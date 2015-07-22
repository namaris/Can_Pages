<ul style="margin-left:40px; font-size:1.1em;" class="global">
<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set("display_errors", 1);
// TABLES -------------------------------------------------

$sql = query("CREATE TABLE IF NOT EXISTS `capabilities` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `capability` varchar(255) NOT NULL,
  `1` tinyint(1) NOT NULL,
  `2` tinyint(1) NOT NULL,
  `3` tinyint(1) NOT NULL,
  `4` tinyint(1) NOT NULL,
  `5` tinyint(1) NOT NULL,
  `6` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;")
 or die(mysql_error()); 

echo "<li>The Capabilities table has been created. </li>";

// --------------------------------------------------------

$sql = query("CREATE TABLE IF NOT EXISTS `events` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `outlet_id` int(255) NOT NULL,
  `property_id` int(11) NOT NULL,
  `subject` varchar(255)  NOT NULL,
  `description` text  NOT NULL,
  `event_date` date NOT NULL,
  `start_time` time NULL,
  `end_time` time NULL,
  `open_to` varchar(255) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `advertise_start` int(10) DEFAULT NULL,
  `price` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `outlet_id` (`outlet_id`,`event_date`),
  KEY `property_id` (`property_id`),
  KEY `event_date` (`event_date`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;")
 or die(mysql_error()); 

echo "<li>The Events table has been created. </li>";

// --------------------------------------------------------

$sql = query("CREATE TABLE IF NOT EXISTS `maitre` (
  `maitre_id` int(11) NOT NULL AUTO_INCREMENT,
  `maitre_outlet_id` int(11) NOT NULL,
  `maitre_date` date DEFAULT NULL,
  `maitre_comment_day` varchar(255) DEFAULT NULL,
  `maitre_comment_day_timestamp` datetime DEFAULT NULL,
  `maitre_comment_day_name` varchar(30) DEFAULT NULL,
  `maitre_comment_availability` varchar(255) DEFAULT NULL,
  `maitre_comment_availability_timestamp` datetime DEFAULT NULL,
  `maitre_comment_availability_name` varchar(30) DEFAULT NULL,
  `maitre_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `maitre_ip` varchar(20) DEFAULT NULL,
  `maitre_author` varchar(255) DEFAULT NULL,
  `outlet_child_tables` int(5) DEFAULT '0',
  `outlet_child_capacity` int(5) DEFAULT '0',
  `outlet_capacity_timestamp` datetime DEFAULT NULL,
  `outlet_child_passer_max_pax` int(12) DEFAULT NULL,
  `outlet_child_dayoff` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`maitre_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;")
 or die(mysql_error()); 

echo "<li>The Maitre table has been created. </li>";

// --------------------------------------------------------

$sql = query("CREATE TABLE IF NOT EXISTS `outlets` (
  `outlet_id` int(11) NOT NULL AUTO_INCREMENT,
  `outlet_name` varchar(50) DEFAULT NULL,
  `outlet_description` text,
  `outlet_description_en` text,
  `cuisine_style` varchar(255) DEFAULT NULL,
  `property_id` tinyint(12) DEFAULT NULL,
  `outlet_max_capacity` int(5) DEFAULT '0',
  `outlet_max_tables` int(3) DEFAULT '0',
  `outlet_open_time` time DEFAULT NULL,
  `outlet_close_time` time DEFAULT NULL,
  `outlet_timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `outlet_closeday` varchar(30) NULL DEFAULT '',
  `saison_start` varchar(4) NULL DEFAULT '',
  `saison_end` varchar(4) NULL DEFAULT '',
  `saison_year` int(4) DEFAULT NULL,
  `webform` char(1) DEFAULT '0',
  `limit_password` varchar(255) DEFAULT NULL,
  `confirmation_email` varchar(255) DEFAULT NULL,
  `passerby_max_pax` int(12) NOT NULL,
  `avg_duration` varchar(5) NOT NULL,
  `1_open_time` time DEFAULT NULL,
  `1_close_time` time DEFAULT NULL,
  `2_open_time` time DEFAULT NULL,
  `2_close_time` time DEFAULT NULL,
  `3_open_time` time DEFAULT NULL,
  `3_close_time` time DEFAULT NULL,
  `4_open_time` time DEFAULT NULL,
  `4_close_time` time DEFAULT NULL,
  `5_open_time` time DEFAULT NULL,
  `5_close_time` time DEFAULT NULL,
  `6_open_time` time DEFAULT NULL,
  `6_close_time` time DEFAULT NULL,
  `0_open_time` time DEFAULT NULL,
  `0_close_time` time DEFAULT NULL,
  `1_open_break` time DEFAULT NULL,
  `1_close_break` time DEFAULT NULL,
  `2_open_break` time DEFAULT NULL,
  `2_close_break` time DEFAULT NULL,
  `3_open_break` time DEFAULT NULL,
  `3_close_break` time DEFAULT NULL,
  `4_open_break` time DEFAULT NULL,
  `4_close_break` time DEFAULT NULL,
  `5_open_break` time DEFAULT NULL,
  `5_close_break` time DEFAULT NULL,
  `6_open_break` time DEFAULT NULL,
  `6_close_break` time DEFAULT NULL,
  `0_open_break` time DEFAULT NULL,
  `0_close_break` time DEFAULT NULL,
  PRIMARY KEY (`outlet_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;")
 or die(mysql_error());
 
 
echo "<li>The Outlets table has been created. </li>";

// --------------------------------------------------------

$sql = query("CREATE TABLE IF NOT EXISTS `plc_autologin` (
  `key_id` char(32)  NOT NULL,
  `user_id` mediumint(8) NOT NULL DEFAULT '0',
  `user_agent` varchar(150)  DEFAULT NULL,
  `last_ip` varchar(40)  DEFAULT NULL,
  `last_login` timestamp DEFAULT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;")
 or die(mysql_error());
 
echo "<li>The PLC-Autologins table has been created. </li>";

// --------------------------------------------------------

$sql = query("CREATE TABLE IF NOT EXISTS `plc_sessions` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `login_attempts` mediumint(1) unsigned NOT NULL DEFAULT '0',
  `last_activity` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;")
 or die(mysql_error()); 

echo "<li>The PLC-Sessions table has been created. </li>";

// --------------------------------------------------------

$sql = query("CREATE TABLE IF NOT EXISTS `plc_users` (
  `userID` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL DEFAULT '',
  `realname` VARCHAR( 255 ) NOT NULL DEFAULT '',
  `password` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(150) NOT NULL DEFAULT '',
  `role` smallint(2) NOT NULL DEFAULT '5',
  `property_id` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `confirm_code` varchar(255) DEFAULT NULL,
  `last_ip` varchar(40) CHARACTER SET utf8  NOT NULL,
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `autofill` INT NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`userID`),
  KEY `password` (`password`),
  KEY `active` (`active`),
  KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;")
 or die(mysql_error());
 
 echo "<li>The PLC-Users table has been created. </li>";

// --------------------------------------------------------

$sql = query("CREATE TABLE IF NOT EXISTS `properties` (
  `id` tinyint(12) NOT NULL AUTO_INCREMENT,
  `name` varchar(255)  NOT NULL,
  `street` varchar(255) DEFAULT NULL,
  `zip` varchar(12)  DEFAULT NULL,
  `city` varchar(255)  DEFAULT NULL,
  `country` varchar(255)  DEFAULT NULL,
  `contactperson` varchar(100)  DEFAULT NULL,
  `phone` varchar(50)  DEFAULT NULL,
  `fax` varchar(50)  DEFAULT NULL,
  `email` varchar(100)  DEFAULT NULL,
  `website` varchar(200)  DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `img_filename` varchar(255)  DEFAULT NULL,
  `logo_filename` varchar(255)  DEFAULT NULL,
  `status` varchar(10)  NOT NULL DEFAULT 'active',
  `social_fb` VARCHAR( 255 ) DEFAULT NULL,
  `social_tw` VARCHAR( 255 ) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;")
 or die(mysql_error()); 

echo "<li>The Properties table has been created. </li>";

// --------------------------------------------------------

$sql = query("CREATE TABLE IF NOT EXISTS `reservations` (
  `reservation_id` int(11) NOT NULL AUTO_INCREMENT,
  `reservation_bookingnumber` varchar(12) DEFAULT NULL,
  `reservation_outlet_id` int(11) NOT NULL DEFAULT '0',
  `reservation_date` date DEFAULT NULL,
  `reservation_time` time DEFAULT '12:34:00',
  `reservation_title` varchar(2) DEFAULT NULL,
  `reservation_guest_name` text,
  `reservation_guest_adress` varchar(255) NOT NULL DEFAULT '',
  `reservation_guest_city` varchar(255) NOT NULL DEFAULT '',
  `reservation_guest_email` varchar(80) NOT NULL DEFAULT '',
  `reservation_guest_phone` varchar(50) NOT NULL DEFAULT '',
  `reservation_pax` int(11) DEFAULT '0',
  `reservation_hotelguest_yn` varchar(20) DEFAULT 'x',
  `reservation_notes` varchar(255) DEFAULT NULL,
  `reservation_booker_name` varchar(20) DEFAULT NULL,
  `reservation_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reservation_ip` varchar(20) DEFAULT NULL,
  `reservation_hidden` int(11) DEFAULT '0',
  `reservation_wait` int(11) NULL DEFAULT '0',
  `repeat_id` int(11) NULL DEFAULT '0',
  `reservation_bill` varchar(5) NULL DEFAULT 'mail',
  `reservation_discount` int(3) DEFAULT NULL,
  `reservation_bill_paid` varchar(10) NULL DEFAULT '',
  `reservation_billet_sent` varchar(10) NULL DEFAULT '',
  `reservation_parkticket` int(3) DEFAULT NULL,
  `reservation_table` varchar(25) DEFAULT NULL,
  `reservation_status` varchar(25) DEFAULT 'NYA',
  `reservation_advertise` varchar(5) NOT NULL DEFAULT 'NO',
  `reservation_referer` text,
  PRIMARY KEY (`reservation_id`),
  KEY `reservation_outlet_id` (`reservation_outlet_id`),
  KEY `reservation_date` (`reservation_date`),
  KEY `reservation_hidden` (`reservation_hidden`),
  KEY `reservation_wait` (`reservation_wait`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;")
 or die(mysql_error()); 

echo "<li>The Reservations table has been created. </li>";

// --------------------------------------------------------


$sql = query("CREATE TABLE IF NOT EXISTS `res_history` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `reservation_id` int(255) NOT NULL,
  `author` varchar(255)  NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `reservation_id` (`reservation_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;")
 or die(mysql_error());
 
echo "<li>The Reservations History table has been created. </li>";


// --------------------------------------------------------

$sql = query("CREATE TABLE IF NOT EXISTS `res_repeat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_date` date NOT NULL DEFAULT '0000-00-00',
  `end_date` date NOT NULL DEFAULT '0000-00-00',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `create_by` varchar(80) NOT NULL DEFAULT 'NO BOOKER - ERROR',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;")
 or die(mysql_error());
 
echo "<li>The Repeat Reservations table has been created. </li>";

// --------------------------------------------------------

$sql = query("CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `property_id` int(255) NOT NULL,
  `language` varchar(8)  NOT NULL,
  `timezone` varchar(80)  NOT NULL,
  `timeformat` int(2) NOT NULL,
  `timeintervall` int(2) NOT NULL,
  `dateformat` varchar(15)  NOT NULL,
  `dateformat_short` varchar(15)  NOT NULL,
  `datepickerformat` varchar(15)  NOT NULL,
  `app_name` varchar(255)  NOT NULL,
  `max_menu` int(3) NOT NULL,
  `old_days` int(2) NOT NULL,
  `manual_lines` int(2) NOT NULL,
  `contactform_color_scheme` varchar(12)  NOT NULL DEFAULT 'grey',
  `contactform_background` varchar(7)  NOT NULL DEFAULT 'E0ECDB',
  `guest_type_text_HG` VARCHAR( 255 ) NOT NULL ,
  `guest_type_text_PASS` VARCHAR( 255 ) NOT NULL ,
  `guest_type_text_WALK` VARCHAR( 255 ) NOT NULL ,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;")
 or die(mysql_error());

echo "<li>The Settings table has been created. </li>";

// --------------------------------------------------------

$sql = query("CREATE TABLE IF NOT EXISTS `client_order` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `property_id` int(12) NOT NULL,
  `package_code` varchar(12)  NOT NULL,
  `order_date` date NOT NULL,
  `close_date` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;")
 or die(mysql_error());

echo "<li>The Client Order table has been created. </li>";

// DATA ---------------------------------------------------

$sql = query("INSERT INTO `capabilities` (`id`, `capability`, `1`, `2`, `3`, `4`, `5`, `6`) VALUES
(1, 'Settings-General', 1, 1, 0, 0, 0, 0),
(2, 'Settings-Outlets', 1, 1, 1, 0, 0, 0),
(3, 'Settings-Users', 1, 1, 0, 0, 0, 0),
(4, 'Page-Statistic', 1, 1, 1, 1, 0, 0),
(5, 'Page-Export', 1, 1, 1, 0, 0, 0),
(6, 'Page-System', 1, 1, 1, 1, 0, 0),
(7, 'Reservation-New', 1, 1, 1, 1, 1, 0),
(8, 'Reservation-Delete', 1, 1, 1, 1, 1, 0),
(9, 'Reservation-Edit', 1, 1, 1, 1, 1, 0),
(10, 'Daily-Outlet-Edit', 1, 1, 1, 1, 0, 0),
(11, 'Settings-Events', 1, 1, 1, 1, 0, 0),
(12, 'Property-Overview', 1, 0, 0, 0, 0, 0),
(13, 'Property-New', 1, 1, 1, 0, 0, 0);
")
 or die(mysql_error());

echo "<li>User Permissions have been set to default.</li>";


// API ---------------------------------------------------

$sql = query("CREATE TABLE IF NOT EXISTS `api_users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `token` varchar(60) DEFAULT NULL,
  `name` varchar(40) DEFAULT NULL,
  `website` varchar(60) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `confirm_code` varchar(255) NOT NULL,
  `request_count` int(10) unsigned DEFAULT NULL,
  `last_ip` varchar(40) CHARACTER SET utf8  NOT NULL,
  `last_login` date NOT NULL DEFAULT '0000-00-00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `token` (`token`),
  KEY `name` (`name`),
  KEY `request_count` (`request_count`),
  KEY `last_login` (`last_login`),
  KEY `modified` (`modified`),
  FULLTEXT KEY `description` (`description`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;")
 or die(mysql_error());

echo "<li>The API key table has been created. </li>";


// Plugins -------------------------------------------------

$query = "CREATE TABLE IF NOT EXISTS `plugins` (
      `filename` varchar(127) collate utf8_bin DEFAULT NULL,
      `action` tinyint(1) default '0',
      PRIMARY KEY  (`filename`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1;";
  $sql = query($query);

  $query = "INSERT INTO `plugins` (`filename`, `action`) VALUES
  ('email_send.plugin.php', 1),
  ('debug_session.plugin.php', 0);";
  $sql = query($query);

echo "<li>The Plugins table has been created. </li>";

// FINISH ---------------------------------------------------
echo '<div id="login_info" class="alert_info" style="margin:auto;padding:auto;"><p style="margin-bottom:6px; text-align:center;"><img src="../web/images/icon_message.png" alt="success" class="middle"/>';
echo '<strong>The Database has been created!</strong><div style="margin-left:36px; font-size:0.9em; line-height:1.2em; text-align:center;">Proceed with setting up property and admin user.</div><br /></p>';

echo '</div><br /><br /><center><input type="button" value="Proceed" onClick="location.href=\'../web/properties.php?p=2&pk=BS1\'" 
class="button_dark"></center><br /><br />';
?>