<div class="m1">
    <h2><i></i><b>推荐公司</b></h2>
    <ul class="clearfix">
    {{#companys}}
        <li>
            <a href="{{url}}"><img class="mlines__img" src="{{logo}}" alt="logo"></a>
            <h3 class="mlines__name">{{name}}</h3>
            <p class="star_{{star}}"></p>
        </li>
    {{/companys}}
    </ul>
</div>

<div class="m2">
    <h2><i></i><b>精品推荐</b></h2>
    <ul class="clearfix">
    {{#activities}}
        <li>
            <a href="{{url}}">
                <img class="mlines__img" src="{{img}}" alt="插图">
                <p class="mlines__name">{{title}}</p>
            </a>
        </li>
    {{/activities}}
    </ul>
</div>

<div class="m3 clearfix">
    {{#informations}}
        <dl>
            <dt><i></i><b>推荐资讯</b></dt>
            <dd class="info clearfix">
                    <img src="{{img}}" alt="插图">
                    <div>
                        <a href="{{url}}">{{title}}</a>
                        <p>新闻内容新闻内容新闻内容新闻内容新闻内容新闻内容新闻内容新闻内容新闻内容新闻内容</p>
                    </div>
            </dd>
            <dd class="list clearfix">
              <a href="{{url}}">{{title}}</a>
              <a href="{{url}}">{{title}}</a>
              <a href="{{url}}">{{title}}</a>
              <a href="{{url}}">{{title}}</a>
              <a href="{{url}}">{{title}}</a>
              <a href="{{url}}">{{title}}</a>
            </dd>
        </dl>
    {{/informations}}
</div>

<div class="m4">
  <h2><i></i><b>最近更新</b></h2>
  <ul class="clearfix">
    {{#newCompanys}}
    <li>
        <a href="{{url}}">
            <img class="mlines__img" src="{{logo}}" alt="logo">
            <p>{{name}}</p>
        </a>
    </li>
    {{/newCompanys}}
    </ul>
</div>