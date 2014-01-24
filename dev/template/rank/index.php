<div class="bdc">
    <div class="sorts">
        <div class="clearfix sorts-tab">
            {{#sorts}}
            <a href="{{url}}" id="order_{{attr}}" class="{{#on}}udl{{/on}}">{{name}}排行<i class="i_arr2 down"></i></a>
            {{/sorts}}
        </div>

        <ul class="com-list js_list clearfix">
            {{#data}}
            <li id="info_{{id}}">
                <div class="left">
                    <img class="logo" src="{{logo}}" alt="无">
                </div>
                <div class="center">
                    <div class="center_top">
                        <span class="name">{{name}}</span>
                        <span class="star_{{star}}"></span>
                        <span class="score"><b class="red_pale">{{score}}</b>分</span>
                    </div>
                    <div class="center_middle">{{abstract}}</div>
                    <div class="center_bottom">
                        <span class="clickCount">访问量{{clickCount}}</span>
                        <span class="commentCount">评论数：{{commentCount}}</span>
                    </div>
                </div>
                <div class="right">
                    <div class="right_top">
                        <a class="btn beFixed {{^beFixed}}gray{{/beFixed}}">固</a>
                        <a class="btn beRecommend {{^beRecommend}}gray{{/beRecommend}}">荐</a>
                        <a class="btn beGuarantee {{^beGuarantee}}gray{{/beGuarantee}}">保</a>
                    </div>
                    <div class="right_bottom">
                        <a class="goto btn2" href="{{goto}}">进入</a>
                    </div>
                </div>
            </li>
            {{/data}}
        </ul>
        <div id="pager"></div>
    </div>
</div>