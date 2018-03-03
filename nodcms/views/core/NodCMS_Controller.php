<?php
/**
 * Created by PhpStorm.
 * User: Mojtaba
 * Date: 2/15/2016
 * Time: 6:27 PM
 * Project: NodCMS
 * Website: http://www.nodcms.com
 */

class NodCMS_Controller extends CI_Controller{
    // !Important: undefined $lang keys put in this array to add to language files
    public $langArray = array();
    // use for system settings
    public $_website_info;
    // use for view main folder
    public $mainTemplate;
    // use for view main file
    public $frameTemplate;
    // Outputs data (The parameters will use in view files)
    public $data;
    // User data from DB
    public $userdata;
    // Class type: backend or frontend
    public $controllerType;
    // Active add-ons
    private $addons = array();
    // Activate status for PayPal add-on
    public $paypal_addon = FALSE;
    // Current provider data
    public $provider = NULL;

    function __construct($controllerType='backend') // $controller_type = backend or frontend
    {
        parent::__construct();
        if(file_exists('nodcms/controllers/Paypal.php')){
            array_push($this->addons, "paypal");
            $this->paypal_addon = TRUE;
        }
        $this->controllerType = $controllerType;
        $models = $this->config->item($controllerType.'_models');
        if(file_exists(APPPATH."models/Paypal_model.php")) array_push($models, 'Paypal_model');
        $this->load->model($models);
        $this->load->model('Public_model');
        $helpers = $this->config->item($controllerType.'_helpers');
        $this->load->helper($helpers);
        $this->$controllerType();
        if(isset($this->_website_info["currency_code"])){
            if($this->_website_info["currency_sign"]!=""){
                $currencyConfig = array(
                    "code"=>$this->_website_info["currency_code"],
                    "sign"=>$this->_website_info["currency_sign"],
                    "add_before"=>"",
                    "add_after"=>"",
                );
                if($this->_website_info["currency_sign_before"]==1) {
                    $currencyConfig["add_before"] = $this->_website_info["currency_sign"];
                }else {
                    $currencyConfig["add_after"] = $this->_website_info["currency_sign"];
                }
                $this->currency->setOptions($currencyConfig);
            }
            if($this->_website_info["currency_format"]!=""){
                $this->currency->setFormat($this->_website_info["currency_format"]);
            }
        }
    }

    // To make a admin controller
    private function backend()
    {
        $this->mainTemplate = $this->config->item('NodCMS_general_admin_templateFolderName');
        $this->frameTemplate = $this->mainTemplate;
        $this->_website_info = @reset($this->Nodcms_admin_model->get_website_info());
        if(isset($this->_website_info["timezone"]) && $this->_website_info["timezone"]!=""){
            date_default_timezone_set($this->_website_info["timezone"]);
        }
        if(!isset($this->session->userdata['user_id'])) redirect(base_url()."admin-sign");
        $this->data['base_url'] = base_url()."admin/";
        define('ADMIN_URL',base_url().'admin/');
        define('APPOINTMENT_ADMIN_URL',base_url().'admin-appointment/');
        define('PAYPAL_ADMIN_URL',base_url().'admin-paypal/');
        $this->userdata = $this->Nodcms_admin_model->get_user_detail($this->session->userdata["user_id"]);
        $language = $this->Nodcms_admin_model->get_language_detail($this->userdata["language_id"]);
        $_SESSION['language'] = $language;
        $this->lang->load('backend', $language["language_name"]);
        $this->data['settings'] = $this->_website_info;
        $_SESSION['settings'] = $this->_website_info;
        // Check user access
        if(in_array($this->session->userdata('group'), array(20))
            && $this->router->fetch_class()!='Appointment_admin'
            && $this->router->fetch_class()!='Paypal_admin'){
            $this->session->set_flashdata('error', _l("Unfortunately you do not have permission to this part of system.",$this));
            redirect(APPOINTMENT_ADMIN_URL);
        }
    }

    // To make a frontend controller
    private function frontend()
    {
        $this->theme = "reservation";
        $this->mainTemplate = $this->config->item("NodCMS_general_templateFolderName");
        $this->_website_info = $this->Nodcms_general_model->get_website_info();
        if(isset($this->_website_info["timezone"]) && $this->_website_info["timezone"]!=""){
            date_default_timezone_set($this->_website_info["timezone"]);
        }
        $this->data['lang_url'] = $_SERVER["REQUEST_URI"];
    }

    // Return a default language URL if didn't set any lang in URL
    public function setLanguagePrefix()
    {
        // Available just for frontend
        if($this->controllerType != 'frontend') show_404();

        $language = $this->Nodcms_general_model->get_language_default();
        if($language!=0){
            // Redirect to new URL with default language
            redirect(base_url().$language['code']);
        }else{
            $language = $this->Nodcms_general_model->get_languages();
            if(count($language)!=0){
                // Redirect to new URL with default language
                redirect(base_url().$language[0]['code']);
            }else{
                // Not exists any language in database
                echo "System cannot find any language to load.";
                exit;
            }
        }
    }

    // Set system language from URL
    function preset($lang="en")
    {
        // Available just for frontend
        if($this->controllerType != 'frontend') show_404();
        // Set system language from URL language code (Language prefix)
        $language = $this->Nodcms_general_model->get_language_by_code($lang);
        if($language!=0){
            $_SESSION["language"] = $language;
            $this->data["lang"] = $lang;
        }else{
            $this->setLanguagePrefix();
        }

        $this->lang->load($lang, $language["language_name"]);

        $_SERVER['DOCUMENT_ROOT'] = dirname(dirname(dirname(__FILE__)));
        $this->_website_info["options"] =  $this->Nodcms_general_model->get_website_info_options($language["language_id"]);
        $this->_website_info['company_name']=isset($this->_website_info["options"]["company"])?$this->_website_info["options"]["company"]:$this->_website_info["company"];
        $this->data['settings'] =  $this->_website_info;
        $_SESSION['settings'] = $this->data['settings'];

        // Set Languages menu
        $this->data['languages'] = $this->Nodcms_general_model->get_languages();
        foreach ($this->data['languages'] as &$value) {
            $url_array = explode("/",$this->data["lang_url"]);
            $url_array[array_search($lang,$url_array)]=$value["code"];
            $value["lang_url"] = implode("/",$url_array);
        }
    }

    // Method to send notification emails to users
    public function sendNotificationEmail($auto_message_key, $language_id, $to_email, $data = array())
    {
        $autoEmailMsgConfig = $this->config->item('autoEmailMessages');
        $autoEmailMSG = $this->Public_model->getAutoMessages($auto_message_key, $language_id);
        $email_content = $autoEmailMsgConfig[$auto_message_key]['replace_keys']($autoEmailMSG['content'], $data);
        $this->sendEmailAutomatic($to_email,$autoEmailMSG['subject'],$email_content);
    }

    // Send email with protocol that in settings set
    public function sendEmailAutomatic($emails, $subject, $content, $email_theme = 'email-template-public')
    {
        if ($_SERVER['SERVER_NAME'] != 'localhost') {
            $content = $this->load->view($this->mainTemplate.'/'.$email_theme,array('body'=>$content),true);
            $setting =  $this->_website_info;
            if(isset($setting['use_smtp']) && $setting['use_smtp']==1){
                $config = array(
                    'protocol' => 'smtp',
                    'smtp_host' => $setting['smtp_host'],
                    'smtp_port' => $setting['smtp_port'],
                    'smtp_user' => $setting['smtp_username'],
                    'smtp_pass' => $setting['smtp_password'],
                    'mailtype'  => 'html',
                    'charset'   => 'iso-8859-1',
                    'starttls'  => true,
                    'newline'   => "\r\n"
                );
            }else{
                $config = array(
                    'protocol' => 'mail',
                    'mailtype'  => 'html',
                    'charset'   => 'utf8',
                    'starttls'  => true,
                    'newline'   => "\r\n"
                );
            }
            $this->load->library('email',$config);
            try {
                $this->email->clear();
                $this->email->to($emails);
                $this->email->from($setting['email']);
                $this->email->set_header('Subject',$subject);
                $this->email->message($content);
                $this->email->send();
            }catch (Exception $e){
                //Do nothing
                $SendMailError = '<p>'.implode('</p><p>',$e).'</p>';
                log_message('error', $SendMailError);
            }
        }
    }

    // Validation time format function
    public function regexMatch24Hours($text)
    {
        if(preg_match('/^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/',$text)==TRUE){
            return TRUE;
        }else{
            $this->form_validation->set_message('regexMatch24Hours', 'The %s field is not in the correct format.');
            return false;
        }
    }

    // Validation URL format function
    public function regexMatchUrl($text)
    {
        if(preg_match('/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i',$text)==TRUE){
            return TRUE;
        }else{
            $this->form_validation->set_message('regexMatchUrl', 'The %s field is not in the correct format.');
            return false;
        }
    }

    // Validation date format function
    public function formRulesDateFormat($value)
    {
        if(checkdate(substr($value, 3, 2), substr($value, 0, 2), substr($value, 6, 4)) || checkdate(substr($value, 0, 2), substr($value, 3, 2), substr($value, 6, 4)))
            return true;
        else{
            $this->form_validation->set_message('formRulesDateFormat', 'The {field} field value was not true.');
            return false;
        }
    }

    // Validation name format function
    public function formRulesName($value)
    {
        if (preg_match('/[\'\/~`\!@#\$£€%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\0-9]/', $value) == true) {
            $this->form_validation->set_message('formRulesName', '{field} must contain letters and spaces only.');
            $errors[] = 'Name must contain letters and spaces only';
            return false;
        }else{
            return true;
        }
    }

    // Validation username type function
    public function validateUsernameType($value)
    {
        if (preg_match('/^[a-z0-9]{1}[a-z0-9_]{1,18}[a-z0-9]{1}$/', $value) == FALSE) {
            $this->form_validation->set_message('validateUsernameType', '{field} can contain just English letters and underline only.');
            return FALSE;
        }else{
            return TRUE;
        }
    }

    // Validation username function (check unique with DB)
    public function validateProviderUsername($value, $id)
    {
        if (preg_match('/^[a-z0-9]{1}[a-z0-9_]{1,18}[a-z0-9]{1}$/', $value) == FALSE) {
            $this->form_validation->set_message('validateProviderUsername', '{field} can contain letters and underline only.');
            return FALSE;
        }else{
            if($this->Appointment_admin_model->checkProviderUnique(array('provider_username'=>$value), $id)){
                $this->form_validation->set_message('validateProviderUsername', '{field} must be unique.');
                return FALSE;
            }else{
                return TRUE;
            }
        }
    }

    // Validation username function (check unique with DB)
    public function validateUsername($value)
    {
        if (preg_match('/^[a-z0-9]{1}[a-z0-9_]{1,18}[a-z0-9]{1}$/', $value) == FALSE) {
            $this->form_validation->set_message('validateUsername', '{field} can contain letters and underline only.');
            return FALSE;
        }else{
            if($this->Appointment_admin_model->checkUserUnique(array('username'=>$value),$this->session->userdata['user_id'])){
                $this->form_validation->set_message('validateUsername', '{field} must be unique.');
                return FALSE;
            }else{
                return TRUE;
            }
        }
    }

    // Validation email unique function
    public function emailUnique($value)
    {
        if($this->Appointment_admin_model->checkUserUnique(array('email'=>$value),$this->session->userdata['user_id'])){
            $this->form_validation->set_message('emailUnique', '{field} must be unique.');
            return false;
        }else{
            return true;
        }
    }

    public function activeAddOn($value)
    {
        if(in_array($value, $this->addons))
            return TRUE;
        else
            return FALSE;
    }
}