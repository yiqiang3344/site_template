<div class="breadcrumb clearfix">
        <a href="{{homeUrl}}">首页</a>&nbsp;»&nbsp;
        <a href="{{informationUrl}}">资讯</a>  
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