<div class="mheader">
    <div class="muser">
        {{#user}}
        欢迎您，<span>{{username}}</span> &nbsp;&nbsp; <span><a href="#" class="js_logout">退出</a></span>
        {{/user}}
        {{^user}}
        <span><a href="{{loginUrl}}" class="js_login">登录</a></span>
        <span><a href="{{registerUrl}}" class="js_register">注册</a></span>
        {{/user}}
    </div>
    <div class="mlogo_search clearfix">
        <div class="mlogo fl"><img class="mlogo__img" src="{{logo}}" alt="logo"></div>
        <div class="msearch fr">
            <form action="{{searchUrl}}" method="get">
                <div class="msearch__content_box">
                    <input class="msearch__content" name="search" type="text"/>
                </div>
                <input class="msearch__button" type="submit" value=""/>
            </form>
        </div>
    </div>
    <div class="mnav clearfix">
        <div class="mnav__main">
            {{#navList}}
            <div class="mnav__link fl"><a class="mnav__a" href="{{url}}">{{name}}</a></div>
            {{/navList}}
        </div>
    </div>
    <div class="mpos clearfix">
        <p class="fl">当前位置：</p>
        {{#stageList}}
        <div class="fl mr5">
            {{^first}}
            &gt;
            {{/first}}
            <a class="mpos__a" {{#url}}href="{{url}}"{{/url}}>{{name}}</a>
        </div>
        {{/stageList}}
    </div>
</div>