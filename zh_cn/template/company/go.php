<div class="clearfix">
    <div class="fl">
        <div class="clearfix">
            <div class="fl">
                    <a href="{{url}}"><img src="{{logo}}" alt="无"/></a>
            </div>
            <div class="fl">
                <p class="name">名称：{{name}}</p>
                <p class="">星级：{{star}}</p>
                <p class="">评分：{{score}}</p>
                <p class="">访问量：{{clickCount}}</p>
                <p class="">评论数：{{commentCount}}</p>
                <p class="">{{#beFixed}}固{{/beFixed}}{{#beRecommend}}荐{{/beRecommend}}{{#beGuarantee}}保{{/beGuarantee}}</p>
            </div>
        </div>
        <p class="platform">平台：{{platform}}</p>
        <p class="license">牌照：{{#hasLicense}}有{{/hasLicense}}{{^hasLicense}}无{{/hasLicense}}</p>
        <p class="openTime">开业时间：{{openedTime}}</p>
        <p class="">简介：{{abstract}}</p>
    </div>
    <div class="fl">
        <div class="">
            <p>网站快照：</p>
            <img src="{{urlPhoto}}" alt="无">
        </div>
        <div class="">
            <p>描述：</p>
            <div>{{{description}}}</div>
        </div>
        <div class="comment">
            <div class="clearfix">
                {{#commentUrls}}
                <p class="fl"><a href="{{url}}">{{name}}</a>({{num}})</p>
                {{/commentUrls}}
            </div>
            <ul class="mlist_comment clearfix">
                {{#comments.data}}
                <li class="clearfix">
                    <div class="fl">
                        <div><img src="{{userImg}}" alt="用户头像"></div>
                        <p>{{username}}</p>
                    </div>
                    <div class="fl">
                        <div class="clearfix">
                            <div class="fl">总评分：{{totalScore}}</div>
                            <div class="fl">评分A：{{scoreA}}</div>
                            <div class="fl">评分B：{{scoreB}}</div>
                            <div class="fl">评分C：{{scoreC}}</div>
                        </div>
                        <div>{{content}}</div>
                    </div>
                </li>
                {{/comments.data}}
            </ul>
            <div id="pager"></div>
            <div class="add_comment">
                <div>
                    总体评价：
                    <select id="comment_totalScore">
                        <option value="">请选择</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
                <div>
                    <div>
                        评分A：
                        <select id="comment_scoreA">
                            <option value="">请选择</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                    <div>
                        评分B：
                        <select id="comment_scoreB">
                            <option value="">请选择</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                    <div>
                        评分C：
                        <select id="comment_scoreC">
                            <option value="">请选择</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                </div>
                <div>
                    <textarea id="comment_content" cols="30" rows="10"></textarea>
                </div>
                <div>
                    <button class="js_comment_submit">提交评论</button>
                </div>
            </div>
        </div>
    </div>
</div>