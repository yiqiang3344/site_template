<div class="mask js_mask"></div>
{{#isLogin}}
<div class="modal js_login_register_div">
    <h2><a class="close js_login_register_close">×</a><span>登录</span></h2>
    <form class="js_loginForm">
        <input type="text" name="username" placeholder="请输入账号">
        <input class="js_before_verify" type="text" name="password" placeholder="请输入密码">
        {{>verifyTemplate}}
        <div>记住我：<input type="checkbox" name="remember" value="1"/></div>
        <p style="padding-top: 30px"><a class="login js_btn_login">立即登录</a><a class="reg js_btn_to_register">注册</a></p>
    </form>
</div>
{{/isLogin}}
{{#isRegister}}
<div class="modal js_login_register_div">
    <h2><a class="close js_login_register_close">×</a><span>注册</span></h2>
    <form class="js_registerForm">
        <input type="text" name="username" placeholder="请输入账号">
        <input type="text" name="password" placeholder="请输入密码">
        <input class="js_before_verify" type="text" name="passwordConfirm" placeholder="确认密码">
        {{>verifyTemplate}}
        <div>记住我：<input type="checkbox" name="remember" value="1"/></div>
        <p style="padding-top: 10px"><a class="login js_btn_register">提交</a><a class="reg js_btn_to_login">已有账号？登录</a></p>
    </form>
</div>
{{/isRegister}}