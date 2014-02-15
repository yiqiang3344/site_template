{{#topAd}}
<div class="top_ad">
    <a href="{{url}}"><img src="{{img}}"></a>
</div>
{{/topAd}}
<div class="head">
    <div class="user">
        {{#user}}
        欢迎您，<span>{{username}}</span> &nbsp;&nbsp; <span><a href="#" class="js_btn_logout">退出</a></span>
        {{/user}}
        {{^user}}
        <a href="{{loginUrl}}" class="js_btn_to_login">登录</a>
        <a href="{{registerUrl}}" class="js_btn_to_register">注册</a>
        {{/user}}
    </div>
    <div class="clearfix w960">
        <a class="logo"></a>
        <form  class="search clearfix" action="{{searchUrl}}" method="get">
            <input name="search" type="text"/>
            <input type="submit" value="搜索"/>
        </form>
    </div>
    <div class="nav">
        <div class="w960 clearfix">
            {{#navList}}
            <a {{#on}}class="cur"{{/on}} href="{{url}}">{{name}}</a>
            {{/navList}}
        </div>
    </div>
</div>
{{#sliderBanner}}
<div class="warp-banner">
    <div class="w960 banner-bg">
        <div class="banner-slider">
            <ul class="J_slider">
                {{#list}}
                <li><a href="{{url}}"><img src="{{img}}"></a></li>
                {{/list}}
            </ul>
        </div>
        <div class="banner-btn">
            <i class="on"></i><i></i><i></i>
        </div>
    </div>
</div>
<script>
    $(function(){
        var nSlideIndex = 0,
            nSlideLimit = 3,
            nTimeout;
        $('.J_slider').width($('.J_slider li').length*940+'px');
        $('.banner-btn i').click(function() {
            var index = $(this).index();
            fSlide(index);
            fAutoSlide((index+1)%nSlideLimit);
        });
        fAutoSlide(nSlideIndex);
        function fSlide(index,callback){
            $('.banner-btn i:eq('+index+')').addClass('on').siblings('').removeClass('on');
            $('.J_slider').animate({left: -940*index}, 500,'swing', function() {
                callback && callback();
            });
        }
        function fAutoSlide(index){
            clearTimeout(nTimeout);
            nTimeout = setTimeout(function(){
                fSlide(index,function(){
                    fAutoSlide((index+1)%nSlideLimit);
                });
            },3000);
        }
    });
</script>
{{/sliderBanner}}