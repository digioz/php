DROP TABLE IF EXISTS `test1`;
CREATE TABLE  `test1` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `column1` varchar(45) NOT NULL,
  `column2` varchar(45) NOT NULL,
  `column3` varchar(45) NOT NULL,
  `column4` varchar(45) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

INSERT INTO `test1` (`id`,`column1`,`column2`,`column3`,`column4`) VALUES 
 (1,'Row 1 Column 1','Row 1 Column 2','Row 1 Column 3','Row 1 Column 4'),
 (2,'Row 2 Column 1','Row 2 Column 2','Row 2 Column 3','Row 2 Column 4');