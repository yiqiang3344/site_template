<!-- <div class="category">
	<div class="catlist">
		<strong>分类<s></s></strong>
		<div class="linkbox">
			<a href="##" class="current"><span>全部</span></a>
			<a href="##"><span>安卓资讯</span></a>
			<a href="##"><span>手机资讯</span></a>
			<a href="##"><span>游戏攻略</span></a>
			<a href="##"><span>刷机教程</span></a>          
		</div>
	</div>
</div> -->
<dl class="breadcrumb clearfix">
	<dt>
		<strong>当前位置:</strong>
		<a href="{{homeUrl}}">首页</a>&nbsp;»&nbsp;
		<a href="{{informationUrl}}">资讯</a>  
	</dt>
	<dd></dd>
</dl>
<div class="news">
	<ul>
		{{#data}}
		<li id="line_{{id}}">
			<a href="{{url}}" class="goto news-img"><img src="{{img}}" alt="无"/></a>
			<dl>
				<dt><a href="{{url}}" class="goto">{{title}}</a></dt>
				<dd>{{abstract}}</dd>
			</dl>
		</li>
		{{/data}}
	</ul>
	<div id="pager"></div>
</div>