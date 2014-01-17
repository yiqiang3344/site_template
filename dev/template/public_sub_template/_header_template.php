<div class="head">
    <div class="user">
        {{#user}}
        欢迎您，<span>{{username}}</span> &nbsp;&nbsp; <span><a href="#" class="js_logout">退出</a></span>
        {{/user}}
        {{^user}}
        <a href="{{loginUrl}}" class="js_login">登录</a>
        <a href="{{registerUrl}}" class="js_register">注册</a>
        {{/user}}
    </div>
    <div class="clearfix">
        <a class="logo"></a>
        <form  class="search clearfix" action="{{searchUrl}}" method="get">
            <input name="search" type="text"/>
            <input type="submit" value=""/>
        </form>
    </div>
    <div class="nav clearfix">
        {{#navList}}
        <a href="{{url}}">{{name}}</a>
        {{/navList}}
    </div>
</div>
<div class="mask"></div>
<!-- <div class="modal">
    <h2><a class="close">×</a><span>登录与注册</span></h2>
    <form action="">
        <input type="text" placeholder="请输入账号">
        <input type="text" placeholder="请输入密码">
        <p style="padding-top: 30px"><a class="login">立即登录</a><a class="reg">注册</a></p>
    </form>
</div> -->
<div class="modal">
    <h2><a class="close">×</a><span>登录与注册</span></h2>
    <form action="">
        <input type="text" placeholder="请输入账号">
        <input type="text" placeholder="请输入密码">
        <input type="text" placeholder="确认密码">
        <p style="padding-top: 10px"><a class="login">提交</a><a class="reg">已有账号？登录</a></p>
    </form>
</div>