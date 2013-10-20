function time(){
    return Math.floor(STIME+(new Date().getTime()-CTIME)/1000);
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
        return BASEURL+"/"+file+"?v="+arr;
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
            url+="?";
            for(var k in param){
                url+=encodeURIComponent(k)+"="+encodeURIComponent(param[k])+"&";
            }
        }
        return url;
    }
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