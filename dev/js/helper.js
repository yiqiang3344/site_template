function showFooter(links){
    links = links || [];
    var params = {
            list : []
        },
        sublist = [];
    for(var i=0;i<links.length;i++){
        sublist.push({
            name:links[i].name,
            url:getUrl('Contact','Index',{urlName:links[i].urlName})
        });
        if(i==links.length-1 || (i!==0 && (i+1)%5==0)){
            params.list.push(sublist);
            sublist = [];
        }
    }
    $('#maindiv').append(footerTemplate.render(params));
}

function showHeader(user,links){
    user = user || false;
    links = links || [];
    var params = {
        user:user?true:false,
        username:user?user.username:false,
        list:[
            {
                name:'首页',
                url:getUrl('Main','Index')
            },
        ]
    }
    for(var i=0;i<links.length;i++){
        params.list.push({
            name:links[i].name,
            url:links[i].url
        });
    }
    var html = headerTemplate.render(params);
    $('#maindiv').prepend(html);
    State.setDic({
            'main/index':'首页',
        });
    State.setDefaultPosition('main/index',{});
    $('.js_pos').html(State.getPositionHtml());

    //绑定事件
    //登出
    $('.js_logout').click(function(){
        oneAjax('Main','logout',{},function(obj){
            if(obj.code==1){
                State.back(0);
            }
        },this);
        return false;
    });

    //登录
    $('.js_login').click(function(){
        showLoginPop();
        return false;
    });

    //注册
    $('.js_register').click(function(){
        showRegisterPop();
        return false;
    });
}

function showRegisterPop(){
    var html = '';
    html+='<div class="user_info">';
    html+='    <form class="js_registerForm">';
    html+='        <div>注册</div>';
    html+='        <div>用户名：<input type="text" name="username"/></div>';
    html+='        <div>密码：<input type="password" name="password"/></div>';
    html+='        <div>确认密码：<input type="password" name="passwordConfirm"/></div>';
    if(UD.login_error_time>=UD.max_login_error_time){
        html+='    <div>验证码：<input type="text" name="verifyCode"/>';
        html+='        <img class="js_verifyImg" alt="点击换图" title="点击换图" style="cursor:pointer" src="'+getUrl(CONTROLLER,'captcha')+'/v/'+Math.random()+'">';
        html+='    </div>';
    }
    html+='        <div>记住我：<input type="checkbox" name="remember" value="1"/></div>';
    html+='        <div><input type="submit" name="submit" value="提交"/></div>';
    html+='    </form>';
    html+='</div>';
    $('#maindiv').prepend(html);


    $('.js_verifyImg').click(function(){
        $.ajax({
            url: getUrl(CONTROLLER,'captcha',{refresh:1}),
            dataType: 'json',
            cache: false,
            success: function(data) {
                $('.js_verifyImg').attr('src', data['url']);
                $('body').data('captcha.hash', [data['hash1'], data['hash2']]);
            }
        });
    });

    $('.js_registerForm').find('[name="submit"]').click(function(){
        $('.js_registerForm').find('.merror').removeClass('merror');
        oneAjax(CONTROLLER,'register',$('.js_registerForm').serialize(),function(obj){
            if(obj.code==1){
                State.back(0);
            }else if(obj.code==2){
                $.each(obj.errors,function(k,v){
                    $('.js_registerForm').find('[name='+k+']').addClass('merror');
                });
            }
        },this);
        return false;
    });
}

function showLoginPop(){
    var html = '';
    html+='<div class="user_info">';
    html+='    <form class="js_loginForm">';
    html+='        <div>登陆</div>';
    html+='        <div>用户名：<input type="text" name="username"/></div>';
    html+='        <div>密码：<input type="password" name="password"/></div>';
    if(UD.login_error_time>=UD.max_login_error_time){
        html+='    <div>验证码：<input type="text" name="verifyCode"/>';
        html+='        <img class="js_verifyImg" alt="点击换图" title="点击换图" style="cursor:pointer" src="'+getUrl(CONTROLLER,'captcha')+'/v/'+Math.random()+'">';
        html+='    </div>';
    }
    html+='        <div>记住我：<input type="checkbox" name="remember" value="1"/></div>';
    html+='        <div><input type="submit" name="submit" value="提交"/></div>';
    html+='    </form>';
    html+='</div>';
    $('#maindiv').prepend(html);


    $('.js_verifyImg').click(function(){
        $.ajax({
            url: getUrl(CONTROLLER,'captcha',{refresh:1}),
            dataType: 'json',
            cache: false,
            success: function(data) {
                $('.js_verifyImg').attr('src', data['url']);
                $('body').data('captcha.hash', [data['hash1'], data['hash2']]);
            }
        });
    });

    $('.js_loginForm').find('[name="submit"]').click(function(){
        $('.js_loginForm').find('.merror').removeClass('merror');
        oneAjax(CONTROLLER,'login',$('.js_loginForm').serialize(),function(obj){
            if(obj.code==1){
                State.back(0);
            }else if(obj.code==2){
                $.each(obj.errors,function(k,v){
                    $('.js_loginForm').find('[name='+k+']').addClass('merror');
                });
            }
        },this);
        return false;
    });
}
