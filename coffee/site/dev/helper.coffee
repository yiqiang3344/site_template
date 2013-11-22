window.showFooter = (links)->
    links ||= []
    params = {
        list : []
    }
    sublist = []
    for v,k in links
        sublist.push({
            name:links[k].name
            user:getUrl('Contack','Index',{urlName:links[k].urlName})
        })
        if k==links.length-1 or (k!=0 and (k+1)%5==0)
            params.list.push(sublist)
            sublist = []
    $('#maindiv').append(footerTemplate.render(params))

window.showHeader = (user,links)->
    user ||= null
    links ||= []
    params = {
        user:user?
        username:if user then user.username else false
        list:[
            {
                name:'首页'
                url:getUrl('Main','Index')
            }
        ]
    }
    for v,i in links
        params.list.push({
            name:links[i].name
            url:links[i].url
        });
        
    html = headerTemplate.render(params)
    $('#maindiv').prepend(html)
    State.setDic({
            'main/index':'首页'
        });
    State.setDefaultPosition('main/index',{})
    $('.js_pos').html(State.getPositionHtml())

    # 绑定事件
    # 登出
    $('.js_logout').click(->
        oneAjax('Main','logout',{},(obj)->
            if obj.code==1
                State.back(0)
        ,this)
        false
    )

    # 登录
    $('.js_login').click(->
        showLoginPop()
        false
    )

    # 注册
    $('.js_register').click(->
        showRegisterPop()
        false
    );

window.showRegisterPop = ->
    html = """
        <div class="user_info">
            <form class="js_registerForm">
                <div>注册</div>
                <div>用户名：<input type="text" name="username"/></div>
                <div>密码：<input type="password" name="password"/></div>
                <div>确认密码：<input type="password" name="passwordConfirm"/></div>
    """
    if UD.login_error_time>=UD.max_login_error_time
        html = """#{html}
                    <div>验证码：<input type="text" name="verifyCode"/>
                        <img class="js_verifyImg" alt="点击换图" title="点击换图" style="cursor:pointer" src="'+getUrl(CONTROLLER,'captcha')+'/v/'+Math.random()+'">
                    </div>
        """
    html = """#{html}
                  <div>记住我：<input type="checkbox" name="remember" value="1"/></div>
                <div><input type="submit" name="submit" value="提交"/></div>
            </form>
        </div>
    """
    $('#maindiv').prepend(html)


    $('.js_verifyImg').click(->
        $.ajax({
            url: getUrl(CONTROLLER,'captcha',{refresh:1})
            dataType: 'json'
            cache: false
            success: (data)->
                $('.js_verifyImg').attr('src', data['url'])
                $('body').data('captcha.hash', [data['hash1'], data['hash2']])
                false
        })
        false
    )

    $('.js_registerForm').find('[name="submit"]').click(->
        $('.js_registerForm').find('.merror').removeClass('merror');
        oneAjax(CONTROLLER,'register',$('.js_registerForm').serialize(),(obj)->
            if obj.code==1
                State.back(0)
            else if obj.code==2
                $.each(obj.errors,(k,v)->
                    $('.js_registerForm').find('[name='+k+']').addClass('merror')
                )
            false
        ,this)
        false
    )

window.showLoginPop = ->
    html = """
        <div class="user_info">
            <form class="js_loginForm">
                <div>登陆</div>
                <div>用户名：<input type="text" name="username"/></div>
                <div>密码：<input type="password" name="password"/></div>
    """
    if UD.ogin_error_time>=UD.max_login_error_time
        html = """#{html}
                <div>验证码：<input type="text" name="verifyCode"/>
                    <img class="js_verifyImg" alt="点击换图" title="点击换图" style="cursor:pointer" src="'+getUrl(CONTROLLER,'captcha')+'/v/'+Math.random()+'">
                </div>
        """
    html = """#{html}
                <div>记住我：<input type="checkbox" name="remember" value="1"/></div>
                <div><input type="submit" name="submit" value="提交"/></div>
            </form>
        </div>
    """
    $('#maindiv').prepend(html);

    $('.js_verifyImg').click(->
        $.ajax({
            url: getUrl(CONTROLLER,'captcha',{refresh:1})
            dataType: 'json'
            cache: false
            success: (data)->
                $('.js_verifyImg').attr('src', data['url'])
                $('body').data('captcha.hash', [data['hash1'], data['hash2']])
        })
        false
    )

    $('.js_loginForm').find('[name="submit"]').click(->
        $('.js_loginForm').find('.merror').removeClass('merror')
        oneAjax(CONTROLLER,'login',$('.js_loginForm').serialize(),(obj)->
            if obj.code==1
                State.back(0)
            else if obj.code==2
                $.each(obj.errors,(k,v)->
                    $('.js_loginForm').find('[name='+k+']').addClass('merror');
                )
            false
        ,this)
        false
    )
