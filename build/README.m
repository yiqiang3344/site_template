default.properties 项目配置文件,包括项目所有需要配置的信息

./bin 命令中使用的脚本以及插件

./translator 翻译图形工具入口

build.xml phing工具命令箱，包括如下命令
    config 项目配置
        根据default.properties初始化项目数据库、缓存等基础配置

    coffee coffee转js

    sass sass转css

    rmAssets 清除暂存文件

    initCode 初始化代码
        依次执行 coffee,sass,rmAssets

    clearLangs 根据配置删除各语言版本目录和文件
        js
        template
        view
    initLangs 根据配置复制生成各语言版本目录和文件
        js
        template
        view

    tanslate 根据配置对指定文件作多语言翻译

    i18n 国际化
        依次执行 clearLangs,initLangs,translate

    versionNumber 生成文件版本号
        根据配置生成图片版本号保存到url.js中
        根据配置处理给指定css文件中的图片链接加上版本号

    optimizeJs 优化js
        编译各语言template
            试图模板编译为(lang)/js/(controller)/(view).min.js
            公用模板保存到(lang)/js/helper.min.js 
            局部模板保存为(lang)/js/(controller)_sub_template.min.js
        处理视图文件
            从视图文件夹的翻译视图中提取指定js文件码,压缩后追加到(lang)/js/(controller)/(view).min.js中，不存在则创建;然后替换视图中提取代码为js文件外链

    mini 压缩代码
        根据配置压缩指定目录的代码
            css目录
            js目录
            各语言的js目录

        根据配置合并js目录中指定js文件

    release 生成发布版本
        依次执行config,initCode,i18n,versionNumber,optimizeJs,mini

    export 导出项目
        复制出发布版本所需要的文件

    initDb 初始化数据库
        执行protected/data/init.sql文件

    initYiiMessage 初始化Yii自带翻译目录
exp:
$ cd 站点路径/build 
$ phing 任务命令1 任务命令2
也可以指定配置文件
$ phing Dbuild.env=无扩展名文件名 命令
导出项目
$ phing -Dproduct.dir=../site_path -Dproduct.langList=zh_cn,en export

