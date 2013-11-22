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


window.dateFormat = function(time, flag) {
    var date, ret;
    date = new Date(time * 1000);
    ret = '';
    if (!flag || flag === 1) {
      ret = "" + (date.getFullYear()) + "-" + (date.getMonth() + 1) + "-" + (date.getDate());
    } else if (flag === 2) {
      ret = "" + (date.getFullYear()) + "-" + (date.getMonth() + 1) + "-" + (date.getDate()) + " " + (date.getHours()) + ":" + (date.getMinutes()) + ":" + (date.getSeconds());
    }
    return ret;
};