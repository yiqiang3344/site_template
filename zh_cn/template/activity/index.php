<div class="breadcrumb clearfix">
        <a href="{{homeUrl}}">首页</a>&nbsp;»&nbsp;
        <a href="{{activityUrl}}">活动</a>  
</div>
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
