<!-- <dl class="breadcrumb clearfix">
    <dt>
        <strong>当前位置:</strong>
        <a href="/">首页</a>&nbsp;»&nbsp;
        <a href="/info_news.html">活动</a>  
    </dt>
    <dd></dd>
</dl> -->
<ul class="activity">
    {{#data}}
    <li id="line_{{id}}">
        <a href="{{url}}" class="goto"><img src="{{img}}" alt="无"/></a>
        <dl>
            <dt><a href="{{url}}" class="goto">{{title}}</a></dt>
            <dd>{{abstract}}</dd>
        </dl>
    </li>
    {{/data}}
</ul>
