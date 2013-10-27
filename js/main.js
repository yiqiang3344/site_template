/**
* Pager
* @param {object} dom : jquery selector,where to insert html
* @param {string} c : controller
* @param {string} a : action
* @param {object} params : params
* @param {object} pager : {item_count: count, page : page, page_count : page_count, data : data, page_size : page_size } 
* @param [option] {object} ajax : {className:'this pager class name',c:'controller', a:'action', params:'params', callback:function(){} } 
*/
function Pager(dom,c,a,params,pager,ajax){
    if(pager.page_count==1){
        return '';
    }
    ajax = ajax || false;

    var className = ajax?('pager_'+ajax.className):false;

    var last = false;
    if(pager.page>1){
        params.p = pager.page-1;
        last = {
            id : ajax ? (className+params.p) : false,
            href : getUrl(c,a,params)
        };
    }
    var next = false;
    if(pager.page<pager.page_count){
        params.p = pager.page+1;
        next = {
            id : ajax ? (className+params.p) : false,
            href : getUrl(c,a,params)
        };
    }
    var p = {
        className : className,
        last : last,
        next : next,
        list : []
    };

    //show 5 links,other is ellipsis
    var link_count = pager.page_count-pager.page;
    if(link_count<=5){
        for(var i=pager.page+1;i<=pager.page_count;i++){
            params.p = i;
            var link = {
                ellipsis : false,
                id : ajax ? (className+i) : false,
                href : getUrl(c,a,params),
                name : i
            };
            p.list.push(link);
        }
    }else{
        var c1 = pager.page+3,
            c2 = pager.page_count-1,
            link;
        for(var i=pager.page+1;i<=pager.page_count;i++){
            link = {
                ellipsis : true,
            };
            if(i<=c1 || i>=c2){
                params.p = i;
                link = {
                    ellipsis : false,
                    id : ajax ? (className+i) : false,
                    href : getUrl(c,a,params),
                    name : i
                };
            }
            p.list.push(link);
        }
    }
    dom.html(pagerTemplate.render(p));

    if(ajax){
        dom.find('[id^="'+className+'"]').click(function(){
            var p = this.id.replace(className,'');
            ajax.params.p = p;
            yajax(ajax.c,ajax.a,ajax.params,ajax.callback,this);
            return false;
        });
    }
}

/**
 * operate Cookie
 * @param {string} uniqueN 
 */
var YCache = function(uniqueN){
    var uniqueN = (typeof(uniqueN) != "string") ? "" : "uniqueN_" + uniqueN + "_";
    setCookie = function(name, value){
        var Days = 1;
        var exp = new Date();
        exp.setTime(exp.getTime() + Days * 24 * 60 * 60 * 1000);
        document.cookie = name + "=" + escape(this.encode(value)) + ";expires=" + exp.toGMTString();
    }
    getCookie = function(name){
        var arr = document.cookie.match(new RegExp("(^| )" + name + "=([^;]*)(;|$)"));
        if (arr != null)
            return this.unencode(unescape(arr[2]));
        return null;
    }
    delCookie = function(name){
        var exp = new Date();
        exp.setTime(exp.getTime() - 1);
        var tem = this.getCookie(name);
        if (tem != null)
            document.cookie = "name=" + tem + ";expires=" + exp.toGMTString();
    }
    encode = function(str){
        var temstr = "";
        var i = str.length - 1;
        for (i; i >= 0; i--) {
            temstr += str.charCodeAt(i);
            if (i)
                temstr += "a";
        }
        return temstr;
    }
    unencode = function(str){
        var strarr = "";
        var temstr = "";
        strarr = str.split("a");
        var i = strarr.length - 1;
        for (i; i >= 0; i--) {
            temstr += String.fromCharCode(eval(strarr[i]));
        }
        return temstr;
    }
    return {
        set: function(text){
          setCookie(uniqueN, text);
        },
        clear: function(){
          delCookie(uniqueN);
        },
        get: function(){
          return getCookie(uniqueN);
        }
    }
}

var State = {};
(function(State){
    var history = [],
        //list of url : name
        Dic = {},
        Cache = YCache('siteHistory');
    State.setDic = function(p){
        if(typeof p != 'object'){
            return false;
        }
        for(var k in p){
            Dic[k]=p[k];
        }
    }
    State.setDefaultPosition = function(url,params){
        loadFromCookie();
        if(history.length==0){
            history.push({url:url,params:params});
            saveToCookie();
        }
    }
    //forward and record
    State.forward = function(url,params){
        history.push({url:url,params:params});
        saveToCookie();
        State.gotoUrl(url,params);
    }
    //forward no record
    State.forwardNoback = function(url,params){
        State.gotoUrl(url,params);
    }
    //back n=0 refresh,n>0 to max-n,n<0 to-n 
    State.back = function(n){
        if(!n){
            n = history.length-1;
        }else if(n<0){
            n = (-n>history.length?history.length:-n)-1;
        }else{
            n = n>history.length?0:history.length-n;
        }
        var h;
        for(var i=history.length-1;i;i--){
            h = history.pop();
            if(i==n){
                break;
            }
        }
        saveToCookie();
        State.gotoUrl(h.url,h.params);
    }
    State.gotoUrl = function(url,params){
        // location.href=getUrl(url,params);
    }
    State.getPositionHtml = function(){
        var p = {
            default:{},
            list:[]
        };
        for(var i=0;i<history.length;i++){
            if(i==0){
                p.default = {
                    url:getUrl(history[i].url,history[i].params),
                    name:Dic[history[i].url]
                };
            }else{
                p.list.push({
                    url:getUrl(history[i].url,history[i].params),
                    name:Dic[history[i].url]
                });
            }
        }
        return sitePositionTemplate.render(p);
    }

    function saveToCookie(){
        var l = [];
        for(var i=0;i<history.length;i++){
            var pl = [];
            for(var j in history[i].params){
                pl.push(j+'**'+history[i].params[j]);
            }
            l.push(history[i].url+'^^'+pl.join('&&'));
        }
        var v = l.join('%%');
        Cache.set(v);
    }

    function loadFromCookie(){
        var c = Cache.get();
        if(!c || c.indexOf('/')==-1){
            return;
        }
        var hl = c.split('%%'),
            h = [];
        for(var i=0;i<hl.length;i++){
            var l = hl[i].split('^^'),
                p = {};
            if(l[1]){
                var pl = l[1].split('&&');
                for(var ii=0;ii<pl.length;ii++){
                    var pp = pl[ii].split('**');
                    p[pp[0]] = pp[1];
                }
            }
            h.push({
                url:l[0],
                params:p,
            });
        }
        history = h;
    }
})(State);

/**
*   get the time of server
*/
function time(){
    return Math.floor(STIME+(new Date().getTime()-CTIME)/1000);
}

/**
*  @param {string} c controller or controller/action
*  @param {string} a or object action
*  @param {object} p params
*/
function getUrl(c,a,p){
    if(a===undefined){
        var pieces=c.split("/");
        var arr=URLCACHE;
        for(var i=0;i<pieces.length;i++){
            if(arr[pieces[i]]){
                arr=arr[pieces[i]];
            }
        }
        return BASEURL+"/"+c+"?v="+arr;
    }else {
        var url,param;
        if(typeof(a)=="string"){
            url=BASEURI+"/"+c+"/"+a;
            param=p;
        }else{
            url=BASEURI+"/"+c;
            param=a;
        }
        if(param){
            var l = [];
            for(var k in param){
                l.push(encodeURIComponent(k)+"="+encodeURIComponent(param[k]));
            }
            l.length>0 && (url+='?'+l.join('&'));
        }
        return url;
    }
}

/**
* @param {time} time
* @param {number} flag 1 Y-d-m, 2 Y-d-m h:i:s
*/
function dateFormat(time,flag){
    var date = new Date(time*1000);
    var ret = '';
    if(!flag || flag==1){
        ret += date.getFullYear();
        ret += '-';
        ret += date.getMonth()+1;
        ret += '-';
        ret += date.getDate();
    }else if(flag==2){
        ret += date.getFullYear();
        ret += '-';
        ret += date.getMonth()+1;
        ret += '-';
        ret += date.getDate();
        ret += ' ';
        ret += date.getHours();
        ret += ':';
        ret += date.getMinutes();
        ret += ':';
        ret += date.getSeconds();
    }
    return ret;
}

function yajax(c,a,data,succ_callback,dom){
    if(dom){
        var k_disable=0;
        $(dom).each(function(){
            if($(this).data("k_disable")){
                k_disable=1;
            }
        });
        if(k_disable){
            return;
        }else{
            $(dom).data("k_disable",1);
        }
    }

    function show_error(error){
        alert(error?error:'data load error!');
    }

    var succ=function(obj){
        dom && $(dom).data("k_disable",0);
        if(obj==null || typeof(obj)!="object" || !obj.code || obj.code==-1){
            show_error(1);
        }else{
            succ_callback(obj);
        }
    }
    var fail=function(jqXHR, textStatus, errorThrown){
        dom && $(dom).data("k_disable",0);
        if (jqXHR.status == 0 && textStatus=="error") {
            show_error();
        } else if(textStatus=="parsererror"){
            show_error();
        }else if(textStatus=="servererror"){
            show_error();
        }else{
            show_error();
        }
    };
    setTimeout(function(){
        $.ajax({
            url:getUrl(c,a),
            data:data,
            dataType:"json",
            type: "POST",
            success:succ,
            error:fail
        });
    },0);
}

/*
 *  Copyright 2011 Twitter, Inc.
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 */
var Hogan = {};
(function (Hogan, useArrayBuffer) {
  Hogan.Template = function (renderFunc, text, compiler, options) {
    this.r = renderFunc || this.r;
    this.c = compiler;
    this.options = options;
    this.text = text || '';
    this.buf = (useArrayBuffer) ? [] : '';
  }

  Hogan.Template.prototype = {
    // render: replaced by generated code.
    r: function (context, partials, indent) { return ''; },

    // variable escaping
    v: hoganEscape,

    // triple stache
    t: coerceToString,

    render: function render(context, partials, indent) {
      return this.ri([context], partials || {}, indent);
    },

    // render internal -- a hook for overrides that catches partials too
    ri: function (context, partials, indent) {
      return this.r(context, partials, indent);
    },

    // tries to find a partial in the curent scope and render it
    rp: function(name, context, partials, indent) {
      var partial = partials[name];

      if (!partial) {
        return '';
      }

      if (this.c && typeof partial == 'string') {
        partial = this.c.compile(partial, this.options);
      }

      return partial.ri(context, partials, indent);
    },

    // render a section
    rs: function(context, partials, section) {
      var tail = context[context.length - 1];

      if (!isArray(tail)) {
        section(context, partials, this);
        return;
      }

      for (var i = 0; i < tail.length; i++) {
        context.push(tail[i]);
        section(context, partials, this);
        context.pop();
      }
    },

    // maybe start a section
    s: function(val, ctx, partials, inverted, start, end, tags) {
      var pass;

      if (isArray(val) && val.length === 0) {
        return false;
      }

      if (typeof val == 'function') {
        val = this.ls(val, ctx, partials, inverted, start, end, tags);
      }

      pass = (val === '') || !!val;

      if (!inverted && pass && ctx) {
        ctx.push((typeof val == 'object') ? val : ctx[ctx.length - 1]);
      }

      return pass;
    },

    // find values with dotted names
    d: function(key, ctx, partials, returnFound) {
      var names = key.split('.'),
          val = this.f(names[0], ctx, partials, returnFound),
          cx = null;

      if (key === '.' && isArray(ctx[ctx.length - 2])) {
        return ctx[ctx.length - 1];
      }

      for (var i = 1; i < names.length; i++) {
        if (val && typeof val == 'object' && names[i] in val) {
          cx = val;
          val = val[names[i]];
        } else {
          val = '';
        }
      }

      if (returnFound && !val) {
        return false;
      }

      if (!returnFound && typeof val == 'function') {
        ctx.push(cx);
        val = this.lv(val, ctx, partials);
        ctx.pop();
      }

      return val;
    },

    // find values with normal names
    f: function(key, ctx, partials, returnFound) {
      var val = false,
          v = null,
          found = false;

      for (var i = ctx.length - 1; i >= 0; i--) {
        v = ctx[i];
        if (v && typeof v == 'object' && key in v) {
          val = v[key];
          found = true;
          break;
        }
      }

      if (!found) {
        return (returnFound) ? false : "";
      }

      if (!returnFound && typeof val == 'function') {
        val = this.lv(val, ctx, partials);
      }

      return val;
    },

    // higher order templates
    ho: function(val, cx, partials, text, tags) {
      var compiler = this.c;
      var options = this.options;
      options.delimiters = tags;
      var text = val.call(cx, text);
      text = (text == null) ? String(text) : text.toString();
      this.b(compiler.compile(text, options).render(cx, partials));
      return false;
    },

    // template result buffering
    b: (useArrayBuffer) ? function(s) { this.buf.push(s); } :
                          function(s) { this.buf += s; },
    fl: (useArrayBuffer) ? function() { var r = this.buf.join(''); this.buf = []; return r; } :
                           function() { var r = this.buf; this.buf = ''; return r; },

    // lambda replace section
    ls: function(val, ctx, partials, inverted, start, end, tags) {
      var cx = ctx[ctx.length - 1],
          t = null;

      if (!inverted && this.c && val.length > 0) {
        return this.ho(val, cx, partials, this.text.substring(start, end), tags);
      }

      t = val.call(cx);

      if (typeof t == 'function') {
        if (inverted) {
          return true;
        } else if (this.c) {
          return this.ho(t, cx, partials, this.text.substring(start, end), tags);
        }
      }

      return t;
    },

    // lambda replace variable
    lv: function(val, ctx, partials) {
      var cx = ctx[ctx.length - 1];
      var result = val.call(cx);

      if (typeof result == 'function') {
        result = coerceToString(result.call(cx));
        if (this.c && ~result.indexOf("{\u007B")) {
          return this.c.compile(result, this.options).render(cx, partials);
        }
      }

      return coerceToString(result);
    }

  };

  var rAmp = /&/g,
      rLt = /</g,
      rGt = />/g,
      rApos =/\'/g,
      rQuot = /\"/g,
      hChars =/[&<>\"\']/;


  function coerceToString(val) {
    return String((val === null || val === undefined) ? '' : val);
  }

  function hoganEscape(str) {
    str = coerceToString(str);
    return hChars.test(str) ?
      str
        .replace(rAmp,'&amp;')
        .replace(rLt,'&lt;')
        .replace(rGt,'&gt;')
        .replace(rApos,'&#39;')
        .replace(rQuot, '&quot;') :
      str;
  }

  var isArray = Array.isArray || function(a) {
    return Object.prototype.toString.call(a) === '[object Array]';
  };

})(typeof exports !== 'undefined' ? exports : Hogan);

(function (Hogan) {
  // Setup regex  assignments
  // remove whitespace according to Mustache spec
  var rIsWhitespace = /\S/,
      rQuot = /\"/g,
      rNewline =  /\n/g,
      rCr = /\r/g,
      rSlash = /\\/g,
      tagTypes = {
        '#': 1, '^': 2, '/': 3,  '!': 4, '>': 5,
        '<': 6, '=': 7, '_v': 8, '{': 9, '&': 10
      };

  Hogan.scan = function scan(text, delimiters) {
    var len = text.length,
        IN_TEXT = 0,
        IN_TAG_TYPE = 1,
        IN_TAG = 2,
        state = IN_TEXT,
        tagType = null,
        tag = null,
        buf = '',
        tokens = [],
        seenTag = false,
        i = 0,
        lineStart = 0,
        otag = '{{',
        ctag = '}}';

    function addBuf() {
      if (buf.length > 0) {
        tokens.push(new String(buf));
        buf = '';
      }
    }

    function lineIsWhitespace() {
      var isAllWhitespace = true;
      for (var j = lineStart; j < tokens.length; j++) {
        isAllWhitespace =
          (tokens[j].tag && tagTypes[tokens[j].tag] < tagTypes['_v']) ||
          (!tokens[j].tag && tokens[j].match(rIsWhitespace) === null);
        if (!isAllWhitespace) {
          return false;
        }
      }

      return isAllWhitespace;
    }

    function filterLine(haveSeenTag, noNewLine) {
      addBuf();

      if (haveSeenTag && lineIsWhitespace()) {
        for (var j = lineStart, next; j < tokens.length; j++) {
          if (!tokens[j].tag) {
            if ((next = tokens[j+1]) && next.tag == '>') {
              // set indent to token value
              next.indent = tokens[j].toString()
            }
            tokens.splice(j, 1);
          }
        }
      } else if (!noNewLine) {
        tokens.push({tag:'\n'});
      }

      seenTag = false;
      lineStart = tokens.length;
    }

    function changeDelimiters(text, index) {
      var close = '=' + ctag,
          closeIndex = text.indexOf(close, index),
          delimiters = trim(
            text.substring(text.indexOf('=', index) + 1, closeIndex)
          ).split(' ');

      otag = delimiters[0];
      ctag = delimiters[1];

      return closeIndex + close.length - 1;
    }

    if (delimiters) {
      delimiters = delimiters.split(' ');
      otag = delimiters[0];
      ctag = delimiters[1];
    }

    for (i = 0; i < len; i++) {
      if (state == IN_TEXT) {
        if (tagChange(otag, text, i)) {
          --i;
          addBuf();
          state = IN_TAG_TYPE;
        } else {
          if (text.charAt(i) == '\n') {
            filterLine(seenTag);
          } else {
            buf += text.charAt(i);
          }
        }
      } else if (state == IN_TAG_TYPE) {
        i += otag.length - 1;
        tag = tagTypes[text.charAt(i + 1)];
        tagType = tag ? text.charAt(i + 1) : '_v';
        if (tagType == '=') {
          i = changeDelimiters(text, i);
          state = IN_TEXT;
        } else {
          if (tag) {
            i++;
          }
          state = IN_TAG;
        }
        seenTag = i;
      } else {
        if (tagChange(ctag, text, i)) {
          tokens.push({tag: tagType, n: trim(buf), otag: otag, ctag: ctag,
                       i: (tagType == '/') ? seenTag - ctag.length : i + otag.length});
          buf = '';
          i += ctag.length - 1;
          state = IN_TEXT;
          if (tagType == '{') {
            if (ctag == '}}') {
              i++;
            } else {
              cleanTripleStache(tokens[tokens.length - 1]);
            }
          }
        } else {
          buf += text.charAt(i);
        }
      }
    }

    filterLine(seenTag, true);

    return tokens;
  }

  function cleanTripleStache(token) {
    if (token.n.substr(token.n.length - 1) === '}') {
      token.n = token.n.substring(0, token.n.length - 1);
    }
  }

  function trim(s) {
    if (s.trim) {
      return s.trim();
    }

    return s.replace(/^\s*|\s*$/g, '');
  }

  function tagChange(tag, text, index) {
    if (text.charAt(index) != tag.charAt(0)) {
      return false;
    }

    for (var i = 1, l = tag.length; i < l; i++) {
      if (text.charAt(index + i) != tag.charAt(i)) {
        return false;
      }
    }

    return true;
  }

  function buildTree(tokens, kind, stack, customTags) {
    var instructions = [],
        opener = null,
        token = null;

    while (tokens.length > 0) {
      token = tokens.shift();
      if (token.tag == '#' || token.tag == '^' || isOpener(token, customTags)) {
        stack.push(token);
        token.nodes = buildTree(tokens, token.tag, stack, customTags);
        instructions.push(token);
      } else if (token.tag == '/') {
        if (stack.length === 0) {
          throw new Error('Closing tag without opener: /' + token.n);
        }
        opener = stack.pop();
        if (token.n != opener.n && !isCloser(token.n, opener.n, customTags)) {
          throw new Error('Nesting error: ' + opener.n + ' vs. ' + token.n);
        }
        opener.end = token.i;
        return instructions;
      } else {
        instructions.push(token);
      }
    }

    if (stack.length > 0) {
      throw new Error('missing closing tag: ' + stack.pop().n);
    }

    return instructions;
  }

  function isOpener(token, tags) {
    for (var i = 0, l = tags.length; i < l; i++) {
      if (tags[i].o == token.n) {
        token.tag = '#';
        return true;
      }
    }
  }

  function isCloser(close, open, tags) {
    for (var i = 0, l = tags.length; i < l; i++) {
      if (tags[i].c == close && tags[i].o == open) {
        return true;
      }
    }
  }

  Hogan.generate = function (tree, text, options) {
    var code = 'var _=this;_.b(i=i||"");' + walk(tree) + 'return _.fl();';
    if (options.asString) {
      return 'function(c,p,i){' + code + ';}';
    }

    return new Hogan.Template(new Function('c', 'p', 'i', code), text, Hogan, options);
  }

  function esc(s) {
    return s.replace(rSlash, '\\\\')
            .replace(rQuot, '\\\"')
            .replace(rNewline, '\\n')
            .replace(rCr, '\\r');
  }

  function chooseMethod(s) {
    return (~s.indexOf('.')) ? 'd' : 'f';
  }

  function walk(tree) {
    var code = '';
    for (var i = 0, l = tree.length; i < l; i++) {
      var tag = tree[i].tag;
      if (tag == '#') {
        code += section(tree[i].nodes, tree[i].n, chooseMethod(tree[i].n),
                        tree[i].i, tree[i].end, tree[i].otag + " " + tree[i].ctag);
      } else if (tag == '^') {
        code += invertedSection(tree[i].nodes, tree[i].n,
                                chooseMethod(tree[i].n));
      } else if (tag == '<' || tag == '>') {
        code += partial(tree[i]);
      } else if (tag == '{' || tag == '&') {
        code += tripleStache(tree[i].n, chooseMethod(tree[i].n));
      } else if (tag == '\n') {
        code += text('"\\n"' + (tree.length-1 == i ? '' : ' + i'));
      } else if (tag == '_v') {
        code += variable(tree[i].n, chooseMethod(tree[i].n));
      } else if (tag === undefined) {
        code += text('"' + esc(tree[i]) + '"');
      }
    }
    return code;
  }

  function section(nodes, id, method, start, end, tags) {
    return 'if(_.s(_.' + method + '("' + esc(id) + '",c,p,1),' +
           'c,p,0,' + start + ',' + end + ',"' + tags + '")){' +
           '_.rs(c,p,' +
           'function(c,p,_){' +
           walk(nodes) +
           '});c.pop();}';
  }

  function invertedSection(nodes, id, method) {
    return 'if(!_.s(_.' + method + '("' + esc(id) + '",c,p,1),c,p,1,0,0,"")){' +
           walk(nodes) +
           '};';
  }

  function partial(tok) {
    return '_.b(_.rp("' +  esc(tok.n) + '",c,p,"' + (tok.indent || '') + '"));';
  }

  function tripleStache(id, method) {
    return '_.b(_.t(_.' + method + '("' + esc(id) + '",c,p,0)));';
  }

  function variable(id, method) {
    return '_.b(_.v(_.' + method + '("' + esc(id) + '",c,p,0)));';
  }

  function text(id) {
    return '_.b(' + id + ');';
  }

  Hogan.parse = function(tokens, text, options) {
    options = options || {};
    return buildTree(tokens, '', [], options.sectionTags || []);
  },

  Hogan.cache = {};

  Hogan.compile = function(text, options) {
    // options
    //
    // asString: false (default)
    //
    // sectionTags: [{o: '_foo', c: 'foo'}]
    // An array of object with o and c fields that indicate names for custom
    // section tags. The example above allows parsing of {{_foo}}{{/foo}}.
    //
    // delimiters: A string that overrides the default delimiters.
    // Example: "<% %>"
    //
    options = options || {};

    var key = text + '||' + !!options.asString;

    var t = this.cache[key];

    if (t) {
      return t;
    }

    t = this.generate(this.parse(this.scan(text, options.delimiters), text, options), text, options);
    return this.cache[key] = t;
  };
})(typeof exports !== 'undefined' ? exports : Hogan);