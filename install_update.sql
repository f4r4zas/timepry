ALTER TABLE `r_providers`
  ADD COLUMN `payment_type` int(1) unsigned DEFAULT '0',
  ADD COLUMN `provider_currency_code` VARCHAR(3),
  ADD COLUMN `paypal_user_id` VARCHAR(255),
  ADD COLUMN `paypal_password` VARCHAR(255),
  ADD COLUMN `paypal_signature` VARCHAR(255),
  ADD COLUMN `currency_sign` VARCHAR(255),
  ADD COLUMN `currency_sign_before` int(1) unsigned DEFAULT '0';

ALTER TABLE `r_provider_admins`
  ADD COLUMN `notification_email` int(1) unsigned DEFAULT '0';

ALTER TABLE `r_reservation`
  ADD COLUMN `pre_registration_id` int(10) unsigned DEFAULT '0',
  ADD COLUMN `paid` int(1) unsigned DEFAULT '0',
  ADD COLUMN `paypal_paid` int(1) unsigned DEFAULT '0';

ALTER TABLE `r_services`
	ADD COLUMN `price_show` int(1) unsigned DEFAULT '0';

ALTER TABLE `setting`
  ADD COLUMN `appointment_payment` int(1) unsigned DEFAULT '0',
  ADD COLUMN `timezone` VARCHAR(255),
  ADD COLUMN `date_format` VARCHAR(255),
  ADD COLUMN `time_format` VARCHAR(255),
  ADD COLUMN `currency_code` VARCHAR(255),
  ADD COLUMN `paypal_user_id` VARCHAR(255),
  ADD COLUMN `paypal_password` VARCHAR(255),
  ADD COLUMN `paypal_signature` VARCHAR(255),
  ADD COLUMN `currency_sign` VARCHAR(255),
  ADD COLUMN `currency_format` VARCHAR(255),
  ADD COLUMN `currency_sign_before` int(1) unsigned DEFAULT '0';

INSERT INTO `auto_email_messages` (`code_key`, `subject`, `content`, `language_id`, `lang`) VALUES
	('reservation_payment_confirmation', 'Payment confirmation', '<p>Hi dear [--$reservation_fname--],</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<div style="background:#eee;border:1px solid #ccc;padding:5px 10px;"><span style="color:#008000"><strong>Your payment completed successfully.</strong></span></div>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Appointment info:</p>\r\n\r\n<table border="0">\r\n	<tbody>\r\n		<tr>\r\n			<td>Price</td>\r\n			<th>[--$reservation_price--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Appointment date:</td>\r\n			<th>[--$reservation_date--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Appointment time:</td>\r\n			<th>[--$reservation_time--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Customer name:</td>\r\n			<th>[--$reservation_fname--] [--$reservation_lname--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Reference number:</td>\r\n			<th>[--$reservation_number--]</th>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Thanks</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>[--$company--]</strong></p>\r\n', 1, NULL),
	('reservation_payment_confirmation', 'Zahlungsbestätigung', '<p>Sehr geehrte <strong>[--$reservation_fname--]</strong>,</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<div style="background:#eee;border:1px solid #ccc;padding:5px 10px;"><strong><span style="color:#008000">Ihre Zahlung erfolgreich abgeschlossen.</span></strong></div>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Termin info:</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<table border="0">\r\n	<tbody>\r\n		<tr>\r\n			<td>Preis</td>\r\n			<th>[--$reservation_price--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Datum des Termins:</td>\r\n			<th>[--$reservation_date--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Zeit des Termins:</td>\r\n			<th>[--$reservation_time--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Kundenname:</td>\r\n			<th>[--$reservation_fname--] [--$reservation_lname--]</th>\r\n		</tr>\r\n		<tr>\r\n			<td>Referenznummer:</td>\r\n			<th>[--$reservation_number--]</th>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Mit freundlichen Gr&uuml;&szlig;en</p>\r\n\r\n<p><strong>[--$company--]</strong></p>\r\n', 3, NULL);
