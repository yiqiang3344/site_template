-- MySQL dump 10.13  Distrib 5.5.33, for osx10.6 (i386)
--
-- Host: 127.0.0.1    Database: site1
-- ------------------------------------------------------
-- Server version	5.5.33

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `activity`
--

DROP TABLE IF EXISTS `activity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(128) COLLATE utf8_bin NOT NULL,
  `abstract` varchar(256) COLLATE utf8_bin NOT NULL DEFAULT '',
  `hasPicture` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否有插图',
  `content` text COLLATE utf8_bin NOT NULL,
  `updateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleteFlag` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `recordTime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity`
--

LOCK TABLES `activity` WRITE;
/*!40000 ALTER TABLE `activity` DISABLE KEYS */;
INSERT INTO `activity` VALUES (1,'活动1','简介1',1,'<p>活动内容2asdfasdf</p>','2013-10-24 14:04:02',1,1382623405),(2,'活动1','简介1',0,'<p>活动内容1asdfa</p>','2013-10-24 14:04:02',1,1382623427),(3,'活动1','简介1',0,'<p>活动内容2</p>','2013-10-24 14:04:12',0,1382623452);
/*!40000 ALTER TABLE `activity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
INSERT INTO `comment` VALUES (1,1,1,'test','测试评论内容',5,1,2,3,1,1382542690),(2,1,1,'test','测试评论内容',5,1,2,3,1,1382542991),(3,1,1,'test','测试评论内容',5,1,2,3,1,1382543079),(4,1,1,'test','测试评论内容',5,1,2,3,1,1382543112),(5,1,1,'test','测试评论内容',5,1,2,3,1,1382543156),(6,1,1,'test','测试评论内容',5,1,2,3,1,1382543183),(7,1,1,'test','测试评论内容',5,1,2,3,1,1382543188),(8,1,1,'test','测试评论内容',5,1,2,3,1,1382543234),(9,1,1,'test','测试评论内容',5,1,2,3,1,1382543439),(10,1,1,'test','测试评论内容',5,1,2,3,1,1382543893),(11,1,1,'test','测试评论内容',5,1,2,3,0,1382543938),(12,1,1,'test','测试评论内容',5,1,2,3,0,1382543984),(13,1,1,'test','测试评论内容',5,1,2,3,0,1382543985);
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company`
--

DROP TABLE IF EXISTS `company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '类别',
  `name` varchar(32) COLLATE utf8_bin NOT NULL,
  `nameFirstLetter` char(1) COLLATE utf8_bin NOT NULL COMMENT '名字首字母',
  `weight` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '权重',
  `hasLogo` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '有无logo',
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
  `hasUrlPhoto` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '有无网站截图',
  `abstract` varchar(256) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '摘要',
  `description` text COLLATE utf8_bin NOT NULL COMMENT '描述',
  `updateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleteFlag` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `recordTime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company`
--

LOCK TABLES `company` WRITE;
/*!40000 ALTER TABLE `company` DISABLE KEYS */;
INSERT INTO `company` VALUES (1,'test','测再测试名字','C',2,0,0,1,0,0,0,0,1,'',0,'2013-10-22','',0,'','','2013-11-19 10:17:16',1,1382458594),(2,'test','再测试名字','Z',1,0,0,0,0,0,0,0,2,'',0,'2013-10-22','',0,'这是一个测试的东西哦。','','2013-11-19 10:17:16',1,1382458643),(5,'','再测试名字','Z',0,0,0,0,0,0,0,0,1,'',0,'2013-10-27','',0,'','','2013-11-19 10:17:16',1,1382883706),(6,'','再测试名字','Z',0,0,0,1,0,0,0,0,0,'',0,'2013-10-27','',0,'','','2013-11-19 10:17:00',1,1382883711),(7,'','再测试名字','Z',0,0,0,0,0,0,0,0,0,'',0,'2013-10-27','',0,'','','2013-11-19 10:17:00',1,1382883712),(8,'','test1','T',0,0,0,0,0,0,0,0,0,'',0,'2012-12-12','',0,'','','2013-11-19 10:17:16',1,1384784643),(9,'1111','test2','t',1,1,1,1,1,1,1,1,0,'1',1,'2011-11-11','1',1,'test','<p>asadsfasdf</p>','2013-11-19 10:16:49',1,1384788048),(10,'','111111','',0,0,0,0,0,0,0,0,0,'',0,'2012-12-12','',0,'','','2013-11-19 10:15:18',1,1384853695),(11,'','34343','',0,0,0,0,0,0,0,0,0,'',0,'2012-12-12','',0,'','','2013-11-19 10:16:25',1,1384853716);
/*!40000 ALTER TABLE `company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact`
--

DROP TABLE IF EXISTS `contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact`
--

LOCK TABLES `contact` WRITE;
/*!40000 ALTER TABLE `contact` DISABLE KEYS */;
INSERT INTO `contact` VALUES (1,'introduce','联系我们','<p>自我介绍内容111</p>',0,'2013-11-20 13:00:40',1,1382716598),(3,'introduc','公司简介','自我介绍内容',0,'2013-11-20 13:00:40',1,1382716756),(4,'joinUs','加入我们','<p>加入我们内容<img src=\"/site1/assets/b3b3bdaf/ueditor/php/../../../../upload/20131116/13845910836443.png\" title=\"text14.png\"/><img src=\"http://www.yiiframework.com/css/img/logo.png\" width=\"284\" height=\"64\"/></p>',4,'2013-11-20 13:00:40',1,1383055483),(5,'joinUs1','加入我们1','<p>加入我们内容</p>',0,'2013-11-20 13:00:40',1,1383056245),(6,'joinUs2','加入我们2','加入我们内容',0,'2013-11-20 13:00:40',1,1383056259),(7,'joinUs3','加入我们3','加入我们内容',0,'2013-11-20 13:00:40',1,1383056273),(8,'test1','test2','<p>testasdfasdf</p>',0,'2013-11-16 05:55:26',1,1384579498),(9,'111','111','<p>1111<br/></p>',1,'2013-11-20 13:01:29',0,1384952489);
/*!40000 ALTER TABLE `contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `information`
--

DROP TABLE IF EXISTS `information`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `information` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(128) COLLATE utf8_bin NOT NULL,
  `abstract` varchar(256) COLLATE utf8_bin NOT NULL DEFAULT '',
  `hasPicture` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否有插图',
  `content` text COLLATE utf8_bin NOT NULL,
  `updateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleteFlag` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `recordTime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `information`
--

LOCK TABLES `information` WRITE;
/*!40000 ALTER TABLE `information` DISABLE KEYS */;
INSERT INTO `information` VALUES (1,'资讯1','简介1',0,'资讯内容1','2013-10-24 14:00:13',1,1382622986),(2,'资讯2','简介1',1,'资讯内容1','2013-10-24 14:00:13',0,1382623027),(3,'资讯3','简介1',1,'资讯内容1','2013-11-19 11:50:19',0,1382623050),(4,'资讯4','简介1',1,'资讯内容1','2013-11-19 11:50:19',0,1382623073),(5,'资讯5','简介1',1,'资讯内容1','2013-11-19 11:50:19',1,1382623117),(6,'test','test',0,'<p>asdfsadfasdf</p><p>asdfa</p><p>sdfa</p><p>sdfas</p><p>df<img src=\"/site1/assets/b3b3bdaf/ueditor/php/../../../../upload//20131119/13848620467789.png\"/></p>','2013-11-19 11:56:36',0,1384862196);
/*!40000 ALTER TABLE `information` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `link`
--

DROP TABLE IF EXISTS `link`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='导航外链';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `link`
--

LOCK TABLES `link` WRITE;
/*!40000 ALTER TABLE `link` DISABLE KEYS */;
INSERT INTO `link` VALUES (1,'外链1','url',1,'2013-11-14 13:29:39',0,1382717030),(2,'外链2','url2',0,'2013-11-14 13:29:42',0,1382717050),(3,'111','222',0,'2013-11-14 12:43:23',1,1384432096),(4,'tet','test',0,'2013-11-14 12:43:17',1,1384432323),(5,'aaa','aaa',0,'2013-11-14 13:28:55',1,1384435727),(6,'fff','fff',0,'2013-11-14 13:29:08',1,1384435731),(7,'asdfasdfasd','asdfsdaf',0,'2013-11-14 13:29:08',1,1384435742),(8,'asdfsadf','asdfasdfadsf',0,'2013-11-14 13:29:25',1,1384435759),(9,'ttt','tttt',0,'2013-11-16 05:18:15',1,1384575661),(10,'asdfasdf','asdfasdf',0,'2013-11-16 05:18:20',0,1384579100),(11,'asdfsad','sadfasfd',0,'2013-11-16 05:43:21',0,1384580601);
/*!40000 ALTER TABLE `link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) COLLATE utf8_bin NOT NULL,
  `password` char(128) COLLATE utf8_bin NOT NULL,
  `ip` varchar(32) COLLATE utf8_bin NOT NULL,
  `updateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleteFlag` tinyint(3) NOT NULL DEFAULT '0',
  `recordTime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `ip` (`ip`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (9,'test','d047038edabf6fd6b539f9ad78d88f3ae297652ac721c994a6678f63e963a0f91c99d692543ff0054656453b056cc1262998108ffa94644499eb3969b4254746','::1','2013-11-21 14:01:20',0,1382970277);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-11-22 23:30:16
