<div class="mlines mlines1 clearfix">
    <div class="mlines__title">推荐公司</div>
    {{#companys}}
    <div class="mlines__line fl">
        <div><a href="{{url}}"><img class="mlines__img" src="{{logo}}" alt="logo"></a></div>
        <p class="mlines__name">{{name}}</p>
        <p class="mlines__stars">星级{{star}}</p>
    </div>
    {{/companys}}
</div>

<div class="mlines mlines2 clearfix">
    <div class="mlines__title">精品推荐</div>
    {{#activities}}
    <div class="fl mlines__line">
        <a href="{{url}}"><img class="mlines__img" src="{{img}}" alt="插图"></a>
        <p class="mlines__name">{{title}}</p>
    </div>
    {{/activities}}
</div>

<div class="mlines mlines3 clearfix">
    <div class="mlines__title">推荐资讯</div>
    {{#informations}}
    <div class="pr fl m10">
        <a href="{{url}}"><img class="w400 h200" src="{{img}}" alt="插图"></a>
        <p class="pa b0 w400 ac">{{title}}</p>
    </div>
    {{/informations}}
</div>

<div class="mlines mlines4 clearfix">
    <div class="mlines__title">最近更新</div>
    {{#newCompanys}}
    <div class="mlines__line fl">
        <div class="fl"><a href="{{url}}"><img class="mlines__img" src="{{logo}}" alt="logo"></a></div>
        <p class="fl mlines__name">{{name}}</p>
    </div>
    {{/newCompanys}}
</div>