<div class="clear">
    <div class="fl">
        <p>大分类</p>
        <p><a href=""></a></p>
    </div>
    <div class="fl">
        <div>
            <p>字母分类</p>
            <div>
                {{#letters}}
                <span><a href="{{url}}">{{name}}</a></span>
                {{/letters}}
            </div>
        </div>

        <div>
            排序：
            {{#sorts}}
            <span> <button id="order_{{attr}}">{{name}}</button> </span>
            {{/sorts}}
        </div>
        
        <ul class="mlist_company js_list">
            {{#data}}
            <li  class="clearfix" id="info_{{id}}">
                <div class="left">
                    <img class="logo" src="{{logo}}" alt="无">
                </div>
                <div class="center">
                    <div class="center_top">
                        <span class="name">{{name}}</span>
                        <span class="star">{{star}}</span>
                        <span class="score"><b class="red_pale">{{name}}</b>分</span>
                    </div>
                    <div class="center_middle">{{abstract}}</div>
                    <div class="center_bottom">
                        <span class="click_count">{{click_count}}</span>
                        <span class="comment_count">{{comment_count}}</span>
                    </div>
                </div>
                <div class="right">
                    <div class="right_top">
                        <span class="be_fixed {{#be_fixed}}on{{/be_fixed}}">固</span>
                        <span class="be_recommend {{#be_recommend}}on{{/be_recommend}}">保</span>
                        <span class="be_guarantee {{#be_guarantee}}on{{/be_guarantee}}">荐</span>
                    </div>
                    <div class="right_bottom">
                        <a class="goto" href="{{goto}}">进入</a>
                    </div>
                </div>
            </li>
            {{/data}}
        </ul>
        <div id="page"></div>
    </div>
</div>