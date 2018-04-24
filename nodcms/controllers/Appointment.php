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
class Appointment extends NodCMS_Controller {
    public $provider_prefix = '';
    public $url_prefix = '';
    public $multi_owner = FALSE;

    function __construct()
    {
        parent::__construct('frontend');
        // jQuery ui calendar languages files
        $this->data['calendar_i18n'] = array(
            'af', 'ar', 'az', 'be', 'gb', 'bs', 'ca', 'cs', 'cy', 'da', 'de', 'el', 'eo', 'es', 'et', 'eu', 'fa', 'fi',
            'fo', 'fr', 'gl', 'he', 'hi', 'hr', 'hu', 'hy', 'id', 'is', 'it', 'ja', 'ka', 'kk', 'km', 'ko', 'ky', 'lb',
            'lt', 'lv', 'mk', 'ml', 'ms', 'nb', 'nl', 'nn', 'no', 'pl', 'pt', 'rm', 'ro', 'ru', 'sk', 'sl', 'sq', 'sr',
            'sv', 'ta', 'th', 'tj', 'tr', 'uk', 'vi',
        );
    }

    // Check system type (Multi-Owner or normal)
    function multiProviderSystem($method, $lang="en", $provider_username, $id = NULL){
		
        $provider = $this->Appointment_model->getProviderByUsername($provider_username);
        if(count($provider)!=0 && ($this->_website_info['appointment_multiowner'] || $provider[0]['default']!=0)){
            // # Dental Office exists and (multi provider system = TRUE or the provider default = 1)
            $this->provider_prefix = '/provider/'.$provider[0]['provider_username'];
            $this->provider = $provider[0];
			/* echo "<pre>";
				print_r($this->provider);
			echo "</pre>"; */
			
        }else{
            // Dental Office didn't exists
            if($this->input->is_ajax_request()){
                echo json_encode(array('status'=>'error', 'error'=>_l('Your request was wrong!', $this)));
            }else{
                show_404();
            }
        }
        $this->$method($lang="en", $id);
    }

    // Set system language from URL
    function preset($lang = 'en')
    {
        parent::preset($lang);
        // Set top menu
        $data_menu = array();
        $menu = $this->Nodcms_general_model->get_menu();
        $i=0;
        foreach($menu as $item)
        {
            $data_menu[$i] = array(
                'id'	=> $item['page_id'],
                'name' =>$item['title_caption'],
                'icon' =>$item['menu_icon'],
                'url' =>substr($item['menu_url'],0,4)=="http"?$item['menu_url']:base_url().$lang."/".$item['menu_url'],
            );
            $i++;
        }
        $this->data['data_menu'] = $data_menu;

        $this->data['link_contact'] = base_url().$lang."/contact";

        $this->data['description'] = isset($this->_website_info["options"]["site_description"])?$this->_website_info["options"]["site_description"]:"";
    }

//    Homepage
	function index($lang = "en" )
    {
		
		if(empty($_GET)){
			redirect("/");
		}
	
		if(!empty($_GET)){

			if(empty($this->input->get("search_location")) & empty($this->input->get("treatmentSubcatId")) & empty($this->input->get("search_dental_clinic")))
			{	
				redirect("/");
			}
			
			 $provider_condition = array(
				'provider_location' => $this->input->get("search_location"),
				'treatment_cat' => $this->input->get("treatmentSubcatId"),
				'search_dental_clinic' => $this->input->get("search_dental_clinic")
			);
			
			if(!empty($this->input->get("search_dental_clinic"))){
				$provider_condition['dateSearch'] = $this->input->get("search_dental_clinic"); 
			}
			
				
			 $this->preset($lang);
			$count = $this->Appointment_model->countProvider();
			if($count!=0){
				if(!$this->_website_info['appointment_multiowner']){
					$default_provider = $this->Appointment_model->getAllProvider(array('default'=>1));
					if(count($default_provider)!=0){
						$this->multiProviderSystem('providerPage', $lang, $default_provider[0]['provider_username']);
					}else{
						$this->comingSoon();
					}
				}else{
					$this->providerList($lang,$provider_condition);
				}
			}else{
				$this->comingSoon();
			}
			
		}else{
			
		}
		
       
	}

    // Coming soon page
    function comingSoon(){
        $this->data['title'] = $this->_website_info['company'].' '._l("Coming Soon", $this);
        $this->data['heading'] = _l("Coming Soon!", $this);
        $this->data['message'] = _l("Now the system is ready to operate.", $this);
        $this->data['message'] .= ' '._l("After updating information by the administrator, the system will be available.", $this);
        $this->data['keyword'] = "";
        $this->data['content'] = "";
        $this->load->view("coming_soon", $this->data);
    }

    // Dental Office list to choose a provider
    private function providerList($lang="en",$condition = "", $page=1){

        $this->preset($lang);
        // Dental Office search
        $searchConditions = array();
        $str_search = array();
        $str_replace = array();
        if($this->input->get('search')){
            $searchText = trim(strip_tags(((urldecode($this->input->get('search', TRUE))))));
            $searchWords = explode(' ', $searchText);
            $searchQuery = array();
            foreach ($searchWords as $word){
                array_push($searchQuery, "name LIKE '%$word%'");
                // Set str replace array to highlight search words
                array_push($str_search, $word);
                array_push($str_replace, "<mark>$word</mark>");
            }
            if(count($searchQuery)!=0){
                $searchQuery = implode(" AND ", $searchQuery);
                $searchConditions = "provider_id IN (SELECT relation_id FROM extensions WHERE data_type = 'r_providers' AND $searchQuery)";
            }
            $this->data['search_word'] = $searchText;
        }else{
            $this->data['search_word'] = '';
        }
        /*echo "<pre>";
        print_r($searchConditions);
        echo "</pre>";*/
        // Page navigation
        $config = array();
        $config['base_url'] = base_url().$lang;
        $config['query_string_segment'] = '';
        $config['reuse_query_string'] = TRUE;
        $config['total_rows'] = $this->Appointment_model->countProvider($searchConditions);
        $config['uri_segment'] = 2;
        $config['per_page'] = 20;
        $this->mkPagination($config);
        $page--;

        $this->data['data_list'] = $this->Appointment_model->getAllProvider($searchConditions, $config['per_page'], $config['per_page']*$page);

		if(!empty($condition)){
				$this->data['data_list'] = $this->Appointment_model->getCustomProvider($condition, $config['per_page'], $config['per_page']*$page);
		}
		
        if(count($this->data['data_list'])!=0){
            foreach($this->data['data_list'] as $key=>$item){
                $providerExtension = $this->Appointment_model->getProviderExtensions($item['provider_id']);
                if(count($providerExtension)!=0){
                    $providerExtension = @reset($providerExtension);
                    // Highlghte search words
                    $providerExtension['name'] = str_replace($str_search, $str_replace, $providerExtension['name']);
                    // Replace translated name and description
                    //$this->data['data_list'][$key]['provider_name'] = $providerExtension['name'];
                    $this->data['data_list'][$key]['provider_description'] = $providerExtension['full_description'];
                }else{
                    $this->data['data_list'][$key]['provider_description'] = '<p><i class="fa fa-warning font-red"></i> '
                        ._l('Description in this language is not set!', $this).'</p>';
                }
            }
        }


        $this->data['title'] = isset($this->_website_info["options"]["site_title"])?$this->_website_info["options"]["site_title"]:$this->_website_info['company'];
        $this->data['keyword'] = isset($this->_website_info["options"]["site_keyword"])?$this->_website_info["options"]["site_keyword"]:"";
        $this->data['content'] = $this->load->view('reservation/providers',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    // A provider page (ready to make a reservation)
    function providerPage($lang="en"){

        $this->preset($lang);
		$this->data['provider_id'] = $this->provider['provider_id']; 
        $providerExtension = $this->Appointment_model->getProviderExtensions($this->provider['provider_id']);
        if(count($providerExtension)!=0){
            $providerExtension = @reset($providerExtension);
            //$this->provider['provider_name'] = $providerExtension['name'];
            $this->provider['provider_description'] = $providerExtension['full_description'];
        }else{
            $this->provider['provider_description'] = '<i class="fa fa-warning font-red"></i> '
                ._l('Description in this language is not set!', $this);
        }
        $this->data['data_list']= $this->Appointment_model->getAllServices();
        foreach($this->data['data_list'] as $key=>$item){
            $extensionService = $this->Appointment_model->getServiceExtensions($item['service_id']);
            if(count($extensionService)!=0){
                //$this->data['data_list'][$key]['service_name'] = $extensionService[0]['name'];
                //$this->data['data_list'][$key]['service_description'] = $extensionService[0]['description'];
            }else{
                /*$this->data['data_list'][$key]['service_description'] = '<i class="fa fa-warning font-red"></i> '
                    ._l('Description in this language is not set!', $this);*/
//                $this->data['data_list'][$key]['service_description'] = 'test';
            }
            $this->data['data_list'][$key]['price'] = $item['price']>0?$this->currency->format($item['price']):_l("Free",$this);
        }
        
        $this->db->select('*');
        $this->db->from('r_services');
        $this->db->where('provider_id',$this->provider['provider_id']);
        $query = $this->db->get();
        $this->data['practitioners'] = $query->result_array();
        
        
        $this->db->select('*');
        $this->db->from('r_provider_time');
        $this->db->where('provider_id',$this->provider['provider_id']);
        $query = $this->db->get();
        $this->data['do_time'] = $query->result_array();
                
        

        
        
        $this->data['extra_fields']= $this->Appointment_model->getAllExtraFields();
        $this->data['title'] = _l('Dental Office Page', $this);
        $this->data['sub_title'] = $this->provider['provider_name'];
        
	
		$this->data['reviews'] = $this->Appointment_model->getReviews($this->data['provider_id']);

		$this->data['sub_cats'] = $this->getTreatments();


		
		$this->data['content']=$this->load->view('reservation/provider_detail',$this->data,true);
		
        $this->load->view($this->mainTemplate,$this->data);
    }

/*    External Form
 * This page will be use appointment system in another website.
 * It just a page that make an iframe.
 */
    function jsOutput($lang="en")
    {
        $this->preset($lang);
        // Set some theme options for portable button
        $get_data = $this->input->get(NULL,TRUE);
        if(isset($get_data['btnColor']) && $this->form_validation_color($get_data['btnColor'])){
            $this->data['btnColor'] = $get_data['btnColor'];
        }
        if(isset($get_data['btnBgColor']) && $this->form_validation_color($get_data['btnBgColor'])){
            $this->data['btnBgColor'] = $get_data['btnBgColor'];
        }
        if(isset($get_data['btnHoverBgColor']) && $this->form_validation_color($get_data['btnHoverBgColor'])){
            $this->data['btnHoverBgColor'] = $get_data['btnHoverBgColor'];
        }
        if(isset($get_data['btnBorderColor']) && $this->form_validation_color($get_data['btnBorderColor'])){
            $this->data['btnBorderColor'] = $get_data['btnBorderColor'];
        }
        if(isset($get_data['btnBorder']) && $this->form_validation_number($get_data['btnBorder'],'1|0')){
            $this->data['btnBorder'] = $get_data['btnBorder'];
        }
        if(isset($get_data['btnPadding']) && $this->form_validation_number($get_data['btnPadding'],'1|0')){
            $this->data['btnPadding'] = $get_data['btnPadding'];
        }
        if(isset($get_data['btnBorderRadius']) && $this->form_validation_number($get_data['btnBorderRadius'],'1|0')){
            $this->data['btnBorderRadius'] = $get_data['btnBorderRadius'];
        }
        if(isset($get_data['btnText']) && $this->form_validation_text($get_data['btnText'],'0|0')){
            $this->data['btnText'] = $get_data['btnText'];
        }else{
            $this->data['btnText'] = _l('Book Now',$this);
        }
        if(isset($get_data['btnClass']) && $this->form_validation_text($get_data['btnClass'],'0|0')){
            $this->data['btnClass'] = $get_data['btnClass'];
        }

        $js_output = $this->load->view('reservation/js_output',$this->data,true);
        echo str_replace(array('<script>','</script>'),'',$js_output);
    }

//    This page is a compact page for use the appointment system with ajax
    function compact($lang ="en"){
        $this->preset($lang);
        $this->data['extra_fields']= $this->Appointment_model->getAllExtraFields();
        $this->data['data_list']= $this->Appointment_model->getAllServices();
        foreach($this->data['data_list'] as $key=>$item){
            $extensionService = $this->Appointment_model->getServiceExtensions($item['service_id']);
            if(count($extensionService)!=0){
                $this->data['data_list'][$key]['service_name'] = $extensionService[0]['name'];
                $this->data['data_list'][$key]['service_description'] = $extensionService[0]['description'];
            }else{
                $this->data['data_list'][$key]['service_description'] = '<i class="fa fa-warning font-red"></i> '
                    ._l('Description in this language is not set!', $this);
//                $this->data['data_list'][$key]['service_description'] = 'test';
            }
        }
        $this->data['title']= isset($this->data['settings']["options"]["site_title"])?$this->data['settings']["options"]["site_title"]:"";
        $this->data['keyword']= isset($this->data['settings']["options"]["site_keyword"])?$this->data['settings']["options"]["site_keyword"]:"";
        $this->data['description']= isset($this->data['settings']["options"]["site_description"])?$this->data['settings']["options"]["site_description"]:"";
        $this->data['content']=$this->load->view('reservation/home',$this->data,true);
        $this->load->view('reservation_iframe',$this->data);
    }
    
    
//  Get practitioner
    function getPractitioner($lang="en",$id)
    {
		
        $this->preset($lang);
		
		
        $this->session->set_userdata("treatment_id",$id);
         
        $this->db->select('*');
        $this->db->from('treatments');
        $this->db->where('id',$id);
        $query = $this->db->get();
        $treatments = $query->result();
        $practitioners = explode(',',$treatments[0]->dentists_id);
        
        $practitioner_detail = array();
        foreach($practitioners as $practitioner):
                $this->db->select('*');
                $this->db->from('r_services');
                $this->db->where('service_id',trim($practitioner));
                $query = $this->db->get();
                $thispractitioner = $query->result();
                
                if(!empty($thispractitioner)){
      
                    
                    $practitioner_detail[$thispractitioner[0]->service_id]=$thispractitioner[0]->service_name;
                }            
        endforeach;
        
                                                                    
            // If exists some available days
            if(count($practitioner_detail)!=0){
                // Success
                $data = array('treatment_id'=>$this->session->userdata("treatment_id"),'status'=>'success','practitioners'=>$practitioner_detail);
            }else{
                // Error
                $data = array('treatment_id'=>$this->session->userdata("treatment_id"),'status'=>'error','error'=>_l("Unfortunately, now is no time available for appointments for this Dentist!",$this));
            }
        echo json_encode($data);
    }    

//    Get a service detail form compact page with ajax
    function getService($lang="en",$id)
    {
        $this->preset($lang);
        $this->data['data'] =  @reset($this->Appointment_model->getServiceDetail($id));
		//print_r($id);
        if(isset($this->data['data']["service_id"])){
            $this->data['disable_dates'] = array();
            $free_days =  $this->Appointment_model->getAllFreeDays();
            foreach($free_days as $item){
                array_push($this->data['disable_dates'],date("Y-m-d",$item['free_date']));
            }
            $this->data['allow_days'] = array();
            for($i=0;$i<=6;$i++){
                $allow_days =  $this->Appointment_model->getTimePeriod($i,$id);
                if(count($allow_days)!=0){
                    array_push($this->data['allow_days'],$i);
                    foreach ($allow_days as $item) {
                        $candida = array();
                        $theTimes = array();
                        for($j=$item["period_start_time"];$j<$item["period_end_time"];$j+=$item["period_min"]){
                            array_push($theTimes,$j);
                        }
                        $maxCountInOnePeriod = ($item["period_end_time"]-$item["period_start_time"])/$item["period_min"];
                        $full_reservation =  $this->Appointment_model->checkFullReservationDate($id,$i,implode(",",$theTimes));
                        foreach($full_reservation as $itemReservation){
                            if($itemReservation["reservation_count"]>=$item["max_count"]){
                                if(!isset($candida[$itemReservation["reservation_date"]])){
                                    $candida[$itemReservation["reservation_date"]] = 1;
                                }else{
                                    $candida[$itemReservation["reservation_date"]]++;
                                }
                                if(isset($candida[$itemReservation["reservation_date"]]) && $candida[$itemReservation["reservation_date"]] >= $maxCountInOnePeriod){
                                    array_push($this->data['disable_dates'],date("Y-m-d",$itemReservation["reservation_date"]));
                                }
                            }
                        }
                    }
                }
            }
            // If exists some available days
            if(count($this->data['allow_days'])!=0){
                // Success
                $data = array('treatment_id'=>$this->session->userdata("treatment_id"),'status'=>'success','disable_dates'=>$this->data['disable_dates'],'allow_days'=>$this->data['allow_days']);
            }else{
                // Error
                $data = array('treatment_id'=>$this->session->userdata("treatment_id"),'status'=>'error','error'=>_l("Unfortunately, now is no time available for appointments for this Dentist!",$this));
            }
        }else{
            // Error
            $data = array('treatment_id'=>$this->session->userdata("treatment_id"),'status'=>'error','error'=>_l("Dentist doesn't exists!",$this));
        }
        echo json_encode($data);
    }

//    Set an appointment request from compact page with ajax
    function setAppointment($lang="en",$id)
    {
		  //Method for user no of reservations 
		   get_instance()->load->helper('user');
           $this->preset($lang);
        
        $extra_fields = $this->Appointment_model->getAllExtraFields();
        //if(isset($service["service_id"])){
            $this->load->library('form_validation');
            if($this->input->raw_input_stream){
                //$this->form_validation->set_rules('date', _l('Date',$this), 'required|callback_formRulesDateFormat');
                //$this->form_validation->set_rules('time', _l('Time',$this), 'required|callback_regexMatch24Hours');
                $this->form_validation->set_rules('fname', _l('First Name',$this), 'required|xss_clean|callback_formRulesName');
                $this->form_validation->set_rules('lname', _l('Last Name',$this), 'required|xss_clean|callback_formRulesName');
                $this->form_validation->set_rules('email', _l('Email Address',$this), 'required|valid_email');
                $this->form_validation->set_rules('tel', _l('Phone Number',$this), 'required|is_natural');
                foreach($extra_fields as $item){
                    $this->form_validation->set_rules('extra_field'.$item['id'], $item['title_caption'], ($item['require']==1?'required|':'').'callback_form_validation_'.strtolower($item['type_name']).'['.$item['min'].'|'.$item['max'].']');
                }
                if ($this->form_validation->run() == FALSE){
                    $data = array('status'=>'error','error'=>_l('Errors:',$this).validation_errors());
                }else{
                    $post_data1 = $this->input->post(NULL,TRUE);
                    // Check & Validate appointments
                    
                    $content = "";
                    foreach($post_data1['service'] as $mainKey => $mainValue){
                        $newpost_data = array(
                                        'time' => $post_data1['time'][$mainKey],
                                        'date' => $post_data1['date'][$mainKey],
                                        'tel' => $post_data1['tel'],
                                        'email' => $post_data1['email'],
                                        'lname' => $post_data1['lname'],
                                        'fname' => $post_data1['fname'],
                                        'treatment_id' => $post_data1['service'][$mainKey],
                                    );
                        $post_data = $newpost_data;
                        $id = $post_data1['practitioner'][$mainKey];

                    //print_r($post_data);
                    
                    //exit();

                    $appointmentValidation = $this->setAppointmentValidation($id, $post_data);
                    
                    $service =  @reset($this->Appointment_model->getServiceDetail($id));
					
					 if(!empty($this->session->userdata("email"))){ 
					 $totalReservations = getNoReservations($this->session->userdata("email"));
						if($totalReservations >= 10){
							
							$discounted = $service["price"] * 20 / 100;
							
								$service["price"] = $service['price'] - $discounted;
						}
					} 
					
					
                    if($appointmentValidation["status"] == "success"){
                        $start_time = $appointmentValidation["start_time"];
                        $time_period = $appointmentValidation["time_period"];
                        $thisMin = $appointmentValidation["thisMin"];
                        $dayNO = $appointmentValidation["dayNO"];
                        $justDate = $appointmentValidation["justDate"];
                        $end_time = $appointmentValidation["end_time"];
                        // Make Reservation number
                        $reservationNumber = str_pad(($this->Appointment_model->countReservation($id,$start_time) + 1), strlen($time_period["max_count"]), '0', STR_PAD_LEFT);
                        $reservationNumber = $thisMin.$reservationNumber;
                        $new_reservation = array(
                            "service_id"=>$id,
                            "fname"=>$post_data["fname"],
                            "lname"=>$post_data["lname"],
                            "tel"=>$post_data["tel"],
                            "email"=>$post_data["email"],
                            "reservation_day_no"=>$dayNO,
                            "reservation_date"=>$justDate,
                            "reservation_date_time"=>$start_time,
                            "reservation_edate_time"=>$end_time,
                            "service_name"=>$service["service_name"],
                            "price"=>$service["price"],
                            "owner_user_id"=>$service["user_id"],
                            "reservation_number"=>$reservationNumber,
                            "lang"=>$lang,
                            "language_id"=>$_SESSION['language']['language_id']
                        );
                        
                        
                        if($this->provider["payment_type"]==0 || $this->provider["payment_type"]==2 || $service["price"]==0){
                            // No need to payment
                            $reservationID = $this->Appointment_model->addToReservation($new_reservation);
                            foreach($extra_fields as $item){
                                if(isset($post_data['extra_field'.$item['id']])){
                                    if($item['field_type']==4) $post_data['extra_field'.$item['id']] = _l('Yes',$this);
                                    $this->Appointment_model->addExtraFieldValue($reservationID,$item['field_name'],$post_data['extra_field'.$item['id']]);
                                }
                            }
                            $this->data['data'] =  @reset($this->Appointment_model->getReservationDetail($reservationID));
                            $extension = $this->Appointment_model->getServiceExtensions($this->data['data']["service_id"]);
                            if(count($extension)!=0){
                                $this->data['data']['service_name'] = $extension[0]['name'];
                                $this->data['data']['service_description'] = $extension[0]['description'];
                            }else{
                                $this->data['data']['service_description'] = '';
                            }
                            $this->data['data']['price_show'] = $service['price_show'];
                            $content .= $this->load->view('reservation/reservation_confirmation', $this->data, true);
                            /*$autoEmailMsgConfig = $this->config->item('autoEmailMessages');
                            // Send email to Customer
                            $autoEmailMSG = $this->Nodcms_general_model->get_auto_messages('reservation_confirmation');
                            $set_data = array(
                                "company"=>$this->_website_info['company'],
                                "site_email"=>$this->_website_info['email'],
                                "reservation_number"=>$reservationNumber,
                                "reservation_price"=>$this->data['data']['price'],
                                "reservation_date"=>my_int_justDate($justDate),
                                "reservation_time"=>my_int_justTime($start_time),
                                "reservation_fname"=>$post_data["fname"],
                                "reservation_lname"=>$post_data["lname"],
                                "reference_url"=>'');
                            $email_content = $autoEmailMsgConfig['reservation_confirmation']['replace_keys']($autoEmailMSG['content'], $set_data);
                            $this->sendEmailAutomatic($post_data["email"],$autoEmailMSG['subject'],$email_content);
                            // Send email to admin
                            $managers = $this->Appointment_model->getProviderManagers($this->provider["provider_id"], array("notification_email"=>1));
                            if(count($managers)!=0){
                                $autoEmailMSG = $this->Nodcms_general_model->get_auto_messages('reservation_confirmation_admin');
                                $set_data = array(
                                    "company"=>$this->_website_info['company'],
                                    "site_email"=>$this->_website_info['email'],
                                    "reservation_number"=>$reservationNumber,
                                    "reservation_price"=>$this->data['data']['price'],
                                    "reservation_date"=>my_int_justDate($justDate),
                                    "reservation_time"=>my_int_justTime($start_time),
                                    "reservation_fname"=>$post_data["fname"],
                                    "reservation_lname"=>$post_data["lname"],
                                    "reference_url"=>'',
                                );
                                $email_content = $autoEmailMsgConfig['reservation_confirmation_admin']['replace_keys']($autoEmailMSG['content'], $set_data);
                                foreach($managers as $item){
                                    $this->sendEmailAutomatic($item["email"],$autoEmailMSG['subject'],$email_content);
                                }
                            }*/
                            $data = array('status'=>'success','result'=>$content);
                        }elseif($this->provider["payment_type"] == 1 && $service["price"] > 0){
                            // Should payment
                            $reservationID = $this->Appointment_model->addToPreReservation($new_reservation);
                            foreach($extra_fields as $item){
                                if(isset($post_data['extra_field'.$item['id']])){
                                    if($item['field_type']==4) $post_data['extra_field'.$item['id']] = _l('Yes',$this);
                                    $this->Appointment_model->addPreExtraFieldValue($reservationID,$item['field_name'],$post_data['extra_field'.$item['id']]);
                                }
                            }
                            $this->data['data'] =  @reset($this->Appointment_model->getPreReservationDetail($reservationID));
                            $extension = $this->Appointment_model->getServiceExtensions($this->data['data']["service_id"]);
                            if(count($extension)!=0){
                                $this->data['data']['service_name'] = $extension[0]['name'];
                                $this->data['data']['service_description'] = $extension[0]['description'];
                            }else{
                                $this->data['data']['service_description'] = '';
                            }
                            $this->data['data']['price_show'] = $service['price_show'];
                            $content .= $this->load->view('reservation/reservation_confirmation', $this->data, true);
                            $data = array('status'=>'success','result'=>$content);
                        }else{
                            // if provider payment_type has not certain value(Acceptable values: 0, 1, 2)
                            $data = array('status'=>'error','error'=>_l("Payment type fail!",$this));
                        }
                        
                    
                    }else{
                        $data = $appointmentValidation;
                    }
                    
                    //print_r($data);
                    
                    }
                    
                    
                }
            }else{
                $data = array('status'=>'error','error'=>_l("Argument fail!",$this));
            }
        /*}else{
            $data = array('status'=>'error','error'=>_l("Service doesn't exists!",$this));
        }*/
        echo json_encode($data);
    }

    // Appointment validation for ajax requests
    function checkAvailableAppointment($lang="en", $id){
        $this->preset($lang);
        $service =  @reset($this->Appointment_model->getPreServiceDetail($id));
        if(isset($service["service_id"])) {
            $this->load->library('form_validation');
            if ($this->input->raw_input_stream) {
                $this->form_validation->set_rules('date', _l('Date', $this), 'required|callback_formRulesDateFormat');
                $this->form_validation->set_rules('time', _l('Time', $this), 'required|callback_regexMatch24Hours');
                $this->form_validation->set_rules('email', _l('Email Address', $this), 'required|valid_email');
                if ($this->form_validation->run() == FALSE) {
                    $data = array('status' => 'error', 'error' => _l('Errors:', $this) . validation_errors());
                } else {
                    $post_data = $this->input->post(NULL,TRUE);
                    $appointmentValidation = $this->setAppointmentValidation($id, $post_data);
                    if($appointmentValidation["status"] == "success"){
                        $data = array("status"=>"success");
                    }else{
                        $data = array("status"=>"error", "error"=>_l("This appointment time is not more available!", $this));
                    }
                }
            }else{
                $data = array("status"=>"error", "error"=>_l("Posted arguments are fails!", $this));
            }
        }else{
            $data = array('status'=>'error','error'=>_l("Service doesn't exists!",$this));
        }
        echo json_encode($data);
    }

    // Validation of an appointment (This method is a private method and used just in this file)
    private function setAppointmentValidation($service_id, $post_data){
        // IMPORTANT: $post_data should have this keys: "date", "time", "email"
        if(isset($this->_website_info['appointment_non_repeating']) && $this->_website_info['appointment_non_repeating']==1){
            $duplicate = $this->Appointment_model->reservationExists(array('email'=>$post_data["email"], 'service_id'=>$service_id));
        }else{
            $duplicate = 0;
        }
        //if(!$duplicate){
            $intDate = strtotime($post_data["date"]);
            // Check holly days
            if($this->Appointment_model->checkFreeDate($intDate,$service_id) == 0){
                $dayNO = date("N",$intDate)==7?0:date("N",$intDate);
                $thisTime = explode(":",$post_data["time"]);
                $thisMin = ((int) $thisTime[0] * 60) + (int) $thisTime[1];
                $time_period =  @reset($this->Appointment_model->getTimePeriod($dayNO,$service_id,$thisMin,$post_data["treatment_id"]));
                // Check period exists
                if(isset($time_period["period_id"])){
                    // Check selected time in period
                    if($thisMin>=$time_period["period_start_time"] && $thisMin<$time_period["period_end_time"]){
                        // Check selected time in period section
                        $checkMin = ($thisMin - $time_period["period_start_time"]) % $time_period["period_min"];
                        if($checkMin==0){
                            $justDate = $intDate;
                            $start_time = $intDate+($thisMin*60);
                            $end_time = $intDate+(($thisMin+$time_period["period_min"])*60);
                            // Check start time not yet
                            if($start_time>time()){
                                $existsReservationCount = $this->Appointment_model->checkReservation($service_id,$start_time,$end_time);
                                if($time_period["max_count"]==0 || $existsReservationCount < $time_period["max_count"]){
                                    // Acceptable appointment (ready to save to database)
                                    return array(
                                        'status'=>'success',
                                        'start_time'=>$start_time,
                                        'time_period'=>$time_period,
                                        'thisMin'=>$thisMin,
                                        'dayNO'=>$dayNO,
                                        'justDate'=>$justDate,
                                        'end_time'=>$end_time,
                                        );
                                }else{
                                    // Error
                                    return array('status'=>'error','error'=>_l("Not free",$this));
                                }
                            }else{
                                // Error
                                return array('status'=>'error','error'=>_l("Not true time #3",$this));
                            }
                        }else{
                            // Error
                            return array('status'=>'error','error'=>_l("Your request time was is not in right range! Please refresh your browser and try your request again.",$this));
                        }
                    }else{
                        // Error
                        return array('status'=>'error','error'=>_l("Not true time #1",$this));
                    }
                }else{
                    // Error
                    return array('status'=>'error','error'=>_l("Not true select",$this));
                }
            }else{
                // Error
                return array('status'=>'error','error'=>_l("Free date",$this));
            }
        /*}else{
            // Error
            return array('status'=>'error','error'=>_l("Sorry, you can not submit duplicate appointments.",$this));
        }*/
    }
    
//    Service detail pages without ajax  *(Not work yet)
    function serviceDetail($lang="en",$id)
    {
        $this->preset($lang);
        $this->data['data'] =  @reset($this->Appointment_model->getServiceDetail($id));
        if(!isset($this->data['data']["service_id"])){
            show_404();
        }
        $this->load->library('form_validation');
        if($this->input->input_stream('data')){
            $this->form_validation->set_rules('data[date]', _l('Date',$this), 'required|callback_formRulesDateFormat');
            $this->form_validation->set_rules('data[time]', _l('Time',$this), 'required|callback_regexMatch24Hours');
            $this->form_validation->set_rules('data[fname]', _l('First Name',$this), 'required|xss_clean|callback_formRulesName');
            $this->form_validation->set_rules('data[lname]', _l('Last Name',$this), 'required|xss_clean|callback_formRulesName');
            $this->form_validation->set_rules('data[email]', _l('Email Address',$this), 'required|valid_email');
            $this->form_validation->set_rules('data[tel]', _l('Phone Number',$this), 'required|is_natural');
            if ($this->form_validation->run() == FALSE){
                $this->session->set_flashdata('error_message', _l('Errors:',$this).validation_errors());
                redirect(base_url().$lang."/reservation/service/".$id);
            }else{
                $post_data = $this->input->post('data', TRUE);
                $intDate = strtotime($post_data["date"]);
                if($this->Appointment_model->checkFreeDate($intDate,$id) == 0){
                    $dayNO = date("N",$intDate)==7?0:date("N",$intDate);
                    $thisTime = explode(":",$post_data["time"]);
                    $thisMin = ((int) $thisTime[0] * 60) + (int) $thisTime[1];
                    $time_period =  @reset($this->Appointment_model->getTimePeriod($dayNO,$id,$thisMin));
                    if(isset($time_period["period_id"])){
                        if($thisMin>=$time_period["period_start_time"] && $thisMin<$time_period["period_end_time"]){
                            $checkMin = ($thisMin - $time_period["period_start_time"]) % $time_period["period_min"];
                            if($checkMin==0){
                                $justDate = $intDate;
                                $start_time = $intDate+($thisMin*60);
                                $end_time = $intDate+(($thisMin+$time_period["period_min"])*60);
                                if($start_time>time()){
                                    $existsReservationCount = $this->Appointment_model->checkReservation($id,$start_time,$end_time);
                                    if($time_period["max_count"]==0 || $existsReservationCount < $time_period["max_count"]){
//                                        Make Reservation number
                                        $reservationNumber = str_pad(($this->Appointment_model->countReservation($id,$start_time) + 1), strlen($time_period["max_count"]), '0', STR_PAD_LEFT);
                                        $reservationNumber = $thisMin.$reservationNumber;
                                        $new_reservation = array(
                                            "service_id"=>$id,
                                            "fname"=>$post_data["fname"],
                                            "lname"=>$post_data["lname"],
                                            "tel"=>$post_data["tel"],
                                            "email"=>$post_data["email"],
                                            "reservation_day_no"=>$dayNO,
                                            "reservation_date"=>$justDate,
                                            "reservation_date_time"=>$start_time,
                                            "reservation_edate_time"=>$end_time,
                                            "service_name"=>$this->data['data']["service_name"],
                                            "price"=>$this->data['data']["price"],
                                            "owner_user_id"=>$this->data['data']["user_id"],
                                            "reservation_number"=>$reservationNumber,
                                            "lang"=>$lang,
                                            "language_id"=>$_SESSION['language']['language_id']
                                        );
                                        $reservationID = $this->Appointment_model->addToReservation($new_reservation);
                                        $this->session->set_flashdata('success_message', _l('Reservation added',$this));
                                        redirect(base_url().$lang."/reservation/confirmation/".$reservationID);
                                    }else{
                                        $this->session->set_flashdata('error_message', _l('Not free',$this));
                                    }
                                }else{
                                    $this->session->set_flashdata('error_message', _l('Not true time #3',$this));
                                }
                            }else{
                                $this->session->set_flashdata('error_message', _l('Not true time #2',$this));
                            }
                        }else{
                            $this->session->set_flashdata('error_message', _l('Not true time #1',$this));
                        }
                    }else{
                        $this->session->set_flashdata('error_message', _l('Not true select',$this));
                    }
                }else{
                    $this->session->set_flashdata('error_message', _l('Free date',$this));
                }
                redirect(base_url().$lang."/reservation/service/".$id);
            }
        }

        $this->data['disable_dates'] = array();
        $free_days =  $this->Appointment_model->getAllFreeDays();
        foreach($free_days as $item){
            array_push($this->data['disable_dates'],date("Y-m-d",$item['free_date']));
        }
        $this->data['allow_days'] = array();
        for($i=0;$i<=6;$i++){
            $allow_days =  $this->Appointment_model->getTimePeriod($i,$id);
            if(count($allow_days)!=0){
                array_push($this->data['allow_days'],$i);
                foreach ($allow_days as $item) {
                    $candida = array();
                    $theTimes = array();
                    for($j=$item["period_start_time"];$j<$item["period_end_time"];$j+=$item["period_min"]){
                        array_push($theTimes,$j);
                    }
                    $maxCountInOnePeriod = ($item["period_end_time"]-$item["period_start_time"])/$item["period_min"];
                    $full_reservation =  $this->Appointment_model->checkFullReservationDate($id,$i,implode(",",$theTimes));
                    foreach($full_reservation as $itemReservation){
                        if($itemReservation["reservation_count"]>=$item["max_count"]){
                            if(!isset($candida[$itemReservation["reservation_date"]])){
                                $candida[$itemReservation["reservation_date"]] = 1;
                            }else{
                                $candida[$itemReservation["reservation_date"]]++;
                            }
                            if($candida[$itemReservation["reservation_date"]] == $maxCountInOnePeriod){
                                array_push($this->data['disable_dates'],date("Y-m-d",$itemReservation["reservation_date"]));
                            }
                        }
                    }
                }
            }
        }
        $this->data['disable_dates'] = json_encode($this->data['disable_dates']);
        $this->data['allow_days'] = json_encode($this->data['allow_days']);

//        $this->data['user_data']=$this->Nodcms_general_model->get_user_detail($this->data['data']["user_id"]);
        $extensions = $this->Nodcms_general_model->get_extension_detail(array('relation_id'=>$this->data['data']["service_id"],'data_type'=>'r_services'));
        if($extensions!=0){
            $this->data['extension_data'] = $extensions;
            $this->data['description'] = $extensions['description'];
            $this->data['keyword'] = $extensions['tag'];
            $this->data['title'] = ($extensions['name']!='')?$extensions['name']:$this->data['data']['service_name'];
        }else{
            $this->data['title']=$this->data['data']['service_name'];
        }
        $this->data['enable_languages'] = $this->Appointment_model->get_existed_services_language($this->data['data']["service_id"],array('languages.public'=>1));
        $this->data['content']=$this->load->view('reservation/service_detail',$this->data,true);
        $this->load->view('nodcms_general',$this->data);
    }

    // Confirmation booking after payment
    function reservationConfirmation($lang="en", $id)
    {
        $this->preset($lang);
        $this->data['data'] =  @reset($this->Appointment_model->getReservationDetail($id));
        if(!isset($this->data["data"]["reservation_id"])){
            show_404();
        }
        $service = $this->Appointment_model->getServiceDetail($this->data['data']['service_id']);
        if(count($service)!=0){
            $this->data['data']['price_show'] = $service[0]['price_show'];
        }else{
            $this->data['data']['price_show'] = 1;
        }
        $extensionService = $this->Appointment_model->getServiceExtensions($this->data['data']['service_id']);
        if(count($extensionService)!=0){
            $this->data['data']['service_name'] = $extensionService[0]['name'];
            $this->data['data']['service_description'] = $extensionService[0]['description'];
        }else{
            $this->data['data']['service_description'] = '<i class="fa fa-warning font-red"></i> '
                ._l('Description in this language is not set!', $this);
        }
        $this->data['title']=_l("Booking Confirmation",$this);
        $this->data['content']=$this->load->view('reservation/payment_confirmation',$this->data,true);
        $this->load->view($this->mainTemplate, $this->data);
    }

//    Get list of available times for services with ajax
    function getTime($lang="en",$service_id)
    {
        $this->preset($lang);
        $service=  @reset($this->Appointment_model->getServiceDetail($service_id));
        if(isset($service["service_id"]) && $this->input->input_stream('date')){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('date', _l('Date',$this), 'required|callback_formRulesDateFormat');
            if ($this->form_validation->run() != FALSE){
                $post_data = $this->input->post(NULL, TRUE);
                
                
                $day_no = date("N",strtotime($post_data["date"]))==7?0:date("N",strtotime($post_data["date"]));
                $time_period =  $this->Appointment_model->getTimePeriod($day_no,$service_id);
                //echo $time_period;
                //print_r($post_data['selected_times']);
                if(count($time_period)!=0){
                    $times = array();
                    foreach ($time_period as $item) {
                        for($i=$item["period_start_time"];$i<$item["period_end_time"];$i+=$item["period_min"]){
                            $start_time = strtotime($post_data["date"])+($i*60);
                            $end_time = strtotime($post_data["date"])+(($i+$item["period_min"])*60);
                            
                            //$timestamp = $i*60;

                            $start_time1 = date('H:i', $start_time);
                            //$start_time1 = date('H:i',strtotime($i*60));
                            
                            //$timestamp = $i+$item["period_min"]*60;

                            $end_time1 = date('H:i', $end_time);
                            //$end_time1 = strtotime($post_data["date"])+(($i+$item["period_min"])*60);
                            
                            $prev_start_time = array();
                            $prev_end_time = array();
                            if(isset($post_data['selected_times'])){
                                foreach($post_data['selected_times'] as $key => $value){
                                    if(!empty($value)){
                                        //$this_start_time = strtotime($post_data["date"].' '.$value);
                                        
                                        //$this_end_time = strtotime($post_data["date"].' '.$value." +".$post_data['selected_duration'][$key]." minutes");
                                        
                                        $this_start_time = $value;
                                        $timestamp = strtotime($value) + ($post_data['selected_duration'][$key]*60);

                                        $this_end_time = date('H:i', $timestamp);
                                        
                                        
                                        
                                        if(!in_array($this_start_time,$prev_start_time)){
                                            $prev_start_time[] = $this_start_time;
                                        }
                                        if(!in_array($this_end_time,$prev_end_time)){
                                            $prev_end_time[] = $this_end_time;
                                        }
                                        
                                        /*print_r('current:'.strtotime($post_data["date"].' '.$value));
                                        echo '<br />';*/
                                    }
                                }
                            
                            }
                            //print_r($prev_start_time);
                            //print_r($prev_end_time);
                            
                            
                            
                            //echo $start_time1.'<br />';
                            //echo $end_time1.'<br />';
                            /*print_r('start:'.$start_time.'');
                            echo '<br />';
                            print_r('end:'.$end_time);
                            echo '<br />';*/
                            /*print_r($prev_start_time);
                            echo '<br />';
                            print_r($prev_end_time);*/
                            
                            
                            if($item["max_count"]==0 || $this->Appointment_model->checkReservation($service_id,$start_time,$end_time) < $item["max_count"]){
                                if($this->Appointment_model->checkPrevReservation($start_time1,$end_time1,$prev_start_time,$prev_end_time) == 1){
                                    $h = floor($i/60);
                                    $h = strlen($h)==1?'0'.$h:$h;
                                    $m = ($i%60!=0)?($i-($h*60)):'00';
                                    array_push($times,$h.":".$m);
                                }
                            }
                        }
                    }
                    echo json_encode(array("status"=>"success","times"=>$times));
                }else{
                    echo json_encode(array("status"=>"error","error"=>_l("No Time!",$this)));
                }
            }else{
                echo json_encode(array("status"=>"error","error"=>validation_errors()));
            }
        }else{
            echo json_encode(array("status"=>"error","error"=>_l("Request was wrong!",$this)));
        }
    }

    // Contact us page
    function contact($lang="en")
    {
        $this->preset($lang);
        if($this->_website_info['contact_form']){
            $this->load->library('form_validation');
            if($this->input->input_stream("data")){
                $this->form_validation->set_rules('data[name]', _l('Name',$this), 'required|xss_clean|callback_formRulesName');
                $this->form_validation->set_rules('data[subject]', _l('Subject',$this), 'required|xss_clean');
                $this->form_validation->set_rules('data[email]', _l('Email Address',$this), 'required|valid_email');
                $this->form_validation->set_rules('data[text]', _l('Phone Number',$this), 'required|xss_clean');
                if ($this->form_validation->run() == FALSE){
                    $this->session->set_flashdata('error_message', _l('Errors:',$this).validation_errors());
                    redirect(base_url().$lang."/contact");
                }else{
                    $post_data = $this->input->post('data', TRUE);
                    $body_data = array(
                        "title"=>$post_data["name"],
                        "body"=>$post_data["text"]
                    );
                    $email_body = $this->load->view('nodcms_general/email-template-public',$body_data,true);
                    $this->sendEmailAutomatic($this->_website_info["email"], $this->_website_info['company'].' '._l("Contact Form",$this).": ".$post_data['subject'], $email_body, $post_data["email"]);
                    $this->session->set_flashdata('message_success', "Your request successfully sent!");
                }
                redirect(base_url().$lang."/contact");
            }
        }else{

        }
        $this->data['title'] = _l('Contact us', $this);
        $this->data['content'] = $this->load->view($this->mainTemplate.'/contact',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data,'');
    }

//    Validation time format function
    public function regexMatch24Hours($text)
    {
        if(preg_match('/^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/',$text)==true){
            return true;
        }else{
            $this->form_validation->set_message('regexMatch24Hours', 'The {field} field is not in the correct format.');
            return false;
        }
    }

//    Validation URL format function
    public function regexMatchUrl($text)
    {
        if(preg_match('/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i',$text)==true){
            return true;
        }else{
            $this->form_validation->set_message('regexMatchUrl', 'The {field} field is not in the correct format.');
            return false;
        }
    }

//    Validation date format function
    public function formRulesDateFormat($value)
    {
        $d1 = DateTime::createFromFormat("d.m.Y", $value);
        $d2 = DateTime::createFromFormat("m/d/Y", $value);
        $d3 = DateTime::createFromFormat("Y-m-d", $value);
        if($d1 && $d1->format("d.m.Y") == $value
            || $d2 && $d2->format("m/d/Y") == $value
            || $d3 && $d3->format("Y-m-d") == $value)
//        if(checkdate(substr($value, 3, 2), substr($value, 0, 2), substr($value, 6, 4))
//            || checkdate(substr($value, 0, 2), substr($value, 3, 2), substr($value, 6, 4))
//            || checkdate(substr($value, 6, 4), substr($value, 3, 2), substr($value, 0, 2)))
            return true;
        else{
            $this->form_validation->set_message('formRulesDateFormat', 'The {field} field value was not true. 1');
            return false;
        }
    }

//    Validation name format function
    public function formRulesName($value)
    {
        if (preg_match('/[\'\/~`\!@#\$£%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\0-9]/', $value) == true) {
            $this->form_validation->set_message('formRulesName', '{field} must contain letters and spaces only.');
            $errors[] = 'Name must contain letters and spaces only';
            return false;
        }else{
            return true;
        }
    }

/*
 * This validation functions will use automatically for extra fields,
     * that user set it.
 */
//    Validation number fields
    public function form_validation_number($value,$parameters)
    {
        $parameters = explode("|", $parameters);
        $min = $parameters[0];
        $max = $parameters[1];
        if(is_numeric($value) && (
            ($min>0 && $max>0 && $value>=$min && $value<=$max) ||
            ($min<=0 && $max>0 && $value<=$max) ||
            ($min>0 && $max<=0 && $value>=$min) ||
            ($min<=0 && $max<=0)
            )){
            return true;
        }else{
            $this->form_validation->set_message('form_validation_number', 'The {field} field value was not true.');
            return false;
        }
    }

//    Validation alphanumeric fields
    public function form_validation_alphanumeric($value,$parameters)
    {
        $parameters = explode("|", $parameters);
        $min = $parameters[0];
        $max = $parameters[1];
        if(
            ($min>0 && $max>0 && strlen($value)>=$min && strlen($value)<=$max) ||
            ($min<=0 && $max>0 && strlen($value)<=$max) ||
            ($min>0 && $max<=0 && strlen($value)>=$min) ||
            ($min<=0 && $max<=0)
            ){
            return true;
        }else{
            $this->form_validation->set_message('form_validation_number', 'The {field} field value was not true.');
            return false;
        }
    }

//    Validation normal text fields
    public function form_validation_text($value,$parameters){
        $parameters = explode("|", $parameters);
        $min = $parameters[0];
        $max = $parameters[1];
        if(
            $value==strip_tags($value) &&
            (($min>0 && $max>0 && strlen($value)>=$min && strlen($value)<=$max) ||
            ($min<=0 && $max>0 && strlen($value)<=$max) ||
            ($min>0 && $max<=0 && strlen($value)>=$min) ||
            ($min<=0 && $max<=0)
            )){
            return true;
        }else{
            $this->form_validation->set_message('form_validation_number', 'The {field} field value was not true.');
            return false;
        }
    }

//    Validation for textarea fields
    public function form_validation_textarea($value,$parameters){
        $parameters = explode("|", $parameters);
        $min = $parameters[0];
        $max = $parameters[1];
        if(
            ($min>0 && $max>0 && strlen($value)>=$min && strlen($value)<=$max) ||
            ($min<=0 && $max>0 && strlen($value)<=$max) ||
            ($min>0 && $max<=0 && strlen($value)>=$min) ||
            ($min<=0 && $max<=0)
            ){
            return true;
        }else{
            $this->form_validation->set_message('form_validation_number', 'The {field} field value was not true.');
            return false;
        }
    }

    // Validation for checkbox fields
    public function form_validation_checkbox($value,$parameters)
    {
        return true;
    }

    // Validation for url fields
    public function form_validation_url($value,$parameters)
    {
        return $this->regexMatchUrl($value);
    }

    // Validation for color fields
    public function form_validation_color($value,$parameters=null)
    {
        if(preg_grep('/#([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?\b/', $value)){
            return TRUE;
        }else{
            $this->form_validation->set_message('form_validation_color', '{field} should be color Hex code.');
            return FALSE;
        }
    }

    // Add on configuration for page navigation
    private function mkPagination($config)
    {
        $config["full_tag_open"] = "<nav class='text-center'><ul class='pagination pagination-sm'>";
        $config["full_tag_close"] = "</ul></nav>";
        $config["first_tag_open"] = $config["last_tag_open"] = $config["next_tag_open"] = $config["prev_tag_open"] = $config["num_tag_open"] = "<li>";
        $config["first_tag_close"] = $config["last_tag_close"] = $config["next_tag_close"] = $config["prev_tag_close"] = $config["num_tag_close"] = "</li>";
        $config["first_link"] = _l("First",$this);
        $config["last_link"] = _l("Last",$this);
        $config["prev_link"] = "<span aria-hidden='TRUE'>&laquo;</span>";
        $config["next_link"] = "<span aria-hidden='TRUE'>&raquo;</span>";
        $config["cur_tag_open"] = "<li class='active'><span>";
        $config["cur_tag_close"] = "<span class='sr-only'>(current)</span></span></li>";
        $config['use_page_numbers']  = TRUE;
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
    }
	
	public function saveRating(){
	
		if($this->input->post()){
			$a = array_filter($this->input->post('rating'));
			$average = array_sum($a)/count($a);
			
			$ratingAvg = $average;
			$reservationId = $this->input->post('reservation_id');
			$comment = $this->input->post('comments');
			
			$data = array(
				'reservation_id' => $reservationId,
				'ratings' => $ratingAvg,
				'comment' => $comment,
				'commenter' => $this->session->userdata('fullname'),
				'date_comment' => date("Y-m-d"),
				'provider_id' => $this->input->post('provider_id'),
				'status' => 1
			);	
		
			$this->db->insert('r_reviews',$data);
			
			echo $this->db->insert_id();
		}
		
	}
	
	public function updateReviewReplay(){
		
		if($this->input->post()){
			$replay = $this->input->post("comment_replay");
			$id = $this->input->post("review_id");
			$update_data = array("comment_replay"=>$replay);
			$conditions = array("id"=>$id);
			$this->db->update("r_reviews", $update_data, $conditions);
		}
		
	}
	

	public function getTreatments(){

        $this->db->select("*");
        $this->db->from("subcategory");
        $query = $this->db->get();
        return $query->result_array();

    }


	
}