<div class="company clearfix">
    <div class="com-nav">
        <h2><i></i>大分类</h2>
        <ul>
            {{#categorys}}
            <li><a href="{{url}}"><i></i><span>小分类{{name}}</span></a></li>
            {{/categorys}}
        </ul>
    </div>
    <div class="com-m">
        <h2 class="clearfix">
            <i>字母分类</i>
            <s>
                {{#letters}}
                <a href="{{url}}">{{name}}</a>
                {{/letters}}
            </s>
        </h2>
        <div class="bdc">
            <h3 class="sorts-tab clearfix">
                <!-- <a>星级<i class="i_arr2 down"></i></a>
                <a class="on">评分<i class="i_arr2 down"></i></a>
                <a>访问量<i class="i_arr2 down"></i></a>
                <a>评论量<i class="i_arr2 down"></i></a> -->
                排序：
                {{#sorts}}
                <select name="" id="order_{{attr}}">
                <option value="">{{name}}</option>
                <option value="desc" {{#desc}}selected{{/desc}}>{{name}}↑</option>
                <option value="asc" {{#asc}}selected{{/asc}}>{{name}}↓</option>
                </select>
                {{/sorts}}
                <button class="js_order_do">查看</button> 
            </h3>
            <ul class="com-list">
                {{#data}}
                <li id="info_{{id}}">
                    <a class="left" href="{{goto}}">
                        <img class="logo" src="{{logo}}" alt="无">
                    </a>
                    <div class="center">
                        <div class="center_top">
                            <a class="name">{{name}}</a>
                            <i class="star_{{star}}"></i>
                            <span class="score"><b class="red_pale">{{score}}</b>分</span>
                        </div>
                        <div class="center_middle">{{abstract}}</div>
                        <div class="center_bottom">
                            <span class="clickCount">访问次数：{{clickCount}}</span>
                            <span class="commentCount">访问条数：{{commentCount}}</span>
                        </div>
                    </div>
                    <div class="right">
                        <div class="right_top">
                            <a class="btn beFixed {{#beFixed}}on{{/beFixed}}">固</a>
                            <a class="btn beRecommend {{#beRecommend}}on{{/beRecommend}}">保</a>
                            <a class="btn beGuarantee {{#beGuarantee}}on{{/beGuarantee}}">荐</a>
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
</div>