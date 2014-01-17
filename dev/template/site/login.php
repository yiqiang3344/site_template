<div class="user_info">
        <h2>登陆</h2>
    <form class="js_loginForm">
        <div>用户名：<input type="text" name="username"/></div>
        <div>密&nbsp;&nbsp;&nbsp;&nbsp;码：<input type="password" name="password"/></div>
        {{#verifyUrl}}
        <div>验证码：<input type="text" name="verifyCode"/>
            <img class="js_verifyImg cp" alt="点击换图" title="点击换图" src="{{verifyUrl}}">
        </div>
        {{/verifyUrl}}
        <div>记住我：<input type="checkbox" name="remember" value="1"/></div>
        <div><input type="submit" name="submit" value="提交"/></div>
    </form>
</div>
