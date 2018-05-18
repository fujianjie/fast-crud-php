-- phpMyAdmin SQL Dump
-- version 4.4.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2018-05-18 09:23:22
-- 服务器版本： 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `fastcrud`
--

-- --------------------------------------------------------

--
-- 表的结构 `we_access`
--

CREATE TABLE IF NOT EXISTS `we_access` (
  `id` int(7) NOT NULL,
  `name` varchar(50) NOT NULL,
  `keyset` varchar(50) NOT NULL,
  `isDelete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除'
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `we_access`
--

INSERT INTO `we_access` (`id`, `name`, `keyset`, `isDelete`) VALUES
(1, '用户管理查看', 'userManagementview', 0),
(2, '全局用户管理查看', 'TotalUserview', 0),
(3, '全局用户管理编辑', 'TotalUseropt', 0),
(4, '用户管理编辑', 'userManagementopt', 0),
(5, '用户管理删除', 'userManagementdel', 0),
(6, '全局用户管理删除', 'TotalUserdel', 0),
(7, '导航栏管理', 'navview', 0),
(8, '导航栏编辑', 'navopt', 0),
(9, '导航栏删除', 'navdel', 0),
(10, '权限管理', 'accessview', 0),
(11, '权限编辑', 'accessopt', 0),
(12, '权限删除', 'accessdel', 0),
(13, '用户组管理', 'usergroupview', 0),
(14, '用户组编辑', 'usergroupopt', 0),
(15, '用户组删除', 'usergroupdel', 0),
(16, '系统配置查看', 'SystemSettingview', 0),
(17, '系统配置编辑', 'SystemSettingopt', 0),
(18, '系统配置删除', 'SystemSettingdel', 0),
(19, '文件存储信息查看', 'Filesview', 0),
(20, '文件存储信息编辑', 'Filesopt', 0),
(21, '文件存储信息删除', 'Filesdel', 0),
(22, '系统日志查看', 'Logview', 0),
(23, '系统日志编辑', 'Logopt', 0),
(24, '系统日志删除', 'Logdel', 0),
(25, '操作历史查看', 'OperationHistoryview', 0),
(26, '操作历史编辑', 'OperationHistoryopt', 0),
(27, '操作历史删除', 'OperationHistorydel', 0);

-- --------------------------------------------------------

--
-- 表的结构 `we_files`
--

CREATE TABLE IF NOT EXISTS `we_files` (
  `id` int(7) NOT NULL,
  `date` date NOT NULL COMMENT '日期',
  `filename` varchar(200) NOT NULL COMMENT '文件名',
  `addTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '添加时间',
  `uid` int(7) NOT NULL COMMENT '用户',
  `cid` int(7) NOT NULL COMMENT '公司',
  `sourcename` varchar(100) NOT NULL COMMENT '原文件名',
  `isDelete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `we_group`
--

CREATE TABLE IF NOT EXISTS `we_group` (
  `id` int(7) NOT NULL,
  `name` varchar(50) NOT NULL COMMENT '名称',
  `access` text NOT NULL,
  `keyname` varchar(50) NOT NULL,
  `cid` int(7) NOT NULL,
  `isDelete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除'
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `we_group`
--

INSERT INTO `we_group` (`id`, `name`, `access`, `keyname`, `cid`, `isDelete`) VALUES
(1, '超级管理员', 'root', 'root', 0, 0),
(2, '管理员', 'userManagementview,userManagementopt,userManagementdel,usergroupview,usergroupopt,usergroupdel', '', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `we_log`
--

CREATE TABLE IF NOT EXISTS `we_log` (
  `id` int(7) NOT NULL,
  `uid` int(7) NOT NULL COMMENT '用户',
  `addTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '操作时间',
  `classAndMethod` varchar(100) NOT NULL COMMENT '页面',
  `actionName` varchar(100) NOT NULL COMMENT '操作内容',
  `paramsData` text NOT NULL COMMENT '参数',
  `ip` varchar(100) NOT NULL COMMENT 'IP地址',
  `html` text NOT NULL COMMENT '页面显示内容',
  `isDelete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除',
  `realname` varchar(50) NOT NULL COMMENT '姓名',
  `keyParam` varchar(50) NOT NULL COMMENT '特殊关键字',
  `mobile` varchar(20) NOT NULL COMMENT '手机号码'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `we_nav`
--

CREATE TABLE IF NOT EXISTS `we_nav` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `iconClass` varchar(50) NOT NULL COMMENT '导航图标',
  `url` varchar(100) NOT NULL,
  `access` varchar(50) NOT NULL,
  `pid` int(7) NOT NULL COMMENT '上级nav ID',
  `sort` int(7) NOT NULL DEFAULT '0' COMMENT '排序',
  `isDelete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除'
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `we_nav`
--

INSERT INTO `we_nav` (`id`, `name`, `iconClass`, `url`, `access`, `pid`, `sort`, `isDelete`) VALUES
(1, '系统管理', 'fa fa-server', '', '', 0, 10, 0),
(2, '导航栏管理', '', 'nav/index', 'navview', 1, 0, 0),
(3, '权限管理', '', 'access', 'accessview', 1, 0, 0),
(4, 'ORM', '', 'orm', 'orm', 1, 0, 0),
(5, '系统配置', '', 'SystemSetting/index', 'SystemSettingview', 1, 0, 0),
(7, '文件存储信息', '', 'Files/index', 'Filesview', 1, 0, 0),
(8, '系统日志', '', 'Log/index', 'Logview', 1, 0, 0),
(9, '操作历史', '', 'OperationHistory/index', 'OperationHistoryview', 1, 0, 0),
(10, '后台用户中心', 'fa fa-user-o', '', '', 0, 93, 0),
(11, '用户管理', '', 'userManagement/index', 'userManagementview', 10, 0, 0),
(13, '角色管理', '', 'userGroup/index', 'usergroupview', 10, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `we_operation_history`
--

CREATE TABLE IF NOT EXISTS `we_operation_history` (
  `id` int(7) NOT NULL,
  `controllerName` varchar(100) NOT NULL COMMENT '模块名称',
  `uid` int(7) NOT NULL COMMENT '用户',
  `realname` varchar(100) NOT NULL COMMENT '姓名',
  `addTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '操作时间',
  `actionInfo` varchar(100) NOT NULL COMMENT '操作内容',
  `backup` text NOT NULL COMMENT '备注',
  `dataId` int(7) NOT NULL COMMENT '数据id',
  `isDelete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='操作历史';

-- --------------------------------------------------------

--
-- 表的结构 `we_sessions`
--

CREATE TABLE IF NOT EXISTS `we_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  `isDelete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `we_systemconfig`
--

CREATE TABLE IF NOT EXISTS `we_systemconfig` (
  `id` mediumint(4) NOT NULL,
  `name` varchar(50) NOT NULL COMMENT '字段名称',
  `type` varchar(20) NOT NULL COMMENT '字段填充类型',
  `content` text NOT NULL COMMENT '字段内容',
  `select` text NOT NULL COMMENT '选择框数据',
  `comments` varchar(100) NOT NULL COMMENT '注释',
  `sort` mediumint(4) DEFAULT NULL COMMENT '排序',
  `basic` smallint(1) NOT NULL DEFAULT '0' COMMENT '必须',
  `isDelete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除'
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `we_systemconfig`
--

INSERT INTO `we_systemconfig` (`id`, `name`, `type`, `content`, `select`, `comments`, `sort`, `basic`, `isDelete`) VALUES
(1, 'base_url', 'middleText', 'fastcrud.we-ideas.com', '', '网址', 1, 1, 0),
(2, 'staticurl', 'text', '', '', '静态资源路径', 2, 1, 0),
(3, 'sitename', 'text', 'FASTCRUD管理系统', '', '网站名称', 3, 1, 0),
(4, 'sitekeywords', 'text', 'FASTCRUD管理系统', '', '网站keywords', 4, 1, 0),
(5, 'sitedesc', 'text', 'FASTCRUD管理系统', '', '网站Description', 5, 1, 0),
(6, 'resetPassword', 'bool', 'TRUE', '', '首登修改密码', 6, 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `we_user`
--

CREATE TABLE IF NOT EXISTS `we_user` (
  `id` int(11) NOT NULL COMMENT '用户ID',
  `account` varchar(50) NOT NULL COMMENT '用户帐号',
  `password` varchar(256) NOT NULL COMMENT '用户密码',
  `realname` varchar(100) NOT NULL COMMENT '姓名',
  `email` varchar(30) NOT NULL COMMENT '邮箱',
  `mobile` varchar(20) NOT NULL COMMENT '手机',
  `status` tinyint(4) NOT NULL COMMENT '状态',
  `uuid` varchar(50) NOT NULL,
  `group` int(11) NOT NULL COMMENT '用户组',
  `hasChange` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否修改过密码',
  `isDelete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `we_access`
--
ALTER TABLE `we_access`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `we_files`
--
ALTER TABLE `we_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `filename` (`filename`);

--
-- Indexes for table `we_group`
--
ALTER TABLE `we_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `we_log`
--
ALTER TABLE `we_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `classAndMethod` (`classAndMethod`);

--
-- Indexes for table `we_nav`
--
ALTER TABLE `we_nav`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `we_operation_history`
--
ALTER TABLE `we_operation_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `controllerName` (`controllerName`);

--
-- Indexes for table `we_sessions`
--
ALTER TABLE `we_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `we_systemconfig`
--
ALTER TABLE `we_systemconfig`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `we_user`
--
ALTER TABLE `we_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD UNIQUE KEY `account` (`account`),
  ADD UNIQUE KEY `mobile` (`mobile`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `we_access`
--
ALTER TABLE `we_access`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `we_files`
--
ALTER TABLE `we_files`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `we_group`
--
ALTER TABLE `we_group`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `we_log`
--
ALTER TABLE `we_log`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `we_nav`
--
ALTER TABLE `we_nav`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `we_operation_history`
--
ALTER TABLE `we_operation_history`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `we_systemconfig`
--
ALTER TABLE `we_systemconfig`
  MODIFY `id` mediumint(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `we_user`
--
ALTER TABLE `we_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID';
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
