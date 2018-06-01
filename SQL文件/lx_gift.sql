SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS  `lx_gift`;
CREATE TABLE `lx_gift` (
  `gift` char(11) NOT NULL DEFAULT '' COMMENT '礼物\n',
  `gift_number` int(11) DEFAULT NULL COMMENT '礼物个数\n',
  PRIMARY KEY (`gift`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

insert into `lx_gift`(`gift`,`gift_number`) values
('A','2'),
('B','2'),
('C','100'),
('D','413'),
('E','905');
SET FOREIGN_KEY_CHECKS = 1;

