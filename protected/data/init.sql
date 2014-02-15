DROP TABLE IF EXISTS YiiSession;
CREATE TABLE `YiiSession` (  
  `id` char(32) NOT NULL,  
  `expire` int(11) default NULL,  
  `data` text,  
  PRIMARY KEY  (`id`),  
  KEY `expire` (`expire`)  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;  

DROP TABLE IF EXISTS user;
CREATE TABLE user (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '',
    `username` varchar(32) UNIQUE NOT NULL COMMENT '',
    `password` char(128) NOT NULL COMMENT '',
    `ip` varchar(32) UNIQUE NOT NULL COMMENT '',
    `updateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
    `deleteFlag` tinyint(3) NOT NULL DEFAULT 0 COMMENT '0 正常 1禁用',
    `recordTime` int(10) UNSIGNED NOT NULL COMMENT '',
    PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS admin;
CREATE TABLE admin (
     `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '',
     `username` varchar(32) UNIQUE NOT NULL COMMENT '',
     `password` char(128) NOT NULL COMMENT '',
     `super` tinyint(3) NOT NULL DEFAULT 0 COMMENT '1超级管理员',
     `updateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
     `deleteFlag` tinyint(3) NOT NULL DEFAULT 0 COMMENT '0 正常 1禁用',
     `recordTime` int(10) UNSIGNED NOT NULL COMMENT '',
     PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='' AUTO_INCREMENT=1 ;
insert into admin(username,password,super,recordTime) values('admin','eb3ccf0a7c36c8723ba9f34851048baea1299b21ec691b4c9a14ea39f35912b9f5afe5cec9244f5814fe43dda494829f84ccbd4e207531dd26ca0e6627cf1f14',1,unix_timestamp());

DROP TABLE IF EXISTS company;
CREATE TABLE company (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '',
    `category` varchar(64) NOT NULL DEFAULT '' COMMENT '类别',
    `name` varchar(32) NOT NULL COMMENT '',
    `nameFirstLetter` char(1) NOT NULL COMMENT '名字首字母',
    `weight` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '权重',
    `logo` varchar(128) NOT NULL DEFAULT '' COMMENT 'logo',
    `star` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '星级',
    `score` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '用户评分',
    `beFixed` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '被固定',
    `beRecommend` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '被推荐',
    `beGuarantee` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '被担保',
    `clickCount` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '访问数',
    `commentCount` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '评论数',
    `platform` varchar(128) NOT NULL DEFAULT '' COMMENT '使用平台',
    `hasLicense` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '有无牌照',
    `openedTime` date NOT NULL COMMENT '开业时间',
    `url` varchar(64) NOT NULL DEFAULT '' COMMENT '网站链接',
    `urlPhoto` varchar(128) NOT NULL DEFAULT '' COMMENT '网站截图',
    `abstract` varchar(256) NOT NULL DEFAULT '' COMMENT '摘要',
    `description` text NOT NULL DEFAULT '' COMMENT '描述',
    `updateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
    `deleteFlag` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '',
    `recordTime` int(10) UNSIGNED NOT NULL COMMENT '',
    PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `companyId` int(10) unsigned NOT NULL,
  `userId` int(10) unsigned NOT NULL,
  `username` varchar(32) COLLATE utf8_bin NOT NULL,
  `content` varchar(512) COLLATE utf8_bin NOT NULL,
  `totalScore` smallint(6) unsigned NOT NULL DEFAULT '0',
  `scoreA` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '评分a',
  `scoreB` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '评分b',
  `scoreC` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '评分c',
  `deleteFlag` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `recordTime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS information;
CREATE TABLE information (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '',
    `categoryId` int(10) NOT NULL COMMENT '',
    `top` tinyint(3) NOT NULL COMMENT '首页显示',
    `title` varchar(128) NOT NULL COMMENT '',
    `abstract` varchar(256) NOT NULL DEFAULT '' COMMENT '',
    `img` varchar(128) NOT NULL DEFAULT '' COMMENT '插图',
    `content` text NOT NULL COMMENT '',
    `updateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
    `deleteFlag` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '',
    `recordTime` int(10) UNSIGNED NOT NULL COMMENT '',
    PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS inforCategory;
CREATE TABLE inforCategory (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '',
    `name` varchar(128) NOT NULL COMMENT '',
    `title` varchar(256) NOT NULL COMMENT '',
    `sort` tinyint(3) NOT NULL DEFAULT 0 COMMENT '排序',
    `updateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
    `deleteFlag` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '',
    `recordTime` int(10) UNSIGNED NOT NULL COMMENT '',
    PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='' AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS activity;
CREATE TABLE activity (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '',
    `title` varchar(128) NOT NULL COMMENT '',
    `abstract` varchar(256) NOT NULL DEFAULT '' COMMENT '',
    `img` varchar(128) NOT NULL DEFAULT '' COMMENT '插图',
    `content` text NOT NULL COMMENT '',
    `updateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
    `deleteFlag` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '',
    `recordTime` int(10) UNSIGNED NOT NULL COMMENT '',
    PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS contact;
CREATE TABLE contact (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '',
    `urlName` varchar(64) UNIQUE NOT NULL COMMENT '路径中显示的名称',
    `name` varchar(64) UNIQUE NOT NULL COMMENT '名称',
    `content` text NOT NULL COMMENT '',
    `sort` tinyint(3) NOT NULL DEFAULT 0 COMMENT '排序',
    `updateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
    `deleteFlag` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '',
    `recordTime` int(10) UNSIGNED NOT NULL COMMENT '',
    PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS link;
CREATE TABLE link (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '',
    `name` varchar(64) UNIQUE NOT NULL COMMENT '名称',
    `url` varchar(128) UNIQUE NOT NULL COMMENT '外链',
    `sort` tinyint(3) NOT NULL DEFAULT 0 COMMENT '排序',
    `updateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
    `deleteFlag` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '',
    `recordTime` int(10) UNSIGNED NOT NULL COMMENT '',
    PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='导航外链' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS backup;
CREATE TABLE backup(
    id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    name varchar(64) NOT NULL,
    file varchar(64) NOT NULL COMMENT '文件名',
    lastRebackTime int(10) NOT NULL DEFAULT 0 COMMENT '最后一次回复的时间',
    deleteFlag tinyint(3) NOT NULL DEFAULT 0,
    createTime int(10) NOT NULL COMMENT '备份时间',
    PRIMARY KEY(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='备份状态表' AUTO_INCREMENT=1 ;
DROP TABLE IF EXISTS ad;
CREATE TABLE ad(
    id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    category varchar(64) NOT NULL COMMENT 'top:头部广告，slide:幻灯片',
    url varchar(256) NOT NULL,
    img varchar(256) NOT NULL COMMENT '',
    sort int(10) UNSIGNED NOT NULL DEFAULT 1 COMMENT '排序',
    deleteFlag tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='广告表' AUTO_INCREMENT=1 ;
