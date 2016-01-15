-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2015-11-15 20:20:30
-- 服务器版本: 5.5.46-0ubuntu0.14.04.2
-- PHP 版本: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `cleanMine`
--

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `pwd` varchar(32) NOT NULL COMMENT '用户密码',
  `name` char(32) NOT NULL COMMENT '用户名',
  `cost_time` int(11) NOT NULL COMMENT '完成时间',
  `mine_num` int(11) NOT NULL COMMENT '地雷总数',
  `create_time` date NOT NULL COMMENT '创建记录时间',
  `register_time` datetime NOT NULL COMMENT '注册时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `pwd`, `name`, `cost_time`, `mine_num`, `create_time`, `register_time`) VALUES
(7, 'e10adc3949ba59abbe56e057f20f883e', 'chanran', 0, 0, '0000-00-00', '2015-11-15 00:00:00'),
(10, 'e10adc3949ba59abbe56e057f20f883e', '2', 3, 26, '0000-00-00', '2015-11-15 10:03:52'),
(11, '', 'blue', 0, 22, '2015-11-15', '0000-00-00 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
