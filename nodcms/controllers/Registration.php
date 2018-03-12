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
            
            $this->form_validation->set_rules('password', _l('Password',$this), 'trim|required|callback_formRulesPassword');
            $this->form_validation->set_rules('cpassword', _l('Confirm Password',$this), 'trim|required|matches[password]');
            if ($this->form_validation->run() == FALSE){
                $this->session->set_flashdata('error_message', _l('Errors:',$this).validation_errors());
                $set_value = array(
                    'cpassword'=>'',
                    'email'=>set_value('email'),
                    'fname'=>set_value('fname'),
                    'lname'=>set_value('lname'),
                    'mobile'=>set_value('mobile'),
                    'password'=>'',
                );
                $this->session->set_flashdata('set_value', $set_value);
                $form_error = array(
                    'cpassword'=>form_error('cpassword'),
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
                $time_start = time();
                $time_start = $time_start + (7 * 24 * 60 * 60 * 60);
                //$username = $this->input->post('username', TRUE);
                $password = $this->input->post('password', TRUE);
                $active_code = md5(substr(md5(time()),4,6));
                $user = array(
                    "firstname"=>$firstname,
                    "lastname"=>$lastname,
                    "fullname"=>$firstname.' '.$lastname,
                    "mobile"=>$mobile,
                    "email"=>$email,
                    "username"=>$time_start,
                    "password"=>md5($password),
                    "active_code"=>$active_code,
                    "email_hash"=>md5($email),
                    "created_date"=>time(),
                    "reset_pass_exp"=>time()+(18000),
                    "group_id"=>20,
                    "active_register"=>0,
                    "active"=>1,
                    "status"=>1
                );

              $registered_user_id = $this->Registration_model->insertUser($user);
				
				//Get Registered user id
				
				$this->session->setuserdata('registered_user_id',$registered_user_id);
				
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
    
    function test_email(){
        $active_code = md5(substr(md5(time()),4,6));
        $firstname = "Faraz";
        $lastname = "Siddiqui";
        $mobile = "1234567";
        $email = "czxxc@mailinator.com";
        $username = "adsdas";
        $password = "zxxczc";
        $refurl = base_url().'register/user-registration/active/'.md5($email).'/'.$active_code;
        $autoEmailMsgConfig = $this->config->item('autoEmailMessages');
                $autoEmailMSG = $this->Nodcms_general_model->get_auto_messages('registration_confirm');
                if(isset($autoEmailMSG['content'])){
                    $company = $this->_website_info['company'];
                    $email_content = $autoEmailMsgConfig['registration_confirm']['replace_keys']($autoEmailMSG['content'], $company, $username, $email, $firstname, $lastname, $refurl);
                    $this->sendEmailAutomatic($email, $autoEmailMSG['subject'], $email_content);
                }
    }
    
    function dentistRegistration($step =1,$lang="en")
    {
        $status = true;
		$error = array();
        $this->preset($lang);
        $this->load->library('form_validation');
        
        if(isset($_POST['undefined']))unset($_POST['undefined']);
        
        if($this->input->post("step")=="update1"){
            //print_r($this->input->post());
            //exit();
            
            
            $this->form_validation->set_rules('fname', _l('First Name',$this), 'required|xss_clean|callback_formRulesName');
            $this->form_validation->set_rules('lname', _l('Last Name',$this), 'required|xss_clean|callback_formRulesName');
            $this->form_validation->set_rules('mobile', _l('Phone Number',$this), 'required|is_natural');
            $this->form_validation->set_rules('email', _l('Email Address',$this), 'required|valid_email|callback_userUniqueEmail');
            $this->form_validation->set_rules('password', _l('Password',$this), 'trim|required|callback_formRulesPassword');
            $this->form_validation->set_rules('cpassword', _l('Confirm Password',$this), 'trim|required|matches[password]');
            if ($this->form_validation->run() == FALSE){
                $this->session->set_flashdata('error_message', _l('Errors:',$this).validation_errors());
                $set_value = array(
                    'cpassword'=>set_value('cpassword'),
                    'email'=>set_value('email'),
                    'fname'=>set_value('fname'),
                    'lname'=>set_value('lname'),
                    'mobile'=>set_value('mobile'),
                    'password'=>'',
                );
                $this->session->set_flashdata('set_value', $set_value);
                $form_error = array(
                    'cpassword'=>form_error('cpassword'),
                    'email'=>form_error('email'),
                    'fname'=>form_error('fname'),
                    'lname'=>form_error('lname'),
                    'mobile'=>form_error('mobile'),
                    'password'=>form_error('password'),
                );
                $this->session->set_flashdata('form_error', $form_error);
                
                $status = false;
		          $error = $form_error;
                
                //$optional_fields = array();
			 //print_r($_POST['phone']);
			 //exit();
            /*foreach($this->input->post() as $key => $value)
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
				
			  
	        	
	        }*/
                
                
            }else{
                
                $time_start = time();
                $time_start = $time_start + (7 * 24 * 60 * 60 * 60);
                
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
                    "username"=>$time_start,
                    "password"=>md5($password),
                    "active_code"=>$active_code,
                    "email_hash"=>md5($email),
                    "created_date"=>time(),
                    "reset_pass_exp"=>time()+(18000),
                    "group_id"=>21,
                    "active_register"=>0,
                    "active"=>1,
                    "status"=>0
                );
                $this->Registration_model->insertUser($user);
                $this->db->select('user_id');
                $this->db->from('users');
                $this->db->order_by('user_id','desc');
                $this->db->limit('1');
                $query = $this->db-> get();
                
                $get_last_user_id = $query->result();
                
                $this->session->set_userdata(array(
                    'user_id'  => $get_last_user_id[0]->user_id,
                ));
                
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
        
        elseif($this->input->post("step")=="update2"){
            //echo "<pre>";
            //print_r($this->input->post());
            //echo "</pre>";
            //exit();
            
            
            $this->form_validation->set_rules('dental_officename', _l('Name of the Dental Office',$this), 'required|xss_clean|callback_formRulesName');
            $this->form_validation->set_rules('dental_officedescription', _l('Description of Dental Office',$this), 'required|xss_clean|callback_formRulesName');
            $this->form_validation->set_rules('dental_officephone', _l('Phone of Dental Office',$this), 'required|is_natural');
            //$this->form_validation->set_rules('dental_officeemail', _l('Email of Dental Office',$this), '');
            
            
            $optional_fields = array('dental_officewebsite','dental_officeemail','openingHours','closingHours','dayClosed');
			 //print_r($_POST['phone']);
			 //exit();
             
             foreach($_POST['dayClosed'] as $x => $oneTextFieldsValue) {
                if($oneTextFieldsValue == '' && $_POST['openingHours'][$x] != "" && $_POST['closingHours'][$x] !=""){
                    $start_min = explode(":",$_POST['openingHours'][$x]);
                    $start_min = ((int) $start_min[0]*60) + (int) $start_min[1];
                    $end_min = explode(":",$_POST['closingHours'][$x]);
                    $end_min = ((int) $end_min[0]*60) + (int) $end_min[1];
                    if($start_min > $end_min){
                        $status = FALSE;
    				    $error["closingHours[]|".$x] = 'Closing hours must be greater than opening hours.';
                    }
                }elseif($oneTextFieldsValue == '' && $_POST['openingHours'][$x] == "" && $_POST['closingHours'][$x] ==""){
                    $status = FALSE;
			        $error["openingHours[]|".$x] = 'You must provide this field.';
                    $error["closingHours[]|".$x] = 'You must provide this field.';
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
                    'dental_officeemail'=>set_value('dental_officeemail'),
                );
                $this->session->set_flashdata('set_value', $set_value);
                $form_error = array(
                    'dental_officename'=>form_error('dental_officename'),
                    'dental_officedescription'=>form_error('dental_officedescription'),
                    'dental_officephone'=>form_error('dental_officephone'),
                    //'dental_officeemail'=>form_error('dental_officeemail'),
                );
                $this->session->set_flashdata('form_error', $form_error);
                
                $error = array_filter($form_error);
                $status == FALSE;
                
                //$optional_fields = array();
			 //print_r($_POST['phone']);
			 //exit();
            /*foreach($this->input->post() as $key => $value)
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
				
			  
	        	
	        }*/
                
                
            }else{
                $time_start = time();
                $time_start = $time_start + (7 * 24 * 60 * 60 * 60);
                
                $this->db->select('user_id');
                $this->db->from('users');
                $this->db->where('user_id',$this->session->userdata('user_id'));
                $this->db->order_by('user_id','desc');
                $this->db->limit('1');
                $query = $this->db-> get();
                
                $get_last_user_id = $query->result();
                
                
                
                $data = array(
                    "provider_name"=>$this->input->post('dental_officename'),
                    "provider_username"=>$time_start,
                    "provider_email"=>$this->input->post('dental_officeemail'),
                    "phone"=>$this->input->post('dental_officephone'),
                    "description"=>$this->input->post('dental_officedescription'),
                    "website"=>$this->input->post('dental_officewebsite'),
                    "created_date"=>time(),
                    "user_id"=>$get_last_user_id[0]->user_id
                );
                $this->db->insert('r_providers',$data);
                $provider_id = $this->db->insert_id();
                
                foreach($_POST['practitioners_title'] as $x => $oneTextFieldsValue) {
                $data1 = array(
                    "practitioner_title"=>$_POST['practitioners_title'][$x],
                    "practitioner_fullname"=>$_POST['practitioner_name'][$x],
                    "provider_id"=>$provider_id
                );
                $this->db->insert('practitioners',$data1);
                
                $data3 = array(
                    "service_name"=>$_POST['practitioners_title'][$x]." ".$_POST['practitioner_name'][$x],
                    "provider_id"=>$provider_id,
                    "service_description"=>"",
                    "created_date"=>time(),
                    "price" => 1.0,
                    "user_id"=>$get_last_user_id[0]->user_id,
                    "public"=>1,
                    "price_show"=>1,
                    
                );
                
                $this->db->insert('r_services',$data3);
                $service_id = $this->db->insert_id();
                
                $days = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');

                foreach($_POST['dayClosed'] as $y => $oneTextFieldsValue1) {
                    if($oneTextFieldsValue1 == '' && $_POST['openingHours'][$y] != "" && $_POST['closingHours'][$y] !=""){
                        $start_min = explode(":",$_POST['openingHours'][$y]);
                        $start_min = ((int) $start_min[0]*60) + (int) $start_min[1];
                        $end_min = explode(":",$_POST['closingHours'][$y]);
                        $end_min = ((int) $end_min[0]*60) + (int) $end_min[1];
                        
                        $data4["user_id"]=$get_last_user_id[0]->user_id;
                        $data4["created_date"]=time();
                        $data4["service_id"]=$service_id;
                        $data4["day_no"]=$y;
                        $data4["max_count"]=1;
                        $data4["period_start_time"]=$start_min;
                        $data4["period_end_time"]=$end_min;
                        $data4["period_min"]=30;
                        $this->db->insert('r_time_period',$data4);
                    }
                // Validate $oneTextFieldsValue...
                }
                
				@$service_ids[] = $service_id;             
                }
                //$provider_id = $this->db->insert_id();
                
                
                /*$data2 = array(
                        "title"=>'Hygeine Treatment',
                        "service_description"=>"",
                        "provider_id"=>$provider_id,
                        "user_id"=>$get_last_user_id[0]->user_id,
                        "created_date"=>time(),
                        "price" => 1.0,
                        "subcategory"=>1

                    );
                
                
                
                $this->db->insert('treatments',$data2);
                $treatment_id = $this->db->insert_id();*/
					
                
                $days = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
                foreach($days as $x => $day):
                 if($_POST['openingHours'][$x] != "" && $_POST['closingHours'][$x] !=""){   
                    $start_min = explode(":",$_POST["openingHours"][$x]);
                    $start_min = ((int) $start_min[0]*60) + (int) $start_min[1];
                    $end_min = explode(":",$_POST["closingHours"][$x]);
                    $end_min = ((int) $end_min[0]*60) + (int) $end_min[1];
                 }else{
                    $end_min = 0;
                    $start_min = 0;
                 }   
                    $data3 = array(
                        "day"=>$day,
                        "closing"=>$end_min,
                        "opening"=>$start_min,
                        "closed"=>$_POST["dayClosed"][$x],
                        "provider_id"=>$provider_id
                    );
                    $this->db->insert('r_provider_time',$data3);
                    
                    
                endforeach;
                
                $this->session->set_userdata(array(
                    'provider_id' => $provider_id,
                    'service_id' => $service_ids
                ));
                
                $this->db->set('status', 1);
        $this->db->set('active_register', 1);
        $this->db->where('user_id', $get_last_user_id[0]->user_id);
        $this->db->update('users');
        

        $this->db->set('active', 1);
        $this->db->where('user_id', $get_last_user_id[0]->user_id);
        $this->db->update('r_providers');
        
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('user_id',$get_last_user_id[0]->user_id);
        $query = $this->db->get();
        $user_all_data = $query->result();
        
        $this->db->select('description');
        $this->db->from('r_providers');
        $this->db->where('provider_id',$provider_id);
        $query = $this->db->get();
        $provider_all_data = $query->result();
        
        $this->db->select('*');
        $this->db->from('r_services');
        $this->db->where_in('service_id',$service_ids);
        $query = $this->db->get();
        $service_all_data = $query->result();
        
        
        $value2['user_id'] = $get_last_user_id[0]->user_id;
        $value2['provider_id'] = $provider_id;
        $value2['group_id'] = 1;
        
        $where = array('user_id'=>$get_last_user_id[0]->user_id,'provider_id'=>$provider_id);
        $query = $this->db->get_where('r_provider_admins',$where);
        if($query->num_rows() != 0)
        {
            $row = $query->first_row();
            $this->db->update('r_provider_admins',$value2,array('provider_id'=>$row->provider_id));
        }else{
            
                $this->db->insert('r_provider_admins',$value2);
            
        }
        
                $value3['user_id'] = $get_last_user_id[0]->user_id;
                $value3['language_id'] = 1;
                $value3['relation_id'] = $provider_id;
                $value3['data_type'] = 'r_providers';
                $value3['public'] = 1;
                $value3['status'] = 1;
                $value3['full_description'] = "<p>".$provider_all_data[0]->description."</p>";
                $value3['name'] = $user_all_data[0]->fullname;
                $value3['description'] = $provider_all_data[0]->description;
                $where = array('language_id'=>1,'relation_id'=>$provider_id,'data_type'=>'r_providers');
                $query = $this->db->get_where('extensions',$where);
                if($query->num_rows() != 0)
                {
                    $row = $query->first_row();
                    $this->db->update('extensions',$value3,array('extension_id'=>$row->extension_id));
                }else{
                    
                        $this->db->insert('extensions',$value3);                    
                }
				
				
               
                for($j=0; $j<count($service_ids);$j++){
					
                    $value1['user_id'] = $get_last_user_id[0]->user_id;
                    $value1['language_id'] = 1;
                    $value1['relation_id'] = $service_ids[$j];
                    $value1['data_type'] = 'r_services';
                    $value1['public'] = 1;
                    $value1['status'] = 1;
                    $value1['full_description'] = "<p>".$service_all_data[0]->service_description."</p>";
                    $value1['name'] = $service_all_data[0]->service_name;
                    $value1['description'] = $service_all_data[0]->service_description;
                    $where = array('language_id'=>1,'relation_id'=>$service_ids[$j],'data_type'=>'r_services');
                    $query = $this->db->get_where('extensions',$where);
                    if($query->num_rows() != 0)
                    {
                        $row = $query->first_row();
                        $this->db->update('extensions',$value1,array('extension_id'=>$row->extension_id));
                    }else{
                        
                            $this->db->insert('extensions',$value1);
                        
                    }
                
                }
                
                
                
                //$this->session->set_flashdata('message', $message);
                echo json_encode(array("status" => $status,"Error_Mess" => $error,'Posted_data'=>$this->input->post(),'redirect'=>base_url()."register/dentist-registration/3"));		
		        die();
            }
            //redirect(base_url()."register/dentist-registration");
            echo json_encode(array("status" => $status,"Error_Mess" => $error,'Posted_data'=>$this->input->post(),'redirect'=>base_url()."register/dentist-registration/2"));		
		    die();
        }elseif($this->input->post("step")=="update3"){
            //print_r($this->input->post());
            //exit();
            
            
            /*$this->form_validation->set_rules('address', _l('Address',$this), 'required|xss_clean|callback_formRulesName');
            $this->form_validation->set_rules('street', _l('Description of Dental Office',$this), 'required|xss_clean|callback_formRulesName');
            $this->form_validation->set_rules('city', _l('Phone of Dental Office',$this), 'required|is_natural');
            $this->form_validation->set_rules('state', _l('Username of Dental Office',$this), 'required|callback_userUniqueUsername');*/
            
            
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
        }elseif($this->input->post("step")=="update4"){

    
             $optional_fields = array();
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
                
                foreach($_POST['treatment_name'] as $x => $oneTextFieldsValue) {
                $data1 = array(
                    "title"=>$_POST['treatment_name'][$x],
                    "service_description"=>$_POST['treatment_desc'][$x],
                    "provider_id"=>$this->session->userdata('provider_id'),
                    "user_id"=>$this->session->userdata('user_id'),
                    "created_date"=>time(),
                    "price" => $_POST['treatment_price'][$x],
                    "subcategory"=> $_POST['subcat'][$x],
                    'dentists_id'=>$_POST['treatment_practitioner'][$x],
                    "period_min" =>$_POST['treatment_duration'][$x],
                    
                );
                $treatment_id = $this->db->insert('treatments',$data1);
                
                
                }
                
                
                
                /*$address = $this->input->post('address').','.$this->input->post('street').','.$this->input->post('city').','.$this->input->post('state');
                
                */

                
                
                //$this->session->set_flashdata('message', $message);
                echo json_encode(array("status" => $status,"Error_Mess" => $error,'Posted_data'=>$this->input->post(),'redirect'=>base_url()."register/dentist-registration/5"));		
		        die();
            }
            //redirect(base_url()."register/dentist-registration");
            echo json_encode(array("status" => $status,"Error_Mess" => $error,'Posted_data'=>$this->input->post(),'redirect'=>base_url()."register/dentist-registration/4"));		
		    die();
        }elseif($this->input->post("step")=="update5"){
        
             $optional_fields = array();
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
                // Make confirm message
                /*$message = array(
                    'title'=>_l('Your subscription was successful!', $this),
                    'body'=>_l('Please check your email and click on the link posted.', $this),
                    'class'=>'note note-success'
                );
                $this->session->set_flashdata('message', $message);*/
                echo json_encode(array("status" => $status,"Error_Mess" => $error,'Posted_data'=>$this->input->post(),'redirect'=>base_url()."register/dentist-registration/message"));		
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
        
        
        
        $this->db->select('*');
        $this->db->from('category');
        $query_cat = $this->db->get();
        $all_cats = $query_cat->result();
        $this->data['all_cats']=$all_cats;
        
        $this->db->select('*');
        $this->db->from('subcategory');
        $query_subcat = $this->db->get();
        $all_subcats = $query_subcat->result();
        $this->data['all_subcats']=$all_subcats;
        
                
        $this->data['step']=$step;
        $this->data['title']=_l("Dentist Registration",$this);
        $this->data['content']=$this->load->view($this->mainTemplate.'/dentist_register',$this->data,true);
        $this->load->view($this->frameTemplate, $this->data);
    }
    // Reservation messages page after any active
    function userRegistrationMessage($lang="en"){
        $this->db->set('status', 1);
        $this->db->set('active_register', 1);
        $this->db->where('user_id', $this->session->userdata('user_id'));
        $this->db->update('users');
        

        $this->db->set('active', 1);
        $this->db->where('user_id', $this->session->userdata('user_id'));
        $this->db->update('r_providers');
        
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('service_id');
        $this->session->unset_userdata('provider_id');
        
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
            //redirect(base_url().$lang);
        }
    }
    
    
    function dentistRegistrationMessage($lang="en"){
        
        
        
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('service_id');
        $this->session->unset_userdata('provider_id');
        
        $this->preset($lang);
        $message = array(
                    'title'=>_l('Your subscription was successful!', $this),
                    'body'=>_l('Please check your email and click on the link posted.', $this),
                    'class'=>'note note-success'
                );
        $this->session->set_flashdata('message', $message);
        
        
        if($this->session->flashdata('message')){
            $message = $this->session->flashdata('message');
            $this->data['title'] = _l('User Registration', $this);
            $this->data['message_title'] = $message['title'];
            $this->data['message'] = $message['body'];
            $this->data['message_class'] = $message['class'];
            $this->data['content']=$this->load->view($this->mainTemplate.'/user_registration_message',$this->data,true);
            $this->load->view($this->frameTemplate, $this->data);
        }else{
            echo "df;ldsf";
            //redirect(base_url().$lang);
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