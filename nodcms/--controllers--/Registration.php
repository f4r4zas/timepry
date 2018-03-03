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
        $this->load->library(array('upload','form_validation'));
    }

    // Set system language from URL
    function preset($lang = "en")
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
    function userRegistration($lang="en")
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
                $refurl = base_url().'register/user-registration/active/'.md5($email).'/'.$active_code;

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
                redirect(base_url().'register/user-registration/message');
            }
            redirect(base_url()."register/user-registration");
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
    
    function dentistRegistration($step =1,$lang="en")
    {
        $status = true;
		$error = array();
        $this->preset($lang);
        $this->load->library('form_validation');
        
        if(isset($_POST['undefined']))unset($_POST['undefined']);
        
        if($this->input->post("step")=="update1" && $step == 1){
            //print_r($this->input->post());
            //exit();
            
            
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
                
                
                
                $optional_fields = array();
			 //print_r($_POST['phone']);
			 //exit();
            foreach($this->input->post() as $key => $value)
	        {
	           	           
			
				if(in_array($key,$optional_fields)){
					
					continue;
				}
                 else {
					
					if(is_array($value)){
						
						foreach($value as $row_val){
						  
							if(empty($row_val)){
								$status = FALSE;
								$error[$key] = form_error($key);
							}
						}
					}
                    elseif(empty($value)){
						
				        $status = FALSE;
				        $error[$key] = form_error($key);
				    }
                    else{
						//do nothing
					
					}
                    
                    
				}
				
			  
	        	
	        }
                
                
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
                $refurl = base_url().'register/user-registration/active/'.md5($email).'/'.$active_code;

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
                echo json_encode(array("status" => $status,"Error_Mess" => $error,'Posted_data'=>$this->input->post(),'redirect'=>base_url()."register/dentist-registration/2"));		
		        die();
            }
            //redirect(base_url()."register/dentist-registration");
            echo json_encode(array("status" => $status,"Error_Mess" => $error,'Posted_data'=>$this->input->post(),'redirect'=>base_url()."register/dentist-registration/"));		
		    die();
        }
        
        elseif($this->input->post("step")=="update2" && $step == 2){
            //print_r($this->input->post());
            //exit();
            
            
            $this->form_validation->set_rules('dental_officename', _l('Name of the Dental Office',$this), 'required|xss_clean|callback_formRulesName');
            $this->form_validation->set_rules('dental_officedescription', _l('Description of Dental Office',$this), 'required|xss_clean|callback_formRulesName');
            $this->form_validation->set_rules('dental_officephone', _l('Phone of Dental Office',$this), 'required|is_natural');
            $this->form_validation->set_rules('dental_officeusername', _l('Username of Dental Office',$this), 'required|callback_userUniqueUsername');
            
            
            $optional_fields = array('dental_officewebsite','openingHours','closingHours','dayClosed');
			 //print_r($_POST['phone']);
			 //exit();
             
             foreach($_POST['dayClosed'] as $x => $oneTextFieldsValue) {
                if($oneTextFieldsValue == ''){
                    $start_min = explode(":",$_POST['openingHours'][$x]);
                    $start_min = ((int) $start_min[0]*60) + (int) $start_min[1];
                    $end_min = explode(":",$_POST['closingHours'][$x]);
                    $end_min = ((int) $end_min[0]*60) + (int) $end_min[1];
                    if(empty($start_min)){
                        $status = FALSE;
    				    $error["openingHours[]|".$x] = 'You must provide this field.';
                    }
                    if(empty($end_min)){
                        $status = FALSE;
    				    $error["closingHours[]|".$x] = 'You must provide this field.';
                    }
                    if($start_min < $end_min){
                        $status = FALSE;
    				    $error["closingHours[]|".$x] = 'Closing hours must be greater than opening hours.';
                    }
                }
                // Validate $oneTextFieldsValue...
              }
             
            foreach($this->input->post() as $key => $value)
	        {
				if(in_array($key,$optional_fields)){
					
					continue;
				}
                 else {
					
					if(is_array($value)){
						
						foreach($value as $row_val){
						  
							if(empty($row_val)){
								$status = FALSE;
								$error[$key] = "You must provide this Field.";
							}
						}
					}
                    elseif(empty($value)){
						
				        $status = FALSE;
				        $error[$key] = "You must provide this Field.";
				    }
                    else{
						//do nothing
					} 
				}
	        }
            
            if ($status == FALSE){
                
                $error = array_filter($error); // Some might be empty
                
            }elseif($this->form_validation->run() == FALSE){
                $this->session->set_flashdata('error_message', _l('Errors:',$this).validation_errors());
                $set_value = array(
                    'dental_officename'=>set_value('dental_officename'),
                    'dental_officedescription'=>set_value('dental_officedescription'),
                    'dental_officephone'=>set_value('dental_officephone'),
                    'dental_officeusername'=>set_value('dental_officeusername'),
                );
                $this->session->set_flashdata('set_value', $set_value);
                $form_error = array(
                    'dental_officename'=>form_error('dental_officename'),
                    'dental_officedescription'=>form_error('dental_officedescription'),
                    'dental_officephone'=>form_error('dental_officephone'),
                    'dental_officeusername'=>form_error('dental_officeusername'),
                );
                $this->session->set_flashdata('form_error', $form_error);
                
                
                
                $optional_fields = array();
			 //print_r($_POST['phone']);
			 //exit();
            foreach($this->input->post() as $key => $value)
	        {
	           	           
			
				if(in_array($key,$optional_fields)){
					
					continue;
				}
                 else {
					
					if(is_array($value)){
						
						foreach($value as $row_val){
						  
							if(empty($row_val)){
								$status = FALSE;
								$error[$key] = form_error($key);
							}
						}
					}
                    elseif(empty($value)){
						
				        $status = FALSE;
				        $error[$key] = form_error($key);
				    }
                    else{
						//do nothing
					
					}
                    
                    
				}
				
			  
	        	
	        }
                
                
            }else{
                $this->db->select('user_id');
                $this->db->from('users');
                $this->db->order_by('id','desc');
                $this->db->limit('1');
                $query = $this->db-> get();
                
                $get_last_user_id = $query->result();
                
                
                
                $data = array(
                    "provider_name"=>$this->input->post('dental_officename'),
                    "provider_username"=>$this->input->post('dental_officeusername'),
                    "phone"=>$this->input->post('dental_officephone'),
                    "description"=>$this->input->post('dental_officedescription'),
                    "website"=>$this->input->post('dental_officewebsite'),
                    "user_id"=>$get_last_user_id[0]->user_id
                );
                $this->db->insert('r_providers',$data);
                $provider_id = $this->db->insert_id();
                
                
                $data1 = array(
                    "practitioner_title"=>$this->input->post('practitioners_title'),
                    "practitioner_fullname"=>$this->input->post('practitioner_name'),
                    "provider_id"=>$provider_id
                );
                $this->db->insert('practitioners',$data1);
                //$provider_id = $this->db->insert_id();
                
                $days = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');

                
                foreach($days as $x => $day):
                
                    $start_min = explode(":",$_POST["openingHours"][$x]);
                    $start_min = ((int) $start_min[0]*60) + (int) $start_min[1];
                    $end_min = explode(":",$_POST["closingHours"][$x]);
                    $end_min = ((int) $end_min[0]*60) + (int) $end_min[1];
                    
                    $data2 = array(
                        "day"=>$day,
                        "closing"=>$end_min,
                        "opening"=>$start_min,
                        "closed"=>$_POST["dayClosed"][$x],
                        "provider_id"=>$provider_id
                    );
                    $this->db->insert('r_provider_time',$data2);
                endforeach;
                
                $this->session->set_userdata(array(
                    'user_id'  => $get_last_user_id,
                    'provider_id' => $provider_id
                ));
                
                
                
                
                //$this->session->set_flashdata('message', $message);
                echo json_encode(array("status" => $status,"Error_Mess" => $error,'Posted_data'=>$this->input->post(),'redirect'=>base_url()."register/dentist-registration/3"));		
		        die();
            }
            //redirect(base_url()."register/dentist-registration");
            echo json_encode(array("status" => $status,"Error_Mess" => $error,'Posted_data'=>$this->input->post(),'redirect'=>base_url()."register/dentist-registration/2"));		
		    die();
        }elseif($this->input->post("step")=="update3" && $step == 3){
            //print_r($this->input->post());
            //exit();
            
            
            $this->form_validation->set_rules('address', _l('Address',$this), 'required|xss_clean|callback_formRulesName');
            $this->form_validation->set_rules('street', _l('Description of Dental Office',$this), 'required|xss_clean|callback_formRulesName');
            $this->form_validation->set_rules('city', _l('Phone of Dental Office',$this), 'required|is_natural');
            $this->form_validation->set_rules('state', _l('Username of Dental Office',$this), 'required|callback_userUniqueUsername');
            
            
            $optional_fields = array('zip');

    
             
            foreach($this->input->post() as $key => $value)
	        {
				if(in_array($key,$optional_fields)){
					
					continue;
				}
                 else {
					
					if(is_array($value)){
						
						foreach($value as $row_val){
						  
							if(empty($row_val)){
								$status = FALSE;
								$error[$key] = "You must provide this Field.";
							}
						}
					}
                    elseif(empty($value)){
						
				        $status = FALSE;
				        $error[$key] = "You must provide this Field.";
				    }
                    else{
						//do nothing
					} 
				}
	        }
            
            if ($status == FALSE){
                
                $error = array_filter($error); // Some might be empty
                
            }else{
                
                $address = $this->input->post('address').', '.$this->input->post('street').', '.$this->input->post('city').', '.$this->input->post('state');
                
                $data = array("address"=>$address);
                
                $this->db->where('provider_id',$this->session->userdata('provider_id'));
                $this->db->update('r_providers',$data);

                
                
                //$this->session->set_flashdata('message', $message);
                echo json_encode(array("status" => $status,"Error_Mess" => $error,'Posted_data'=>$this->input->post(),'redirect'=>base_url()."register/dentist-registration/4"));		
		        die();
            }
            //redirect(base_url()."register/dentist-registration");
            echo json_encode(array("status" => $status,"Error_Mess" => $error,'Posted_data'=>$this->input->post(),'redirect'=>base_url()."register/dentist-registration/3"));		
		    die();
        }elseif($this->input->post("step")=="update4" && $step == 4){

    
             
            foreach($this->input->post() as $key => $value)
	        {
				if(in_array($key,$optional_fields)){
					
					continue;
				}
                 else {
					
					if(is_array($value)){
						
						foreach($value as $row_val){
						  
							if(empty($row_val)){
								$status = FALSE;
								$error[$key] = "You must provide this Field.";
							}
						}
					}
                    elseif(empty($value)){
						
				        $status = FALSE;
				        $error[$key] = "You must provide this Field.";
				    }
                    else{
						//do nothing
					} 
				}
	        }
            
            if ($status == FALSE){
                
                $error = array_filter($error); // Some might be empty
                
            }else{
                
                /*$address = $this->input->post('address').','.$this->input->post('street').','.$this->input->post('city').','.$this->input->post('state');
                
                $data = array(
                    "address"=>$address;
                );
                
                $this->db->where('provider_id',$this->session->userdata('provider_id'));
                $this->db->update('r_providers',$data);*/

                
                
                //$this->session->set_flashdata('message', $message);
                echo json_encode(array("status" => $status,"Error_Mess" => $error,'Posted_data'=>$this->input->post(),'redirect'=>base_url()."register/dentist-registration/5"));		
		        die();
            }
            //redirect(base_url()."register/dentist-registration");
            echo json_encode(array("status" => $status,"Error_Mess" => $error,'Posted_data'=>$this->input->post(),'redirect'=>base_url()."register/dentist-registration/4"));		
		    die();
        }elseif($this->input->post("step")=="update5" && $step == 5){

    
             
            foreach($this->input->post() as $key => $value)
	        {
				if(in_array($key,$optional_fields)){
					
					continue;
				}
                 else {
					
					if(is_array($value)){
						
						foreach($value as $row_val){
						  
							if(empty($row_val)){
								$status = FALSE;
								$error[$key] = "You must provide this Field.";
							}
						}
					}
                    elseif(empty($value)){
						
				        $status = FALSE;
				        $error[$key] = "You must provide this Field.";
				    }
                    else{
						//do nothing
					} 
				}
	        }
            
            if ($status == FALSE){
                
                $error = array_filter($error); // Some might be empty
                
            }else{
                
                /*$address = $this->input->post('address').','.$this->input->post('street').','.$this->input->post('city').','.$this->input->post('state');
                
                $data = array(
                    "address"=>$address;
                );
                
                $this->db->where('provider_id',$this->session->userdata('provider_id'));
                $this->db->update('r_providers',$data);*/

                
                
                //$this->session->set_flashdata('message', $message);
                echo json_encode(array("status" => $status,"Error_Mess" => $error,'Posted_data'=>$this->input->post(),'redirect'=>base_url()));		
		        die();
            }
            //redirect(base_url()."register/dentist-registration");
            echo json_encode(array("status" => $status,"Error_Mess" => $error,'Posted_data'=>$this->input->post(),'redirect'=>base_url()."register/dentist-registration/5"));		
		    die();
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
        $this->data['step']=$step;
        $this->data['title']=_l("Dentist Registration",$this);
        $this->data['content']=$this->load->view($this->mainTemplate.'/dentist_register',$this->data,true);
        $this->load->view($this->frameTemplate, $this->data);
    }
    
    

    // Reservation messages page after any active
    function userRegistrationMessage($lang="en"){
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
    
    
    
    
    
    
    public function file_upload($input_name, $upload_path='./images', $allowed_type="gif|jpg|png"){
        $images=array();

        $files = $_FILES;
        $cpt = count($_FILES[$input_name]['name']);

        for($i=0; $i<$cpt; $i++){
            if(!empty($files[$input_name]['name'][$i])){
                $_FILES[$input_name]['name']= $files[$input_name]['name'][$i];
                $_FILES[$input_name]['type']= $files[$input_name]['type'][$i];
                $_FILES[$input_name]['tmp_name']= $files[$input_name]['tmp_name'][$i];
                $_FILES[$input_name]['error']= $files[$input_name]['error'][$i];
                $_FILES[$input_name]['size']= $files[$input_name]['size'][$i];
                $this->upload->initialize($this->set_upload_options($upload_path, $allowed_type));

                if (!$this->upload->do_upload($input_name))
                {
                    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata('error',$error['error']);
                    return $error;
                }

                //get encrypted name of uploaded image
                $fileName = $this->upload->data()['file_name'];
                $images[] = $fileName;
            }
        }
        $fileName= implode(',',$images);
        return $images;
    }
    private function set_upload_options($upload_path, $allowed_type)
    {
        // upload an image options
        $config = array();
        $config['upload_path'] = $upload_path; //give the path to upload the image in folder
        $config['allowed_types'] = $allowed_type;
        $config['max_size'] = '0';
        $config['overwrite'] = FALSE;
        $config['encrypt_name'] = TRUE;

        return $config;
    }
}