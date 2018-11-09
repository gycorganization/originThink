/*
MySQL Backup
Database: tp5.1
Backup Time: 2018-11-09 18:14:35
*/

SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS `tp5.1`.`think_article`;
DROP TABLE IF EXISTS `tp5.1`.`think_auth_group`;
DROP TABLE IF EXISTS `tp5.1`.`think_auth_group_access`;
DROP TABLE IF EXISTS `tp5.1`.`think_auth_rule`;
DROP TABLE IF EXISTS `tp5.1`.`think_config`;
DROP TABLE IF EXISTS `tp5.1`.`think_login_log`;
DROP TABLE IF EXISTS `tp5.1`.`think_user`;
CREATE TABLE `think_article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT '文章标题',
  `desc` varchar(255) NOT NULL COMMENT '简介',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '分类',
  `img` varchar(255) NOT NULL COMMENT '图片',
  `content` text NOT NULL COMMENT '内容',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
CREATE TABLE `think_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` char(100) NOT NULL DEFAULT '' COMMENT '用户组中文名称',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：为1正常，为0禁用',
  `rules` char(80) NOT NULL DEFAULT '' COMMENT '用户组拥有的规则id， 多个规则","隔开',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
CREATE TABLE `think_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL COMMENT '用户id',
  `group_id` mediumint(8) unsigned NOT NULL COMMENT '用户组id',
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `think_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` char(80) NOT NULL DEFAULT '' COMMENT '规则唯一标识',
  `title` char(20) NOT NULL DEFAULT '' COMMENT '规则中文名称',
  `pid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '父级ID',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：为1正常，为0禁用',
  `condition` char(100) NOT NULL DEFAULT '' COMMENT '规则表达式，为空表示存在就验证，不为空表示按照条件验证',
  `menu` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否是菜单；0:否，1:是',
  `icon` varchar(255) DEFAULT NULL COMMENT '菜单图标',
  `sort` int(11) unsigned NOT NULL DEFAULT '1' COMMENT '排序',
  PRIMARY KEY (`id`),
  KEY `name` (`name`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
CREATE TABLE `think_config` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(255) NOT NULL COMMENT '配置字段名',
  `title` varchar(255) NOT NULL COMMENT '配置标题名称',
  `value` json NOT NULL COMMENT '配置参数',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
CREATE TABLE `think_login_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uid` int(11) unsigned NOT NULL COMMENT '用户id',
  `user` varchar(255) NOT NULL COMMENT '账号',
  `name` varchar(255) NOT NULL COMMENT '用户名',
  `last_login_ip` varchar(32) NOT NULL COMMENT '登录ip',
  `create_time` int(11) unsigned NOT NULL COMMENT '登录时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
CREATE TABLE `think_user` (
  `uid` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `user` varchar(32) NOT NULL COMMENT '账号',
  `name` varchar(255) NOT NULL COMMENT '用户名',
  `head` varchar(255) DEFAULT NULL COMMENT '头像',
  `password` varchar(255) NOT NULL COMMENT '密码',
  `login_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  `last_login_ip` varchar(32) NOT NULL DEFAULT '0.0.0.0' COMMENT '最后登录ip地址',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否禁用；0: 禁用 1:正常',
  `updatapassword` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `user_unique` (`user`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
BEGIN;
LOCK TABLES `tp5.1`.`think_article` WRITE;
DELETE FROM `tp5.1`.`think_article`;
INSERT INTO `tp5.1`.`think_article` (`id`,`title`,`desc`,`type`,`img`,`content`,`status`,`create_time`,`update_time`) VALUES (1, '测试', '测试', 1, '', '测试', 1, 0, 0),(2, '请问', '请问', 0, '', '请问', 0, 0, 0);
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `tp5.1`.`think_auth_group` WRITE;
DELETE FROM `tp5.1`.`think_auth_group`;
INSERT INTO `tp5.1`.`think_auth_group` (`id`,`title`,`status`,`rules`,`create_time`,`update_time`) VALUES (1, '管理员组', 1, '1,2,3,4,5,6,8,9,10', 0, 1494407780),(2, '普通用户组', 1, '1,2,3,4,10,13,14,18,19', 0, 1494308736);
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `tp5.1`.`think_auth_group_access` WRITE;
DELETE FROM `tp5.1`.`think_auth_group_access`;
INSERT INTO `tp5.1`.`think_auth_group_access` (`uid`,`group_id`) VALUES (1, 1),(2, 2);
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `tp5.1`.`think_auth_rule` WRITE;
DELETE FROM `tp5.1`.`think_auth_rule`;
INSERT INTO `tp5.1`.`think_auth_rule` (`id`,`name`,`title`,`pid`,`type`,`status`,`condition`,`menu`,`icon`,`sort`) VALUES (1, '#', '首页', 0, 1, 1, '', 1, 'fa fa-home', 1),(2, '#', '用户管理', 0, 1, 1, '', 1, 'fa fa-user', 1),(3, 'admin/userList', '用户列表', 2, 1, 1, '', 1, NULL, 1),(4, 'admin/groupList', '用户组列表', 2, 1, 1, '', 1, NULL, 1),(5, 'admin/edit', '添加用户', 2, 1, 1, '', 0, '', 1),(6, '#', '系统管理', 0, 1, 1, '', 1, 'fa fa-cog', 1),(7, 'admin/cleanCache', '清除缓存', 6, 1, 1, '', 1, '', 1),(8, 'admin/menu', '菜单管理', 6, 1, 1, '', 1, '', 1),(9, 'admin/home', '系统信息', 1, 1, 1, '', 1, '', 1),(10, 'admin/log', '日志管理', 6, 1, 1, '', 1, '', 1),(11, 'admin/editMenu', '编辑菜单', 6, 1, 1, '', 0, '', 1),(12, 'admin/deleteMenu', '删除菜单', 6, 1, 1, '', 0, '', 1),(13, 'admin/config', '系统配置', 6, 1, 1, '', 1, '', 1),(14, 'admin/siteConfig', '站点配置', 6, 1, 1, '', 1, '', 1),(15, '#', '文章管理', 0, 1, 1, '', 1, '', 1),(16, 'admin/blog', '文章列表', 15, 1, 1, '', 1, '', 1),(17, 'admin/addBlog', '添加文章', 15, 1, 1, '', 1, '', 1);
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `tp5.1`.`think_config` WRITE;
DELETE FROM `tp5.1`.`think_config`;
INSERT INTO `tp5.1`.`think_config` (`id`,`name`,`title`,`value`,`status`,`create_time`,`update_time`) VALUES (1, 'system_config', '系统配置', '{\"debug\": \"0\", \"trace\": \"0\", \"trace_type\": \"0\"}', 0, 1523414007, 1531729547),(2, 'site_config', '站点配置', '{\"icp\": \"苏ICP备17056337号\", \"name\": \"tpswoole\", \"title\": \"tpswoole\", \"copyright\": \"copyright @2018 原点\"}', 1, 1523414007, 1536478335);
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `tp5.1`.`think_login_log` WRITE;
DELETE FROM `tp5.1`.`think_login_log`;
INSERT INTO `tp5.1`.`think_login_log` (`id`,`uid`,`user`,`name`,`last_login_ip`,`create_time`) VALUES (1, 1, 'admin', 'admin', '127.0.0.1', 1541746960);
UNLOCK TABLES;
COMMIT;
BEGIN;
LOCK TABLES `tp5.1`.`think_user` WRITE;
DELETE FROM `tp5.1`.`think_user`;
INSERT INTO `tp5.1`.`think_user` (`uid`,`user`,`name`,`head`,`password`,`login_count`,`last_login_ip`,`last_login_time`,`status`,`updatapassword`,`create_time`,`update_time`) VALUES (1, 'admin', 'admin', NULL, '$2y$10$HLh4UHoluqLvwsNN6vQxz.tuKMA5xYp6rH2vOpA.74sxiQbjwm2My', 88, '127.0.0.1', 1541746960, 1, 1, 0, 1541746960),(2, 'admin1', 'admin1', NULL, '$2y$10$HLh4UHoluqLvwsNN6vQxz.tuKMA5xYp6rH2vOpA.74sxiQbjwm2My', 13, '127.0.0.1', 1535891091, 1, 1, 0, 1535891091);
UNLOCK TABLES;
COMMIT;
