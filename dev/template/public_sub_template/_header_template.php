<div class="mheader">
    <div class="user">
        {{#user}}
        <span>{{username}}</span>
        <span><a href="#" class="js_logout">退出</a></span>
        {{/user}}
        {{^user}}
        <span><a href="{{loginUrl}}" class="js_login">登录</a></span>
        <span><a href="{{registerUrl}}" class="js_register">注册</a></span>
        {{/user}}
    </div>
    <div class="clearfix">
        <div class="mlogo fl"></div>
        <div class="msearch fr">
            <form action="{{searchUrl}}" method="get">
                <input class="content" name="search" type="text"/>
                <input class="button" type="submit" value="搜索"/>
            </form>
        </div>
    </div>
    <div class="mnav clearfix">
        {{#navList}}
        <div class="fl mr5"><a href="{{url}}">{{name}}</a></div>
        {{/navList}}
    </div>
    <div class="mpos clearfix mt10">
        <p class="fl">当前位置：</p>
        {{#stageList}}
        <div class="fl mr5">
            {{^first}}
            &gt;
            {{/first}}
            <a {{#url}}href="{{url}}"{{/url}}>{{name}}</a>
        </div>
        {{/stageList}}
    </div>
</div>