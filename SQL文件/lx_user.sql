SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS  `lx_user`;
CREATE TABLE `lx_user` (
  `phone` char(12) NOT NULL DEFAULT '0',
  `name` varchar(12) DEFAULT 'XXX',
  `sex` int(6) DEFAULT '0',
  `draw_number` int(6) DEFAULT '1',
  `draw_time` varchar(92) DEFAULT '',
  `gifts` varchar(20) DEFAULT '',
  `home` varchar(94) DEFAULT NULL,
  PRIMARY KEY (`phone`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

insert into `lx_user`(`phone`,`name`,`sex`,`draw_number`,`draw_time`,`gifts`,`home`) values
('18911111111','98','1','11212','___01-22.11:16  ___01-22.11:15  ___01-22.11:15  ___01-22.11:15  ___01-22.10:39  ___01-22.10:',' D E D D E E E E E E','山西省朔州市98'),
('18922222222','XXX','2','0','___01-25.00:22  ',' E',null),
('18982497320',null,'2','1',null,null,null);
SET FOREIGN_KEY_CHECKS = 1;

