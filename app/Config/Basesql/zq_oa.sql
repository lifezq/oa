/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50524
Source Host           : localhost:3306
Source Database       : zq_oa

Target Server Type    : MYSQL
Target Server Version : 50524
File Encoding         : 65001

Date: 2013-10-25 16:53:55
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `oa_address_book`
-- ----------------------------
DROP TABLE IF EXISTS `oa_address_book`;
CREATE TABLE `oa_address_book` (
  `a_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'address book id',
  `a_uid` int(11) NOT NULL COMMENT '通讯薄所有人ID',
  `a_username` varchar(15) NOT NULL COMMENT '联系人姓名',
  `a_spellname` varchar(20) NOT NULL DEFAULT '' COMMENT '姓名拼音',
  `a_company` varchar(30) NOT NULL DEFAULT '' COMMENT '所在公司',
  `a_mobile` int(11) NOT NULL DEFAULT '0' COMMENT '手机号',
  `a_telephone` varchar(15) NOT NULL DEFAULT '' COMMENT '固定电话',
  `a_faxaphone` varchar(15) NOT NULL DEFAULT '' COMMENT '传真电话',
  `a_address` varchar(50) NOT NULL DEFAULT '' COMMENT '住址',
  `a_qq` int(11) NOT NULL DEFAULT '0' COMMENT 'qq',
  `a_email` varchar(30) NOT NULL DEFAULT '' COMMENT '邮箱',
  `a_remark` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',
  `created` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`a_id`),
  KEY `au` (`a_uid`),
  KEY `un` (`a_username`),
  KEY `as` (`a_spellname`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_address_book
-- ----------------------------
INSERT INTO `oa_address_book` VALUES ('1', '4', '杨乾磊', 'yangqianlei', '北京乐思点', '2147483647', '010-6616688', '010-6616688', '北京昌平', '365755151', 'lifezqy@126.com', '备注111', '1377752367');
INSERT INTO `oa_address_book` VALUES ('2', '4', '测试联系', 'ceshilianxiren', '测试联系人公司', '2147483647', '010-6616688', '010-6616688', 'dddddddddddddd', '41234568', 'lifezq@126.com', '测试人备注', '1377755575');

-- ----------------------------
-- Table structure for `oa_album`
-- ----------------------------
DROP TABLE IF EXISTS `oa_album`;
CREATE TABLE `oa_album` (
  `a_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'a_id',
  `a_name` varchar(15) NOT NULL COMMENT '相册名称',
  `a_picture_nums` int(11) NOT NULL DEFAULT '0' COMMENT '相册内相片数量',
  `a_cover_image` varchar(100) NOT NULL DEFAULT '' COMMENT '封面图片路径',
  `a_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否启用，1为启用，0为关闭',
  `a_add_time` int(11) NOT NULL COMMENT '相册创建时间',
  PRIMARY KEY (`a_id`),
  KEY `apn` (`a_picture_nums`),
  KEY `as` (`a_status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_album
-- ----------------------------

-- ----------------------------
-- Table structure for `oa_announcement`
-- ----------------------------
DROP TABLE IF EXISTS `oa_announcement`;
CREATE TABLE `oa_announcement` (
  `a_id` int(11) NOT NULL AUTO_INCREMENT,
  `a_title` varchar(50) NOT NULL DEFAULT '' COMMENT '公告标题',
  `a_content` varchar(600) NOT NULL DEFAULT '' COMMENT '公告内容',
  `a_uid` int(11) NOT NULL COMMENT '发出人ID',
  `a_author` varchar(30) NOT NULL DEFAULT '' COMMENT '发布人',
  `a_level` tinyint(1) NOT NULL DEFAULT '0' COMMENT '公告级别，0为普通，1为紧急',
  `created` int(11) NOT NULL DEFAULT '0' COMMENT '发布时间',
  `a_company_id` smallint(5) NOT NULL DEFAULT '0' COMMENT '公告所属公司ID',
  PRIMARY KEY (`a_id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_announcement
-- ----------------------------
INSERT INTO `oa_announcement` VALUES ('17', '最新公告，各部门接收下', '最新公告，各部门接收下最新公告，各部门接收下最新公告，各部门接收下', '4', '杨乾磊', '0', '1377949316', '0');
INSERT INTO `oa_announcement` VALUES ('18', '最新公告，各部门接收下', '最新公告，各部门接收下最新公告，各部门接收下最新公告，各部门接收下', '4', '杨乾磊', '0', '1377949367', '0');
INSERT INTO `oa_announcement` VALUES ('19', '最新公告，各部门接收下', '最新公告，各部门接收下最新公告，各部门接收下最新公告，各部门接收下', '4', '杨乾磊', '0', '1377949510', '0');
INSERT INTO `oa_announcement` VALUES ('20', '最新公告，各部门接收下', '最新公告，各部门接收下最新公告，各部门接收下最新公告，各部门接收下', '4', '杨乾磊', '0', '1377949565', '0');
INSERT INTO `oa_announcement` VALUES ('21', 'newnew最新公告，各部门接收下', 'newnewnewnewnewnew 最新公告，各部门接收下最新公告，各部门接收下最新公告，各部门接收下', '4', '杨乾磊', '1', '1377949592', '0');
INSERT INTO `oa_announcement` VALUES ('22', '22最新公告，各部门接收下', '22最新公告，各部门接收下22最新公告，各部门接收下', '4', '杨乾磊', '0', '1377954761', '0');
INSERT INTO `oa_announcement` VALUES ('16', '测试公告测试公告', '测试公告测试公告测试公告测试公告', '4', '杨乾磊', '1', '1377872787', '0');
INSERT INTO `oa_announcement` VALUES ('13', '测试公告测试公告', '测试公告测试公告测试公告测试公告', '4', '杨乾磊', '0', '1377872026', '0');
INSERT INTO `oa_announcement` VALUES ('31', '111最新公告，各部门接收下', '111最新公告，各部门接收下111最新公告，各部门接收下111最新公告，各部门接收下', '4', '杨乾磊', '0', '1377955541', '0');
INSERT INTO `oa_announcement` VALUES ('37', 'fffffffffff555最新公告，各部门接收下', '555最新公告，各部门接收下555最新公告，各部门接收下555最新公告，各部ffffffff门接收下', '4', '杨乾磊', '1', '1377955810', '0');
INSERT INTO `oa_announcement` VALUES ('38', '222222222111111111newnew8888最新公告，各部门接收下', 'newnew 888最新公告，各部门接收下888最新公告，各部门接收22222下888最新公告，各部门接收下', '4', '杨乾磊', '1', '1377955931', '0');
INSERT INTO `oa_announcement` VALUES ('42', '最新的公告测试最新的公告测试', '最新的公告测试最新的公告测试最新的公告测试最新的公告测试最新的公告测试', '4', '杨乾磊', '1', '1378008628', '0');

-- ----------------------------
-- Table structure for `oa_assignments`
-- ----------------------------
DROP TABLE IF EXISTS `oa_assignments`;
CREATE TABLE `oa_assignments` (
  `a_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '任务ID',
  `a_users` varchar(200) NOT NULL DEFAULT '' COMMENT '接受该任务的所有员工，员工ID记录在表oa_assignment_uid',
  `com_id` smallint(5) NOT NULL DEFAULT '0' COMMENT '公司ID',
  `a_class` tinyint(3) NOT NULL DEFAULT '0' COMMENT '任务所属部门ID',
  `a_task` text NOT NULL COMMENT '任务内容',
  `a_status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '任务状态，0待完成，2正在进行，1完成',
  `a_use_time` int(11) NOT NULL COMMENT '计划任务用时，单位小时',
  `a_complete_time` int(11) NOT NULL COMMENT '实际任务完成用时，单位小时',
  `a_remark` varchar(200) NOT NULL DEFAULT '' COMMENT '任务备注',
  `a_make_uid` int(11) NOT NULL COMMENT '下达任务领导ID',
  `created` int(11) NOT NULL DEFAULT '0' COMMENT '任务下达时间',
  PRIMARY KEY (`a_id`),
  KEY `as` (`a_status`),
  KEY `amu` (`a_make_uid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_assignments
-- ----------------------------
INSERT INTO `oa_assignments` VALUES ('1', '札幌', '0', '9', '<p>沙沙沙沙沙沙沙沙沙沙</p>', '0', '0', '0', '0', '0', '1379830034');
INSERT INTO `oa_assignments` VALUES ('2', '札幌,测试帐号', '0', '9', '<p>木木木木木木木木棒大厦大厦大厦磊</p>', '0', '2', '0', '0', '0', '1379830424');
INSERT INTO `oa_assignments` VALUES ('3', '杨乾磊,测试帐号', '0', '8', '<p>白白白白白白白的</p>', '0', '3', '0', '0', '4', '1379830779');
INSERT INTO `oa_assignments` VALUES ('4', '杨乾磊,测试帐号', '0', '8', '<p>fffffffffffffff王王王王王王一天大厦大厦大厦大厦大厦大厦在目目止</p>', '0', '4', '0', '0', '4', '1379832197');
INSERT INTO `oa_assignments` VALUES ('5', '杨乾磊,测试帐号', '0', '8', '<p>王王王王王王王目目目目目目目目上</p>', '0', '4', '0', '0', '4', '1379832220');
INSERT INTO `oa_assignments` VALUES ('6', '杨乾磊,测试帐号', '0', '8', '<p>大厦大厦大厦大厦大厦大厦磊</p>', '0', '4', '0', '0', '4', '1379832349');
INSERT INTO `oa_assignments` VALUES ('7', '札幌,测试帐号', '1', '9', '<p>dddddddddddddddd土土土土土雪女女女女女女女女妇</p>', '0', '5', '0', 'tliy备注  努力，加油！', '4', '1379833945');

-- ----------------------------
-- Table structure for `oa_assignment_uids`
-- ----------------------------
DROP TABLE IF EXISTS `oa_assignment_uids`;
CREATE TABLE `oa_assignment_uids` (
  `a_id` int(11) NOT NULL COMMENT '任务ID',
  `u_id` int(11) NOT NULL COMMENT '用户ID',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '任务状态，0待完成，2正在进行，1完成'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_assignment_uids
-- ----------------------------
INSERT INTO `oa_assignment_uids` VALUES ('2', '10', '0');
INSERT INTO `oa_assignment_uids` VALUES ('2', '11', '0');
INSERT INTO `oa_assignment_uids` VALUES ('3', '4', '0');
INSERT INTO `oa_assignment_uids` VALUES ('3', '12', '0');
INSERT INTO `oa_assignment_uids` VALUES ('4', '4', '0');
INSERT INTO `oa_assignment_uids` VALUES ('4', '12', '0');
INSERT INTO `oa_assignment_uids` VALUES ('5', '4', '0');
INSERT INTO `oa_assignment_uids` VALUES ('5', '12', '0');
INSERT INTO `oa_assignment_uids` VALUES ('6', '4', '0');
INSERT INTO `oa_assignment_uids` VALUES ('6', '12', '0');
INSERT INTO `oa_assignment_uids` VALUES ('0', '11', '0');
INSERT INTO `oa_assignment_uids` VALUES ('0', '10', '0');
INSERT INTO `oa_assignment_uids` VALUES ('0', '11', '0');
INSERT INTO `oa_assignment_uids` VALUES ('0', '10', '0');
INSERT INTO `oa_assignment_uids` VALUES ('7', '10', '0');
INSERT INTO `oa_assignment_uids` VALUES ('7', '11', '0');

-- ----------------------------
-- Table structure for `oa_cabinets`
-- ----------------------------
DROP TABLE IF EXISTS `oa_cabinets`;
CREATE TABLE `oa_cabinets` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'c_id',
  `c_uid` int(11) NOT NULL COMMENT 'uid',
  `c_username` varchar(30) NOT NULL DEFAULT '' COMMENT '文件所有者',
  `c_file_name` varchar(30) NOT NULL COMMENT '文件名',
  `c_file_size` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小，单位字节B',
  `c_file_path` varchar(100) NOT NULL COMMENT '文件保存路径',
  `created` int(11) NOT NULL DEFAULT '0' COMMENT '文件添加时间',
  PRIMARY KEY (`c_id`),
  KEY `cu` (`c_uid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_cabinets
-- ----------------------------
INSERT INTO `oa_cabinets` VALUES ('1', '4', '杨乾磊', 'ddddffg', '1938046', '/img/upload/images/20130905/5845228375ccc3af.zip', '1378367325');
INSERT INTO `oa_cabinets` VALUES ('2', '4', '杨乾磊', 'Winter.jpg', '105542', '/img/upload/images/20130905/161935228534bcd834.jpg', '1378374476');
INSERT INTO `oa_cabinets` VALUES ('3', '4', '杨乾磊', 'Winter.jpg', '105542', '/img/upload/images/20130905/278785228537846a4d.jpg', '1378374520');
INSERT INTO `oa_cabinets` VALUES ('4', '4', '杨乾磊', 'app.zip', '1938046', '/img/upload/images/20130905/8743522853a3dcc83.zip', '1378374564');
INSERT INTO `oa_cabinets` VALUES ('5', '4', '杨乾磊', 'app.zip', '1938046', '/img/upload/images/20130905/27067522855808832d.zip', '1378375040');

-- ----------------------------
-- Table structure for `oa_checking_in`
-- ----------------------------
DROP TABLE IF EXISTS `oa_checking_in`;
CREATE TABLE `oa_checking_in` (
  `ci_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '考勤ID',
  `ci_uid` int(11) NOT NULL COMMENT '用户 ID',
  `ci_january` char(255) NOT NULL DEFAULT '' COMMENT '一月',
  `ci_february` char(255) NOT NULL DEFAULT '' COMMENT '二月',
  `ci_march` char(255) NOT NULL DEFAULT '' COMMENT '三月',
  `ci_april` char(255) NOT NULL DEFAULT '' COMMENT '四月',
  `ci_may` char(255) NOT NULL DEFAULT '' COMMENT '五月',
  `ci_june` char(255) NOT NULL DEFAULT '' COMMENT '六月',
  `ci_july` char(255) NOT NULL DEFAULT '' COMMENT '七月',
  `ci_august` char(255) NOT NULL DEFAULT '' COMMENT '八月',
  `ci_september` char(255) NOT NULL DEFAULT '' COMMENT '九月',
  `ci_october` char(255) NOT NULL DEFAULT '' COMMENT '十月',
  `ci_november` char(255) NOT NULL DEFAULT '' COMMENT '十一月',
  `ci_december` char(255) NOT NULL DEFAULT '' COMMENT '十二月',
  `ci_year` char(255) NOT NULL DEFAULT '' COMMENT '年，如果对应用户该年没有考勤，则新生成',
  `ci_add_time` int(11) NOT NULL DEFAULT '0' COMMENT '考勤生成时间',
  PRIMARY KEY (`ci_id`),
  KEY `cu` (`ci_uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_checking_in
-- ----------------------------

-- ----------------------------
-- Table structure for `oa_class_announcements`
-- ----------------------------
DROP TABLE IF EXISTS `oa_class_announcements`;
CREATE TABLE `oa_class_announcements` (
  `cp_id` tinyint(3) unsigned NOT NULL COMMENT '部门ID',
  `a_id` smallint(5) unsigned NOT NULL COMMENT '公告ID',
  KEY `ci` (`cp_id`),
  KEY `ai` (`a_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_class_announcements
-- ----------------------------
INSERT INTO `oa_class_announcements` VALUES ('4', '13');
INSERT INTO `oa_class_announcements` VALUES ('5', '13');
INSERT INTO `oa_class_announcements` VALUES ('4', '16');
INSERT INTO `oa_class_announcements` VALUES ('5', '16');
INSERT INTO `oa_class_announcements` VALUES ('4', '17');
INSERT INTO `oa_class_announcements` VALUES ('5', '17');
INSERT INTO `oa_class_announcements` VALUES ('4', '19');
INSERT INTO `oa_class_announcements` VALUES ('5', '19');
INSERT INTO `oa_class_announcements` VALUES ('5', '38');
INSERT INTO `oa_class_announcements` VALUES ('5', '21');
INSERT INTO `oa_class_announcements` VALUES ('5', '22');
INSERT INTO `oa_class_announcements` VALUES ('5', '31');
INSERT INTO `oa_class_announcements` VALUES ('4', '37');
INSERT INTO `oa_class_announcements` VALUES ('4', '38');
INSERT INTO `oa_class_announcements` VALUES ('4', '21');
INSERT INTO `oa_class_announcements` VALUES ('4', '41');
INSERT INTO `oa_class_announcements` VALUES ('5', '41');
INSERT INTO `oa_class_announcements` VALUES ('5', '37');
INSERT INTO `oa_class_announcements` VALUES ('4', '42');
INSERT INTO `oa_class_announcements` VALUES ('5', '42');

-- ----------------------------
-- Table structure for `oa_class_posts`
-- ----------------------------
DROP TABLE IF EXISTS `oa_class_posts`;
CREATE TABLE `oa_class_posts` (
  `cp_id` smallint(5) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `cp_name` varchar(15) NOT NULL DEFAULT '' COMMENT '名称',
  `cp_order` smallint(4) NOT NULL DEFAULT '0' COMMENT '排序',
  `cp_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '类型，1为职位，0为部门',
  `cp_add_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间 ',
  `cp_company_id` smallint(5) NOT NULL DEFAULT '0' COMMENT '所属公司ID',
  PRIMARY KEY (`cp_id`),
  KEY `od` (`cp_order`),
  KEY `tp` (`cp_type`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_class_posts
-- ----------------------------
INSERT INTO `oa_class_posts` VALUES ('6', '总经理', '0', '1', '0', '0');
INSERT INTO `oa_class_posts` VALUES ('4', '技术部', '0', '0', '0', '0');
INSERT INTO `oa_class_posts` VALUES ('5', '公关部', '0', '0', '0', '0');
INSERT INTO `oa_class_posts` VALUES ('7', '管理部', '0', '0', '0', '0');
INSERT INTO `oa_class_posts` VALUES ('8', '管理部', '0', '0', '0', '1');
INSERT INTO `oa_class_posts` VALUES ('9', '技术部', '0', '0', '0', '1');
INSERT INTO `oa_class_posts` VALUES ('10', '总经理', '0', '1', '0', '1');
INSERT INTO `oa_class_posts` VALUES ('11', '技术部经理', '0', '1', '0', '1');

-- ----------------------------
-- Table structure for `oa_clients`
-- ----------------------------
DROP TABLE IF EXISTS `oa_clients`;
CREATE TABLE `oa_clients` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'c_id',
  `c_uid` int(11) NOT NULL DEFAULT '0' COMMENT 'UID谁的客户',
  `c_name` varchar(15) NOT NULL DEFAULT '' COMMENT '客户姓名',
  `c_mobile` varchar(11) NOT NULL DEFAULT '0' COMMENT '客户手机',
  `c_hot` enum('高热','中热','低热') NOT NULL DEFAULT '高热' COMMENT '客户热度，3为低热，2为中热，1为高热',
  `c_hot_reason` varchar(255) NOT NULL DEFAULT '' COMMENT '热点说明',
  `c_sex` enum('男','女') DEFAULT NULL COMMENT '客户性别',
  `c_type` enum('失效客户','合作伙伴','VIP客户','普通客户','潜在客户') NOT NULL DEFAULT '失效客户' COMMENT '客户种类：5为潜在客户，4为普通客户，3为VIP客户，2为合作伙伴，1为失效客户',
  `c_stage` enum('合同期满','售后服务','合同执行','售前跟踪') NOT NULL DEFAULT '合同期满' COMMENT '客户阶段：4为售前跟踪，3为合同执行，2为售后服务，1为合同期满',
  `c_status` enum('已沟通','已报价','已做方案','已签合同','已成交') NOT NULL DEFAULT '已沟通' COMMENT '客户状态：1为已沟通，2为已报价，3为已做方案，4为已签合同，5为已成交',
  `c_telephone` varchar(15) NOT NULL DEFAULT '' COMMENT '固定电话',
  `c_faxaphone` varchar(15) NOT NULL DEFAULT '' COMMENT '传真电话',
  `c_email` varchar(50) NOT NULL DEFAULT '' COMMENT '邮箱',
  `c_qq` int(11) NOT NULL DEFAULT '0' COMMENT 'QQ',
  `c_postcode` int(11) NOT NULL DEFAULT '0' COMMENT '邮编',
  `c_address` varchar(50) NOT NULL DEFAULT '' COMMENT '家庭住址',
  `created` int(11) NOT NULL DEFAULT '0' COMMENT '客户添加时间',
  PRIMARY KEY (`c_id`),
  KEY `cn` (`c_name`),
  KEY `ct` (`c_type`),
  KEY `cs` (`c_stage`),
  KEY `css` (`c_status`),
  KEY `ch` (`c_hot`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_clients
-- ----------------------------
INSERT INTO `oa_clients` VALUES ('1', '0', '2', '0', '', '', '男', '失效客户', '合同期满', '', '固定电话', '传真电话', '邮箱地址', '0', '0', '家庭住址', '1381220669');
INSERT INTO `oa_clients` VALUES ('2', '0', '2', '0', '', '', '男', '失效客户', '合同期满', '', '固定电话', '传真电话', '邮箱地址', '0', '0', '家庭住址', '1381220703');
INSERT INTO `oa_clients` VALUES ('3', '0', '2', '0', '', '', '男', '失效客户', '合同期满', '', '固定电话', '传真电话', '邮箱地址', '0', '0', '家庭住址', '1381220755');
INSERT INTO `oa_clients` VALUES ('4', '0', '2', '0', '', '', '男', '失效客户', '合同期满', '', '固定电话', '传真电话', '邮箱地址', '0', '0', '家庭住址', '1381220803');
INSERT INTO `oa_clients` VALUES ('9', '4', '李明22', '2147483647', '高热', '', '女', '潜在客户', '售前跟踪', '已报价', '010-2525225', '010-2525225', '365875515@qq.com', '36555655', '100080', '北京市朝阳区ffff', '1382593341');

-- ----------------------------
-- Table structure for `oa_client_infos`
-- ----------------------------
DROP TABLE IF EXISTS `oa_client_infos`;
CREATE TABLE `oa_client_infos` (
  `ci_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ci_id',
  `c_id` int(11) NOT NULL COMMENT '客户ID',
  `ci_company` varchar(30) NOT NULL DEFAULT '' COMMENT '客户所在公司',
  `ci_company_address` varchar(50) NOT NULL DEFAULT '' COMMENT '客户公司所在地址',
  `ci_profession` varchar(30) NOT NULL DEFAULT '' COMMENT '客户负责业务',
  `ci_nickname` varchar(15) NOT NULL DEFAULT '' COMMENT '公司称谓',
  `ci_hold_posts` varchar(15) NOT NULL DEFAULT '' COMMENT '公司担任职务',
  `ci_source` varchar(10) NOT NULL DEFAULT '' COMMENT '客户来源：1电话咨询，2网站咨询，3上门来访，4好友介绍',
  `ci_credit_level` varchar(1) NOT NULL DEFAULT '' COMMENT '信用等级：1高，2中，3低',
  `ci_relation_level` varchar(2) NOT NULL DEFAULT '' COMMENT '关系等级：1密切，2较好，3一般，4较差',
  `ci_client_worth` varchar(1) NOT NULL DEFAULT '' COMMENT '客户价值：1高，2中，3低',
  `ci_important` varchar(4) NOT NULL DEFAULT '' COMMENT '客户重要性：1特别重要，2重要，3普通，4不重要，5失效',
  `ci_certificate_type` varchar(3) NOT NULL DEFAULT '' COMMENT '证件类型：1身份证，2驾驶证，3军官证',
  `ci_certificate_number` varchar(18) NOT NULL DEFAULT '' COMMENT '证件号码',
  `ci_remark` varchar(200) NOT NULL DEFAULT '' COMMENT '客户备注',
  PRIMARY KEY (`ci_id`),
  KEY `ccu` (`c_id`),
  KEY `cs` (`ci_source`),
  KEY `ccl` (`ci_credit_level`),
  KEY `ccw` (`ci_client_worth`),
  KEY `ci` (`ci_important`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_client_infos
-- ----------------------------
INSERT INTO `oa_client_infos` VALUES ('1', '5', '所在公司', '公司地址', '负责业务', '公司称谓', '担任职务', '4', '2', '4', '1', '1', '1', '证件号码', '客户备注');
INSERT INTO `oa_client_infos` VALUES ('2', '6', '所在公司', '公司地址', '负责业务', '公司称谓', '担任职务', '4', '2', '4', '1', '1', '1', '证件号码', '客户备注');
INSERT INTO `oa_client_infos` VALUES ('3', '7', '所在公司', '公司地址', '负责业务', '公司称谓', '担任职务', '1', '1', '1', '1', '1', '1', '证件号码', '客户备注');
INSERT INTO `oa_client_infos` VALUES ('4', '8', '北京网络科技有限公司', '北京市海淀中关村', 'GT', '小李', '技术员', '2', '1', '1', '1', '2', '1', '625625625565256215', '客户备注客户备注客户备注客户备注客户备注客户备注555555555555555555555555555555555jjjjjjjjjjjjjjjjjjjjjj');
INSERT INTO `oa_client_infos` VALUES ('8', '0', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `oa_client_infos` VALUES ('9', '10', '北京市朝阳区ffff', '北京市朝阳区ffff', '北京市朝阳区ffff', '北京市朝阳区ffff', '北京市朝阳区ffff', '2', '3', '2', '3', '1', '1', '6012245255455545', '客户备注客户备注客户备注客户备注');

-- ----------------------------
-- Table structure for `oa_communication`
-- ----------------------------
DROP TABLE IF EXISTS `oa_communication`;
CREATE TABLE `oa_communication` (
  `co_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'co_id',
  `co_uid` int(11) NOT NULL DEFAULT '0' COMMENT '交流用户ID',
  `co_username` varchar(10) NOT NULL COMMENT '交流用户姓名',
  `co_message` text NOT NULL COMMENT '交流内容',
  `co_is_del` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除消息记录，如果用户删除了记录，那么在用户语音框里将看不到该条消息,0为未删除，1为已删除',
  `co_add_time` int(11) NOT NULL DEFAULT '0' COMMENT '交流记录时间',
  PRIMARY KEY (`co_id`),
  KEY `cid` (`co_is_del`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_communication
-- ----------------------------

-- ----------------------------
-- Table structure for `oa_company`
-- ----------------------------
DROP TABLE IF EXISTS `oa_company`;
CREATE TABLE `oa_company` (
  `com_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'com_id',
  `com_company` varchar(30) NOT NULL COMMENT '公司名称',
  `com_mobile` int(11) NOT NULL DEFAULT '0' COMMENT '公司移动电话',
  `com_faxaphone` varchar(100) NOT NULL DEFAULT '' COMMENT '公司传真电话,,多个以|分开',
  `com_telephone` varchar(100) NOT NULL DEFAULT '' COMMENT '公司固定电话,多个以|分开',
  `com_email` varchar(30) NOT NULL DEFAULT '' COMMENT '公司邮箱',
  `com_city` varchar(8) NOT NULL DEFAULT '' COMMENT '公司所在城市',
  `com_qq` int(11) NOT NULL DEFAULT '0' COMMENT '公司客服QQ',
  `com_address` varchar(30) NOT NULL DEFAULT '' COMMENT '公司地址',
  `com_built_user` varchar(20) NOT NULL DEFAULT '' COMMENT '创建人',
  `com_uid` int(11) NOT NULL DEFAULT '0' COMMENT '录入该公司信息的用户ID记录',
  `com_web` varchar(100) NOT NULL DEFAULT '' COMMENT '公司网址',
  `com_regime` text NOT NULL COMMENT '公司管理制度',
  `created` int(11) NOT NULL DEFAULT '0' COMMENT '录入时间',
  PRIMARY KEY (`com_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_company
-- ----------------------------
INSERT INTO `oa_company` VALUES ('1', '北京乐思点信息技术有限公司', '2147483647', '010-6465545', '010-6465545', '365755151@qq.com', '北京海淀', '365755151', '北京海淀', '', '0', '', '&lt;p&gt;北京乐思点信息技术有限公司管理制度&lt;/p&gt;', '0');

-- ----------------------------
-- Table structure for `oa_email`
-- ----------------------------
DROP TABLE IF EXISTS `oa_email`;
CREATE TABLE `oa_email` (
  `em_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '邮件ID',
  `em_subject` varchar(50) NOT NULL DEFAULT '' COMMENT '邮件主题',
  `em_from` varchar(30) NOT NULL DEFAULT '' COMMENT '邮件来自邮箱',
  `em_come_to` varchar(255) NOT NULL DEFAULT '' COMMENT '接收人邮箱',
  `em_from_uid` int(11) NOT NULL DEFAULT '0' COMMENT '发件人ID',
  `em_to_user` varchar(255) NOT NULL DEFAULT '' COMMENT '接收人姓名',
  `em_content` text NOT NULL COMMENT '邮件内容',
  `em_inner_out` tinyint(1) NOT NULL DEFAULT '0' COMMENT '为内部或外部邮件：0为内部，1为外部',
  `em_is_attachment` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否附带附件，1为是，0为否',
  `em_attachment_path` varchar(200) NOT NULL DEFAULT '' COMMENT '附件路径',
  `created` int(11) NOT NULL DEFAULT '0' COMMENT '接收时间或邮件发送时间',
  `em_reply_time` int(11) NOT NULL DEFAULT '0' COMMENT '回复时间',
  `em_is_reply` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否回复，1为已回复，0为未回复',
  `em_is_read` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已读，1为已读，0为未读',
  `em_del_from` tinyint(1) NOT NULL DEFAULT '0' COMMENT '发件人删除确认，如果删除则为1，否则0',
  `em_del_to` tinyint(1) NOT NULL DEFAULT '0' COMMENT '收件人删除记录，同发件人字段',
  PRIMARY KEY (`em_id`),
  KEY `‘from’` (`em_from`),
  KEY `‘ct’` (`em_come_to`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_email
-- ----------------------------
INSERT INTO `oa_email` VALUES ('12', '测试邮件，谢谢 ！测试邮件，谢谢 ！', 'yangqianleizq@gmail.com', '365755151@qq.com', '4', '杨杨', '测试邮件，谢谢 ！测试邮件，谢谢 ！测试邮件，谢谢 ！测试邮件，谢谢 ！测试邮件，谢谢 ！测试邮件，谢谢 ！测试邮件，谢谢 ！测试邮件，谢谢 ！测试邮件，谢谢 ！测试邮件，谢谢 ！', '1', '0', '', '1377585424', '0', '0', '0', '0', '0');
INSERT INTO `oa_email` VALUES ('9', '测试邮件，谢谢 ！', 'lifezqy@126.com', '365755151@qq.com', '4', '杨杨', '测试邮件，谢谢 ！', '1', '0', '', '1377509894', '0', '0', '0', '0', '0');
INSERT INTO `oa_email` VALUES ('10', '测试邮件，谢谢 ！', 'yangqianleizq@gmail.com', '365755151@qq.com', '4', '杨杨', '测试邮件，谢谢 ！', '1', '0', '', '1377567654', '0', '0', '0', '0', '0');
INSERT INTO `oa_email` VALUES ('11', '测试邮件，谢谢 ！测试邮件，谢谢 ！', 'yangqianleizq@gmail.com', '365755151@qq.com', '4', '杨杨', '测试邮件，谢谢 ！测试邮件，谢谢 ！测试邮件，谢谢 ！测试邮件，谢谢 ！测试邮件，谢谢 ！测试邮件，谢谢 ！测试邮件，谢谢 ！测试邮件，谢谢 ！测试邮件，谢谢 ！测试邮件，谢谢 ！', '1', '0', '', '1377583981', '0', '0', '0', '0', '0');
INSERT INTO `oa_email` VALUES ('7', 'dddddddd', 'yangqianleizq@gmail.com', 'lifezqy@126.com', '0', '', '魂牵梦萦霜土土土土土土', '0', '0', '', '1377334527', '0', '0', '0', '0', '0');
INSERT INTO `oa_email` VALUES ('8', '测试邮件中', 'yangqianleizq@gmail.com', '杨杨:life@126.com;杨乾磊:yangqianle', '0', '', '测试邮件中', '0', '1', '', '1377496260', '0', '0', '0', '0', '0');
INSERT INTO `oa_email` VALUES ('13', '一个重要的日子', 'yangqianleizq@gmail.com', '365755151@qq.com', '4', '杨杨', '一个重要的日子，一个重要的日子，谢谢 ！', '1', '0', '', '1377586166', '0', '0', '0', '0', '0');
INSERT INTO `oa_email` VALUES ('14', '内部消息测试发送', 'yangqianleizq@gmail.com', 'life@126.com', '0', '杨杨', '内部消息测试发送', '0', '1', '', '1377610232', '0', '0', '0', '0', '0');
INSERT INTO `oa_email` VALUES ('15', '内部消息测试发送', 'yangqianleizq@gmail.com', 'life@126.com', '0', '杨杨', '内部消息测试发送', '0', '1', '/img/upload/images/20130827//1377610498.jpg,,', '1377610499', '0', '0', '0', '0', '0');
INSERT INTO `oa_email` VALUES ('16', '内部消息测试发送', 'yangqianleizq@gmail.com', 'life@126.com', '0', '杨杨', '内部消息测试发送', '0', '1', 'Array/img/upload/mark/20130827/1377611397_mark.jpg', '1377611398', '0', '0', '0', '0', '0');
INSERT INTO `oa_email` VALUES ('17', '内部消息测试发送', 'yangqianleizq@gmail.com', 'life@126.com', '0', '杨杨', '内部消息测试发送', '0', '1', '/img/upload/mark/20130827/1377611624_mark.jpg', '1377611625', '0', '0', '0', '0', '0');
INSERT INTO `oa_email` VALUES ('18', '测试邮件，亲', 'yangqianleizq@gmail.com', 'lifezqy@126.com', '0', '杨乾磊', '测试邮件，亲', '1', '0', '', '1377867650', '0', '0', '0', '0', '0');
INSERT INTO `oa_email` VALUES ('19', 'ssssssssssssssssssssssssssssssss', 'yangqianleizq@gmail.com', 'life@126.com,lifecom@company.com', '4', '杨杨,测试', 'ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss', '0', '0', '', '1378105120', '0', '0', '0', '0', '0');
INSERT INTO `oa_email` VALUES ('22', '球坛土土土土土exit;球坛土土土土土exit;', 'yangqianleizq@gmail.com', 'life@126.com,lifecom@company.com', '4', '杨杨,测试', '球坛土土土土土exit;球坛土土土土土exit;球坛土土土土土exit;球坛土土土土土exit;球坛土土土土土exit;', '0', '0', '', '1378105231', '0', '0', '0', '0', '0');
INSERT INTO `oa_email` VALUES ('23', '球坛土土土土土exit;球坛土土土土土exit;', 'yangqianleizq@gmail.com', 'life@126.com,lifecom@company.com', '4', '杨杨,测试', '球坛土土土土土exit;球坛土土土土土exit;球坛土土土土土exit;球坛土土土土土exit;球坛土土土土土exit;', '0', '0', '', '1378105257', '0', '0', '0', '0', '0');
INSERT INTO `oa_email` VALUES ('24', '球坛土土土土土exit;球坛土土土土土exit;', 'yangqianleizq@gmail.com', 'life@126.com,lifecom@company.com', '4', '杨杨,测试', '球坛土土土土土exit;球坛土土土土土exit;球坛土土土土土exit;球坛土土土土土exit;球坛土土土土土exit;', '0', '0', '', '1378105325', '0', '0', '0', '0', '0');
INSERT INTO `oa_email` VALUES ('25', '球坛土土土土土exit;球坛土土土土土exit;', 'yangqianleizq@gmail.com', 'life@126.com,lifecom@company.com', '4', '杨杨,测试', '球坛土土土土土exit;球坛土土土土土exit;球坛土土土土土exit;球坛土土土土土exit;球坛土土土土土exit;', '0', '0', '', '1378105345', '0', '0', '0', '0', '0');
INSERT INTO `oa_email` VALUES ('29', 'sssssssssssssssssdddddddddddddddd球坛土土土土土土土地', 'yangqianleizq@gmail.com', 'life@126.com,lifecom@company.com', '4', '杨杨,测试', 'sssssssssssssssssdddddddddddddddd球坛土土土土土土土地sssssssssssssssssdddddddddddddddd球坛土土土土土土土地sssssssssssssssssdddddddddddddddd球坛土土土土土土土地', '0', '0', '', '1378110224', '0', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for `oa_email_records`
-- ----------------------------
DROP TABLE IF EXISTS `oa_email_records`;
CREATE TABLE `oa_email_records` (
  `em_id` int(11) NOT NULL DEFAULT '0' COMMENT '邮件ID',
  `em_to_uid` int(11) NOT NULL DEFAULT '0' COMMENT '接收人ID',
  `em_hide` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否隐藏，即用户删除记录，当用户双方真正删除该内部邮件时，再删除该表邮件对应ID记录',
  KEY `ei` (`em_id`),
  KEY `etu` (`em_to_uid`),
  KEY `eh` (`em_hide`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_email_records
-- ----------------------------
INSERT INTO `oa_email_records` VALUES ('29', '5', '0');
INSERT INTO `oa_email_records` VALUES ('29', '4', '1');

-- ----------------------------
-- Table structure for `oa_goods_manages`
-- ----------------------------
DROP TABLE IF EXISTS `oa_goods_manages`;
CREATE TABLE `oa_goods_manages` (
  `gm_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'g_id',
  `gt_id` tinyint(3) NOT NULL DEFAULT '0' COMMENT '物品分类ID',
  `gm_goods_name` varchar(100) NOT NULL COMMENT '物品名称',
  `gm_price` float(10,2) NOT NULL COMMENT '物品单价，最高支持1亿',
  `gm_remain` mediumint(8) unsigned NOT NULL COMMENT '物品库存',
  `gm_inventory_keeper` varchar(15) NOT NULL COMMENT '入库人',
  `gm_uid` int(11) NOT NULL DEFAULT '0' COMMENT '入库人UID',
  `created` int(11) NOT NULL DEFAULT '0' COMMENT '入库时间',
  `modified` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `com_id` smallint(5) NOT NULL DEFAULT '0' COMMENT '公司ID',
  PRIMARY KEY (`gm_id`),
  KEY `ggn` (`gm_goods_name`),
  KEY `gp` (`gm_price`),
  KEY `gr` (`gm_remain`),
  KEY `gik` (`gm_inventory_keeper`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_goods_manages
-- ----------------------------
INSERT INTO `oa_goods_manages` VALUES ('1', '0', 'fdsfds', '20.22', '22', '', '0', '1378438385', '0', '0');
INSERT INTO `oa_goods_manages` VALUES ('2', '0', 'fdsfds', '20.22', '22', '', '0', '1378438503', '0', '0');
INSERT INTO `oa_goods_manages` VALUES ('3', '0', 'fdsfds', '20.22', '22', '', '0', '1378438939', '0', '0');
INSERT INTO `oa_goods_manages` VALUES ('4', '0', 'fdsfds', '20.22', '17', '', '0', '1378438979', '0', '0');
INSERT INTO `oa_goods_manages` VALUES ('5', '0', 'fdsfds', '20.22', '22', '', '0', '1378439026', '0', '0');
INSERT INTO `oa_goods_manages` VALUES ('6', '0', 'fdsfds', '20.22', '18', '', '0', '1378439056', '0', '0');
INSERT INTO `oa_goods_manages` VALUES ('7', '0', 'fdsfds', '20.22', '21', '', '0', '1378439145', '0', '0');
INSERT INTO `oa_goods_manages` VALUES ('8', '0', '&lt;script&gt;alert(docume)&lt;/script&gt;', '20.22', '22', '', '0', '1378443746', '0', '0');
INSERT INTO `oa_goods_manages` VALUES ('10', '0', '&lt;script&gt;alert(docume)&lt;/script&gt;', '20.22', '0', '杨乾磊', '4', '1378446108', '1378446108', '0');
INSERT INTO `oa_goods_manages` VALUES ('11', '1', '土土王一一右是理吉日于是 吐', '20.22', '0', '杨乾磊', '4', '1378455349', '1378456237', '0');
INSERT INTO `oa_goods_manages` VALUES ('12', '0', '十大', '23.00', '41', '杨乾磊', '4', '1378794886', '1378794886', '1');
INSERT INTO `oa_goods_manages` VALUES ('13', '0', '地地下', '23.00', '43', '杨乾磊', '4', '1378794920', '1378794920', '1');
INSERT INTO `oa_goods_manages` VALUES ('14', '3', '十大1111', '23.00', '43', '杨乾磊', '4', '1378795084', '1378795110', '1');
INSERT INTO `oa_goods_manages` VALUES ('15', '4', '十大1111', '23.00', '43', '杨乾磊', '4', '1378795414', '1378795414', '1');

-- ----------------------------
-- Table structure for `oa_goods_outs`
-- ----------------------------
DROP TABLE IF EXISTS `oa_goods_outs`;
CREATE TABLE `oa_goods_outs` (
  `go_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'go_id出库记录ID',
  `go_goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '出库物品ID',
  `go_numbers` mediumint(8) NOT NULL DEFAULT '0' COMMENT '出库物品数量',
  `go_price` float(10,2) NOT NULL COMMENT '出库时物品单价',
  `go_price_total` float(10,2) NOT NULL COMMENT '出库总金额',
  `go_type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '是否是领取申请，1管理员出库，0申请中等待审核,-1拒绝通过',
  `examine_info` varchar(200) NOT NULL DEFAULT '' COMMENT '申请原因说明',
  `go_out_uid` int(11) NOT NULL COMMENT '出库人ID',
  `created` int(11) NOT NULL DEFAULT '0' COMMENT '出库时间',
  `com_id` smallint(5) NOT NULL DEFAULT '0' COMMENT '公司ID',
  PRIMARY KEY (`go_id`),
  KEY `gou` (`go_out_uid`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_goods_outs
-- ----------------------------
INSERT INTO `oa_goods_outs` VALUES ('1', '11', '2', '0.00', '0.00', '1', '', '4', '1378461986', '0');
INSERT INTO `oa_goods_outs` VALUES ('2', '11', '22', '0.00', '0.00', '1', '', '4', '1378694397', '0');
INSERT INTO `oa_goods_outs` VALUES ('3', '3', '20', '0.00', '0.00', '1', '', '4', '1378704840', '0');
INSERT INTO `oa_goods_outs` VALUES ('4', '3', '2', '20.22', '40.44', '1', '', '4', '1378705176', '0');
INSERT INTO `oa_goods_outs` VALUES ('5', '4', '5', '20.22', '101.10', '1', '', '4', '1378707066', '0');
INSERT INTO `oa_goods_outs` VALUES ('6', '11', '12', '20.22', '242.64', '1', '', '4', '1378707396', '0');
INSERT INTO `oa_goods_outs` VALUES ('7', '11', '10', '20.22', '202.20', '1', '', '4', '1378707469', '0');
INSERT INTO `oa_goods_outs` VALUES ('8', '10', '22', '20.22', '444.84', '0', '', '4', '1378707811', '0');
INSERT INTO `oa_goods_outs` VALUES ('9', '6', '2', '20.22', '40.44', '0', '', '4', '1378709654', '0');
INSERT INTO `oa_goods_outs` VALUES ('11', '6', '2', '20.22', '40.44', '-2', '领取说明', '4', '1378715758', '0');
INSERT INTO `oa_goods_outs` VALUES ('12', '15', '2', '23.00', '46.00', '1', '申请说明', '4', '1378795622', '1');

-- ----------------------------
-- Table structure for `oa_goods_types`
-- ----------------------------
DROP TABLE IF EXISTS `oa_goods_types`;
CREATE TABLE `oa_goods_types` (
  `gt_id` tinyint(3) NOT NULL AUTO_INCREMENT,
  `gt_name` varchar(50) NOT NULL DEFAULT '' COMMENT '物品分类名称',
  `gt_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否开启，1开启，0 关闭',
  `com_id` smallint(5) NOT NULL DEFAULT '0' COMMENT '公司ID',
  PRIMARY KEY (`gt_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_goods_types
-- ----------------------------
INSERT INTO `oa_goods_types` VALUES ('1', '常用', '1', '0');
INSERT INTO `oa_goods_types` VALUES ('3', '贵重物品', '1', '4');
INSERT INTO `oa_goods_types` VALUES ('4', '贵重物品', '1', '1');
INSERT INTO `oa_goods_types` VALUES ('5', '常用物品', '1', '1');

-- ----------------------------
-- Table structure for `oa_group`
-- ----------------------------
DROP TABLE IF EXISTS `oa_group`;
CREATE TABLE `oa_group` (
  `g_id` tinyint(2) NOT NULL AUTO_INCREMENT COMMENT 'gid',
  `g_name` varchar(10) NOT NULL COMMENT '用户组',
  `g_access` varchar(255) NOT NULL DEFAULT '' COMMENT '访问权限，可以访问的导航菜单',
  `g_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否启用，1为启用，0为关闭',
  `com_id` smallint(5) NOT NULL DEFAULT '0' COMMENT '公司ID',
  PRIMARY KEY (`g_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_group
-- ----------------------------
INSERT INTO `oa_group` VALUES ('1', '超级管理员', 'all', '1', '1');
INSERT INTO `oa_group` VALUES ('2', '项目经理', 'all', '1', '1');
INSERT INTO `oa_group` VALUES ('3', '管理员11', 'all', '0', '0');
INSERT INTO `oa_group` VALUES ('4', '普通职员', 'normal', '1', '1');

-- ----------------------------
-- Table structure for `oa_leave_applications`
-- ----------------------------
DROP TABLE IF EXISTS `oa_leave_applications`;
CREATE TABLE `oa_leave_applications` (
  `la_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` int(11) NOT NULL COMMENT '用户ID',
  `la_username` varchar(20) NOT NULL DEFAULT '' COMMENT '用户姓名',
  `la_message` text NOT NULL COMMENT '申请内容信息',
  `la_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '类型，0为请假，1为外出',
  `la_read` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否查看，0为未查看，1为已查看',
  `la_reply_message` varchar(255) NOT NULL DEFAULT '' COMMENT '回复内容',
  `la_reply_uid` int(11) NOT NULL DEFAULT '0' COMMENT '回复人ID',
  `la_agree` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否批准，0未批准，1批准，-1未批准',
  `created` int(11) NOT NULL DEFAULT '0' COMMENT '记录时间',
  PRIMARY KEY (`la_id`),
  KEY `lu` (`u_id`),
  KEY `lt` (`la_type`),
  KEY `lr` (`la_read`),
  KEY `lre` (`la_reply_message`),
  KEY `la` (`la_agree`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_leave_applications
-- ----------------------------
INSERT INTO `oa_leave_applications` VALUES ('1', '4', '杨乾磊', '<p><strong>ddddddddddff</strong>ffffffffffffffffffffffffffffffffggffgggggggggggg</p>\r\n<p>gggddd&lt;script&gt;alter(1);&lt;/script&gt; \'</p>', '0', '0', '', '0', '0', '1378197980');
INSERT INTO `oa_leave_applications` VALUES ('2', '4', '杨乾磊', '', '0', '0', '', '0', '0', '1378198014');
INSERT INTO `oa_leave_applications` VALUES ('3', '4', '杨乾磊', '', '0', '0', '', '0', '0', '1378198022');
INSERT INTO `oa_leave_applications` VALUES ('4', '4', '杨乾磊', '<p>username like \'admin\' or \'1=1</p>', '0', '0', '', '0', '0', '1378198263');
INSERT INTO `oa_leave_applications` VALUES ('5', '4', '杨乾磊', '<p>%lifezq\' or \'1=1\' or \'&lt;script&gt;alter(1);&lt;/script&gt;\'</p>', '0', '0', '', '0', '0', '1378198981');
INSERT INTO `oa_leave_applications` VALUES ('6', '4', '杨乾磊', '<p>%lifezq\\\' or \\\'1=1\\\' or \\\'&lt;script&gt;alter(1)&lt;/script&gt;</p>', '0', '1', '', '0', '0', '1378199073');
INSERT INTO `oa_leave_applications` VALUES ('7', '4', '杨乾磊', '<p>%lifezq\' or \'1=1\' or \'&lt;script&gt;alter(1);&lt;/script&gt;</p>', '0', '1', '', '0', '-1', '1378199431');
INSERT INTO `oa_leave_applications` VALUES ('8', '4', '杨乾磊', '<p>%lifezq\\\' or \\\'1=1\\\' or \\\'&lt;script&gt;alter(1);&lt;/script&gt;</p>', '0', '1', '', '0', '0', '1378199589');
INSERT INTO `oa_leave_applications` VALUES ('9', '6', '杨乾磊', '<p>%lifezq\\\\\\\\\\\\\\\' or \\\\\\\\\\\\\\\'1=1\\\\\\\\\\\\\\\' or \\\\\\\\\\\\\\\'&lt;script&gt;alter(1);&lt;/script&gt;一概而论于厅 地于厅球棒王老五目目目目目止</p>', '0', '1', '<p>fffffffffe回复回复回复回复回复回复回复回复回复回复暮云春树颟顸西城西城于</p>', '0', '1', '1378199623');

-- ----------------------------
-- Table structure for `oa_mail_servers`
-- ----------------------------
DROP TABLE IF EXISTS `oa_mail_servers`;
CREATE TABLE `oa_mail_servers` (
  `m_uid` int(11) NOT NULL COMMENT '用户ID',
  `m_server` varchar(20) NOT NULL DEFAULT '' COMMENT '服务器地址',
  `m_port` smallint(4) NOT NULL DEFAULT '25' COMMENT '邮件端口',
  `m_username` varchar(30) NOT NULL COMMENT '邮件服务器帐号',
  `m_password` varchar(32) NOT NULL COMMENT '邮件服务器密码',
  `created` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`m_uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_mail_servers
-- ----------------------------
INSERT INTO `oa_mail_servers` VALUES ('0', 'smtp.126.com', '25', 'lifezqy@126.com', 'fdsafds', '1377581635');
INSERT INTO `oa_mail_servers` VALUES ('4', 'smtp.126.com', '25', 'lifezqy@126.com', 'yan@gqian@891220', '1377581713');

-- ----------------------------
-- Table structure for `oa_meetings`
-- ----------------------------
DROP TABLE IF EXISTS `oa_meetings`;
CREATE TABLE `oa_meetings` (
  `m_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '会议ID',
  `mr_id` tinyint(3) unsigned NOT NULL COMMENT '会议室编号ID',
  `u_id` int(11) NOT NULL COMMENT '会议主持人ID',
  `m_subject` varchar(50) NOT NULL COMMENT '会议主题',
  `m_class_id` varchar(255) NOT NULL COMMENT '参加会议部门ID，以逗号分隔',
  `m_join_uids` text NOT NULL COMMENT '参加会议的人员uid，以逗号分隔',
  `m_meet_time` int(11) NOT NULL DEFAULT '0' COMMENT '会议开始时间',
  `com_id` smallint(5) NOT NULL DEFAULT '0' COMMENT '公司ID',
  PRIMARY KEY (`m_id`),
  KEY `mmi` (`mr_id`),
  KEY `mcu` (`u_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_meetings
-- ----------------------------
INSERT INTO `oa_meetings` VALUES ('2', '0', '0', '会议主题会议主题', '8,9', '', '1378981200', '1');
INSERT INTO `oa_meetings` VALUES ('3', '2', '4', '会议主题会议主题', '8,9', '', '1378980780', '1');
INSERT INTO `oa_meetings` VALUES ('4', '2', '4', '测试会议安排通知功能', '8,9', '', '1379383260', '1');
INSERT INTO `oa_meetings` VALUES ('5', '2', '4', '测试会议安排通知功能', '8,9', '', '1379383260', '1');
INSERT INTO `oa_meetings` VALUES ('6', '2', '4', '测试会议安排通知功能', '8,9', '', '1379383260', '1');
INSERT INTO `oa_meetings` VALUES ('7', '2', '4', '测试会议安排通知功能', '8,9', '', '1379383260', '1');
INSERT INTO `oa_meetings` VALUES ('8', '2', '4', '测试会议安排通知功能', '8,9', '', '1379391600', '1');
INSERT INTO `oa_meetings` VALUES ('9', '2', '4', '测试会议安排通知功能', '8,9', '', '1379391600', '1');
INSERT INTO `oa_meetings` VALUES ('10', '2', '4', '测试会议安排通知功能', '8,9', '', '1379391600', '1');
INSERT INTO `oa_meetings` VALUES ('11', '2', '4', '测试会议安排通知功能', '8,9', '', '1379391600', '1');
INSERT INTO `oa_meetings` VALUES ('12', '2', '4', '测试会议安排通知功能', '8,9', '', '1379391600', '1');
INSERT INTO `oa_meetings` VALUES ('13', '2', '4', '测试会议安排通知功能', '8,9', '', '1379397660', '1');
INSERT INTO `oa_meetings` VALUES ('14', '2', '4', '大厦大厦大厦在', '8,9', '', '1379473260', '1');

-- ----------------------------
-- Table structure for `oa_meeting_rooms`
-- ----------------------------
DROP TABLE IF EXISTS `oa_meeting_rooms`;
CREATE TABLE `oa_meeting_rooms` (
  `mr_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT '会议室编号ID',
  `mr_room` varchar(15) NOT NULL COMMENT '会议室名称',
  `mr_person_num` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '会议室可容纳人数',
  `mr_status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '会议室状态，1开放，0被占用，3维修关闭中',
  `com_id` smallint(5) NOT NULL DEFAULT '0' COMMENT '公司ID',
  `mr_clean` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否打扫，1已打扫，0未打扫',
  `u_id` int(11) NOT NULL DEFAULT '0' COMMENT '预约人ID',
  `u_order_time` int(11) NOT NULL DEFAULT '0' COMMENT '预约时间',
  `u_order_end_time` int(11) NOT NULL DEFAULT '0' COMMENT '预约结束时间',
  PRIMARY KEY (`mr_id`),
  KEY `ms` (`mr_status`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_meeting_rooms
-- ----------------------------
INSERT INTO `oa_meeting_rooms` VALUES ('1', 'wwwww', '12', '1', '4', '0', '4', '1378864860', '1338890060');
INSERT INTO `oa_meeting_rooms` VALUES ('2', 'eeeeeeeeee', '18', '1', '1', '1', '4', '1379386860', '1379498460');
INSERT INTO `oa_meeting_rooms` VALUES ('3', 'yyyyyyyyyyy', '12', '1', '1', '0', '4', '1378959120', '1378980060');
INSERT INTO `oa_meeting_rooms` VALUES ('4', 'uuuuuuuuuuuuu', '12', '1', '1', '0', '4', '1378868700', '1378890480');
INSERT INTO `oa_meeting_rooms` VALUES ('5', 'wwwww', '12', '1', '1', '1', '4', '1378864860', '1378875660');
INSERT INTO `oa_meeting_rooms` VALUES ('6', 'jjjjjjjjj', '11', '1', '1', '0', '0', '0', '0');
INSERT INTO `oa_meeting_rooms` VALUES ('7', '666666666667777', '33', '1', '1', '1', '0', '0', '0');

-- ----------------------------
-- Table structure for `oa_navigation`
-- ----------------------------
DROP TABLE IF EXISTS `oa_navigation`;
CREATE TABLE `oa_navigation` (
  `n_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'n_id',
  `n_pid` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '父级导航ID',
  `n_name` varchar(10) NOT NULL DEFAULT '' COMMENT '导航名称',
  `n_path` varchar(10) NOT NULL DEFAULT '' COMMENT '路径',
  `n_permission` char(50) NOT NULL DEFAULT '' COMMENT '浏览所需用户组ID',
  `n_link` varchar(50) NOT NULL DEFAULT '' COMMENT '导航链接',
  `com_id` smallint(5) NOT NULL DEFAULT '0' COMMENT '公司ID，默认为0，即所有公司通用导航',
  PRIMARY KEY (`n_id`),
  KEY `np` (`n_pid`),
  KEY `npa` (`n_path`),
  KEY `npe` (`n_permission`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_navigation
-- ----------------------------
INSERT INTO `oa_navigation` VALUES ('1', '0', '我的办公桌', '0', '1,2,4', '', '0');
INSERT INTO `oa_navigation` VALUES ('2', '0', '信息档案', '0', '1,2,4', '', '0');
INSERT INTO `oa_navigation` VALUES ('3', '0', '会议管理', '0', '1,2,4', '', '0');
INSERT INTO `oa_navigation` VALUES ('4', '0', '员工管理', '0', '1,2', '', '0');
INSERT INTO `oa_navigation` VALUES ('27', '4', '管理员工', '0_4', '1,2', 'Staff/staff', '0');
INSERT INTO `oa_navigation` VALUES ('6', '0', '客户管理', '0', '1,2,4', '', '0');
INSERT INTO `oa_navigation` VALUES ('7', '0', '项目管理', '0', '1,2,4', '', '0');
INSERT INTO `oa_navigation` VALUES ('8', '0', '公共区域', '0', '1,2,4', '', '0');
INSERT INTO `oa_navigation` VALUES ('9', '0', 'OA系统设置', '0', '1,2', '', '0');
INSERT INTO `oa_navigation` VALUES ('10', '1', '电子邮件', '0_1', '1,2,4', 'Emails/innerEmails/received', '0');
INSERT INTO `oa_navigation` VALUES ('11', '1', '短信息', '0_1', '1,2,4', 'Office/sms', '0');
INSERT INTO `oa_navigation` VALUES ('12', '1', '公告通知', '0_1', '1,2,4', 'Office/announcement', '0');
INSERT INTO `oa_navigation` VALUES ('13', '1', '请假/外出申请', '0_1', '1,2,4', 'Users/leaveApplication', '0');
INSERT INTO `oa_navigation` VALUES ('14', '1', '日程安排', '0_1', '1,2,4', 'Users/schedule', '0');
INSERT INTO `oa_navigation` VALUES ('15', '1', '工作日志', '0_1', '1,2,4', 'Users/workDiary', '0');
INSERT INTO `oa_navigation` VALUES ('16', '1', '通讯薄', '0_1', '1,2,4', 'Users/addressBook', '0');
INSERT INTO `oa_navigation` VALUES ('18', '2', '个人文件柜', '0_2', '1,2,4', 'Users/fileCabinet', '0');
INSERT INTO `oa_navigation` VALUES ('19', '2', '公司物品', '0_2', '1,2,4', 'Company/goodsManage/list', '0');
INSERT INTO `oa_navigation` VALUES ('20', '2', '公司制度规章', '0_2', '1,2,4', 'Company/manageRegime', '0');
INSERT INTO `oa_navigation` VALUES ('21', '3', '会议室管理', '0_3', '1,2', 'Company/meetingRoom', '0');
INSERT INTO `oa_navigation` VALUES ('23', '3', '会议室预约', '0_3', '1,2,4', 'Company/meetingRoom/order', '0');
INSERT INTO `oa_navigation` VALUES ('24', '3', '会议安排', '0_3', '1,2,4', 'Company/meeting/add', '0');
INSERT INTO `oa_navigation` VALUES ('25', '3', '会议管理', '0_3', '1,2', 'Company/meeting', '0');
INSERT INTO `oa_navigation` VALUES ('28', '4', '任务分派', '0_4', '1,2', 'Staff/assignment/add', '0');
INSERT INTO `oa_navigation` VALUES ('29', '4', '任务管理', '0_4', '1,2', 'Staff/assignment', '0');
INSERT INTO `oa_navigation` VALUES ('30', '4', '紧急通告发布', '0_4', '1,2', '', '0');
INSERT INTO `oa_navigation` VALUES ('31', '6', '新建客户', '0_6', '1,2,4', 'Client/clientManage/add', '0');
INSERT INTO `oa_navigation` VALUES ('32', '6', '管理客户', '0_6', '1,2,4', 'Client/clientManage', '0');
INSERT INTO `oa_navigation` VALUES ('33', '6', '共享客户', '0_6', '1,2,4', '', '0');
INSERT INTO `oa_navigation` VALUES ('34', '7', '新建项目', '0_7', '1,2,4', 'Project/projects/add', '0');
INSERT INTO `oa_navigation` VALUES ('35', '7', '管理项目', '0_7', '1,2,4', '', '0');
INSERT INTO `oa_navigation` VALUES ('36', '8', '公共频道', '0_8', '1,2,4', '', '0');
INSERT INTO `oa_navigation` VALUES ('37', '8', '公司相册', '0_8', '1,2,4', '', '0');
INSERT INTO `oa_navigation` VALUES ('38', '8', '公共投票', '0_8', '1,2,4', '', '0');
INSERT INTO `oa_navigation` VALUES ('39', '9', 'OA导航管理', '0_9', '1,2', 'System/navigationManage', '0');
INSERT INTO `oa_navigation` VALUES ('41', '9', 'OA公司结构', '0_9', '1', 'Company/classAndPosts', '0');
INSERT INTO `oa_navigation` VALUES ('42', '9', 'OA用户管理', '0_9', '1,2', 'Users/userManage', '0');

-- ----------------------------
-- Table structure for `oa_permissions`
-- ----------------------------
DROP TABLE IF EXISTS `oa_permissions`;
CREATE TABLE `oa_permissions` (
  `p_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'p_id',
  `p_uid` int(11) NOT NULL COMMENT '用户ID',
  `p_nav_allows` varchar(255) NOT NULL DEFAULT '' COMMENT '允许用户访问的导航ID，以逗号分开',
  PRIMARY KEY (`p_id`),
  KEY `pu` (`p_uid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_permissions
-- ----------------------------
INSERT INTO `oa_permissions` VALUES ('1', '4', '1,10,11,12,13,14,15,16,17,2,18,19,20,3,21,23,24,25,4,26,27,28,29,30,6,31,32,33,7,34,35,8,36,37,38,9,39,40,41,42,43,44,45,46,47');
INSERT INTO `oa_permissions` VALUES ('2', '12', '');

-- ----------------------------
-- Table structure for `oa_picture`
-- ----------------------------
DROP TABLE IF EXISTS `oa_picture`;
CREATE TABLE `oa_picture` (
  `p_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'p_id',
  `p_album_id` int(11) NOT NULL COMMENT '相册 ID',
  `p_picture` varchar(100) NOT NULL COMMENT '图片保存路径',
  `p_description` varchar(100) NOT NULL DEFAULT '' COMMENT '相片描述',
  `p_add_time` int(11) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`p_id`),
  KEY `pai` (`p_album_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_picture
-- ----------------------------

-- ----------------------------
-- Table structure for `oa_projects`
-- ----------------------------
DROP TABLE IF EXISTS `oa_projects`;
CREATE TABLE `oa_projects` (
  `p_id` int(11) NOT NULL AUTO_INCREMENT,
  `p_title` varchar(50) NOT NULL DEFAULT '' COMMENT '项目标题',
  `p_start_time` char(10) NOT NULL DEFAULT '' COMMENT '项目开始时间',
  `p_end_time` char(10) NOT NULL DEFAULT '' COMMENT '项目结束时间',
  `p_join_uid` varchar(255) NOT NULL DEFAULT '' COMMENT '项目参加人员ID，以,分隔',
  `p_join_users` varchar(255) NOT NULL DEFAULT '' COMMENT '项目参加人员',
  `p_manager_id` int(11) NOT NULL DEFAULT '0' COMMENT '项目经理ID',
  `p_manager` char(10) NOT NULL DEFAULT '' COMMENT '项目经理',
  `p_verify_uid` int(11) NOT NULL DEFAULT '0' COMMENT '项目审核人ID',
  `p_verify_user` char(10) NOT NULL DEFAULT '' COMMENT '项目审核人',
  `p_description` varchar(255) NOT NULL DEFAULT '' COMMENT '项目描述',
  `created` int(11) NOT NULL DEFAULT '0' COMMENT '项目添加时间',
  PRIMARY KEY (`p_id`),
  KEY `m_id` (`p_manager_id`),
  KEY `v_id` (`p_verify_uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_projects
-- ----------------------------

-- ----------------------------
-- Table structure for `oa_schedules`
-- ----------------------------
DROP TABLE IF EXISTS `oa_schedules`;
CREATE TABLE `oa_schedules` (
  `s_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '日程ID',
  `s_uid` int(11) NOT NULL COMMENT '用户ID',
  `s_year` smallint(4) NOT NULL COMMENT '年',
  `s_month` tinyint(2) NOT NULL COMMENT '月',
  `s_schedule` text NOT NULL COMMENT '一月中每天的日程内容,用>>>|分开',
  PRIMARY KEY (`s_id`),
  KEY `su` (`s_uid`),
  KEY `sy` (`s_year`),
  KEY `sm` (`s_month`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_schedules
-- ----------------------------
INSERT INTO `oa_schedules` VALUES ('5', '4', '2013', '10', '');
INSERT INTO `oa_schedules` VALUES ('4', '4', '2013', '9', '土土土土土土土土土地>>>|>>>|>>>|44444444444444444444>>>|土土土土土土55555555555555>>>|8888888888888888888888888888888>>>|土土土圭>>>|>>>|>>>|>>>|>>>|>>>|>>>|>>>|>>>|>>>|>>>|>>>|>>>|>>>|>>>|>>>|>>>|>>>|>>>|>>>|>>>|>>>|>>>|>>>|');

-- ----------------------------
-- Table structure for `oa_sms`
-- ----------------------------
DROP TABLE IF EXISTS `oa_sms`;
CREATE TABLE `oa_sms` (
  `s_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '短消息ID',
  `s_pid` int(11) NOT NULL DEFAULT '0' COMMENT '子消息上级ID',
  `s_receivers` varchar(150) NOT NULL DEFAULT '' COMMENT '接收人',
  `s_from_uid` int(11) NOT NULL DEFAULT '0' COMMENT '发消息人ID',
  `s_message` varchar(200) NOT NULL DEFAULT '' COMMENT '消息内容',
  `s_from_user` varchar(15) NOT NULL DEFAULT '' COMMENT '发消息人',
  `s_reply_num` smallint(5) NOT NULL DEFAULT '0' COMMENT '回复数',
  `created` int(11) NOT NULL DEFAULT '0' COMMENT '发送时间',
  PRIMARY KEY (`s_id`),
  KEY `pid` (`s_pid`),
  KEY `ruid` (`s_receivers`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_sms
-- ----------------------------
INSERT INTO `oa_sms` VALUES ('1', '0', '', '4', '', '杨乾磊', '0', '1377761093');
INSERT INTO `oa_sms` VALUES ('2', '0', '', '4', '', '杨乾磊', '0', '1377761152');
INSERT INTO `oa_sms` VALUES ('3', '0', '', '4', '', '杨乾磊', '0', '1377761197');
INSERT INTO `oa_sms` VALUES ('4', '0', '', '4', '', '杨乾磊', '0', '1377761453');
INSERT INTO `oa_sms` VALUES ('5', '0', '杨杨,测试', '5', 'ddddddddddddddddfffffffffff', '杨乾磊', '12', '1377764189');
INSERT INTO `oa_sms` VALUES ('6', '0', '杨杨', '5', 'fffffffffffffffffffffffffffff一直在整日吉于点到', '杨乾磊', '6', '1378010079');
INSERT INTO `oa_sms` VALUES ('7', '0', '杨乾磊,札幌,测试帐号,测试帐号', '4', '杨乾磊在会议室《eeeeeeeeee》主持了会议，会议主题为《测试会议安排通知功能》,会议开始时间:2013/09/17 12:20:00。希望大家准时参加。谢谢!', '杨乾磊', '0', '1379384471');
INSERT INTO `oa_sms` VALUES ('8', '0', '杨乾磊,札幌,测试帐号,测试帐号', '4', '杨乾磊在会议室《eeeeeeeeee》主持了会议，会议主题为《测试会议安排通知功能》,会议开始时间:2013/09/17 14:01:00。希望大家准时参加。谢谢!', '杨乾磊', '0', '1379384703');
INSERT INTO `oa_sms` VALUES ('9', '5', '杨乾磊', '4', '<p>王王一封土土土在上目目目日日日昌</p>', '杨乾磊', '0', '1379398237');
INSERT INTO `oa_sms` VALUES ('10', '9', '杨乾磊', '4', '<p><br></p>', '杨乾磊', '0', '1379406357');
INSERT INTO `oa_sms` VALUES ('11', '9', '杨乾磊', '4', '<p>ffffffffffffffffffffffffffffffffsssssssssssss</p>', '杨乾磊', '0', '1379409011');
INSERT INTO `oa_sms` VALUES ('12', '5', '杨杨,测试', '4', '<p>ffffffffffffffdddddddddddddddddddd十三点要士别三日要胆有凌源杨上</p>\r\n<p>&nbsp;</p>\r\n<p>百叶 百叶城吸默契困蟛 灶右胆吉在</p>', '杨乾磊', '0', '1379411959');
INSERT INTO `oa_sms` VALUES ('13', '10', '杨乾磊', '4', '@杨乾磊:<p><br></p>', '杨乾磊', '0', '1379472933');
INSERT INTO `oa_sms` VALUES ('14', '13', '杨乾磊', '4', '@杨乾磊:大厦大厦磊55555', '杨乾磊', '0', '1379474732');
INSERT INTO `oa_sms` VALUES ('15', '13', '杨乾磊', '4', '@杨乾磊:王王一44444', '杨乾磊', '0', '1379474761');
INSERT INTO `oa_sms` VALUES ('16', '14', '杨乾磊', '4', '@杨乾磊:城88888888800000000', '杨乾磊', '0', '1379475310');
INSERT INTO `oa_sms` VALUES ('17', '16', '杨乾磊', '4', '@杨乾磊:王王王王王王王', '杨乾磊', '0', '1379481589');
INSERT INTO `oa_sms` VALUES ('18', '12', '杨杨,测试', '4', '@杨乾磊:大厦大厦大厦大厦大厦靥田田田白白', '杨乾磊', '0', '1379486205');
INSERT INTO `oa_sms` VALUES ('19', '6', '杨杨', '4', '@杨乾磊:测试新回复撒', '杨乾磊', '0', '1379486640');
INSERT INTO `oa_sms` VALUES ('20', '19', '杨杨', '4', '@杨乾磊:测试回复新回复撒', '杨乾磊', '0', '1379486682');
INSERT INTO `oa_sms` VALUES ('21', '20', '杨杨', '4', '@杨乾磊:再次测试', '杨乾磊', '0', '1379488996');
INSERT INTO `oa_sms` VALUES ('22', '21', '杨杨', '4', '@杨乾磊:再次测试再次测试', '杨乾磊', '0', '1379489102');
INSERT INTO `oa_sms` VALUES ('23', '5', '杨杨,测试', '4', '@杨乾磊:再次测试再次测试再次测试再次测试', '杨乾磊', '0', '1379489118');
INSERT INTO `oa_sms` VALUES ('24', '22', '杨杨', '4', '@杨乾磊:王王王王王王王王五', '杨乾磊', '0', '1379489183');
INSERT INTO `oa_sms` VALUES ('25', '24', '杨杨', '4', '@杨乾磊:3333333333333土土土土土', '杨乾磊', '0', '1379489284');
INSERT INTO `oa_sms` VALUES ('26', '23', '杨杨,测试', '4', '@杨乾磊:王一44444王一44444王一44444', '杨乾磊', '0', '1379489528');
INSERT INTO `oa_sms` VALUES ('27', '0', '杨乾磊,札幌,测试帐号,测试帐号', '4', '杨乾磊在会议室《eeeeeeeeee》主持了会议，会议主题为《大厦大厦大厦在》,会议开始时间:2013/09/18 11:01:00。希望大家准时参加。谢谢!', '杨乾磊', '0', '1379490219');
INSERT INTO `oa_sms` VALUES ('28', '0', '杨乾磊,测试帐号', '4', '管理部部门技术部经理 杨乾磊给您分配了新任务,快去查看吧!', '杨乾磊', '0', '1379832197');
INSERT INTO `oa_sms` VALUES ('29', '0', '杨乾磊,测试帐号', '4', '管理部部门技术部经理 杨乾磊给您分配了新任务,快去查看吧!', '杨乾磊', '0', '1379832220');
INSERT INTO `oa_sms` VALUES ('30', '0', '杨乾磊,测试帐号', '4', '管理部部门技术部经理 杨乾磊给您分配了新任务,快去查看吧!', '杨乾磊', '0', '1379832349');
INSERT INTO `oa_sms` VALUES ('31', '0', '札幌,测试帐号', '4', '管理部部门技术部经理 杨乾磊给您分配了新任务,快去查看吧!', '杨乾磊', '0', '1379833945');

-- ----------------------------
-- Table structure for `oa_sms_record`
-- ----------------------------
DROP TABLE IF EXISTS `oa_sms_record`;
CREATE TABLE `oa_sms_record` (
  `sr_uid` int(11) NOT NULL COMMENT '用户ID',
  `sr_unread_sms_id` int(11) NOT NULL COMMENT '未读消息ID',
  `sr_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已读，0未读，1已读',
  `sr_hide` tinyint(1) NOT NULL DEFAULT '0' COMMENT '用户是否已删除该条消息记录，如果删除就不显示，0为未删除，1为已删除消息记录',
  `sr_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '新的回复还是消息，0消息，1为新的回复',
  KEY `sr_u` (`sr_uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_sms_record
-- ----------------------------
INSERT INTO `oa_sms_record` VALUES ('6', '6', '0', '0', '0');
INSERT INTO `oa_sms_record` VALUES ('4', '5', '1', '0', '0');
INSERT INTO `oa_sms_record` VALUES ('4', '6', '1', '0', '0');
INSERT INTO `oa_sms_record` VALUES ('4', '8', '1', '0', '0');
INSERT INTO `oa_sms_record` VALUES ('10', '8', '0', '0', '0');
INSERT INTO `oa_sms_record` VALUES ('11', '8', '0', '0', '0');
INSERT INTO `oa_sms_record` VALUES ('12', '8', '0', '0', '0');
INSERT INTO `oa_sms_record` VALUES ('4', '10', '1', '0', '1');
INSERT INTO `oa_sms_record` VALUES ('4', '11', '1', '0', '1');
INSERT INTO `oa_sms_record` VALUES ('5', '12', '0', '0', '1');
INSERT INTO `oa_sms_record` VALUES ('4', '13', '1', '0', '1');
INSERT INTO `oa_sms_record` VALUES ('4', '14', '1', '0', '1');
INSERT INTO `oa_sms_record` VALUES ('4', '15', '1', '0', '1');
INSERT INTO `oa_sms_record` VALUES ('4', '16', '1', '0', '1');
INSERT INTO `oa_sms_record` VALUES ('4', '17', '1', '0', '1');
INSERT INTO `oa_sms_record` VALUES ('4', '18', '1', '0', '1');
INSERT INTO `oa_sms_record` VALUES ('5', '19', '1', '0', '1');
INSERT INTO `oa_sms_record` VALUES ('4', '20', '1', '0', '1');
INSERT INTO `oa_sms_record` VALUES ('4', '6', '1', '0', '1');
INSERT INTO `oa_sms_record` VALUES ('4', '6', '1', '0', '1');
INSERT INTO `oa_sms_record` VALUES ('5', '5', '0', '0', '1');
INSERT INTO `oa_sms_record` VALUES ('4', '6', '1', '0', '1');
INSERT INTO `oa_sms_record` VALUES ('4', '6', '1', '0', '1');
INSERT INTO `oa_sms_record` VALUES ('4', '5', '1', '0', '1');
INSERT INTO `oa_sms_record` VALUES ('4', '27', '1', '0', '0');
INSERT INTO `oa_sms_record` VALUES ('10', '27', '0', '0', '0');
INSERT INTO `oa_sms_record` VALUES ('11', '27', '0', '0', '0');
INSERT INTO `oa_sms_record` VALUES ('12', '27', '0', '0', '0');
INSERT INTO `oa_sms_record` VALUES ('4', '30', '1', '0', '0');
INSERT INTO `oa_sms_record` VALUES ('12', '30', '0', '0', '0');
INSERT INTO `oa_sms_record` VALUES ('10', '31', '0', '0', '0');
INSERT INTO `oa_sms_record` VALUES ('11', '31', '0', '0', '0');

-- ----------------------------
-- Table structure for `oa_space`
-- ----------------------------
DROP TABLE IF EXISTS `oa_space`;
CREATE TABLE `oa_space` (
  `a_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'a_id',
  `a_uid` int(11) NOT NULL COMMENT 'uid',
  `a_cabinet_size` int(11) NOT NULL DEFAULT '10' COMMENT '用户文件柜大小，单位M',
  `a_free_size` int(11) NOT NULL DEFAULT '10' COMMENT '文件柜剩余空间大小，单位M',
  `a_allow_upload` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否允许上传，1为允许，0为禁止',
  PRIMARY KEY (`a_id`),
  KEY `au` (`a_uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_space
-- ----------------------------

-- ----------------------------
-- Table structure for `oa_users`
-- ----------------------------
DROP TABLE IF EXISTS `oa_users`;
CREATE TABLE `oa_users` (
  `u_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `u_company_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '用户所在公司ID',
  `u_gid` tinyint(2) NOT NULL COMMENT '用户所在组ID',
  `u_role` tinyint(2) NOT NULL DEFAULT '0' COMMENT '用户角色，0普通会员，1管理员，2超级管理员,-1黑名单,-2禁用',
  `u_username` varchar(30) NOT NULL COMMENT '用户帐号',
  `u_password` char(40) NOT NULL COMMENT '用户密码',
  `u_true_name` varchar(10) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `u_sex` enum('男','女') NOT NULL COMMENT '性别',
  `u_age` tinyint(3) NOT NULL DEFAULT '0' COMMENT '年龄',
  `u_birthday` varchar(10) NOT NULL DEFAULT '' COMMENT '生日',
  `u_interest` varchar(200) NOT NULL DEFAULT '' COMMENT '兴趣爱好',
  `u_class_id` tinyint(3) NOT NULL DEFAULT '0' COMMENT '所在部门ID',
  `u_posts_id` tinyint(3) NOT NULL DEFAULT '0' COMMENT '所在职位ID',
  `u_mobile` char(11) NOT NULL DEFAULT '' COMMENT '用户手机号',
  `u_email` varchar(30) NOT NULL DEFAULT '' COMMENT '个人邮箱',
  `u_company_email` varchar(30) NOT NULL DEFAULT '' COMMENT '公司内部邮箱',
  `u_resume_type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否上传或完善简历，0未，1已上传，2已完善简历信息',
  `u_is_close` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否禁用帐号，0为启用，1为禁用,2为禁止用户登录OA',
  `u_file_cabinet` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用文件柜，0为启用，1为禁用',
  `u_cabinet_size` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文件柜大小，单位字节B;',
  `u_free_size` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文件柜剩余空间大小，单位字节B;',
  `u_client_uids` text NOT NULL COMMENT '我的客户们ID，以逗号分隔',
  PRIMARY KEY (`u_id`),
  UNIQUE KEY `un` (`u_username`),
  KEY `up` (`u_password`),
  KEY `ci` (`u_class_id`),
  KEY `pi` (`u_posts_id`),
  KEY `ic` (`u_is_close`),
  KEY `fc` (`u_file_cabinet`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_users
-- ----------------------------
INSERT INTO `oa_users` VALUES ('4', '1', '1', '2', 'lifezq', '64be7bd8cabe74ecc551f0c8150d0740d64a9cb8', '杨乾磊', '男', '24', '', '', '8', '11', '15001046768', 'yangqianleizq@gmail.com', 'yangqianleizq@gmail.com', '0', '0', '0', '104857600', '100875966', '');
INSERT INTO `oa_users` VALUES ('5', '1', '0', '0', 'testtest', 'db841de55552f728d9b444299f730e5d453933d1', '杨杨', '男', '24', '', '', '6', '4', '15001046766', '365755151@qq.com', 'life@126.com', '0', '0', '0', '20000', '0', '');
INSERT INTO `oa_users` VALUES ('6', '1', '0', '0', 'testnew', 'fjdksfkdsfdk', '测试', '男', '24', '2000/01/12', '兴趣', '1', '2', '15004054564', 'life@126d.com', 'lifecom@company.com', '0', '0', '0', '22000', '0', '0');
INSERT INTO `oa_users` VALUES ('7', '1', '0', '0', 'testnew1', 'fjdksfkdsfdk', '测试', '男', '24', '2000/01/12', '兴趣', '1', '2', '15004054564', 'life@126d.com', 'lifecom@company.com', '0', '0', '0', '22000', '0', '0');
INSERT INTO `oa_users` VALUES ('8', '1', '0', '0', 'testnew2', 'fjdksfkdsfdk', '测试', '男', '24', '2000/01/12', '兴趣', '1', '2', '15004054564', 'life@126d.com', 'lifecom@company.com', '0', '0', '0', '22000', '0', '0');
INSERT INTO `oa_users` VALUES ('9', '1', '0', '0', 'testnew10', 'fjdksfkdsfdk', '测试', '男', '24', '2000/01/12', '兴趣', '1', '2', '15004054564', 'life@126d.com', 'lifecom@company.com', '0', '0', '0', '22000', '0', '0');
INSERT INTO `oa_users` VALUES ('10', '1', '4', '0', 'testtest1', '5b1a45ca985599971d7ad1d27e95ecde602548ca', '札幌', '男', '22', '', '', '9', '10', '15001046767', 'test@126.com', 'test@126.com', '0', '0', '0', '10485760', '10485760', '');
INSERT INTO `oa_users` VALUES ('11', '1', '4', '0', 'testtest2', '3357d68188d321132c3868985a644c34938d180e', '测试帐号', '男', '22', '', '', '9', '10', '15001046768', 'test1@126.com', 'test1@126.com', '2', '0', '0', '12582912', '12582912', '');
INSERT INTO `oa_users` VALUES ('12', '1', '4', '0', 'testtest3', '2fa7337e265c7e47c4d55403c32a7b0be72b79e2', '测试帐号', '男', '22', '', '', '8', '10', '15001046765', 'test2@126.com', 'test2@126.com', '2', '0', '0', '23068672', '23068672', '');

-- ----------------------------
-- Table structure for `oa_user_announcements`
-- ----------------------------
DROP TABLE IF EXISTS `oa_user_announcements`;
CREATE TABLE `oa_user_announcements` (
  `u_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `a_id` smallint(5) NOT NULL DEFAULT '0' COMMENT '公告ID',
  `hide` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示，或者是用户是否删除该公告，0为显示，1为hide'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_user_announcements
-- ----------------------------
INSERT INTO `oa_user_announcements` VALUES ('4', '21', '1');
INSERT INTO `oa_user_announcements` VALUES ('4', '22', '0');
INSERT INTO `oa_user_announcements` VALUES ('4', '31', '0');
INSERT INTO `oa_user_announcements` VALUES ('4', '36', '0');
INSERT INTO `oa_user_announcements` VALUES ('4', '37', '0');
INSERT INTO `oa_user_announcements` VALUES ('4', '38', '0');
INSERT INTO `oa_user_announcements` VALUES ('4', '40', '0');
INSERT INTO `oa_user_announcements` VALUES ('4', '41', '1');
INSERT INTO `oa_user_announcements` VALUES ('4', '19', '1');

-- ----------------------------
-- Table structure for `oa_user_infos`
-- ----------------------------
DROP TABLE IF EXISTS `oa_user_infos`;
CREATE TABLE `oa_user_infos` (
  `u_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `ui_resume` text NOT NULL COMMENT '用户简历,可以是路径，也可以是简历信息',
  PRIMARY KEY (`u_id`),
  KEY `uuid` (`u_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_user_infos
-- ----------------------------
INSERT INTO `oa_user_infos` VALUES ('12', '<p>土土土土十一王王王王旧</p>');
INSERT INTO `oa_user_infos` VALUES ('11', '<p>编辑个人简历信息编辑个人简历信息编辑个人简历信息编辑个人简历信息编辑个人简历信息编辑个人简历信息</p>');

-- ----------------------------
-- Table structure for `oa_work_diarys`
-- ----------------------------
DROP TABLE IF EXISTS `oa_work_diarys`;
CREATE TABLE `oa_work_diarys` (
  `w_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '日志ID',
  `u_id` int(11) NOT NULL COMMENT '用户ID',
  `w_username` varchar(30) NOT NULL DEFAULT '' COMMENT '用户名',
  `w_diary` text NOT NULL COMMENT '日志内容',
  `w_summary` varchar(100) NOT NULL DEFAULT '' COMMENT '工作总结',
  `w_remark` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',
  `created` int(11) NOT NULL DEFAULT '0' COMMENT '日志记录时间',
  `w_appraise` varchar(255) NOT NULL DEFAULT '' COMMENT '领导对工作日志的评价',
  `w_leader_uid` int(11) NOT NULL DEFAULT '0' COMMENT '领导ID',
  PRIMARY KEY (`w_id`),
  KEY `wu` (`u_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oa_work_diarys
-- ----------------------------
INSERT INTO `oa_work_diarys` VALUES ('1', '4', '杨乾磊', '<p>1111111111111工作内容工作内容</p>', '<p>2222工作总结工作总结</p>', '<p>33333333备注</p>', '1378346126', '<p>不错，继续努力喔</p>', '4');
INSERT INTO `oa_work_diarys` VALUES ('2', '4', '杨乾磊', '', '', '', '1378346369', '', '0');
INSERT INTO `oa_work_diarys` VALUES ('4', '4', '杨乾磊', '<p>工作内容工作内容</p>', '<p>工作总结工作总结</p>', '<p>备注备注备注备注</p>', '1378350827', '', '0');
INSERT INTO `oa_work_diarys` VALUES ('5', '4', '杨乾磊', '<p>1111111工作内容工作内容</p>', '<p>222222222工作总结</p>', '<p>33333333333备注</p>', '1378350938', '', '0');
