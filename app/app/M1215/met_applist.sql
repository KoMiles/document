-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 09 月 23 日 13:53
-- 服务器版本: 5.5.20
-- PHP 版本: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `metinfo`
--

-- --------------------------------------------------------

--
-- 表的结构 `met_applist`
--

CREATE TABLE IF NOT EXISTS `met_applist` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID主键',
  `no` int(11) NOT NULL COMMENT '应用编号',
  `ver` varchar(50) NOT NULL COMMENT '应用版本',
  `m_name` varchar(50) NOT NULL COMMENT '应用系统名称',
  `m_class` varchar(50) NOT NULL COMMENT '默认控制器',
  `m_action` varchar(50) NOT NULL COMMENT '默认事件',
  `appname` varchar(50) NOT NULL COMMENT '应用名称',
  `info` text NOT NULL COMMENT '应用描述',
  `addtime` int(11) NOT NULL COMMENT '发布时间',
  `updateime` int(11) NOT NULL COMMENT '最近更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `met_applist`
--

INSERT INTO `met_applist` (`id`, `no`, `ver`, `m_name`, `m_class`, `m_action`, `appname`, `info`, `addtime`, `updateime`) VALUES
(3, 1215, '1.0', 'M1215', 'M1215', 'doindex', 'M1215', '序号1215制作的应用', 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
