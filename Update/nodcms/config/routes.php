<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes with
| underscores in the controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = "Appointment/setLanguagePrefix";
$route['404_override'] = 'General/error404';
// Admin URLs
$route['admin-sign']= "Nodcms_admin_sign/index";
$route['admin-sign/login']= "Nodcms_admin_sign/login";
$route['admin-sign/logout']= "Nodcms_admin_sign/logout";
$route['admin']= "Appointment_admin/index";
$route['admin/(.+)']= "Nodcms_general_admin/$1";
$route['admin-appointment']= "Appointment_admin/index";
$route['admin-appointment/(.+)']= "Appointment_admin/$1";
$route['admin-paypal/(.+)']= "Paypal_admin/$1";


$route['([a-z][a-z])/user-registration']= "Registration/userRegistration/$1";
$route['([a-z][a-z])/user-registration/message']= "Registration/userRegistrationMessage/$1";
$route['([a-z][a-z])/user-registration/active/([a-zA-Z0-9-]+)/([a-zA-Z0-9-]+)']= "Registration/activeAccount/$1/$2/$3";

// PayPal Addon
$route['([a-z][a-z])/appointment-paypal/([0-9-]+)/(paid|pay)']= "Paypal/appointmentCheckOut/$1/$2/$3";
$route['([a-z][a-z])/appointment-paypal-again/([0-9-]+)/(paid|pay)']= "Paypal/appointmentCheckOutAgain/$1/$2/$3";
$route['([a-z][a-z])/appointment-paypal-again/([0-9-]+)/cancel']= "Paypal/appointmentCheckOutAgainCancel/$1/$2";
$route['([a-z][a-z])/appointment-paypal/([0-9-]+)/cancel']= "Paypal/appointmentCheckOutCancel/$1/$2";
$route['([a-z][a-z])/appointment-paypal-try/([0-9-]+)']= "Paypal/appointmentCheckOutTryAgain/$1/$2";
$route['([a-z][a-z])/appointment-paypal-try/([0-9-]+)/(exists)']= "Paypal/appointmentCheckOutTryAgain/$1/$2/$3";
// Payments
$route['([a-z][a-z])/provider/([0-9a-zA-Z-\._]+)/check-available-appointment/([0-9-]+)']= "Appointment/multiProviderSystem/checkAvailableAppointment/$1/$2/$3";
$route['([a-z][a-z])/provider/([0-9a-zA-Z-\._]+)/confirm-booking/([0-9]+)'] = 'Appointment/multiProviderSystem/reservationConfirmation/$1/$2/$3';

// Appointment system (ajax type)
$route['([a-z][a-z])'] = 'Appointment/index/$1';
$route['([a-z][a-z])/([1-9][0-9]*)'] = 'Appointment/index/$1/$2';
//$route['([a-z][a-z])/get_service/([0-9]+)'] = 'Appointment/getService/$1/$2';
//$route['([a-z][a-z])/set_appointment/([0-9]+)'] = 'Appointment/setAppointment/$1/$2';
//$route['([a-z][a-z])/external'] = 'Appointment/jsOutput/$1';
//$route['([a-z][a-z])/compact'] = 'Appointment/compact/$1';
//$route['([a-z][a-z])/reservation/get_times/([0-9]+)'] = 'Appointment/getTime/$1/$2';

// Appointment system (normal type)
//$route['([a-z][a-z])/reservation/services'] = 'Appointment/index/$1';
//$route['([a-z][a-z])/reservation/service/([0-9]+)'] = 'Appointment/serviceDetail/$1/$2';
//$route['([a-z][a-z])/reservation/confirmation/([0-9]+)'] = 'Appointment/reservationConfirmation/$1/$2';
// Appointment system *Multi owner (ajax type)
$route['([a-z][a-z])/provider/([0-9a-zA-Z-\._]+)'] = 'Appointment/multiProviderSystem/providerPage/$1/$2';
$route['([a-z][a-z])/provider/([0-9a-zA-Z-\._]+)/get_service/([0-9]+)'] = 'Appointment/multiProviderSystem/getService/$1/$2/$3';
$route['([a-z][a-z])/provider/([0-9a-zA-Z-\._]+)/set_appointment/([0-9]+)'] = 'Appointment/multiProviderSystem/setAppointment/$1/$2/$3';
$route['([a-z][a-z])/provider/([0-9a-zA-Z-\._]+)/external'] = 'Appointment/multiProviderSystem/jsOutput/$1/$2';
$route['([a-z][a-z])/provider/([0-9a-zA-Z-\._]+)/compact'] = 'Appointment/multiProviderSystem/compact/$1/$2';
$route['([a-z][a-z])/provider/([0-9a-zA-Z-\._]+)/reservation/get_times/([0-9]+)'] = 'Appointment/multiProviderSystem/getTime/$1/$2/$3';
// Appointment system *Multi owner (normal type)
//$route['([1-9a-zA-Z-\._]+)/([a-z][a-z])/reservation/services'] = 'Appointment/index/multiowner/$1/$2';
//$route['([1-9a-zA-Z-\._]+)/([a-z][a-z])/reservation/service/([0-9]+)'] = 'Appointment/serviceDetail/multiowner/$1/$2/$3';
//$route['([1-9a-zA-Z-\._]+)/([a-z][a-z])/reservation/confirmation/([0-9]+)'] = 'Appointment/reservationConfirmation/multiowner/$1/$2/$3';

$route['translate_uri_dashes'] = FALSE;
