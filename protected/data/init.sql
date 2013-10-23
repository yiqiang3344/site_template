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
    `recordTime` int(10) UNSIGNED NOT NULL COMMENT '',
    PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS admin;
CREATE TABLE admin (
     `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '',
     `username` varchar(32) UNIQUE NOT NULL COMMENT '',
     `password` char(128) NOT NULL COMMENT '',
     `updateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
     `recordTime` int(10) UNSIGNED NOT NULL COMMENT '',
     PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='' AUTO_INCREMENT=1 ;
insert into admin(username,password,recordTime) values('admin','eb3ccf0a7c36c8723ba9f34851048baea1299b21ec691b4c9a14ea39f35912b9f5afe5cec9244f5814fe43dda494829f84ccbd4e207531dd26ca0e6627cf1f14',unix_timestamp());

DROP TABLE IF EXISTS company;
CREATE TABLE company (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '',
    `category` varchar(64) NOT NULL DEFAULT '' COMMENT '类别',
    `name` varchar(32) NOT NULL COMMENT '',
    `nameFirstLetter` char(1) NOT NULL COMMENT '名字首字母',
    `weight` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '权重',
    `hasLogo` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '有无logo',
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
    `hasUrlPhoto` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '有无网站截图',
    `abstract` varchar(256) NOT NULL DEFAULT '' COMMENT '摘要',
    `description` text NOT NULL DEFAULT '' COMMENT '描述',
    `updateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
    `deleteFlag` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '',
    `recordTime` int(10) UNSIGNED NOT NULL COMMENT '',
    PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='' AUTO_INCREMENT=1 ;