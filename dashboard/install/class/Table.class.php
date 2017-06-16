<?php

class Table
{
	private $tablePrefix;
	private $tableType;
	private $query;
	
	public function __construct ($tablePrefix,$tableType) {
		$this->tablePrefix = $tablePrefix;
		$this->tableType = $tableType;
	}
	
	public function getQuery () {
		$query = "CREATE TABLE `".$this->tablePrefix."categories` (
		  `category_id` int(11) NOT NULL AUTO_INCREMENT,
		  `category_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `category_name2` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
		  PRIMARY KEY (`category_id`)
		) ENGINE=".$this->tableType." DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

		CREATE TABLE `".$this->tablePrefix."comments` (
		  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
		  `comment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  `comment` longtext COLLATE utf8_unicode_ci,
		  `post_id` int(11) DEFAULT NULL,
		  `comment_author` varchar(145) CHARACTER SET utf8 DEFAULT NULL,
		  `comment_date2` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
		  PRIMARY KEY (`comment_id`)
		) ENGINE=".$this->tableType." DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

		CREATE TABLE `".$this->tablePrefix."gallery` (
		  `gallery_id` int(11) NOT NULL AUTO_INCREMENT,
		  `gallery_value` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `post_id` int(11) DEFAULT NULL,
		  PRIMARY KEY (`gallery_id`)
		) ENGINE=".$this->tableType." DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


		CREATE TABLE `".$this->tablePrefix."posts` (
		  `post_id` int(11) NOT NULL AUTO_INCREMENT,
		  `post_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `post_introduction` longtext COLLATE utf8_unicode_ci,
		  `post_image` text CHARACTER SET utf8,
		  `post_content` longtext COLLATE utf8_unicode_ci,
		  `post_category` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
		  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  `post_author` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `post_status` varchar(45) CHARACTER SET utf8 DEFAULT 'publish',
		  `post_type` varchar(45) CHARACTER SET utf8 DEFAULT 'post',
		  `comment_status` varchar(45) COLLATE utf8_unicode_ci DEFAULT 'open',
		  `post_gallery` longtext CHARACTER SET utf8,
		  `post_name` varchar(225) COLLATE utf8_unicode_ci NOT NULL,
		  `post_date2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
		  PRIMARY KEY (`post_id`)
		) ENGINE=".$this->tableType." DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

		CREATE TABLE `".$this->tablePrefix."post_category` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `post_id` int(11) DEFAULT NULL,
		  `category_id` int(11) DEFAULT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=".$this->tableType." DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

		CREATE TABLE `".$this->tablePrefix."settings` (
		  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
		  `website_url` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `admin_package_url` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `host` varchar(120) CHARACTER SET utf8 DEFAULT NULL,
		  `user` varchar(120) CHARACTER SET utf8 DEFAULT NULL,
		  `password` varchar(120) CHARACTER SET utf8 DEFAULT NULL,
		  `dbname` varchar(120) CHARACTER SET utf8 DEFAULT NULL,
		  PRIMARY KEY (`setting_id`)
		) ENGINE=".$this->tableType." DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

		CREATE TABLE `".$this->tablePrefix."users` (
		  `user_id` int(11) NOT NULL AUTO_INCREMENT,
		  `username` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `password` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `first_name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `last_name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `born_date` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `country` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `city` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `user_status` int(11) DEFAULT '1',
		  `register_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  `phone_number` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `user_gender` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `user_address` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `user_activation` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
		  `new_psw` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
		  PRIMARY KEY (`user_id`)
		) ENGINE=".$this->tableType." DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

		INSERT INTO `".$this->tablePrefix."users` (`user_id`, `username`, `password`, `first_name`, `last_name`, `born_date`, `email`, `country`, `city`, `user_status`, `register_date`, `phone_number`, `user_gender`, `user_address`, `user_activation`, `new_psw`) VALUES
		(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin', 'Admin', NULL, 'your@email.com', NULL, NULL, 351, NOW(), NULL, NULL, NULL, NULL, '586a26670825b');

		CREATE TABLE `".$this->tablePrefix."user_activity` (
		  `activity_id` int(11) NOT NULL AUTO_INCREMENT,
		  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
		  `activity` text COLLATE utf8_unicode_ci NOT NULL,
		  `post_id` int(11) NOT NULL,
		  `type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
		  `date` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
		  `username2` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
		  PRIMARY KEY (`activity_id`)
		) ENGINE=".$this->tableType." DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

		CREATE TABLE `".$this->tablePrefix."user_status` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `status_number` int(11) DEFAULT NULL,
		  `status_name` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=".$this->tableType." DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

		INSERT INTO `".$this->tablePrefix."user_status` (`id`, `status_number`, `status_name`) VALUES
		(1, 351, 'Owner'),
		(2, 0, 'Inactive'),
		(3, 1, 'Check email validation'),
		(4, 2, 'User'),
		(5, 3, 'Writer'),
		(6, 250, 'Moderator'),
		(7, 350, 'Administrator');
		";
		return $query;
	}
}



?>