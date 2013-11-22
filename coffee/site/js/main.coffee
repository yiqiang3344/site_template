
# ###
# Pager
# @param {object} dom : jquery selector,where to insert html
# @param {string} c : controller
# @param {string} a : action
# @param {object} params : params
# @param {object} pager : {item_count: count, page : page, page_count : page_count, data : data, page_size : page_size } 
# @param [option] {object} ajax : {className:'this pager class name',c:'controller', a:'action', params:'params', callback:function(){} } 
# ###
window.Pager = (dom,c,a,params,pager,ajax)->
    if pager.page_count is 1
        return ''
    ajax or= false
    className = if ajax then 'pager_'+ajax.className else false
    last = false
    if pager.page>1
        params.p = pager.page-1
        last = {
            id : if ajax then className+params.p else false
            href : getUrl(c,a,params)
        }
    next = false
    if pager.page<pager.page_count
        params.p = pager.page+1
        next = {
            id : if ajax then className+params.p else false
            href : getUrl(c,a,params)
        }
    p = {
        className : className
        last : last
        next : next
        list : []
    }

    b2 = pager.page-2
    a2 = pager.page+2
    has_ellipsis = false
    for  i in [1..pager.page_count]
        # alway show first and last page; 
        # when show first or last not show last or next; 
        # show tow page before or after now page.
        if (i>=b2 && i<=a2) or i is 1 or i is pager.page_count
            params.p = i
            link = {
                ellipsis : false
                id : if ajax then className+i else false
                href : getUrl(c,a,params)
                name : i
                select : i is pager.page
            }
        else
            link = if has_ellipsis then false else {ellipsis : true}
            has_ellipsis = true
        link and p.list.push(link)

    dom.html(pagerTemplate.render(p))

    if ajax
        dom.find('[id^='+className+']').click(->
            p = this.id.replace(className,'')
            ajax.params.p = p
            oneAjax(ajax.c,ajax.a,ajax.params,ajax.callback,this)
            false
        )

# ###
# operate Cookie
# @param {string} uniqueN 
# ###
window.YCache = (uniqueN)->
    uniqueN = if typeof(uniqueN) isnt "string" then "" else 'uniqueN_'+uniqueN+'_'
    setCookie = (name, value)->
        Days = 1
        exp = new Date()
        exp.setTime(exp.getTime() + Days * 24 * 60 * 60 * 1000)
        document.cookie = "#{name} = #{escape(this.encode(value))} ;expires= #{exp.toGMTString()} "

    getCookie = (name)->
        arr = document.cookie.match(new RegExp("(^| ) #{name} =([^;]*)(;|$)"));
        if arr?
            this.unencode(unescape(arr[2]))
        null

    delCookie = (name)->
        exp = new Date()
        exp.setTime(exp.getTime() - 1)
        tem = this.getCookie(name)
        if tem?
            document.cookie = 'name='+tem+';expires='+exp.toGMTString()

    encode = (str)->
        temstr = ""
        for i in [str.length - 1..0]
            temstr = temstr + str.charCodeAt(i)
            if i
                temstr = temstr+'a'
        temstr

    unencode = (str)->
        strarr = "";
        temstr = "";
        strarr = str.split("a")
        for i in [str.length - 1..0]
            temstr = temstr + String.fromCharCode(eval(strarr[i]))
        temstr;

    {
        set: (text)->
            setCookie(uniqueN, text)
        ,
        clear: ->
            delCookie(uniqueN)
        ,
        get: ->
            getCookie(uniqueN)
    }

class window.State
    history = []
    # list of url : name
    Dic = {}
    Cache = YCache('siteHistory')

    setDic : (p)->
        if typeof p isnt 'object'
            false
        for k in p
            Dic[k]=p[k]
        true

    setDefaultPosition : (url,params)->
        loadFromCookie()
        if history.length is 0
            history.push({url:url,params:params})
            saveToCookie()
        true

    # forward and record
    forward : (url,params)->
        history.push({url:url,params:params})
        saveToCookie()
        window.State.gotoUrl(url,params)
        true

    # forward no record
    forwardNoback : (url,params)->
        window.State.gotoUrl(url,params)
        true

    # back n=0 refresh,n>0 to max-n,n<0 to-n 
    back : (n)->
        n or= 0
        if not n
            h = history[history.length-1]
        else if n<0
            n = (if -n>history.length then history.length else -n)-1
        else
            n = if n>history.length then 0 else history.length-n;
        for i in [history.length-1..1]
            h = history.pop()
            if i is n
                break
        saveToCookie()
        window.State.gotoUrl(h.url,h.params)
        true

    gotoUrl : (url,params)->
        location.href = getUrl(url,params)
        true

    getPositionHtml : ->
        p = {
            default:{}
            list:[]
        }
        for i in [0..history.length]
            if i is 0
                p.default = {
                    url:getUrl(history[i].url,history[i].params)
                    name:Dic[history[i].url]
                }
            else
                p.list.push({
                    url:getUrl(history[i].url,history[i].params)
                    name:Dic[history[i].url]
                })
        sitePositionTemplate.render(p)
        true

    saveToCookie = ->
        l = []
        for i in [0..history.lenght]
            pl = []
            for j in history[i].params
                pl.push(j+'**'+history[i].params[j])
            l.push(history[i].url+'^^'+pl.join('&&'));
        v = l.join('%%')
        Cache.set(v)
        true

    loadFromCookie = ->
        c = Cache.get()
        if not c or c.indexOf('/') is -1
            return false
        hl = c.split('%%')
        h = []
        for i in [0..hl.length]
            l = hl[i].split('^^')
            p = {}
            if l[1]
                pl = l[1].split('&&')
                for i in [0..pl.length]
                    pp = pl[ii].split('**')
                    p[pp[0]] = pp[1]
            h.push({
                url:l[0]
                params:p
            })
        history = h
        true

# ###
# get the time of server
# ###
window.time = ->
    Math.floor(STIME+(new Date().getTime()-CTIME)/1000)

# ###
# @param {string} c controller or controller/action
# @param {string} a or object action
# @param {object} p params
# ###
window.getUrl = (c,a,p)->
    if a is undefined
        pieces = c.split("/")
        arr = URLCACHE
        for i in [0..pieces.length]
            if arr[pieces[i]]
                arr = arr[pieces[i]]
        "#{BASEURL}/#{c}?v=#{arr}"
    else
        if typeof a is "string"
            url = "#{BASEURI}/#{c}/#{a}"
            param = p
        else
            url = "#{BASEURI}/#{c}"
            param = a
        if param
            l = []
            for k in param
                l.push("#{encodeURIComponent(k)}=#{encodeURIComponent(param[k])}")
            l.length>0 ? url = "#{url}?#{l.join('&')}"
        url

# ###
# @param {time} time
# @param {number} flag 1 Y-d-m, 2 Y-d-m h:i:s
# ###
window.dateFormat = (time,flag)->
    date = new Date(time*1000)
    ret = ''
    if not flag or flag is 1
        ret = "#{date.getFullYear()}-#{date.getMonth()+1}-#{date.getDate()}"
    else if flag is 2
        ret = "#{date.getFullYear()}-#{date.getMonth()+1}-#{date.getDate()} #{date.getHours()}:#{date.getMinutes()}:#{date.getSeconds()}"
    ret

# send ajax after last one succeeded
window.oneAjax = (c,a,data,succ_callback,dom)->
    if dom
        k_disable = 0
        $(dom).each(->
            if $(this).data("k_disable")
                k_disable = 1
            true
        )
        if k_disable
            return false
        else
            $(dom).data("k_disable",1)

    succ = (obj)->
        dom and $(dom).data("k_disable",0)
        if obj is null or typeof obj isnt "object" or not obj.code
            fail("","parsererror","")
        else if obj.code is "-1"
            fail("","servererror",obj.msg)
        else
            succ_callback(obj)
        true

    fail = (jqXHR, textStatus, errorThrown)->
        dom and $(dom).data("k_disable",0)
        if jqXHR.status is 0 and textStatus is "error"
            alert("ajax error: #{errorThrown}")
        else if textStatus is "parsererror"
            alert('ajax parsererror');
        else if textStatus is "servererror"
            alert("ajax servererror: #{errorThrown}")
        else
            alert('ajax error: other')
        true
    $.ajax({url:getUrl(c,a),data:data,dataType:"json",type: "POST",success:succ,error:fail})
