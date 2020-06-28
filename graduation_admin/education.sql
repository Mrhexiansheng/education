/*
 Navicat Premium Data Transfer

 Source Server         : hjh
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : education

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 18/05/2020 16:01:13
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '用户名',
  `password` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '密码',
  `last_login_time` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '用户上次登录时间',
  `state` tinyint(10) NOT NULL DEFAULT 1 COMMENT '1.白名单  2.黑名单',
  `role` int(10) NOT NULL COMMENT '1.超级管理员 2.领导 3.专家 4.教师',
  `hash` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '哈希值',
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '用户头像',
  `phone` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '联系电话',
  `college` int(50) NOT NULL COMMENT '所属学院',
  `depart_number` int(10) NOT NULL DEFAULT 0 COMMENT '所属部门，可以为0,已编号为主',
  `realname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '真实姓名，与用户名做一个区分',
  `teachers_title` int(10) NOT NULL COMMENT '1.助教 2.讲师 3.副教授 4.教授',
  `degree` int(10) NOT NULL COMMENT '1.学士 2.硕士 3.博士',
  `research_project` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '该用户参研项目',
  `experts_type` int(10) NULL DEFAULT NULL COMMENT '专家类型：\r\n1.教学综合改革类\r\n2.专业建设类\r\n3.人才培养改革类\r\n4.实践教学类\r\n5.创新创业类\r\n6.教学管理类\r\n7.师资队伍建设类\r\n8.新工科研究与实践类',
  `position` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '职位',
  `abstract` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '专家简介',
  `experts_project` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '专家参与在评项目',
  `experts_projects` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '专家在评项目成功或失败之后信息转接到这里',
  `research_projects` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '项目在审核完毕之后转接到这里，意为该永华曾经参加过得项目',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uni`(`username`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 52 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES (1, 'admin', 'f2b7535cd9fbbdeea65aecc99868d7d4', '2020/5/18 下午12:23:14', 1, 1, '4ccd6bc7440d2cb165c9745955cea096', '/uploads/20190928/2ba2272a7397fab9de89c7779dfc52d6.jpg', '15513284891', 0, 0, '超级管理员', 0, 0, '', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `admin` VALUES (27, '1614011005', 'f06fa1cb35b33f2edbe7584b007fb650', '2020/5/16 上午11:30:51', 1, 2, 'a5c6d152603c11e3f1832789dac17ada', '/uploads/20191008/867178941932c0fa2a2eebaf493683ed.jpg', '15513284891', 2, 3, '王宣', 3, 3, '', NULL, '机械工程学院领导', NULL, NULL, NULL, NULL);
INSERT INTO `admin` VALUES (29, '1614011003', 'bdd33a66a2e3460db82fb6927efd3a2b', '2020/5/9 下午10:41:22', 1, 4, 'c868794f83df35ff4f042334c966712b', '/uploads/20191010/00a99456b6381074632c557f89cd952d.jpg', '15513284891', 6, 3, '韩景涛', 3, 2, '[{\"id\":12,\"name\":\"课程评估机制的建立与实施\"}]', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `admin` VALUES (28, '1614011006', 'fe80ffe9640f18776929f8de2bed34a8', '2020/5/9 下午3:22:53', 1, 4, '8240a11e5f7eb1deea320dd561a1e3d9', '/uploads/20191008/afa4d90155efe1e1f4ddaf0fa53e70b3.jpg', '15513284891', 4, 4, '王琦', 4, 3, '[{\"id\":13,\"name\":\"课堂教学质量评价指标体系研究与实践\"}]', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `admin` VALUES (30, '1614011007', 'cb270265d62bee55a02bbfea220f4d0b', '2020/5/12 下午12:31:14', 1, 3, '5f5e7788b324b772832d86a645000f2a', '/uploads/20200207/49d89c05935e26c375efc2999c50f944.png', '15513284891', 0, 0, '张三', 0, 0, '', 5, NULL, '我是一个专家', '[{\"id\":12,\"name\":\"课堂教学质量评价指标体系研究与实践\"}]', NULL, NULL);
INSERT INTO `admin` VALUES (23, '1614011002', 'c2604696741a9c162a9a3b0e1e004d28', '2020/5/9 下午10:40:09', 1, 4, 'cc4eee8a216a3e201f62e8090d925371', '/uploads/20191003/0c827577f7e8774cfb647e890847fd35.jpg', '15513284891', 2, 3, '李楠', 3, 2, '[{\"id\":12,\"name\":\"课程评估机制的建立与实施\"}]', NULL, '', NULL, NULL, NULL, NULL);
INSERT INTO `admin` VALUES (32, '1614011011', 'd6d2673e8a3583e728a2bd7f142addfb', '2020/4/30 上午9:26:38', 1, 3, '6258479f2eb5824e4ea65db276a596df', '/uploads/20200418/4aea7743e80e4139ee6ab704de9d19bd.png', '15513284891', 0, 0, '一一', 0, 0, '', 4, NULL, '我是一个专家', '', NULL, NULL);
INSERT INTO `admin` VALUES (38, '1614011017', '9e2cce5cd9c9514265910069fb03c58e', '2020/5/15 上午9:50:16', 1, 4, 'd6bd0c61def61fe39a482d9614b9d9f6', '/uploads/20200514/8c49f8a221eaea9f2ca389b620428430.jpg', '15513284891', 13, 1, '贺锦华', 4, 3, '[]', 0, NULL, NULL, NULL, NULL, '[{\"id\":16,\"name\":\"\"}]');
INSERT INTO `admin` VALUES (35, '1614011014', 'f61e0c7bffdea7f345313e8095f3f459', '2020/5/5 上午10:51:05', 1, 4, '0ae8d6c29269d440a34504d8075483af', '/uploads/20200505/7d4df4950cbefb659fbcc45f256571e2.jpg', '15513284891', 6, 3, '大大', 4, 3, '[{\"id\":14,\"name\":\"这是一个项目\"}]', 0, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `admin` VALUES (34, '1614011013', '8ab50459f1d70174e4c16e3ad6972b1a', '2020/5/5 上午10:32:11', 1, 4, 'b8e5f728f9ea547415214c260450c30c', '/uploads/20200505/58268de19ec372b15b5c5a0129463d67.png', '15513284891', 4, 2, '小小', 1, 2, '', 0, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `admin` VALUES (36, '1614011015', '943c0d6aef6829429fd4aa0cfde17516', '2020/5/6 下午3:52:43', 1, 4, '35d11c1eb0b7f08d0e915f398ad42a53', '/uploads/20200506/59f45b5cbf48a46c1b5dbfb9b72b6bd6.jpg', '15513284891', 1, 3, '李四', 2, 2, '[{\"id\":15,\"name\":\"项目\"}]', 0, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `admin` VALUES (37, '1614011016', '058284cca11129ad721f3131301de510', '2020/5/11 上午11:47:10', 1, 4, 'ed263cf3ebd90d74ab702816ff07c2a6', '/uploads/20200506/19e43b02d253678552afe7cdd07efa17.jpg', '15513284891', 6, 1, '王五', 4, 3, '[{\"id\":15,\"name\":\"项目\"}]', 0, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `admin` VALUES (40, '1614011019', '9d496606bb9f462b2999513d4d7cd0b0', '2020/5/16 下午12:39:46', 1, 2, '1992e13726a7330296d0bc15d612eb76', '/uploads/20200514/c0e0b5c2abc36284cb44d8f67081df46.jpg', '15513284891', 13, 1, '秦伟', 4, 3, '', 0, '软件学院领导', NULL, NULL, NULL, NULL);
INSERT INTO `admin` VALUES (41, '1614011020', 'a0efba0bd4f609c3adf6f85b558302dc', '2020/5/18 上午9:58:00', 1, 3, 'fd1903aaa121f37fa21603d8f242d9d0', '/uploads/20200514/df3138ed32f6caad401bc67ede9736f1.jpg', '15513284891', 0, 0, '阴继鹏', 0, 0, '', 6, NULL, '我是一个教学综合改革类专家！', '[]', '[{\"id\":16,\"name\":\"\"}]', NULL);
INSERT INTO `admin` VALUES (42, '1614011021', '82d55a60ebdfa1eeea2a5de43f56a2c8', '2020/5/14 下午12:21:15', 1, 4, '74a7d53bc6f38822c3b296e55145f74c', '/uploads/20200514/b48fdc15a9baf2df8b735ebdacb4e82a.jpg', '15513284891', 13, 1, '王宣', 1, 2, '', 0, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `admin` VALUES (43, '1614011022', '540cc6141524ca559c4c0db196421ecc', '2020/5/14 下午12:24:04', 1, 4, 'ebab6151852e53d357ce169e3c8ae83e', '/uploads/20200514/8127db585f87fd0e69fd35a22b0a4e58.jpg', '15513284891', 13, 1, '张汪洋', 2, 1, '', 0, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `admin` VALUES (44, '1614011023', 'cb3dec0c831b48d3a4d468650619d229', '2020/5/14 下午2:19:47', 1, 3, 'de6efbce46a41119f0f89c917049d963', '/uploads/20200514/3c71c785683eafd562c0fe5bd91b5bcf.jpg', '15513284891', 0, 0, '瑜', 0, 0, '', 6, NULL, '我是一个师资队伍建设类专家。', '[]', '[{\"id\":16,\"name\":\"\"}]', NULL);
INSERT INTO `admin` VALUES (45, '1614011024', 'a7a54aaba749d64d61c91cfe95c3a966', '2020/5/16 上午11:23:06', 1, 4, '89be2ceb3c794557494f6b4c0d1671c2', '/uploads/20200516/61a5f63430121aa5061605c1cd351d60.jpg', '15513284891', 13, 1, '杜文华', 4, 3, '[]', 0, NULL, NULL, NULL, NULL, '[{\"id\":19,\"name\":\"\"}]');
INSERT INTO `admin` VALUES (46, '1614011025', '9fed84d98b4827e794d9ad992898637e', '2020/5/16 上午11:31:30', 1, 4, 'fd4e843a9d7e9723c3a67c904c9e8687', '/uploads/20200516/45ae5c4fcd4e83ca90233d0ddd519056.jpg', '15513284891', 13, 1, '曾志强', 2, 2, '[]', 0, NULL, NULL, NULL, NULL, '[{\"id\":19,\"name\":\"\"}]');
INSERT INTO `admin` VALUES (47, '1614011026', '9888bea60ce61ef596751df09238f0fb', '2020/5/16 上午11:41:31', 1, 4, '398a4ae68cc1366de3205ff62c101efe', '/uploads/20200516/f798c1b050a8250b4d668ab35fe41204.jpg', '15513284891', 13, 1, '祝锡晶', 3, 2, '[]', 0, NULL, NULL, NULL, NULL, '[{\"id\":19,\"name\":\"\"}]');
INSERT INTO `admin` VALUES (48, '1614011027', '082b127cf86df4ffd81636da1e4041e4', '2020/5/16 上午11:50:31', 1, 4, '19dea9ae1ab021dda75176317a018a96', '/uploads/20200516/fff29a1eaf867041eaf4be87a685c60e.png', '15513284891', 13, 4, '董磊', 1, 2, '[]', 0, NULL, NULL, NULL, NULL, '[{\"id\":19,\"name\":\"\"}]');
INSERT INTO `admin` VALUES (49, '1614011028', 'e3ffc980ba163b97fd4205bb1a81d691', '2020/5/16 上午11:59:41', 1, 4, '2c171effd4f6a258c85bdea32e96ba96', '/uploads/20200516/28030f1da1c6fa4b915fabcd36abca8f.jpg', '15513284891', 13, 1, '黎相孟', 4, 3, '[]', 0, NULL, NULL, NULL, NULL, '[{\"id\":19,\"name\":\"\"}]');
INSERT INTO `admin` VALUES (50, '1614011029', 'cbc8f5d2010cf4926a481f815c6fba07', '2020/5/18 上午9:58:28', 1, 4, 'fe0e2b76e5b46b4713288c89830c4743', '/uploads/20200516/d8febe6bb6c199d1ace550025180f857.jpg', '15513284891', 13, 1, '梅林玉', 3, 3, '', 0, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `admin` VALUES (51, '1614011030', 'e6cd2f0d760ed8a3f624c92a84b8ed6a', '2020/5/16 下午12:16:15', 1, 3, '2c39ac1efbbc3e540548103ea599cf61', '/uploads/20200516/f5bb2f6d4482a803d03d390030aeee31.jpg', '15513284891', 0, 0, '杜琳玲', 0, 0, '', 7, NULL, '我是一个师资队伍建设类专家。', '[]', '[{\"id\":19,\"name\":\"\"}]', NULL);

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `catname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '栏目名称',
  `enname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '路由名称',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 15 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of category
-- ----------------------------
INSERT INTO `category` VALUES (1, '首页', 'Show');
INSERT INTO `category` VALUES (2, '新闻资讯', 'News');
INSERT INTO `category` VALUES (3, '校内资讯', 'SchoolNews');
INSERT INTO `category` VALUES (4, '信息通知', 'Notice');
INSERT INTO `category` VALUES (6, '会议活动', 'Meeting');
INSERT INTO `category` VALUES (7, '关于网站', 'About');

-- ----------------------------
-- Table structure for college
-- ----------------------------
DROP TABLE IF EXISTS `college`;
CREATE TABLE `college`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `college` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '学院名称',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of college
-- ----------------------------
INSERT INTO `college` VALUES (1, '机电工程学院');
INSERT INTO `college` VALUES (2, '机械工程学院');
INSERT INTO `college` VALUES (3, '材料科学与工程学院');
INSERT INTO `college` VALUES (4, '化学工程与技术学院');
INSERT INTO `college` VALUES (5, '信息与通信工程学院');
INSERT INTO `college` VALUES (6, '仪器与电子学院');
INSERT INTO `college` VALUES (7, '大数据学院');
INSERT INTO `college` VALUES (8, '理学院');
INSERT INTO `college` VALUES (9, '经济与管理学院');
INSERT INTO `college` VALUES (10, '人文社会科学学院');
INSERT INTO `college` VALUES (11, '体育学院');
INSERT INTO `college` VALUES (12, '艺术学院');
INSERT INTO `college` VALUES (13, '软件学院');
INSERT INTO `college` VALUES (14, '环境与安全工程学院');
INSERT INTO `college` VALUES (15, '电气与控制工程学院');
INSERT INTO `college` VALUES (16, '能源动力工程学院');
INSERT INTO `college` VALUES (17, '无');

-- ----------------------------
-- Table structure for department
-- ----------------------------
DROP TABLE IF EXISTS `department`;
CREATE TABLE `department`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '部门名称',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of department
-- ----------------------------
INSERT INTO `department` VALUES (1, '纪检部门');
INSERT INTO `department` VALUES (2, '后勤部门');
INSERT INTO `department` VALUES (3, '审核部门');
INSERT INTO `department` VALUES (4, '财务部门');

-- ----------------------------
-- Table structure for meeting
-- ----------------------------
DROP TABLE IF EXISTS `meeting`;
CREATE TABLE `meeting`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `thunb` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `content` varchar(5000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `file` varchar(5000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'meeting',
  `college` int(11) NOT NULL DEFAULT 17,
  `abroad` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of meeting
-- ----------------------------
INSERT INTO `meeting` VALUES (1, '这是一个会议?', NULL, '1', '\"[]\"', '2020/5/15 下午2:16:50', '1', 'meeting', 2, 1);
INSERT INTO `meeting` VALUES (2, '会议', NULL, '这是信息', '[]', '2020/5/17 下午7:13:00', '这是一段回忆信息', 'meeting', 13, 2);

-- ----------------------------
-- Table structure for news
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '新闻/文件标题',
  `thumb` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '新闻缩略图',
  `content` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '新闻内容',
  `cid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '2' COMMENT '所属栏目',
  `abroad` int(11) NULL DEFAULT NULL COMMENT '1.国内2.国外',
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '文章附属文件',
  `description` varchar(5000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '咨询内容',
  `time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '发布时间',
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'news',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of news
-- ----------------------------
INSERT INTO `news` VALUES (1, '资讯', '[{\"name\":\"9\",\"url\":\"/uploads/20200514/c4009163c21f6fcf03472ef63961d6da.jpg\",\"uid\":1589437360469,\"status\":\"success\"}]', '1', '2', 2, NULL, '1', '2020/5/15 下午2:16:50', 'news');
INSERT INTO `news` VALUES (2, '资讯', '[{\"name\":\"9\",\"url\":\"/uploads/20200514/c4009163c21f6fcf03472ef63961d6da.jpg\",\"uid\":1589437360469,\"status\":\"success\"}]', '1', '2', 1, '[{\"name\":\"2019-09-29课程总结\",\"url\":\"/uploadsfile/20200514/26e25406607c3ec35eb3ebf0e60d4f2b.docx\",\"uid\":1589386755104,\"status\":\"success\"}]', '1', '2020/5/17 上午12:53:00', 'news');

-- ----------------------------
-- Table structure for notice
-- ----------------------------
DROP TABLE IF EXISTS `notice`;
CREATE TABLE `notice`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `thumb` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `content` varchar(5000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `file` varchar(5000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'notice',
  `abroad` int(11) NOT NULL,
  `college` int(11) NOT NULL DEFAULT 17,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of notice
-- ----------------------------
INSERT INTO `notice` VALUES (1, '这是一个资讯', '[{\"name\":\"9\",\"url\":\"/uploads/20200514/c4009163c21f6fcf03472ef63961d6da.jpg\",\"uid\":1589437360469,\"status\":\"success\"}]', '1', '\"[]\"', '2020/5/15 下午2:16:50', '1', 'notice', 2, 17, 1);
INSERT INTO `notice` VALUES (2, '2', '[{\"name\":\"9\",\"url\":\"/uploads/20200514/c4009163c21f6fcf03472ef63961d6da.jpg\",\"uid\":1589437360469,\"status\":\"success\"}]', '2', '[{\"name\":\"2019-09-29课程总结\",\"url\":\"/uploadsfile/20200518/f611c7ddfe4d87b810e0ccbc9f72c826.docx\",\"uid\":1589775863867,\"status\":\"success\"}]', '2020/5/18 下午12:23:36', '2', 'notice', 1, 13, 2);

-- ----------------------------
-- Table structure for project
-- ----------------------------
DROP TABLE IF EXISTS `project`;
CREATE TABLE `project`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '项目名称',
  `thumb` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '项目简介图片',
  `states` int(10) NOT NULL DEFAULT 3 COMMENT '1.审核通过 2.审核失败 3.未审核4.审核中',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '项目简介',
  `keywords` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '关键词',
  `aid` int(10) NOT NULL COMMENT '项目申报人/主持人/负责人',
  `level` int(10) NOT NULL COMMENT '1.重点 2.一般',
  `time` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '项目申报时间',
  `file` varchar(5000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '项目文件',
  `state2` int(20) NOT NULL DEFAULT 2 COMMENT '1.已成功申报 2.等待项目组成员全部申请之后',
  `project_number` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '项目编号（流水号）',
  `type` int(10) NOT NULL COMMENT '详见project_type表',
  `search_number` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '项目成员搜索项目的秘钥',
  `member` varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '项目组成员信息',
  `research_experts` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '对此项目评分的专家',
  `experts_state` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '0' COMMENT '0:未分配或者未分配完成\r\n1：已分配完成',
  `score` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '专家对于该项目的评分',
  `join` int(11) NULL DEFAULT 1 COMMENT '1.可加入 2.不可加入',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 20 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of project
-- ----------------------------
INSERT INTO `project` VALUES (13, '课程评估机制的建立与实施', '[{\"name\":\"9\",\"url\":\"/uploads/20200509/60a79116d28a4a74fecf57608b796763.jpg\"}]', 3, '这是一个的项目', '教学改革项目', 28, 1, '2019/10/8 下午8:11:54', '[{\"name\":\"2019-09-29课程总结\",\"url\":\"/uploadsfile/20200509/8c031e62bd2e4b9b402d60d3d40eef08.docx\"}]', 1, 'NU2019098710002ER', 7, '174504079395', '[{\"username\":\"1614011006\",\"realname\":\"王琦\"}]', '', '0', NULL, 1);
INSERT INTO `project` VALUES (12, '课堂教学质量评价指标体系研究与实践', '[{\"name\":\"9\",\"url\":\"/uploads/20200509/60a79116d28a4a74fecf57608b796763.jpg\"}]', 4, '这是一个的项目', '教学改革项目', 23, 2, '2019/10/8 上午10:56:06', '[{\"name\":\"2019-09-29课程总结\",\"url\":\"/uploadsfile/20200509/8c031e62bd2e4b9b402d60d3d40eef08.docx\"}]', 1, 'NU2019098520001ER', 5, '196312920791', '[{\"username\":\"1614011002\",\"realname\":\"李楠\"},{\"username\":\"1614011003\",\"realname\":\"韩景涛\"}]', '[{\"id\":30,\"realname\":\"张三\"}]', '1', '', 1);
INSERT INTO `project` VALUES (14, '这是一个项目', '[{\"name\":\"9\",\"url\":\"/uploads/20200509/60a79116d28a4a74fecf57608b796763.jpg\"}]', 3, '这是一个项目', '这是一个项目', 35, 2, '2020/5/5 上午10:55:01', '[{\"name\":\"2019-09-29课程总结\",\"url\":\"/uploadsfile/20200509/8c031e62bd2e4b9b402d60d3d40eef08.docx\"}]', 2, 'NU202004572003ER', 7, '794323650648', '[{\"username\":\"1614011014\",\"realname\":\"大大\"}]', NULL, '0', NULL, 1);
INSERT INTO `project` VALUES (15, '项目', '[{\"name\":\"9\",\"url\":\"/uploads/20200509/60a79116d28a4a74fecf57608b796763.jpg\"}]', 1, '这是一个项目', '项目', 37, 1, '2020/5/6 下午3:55:42', '[{\"name\":\"2019-09-29课程总结\",\"url\":\"/uploadsfile/20200509/8c031e62bd2e4b9b402d60d3d40eef08.docx\"}]', 1, 'NU202004671004ER', 7, '529583914206', '[{\"username\":\"1614011016\",\"realname\":\"王五\"},{\"username\":\"1614011015\",\"realname\":\"李四\"}]', '[]', '1', '[{\"score\":\"50\",\"name\":\"二二\"}]', 1);
INSERT INTO `project` VALUES (16, '课程教育改革', '[{\"name\":\"9\",\"url\":\"/uploads/20200514/c4009163c21f6fcf03472ef63961d6da.jpg\",\"uid\":1589437360469,\"status\":\"success\"}]', 1, '这是一个改革项目！', '项目', 38, 1, '2020/5/14 下午12:53:19', '[{\"name\":\"2019-09-29课程总结\",\"url\":\"/uploadsfile/20200514/fe33c57e678cef6fd9c0a9bfa753633a.docx\",\"uid\":1589437354783,\"status\":\"success\"}]', 1, 'NU20200414615ER', 6, '198678999951', '[{\"username\":\"1614011017\",\"realname\":\"贺锦华\"}]', '[{\"id\":41,\"realname\":\"阴继鹏\"},{\"id\":44,\"realname\":\"瑜\"}]', '1', '[{\"score\":\"60\",\"name\":\"阴继鹏\"},{\"score\":\"90\",\"name\":\"瑜\"}]', 1);
INSERT INTO `project` VALUES (19, '中北大学机械设计制造及自动化专业一流专业建设研究', '[{\"name\":\"9\",\"url\":\"/uploads/20200516/b33b9cbc9411a6a138e5dda6b74e721c.jpg\",\"uid\":1589607062702,\"status\":\"success\"}]', 1, '这是一个项目', '项目', 45, 1, '2020/5/16 下午1:30:36', '[{\"name\":\"2019-09-29课程总结\",\"url\":\"/uploadsfile/20200516/4fbe0a0657ee61cbdd1f4a1a48dd40a0.docx\",\"uid\":1589607057264,\"status\":\"success\"}]', 1, 'NU20200516716ER', 7, '264934506154', '[{\"username\":\"1614011024\",\"realname\":\"杜文华\"},{\"username\":\"1614011025\",\"realname\":\"曾志强\"},{\"username\":\"1614011026\",\"realname\":\"祝锡晶\"},{\"username\":\"1614011027\",\"realname\":\"董磊\"},{\"username\":\"1614011028\",\"realname\":\"黎相孟\"}]', '[{\"id\":51,\"realname\":\"杜琳玲\"}]', '1', '[{\"score\":\"50\",\"name\":\"杜琳玲\"}]', 2);

-- ----------------------------
-- Table structure for project_type
-- ----------------------------
DROP TABLE IF EXISTS `project_type`;
CREATE TABLE `project_type`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '项目类型',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of project_type
-- ----------------------------
INSERT INTO `project_type` VALUES (1, '教学综合改革类');
INSERT INTO `project_type` VALUES (2, '专业建设类');
INSERT INTO `project_type` VALUES (3, '人才培养改革类');
INSERT INTO `project_type` VALUES (4, '实践教学类');
INSERT INTO `project_type` VALUES (5, '创新创业类');
INSERT INTO `project_type` VALUES (6, '教学管理类');
INSERT INTO `project_type` VALUES (7, '师资队伍建设类');
INSERT INTO `project_type` VALUES (8, '新工科研究与实践类');

-- ----------------------------
-- Table structure for role
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role` int(11) NOT NULL COMMENT '角色',
  `route` varchar(3000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '不同角色，不同的路由权限',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of role
-- ----------------------------
INSERT INTO `role` VALUES (1, 1, '[{\"path\":\"/main\",\"name\":\"AdminMain\",\"children\":[{\"path\":\"admin\",\"name\":\"Admin\",\"meta\":{\"title\":\"个人中心\"},\"children\":[{\"path\":\"RootInformation\",\"name\":\"RootInformation\",\"meta\":{\"title\":\"资料修改\"}}]},{\"path\":\"Personnel\",\"name\":\"Personnel\",\"meta\":{\"title\":\"人事管理\"},\"children\":[{\"path\":\"UserShow\",\"name\":\"UserShow\",\"meta\":{\"title\":\"用户管理\"}},{\"path\":\"DepartmentManage\",\"name\":\"DepartmentManage\",\"meta\":{\"title\":\"部门管理\"}}]},{\"path\":\"Project\",\"name\":\"Project\",\"meta\":{\"title\":\"项目管理\"},\"children\":[{\"path\":\"AdminManage\",\"name\":\"AdminManage\",\"meta\":{\"title\":\"立项管理\"}},{\"path\":\"ProjectLibrary\",\"name\":\"ProjectLibrary\",\"meta\":{\"title\":\"项目库管理\"}}]},{\"path\":\"Message\",\"name\":\"Message\",\"meta\":{\"title\":\"前台信息管理\"},\"children\":[{\"path\":\"NavigationManagement\",\"name\":\"NavigationManagement\",\"meta\":{\"title\":\"导航管理\"}},{\"path\":\"NewsManage\",\"name\":\"NewsManage\",\"meta\":{\"title\":\"新闻资讯管理\"}},{\"path\":\"SchoolInformation\",\"name\":\"SchoolInformation\",\"meta\":{\"title\":\"校内资讯管理\"}},{\"path\":\"Notifications\",\"name\":\"Notifications\",\"meta\":{\"title\":\"信息通知管理\"}},{\"path\":\"MeetingManage\",\"name\":\"MeetingManage\",\"meta\":{\"title\":\"会议活动信息管理\"}}]}]}]');
INSERT INTO `role` VALUES (2, 2, '[{\"path\":\"/main\",\"name\":\"AdminMain\",\"children\":[{\"path\":\"admin\",\"name\":\"Admin\",\"meta\":{\"title\":\"个人中心\"},\"children\":[{\"path\":\"ChangeInformation\",\"name\":\"ChangeInformation\",\"meta\":{\"title\":\"资料修改\"}}]},{\"path\":\"Project\",\"name\":\"Project\",\"meta\":{\"title\":\"项目管理\"},\"children\":[{\"path\":\"LeaderManage\",\"name\":\"LeaderManage\",\"meta\":{\"title\":\"立项管理\"}},{\"path\":\"ProjectLibrary\",\"name\":\"ProjectLibrary\",\"meta\":{\"title\":\"项目库管理\"}}]}]}]');
INSERT INTO `role` VALUES (3, 3, '[{\"path\":\"/main\",\"name\":\"AdminMain\",\"children\":[{\"path\":\"admin\",\"name\":\"Admin\",\"meta\":{\"title\":\"个人中心\"},\"children\":[{\"path\":\"ExpertsInformation\",\"name\":\"ExpertsInformation\",\"meta\":{\"title\":\"资料修改\"}}]},{\"path\":\"Project\",\"name\":\"Project\",\"meta\":{\"title\":\"项目管理\"},\"children\":[{\"path\":\"ProjectManage\",\"name\":\"ProjectManage\",\"meta\":{\"title\":\"立项管理\"}},{\"path\":\"ProjectView\",\"name\":\"ProjectView\",\"meta\":{\"title\":\"项目查看\"}}]}]}]');
INSERT INTO `role` VALUES (4, 4, '[{\"path\":\"/main\",\"name\":\"AdminMain\",\"children\":[{\"path\":\"admin\",\"name\":\"Admin\",\"meta\":{\"title\":\"个人中心\"},\"children\":[{\"path\":\"ChangeInformation\",\"name\":\"ChangeInformation\",\"meta\":{\"title\":\"资料修改\"}},{\"path\":\"PersonalProject\",\"name\":\"PersonalProject\",\"meta\":{\"title\":\"个人项目查看\"}}]},{\"path\":\"Project\",\"name\":\"Project\",\"meta\":{\"title\":\"个人项目管理\"},\"children\":[{\"path\":\"ProjectApplication\",\"name\":\"ProjectApplication\",\"meta\":{\"title\":\"项目申请\"}},{\"path\":\"ProjectMember\",\"name\":\"ProjectMember\",\"meta\":{\"title\":\"项目成员管理\"}}]}]}]');

-- ----------------------------
-- Table structure for school_news
-- ----------------------------
DROP TABLE IF EXISTS `school_news`;
CREATE TABLE `school_news`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `thunb` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `content` varchar(5000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `file` varchar(5000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `abroad` int(11) NOT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'school',
  `college` int(11) NOT NULL DEFAULT 17,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of school_news
-- ----------------------------
INSERT INTO `school_news` VALUES (1, '这是一个资讯?这是一个资讯?这是一个资讯?', NULL, '1', '[{\"name\":\"2019-09-29课程总结\",\"url\":\"/uploadsfile/20200509/8c031e62bd2e4b9b402d60d3d40eef08.docx\"},{\"name\":\"2019-09-29课程总结\",\"url\":\"/uploadsfile/20200509/8c031e62bd2e4b9b402d60d3d40eef08.docx\"}]', '2020/5/15 下午2:16:50', '1', 2, 'school', 2);
INSERT INTO `school_news` VALUES (2, '1', NULL, '1', '[]', '2020/5/17 上午12:52:21', '1', 1, 'school', 17);
INSERT INTO `school_news` VALUES (3, '2', NULL, '2', '[]', '2020/5/17 上午12:53:00', '2', 2, 'school', 7);

SET FOREIGN_KEY_CHECKS = 1;
