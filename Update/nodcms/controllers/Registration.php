<?php
/**
 * Created by PhpStorm.
 * User: Mojtaba
 * Date: 9/16/2015
 * Time: 1:03 AM
 * Project: NodCMS
 * Website: http://www.nodcms.com
 */

defined('BASEPATH') OR exit('No direct script access allowed');
class Registration extends NodCMS_Controller {
    function __construct()
    {
        parent::__construct('frontend');
        $this->load->model('Registration_model');
        $this->frameTemplate = $this->mainTemplate;
        $this->mainTemplate = 'registration';
        // Check registration available from settings
        if($this->_website_info['registration']!=1){
            redirect(base_url());
        }
    }

    // Set system language from URL
    function preset($lang)
    {
        parent::preset($lang);
        // Set top menu
        $data_menu = array();
        $menu = $this->Nodcms_general_model->get_menu();
        $i=0;
		foreach($menu as $menu)
		{
			$data_menu[$i] = array(
					'id'	=> $menu['page_id'],
					'name' =>$menu['title_caption'],
					'icon' =>$menu['menu_icon'],
					'url' =>$menu['page_id']!=0?base_url().$lang."/page/".$menu['page_id']:$menu['menu_url'],
			);
			$i++;
		}
        $this->data['data_menu'] = $data_menu;
        $this->data['languages'] = $this->Nodcms_general_model->get_languages();
        foreach ($this->data['languages'] as &$value) {
            $url_array = explode("/",$this->data["lang_url"]);
            $url_array[array_search($lang,$url_array)]=$value["code"];
            $value["lang_url"] = implode("/",$url_array);
        }
        $this->data['link_contact'] = base_url().$lang."/contact";

        $this->data['description'] = isset($this->_website_info["options"]["site_description"])?$this->_website_info["options"]["site_description"]:"";
    }

    // Register a new user
    function userRegistration($lang)
    {
        $this->preset($lang);
        $this->load->library('form_validation');
        if($this->input->raw_input_stream){
            $this->form_validation->set_rules('fname', _l('First Name',$this), 'required|xss_clean|callback_formRulesName');
            $this->form_validation->set_rules('lname', _l('Last Name',$this), 'required|xss_clean|callback_formRulesName');
            $this->form_validation->set_rules('mobile', _l('Phone Number',$this), 'required|is_natural');
            $this->form_validation->set_rules('email', _l('Email Address',$this), 'required|valid_email|callback_userUniqueEmail');
            $this->form_validation->set_rules('username', _l('Username',$this), 'required|callback_userUniqueUsername');
            $this->form_validation->set_rules('password', _l('Password',$this), 'required|callback_formRulesPassword');
            if ($this->form_validation->run() == FALSE){
                $this->session->set_flashdata('error_message', _l('Errors:',$this).validation_errors());
                $set_value = array(
                    'username'=>set_value('username'),
                    'email'=>set_value('email'),
                    'fname'=>set_value('fname'),
                    'lname'=>set_value('lname'),
                    'mobile'=>set_value('mobile'),
                    'password'=>'',
                );
                $this->session->set_flashdata('set_value', $set_value);
                $form_error = array(
                    'username'=>form_error('username'),
                    'email'=>form_error('email'),
                    'fname'=>form_error('fname'),
                    'lname'=>form_error('lname'),
                    'mobile'=>form_error('mobile'),
                    'password'=>form_error('password'),
                );
                $this->session->set_flashdata('form_error', $form_error);
            }else{
                $firstname = $this->input->post('fname', TRUE);
                $lastname = $this->input->post('lname', TRUE);
                $mobile = $this->input->post('mobile', TRUE);
                $email = $this->input->post('email', TRUE);
                $username = $this->input->post('username', TRUE);
                $password = $this->input->post('password', TRUE);
                $active_code = md5(substr(md5(time()),4,6));
                $user = array(
                    "firstname"=>$firstname,
                    "lastname"=>$lastname,
                    "fullname"=>$firstname.' '.$lastname,
                    "mobile"=>$mobile,
                    "email"=>$email,
                    "username"=>$username,
                    "password"=>md5($password),
                    "active_code"=>$active_code,
                    "email_hash"=>md5($email),
                    "created_date"=>time(),
                    "reset_pass_exp"=>time()+(18000),
                    "group_id"=>20,
                    "active_register"=>0,
                    "active"=>1,
                    "status"=>0
                );
                $this->Registration_model->insertUser($user);
                $refurl = base_url().$lang.'/user-registration/active/'.md5($email).'/'.$active_code;

                // Send auto email for user confirm
                $autoEmailMsgConfig = $this->config->item('autoEmailMessages');
                $autoEmailMSG = $this->Nodcms_general_model->get_auto_messages('registration_confirm');
                if(isset($autoEmailMSG['content'])){
                    $company = $this->_website_info['company'];
                    $email_content = $autoEmailMsgConfig['registration_confirm']['replace_keys']($autoEmailMSG['content'], $company, $username, $email, $firstname, $lastname, $refurl);
                    $this->sendEmailAutomatic($email, $autoEmailMSG['subject'], $email_content);
                }
                // Make confirm message
                $message = array(
                    'title'=>_l('Your subscription was successful!', $this),
                    'body'=>_l('Please check your email and click on the link posted.', $this),
                    'class'=>'note note-success'
                );
                $this->session->set_flashdata('message', $message);
                redirect(base_url().$lang.'/user-registration/message');
            }
            redirect(base_url().$lang."/user-registration");
        }
        if($this->session->flashdata('set_value')){
            $this->data['set_value'] = $this->session->flashdata('set_value');
            $this->data['form_error'] = $this->session->flashdata('form_error');
        }else{
            $this->data['set_value'] = array(
                'username'=>'',
                'email'=>'',
                'fname'=>'',
                'lname'=>'',
                'mobile'=>'',
                'password'=>'',
            );
            $this->data['form_error'] = $this->data['set_value'];
        }
        $this->data['title']=_l("User Registration",$this);
        $this->data['content']=$this->load->view($this->mainTemplate.'/user_register',$this->data,true);
        $this->load->view($this->frameTemplate, $this->data);
    }

    // Reservation messages page after any active
    function userRegistrationMessage($lang){
        $this->preset($lang);
        if($this->session->flashdata('message')){
            $message = $this->session->flashdata('message');
            $this->data['title'] = _l('User Registration', $this);
            $this->data['message_title'] = $message['title'];
            $this->data['message'] = $message['body'];
            $this->data['message_class'] = $message['class'];
            $this->data['content']=$this->load->view($this->mainTemplate.'/user_registration_message',$this->data,true);
            $this->load->view($this->frameTemplate, $this->data);
        }else{
            redirect(base_url().$lang);
        }
    }

    // Set new password for users after restoring request
    function activeAccount($lang, $email_hash, $active_code)
    {
        $this->preset($lang);
        $user = $this->Registration_model->getUserByEmailHashAndActiveCode($email_hash,$active_code);
        if(isset($user) && $user["reset_pass_exp"] > time() && $user["active_register"]==0){
            $this->Registration_model->activeUser($user['user_id']);
            $message = array(
                'title'=>_l('User Activate', $this),
                'body'=>_l('Your account has been successfully activated.', $this),
                'class'=>'note note-success'
            );
            $this->session->set_flashdata('message', $message);
            redirect(base_url().$lang.'/user-registration/message');
        }else{
            show_404();
        }
    }

    // Validation URL format function
    public function regexMatchUrl($text)
    {
        if(preg_match('/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i',$text)==true){
            return true;
        }else{
            $this->form_validation->set_message('regexMatchUrl', 'The {field} field is not in the correct format.');
            return false;
        }
    }

    // Validation date format function
    public function formRulesDateFormat($value)
    {
        if(checkdate(substr($value, 3, 2), substr($value, 0, 2), substr($value, 6, 4)) || checkdate(substr($value, 0, 2), substr($value, 3, 2), substr($value, 6, 4)))
            return true;
        else{
            $this->form_validation->set_message('formRulesDateFormat', 'The {field} field value was not true. 1');
            return false;
        }
    }

    // Validation name format function
    public function formRulesName($value)
    {
        if (preg_match('/[\'\/~`\!@#\$£€%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\0-9]/', $value) == TRUE) {
            $this->form_validation->set_message('formRulesName', '{field} must contain letters and spaces only.');
            $errors[] = 'Name must contain letters and spaces only';
            return FALSE;
        }else{
            return TRUE;
        }
    }
    // Validation password format function
    public function formRulesPassword($value)
    {
        if (preg_match('/^[a-z0-9\/~`\!@#\$£€%\^&\*\(\)_\-\+=\{\}\[\]\|;:]{6,18}$/', $value) == FALSE) {
            $this->form_validation->set_message('formRulesPassword', '{field} must contain letters and spaces only.');
            $errors[] = 'Name must contain letters and spaces only';
            return FALSE;
        }else{
            return TRUE;
        }
    }

    // Validation username for user registration
    public function userUniqueUsername($value){
        if (preg_match('/^[a-z0-9]{1}[a-z0-9_]{1,18}[a-z0-9]{1}$/', $value) == FALSE) {
            $this->form_validation->set_message('userUniqueUsername', '{field} can contain letters and underline only.');
            return FALSE;
        }else{
            if ($this->Registration_model->userUniqueUsername($value)) {
                return TRUE;
            }else{
                $this->form_validation->set_message('userUniqueUsername', 'Unfortunately, the username is taken by someone!');
                return FALSE;
            }
        }
    }

    // Validation username for user registration
    public function userUniqueEmail($value){
        if ($this->Registration_model->userUniqueEmail($value)) {
            return TRUE;
        }else{
            $this->form_validation->set_message('userUniqueEmail', 'Unfortunately, the email-address is taken by someone!');
            return FALSE;
        }
    }
}