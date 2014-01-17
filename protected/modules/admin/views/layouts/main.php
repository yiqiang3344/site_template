<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="format-detection" content="telephone=no" />
        <title><?php echo CHtml::encode($this->pageTitle);?></title>
        <!--<link href="<?php echo $this->url("css/admin.css");?>" rel="stylesheet" type="text/css" media="screen" />-->
        <script type="text/javascript" src="<?php echo $this->url("js/jquery.js");?>"></script>
        <script type="text/javascript">
            var BASEURL=<?php echo json_encode(Yii::app()->getBaseUrl());?>;
            var BASEURI=<?php echo json_encode(Yii::app()->getBaseUrl() . "/index.php/".$this->module->getName());?>;
            var STIME=<?php echo Y::getTime();?>;
            var CTIME=new Date().getTime();
            var TEST_SERVER_FLAG=<?php echo YII_DEBUG;?>;
            var UD=<?php echo json_encode($this->getUd());?>;
            window.UEDITOR_HOME_URL=<?php echo json_encode($this->getAssetsUrl().'/ueditor/');?>;
        </script>
        <script type="text/javascript" src="<?php echo $this->url('js/tool.js');?>"></script>
        <script type="text/javascript" src="<?php echo $this->url('js/url.js');?>"></script>
        <script type="text/javascript" src="<?php echo $this->url('js/main.js');?>"></script>
        <script type="text/javascript">
            //设置子模板编译方法，dev中才有定义
            <?php foreach(array_merge($this->partialsSubTemplate,$this->publicSubTemplate) as $k=>$v):?>
            var <?php echo $k;?> = Hogan.compile(<?php echo json_encode($v);?>);
            <?php endforeach;?>
        </script>
        <style>
            body{ margin:0 auto; padding:0; font:12px/1.7 Microsoft Yahei;color:#333;background: #EFEFEF;}
            form,ul,li,p,h1,h2,h3,h4,h5,h6,p,dl,dt,dd,a,input,select{ margin:0; padding:0; }
            input[type="text"],input[type="password"] {color: #fff; display: inline-block; box-sizing:border-box;border-radius: 5px;line-height: 20px;background-color:rgb(118, 209, 205); outline: none; border: none; text-indent: 10px; }
            iframe{width: 100%;} ul{list-style: none;}
            table{border-spacing: 0; width: 100%;border: solid #ccc 1px; border-radius: 6px; box-shadow: 0 1px 1px #ccc;}
            .h60 img{height: 60px;}
            tr{transition:0.1s ease-in-out;}
            tr:hover {background: #fbf8e9}
            td,th {border-left: 1px solid #ccc; border-top: 1px solid #ccc; padding: 10px; text-align: left;}
            th:hover{background-image: -webkit-linear-gradient(top, #78ADE8, #4C6E98);color:#fff;cursor: pointer;text-shadow:none;}
            td:focus{background-color: rgb(118, 209, 205);outline: none;color:#fff;}
            th {text-align: center;background-color: #dce9f9; background-image: -webkit-linear-gradient(top, #ebf3fc, #dce9f9); box-shadow: 0 1px 0 rgba(255,255,255,.8) inset; border-top: none; text-shadow: 0 1px 0 rgba(255,255,255,.5); }
            td:first-child,th:first-child {border-left: none;}
            th:first-child {border-radius: 6px 0 0 0;}
            th:last-child {border-radius: 0 6px 0 0;}
            tr:last-child td:first-child {border-radius: 0 0 0 6px;}
            tr:last-child td:last-child {border-radius: 0 0 6px 0;}
            .td_input input[type="text"]{display: block;border: none;outline: none;width: 100%;}
            .ac{text-align: center;}
            aside{width: 200px;height: 100%;position: fixed;background: #303030;top: 0;box-shadow:inset -2px 0 20px #000;color: #ccc;-webkit-user-select: none;}
            footer{width: 100%;position: absolute;bottom: 20px;color: #666;text-align: center;}
            .maincontent{margin-left: 200px;padding: 20px;}
            a{color: #333;text-decoration: none;}
            nav a{border-top: 1px solid rgba(34,34,34,0.5);transition:0.5s;padding-left: 10px;font-weight: normal;line-height: 40px;transition:0.5s;cursor: pointer;box-shadow: -2px 3px 5px #000;font-size: 16px;}
            nav a{color: #ccc;display: block;}   
            nav a:hover{background:#545454;background:rgba(34,34,34,0.25);box-shadow: none;color:#fff;}
            nav a.on{background: -webkit-linear-gradient(top,#2cafff,#1b9ded 50%,#1395ec 50.1%,#0083d9);color:#fff;}
            h3{border-bottom: 1px solid #ccc;padding-bottom: 10px;margin-bottom: 20px;font-size: 20px;letter-spacing: 10px;font-weight: 400;text-indent: 2em;}
            .logo{transition:1s;box-shadow: 0 6px 2px rgb(152, 170, 172);text-transform:capitalize; width: 88px; height: 88px; display:block;text-align: center;font: 25px/88px helvetica,verdana,sans-serif; position: relative;margin: 40px auto 0; border:10px solid rgb(130, 191, 231); border-radius: 50%; background-color: rgb(214,214,214);}
            .logo:hover{border-color: #1395ec;text-shadow: #0066cc 0 -1px 0;background-color:rgb(226, 236, 235);color:rgb(37, 197, 228); }
            .logo:active{box-shadow:inset 0 2px 2px rgb(152, 170, 172);}
            .btn_green,.btn_red{display: inline-block;padding: 1px 10px;border-radius: 5px;cursor: pointer;}
            .btn_green{border: 1px solid rgb(27, 211, 211); color: #fff;background: -webkit-linear-gradient(top,rgb(30, 226, 203),rgb(10, 183, 190));}
            .btn_green:hover{background: -webkit-linear-gradient(top,rgb(47, 182, 166),rgb(60, 195, 201));}
            .btn_red{border: 1px solid rgb(238,85,64); color: #fff;background: -webkit-linear-gradient(top,rgb(245,101,82),rgb(234,83,63));}
            .btn_red:hover{background: -webkit-linear-gradient(top,rgb(220,85,70),rgb(210,65,53));}
            .mpager { text-align: center; margin: 20px 0; }
            .mpager a { display: inline-block; padding: 3px 6px; border: 1px solid #d3d3d3; color: #666; margin-right: 5px; border-radius: 2px; }
            .mpager a:hover{ color:#1b9ded; }
            .mpager a.udl{border: 1px solid #0E7FC4;background:#1b9ded;color: #fff}
        </style>
    </head>
    <body>
            <section id="maindiv" class="m">
                    <?php echo $content;?>
            </section>
            <script type="text/javascript">
                show_head(<?php echo json_encode($this->title);?>);
                function show_head(t){
                    var params = {
                        list:[
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
    </body>
</html>

