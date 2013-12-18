<div class="clearfix">
    <div>推荐公司</div>
    {{#companys}}
    <div class="fl m10">
        <div><a href="{{url}}"><img class="w100 h100" src="{{logo}}" alt="logo"></a></div>
        <p class="w100 ac">{{name}}</p>
        <p class="w100 ac">星级{{star}}</p>
    </div>
    {{/companys}}
</div>

<div class="clearfix">
    <div>精品推荐</div>
    {{#activities}}
    <div class="pr fl m10">
        <a href="{{url}}"><img class="w400 h200" src="{{img}}" alt="插图"></a>
        <p class="pa b0 w400 ac">{{title}}</p>
    </div>
    {{/activities}}
</div>

<div class="clearfix">
    <div>推荐资讯</div>
    {{#informations}}
    <div class="pr fl m10">
        <a href="{{url}}"><img class="w400 h200" src="{{img}}" alt="插图"></a>
        <p class="pa b0 w400 ac">{{title}}</p>
    </div>
    {{/informations}}
</div>

<div class="clearfix">
    <div>最近更新</div>
    {{#newCompanys}}
    <div class="fl m10">
        <div><a href="{{url}}"><img class="w100 h100" src="{{logo}}" alt="logo"></a></div>
        <p class="w100 ac">{{name}}</p>
        <p class="w100 ac">星级{{star}}</p>
    </div>
    {{/newCompanys}}
</div>