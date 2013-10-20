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

CREATE TABLE admin (
     `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '',
     `username` varchar(32) UNIQUE NOT NULL COMMENT '',
     `password` char(128) NOT NULL COMMENT '',
     `updateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
     `recordTime` int(10) UNSIGNED NOT NULL COMMENT '',
     PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='' AUTO_INCREMENT=1 ;
insert into admin(username,password,recordTime) values('admin','eb3ccf0a7c36c8723ba9f34851048baea1299b21ec691b4c9a14ea39f35912b9f5afe5cec9244f5814fe43dda494829f84ccbd4e207531dd26ca0e6627cf1f14',unix_timestamp());