<div class="breadcrumb clearfix">
    <a href="{{homeUrl}}">首页</a>&nbsp;»&nbsp;
    <a href="{{informationUrl}}">资讯</a>  
</div>
<div class="category">
    <div class="catlist">
        <strong>分类<s></s></strong>
        <div class="linkbox">
            <a href="{{informationUrl}}" class="current"><span>全部</span></a>
            {{#categoryList}}
            <a href="{{url}}"><span>{{name}}</span></a>
            {{/categoryList}}
        </div>
    </div>
</div>
<div class="news">
    <ul>
        {{#data}}
        <li id="line_{{id}}">
            <a href="{{url}}" class="goto ard-btn">查看详情</a>
            <dl class="clearfix">
                <dt><a href="{{url}}" class="goto">{{title}}</a><i class="gray_pale fr">{{dateTime}}</i></dt>
                <dd>{{abstract}}</dd>
            </dl>
        </li>
        {{/data}}
    </ul>
    <div id="pager"></div>
</div>