$(function(){
  $('.js_cbox_all').click(function(e){
      var a = $(this).parents('ul').find('.js_cbox,.js_cbox_all');
      if($(this).filter(':checked').length){
          $.each(a,function(){
              this.checked = true;
          })
      }else{
          $.each(a,function(){
              this.checked = false;
          })
      }
  });
});

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

    var b2 = pager.page-2,
        a2 = pager.page+2,
        link,
        has_ellipsis = false;
    for(var i=1;i<=pager.page_count;i++){
        //alway show first and last page; 
        //when show first or last not show last or next; 
        //show tow page before or after now page.
        if((i>=b2 && i<=a2) || i==1 || i==pager.page_count){
            params.p = i;
            link = {
                ellipsis : false,
                id : ajax ? (className+i) : false,
                href : getUrl(c,a,params),
                name : i,
                select : i==pager.page
            };
        }else{
            link = has_ellipsis ? false : {ellipsis : true};
            has_ellipsis = true;
        }
        link && p.list.push(link);
    }
    dom.html(pagerTemplate.render(p));

    if(ajax){
        dom.find('[id^="'+className+'"]').click(function(){
            var p = this.id.replace(className,'');
            ajax.params.p = p;
            oneAjax(ajax.c,ajax.a,ajax.params,ajax.callback,this);
            return false;
        });
    }
}

function uploader(input, options) {
    var $this = this;

    // Default settings (mostly debug functions)
    this.settings = {
            prefix:'file',
            multiple:false,
            autoUpload:false,
            url:window.location.href,
            onprogress:function(ev){ console.log('onprogress'); console.log(ev); },
            error:function(msg){ console.log('error'); console.log(msg); },
            success:function(data){ console.log('success'); console.log(data); }
    };
    $.extend(this.settings, options);

    this.input = input;
    this.xhr = new XMLHttpRequest();

    this.send = function(){
            // Make sure there is at least one file selected
            if($this.input.files.length < 1) {
                    if($this.settings.error) $this.settings.error('Must select a file to upload');
                    return false;
            }
            // Don't allow multiple file uploads if not specified
            if($this.settings.multiple === false && $this.input.files.length > 1) {
                    if($this.settings.error) $this.settings.error('Can only upload one file at a time');
                    return false;
            }
            // Must determine whether to send one or all of the selected files
            if($this.settings.multiple) {
                    $this.multiSend($this.input.files);
            }
            else {
                    $this.singleSend($this.input.files[0]);
            }
    };

    // Prep a single file for upload
    this.singleSend = function(file){
            var data = new FormData();
            data.append(String($this.settings.prefix),file);
            $this.upload(data);
    };

    // Prepare all of the input files for upload
    this.multiSend = function(files){
            var data = new FormData();
            for(var i = 0; i < files.length; i++) data.append(String($this.settings.prefix)+String(i), files[i]);
            $this.upload(data);
    };

    // The actual upload calls
    this.upload = function(data){
            $this.xhr.open('POST',$this.settings.url, true);
            $this.xhr.send(data);
    };

    // Modify options after instantiation
    this.setOpt = function(opt, val){
            $this.settings[opt] = val;
            return $this;
    };
    this.getOpt = function(opt){
            return $this.settings[opt];
    };

    // Set the input element after instantiation
    this.setInput = function(elem){
            $this.input = elem;
            return $this;
    };
    this.getInput = function(){
            return $this.input;
    };

    // Basic setup for the XHR stuff
    if(this.settings.onprogress) this.xhr.upload.addEventListener('progress',this.settings.onprogress,false);
    this.xhr.onreadystatechange = function(ev){
            if($this.xhr.readyState == 4) {
                    console.log('done!');
                    if($this.xhr.status == 200) {
                            if($this.settings.success) $this.settings.success(JSON.parse($this.xhr.responseText),ev);
                            $this.input.value = '';
                    }
                    else {
                            if($this.settings.error) $this.settings.error(ev);
                    }
            }
    };

    // onChange event for autoUploads
    if(this.settings.autoUpload) this.input.onchange = this.send;
}

var State = {};
(function(){
    State.forward = function(c,a,p){
        document.location.href=getUrl(c,a,p);
    }
    State.replace = function(c,a,p){
        document.location.replace(getUrl(c,a,p));
    }
    State.back = function(n){
        n = n || 0;
        history.go(-n);
    }
})();


function time(){
    return Math.floor((new Date().getTime()-CTIME)/1000+STIME);
}


function getUrl(c,a,p){
    if(a===undefined){
        var file;
        if(c.substr(0,3)=="js/" || c.substr(0,9)=="template/"){
            file=LANG+"/"+c;
        }else{
            file=c;
        }
        var pieces=c.split("/");
        var arr=URLCACHE;
        for(var i=0;i<pieces.length;i++){
            if(arr[pieces[i]]){
                arr=arr[pieces[i]];
            }
        }
        return STATIC_BASE_URL+"/"+file+"?v="+arr;
    }else {
        var url,param;
        if(typeof(a)=="string"){
            url=CODE_BASE_URL+"/"+c+"/"+a;
            param=p;
        }else{
            url=CODE_BASE_URL+"/"+c;
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

(function(){
    $.fn.onClick=function(selector,data,handler){
        var s,d,h;
        $.each(arguments,function(k,v){
            if(typeof v == 'string'){
                s = v;
            }else if(typeof v == 'object'){
                d = v;
            }else if(typeof v == 'function'){
                h = v;
            }
        });
        return onClick(this,s,d,h);
    }
    $.fn.offClick=function(selector,handler){
        var s,h;
        $.each(arguments,function(k,v){
            if(typeof v == 'string'){
                s = v;
            }else if(typeof v == 'function'){
                h = v;
            }
        });
        return offClick(this,s,h);
    }
    $.fn.bindClick=function(handler){
        dealClick(this,null,handler);
        return $(this).click(function(){return false;});
    }

    var addHover = function(){
        $(this).addClass('hover');
    }

    offClick = function(dom,selector,handler){
        return $(dom).off('click',selector,addHover).off('click',selector,handler);
    }

    onClick = function(dom,selector,data,handler){
        return $(dom).on('click',selector,data,addHover).on('click',selector,data,handler);
    }

    function dealClick(dom,selector,handler){
        var o = dom;
        if(selector){
            o = $(dom).find(selector);
        }
        $(o).each(function() {
            var p;
            var me = this;
            function onstart(point,e){
                p = true;
                $(me).addClass('hover');
                if(TEST_SERVER_FLAG==1){
                    // var s='<div class="btn_test_area" style="pointer-events:none;z-index:1000;position:absolute;left:'+(pageX(me))+'px;top:'+(pageY(me)-4)+'px;width:'+(me.offsetWidth)+'px;height:'+(me.offsetHeight)+'px;border:2px solid red;"></div>';
                    // $('body').append(s);
                }
            }
            function onmove(point,e){
                if(!p)return;
                p = null;
                $(me).removeClass('hover');
                if(TEST_SERVER_FLAG==1){
                    // $('.btn_test_area').remove();
                }
            }
            function onend(point,e){
                if(!p)return;
                p = null;
                $(me).removeClass('hover');
                if(TEST_SERVER_FLAG==1){
                    // $('.btn_test_area').remove();
                }
                handler && handler.call(me,e);
            }
            var touch_start=function(e){
                if(e.button>0)return;
                onstart({
                    pageX:e.pageX,
                    pageY:e.pageY
                },e);
            }
            var touch_move=function(e){
                onmove({
                    pageX:e.pageX,
                    pageY:e.pageY
                },e);
            }
            var touch_end=function(e){
                onend({
                    pageX:e.pageX,
                    pageY:e.pageY
                },e);
            }
            if(document.body.ontouchstart!==undefined){
                $(me).bind('touchstart',touch_start);
                $(me).bind('touchmove',touch_move);
                $(me).bind('touchend',touch_end);
            }else{
                $(me).bind('mousedown',touch_start);
                $(me).bind('mousemove',touch_move);
                $(me).bind('mouseup',touch_end);
            }
        });
        function pageX(selector){
            return $(selector).offset().left;
        }
        function pageY(selector){
            return $(selector).offset().top;
        }
    }
})();

//send ajax after last one succeeded
function oneAjax(c,a,data,succ_callback,dom){
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
    var succ=function(obj){
        dom && $(dom).data("k_disable",0);
        if(obj==null || typeof(obj)!="object" || !obj.code ){
            fail("","parsererror","");
        }else if(obj.code=="-1"){
            fail("","servererror",obj.msg);
        }else{
            succ_callback(obj);
        }
    }
    var fail=function(jqXHR, textStatus, errorThrown){
        dom && $(dom).data("k_disable",0);
        if (jqXHR.status == 0 && textStatus=="error") {
            alert('yajax error: ' + errorThrown);
        } else if(textStatus=="parsererror"){
            alert('yajax parsererror');
        }else if(textStatus=="servererror"){
            alert('yajax servererror:' + errorThrown);
        }else{
            alert('yajax error: other');
        }
    };
    $.ajax({url:getUrl(c,a),data:data,dataType:"json",type: "POST",success:succ,error:fail});
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