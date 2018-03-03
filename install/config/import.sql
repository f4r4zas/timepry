
CREATE TABLE IF NOT EXISTS `auto_email_messages` (
  `msg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code_key` varchar(100) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `content` text,
  `language_id` int(10) unsigned NOT NULL DEFAULT '0',
  `lang` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`msg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;


INSERT INTO `auto_email_messages` (`msg_id`, `code_key`, `subject`, `content`, `language_id`, `lang`) VALUES
	(1, 'reservation_confirmation', 'Appointment confirmation', '<p>Hi dear [--$reservation_fname--],</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Many thanks for your appointment request.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Your request have <strong>successfully</strong> done!</p>\r\n\r\n<p>Appointment info:</p>\r\n\r\n<table border="0">\r\n	<tbody>\r\n		<tr>\r\n			<td>Appointment date:</td>\r\n			<th>[--$reservation_date--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Appointment time:</td>\r\n			<th>[--$reservation_time--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Customer name:</td>\r\n			<th>[--$reservation_fname--] [--$reservation_lname--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Reference number:</td>\r\n			<th>[--$reservation_number--]</th>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Thanks</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>[--$company--]</strong></p>\r\n', 1, NULL),
	(2, 'reservation_confirmation_admin', 'New appointment request', '<p>Hi dear admin of [--$company--],</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>A new appointment request have done by this information:</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<table border="0">\r\n	<tbody>\r\n		<tr>\r\n			<td>Appointment date:</td>\r\n			<th>[--$reservation_date--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Appointment time:</td>\r\n			<th>[--$reservation_time--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Customer name:</td>\r\n			<th>[--$reservation_fname--] [--$reservation_lname--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Reference number:</td>\r\n			<th>[--$reservation_number--]</th>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Thanks</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Nod Appointment System</strong></p>\r\n', 1, NULL),
	(3, 'reservation_payment_confirmation', 'Payment confirmation', '<p>Hi dear [--$reservation_fname--],</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<div style="background:#eee;border:1px solid #ccc;padding:5px 10px;"><span style="color:#008000"><strong>Your payment completed successfully.</strong></span></div>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Appointment info:</p>\r\n\r\n<table border="0">\r\n	<tbody>\r\n		<tr>\r\n			<td>Price</td>\r\n			<th>[--$reservation_price--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Appointment date:</td>\r\n			<th>[--$reservation_date--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Appointment time:</td>\r\n			<th>[--$reservation_time--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Customer name:</td>\r\n			<th>[--$reservation_fname--] [--$reservation_lname--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Reference number:</td>\r\n			<th>[--$reservation_number--]</th>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Thanks</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>[--$company--]</strong></p>\r\n', 1, NULL),
	(4, 'registration_confirm', 'User confirmation', '<p>Hi dear [--$last_name--],</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Many thanks for your registration.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Please click in bellow link to active your account:</p>\r\n\r\n<p><a href="[--$refurl--]">[--$refurl--]</a></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Thanks</p>\r\n\r\n<p><strong>[--$company--]</strong></p>\r\n', 1, NULL),
	(5, 'reservation_reminder', 'Remind your appointment', '<p>Hi dear admin of <strong>[--$last_name--]</strong>,</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<div style="background:#eee;border:1px solid #ccc;padding:5px 10px;"><span style="color:#DAA520"><strong>Please don&#39;t forget your appointment!</strong></span></div>\r\n\r\n<h4>Your Appointment info:</h4>\r\n\r\n<table border="0">\r\n	<tbody>\r\n		<tr>\r\n			<td>Appointment date:</td>\r\n			<th>[--$reservation_date--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Appointment time:</td>\r\n			<th>[--$reservation_time--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Customer name:</td>\r\n			<th>[--$first_name--] [--$last_name--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Service name:</td>\r\n			<th>[--$service_name--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Dental Office name</td>\r\n			<th><a href="[--$provider_url--]">[--$provider_name--]</a></th>\r\n		</tr>\r\n		<tr>\r\n			<td>Phone number</td>\r\n			<th>[--$provider_phone--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Address</td>\r\n			<th>[--$provider_address--]</th>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Thanks</p>\r\n\r\n<p><strong>[--$company--]</strong></p>\r\n', 1, NULL),
	(6, 'reservation_cancel_confirmation', 'Your appointment is canceled', '<p>Hi dear admin of <strong>[--$last_name--]</strong>,</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<div style="background:#eee;border:1px solid #ccc;padding:5px 10px;"><span style="color:#FF0000"><strong>Your appointment is canceled! To make a new appointment, <a href="[--$provider_url--]">click here!</a></strong></span></div>\r\n\r\n<h4>Appointment info:</h4>\r\n\r\n<table border="0">\r\n	<tbody>\r\n		<tr>\r\n			<td>Appointment date:</td>\r\n			<th>[--$reservation_date--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Appointment time:</td>\r\n			<th>[--$reservation_time--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Customer name:</td>\r\n			<th>[--$first_name--] [--$last_name--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Service name:</td>\r\n			<th>[--$service_name--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Dental Office name</td>\r\n			<th><a href="[--$provider_url--]">[--$provider_name--]</a></th>\r\n		</tr>\r\n		<tr>\r\n			<td>Phone number</td>\r\n			<th>[--$provider_phone--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Address</td>\r\n			<th>[--$provider_address--]</th>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Thanks</p>\r\n\r\n<p><strong>[--$company--]</strong></p>\r\n', 1, NULL),
	(7, 'reservation_confirmation', 'Terminbestätigung', '<p>Sehr geehrte <strong>[--$reservation_fname--]</strong>,</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>vielen Dank f&uuml;r Ihre Terminanfrage.</p>\r\n\r\n<p>Ihre Anfrage wird <strong>erfolgreich</strong> durchgef&uuml;hrt!</p>\r\n\r\n<p>Termin info:</p>\r\n\r\n<table border="0">\r\n	<tbody>\r\n		<tr>\r\n			<td>Datum des Termins:</td>\r\n			<th>[--$reservation_date--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Zeit des Termins:</td>\r\n			<th>[--$reservation_time--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Kundenname:</td>\r\n			<th>[--$reservation_fname--] [--$reservation_lname--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Referenznummer:</td>\r\n			<th>[--$reservation_number--]</th>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Mit freundlichen Gr&uuml;&szlig;en</p>\r\n\r\n<p><strong>[--$company--]</strong></p>\r\n', 3, NULL),
	(8, 'reservation_confirmation_admin', 'Neue Terminanfrage', '<p>Sehr geehrte Administrator von <strong>[--$company--]</strong>,</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Ein neuer Terminanfrage wurden von diesen Informationen gemacht:</p>\r\n\r\n<table border="0">\r\n	<tbody>\r\n		<tr>\r\n			<td>Datum des Termins:</td>\r\n			<th>[--$reservation_date--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Zeit des Termins:</td>\r\n			<th>[--$reservation_time--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Kundenname:</td>\r\n			<th>[--$reservation_fname--] [--$reservation_lname--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Referenznummer:</td>\r\n			<th>[--$reservation_number--]</th>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Mit freundlichen Gr&uuml;&szlig;en</p>\r\n\r\n<p><strong>Nod Appointment System</strong></p>\r\n', 3, NULL),
	(9, 'reservation_payment_confirmation', 'Zahlungsbestätigung', '<p>Sehr geehrte <strong>[--$reservation_fname--]</strong>,</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<div style="background:#eee;border:1px solid #ccc;padding:5px 10px;"><strong><span style="color:#008000">Ihre Zahlung erfolgreich abgeschlossen.</span></strong></div>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Termin info:</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<table border="0">\r\n	<tbody>\r\n		<tr>\r\n			<td>Preis</td>\r\n			<th>[--$reservation_price--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Datum des Termins:</td>\r\n			<th>[--$reservation_date--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Zeit des Termins:</td>\r\n			<th>[--$reservation_time--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Kundenname:</td>\r\n			<th>[--$reservation_fname--] [--$reservation_lname--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Referenznummer:</td>\r\n			<th>[--$reservation_number--]</th>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Mit freundlichen Gr&uuml;&szlig;en</p>\r\n\r\n<p><strong>[--$company--]</strong></p>\r\n', 3, NULL),
	(10, 'registration_confirm', 'Benutzerbestätigung', '<p>Sehr geehrte [--$last_name--],</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>vielen Dank f&uuml;r Ihre Anmeldung.</p>\r\n\r\n<p>Bitte klicken Sie auf folgenden Link, um aktiv Ihr Konto:</p>\r\n\r\n<p><a href="[--$refurl--]">[--$refurl--]</a></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Mit freundlichen Gr&uuml;&szlig;en</p>\r\n\r\n<p><strong>[--$company--]</strong></p>\r\n', 3, NULL),
	(11, 'reservation_reminder', 'Termin der Erinnerung', '<p>Sehr geehrte <strong>[--$last_name--]</strong>,</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<div style="background:#eee;border:1px solid #ccc;padding:5px 10px;"><span style="color:#DAA520"><strong>Bitte vergessen Sie nicht Ihren Termin!</strong></span></div>\r\n\r\n<h4>Your Appointment info:</h4>\r\n\r\n<table border="0">\r\n	<tbody>\r\n		<tr>\r\n			<td>Termin Datum:</td>\r\n			<th>[--$reservation_date--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Termin Zeit:</td>\r\n			<th>[--$reservation_time--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Ihre Name:</td>\r\n			<th>[--$first_name--] [--$last_name--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Dienstname:</td>\r\n			<th>[--$service_name--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Anbietername:</td>\r\n			<th><a href="[--$provider_url--]">[--$provider_name--]</a></th>\r\n		</tr>\r\n		<tr>\r\n			<td>Telefonnummer:</td>\r\n			<th>[--$provider_phone--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Adresse:</td>\r\n			<th>[--$provider_address--]</th>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Mit freundlichen Gr&uuml;&szlig;en</p>\r\n\r\n<p><strong>[--$company--]</strong></p>\r\n', 3, NULL),
	(12, 'reservation_cancel_confirmation', 'Ihr Termin wurde abgebrochen', '<p>Sehr geehrte <strong>[--$last_name--]</strong>,</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<div style="background:#eee;border:1px solid #ccc;padding:5px 10px;"><span style="color:#FF0000"><strong>Ihr Termin wurde abgebrocht! Um neuen Termin auszumachen, <a href="[--$provider_url--]">klicken Sie hier!</a></strong></span></div>\r\n\r\n<h4>Your Appointment info:</h4>\r\n\r\n<table border="0">\r\n	<tbody>\r\n		<tr>\r\n			<td>Termin Datum:</td>\r\n			<th>[--$reservation_date--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Termin Zeit:</td>\r\n			<th>[--$reservation_time--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Ihre Name:</td>\r\n			<th>[--$first_name--] [--$last_name--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Dienstname:</td>\r\n			<th>[--$service_name--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Anbietername:</td>\r\n			<th><a href="[--$provider_url--]">[--$provider_name--]</a></th>\r\n		</tr>\r\n		<tr>\r\n			<td>Telefonnummer:</td>\r\n			<th>[--$provider_phone--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Adresse:</td>\r\n			<th>[--$provider_address--]</th>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Mit freundlichen Gr&uuml;&szlig;en</p>\r\n\r\n<p><strong>[--$company--]</strong></p>\r\n', 3, NULL);

	
CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` varchar(40) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `comments` (
  `comment_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `session_id` varchar(50) DEFAULT NULL,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `content` text,
  `created_date` int(11) unsigned NOT NULL DEFAULT '0',
  `extension_id` int(11) unsigned NOT NULL DEFAULT '0',
  `status` int(1) unsigned NOT NULL DEFAULT '0',
  `sub_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lang` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `extensions` (
  `extension_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `category_id` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `extension_icon` varchar(255) DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `description` text,
  `full_description` text,
  `data_type` varchar(255) DEFAULT NULL,
  `relation_id` int(10) unsigned NOT NULL DEFAULT '0',
  `language_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created_date` int(10) unsigned NOT NULL DEFAULT '0',
  `updated_date` int(10) unsigned NOT NULL DEFAULT '0',
  `status` int(1) unsigned NOT NULL DEFAULT '0',
  `public` int(1) unsigned NOT NULL DEFAULT '0',
  `like` int(10) unsigned NOT NULL DEFAULT '0',
  `dislike` int(10) unsigned NOT NULL DEFAULT '0',
  `star_rate_sum` int(10) unsigned NOT NULL DEFAULT '0',
  `star_rate_count` int(10) unsigned NOT NULL DEFAULT '0',
  `count_view` int(10) unsigned NOT NULL DEFAULT '0',
  `count_comment` int(10) unsigned NOT NULL DEFAULT '0',
  `extension_order` int(10) unsigned NOT NULL DEFAULT '0',
  `extension_more` text,
  PRIMARY KEY (`extension_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;


INSERT INTO `extensions` (`extension_id`, `user_id`, `category_id`, `name`, `image`, `extension_icon`, `tag`, `description`, `full_description`, `data_type`, `relation_id`, `language_id`, `created_date`, `updated_date`, `status`, `public`, `like`, `dislike`, `star_rate_sum`, `star_rate_count`, `count_view`, `count_comment`, `extension_order`, `extension_more`) VALUES
	(1, 0, 0, 'First Dental Office', NULL, NULL, NULL, NULL, '<p>First Dental Office</p>\r\n', 'r_providers', 1, 1, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, NULL),
	(2, 0, 0, 'Erste Dental Office', NULL, NULL, NULL, NULL, '<p>Erste Dental Office</p>\r\n', 'r_providers', 1, 3, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, NULL);

	
CREATE TABLE IF NOT EXISTS `gallery` (
  `gallery_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `gallery_name` varchar(255) DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `relation_id` int(10) unsigned NOT NULL DEFAULT '0',
  `data_type` varchar(255) DEFAULT NULL,
  `created_date` int(10) unsigned NOT NULL DEFAULT '0',
  `gallery_order` int(10) unsigned NOT NULL DEFAULT '0',
  `status` int(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`gallery_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `gallery_image` (
  `image_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `relation_id` int(11) unsigned NOT NULL DEFAULT '0',
  `data_type` varchar(200) DEFAULT NULL,
  `gallery_id` int(10) unsigned NOT NULL DEFAULT '0',
  `image` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `size` float unsigned NOT NULL DEFAULT '0',
  `width` int(10) unsigned NOT NULL DEFAULT '0',
  `height` int(10) unsigned NOT NULL DEFAULT '0',
  `count_view` int(10) unsigned NOT NULL DEFAULT '0',
  `created_date` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`image_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `groups` (
  `group_id` tinyint(3) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8;


INSERT INTO `groups` (`group_id`, `group_name`) VALUES
	(1, 'Admin'),
	(20, 'Users');
	
CREATE TABLE IF NOT EXISTS `images` (
  `image_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `width` int(11) unsigned NOT NULL DEFAULT '0',
  `height` int(11) unsigned NOT NULL DEFAULT '0',
  `size` int(11) unsigned NOT NULL DEFAULT '0',
  `root` varchar(255) DEFAULT NULL,
  `folder` varchar(255) DEFAULT NULL,
  `created_date` int(11) unsigned NOT NULL DEFAULT '0',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`image_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table nodaps_v3.5_paypal.images: ~1 rows (approximately)
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` (`image_id`, `name`, `image`, `width`, `height`, `size`, `root`, `folder`, `created_date`, `user_id`) VALUES
	(1, 'austria-monopoly-approved.png', 'upload_file/lang/austria-monopoly-approved.png', 2048, 1079, 42, 'upload_file/lang/', 'lang/', 1468781320, 1);

	
CREATE TABLE IF NOT EXISTS `languages` (
  `language_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_name` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `public` int(1) unsigned NOT NULL DEFAULT '0',
  `rtl` int(1) unsigned DEFAULT '0',
  `sort_order` int(11) DEFAULT NULL,
  `created_date` int(11) DEFAULT NULL,
  `default` int(11) DEFAULT '0',
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`language_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;


INSERT INTO `languages` (`language_id`, `language_name`, `code`, `public`, `rtl`, `sort_order`, `created_date`, `default`, `image`) VALUES
	(1, 'english', 'en', 1, 0, 1, 1369730191, 1, 'upload_file/lang/united_states_flag.png'),
	(3, 'deutsch', 'de', 1, 0, 3, 1403201887, 0, 'upload_file/lang/germany_flag.png');

	
CREATE TABLE IF NOT EXISTS `menu` (
  `menu_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(255) DEFAULT NULL,
  `menu_icon` varchar(255) DEFAULT NULL,
  `menu_link` varchar(255) DEFAULT NULL,
  `sub_menu` int(10) unsigned DEFAULT '0',
  `page_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created_date` int(10) unsigned NOT NULL DEFAULT '0',
  `menu_order` int(10) unsigned NOT NULL DEFAULT '0',
  `public` int(1) unsigned NOT NULL DEFAULT '0',
  `menu_url` varbinary(255) DEFAULT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `menu` (`menu_id`, `menu_name`, `menu_icon`, `menu_link`, `sub_menu`, `page_id`, `created_date`, `menu_order`, `public`, `menu_url`) VALUES
	(1, 'Purchase NodAPS', NULL, NULL, 0, 0, 1472513024, 2, 1, _binary 0x687474703A2F2F7777772E636869637468656D652E636F6D2F6E6F64617073);

CREATE TABLE IF NOT EXISTS `page` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_type` int(10) unsigned NOT NULL DEFAULT '1',
  `page_dynamic` int(1) unsigned NOT NULL DEFAULT '0',
  `page_name` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `country_id` int(11) unsigned NOT NULL DEFAULT '0',
  `created_date` int(11) unsigned NOT NULL DEFAULT '0',
  `public` int(1) unsigned NOT NULL DEFAULT '0',
  `preview` int(1) unsigned NOT NULL DEFAULT '0',
  `default` int(1) unsigned NOT NULL DEFAULT '0',
  `page_order` int(11) unsigned NOT NULL DEFAULT '0',
  `page_more` text,
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `r_extra_fields` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `field_name` varchar(255) DEFAULT NULL,
  `field_caption` varchar(255) DEFAULT NULL,
  `field_type` int(10) unsigned NOT NULL DEFAULT '0',
  `provider_id` int(10) unsigned NOT NULL DEFAULT '0',
  `min` int(10) unsigned NOT NULL DEFAULT '0',
  `max` int(10) unsigned NOT NULL DEFAULT '0',
  `require` int(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `r_extra_fields_value` (
  `value_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `field_name` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `reservation_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`value_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `r_field_type` (
  `type_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

INSERT INTO `r_field_type` (`type_id`, `type_name`) VALUES
	(1, 'Number'),
	(2, 'Alphanumeric'),
	(3, 'Text'),
	(4, 'Textarea'),
	(5, 'Checkbox'),
	(6, 'URL');
	
	
CREATE TABLE IF NOT EXISTS `r_free_dates` (
  `date_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date_title` varchar(255) DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `service_id` int(10) unsigned NOT NULL DEFAULT '0',
  `provider_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created_date` int(10) unsigned NOT NULL DEFAULT '0',
  `free_date` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`date_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
	

CREATE TABLE IF NOT EXISTS `r_providers` (
  `provider_id` int(11) NOT NULL AUTO_INCREMENT,
  `provider_name` varchar(255) DEFAULT NULL,
  `provider_username` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created_date` int(10) unsigned NOT NULL DEFAULT '0',
  `description` text,
  `active` int(1) unsigned NOT NULL DEFAULT '0',
  `block` int(1) unsigned NOT NULL DEFAULT '0',
  `default` int(1) unsigned NOT NULL DEFAULT '0',
  `appointment_non_repeating` int(1) unsigned NOT NULL DEFAULT '0',
  `appointment_cancel` int(1) unsigned NOT NULL DEFAULT '0',
  `payment_type` int(1) unsigned NOT NULL DEFAULT '0',
  `provider_currency_code` varchar(3) NOT NULL,
  `paypal_user_id` varchar(255) NOT NULL,
  `paypal_password` varchar(255) NOT NULL,
  `paypal_signature` varchar(255) NOT NULL,
  `currency_sign` varchar(255) NOT NULL,
  `currency_sign_before` int(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`provider_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;


INSERT INTO `r_providers` (`provider_id`, `provider_name`, `provider_username`, `address`, `phone`, `website`, `image`, `user_id`, `created_date`, `description`, `active`, `block`, `default`, `appointment_non_repeating`, `appointment_cancel`, `payment_type`, `provider_currency_code`, `paypal_user_id`, `paypal_password`, `paypal_signature`, `currency_sign`, `currency_sign_before`) VALUES
	(1, 'First Dental Office', 'default', 'Wien 1010', '+43 0123 1234567', NULL, NULL, 1, 1468487049, NULL, 1, 0, 1, 0, 0, 0, '', '', '', '', '', 1);

	
CREATE TABLE IF NOT EXISTS `r_provider_admins` (
  `provider_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `group_id` int(10) unsigned DEFAULT NULL,
  `notification_email` int(1) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	
CREATE TABLE IF NOT EXISTS `r_provider_groups` (
  `group_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- Dumping data for table nodaps_v3.5_paypal.r_provider_groups: ~3 rows (approximately)
/*!40000 ALTER TABLE `r_provider_groups` DISABLE KEYS */;
INSERT INTO `r_provider_groups` (`group_id`, `group_name`) VALUES
	(1, 'Admin'),
	(21, 'Staff'),
	(22, 'Assistant');
	
CREATE TABLE IF NOT EXISTS `r_reservation` (
  `reservation_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pre_registration_id` int(10) unsigned NOT NULL DEFAULT '0',
  `owner_user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `provider_id` int(10) unsigned NOT NULL DEFAULT '0',
  `service_id` int(10) unsigned NOT NULL DEFAULT '0',
  `reservation_day_no` int(10) unsigned NOT NULL DEFAULT '0',
  `reservation_date` int(10) unsigned NOT NULL DEFAULT '0',
  `reservation_date_time` int(10) unsigned NOT NULL DEFAULT '0',
  `reservation_edate_time` int(10) unsigned NOT NULL DEFAULT '0',
  `created_date` int(10) unsigned NOT NULL DEFAULT '0',
  `language_id` int(10) unsigned NOT NULL DEFAULT '0',
  `lang` varchar(2) DEFAULT NULL,
  `price` float unsigned DEFAULT '0',
  `service_name` varchar(255) DEFAULT NULL,
  `reservation_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `fname` varchar(255) DEFAULT NULL,
  `lname` varchar(255) DEFAULT NULL,
  `color` varchar(50) DEFAULT '',
  `trash` int(1) unsigned DEFAULT '0',
  `seen` int(1) unsigned DEFAULT '0',
  `checked` int(1) unsigned DEFAULT '0',
  `closed` int(1) unsigned DEFAULT '0',
  `reminded` int(10) unsigned DEFAULT '0',
  `paid` int(1) unsigned DEFAULT '0',
  `paypal_paid` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`reservation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `r_reservation_comment` (
  `comment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `comment_message` text,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `reservation_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created_date` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `r_services` (
  `service_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) DEFAULT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `service_description` text,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `provider_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created_date` int(10) unsigned NOT NULL DEFAULT '0',
  `price` float unsigned DEFAULT '0',
  `available_count` int(10) unsigned DEFAULT '0',
  `public` int(1) unsigned DEFAULT '0',
  `price_show` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`service_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
	
	
CREATE TABLE IF NOT EXISTS `r_time_period` (
  `period_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `day_no` int(10) unsigned NOT NULL DEFAULT '0',
  `max_count` int(10) unsigned DEFAULT '0',
  `period_start_time` int(10) unsigned NOT NULL DEFAULT '0',
  `period_end_time` int(10) unsigned NOT NULL DEFAULT '0',
  `period_min` int(10) unsigned NOT NULL DEFAULT '0',
  `created_date` int(10) unsigned NOT NULL DEFAULT '0',
  `service_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`period_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT '',
  `company` varchar(255) DEFAULT '',
  `logo` varchar(255) DEFAULT '',
  `fav_icon` varchar(255) DEFAULT '',
  `address` varchar(255) DEFAULT '',
  `location` varchar(255) DEFAULT '',
  `zip_code` int(11) DEFAULT '0',
  `country_id` int(11) DEFAULT '0',
  `language_id` int(11) DEFAULT '1',
  `phone` varchar(20) DEFAULT '',
  `description` text,
  `use_smtp` int(1) unsigned NOT NULL DEFAULT '0',
  `smtp_host` varchar(255) DEFAULT '',
  `smtp_port` int(11) DEFAULT NULL,
  `smtp_username` varchar(255) DEFAULT '',
  `smtp_password` varchar(255) DEFAULT '',
  `default_image` varchar(255) DEFAULT '',
  `fb_api` varchar(255) DEFAULT '',
  `site_name` varchar(255) DEFAULT '',
  `contact_form` int(1) unsigned DEFAULT '0',
  `registration` int(1) unsigned DEFAULT '0',
  `appointment_multiowner` int(1) unsigned DEFAULT '0',
  `appointment_non_repeating` int(1) unsigned DEFAULT '0',
  `appointment_payment` int(1) unsigned DEFAULT '0',
  `timezone` varchar(255) DEFAULT '0',
  `date_format` varchar(100) DEFAULT '0',
  `time_format` varchar(100) DEFAULT '0',
  `currency_code` varchar(3) NOT NULL,
  `paypal_user_id` varchar(255) NOT NULL,
  `paypal_password` varchar(255) NOT NULL,
  `paypal_signature` varchar(255) NOT NULL,
  `currency_sign` varchar(255) NOT NULL,
  `currency_format` varchar(20) NOT NULL,
  `currency_sign_before` int(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;


/*!40000 ALTER TABLE `setting` DISABLE KEYS */;
INSERT INTO `setting` (`id`, `email`, `company`, `logo`, `fav_icon`, `address`, `location`, `zip_code`, `country_id`, `language_id`, `phone`, `description`, `use_smtp`, `smtp_host`, `smtp_port`, `smtp_username`, `smtp_password`, `default_image`, `fb_api`, `site_name`, `contact_form`, `registration`, `appointment_multiowner`, `appointment_non_repeating`, `appointment_payment`, `timezone`, `date_format`, `time_format`, `currency_code`, `paypal_user_id`, `paypal_password`, `paypal_signature`, `currency_sign`, `currency_format`, `currency_sign_before`) VALUES
	(1, 'nodaps@chicktheme.com', 'NodAPS', 'upload_file/logo/NodCMS-LOGO-aps-shadow.png', 'upload_file/logo/nodcms-fav1.png', '', '-48.198312, +21.636738', 1010, 1, 1, '+43 0123 1234567', '', 0, '', 0, '', '', 'upload_file/logo/no-image-available.jpg', '', NULL, 1, 1, 1, 0, 0, '', 'd.m.Y', 'H:i', 'USD', '', '', '', '$', '1,234.56', 1);


CREATE TABLE IF NOT EXISTS `setting_options_per_lang` (
  `option_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) DEFAULT NULL,
  `site_title` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `site_description` text,
  `site_keyword` text,
  PRIMARY KEY (`option_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;


/*!40000 ALTER TABLE `setting_options_per_lang` DISABLE KEYS */;
INSERT INTO `setting_options_per_lang` (`option_id`, `language_id`, `site_title`, `company`, `site_description`, `site_keyword`) VALUES
	(1, 1, 'NodAPS - online appointment system', 'NodAPS - Appointment Management System', '', ''),
	(3, 3, '', 'NodAPS - Termin-Management-System', '', '');
	
	
CREATE TABLE IF NOT EXISTS `statistic` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `created_date` int(11) unsigned NOT NULL DEFAULT '0',
  `statistic_date` int(11) unsigned NOT NULL DEFAULT '0',
  `visitors` int(11) unsigned NOT NULL DEFAULT '0',
  `visits` int(11) unsigned NOT NULL DEFAULT '0',
  `popular_url` varchar(255) DEFAULT NULL,
  `popular_url_count` int(11) unsigned NOT NULL DEFAULT '0',
  `popular_lang` int(10) unsigned NOT NULL DEFAULT '0',
  `popular_lang_count` int(11) unsigned NOT NULL DEFAULT '0',
  `popular_lang_percent` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `titles` (
  `title_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title_caption` varchar(255) DEFAULT NULL,
  `relation_id` int(10) unsigned NOT NULL DEFAULT '0',
  `data_type` varchar(255) DEFAULT NULL,
  `language_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`title_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;


INSERT INTO `titles` (`title_id`, `title_caption`, `relation_id`, `data_type`, `language_id`) VALUES
	(1, 'Purchase NodAPS', 1, 'menu', 1),
	(2, 'Kuafen Sie NodAPS', 1, 'menu', 3);
	
CREATE TABLE IF NOT EXISTS `upload_files` (
  `file_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `file_path` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `root` varchar(255) DEFAULT NULL,
  `folder` varchar(255) DEFAULT NULL,
  `size` int(10) unsigned NOT NULL DEFAULT '0',
  `created_date` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `group_id` tinyint(3) DEFAULT NULL,
  `created_date` int(11) unsigned NOT NULL DEFAULT '0',
  `reset_pass_exp` int(11) unsigned NOT NULL DEFAULT '0',
  `status` int(1) unsigned NOT NULL DEFAULT '0',
  `active_register` int(1) unsigned NOT NULL DEFAULT '0',
  `active` int(1) unsigned NOT NULL DEFAULT '0',
  `active_code` varchar(20) DEFAULT NULL,
  `email_hash` varchar(20) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `google_plus` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `user_agent` text,
  `keep_me_time` int(11) unsigned NOT NULL DEFAULT '0',
  `language_id` int(11) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `users` (`user_id`, `username`, `password`, `fullname`, `firstname`, `lastname`, `email`, `group_id`, `created_date`, `reset_pass_exp`, `status`, `active_register`, `active`, `active_code`, `email_hash`, `avatar`, `mobile`, `facebook`, `google_plus`, `linkedin`, `website`, `contact_email`, `user_agent`, `keep_me_time`, `language_id`) VALUES
	(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'admin', NULL, NULL, NULL, 1, 0, 0, 1, 0, 1, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1);


CREATE TABLE IF NOT EXISTS `visitors` (
  `visit_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `session_id` varchar(255) DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created_date` int(10) unsigned NOT NULL DEFAULT '0',
  `updated_date` int(10) unsigned NOT NULL DEFAULT '0',
  `count_view` int(10) unsigned NOT NULL DEFAULT '0',
  `user_agent` text,
  `user_ip` varchar(50) DEFAULT NULL,
  `language_id` int(10) unsigned NOT NULL DEFAULT '0',
  `language_code` varchar(2) DEFAULT NULL,
  `referrer` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `request_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`visit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
