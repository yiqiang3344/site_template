<div class="mheader">
    <div class="user">
        {{#user}}
        <span>{{username}}</span>
        <span><a href="" class="js_logout">退出</a></span>
        {{/user}}
        {{^user}}
        <span><a href="" class="js_login">登录</a></span>
        <span><a href="" class="js_register">注册</a></span>
        {{/user}}
    </div>
    <div class="clearfix">
        <div class="mlogo fl"></div>
        <div class="msearch fr">
            <input class="js_search" type="text"/>
        </div>
    </div>
    <div class="mnav clearfix">
        {{#list}}
        <div class="fl"><a href="{{url}}">{{name}}</a></div>
        {{/list}}
    </div>
    <div class="mpos js_pos"></div>
</div>