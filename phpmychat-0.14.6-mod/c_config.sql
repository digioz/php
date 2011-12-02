-- phpMyAdmin SQL Dump
-- version 2.6.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Oct 12, 2005 at 02:26 PM
-- Server version: 4.0.24
-- PHP Version: 4.3.11
-- 
-- Database: `chat`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `c_config`
-- 

CREATE TABLE `c_config` (
  `ID` tinyint(4) NOT NULL default '0',
  `MSG_DEL` tinyint(4) NOT NULL default '0',
  `USR_DEL` tinyint(4) NOT NULL default '0',
  `REG_DEL` tinyint(4) NOT NULL default '0',
  `LANGUAGE` varchar(15) NOT NULL default '',
  `MULTI_LANG` tinyint(4) NOT NULL default '0',
  `REQUIRE_REGISTER` tinyint(4) NOT NULL default '0',
  `EMAIL_PASWD` tinyint(4) NOT NULL default '0',
  `SHOW_ADMIN` tinyint(4) NOT NULL default '0',
  `SHOW_DEL_PROF` tinyint(4) NOT NULL default '0',
  `VERSION` tinyint(4) NOT NULL default '0',
  `BANISH` tinyint(4) NOT NULL default '0',
  `NO_SWEAR` tinyint(4) NOT NULL default '0',
  `SAVE` varchar(5) NOT NULL default '',
  `USE_SMILIES` tinyint(4) NOT NULL default '0',
  `HTML_TAGS_KEEP` varchar(10) NOT NULL default '',
  `HTML_TAGS_SHOW` tinyint(4) NOT NULL default '0',
  `TMZ_OFFSET` tinyint(4) NOT NULL default '0',
  `MSG_ORDER` tinyint(4) NOT NULL default '0',
  `MSG_NB` tinyint(4) NOT NULL default '0',
  `MSG_REFRESH` tinyint(4) NOT NULL default '0',
  `SHOW_TIMESTAMP` tinyint(4) NOT NULL default '0',
  `NOTIFY` tinyint(4) NOT NULL default '0',
  `WELCOME` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

-- 
-- Dumping data for table `c_config`
-- 

INSERT INTO `c_config` (`ID`, `MSG_DEL`, `USR_DEL`, `REG_DEL`, `LANGUAGE`, `MULTI_LANG`, `REQUIRE_REGISTER`, `EMAIL_PASWD`, `SHOW_ADMIN`, `SHOW_DEL_PROF`, `VERSION`, `BANISH`, `NO_SWEAR`, `SAVE`, `USE_SMILIES`, `HTML_TAGS_KEEP`, `HTML_TAGS_SHOW`, `TMZ_OFFSET`, `MSG_ORDER`, `MSG_NB`, `MSG_REFRESH`, `SHOW_TIMESTAMP`, `NOTIFY`, `WELCOME`) VALUES (0, 12, 5, 0, 'english', 1, 0, 0, 0, 1, 2, 0, 0, '*', 1, 'simple', 1, 0, 0, 20, 10, 0, 1, 0);
