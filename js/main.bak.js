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


