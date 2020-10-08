-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2020-09-08 13:34:01
-- サーバのバージョン： 10.4.11-MariaDB
-- PHP のバージョン: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `bbs`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `bbs_content`
--

CREATE TABLE `bbs_content` (
  `id` int(10) UNSIGNED NOT NULL,
  `module_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `time` datetime NOT NULL,
  `member_id` int(10) UNSIGNED NOT NULL,
  `times` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `bbs_content`
--

INSERT INTO `bbs_content` (`id`, `module_id`, `title`, `content`, `time`, `member_id`, `times`) VALUES
(1, 13, '新闻帖子测试', '新闻帖子测试', '2020-08-31 22:15:36', 4, 8),
(7, 10, 'cba标题2', 'cba标题2', '2020-09-01 00:48:10', 4, 152),
(6, 10, 'cba标题', '', '2020-09-01 00:47:58', 4, 11),
(10, 11, 'cba的标题', 'cba的内容', '2020-09-01 23:20:10', 1, 12),
(9, 10, 'cba标题1111', '', '2020-09-01 01:25:29', 4, 11),
(11, 15, '军事标题', '军事内容', '2020-09-01 23:57:27', 1, 5),
(12, 10, '<>test', '<>test', '2020-09-02 10:46:29', 1, 87),
(35, 15, '<span style=\"color:red;\">aaa</span>', '<span style=\"color:red;\">aaa</span>\r\n<span style=\"color:red;\">aaa</span>\r\n<span style=\"color:red;\">aaa</span>\r\ns', '2020-09-03 21:31:51', 1, 3),
(32, 12, 'NBA标题', '<br /><br />\r\nnba内容帖子nba内容帖子nba内容帖子\r\nhttp://localhost:8066/bilibiliphp/bbs/home/content_update.php?id=32&return_rul=/bilibiliphp/bbs/home/list_father.php?id=17', '2020-09-02 11:19:18', 1, 4);

-- --------------------------------------------------------

--
-- テーブルの構造 `bbs_father_module`
--

CREATE TABLE `bbs_father_module` (
  `id` int(10) UNSIGNED NOT NULL,
  `module_name` varchar(50) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='父版块信息';

--
-- テーブルのデータのダンプ `bbs_father_module`
--

INSERT INTO `bbs_father_module` (`id`, `module_name`, `sort`) VALUES
(20, '军事', 0),
(18, '新闻', 1),
(19, '测试', 0),
(17, '体育', 2);

-- --------------------------------------------------------

--
-- テーブルの構造 `bbs_manage`
--

CREATE TABLE `bbs_manage` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(32) NOT NULL,
  `pwd` varchar(32) NOT NULL,
  `create_time` datetime NOT NULL,
  `level` tinyint(3) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `bbs_manage`
--

INSERT INTO `bbs_manage` (`id`, `name`, `pwd`, `create_time`, `level`) VALUES
(7, '王玉强', '96e79218965eb72c92a549dd5a330112', '2020-09-05 20:26:53', 1),
(4, 'admin', '96e79218965eb72c92a549dd5a330112', '2020-09-05 16:14:50', 0);

-- --------------------------------------------------------

--
-- テーブルの構造 `bbs_member`
--

CREATE TABLE `bbs_member` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(32) NOT NULL,
  `pwd` varchar(32) NOT NULL,
  `photo` varchar(255) NOT NULL DEFAULT '‘’',
  `register_time` datetime NOT NULL,
  `last_time` datetime NOT NULL DEFAULT '2020-09-01 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `bbs_member`
--

INSERT INTO `bbs_member` (`id`, `name`, `pwd`, `photo`, `register_time`, `last_time`) VALUES
(1, '王玉强', 'e10adc3949ba59abbe56e057f20f883e', 'uploads/2020-09-05/20200905072932_715545f53223cec3a5508784162.png', '2020-08-31 12:26:00', '0000-00-00 00:00:00'),
(2, 'admin', 'e10adc3949ba59abbe56e057f20f883e', '', '2020-08-31 14:29:02', '0000-00-00 00:00:00'),
(3, '123', 'e10adc3949ba59abbe56e057f20f883e', '', '2020-08-31 14:45:01', '0000-00-00 00:00:00'),
(4, 'test', '96e79218965eb72c92a549dd5a330112', '', '2020-08-31 19:25:26', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `bbs_replay`
--

CREATE TABLE `bbs_replay` (
  `id` int(10) UNSIGNED NOT NULL,
  `content_id` int(10) UNSIGNED NOT NULL,
  `quote_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `content` text NOT NULL,
  `time` datetime NOT NULL,
  `member_id` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `bbs_replay`
--

INSERT INTO `bbs_replay` (`id`, `content_id`, `quote_id`, `content`, `time`, `member_id`) VALUES
(1, 7, 0, '回复成功回复成功回复成功回复成功回复成功回复成功', '2020-09-02 13:24:30', 1),
(2, 7, 0, '阿萨啊啊啊啊啊啊啊啊啊啊啊啊啊', '2020-09-02 14:45:47', 1),
(3, 7, 0, '1111111111111111111111111111', '2020-09-02 15:04:43', 1),
(4, 7, 0, '11111111111111', '2020-09-02 15:04:54', 1),
(5, 7, 0, '<h1>aaaa</h1>', '2020-09-02 23:02:05', 1),
(6, 10, 0, 'aaaaaaaaaaaaaaaaaaaaaaaa', '2020-09-02 23:55:51', 1),
(7, 6, 0, 'fafasfasfasfafsa', '2020-09-02 23:57:18', 1),
(8, 13, 0, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2020-09-03 00:14:42', 1),
(9, 12, 0, '&lt;h1&gt;fafaf&lt;/h1&gt;', '2020-09-03 00:25:38', 1),
(10, 12, 0, '<a href =\" #\">a</a>', '2020-09-03 00:29:42', 1),
(11, 12, 0, '<a>aaaaaaaaaaaaa</a>', '2020-09-03 00:30:38', 1),
(12, 12, 10, '<a href =\" #\">a</a> 非法输入引用测试', '2020-09-03 00:36:07', 1),
(13, 12, 12, '按时大大大大大2222222222222', '2020-09-03 00:55:25', 1),
(14, 12, 9, '引用一楼的回复测试啊啊啊', '2020-09-03 01:05:27', 1),
(15, 7, 1, '引用1楼测试回复啊111111', '2020-09-03 01:09:56', 1),
(16, 12, 10, '啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊', '2020-09-03 01:14:17', 1),
(17, 12, 16, '啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊', '2020-09-03 01:16:19', 1),
(18, 11, 0, '军事帖子回复内容测试啊', '2020-09-03 01:26:27', 1),
(19, 11, 18, '范德萨发生的方式放松放松', '2020-09-03 01:26:44', 1),
(20, 32, 0, '<h1>aaaaaaaaaaaaaaaa</h1>', '2020-09-03 20:15:11', 1),
(21, 7, 0, '111111111111111111', '2020-09-05 21:51:38', 1);

-- --------------------------------------------------------

--
-- テーブルの構造 `bbs_son_module`
--

CREATE TABLE `bbs_son_module` (
  `id` int(10) UNSIGNED NOT NULL,
  `father_module_id` int(11) NOT NULL,
  `module_name` varchar(50) NOT NULL,
  `info` varchar(255) NOT NULL,
  `member_id` int(11) NOT NULL DEFAULT 0,
  `sort` int(3) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `bbs_son_module`
--

INSERT INTO `bbs_son_module` (`id`, `father_module_id`, `module_name`, `info`, `member_id`, `sort`) VALUES
(10, 17, '中国CBA', '中国CBA', 0, 2),
(11, 17, 'CBA', 'test', 0, 1),
(12, 17, 'NBA', 'hello world', 0, 3),
(13, 18, '国际新闻', '新闻子版块1', 0, 1),
(14, 19, '测试', '测试6', 0, 0),
(15, 20, '军事子版块', '军事子i', 0, 0);

-- --------------------------------------------------------

--
-- テーブルの構造 `bbs_web_set`
--

CREATE TABLE `bbs_web_set` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `bbs_web_set`
--

INSERT INTO `bbs_web_set` (`id`, `title`, `keyword`, `description`) VALUES
(1, '默认标题 bbs', '默认关键字bbs', '默认描述bbs');

-- --------------------------------------------------------

--
-- テーブルの構造 `shop_list`
--

CREATE TABLE `shop_list` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `jan` varchar(15) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 2
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='商品一览';

--
-- テーブルのデータのダンプ `shop_list`
--

INSERT INTO `shop_list` (`id`, `name`, `jan`, `status`) VALUES
(1, '商品1', '123456789', 2),
(2, '商品2', '123456789', 1),
(3, '商品3', '123465', 0),
(5, 'test', 'abc', 1);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `bbs_content`
--
ALTER TABLE `bbs_content`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `bbs_father_module`
--
ALTER TABLE `bbs_father_module`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `bbs_manage`
--
ALTER TABLE `bbs_manage`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `bbs_member`
--
ALTER TABLE `bbs_member`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `bbs_replay`
--
ALTER TABLE `bbs_replay`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `bbs_son_module`
--
ALTER TABLE `bbs_son_module`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `bbs_web_set`
--
ALTER TABLE `bbs_web_set`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `shop_list`
--
ALTER TABLE `shop_list`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルのAUTO_INCREMENT
--

--
-- テーブルのAUTO_INCREMENT `bbs_content`
--
ALTER TABLE `bbs_content`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- テーブルのAUTO_INCREMENT `bbs_father_module`
--
ALTER TABLE `bbs_father_module`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- テーブルのAUTO_INCREMENT `bbs_manage`
--
ALTER TABLE `bbs_manage`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- テーブルのAUTO_INCREMENT `bbs_member`
--
ALTER TABLE `bbs_member`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- テーブルのAUTO_INCREMENT `bbs_replay`
--
ALTER TABLE `bbs_replay`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- テーブルのAUTO_INCREMENT `bbs_son_module`
--
ALTER TABLE `bbs_son_module`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- テーブルのAUTO_INCREMENT `bbs_web_set`
--
ALTER TABLE `bbs_web_set`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- テーブルのAUTO_INCREMENT `shop_list`
--
ALTER TABLE `shop_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
