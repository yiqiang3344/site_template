# site1服务器端代码

## 说明
这里包含site1项目的服务器端代码，使用PHP基于Yii框架开发而成。

## 目录

## 安装
### 依赖：
 * PHP(5.4+)
 * composer(1.0.0)

### 安装步骤：
 * 安装PHP

 * 安装composer:
    $ curl -sS https://getcomposer.org/installer | php
   参考：http://getcomposer.org/doc/00-intro.md

 * 使用Composer安装依赖模块:
    $ php composer.phar install
    或者
    $ composer install

 * 环境配置
   需要的配置包括：
    + 站点语言，名称及相关构建配置
    + 数据库
    + session cache
    + data cache
   默认配置在build/default.properties中，可以根据不同的环境新建不同的配置文件，
   在该配置文件中指定的配置会覆盖默认配置文件。build命令中指定配置环境的方法：
    $ cd build
    $ phing -Dbuild.env=local target

 * 数据库初始化
    $ phing db-migrate

 * 配置文件初始化
    $ phing config

 * deploy
    $ phing deploy

## 参考
