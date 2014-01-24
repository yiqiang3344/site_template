DROP TABLE IF EXISTS `activity`;
CREATE TABLE `activity` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(128) COLLATE utf8_bin NOT NULL,
  `abstract` varchar(256) COLLATE utf8_bin NOT NULL DEFAULT '',
  `img` varchar(128) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '插图',
  `content` text COLLATE utf8_bin NOT NULL,
  `updateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleteFlag` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `recordTime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
INSERT INTO `activity` VALUES ('1','1111','1111','/site1/assets/c56ccf76/ueditor/php/../../../../upload/20131222/bg26.jpg','<p><img src=\"/site1/assets/c56ccf76/ueditor/php/../../../../upload/20131222/bg26.jpg\" title=\"1.png\"/></p>','2013-12-23 22:23:40','0','1387689546');INSERT INTO `activity` VALUES ('2','2222','2222','/site1/assets/c56ccf76/ueditor/php/../../../../upload/20131222/bg26.jpg','<p><img src=\"/site1/assets/c56ccf76/ueditor/php/../../../../upload/20131222/bg26.jpg\" title=\"1.png\"/></p>','2013-12-23 22:23:40','0','1387689546');INSERT INTO `activity` VALUES ('3','3333','3','/site1/assets/c56ccf76/ueditor/php/../../../../upload/20131222/bg26.jpg','<p><img src=\"/site1/assets/c56ccf76/ueditor/php/../../../../upload/20131222/bg26.jpg\" title=\"1.png\"/></p>','2013-12-23 22:23:40','0','1387689546');INSERT INTO `activity` VALUES ('4','4444','5','/site1/assets/c56ccf76/ueditor/php/../../../../upload/20131222/bg26.jpg','<p><img src=\"/site1/assets/c56ccf76/ueditor/php/../../../../upload/20131222/bg26.jpg\" title=\"1.png\"/></p>','2013-12-23 22:23:40','0','1387689546');INSERT INTO `activity` VALUES ('5','4444','6','/site1/assets/c56ccf76/ueditor/php/../../../../upload/20131222/bg26.jpg','<p><img src=\"/site1/assets/c56ccf76/ueditor/php/../../../../upload/20131222/bg26.jpg\" title=\"1.png\"/></p>','2013-12-23 22:23:40','0','1387689546');INSERT INTO `activity` VALUES ('6','4444','7','/site1/assets/c56ccf76/ueditor/php/../../../../upload/20131222/bg26.jpg','<p><img src=\"/site1/assets/c56ccf76/ueditor/php/../../../../upload/20131222/bg26.jpg\" title=\"1.png\"/></p>','2013-12-23 22:23:40','0','1387689546');INSERT INTO `activity` VALUES ('7','4444','8','/site1/assets/c56ccf76/ueditor/php/../../../../upload/20131222/bg26.jpg','<p><img src=\"/site1/assets/c56ccf76/ueditor/php/../../../../upload/20131222/bg26.jpg\" title=\"1.png\"/></p>','2013-12-23 22:23:40','0','1387689546');INSERT INTO `activity` VALUES ('8','4444','9','/site1/assets/c56ccf76/ueditor/php/../../../../upload/20131222/bg26.jpg','<p><img src=\"/site1/assets/c56ccf76/ueditor/php/../../../../upload/20131222/bg26.jpg\" title=\"1.png\"/></p>','2013-12-23 22:23:40','0','1387689546');DROP TABLE IF EXISTS `comment`;
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
INSERT INTO `comment` VALUES ('1','1','1','test','test','3','5','5','5','0','1389969070');DROP TABLE IF EXISTS `company`;
CREATE TABLE `company` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '类别',
  `name` varchar(32) COLLATE utf8_bin NOT NULL,
  `nameFirstLetter` char(1) COLLATE utf8_bin NOT NULL COMMENT '名字首字母',
  `weight` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '权重',
  `logo` varchar(128) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT 'logo',
  `star` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '星级',
  `score` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户评分',
  `beFixed` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '被固定',
  `beRecommend` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '被推荐',
  `beGuarantee` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '被担保',
  `clickCount` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '访问数',
  `commentCount` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论数',
  `platform` varchar(128) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '使用平台',
  `hasLicense` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '有无牌照',
  `openedTime` date NOT NULL COMMENT '开业时间',
  `url` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '网站链接',
  `urlPhoto` varchar(128) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '网站截图',
  `abstract` varchar(256) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '摘要',
  `description` text COLLATE utf8_bin NOT NULL COMMENT '描述',
  `updateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleteFlag` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `recordTime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
INSERT INTO `company` VALUES ('1','1','a1','a','0','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','1','1','1','1','0','10','1','1','1','2013-12-23','http://baidu.com','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','11','11','2014-01-17 22:31:10','0','0');INSERT INTO `company` VALUES ('2','2','a2','a','0','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','2','2','0','1','1','2','1','1','0','2013-12-23','http://baidu.com','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','11','11','2014-01-17 22:31:10','0','0');INSERT INTO `company` VALUES ('3','3','a3','a','0','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','3','3','1','1','1','0','1','1','0','2013-12-23','http://baidu.com','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','11','11','2014-01-17 22:31:10','0','0');INSERT INTO `company` VALUES ('4','4','a4','a','0','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','4','4','0','0','0','0','1','1','0','2013-12-23','http://baidu.com','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','11','11','2014-01-17 22:31:10','0','0');INSERT INTO `company` VALUES ('5','5','a5','a','0','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','5','5','0','1','0','0','1','1','0','2013-12-23','http://baidu.com','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','11','11','2014-01-17 22:31:10','0','0');INSERT INTO `company` VALUES ('6','6','a6','a','0','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','0','0','0','1','0','0','1','1','0','2013-12-23','http://baidu.com','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','11','11','2014-01-17 22:31:10','0','0');INSERT INTO `company` VALUES ('7','7','a7','a','0','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','0','0','0','1','0','0','1','1','0','2013-12-23','http://baidu.com','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','11','11','2014-01-17 22:31:10','0','0');INSERT INTO `company` VALUES ('8','8','a8','a','0','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','0','0','0','1','0','0','1','1','0','2013-12-23','http://baidu.com','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','11','11','2014-01-17 22:31:10','0','0');INSERT INTO `company` VALUES ('9','9','a9','a','0','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','0','0','0','1','0','0','1','1','0','2013-12-23','http://baidu.com','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','11','11','2014-01-17 22:31:10','0','0');INSERT INTO `company` VALUES ('10','10','a10','a','0','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','0','0','0','1','0','0','1','1','0','2013-12-23','http://baidu.com','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','11','11','2014-01-17 22:31:10','0','0');INSERT INTO `company` VALUES ('11','11','a11','a','0','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','0','0','0','1','0','0','1','1','0','2013-12-23','http://baidu.com','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','11','11','2014-01-17 22:31:10','0','0');INSERT INTO `company` VALUES ('12','12','a12','a','0','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','0','0','0','1','0','0','1','1','0','2013-12-23','http://baidu.com','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','11','11','2014-01-17 22:31:10','0','0');INSERT INTO `company` VALUES ('13','13','a13','a','0','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','0','0','0','1','0','0','1','1','0','2013-12-23','http://baidu.com','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','11','11','2014-01-17 22:31:10','0','0');INSERT INTO `company` VALUES ('14','14','a14','a','0','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','0','0','0','1','0','0','1','1','0','2013-12-23','http://baidu.com','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','11','11','2014-01-17 22:31:10','0','0');INSERT INTO `company` VALUES ('15','15','a15','a','0','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','0','0','0','1','0','0','1','1','0','2013-12-23','http://baidu.com','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','11','11','2014-01-17 22:31:10','0','0');INSERT INTO `company` VALUES ('16','16','a16','a','0','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','0','0','0','1','0','0','1','1','0','2013-12-23','http://baidu.com','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','11','11','2014-01-17 22:31:10','0','0');INSERT INTO `company` VALUES ('17','17','a17','a','0','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','0','0','0','1','0','0','1','1','0','2013-12-23','http://baidu.com','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','11','11','2014-01-17 22:31:10','0','0');INSERT INTO `company` VALUES ('18','18','a18','a','0','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','0','0','0','1','0','0','1','1','0','2013-12-23','http://baidu.com','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','11','11','2014-01-17 22:31:10','0','0');INSERT INTO `company` VALUES ('19','19','a19','a','0','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','0','0','0','1','0','0','1','1','0','2013-12-23','http://baidu.com','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','11','11','2014-01-17 22:31:10','0','0');INSERT INTO `company` VALUES ('20','20','a20','a','0','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','0','0','0','1','0','0','1','1','0','2013-12-23','http://baidu.com','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','11','11','2014-01-17 22:31:10','0','0');INSERT INTO `company` VALUES ('21','21','a21','a','0','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','0','0','0','1','0','0','1','1','0','2013-12-23','http://baidu.com','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','11','11','2014-01-17 22:31:10','0','0');INSERT INTO `company` VALUES ('22','22','a22','a','0','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','0','0','0','1','0','0','1','1','0','2013-12-23','http://baidu.com','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','11','11','2014-01-17 22:31:10','0','0');INSERT INTO `company` VALUES ('23','23','a23','a','0','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','0','0','0','1','0','0','1','1','0','2013-12-23','http://baidu.com','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','11','11','2014-01-17 22:31:10','0','0');INSERT INTO `company` VALUES ('24','24','a24','a','0','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','0','0','0','1','0','0','1','1','0','2013-12-23','http://baidu.com','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','11','11','2014-01-17 22:31:10','0','0');INSERT INTO `company` VALUES ('25','25','a25','a','0','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','0','0','0','1','0','0','1','1','0','2013-12-23','http://baidu.com','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','11','11','2014-01-17 22:31:10','0','0');INSERT INTO `company` VALUES ('26','26','a26','a','0','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','0','0','0','1','0','0','1','1','0','2013-12-23','http://baidu.com','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','11','11','2014-01-17 22:31:10','0','0');INSERT INTO `company` VALUES ('27','27','a27','a','0','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','0','0','0','1','0','0','1','1','0','2013-12-23','http://baidu.com','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','11','11','2014-01-17 22:31:10','0','0');INSERT INTO `company` VALUES ('28','28','a28','a','0','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','0','0','0','1','0','0','1','1','0','2013-12-23','http://baidu.com','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','11','11','2014-01-17 22:31:10','0','0');INSERT INTO `company` VALUES ('29','29','a29','a','0','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','0','0','0','1','0','0','1','1','0','2013-12-23','http://baidu.com','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','11','11','2014-01-17 22:31:10','0','0');INSERT INTO `company` VALUES ('30','30','a30','a','0','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','0','0','0','1','0','0','1','1','0','2013-12-23','http://baidu.com','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','11','11','2014-01-17 22:31:10','0','0');INSERT INTO `company` VALUES ('31','31','a31','a','0','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','0','0','0','1','0','0','1','1','0','2013-12-23','http://baidu.com','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','11','11','2014-01-17 22:31:10','0','0');INSERT INTO `company` VALUES ('32','32','a32','a','0','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','0','0','0','1','0','0','1','1','0','2013-12-23','http://baidu.com','/site1/upload/20131222/company_logo_3.png?v=e3aaaa4a','11','11','2014-01-17 22:31:10','0','0');DROP TABLE IF EXISTS `contact`;
CREATE TABLE `contact` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `urlName` varchar(64) COLLATE utf8_bin NOT NULL COMMENT '路径中显示的名称',
  `name` varchar(64) COLLATE utf8_bin NOT NULL COMMENT '名称',
  `content` text COLLATE utf8_bin NOT NULL,
  `sort` tinyint(3) NOT NULL DEFAULT '0' COMMENT '排序',
  `updateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleteFlag` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `recordTime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `urlName` (`urlName`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
INSERT INTO `contact` VALUES ('1','contract_us','联系我们','<p>快点联系我们呀～</p><p><img src=\"/site1/assets/b3b3bdaf/ueditor/php/../../../../upload//20131116/1.jpg\"/>记得要联系我~</p>','1','2013-12-22 15:37:57','0','1387697877');INSERT INTO `contact` VALUES ('2','joinUs','加入我们','<p>来加入我们吧~</p>','2','2014-01-24 21:36:16','0','1390570576');DROP TABLE IF EXISTS `information`;
CREATE TABLE `information` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `categoryId` int(10) unsigned NOT NULL,
  `top` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `title` varchar(128) COLLATE utf8_bin NOT NULL,
  `abstract` varchar(256) COLLATE utf8_bin NOT NULL DEFAULT '',
  `img` varchar(128) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '插图',
  `content` text COLLATE utf8_bin NOT NULL,
  `updateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleteFlag` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `recordTime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
INSERT INTO `information` VALUES ('1','1','1','好活动呀','快来参加快来看呀～','/site1/assets/b3b3bdaf/ueditor/php/../../../../upload//20131222/bg26.jpg','<p><img src=\"/site1/assets/b3b3bdaf/ueditor/php/../../../../upload//20131222/bg26.jpg\"/></p>','2013-12-25 23:25:45','0','1387985145');INSERT INTO `information` VALUES ('2','2','1','好活动1','好活动1','/site1/assets/b3b3bdaf/ueditor/php/../../../../upload//20131222/bg26.jpg','<p><img src=\"/site1/assets/b3b3bdaf/ueditor/php/../../../../upload//20131222/bg26.jpg\"/></p>','2013-12-26 00:52:01','0','1387985197');INSERT INTO `information` VALUES ('3','3','1','好活动2','好活动2','/site1/assets/b3b3bdaf/ueditor/php/../../../../upload//20131222/bg26.jpg','<p><img src=\"/site1/assets/b3b3bdaf/ueditor/php/../../../../upload//20131222/bg26.jpg\"/></p>','2013-12-26 00:52:01','0','1387985197');INSERT INTO `information` VALUES ('4','4','1','好活动4','好活动4','/site1/assets/b3b3bdaf/ueditor/php/../../../../upload//20131222/bg26.jpg','<p><img src=\"/site1/assets/b3b3bdaf/ueditor/php/../../../../upload//20131222/bg26.jpg\"/></p>','2013-12-26 00:52:01','0','1387985197');INSERT INTO `information` VALUES ('5','1','1','好活动5','好活动5','/site1/assets/b3b3bdaf/ueditor/php/../../../../upload//20131222/bg26.jpg','<p><img src=\"/site1/assets/b3b3bdaf/ueditor/php/../../../../upload//20131222/bg26.jpg\"/></p>','2013-12-26 00:52:01','0','1387985197');INSERT INTO `information` VALUES ('6','2','1','好活动6','好活动6','/site1/assets/b3b3bdaf/ueditor/php/../../../../upload//20131222/bg26.jpg','<p><img src=\"/site1/assets/b3b3bdaf/ueditor/php/../../../../upload//20131222/bg26.jpg\"/></p>','2013-12-26 00:52:01','0','1387985197');INSERT INTO `information` VALUES ('7','3','1','好活动7','好活动7','/site1/assets/b3b3bdaf/ueditor/php/../../../../upload//20131222/bg26.jpg','<p><img src=\"/site1/assets/b3b3bdaf/ueditor/php/../../../../upload//20131222/bg26.jpg\"/></p>','2013-12-26 00:52:01','0','1387985197');INSERT INTO `information` VALUES ('8','4','1','好活动8','好活动8','/site1/assets/b3b3bdaf/ueditor/php/../../../../upload//20131222/bg26.jpg','<p><img src=\"/site1/assets/b3b3bdaf/ueditor/php/../../../../upload//20131222/bg26.jpg\"/></p>','2013-12-26 00:52:01','0','1387985197');INSERT INTO `information` VALUES ('9','1','1','好活动9','好活动9','/site1/assets/b3b3bdaf/ueditor/php/../../../../upload//20131222/bg26.jpg','<p><img src=\"/site1/assets/b3b3bdaf/ueditor/php/../../../../upload//20131222/bg26.jpg\"/></p>','2013-12-26 00:52:01','0','1387985197');INSERT INTO `information` VALUES ('10','2','1','好活动10','好活动10','/site1/assets/b3b3bdaf/ueditor/php/../../../../upload//20131222/bg26.jpg','<p><img src=\"/site1/assets/b3b3bdaf/ueditor/php/../../../../upload//20131222/bg26.jpg\"/></p>','2013-12-26 00:52:01','0','1387985197');DROP TABLE IF EXISTS `inforCategory`;
CREATE TABLE `inforCategory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_bin NOT NULL,
  `title` varchar(256) COLLATE utf8_bin NOT NULL,
  `sort` tinyint(3) NOT NULL DEFAULT '0' COMMENT '排序',
  `updateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleteFlag` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `recordTime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
INSERT INTO `inforCategory` VALUES ('1','资讯分类1','首先显示的资讯分类标题1','1','2013-12-26 00:11:04','0','1387987864');INSERT INTO `inforCategory` VALUES ('2','资讯分类2','资讯分类2','2','2013-12-26 00:41:48','0','1387989708');INSERT INTO `inforCategory` VALUES ('3','资讯分类3','资讯分类3','3','2013-12-26 00:42:02','0','1387989722');INSERT INTO `inforCategory` VALUES ('4','资讯分类4','资讯分类4','4','2013-12-26 00:42:14','0','1387989734');DROP TABLE IF EXISTS `link`;
CREATE TABLE `link` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_bin NOT NULL COMMENT '名称',
  `url` varchar(128) COLLATE utf8_bin NOT NULL COMMENT '外链',
  `sort` tinyint(3) NOT NULL DEFAULT '0' COMMENT '排序',
  `updateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleteFlag` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `recordTime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `url` (`url`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='导航外链';
INSERT INTO `link` VALUES ('1','测试','http://baidu.com','1','2014-01-24 21:30:56','0','1390570256');DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) COLLATE utf8_bin NOT NULL,
  `password` char(128) COLLATE utf8_bin NOT NULL,
  `ip` varchar(32) COLLATE utf8_bin NOT NULL,
  `updateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleteFlag` tinyint(3) NOT NULL DEFAULT '0' COMMENT '0 正常 1禁用',
  `recordTime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `ip` (`ip`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
INSERT INTO `user` VALUES ('1','test','d047038edabf6fd6b539f9ad78d88f3ae297652ac721c994a6678f63e963a0f91c99d692543ff0054656453b056cc1262998108ffa94644499eb3969b4254746','0','2014-01-23 20:52:05','0','1387376778');INSERT INTO `user` VALUES ('2','111111','40f551ea97fd67466d8c7d9ca0fcbda00a1349863e3c15bbc6e3b5a270a43d5e46766e83ae4efe748fe7c9b9d9a91b3a7e1570088195870a9c91085f0310bf59','::1','2014-01-23 20:53:33','0','1390481613');