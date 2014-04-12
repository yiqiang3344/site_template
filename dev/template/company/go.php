<div class="breadcrumb bdb clearfix">
    <a href="{{homeUrl}}" class="current">首页</a><span>&nbsp;»&nbsp;</span>
    <a href="{{companyUrl}}">公司</a><span>&nbsp;»&nbsp;</span>
    <a href="#"><span>{{name}}</span></a>
</div>
<div class="clearfix com-info">
    <div class="com-info-side">
        <dl class="clearfix">
            <dt>
                <a href="{{url}}" target="_blank"><img src="{{logo}}" alt="无"/></a>
            </dt>
            <dd>
                <a href="{{url}}" target="_blank"><p class="name">{{name}}</p></a>
                <p class="star_{{star}}"></p>
                <p class=""><a class="btn {{^beFixed}}gray{{/beFixed}}">固</a><a class="btn {{^beRecommend}}gray{{/beRecommend}}">荐</a><a class="btn {{^beGuarantee}}gray{{/beGuarantee}}">保</a></p>
                <p class="info-list">
                    <span>评分：{{score}}</span>
                    <span class="platform">平台：{{platform}}</span>
                    <span class="license">牌照：{{#hasLicense}}有{{/hasLicense}}{{^hasLicense}}无{{/hasLicense}}</span>
                    <span>访问量：{{clickCount}}</span>
                    <span>评论数：{{commentCount}}</span>
                    <span class="openTime">开业时间：{{openedTime}}</span>
                </p>
                <p>简介：{{abstract}}</p>
            </dd>
        </dl>
    </div>
    <div class="com-info-m">
        <div class="com-info-m-t">
            <h2>网站快照：</h2>
            <img src="{{urlPhoto}}" alt="无">
        </div>
        <div>
            <h2 class="bdb">描述：</h2>
            <div class="p10 lh2">{{{description}}}</div>
        </div>
        <div class="com-pose mb10">
            <div class="clearfix sorts-tab">
                 {{#commentUrls}}
                <a href="{{url}}">{{name}}<s>({{num}})</s></a>
                 {{/commentUrls}}
            </div>
            <div class="clearfix m10">
                <form action="">
                    <textarea id="comment_content"></textarea>
                </form>
                <dl>
                    <dt>
                        <i>总体评价：</i>
                        <p class="star2 js_select_score">
                            <a class="star2-1"></a><a class="star2-2"></a><a class="star2-3"></a><a class="star2-4"></a><a class="star2-5"></a>
                            <input id="comment_totalScore" type="hidden" value="0"/>
                        </p>
                    </dt>
                    <dd>
                        <i>存款速度：</i>
                        <p class="star2 js_select_score">
                            <a class="star2-1"></a><a class="star2-2"></a><a class="star2-3"></a><a class="star2-4"></a><a class="star2-5"></a>
                            <input id="comment_scoreA" type="hidden" value="0"/>
                        </p>
                    </dd>
                    <dd>
                        <i>提款速度：</i>
                        <p class="star2 js_select_score">
                            <a class="star2-1"></a><a class="star2-2"></a><a class="star2-3"></a><a class="star2-4"></a><a class="star2-5"></a>
                            <input id="comment_scoreB" type="hidden" value="0"/>
                        </p>
                    </dd>
                    <dd>
                        <i>服务态度：</i>
                        <p class="star2 js_select_score">
                            <a class="star2-1"></a><a class="star2-2"></a><a class="star2-3"></a><a class="star2-4"></a><a class="star2-5"></a>
                            <input id="comment_scoreC" type="hidden" value="0"/>
                        </p>
                    </dd>
                </dl>
            </div>
            <p class="submit"><input class="js_comment_submit" type="submit" class="btn2" value="提交评价"></p>
        </div>
        <div>
            <h2 class="bdb">评论：</h2>
            <ul class="rate-list">
                {{#comments.data}}
                <li>
                    <p class="info">
                        <a class="name">{{username}}</a>
                        <span class="star2">
                            <a class="star2-{{star}} on"></a>
                        </span>
                        <span>存款速度({{aStr}})</span>
                        <span>提款速度({{bStr}})</span>
                        <span>服务态度({{cStr}})</span>
                        <span class="time">{{dateTime}}</span>
                    </p>
                    <p class="info">{{content}}</p>
                </li>
                {{/comments.data}}
            </ul>
        </div>
    </div>
</div>
