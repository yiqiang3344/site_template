<div class="top_ad">
    <img src="../images/top_ad.png">
</div>
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
            <a href="{{url}}">{{name}}</a>
            {{/navList}}
        </div>
    </div>
</div>
<div class="warp-banner">
    <div class="w960 banner-bg">
        <div class="banner-slider">
            <ul class="J_slider">
                <li><a><img src="../images/banner1.jpg"></a></li>
                <li><a><img src="../images/banner2.jpg"></a></li>
                <li><a><img src="../images/banner3.jpg"></a></li>
            </ul>
        </div>
        <div class="banner-btn">
            <i class="on"></i><i></i><i></i>
        </div>
    </div>
</div>
<script>
    $('.J_slider').width($('.J_slider li').length*940+'px');
    $('.banner-btn i').click(function() {
        var i=$(this).index();
        $('.J_slider').animate({left: -940*i}, 500,'swing', function() {
      });
       $(this).addClass('on').siblings('').removeClass('on');
    });
</script>