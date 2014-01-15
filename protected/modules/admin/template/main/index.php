<section>
    <iframe id="m" src="<?=$this->url('Admin','LinksList')?>" frameborder="0" scrolling="no"></iframe>
</section>
<aside>
    <nav>
        <div>
            <h2 class="on"><a onclick="go(this,'<?=$this->url('Admin','LinksList')?>')">友情链接</a></h2>
            <ul style="display:block">
                <li><a class="on" onclick="go(this,'<?=$this->url('Admin','LinksList')?>')">管理友情链接</a></li>
                <li><a onclick="go(this,'<?=$this->url('Admin','AddLinks')?>')">添加友情链接</a></li>
            </ul>
        </div>
        <div>
            <h2><a onclick="go('<?=$this->url('Admin','NewsClassList')?>')">新闻管理</a></h2>
                <ul>
                    <li><a onclick="go(this,'<?=$this->url('Admin','NewsClassList')?>')">新闻类别管理</a></li>
                    <li><a onclick="go(this,'<?=$this->url('Admin','AddNews')?>')">添加新闻</a></li>
                    <li><a onclick="go(this,'<?=$this->url('Admin','NewsManage')?>')">新闻管理</a></li>
                </ul>
        </div>
    </nav>
</aside>
<aside class="r">
    <a class="logo" title="退出登录" href="##"></a>
    <a>修改密码</a>
    <footer>后台管理工具 by 47</footer>
</aside>
<script type="text/javascript">
    $('nav h2').click(function(){
        var me=$(this).hasClass('on');
        $('nav a').removeClass('on');
        $('nav h2').removeClass('on');
        $('nav ul').slideUp(500);
        if(!me){
            $(this).addClass('on');
            $(this).next('ul').find('li').find('a').first().addClass('on');
            $(this).next('ul').slideDown(500);
        }
    });
    $('nav li a').click(function(){
        $('nav li a').removeClass('on');
        $(this).addClass('on');
        iframe_auto_height();
        kajax("AjaxAdmin","LinksList",{name:name,href:href},function(obj){
                    links_list=obj.links_list;
                    table();
        },this);

    });

    function go(dom,href){
        $('iframe').attr('src',href)
    }
    function iframe_auto_height(){
        $("#m").height(0);
        $("#m").height($("#m").contents().height());
    }
    $("#m").load(function(){iframe_auto_height();})
</script>
<script type="text/javascript">
    show_head(<?php echo json_encode($this->title);?>);
    function show_head(t){
        var params = {list:[
            {
                select:t=='Index'?1:0,
                url:getUrl('Main','index'),
                name:'logo管理'
            },
            {
                select:t=='Link'?1:0,
                url:getUrl('Main','LinkList'),
                name:'导航链接'
            },
            {
                select:t=='Contact'?1:0,
                url:getUrl('Main','ContactList'),
                name:'联系我们'
            },
            {
                select:t=='Company'?1:0,
                url:getUrl('Main','CompanyList'),
                name:'公司'
            },
            {
                select:t=='Comment'?1:0,
                url:getUrl('Main','CommentList'),
                name:'评论'
            },
            {
                select:t=='Activity'?1:0,
                url:getUrl('Main','ActivityList'),
                name:'活动'
            },
            {
                select:t=='InforCategory'?1:0,
                url:getUrl('Main','InforCategoryList'),
                name:'资讯分类'
            },
            {
                select:t=='Information'?1:0,
                url:getUrl('Main','InformationList'),
                name:'资讯'
            },
            {
                select:t=='User'?1:0,
                url:getUrl('Main','UserList'),
                name:'用户管理'
            }
        ]};
        if(UD){
            params.list = params.list.concat([
                {
                    select:t=='Admin'?1:0,
                    url:getUrl('Main','AdminList'),
                    name:'管理员管理'
                },
                {
                    select:t=='Backup'?1:0,
                    url:getUrl('Main','Backup'),
                    name:'备份还原'
                }
            ]);
        }
        params.list.push(
            {
                select:0,
                url:getUrl('Main','Logout'),
                name:'退出'
            }
        );
        $('#maindiv').prepend(pHeader.render(params));
    }
</script>
<!-- <div>
    <div>
        <h3>logo管理</h3>
        <p>当前logo</p>
        <div>
            <img src="{{logo_url}}" alt="logo">
        </div>
        <div>
            <input type="file" id="logo_file">
        </div>
        <div>
            <input type="submit" id="upload_logo" value="提交">
        </div>
    </div>
</div> -->