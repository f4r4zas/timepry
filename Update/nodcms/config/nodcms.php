<?php
/**
 * Created by PhpStorm.
 * User: Mojtaba
 * Date: 9/15/2015
 * Time: 8:35 PM
 * Project: NodCMS
 * Website: http://www.nodcms.com
 */
$config['NodCMS_general_templateFolderName'] = 'reservation';
$config['NodCMS_general_admin_templateFolderName'] = 'appointment_admin';
$config['max_upload_size'] = 20000; // KG

$config['backend_models'] = array('Nodcms_admin_model','Appointment_admin_model');
$config['backend_helpers'] = array('admin_page_type','nodcms_form','reservation');
$config['frontend_models'] = array('Nodcms_general_model','Appointment_model');
$config['frontend_helpers'] = array();

$config['autoEmailMessages'] = array(
    'reservation_confirmation'=> array(
        'label'=>'Booking confirmation for customer',
        'keys'=>array(
            array('label'=>'Company name','value'=>'[--$company--]'),
            array('label'=>'Site Email','value'=>'[--$smail--]'),
            array('label'=>'Date','value'=>'[--$date--]'),
            array('label'=>'Request number','value'=>'[--$reservation_number--]'),
            array('label'=>'Price','value'=>'[--$reservation_price--]'),
            array('label'=>'Appointment date','value'=>'[--$reservation_date--]'),
            array('label'=>'Appointment time','value'=>'[--$reservation_time--]'),
            array('label'=>'First name','value'=>'[--$reservation_fname--]'),
            array('label'=>'Last name','value'=>'[--$reservation_lname--]'),
            array('label'=>'Request reference','value'=>'[--$refurl--]'),
        ),
        'replace_keys'=>function($text, $data){
            $search = array(
                '[--$company--]',
                '[--$smail--]',
                '[--$date--]',
                '[--$reservation_number--]',
                '[--$reservation_price--]',
                '[--$reservation_date--]',
                '[--$reservation_time--]',
                '[--$reservation_fname--]',
                '[--$reservation_lname--]',
                '[--$refurl--]'
            );
            $replace = array(
                $data["company"],
                $data["site_email"],
                $data["reservation_number"],
                $data["reservation_price"],
                $data["reservation_date"],
                $data["reservation_time"],
                $data["reservation_fname"],
                $data["reservation_lname"],
                $data["reference_url"]
            );
            return str_replace($search, $replace, $text);
        }
    ),
    'reservation_confirmation_admin'=> array(
        'label'=>'New booking notification for admin',
        'keys'=>array(
            array('label'=>'Company name','value'=>'[--$company--]'),
            array('label'=>'Site Email','value'=>'[--$smail--]'),
            array('label'=>'Date','value'=>'[--$date--]'),
            array('label'=>'Request number','value'=>'[--$reservation_number--]'),
            array('label'=>'Price','value'=>'[--$reservation_price--]'),
            array('label'=>'Appointment date','value'=>'[--$reservation_date--]'),
            array('label'=>'Appointment time','value'=>'[--$reservation_time--]'),
            array('label'=>'First name','value'=>'[--$reservation_fname--]'),
            array('label'=>'Last name','value'=>'[--$reservation_lname--]'),
            array('label'=>'Request reference','value'=>'[--$refurl--]'),
        ),
        'replace_keys'=>function($text, $data){
            $search = array(
                '[--$company--]',
                '[--$smail--]',
                '[--$date--]',
                '[--$reservation_number--]',
                '[--$reservation_price--]',
                '[--$reservation_date--]',
                '[--$reservation_time--]',
                '[--$reservation_fname--]',
                '[--$reservation_lname--]',
                '[--$refurl--]'
            );
            $replace = array(
                $data["company"],
                $data["site_email"],
                $data["reservation_number"],
                $data["reservation_price"],
                $data["reservation_date"],
                $data["reservation_time"],
                $data["reservation_fname"],
                $data["reservation_lname"],
                $data["reference_url"]
            );
            return str_replace($search, $replace, $text);
        }
    ),
    'reservation_payment_confirmation'=> array(
        'label'=>'Payment confirmation for customer',
        'keys'=>array(
            array('label'=>'Company name','value'=>'[--$company--]'),
            array('label'=>'Site Email','value'=>'[--$smail--]'),
            array('label'=>'Date','value'=>'[--$date--]'),
            array('label'=>'Request number','value'=>'[--$reservation_number--]'),
            array('label'=>'Price','value'=>'[--$reservation_price--]'),
            array('label'=>'Appointment date','value'=>'[--$reservation_date--]'),
            array('label'=>'Appointment time','value'=>'[--$reservation_time--]'),
            array('label'=>'First name','value'=>'[--$reservation_fname--]'),
            array('label'=>'Last name','value'=>'[--$reservation_lname--]'),
            array('label'=>'Request reference','value'=>'[--$refurl--]'),
        ),
        'replace_keys'=>function($text, $data){
            $search = array(
                '[--$company--]',
                '[--$smail--]',
                '[--$date--]',
                '[--$reservation_number--]',
                '[--$reservation_price--]',
                '[--$reservation_date--]',
                '[--$reservation_time--]',
                '[--$reservation_fname--]',
                '[--$reservation_lname--]',
                '[--$refurl--]'
            );
            $replace = array(
                $data["company"],
                $data["site_email"],
                $data["reservation_number"],
                $data["reservation_price"],
                $data["reservation_date"],
                $data["reservation_time"],
                $data["reservation_fname"],
                $data["reservation_lname"],
                $data["reference_url"]
            );
            return str_replace($search, $replace, $text);
        }
    ),
    'registration_confirm'=> array(
        'label'=>'Registration confirmation email',
        'keys'=>array(
            array('label'=>'Company Name','value'=>'[--$company--]'),
            array('label'=>'Username','value'=>'[--$username--]'),
            array('label'=>'Email','value'=>'[--$email--]'),
            array('label'=>'Date','value'=>'[--$date--]'),
            array('label'=>'First name','value'=>'[--$first_name--]'),
            array('label'=>'Last name','value'=>'[--$last_name--]'),
            array('label'=>'Request reference','value'=>'[--$refurl--]'),
        ),
        'replace_keys'=>function($text, $company, $username, $email, $first_name, $last_name, $reference_url){
            return str_replace(array('[--$company--]', '[--$username--]','[--$email--]','[--$date--]', '[--$first_name--]', '[--$last_name--]', '[--$refurl--]'),
                array($company, $username, $email, time(), $first_name, $last_name, $reference_url),$text);
        }
    ),
    'reservation_reminder'=> array(
        'label'=>'Appointment reminder email',
        'keys'=>array(
            array('label'=>'Company Name','value'=>'[--$company--]'),
            array('label'=>'Username','value'=>'[--$username--]'),
            array('label'=>'Email','value'=>'[--$email--]'),
            array('label'=>'Date','value'=>'[--$date--]'),
            array('label'=>'First name','value'=>'[--$first_name--]'),
            array('label'=>'Last name','value'=>'[--$last_name--]'),
            array('label'=>'Appointment date','value'=>'[--$reservation_date--]'),
            array('label'=>'Appointment time','value'=>'[--$reservation_time--]'),
            array('label'=>'Dental Office name','value'=>'[--$provider_name--]'),
            array('label'=>'Dental Office phone number','value'=>'[--$provider_phone--]'),
            array('label'=>'Dental Office address','value'=>'[--$provider_address--]'),
            array('label'=>'Service name','value'=>'[--$service_name--]'),
            array('label'=>'Dental Office page URL','value'=>'[--$provider_url--]'),
        ),
        'replace_keys'=>function($text, $data){
            $search = array(
                '[--$company--]',
                '[--$email--]',
                '[--$date--]',
                '[--$first_name--]',
                '[--$last_name--]',
                '[--$reservation_date--]',
                '[--$reservation_time--]',
                '[--$provider_name--]',
                '[--$provider_phone--]',
                '[--$provider_address--]',
                '[--$service_name--]',
                '[--$provider_url--]',
            );
            $replace = array(
                $data["company"],
                $data["email"],
                time(),
                $data["first_name"],
                $data["last_name"],
                $data["reservation_date"],
                $data["reservation_time"],
                $data["provider_name"],
                $data["provider_phone"],
                $data["provider_address"],
                $data["service_name"],
                $data["provider_url"],
            );
            return str_replace($search, $replace ,$text);
        }
    ),
    'reservation_cancel_confirmation'=> array(
        'label'=>'Cancellation confirmation email',
        'keys'=>array(
            array('label'=>'Company Name','value'=>'[--$company--]'),
            array('label'=>'Username','value'=>'[--$username--]'),
            array('label'=>'Email','value'=>'[--$email--]'),
            array('label'=>'Date','value'=>'[--$date--]'),
            array('label'=>'First name','value'=>'[--$first_name--]'),
            array('label'=>'Last name','value'=>'[--$last_name--]'),
            array('label'=>'Appointment date','value'=>'[--$reservation_date--]'),
            array('label'=>'Appointment time','value'=>'[--$reservation_time--]'),
            array('label'=>'Dental Office name','value'=>'[--$provider_name--]'),
            array('label'=>'Dental Office phone number','value'=>'[--$provider_phone--]'),
            array('label'=>'Dental Office address','value'=>'[--$provider_address--]'),
            array('label'=>'Service name','value'=>'[--$service_name--]'),
            array('label'=>'Dental Office page URL','value'=>'[--$provider_url--]'),
        ),
        'replace_keys'=>function($text, $data){
            $search = array(
                '[--$company--]',
                '[--$username--]',
                '[--$email--]',
                '[--$date--]',
                '[--$first_name--]',
                '[--$last_name--]',
                '[--$reservation_date--]',
                '[--$reservation_time--]',
                '[--$provider_name--]',
                '[--$provider_phone--]',
                '[--$provider_address--]',
                '[--$service_name--]',
                '[--$provider_url--]',
            );
            $replace = array(
                $data["company"],
                $data["email"],
                time(),
                $data["first_name"],
                $data["last_name"],
                $data["reservation_date"],
                $data["reservation_time"],
                $data["provider_name"],
                $data["provider_phone"],
                $data["provider_address"],
                $data["service_name"],
                $data["provider_url"],
            );
            return str_replace($search, $replace ,$text);
        }
    ),
);