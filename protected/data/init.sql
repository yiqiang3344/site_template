CREATE TABLE `YiiSession` (  
  `id` char(32) NOT NULL,  
  `expire` int(11) default NULL,  
  `data` text,  
  PRIMARY KEY  (`id`),  
  KEY `expire` (`expire`)  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;  

CREATE TABLE user (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '',
    `username` varchar(32) UNIQUE NOT NULL COMMENT '',
    `password` char(128) NOT NULL COMMENT '',
    `ip` varchar(32) UNIQUE NOT NULL COMMENT '',
    `updateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
    `recordTime` int(10) UNSIGNED NOT NULL COMMENT '',
    PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='' AUTO_INCREMENT=1 ;
