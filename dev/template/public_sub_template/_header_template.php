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
    <!-- <div class="mpos clearfix">
        <p class="fl">当前位置：</p>
        {{#stageList}}
        <div class="fl mr5">
            {{^first}}
            &gt;
            {{/first}}
            <a class="mpos__a" {{#url}}href="{{url}}"{{/url}}>{{name}}</a>
        </div>
        {{/stageList}}
    </div> -->
</div>