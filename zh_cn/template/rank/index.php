<div class="clearfix">
    {{#sorts}}
    <div class="fl mr10"><a href="{{url}}" id="order_{{attr}}" class="{{#on}}udl{{/on}}">{{name}}排行</a></div>
    {{/sorts}}
</div>

<ul class="mlist_company js_list clearfix">
    {{#data}}
    <li  class="line clearfix" id="info_{{id}}">
        <div class="left">
            <img class="logo" src="{{logo}}" alt="无">
        </div>
        <div class="center">
            <div class="center_top">
                <span class="name">{{name}}</span>
                <span class="star">{{star}}</span>
                <span class="score"><b class="red_pale">{{score}}</b>分</span>
            </div>
            <div class="center_middle">{{abstract}}</div>
            <div class="center_bottom">
                <span class="clickCount">{{clickCount}}</span>
                <span class="commentCount">{{commentCount}}</span>
            </div>
        </div>
        <div class="right">
            <div class="right_top">
                <span class="beFixed {{#beFixed}}on{{/beFixed}}">固</span>
                <span class="beRecommend {{#beRecommend}}on{{/beRecommend}}">保</span>
                <span class="beGuarantee {{#beGuarantee}}on{{/beGuarantee}}">荐</span>
            </div>
            <div class="right_bottom">
                <a class="goto" href="{{goto}}">进入</a>
            </div>
        </div>
    </li>
    {{/data}}
</ul>
<div id="pager"></div>
