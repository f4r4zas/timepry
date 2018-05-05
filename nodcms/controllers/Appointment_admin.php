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
class Appointment_admin extends NodCMS_Controller
{
    private $provider_group = 0;
    function __construct(){


        // load construct with backend prepared function
        parent::__construct('backend');
        if($this->session->userdata('group') == 20){
            $this->reservationPatientPermission();
        }

        // Stable Dental Office menu for single provider users
        if($this->_website_info["appointment_multiowner"] != 1
            && !$this->session->has_userdata("provider_id")
            && in_array($this->session->userdata("group"), array(1, 100))){
            $default_provider = $this->Appointment_admin_model->getProvider(array("default"=>1));
            if(count($default_provider)!=0){
                $this->session->set_userdata('provider_id',$default_provider[0]["provider_id"]);
                $this->session->set_userdata('provider_name',$default_provider[0]["provider_name"]);

                redirect(APPOINTMENT_ADMIN_URL."dashboard");
            }
        }

        /*
         * # Important: This part set user access
         *   1. Check admin access to manage managers
         *   2. Change Panel design and menu for 3 user type:
         *      I.   admin
         *      II.  assistant
         *      III. staff
         */
        $this->data['justOneDentalOffice'] = FALSE;
        $adminPages = array(
            'providers',
            'providerEdit',
            'providerManipulate',
            'makeProviderDefault',
            'providerRemove',
            'getUsername',
            'getEmail',
            'providerManager',
            'providerManagerRemove',
            'settings',
        );

        if($this->session->userdata('group') != 1 && $this->session->userdata('group') != 100){
            $this->frameTemplate .= '_staff';
        }

        //$this->accountSetting();

        if(!in_array($this->router->fetch_method(), array('index', 'accountSettings'))){



            // Check admin access pages
            if(!in_array($this->session->userdata('group'), array(1, 100)) || !in_array($this->router->fetch_method(), $adminPages)){
                // Check Selected a provider


                if(!$this->session->has_userdata('provider_id')){
                        //die();
                        //redirect(APPOINTMENT_ADMIN_URL);
                        //Normal user requesting edit option

                }
                $provider_id = $this->session->userdata('provider_id');

                if($this->session->userdata('group') == 20){
                    $this->provider_group = 20;
                }


                if($this->session->userdata('group_id')!=1 && $this->session->userdata('group_id')!=100){
                    $where = NULL;
                }else{
                    $where = array('active'=>1);
                }
                $provider = $this->Appointment_admin_model->getProviderById($provider_id, $where);
                if(count($provider)!=0 || $this->session->userdata('group')==20) {
                    $provider = reset($provider);
                    $this->provider = $provider;
                    // Get provider manager from DB
                    $where = array('r_provider_admins.user_id' => $this->session->userdata('user_id'));
                    $providerManager = $this->Appointment_admin_model->getProviderManagerById($provider_id, $where);
                    // Check admin access
                    if (count($providerManager) == 0 && in_array($this->session->userdata('group'), array(1, 100))) {
                        // Set a message for admin
                        $this->data['admin_permission_warning'] = _l('This provider is not yours. You have access it because your account is admin.', $this);
                        // Set admin permissions
                        $this->provider_group = 1;
                        // Check no access
                    }elseif(count($providerManager)==0){
                        //$this->session->set_flashdata('error', _l('Your request was wrong!', $this));
                        //redirect(APPOINTMENT_ADMIN_URL);
                        // Normal access
                    }else{
                        if($this->session->userdata('group')==1 && $providerManager[0]['group_id']!=1){
                            $this->data['admin_permission_warning']= _l("Your permission type", $this).': <strong>'.$providerManager[0]['group_name'].'</strong>.';
                            $this->data['admin_permission_warning'].= ' '._l('You have access to all part of this provider because your account is admin.', $this);
                            $this->provider_group = 1;
                        }else{
                            $myProvider = $this->Appointment_admin_model->getProviderManagers(NULL, $where);
                            if(count($myProvider)==1){
                                $this->data['justOneDentalOffice'] = TRUE;
                            }
                            $this->provider_group = $providerManager[0]['group_id'];

                        }
                    }
                    $this->data['provider_data'] = $provider;
                    // Check user access

                    if($this->provider_group==21) {
                        $this->reservationStaffPermission();
                    }elseif($this->provider_group==22) {
                        $this->reservationAssistantPermission();
                    }elseif($this->provider_group == 1) {
                        $this->reservationAdminPermission();
                    }elseif($this->provider_group==20){
                        $this->reservationPatientPermission();
                    }
                    else
                    {
                        echo $this->provider_group; exit;
                    }

                }else{
                    $this->session->set_flashdata('error', _l('Please choose a provider!', $this));
                    redirect(APPOINTMENT_ADMIN_URL);
                }
            }
        }
    }

    // Add on configuration for page navigation
    private function mkPagination($config)
    {
        $this->load->library('pagination');
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


    function getEmail(){
        if($this->input->input_stream('text')){
            $text = $this->input->post('text',TRUE);
            if (preg_match('/^[a-z0-9_]{1,18}$/', $text) != FALSE) {
                $result = $this->Appointment_admin_model->getEmail("email LIKE '$text%'");
            }else{
                $result = array();
            }
            echo json_encode(array('status'=>'success', 'data'=>$result));
        }else{
            echo json_encode(array('status'=>'error', 'error'=>'Not Set'));
        }
    }

    function getUsername(){
        if($this->input->input_stream('text')){
            $text = $this->input->post('text',TRUE);
            if (preg_match('/^[a-z0-9_]{1,18}$/', $text) != FALSE) {
                $result = $this->Appointment_admin_model->getUsername("username LIKE '$text%'");
            }else{
                $result = array();
            }
            echo json_encode(array('status'=>'success', 'data'=>$result));
        }else{
            echo json_encode(array('status'=>'error', 'error'=>'Not Set'));
        }
    }

    // Admin Homepage (Choose a provider)
    function index($id=NULL)
    {
        if($id!=NULL){

            if($this->session->userdata('group_id')!=1 && $this->session->userdata('group_id')!=100){
                $where = NULL;
            }else{
                $where = array('active'=>1);
            }
            $provider = $this->Appointment_admin_model->getProviderById($id, $where);
            if(count($provider)!=0){
                // Get provider manager from DB
                $where = array('user_id'=>$this->session->userdata('user_id'));
                $providerManager = $this->Appointment_admin_model->getProviderManagerById($id, $where);
                if(count($providerManager)!=0 ||
                    (count($providerManager)==0 && in_array($this->session->userdata('group'), array(1, 100)))){
                    // Set provider_id
                    $this->session->set_userdata('provider_id',$id);
                    $this->session->set_userdata('provider_name',$provider[0]["provider_name"]);
                    redirect(APPOINTMENT_ADMIN_URL.'dashboard');
                }else{
                    $this->session->set_flashdata('error', _l("Your don't have any access to this provider!", $this));
                    redirect(APPOINTMENT_ADMIN_URL);
                }
            }else{
                $this->session->set_flashdata('error', _l('Your request was wrong!', $this));
                redirect(APPOINTMENT_ADMIN_URL);
            }
        }
        $this->data['title']=_l("Home",$this);
        $this->data['sub_title']=_l("Dental Offices",$this);
        $this->data['page']='home';
        if($this->session->userdata('group') == 1 || $this->session->userdata('group') == 100){
            // # Admin Home
            $this->data['auto_emails'] = $this->config->item('autoEmailMessages');
            $languages = $this->Nodcms_admin_model->get_all_language();
            $fail_auto_messages = array();
            foreach($this->data['auto_emails'] as $key=>$val){
                // Values of $val are in config/nodcms.php
                foreach($languages as $lang_item){
                    $autoMsgData = $this->Nodcms_admin_model->get_all_auto_messages($key, array('language_id'=>$lang_item['language_id']));
                    if(count($autoMsgData)==0 || $autoMsgData[0]['subject']=='' || $autoMsgData[0]['content']==''){
                        array_push($fail_auto_messages, array('language'=>$lang_item, 'message'=>$val));
                    }
                }
            }
            $this->data['fail_auto_messages'] = $fail_auto_messages;
            // Last Users
            $this->data['users'] = $this->Appointment_admin_model->getAllUserByType(5, 0);
            // Last Dentists
            $this->data['dentists'] = $this->Appointment_admin_model->getAllUserByType(5, 0, 21);
            // Dental Offices List
            $this->data['providers'] = $this->Appointment_admin_model->getProvider(NULL, 5, 0);
            foreach($this->data['providers'] as &$item){
                $managerGroup = $this->Appointment_admin_model->getProviderManagerById($item['provider_id'], array('user_id'=>$this->session->userdata('user_id')));
                if(count($managerGroup)!=0){
                    $item['group_name'] = $managerGroup[0]['group_name'];
                }else{
                    $item['group_name'] = '-';
                }
            }
            $loadPage = "home";
        }else{
            // # Users Home
            $where = array('r_provider_admins.user_id'=>$this->session->userdata('user_id'));
            $this->data['data'] = $this->Appointment_admin_model->getProviderManagers(NULL, $where);

            //print_r(count($this->data['data']));

            if(count($this->data['data']) != 0){
                if(count($this->data['data'])==1){
                    redirect(APPOINTMENT_ADMIN_URL.'index/'.$this->data['data'][0]['provider_id']);
                }
                $loadPage = "appointment_home";
            } else if($this->input->get("showOption")){
                $loadPage = "appointment_home";
            }else {
				$this->data['reviewed'] = $this->Appointment_admin_model->getReviewed();
                $loadPage = "user_dashboard";
            }
        }


        //print_r($loadPage);

        $this->data['content']=$this->load->view($this->mainTemplate."/appointment/".$loadPage,$this->data,TRUE);

        $this->loadView();
    }

    // Dental Offices list page
    function providers($page = 1)
    {
        $config = array();
        $config['base_url'] = APPOINTMENT_ADMIN_URL.'providers';
        $config['query_string_segment'] = '';
        $config['reuse_query_string'] = TRUE;
        $config['total_rows'] = count($this->Appointment_admin_model->getProvider());
        $config['uri_segment'] = 4;
        $config['per_page'] = 10;
        $this->mkPagination($config);
        $page--;

        $this->data['data'] = $this->Appointment_admin_model->getProvider(NULL, $config['per_page'], $page*$config['per_page']);
        foreach($this->data['data'] as &$item){
            $managerGroup = $this->Appointment_admin_model->getProviderManagerById($item['provider_id'], array('user_id'=>$this->session->userdata('user_id')));
            if(count($managerGroup)!=0){
                $item['group_name'] = $managerGroup[0]['group_name'];
            }else{
                $item['group_name'] = '-';
            }
        }
        $this->data['title'] = _l('Dental Offices', $this);
        $this->data['page'] = 'providers';
        $this->data['content']=$this->load->view($this->mainTemplate."/appointment/providers",$this->data,TRUE);
        $this->loadView();
    }

    // Dental Office add/edit form
    function providerEdit($id=null)
    {
        if($id!=null){
            $this->data['data'] = @reset($this->Appointment_admin_model->getProviderDetail($id));
            if($this->data['data']==null)
                redirect(APPOINTMENT_ADMIN_URL.'providers');
            $this->data['sub_title'] = _l("Edit a provider",$this);
            $extensions = array();
            $data_extensions = $this->Nodcms_admin_model->get_all_extension("r_providers",$id);
            if(count($data_extensions)!=0){
                foreach ($data_extensions as $value) {
                    $extensions[$value["language_id"]] = $value;
                }
            }
            $this->data['extensions'] = $extensions;
        }else{
            $this->data['sub_title'] = _l("Add a new provider",$this);
        }
        // Default payment type (service type)
        $this->data["payment_type"] = array(array("code"=>0, "name"=>_l("No need to online payment", $this)));
        // Add to more payment type (service type) if PayPal add-on is active
        if($this->paypal_addon){
            array_push($this->data["payment_type"], array("code"=>1, "name"=>_l("Online payment required", $this)));
            array_push($this->data["payment_type"], array("code"=>2, "name"=>_l("Online payment optional", $this)));
        }

        $this->data['languages'] = $this->Nodcms_admin_model->get_all_language();
        $this->data['title'] = _l("providers",$this);
        $this->data['breadcrumb']=array(
            array('title'=>_l("My Dental Office", $this), 'url'=>APPOINTMENT_ADMIN_URL.'providers'),
            array('title'=>"Details")
        );
        $this->data['page'] = "provider";
        $this->data['content']=$this->load->view($this->mainTemplate.'/appointment/provider_edit',$this->data,TRUE);
        $this->loadView();
    }

    // Dental Office managers edit page
    function providerManager($id)
    {
        $provider = $this->Appointment_admin_model->getProvider(array('provider_id'=>$id));
        //print_r($provider);
        if(count($provider)!=0){
            if($this->input->raw_input_stream){
                if (in_array($this->session->userdata['group'], array(1, 20, 21))) {
                    $this->load->library('form_validation');
                    $this->form_validation->set_rules('email', _l('email',$this), 'required|callback_validateUserEmail');
                    $this->form_validation->set_rules('group', _l('Group',$this), 'required|is_natural');
                    if ($this->form_validation->run() != TRUE){
                        $this->session->set_flashdata('static_error', validation_errors());
                    }else{
                        $username = $this->input->post("email",TRUE);
                        $group = $this->input->post("group",TRUE);
                        $user = $this->Appointment_admin_model->getUserByEmail($username);
                        if(count($user) != 0){
                            $provider_manager = $this->Appointment_admin_model->getProviderManagers($id, array('r_provider_admins.user_id'=>$user[0]['user_id']));
                            if(count($provider_manager)==0){
                                $this->Appointment_admin_model->addUserManager($id, $user[0]['user_id'], $group);
                                $this->session->set_flashdata('success', _l('New manager added!', $this));
                            }else{
                                $this->session->set_flashdata('static_error', _l("This user is already one of this provider manager!",$this));
                            }
                        }else{
                            $this->session->set_flashdata('static_error', _l("Username isn't exists!",$this));
                        }
                    }
                    if($this->router->fetch_method() == "providerManager")
                        redirect(APPOINTMENT_ADMIN_URL.'providerManager/'.$id);
                    else
                        redirect(APPOINTMENT_ADMIN_URL.'myProviderManager/');
                }else{
                    $this->session->set_flashdata('error', _l("Unfortunately you do not have permission to this part of system.",$this));
                }
                $this->data["provider_data"] = $provider;
            }
            $this->data['groups'] = $this->Appointment_admin_model->getManagersGroups();
            $this->data['data'] = $this->Appointment_admin_model->getProviderManagers($id);
            $this->data['title'] = _l("Members",$this);
            $this->data['sub_title'] = _l("Managers",$this);
            $this->data['breadcrumb']=array(
                array('title'=>$provider[0]['provider_name']),
                array('title'=>$this->data['sub_title'])
            );
            $this->data['page'] = "provider_manager";
            $this->data['content'] = $this->load->view($this->mainTemplate.'/appointment/provider_manager',$this->data,TRUE);
            $this->loadView();
        }
    }

    // Edit users notifications
    function providerManagerNotificationEmail($provider_id){
        if($this->input->raw_input_stream){
            $this->load->library('form_validation');
//            $this->form_validation->set_rules('provider_id', _l('Dental Office data',$this), 'required|is_natural');
            $this->form_validation->set_rules('user_id', _l('User data',$this), 'required|is_natural');
            $this->form_validation->set_rules('notification_email', _l('Notification status',$this), 'required|in_list[0,1]');
            if ($this->form_validation->run() != TRUE){
                $result = array("status"=>"error","error"=>validation_errors(),"static_error");
            }else{
//                $provider_id = $this->input->post("provider_id", TRUE);
                $user_id = $this->input->post("user_id", TRUE);
                $notification = $this->input->post("notification_email", TRUE);
                $this->Appointment_admin_model->updateProviderManagerNotificationEmail($provider_id, $user_id, $notification);
                $result = array("status"=>"success");
            }
        }else{
            $result = array("status"=>"error","error"=>_l("Your request was wrong!",$this));
        }
        echo json_encode($result);
    }

    function myProviderManagerNotificationEmail(){
        $this->providerManagerNotificationEmail($this->session->userdata('provider_id'));
    }

    // Extra-Fields add/edit action
    function providerManipulate($id = null)
    {
        // Check admin permissions
        if (in_array($this->session->userdata['group'], array(1, 20,21 ))) {
            if($this->input->raw_input_stream){
                $this->load->library('form_validation');
                $this->form_validation->set_rules('data[provider_name]', _l('Dental Office Name',$this), 'required');
                $this->form_validation->set_rules('data[provider_username]', _l('Dental Office Unique Name',$this), 'required|callback_validateProviderUsername['.$id.']');
                if ($this->form_validation->run() != TRUE){
                    $result = array("status"=>"error","error"=>validation_errors(),"static_error");
                }else{
                    $setData = $this->input->post("data",TRUE);
                    if($this->input->input_stream('extensions'))
                        $extensions = $this->input->post("extensions",TRUE);
                    else
                        $extensions = NULL;
//                    if($setData["paypal_user_id"] == '') unset($setData["paypal_user_id"]);
//                    if($setData["paypal_password"] == '') unset($setData["paypal_password"]);
//                    if($setData["paypal_signature"] == '') unset($setData["paypal_signature"]);

                    $new_id = $this->Appointment_admin_model->providerManipulate($setData,$id,$extensions);
                    $result = array("status"=>"success","id",$new_id);
                }
            }else{
                $result = array("status"=>"error","error"=>_l("Your request was wrong!",$this));
            }
            if($this->input->is_ajax_request()){
                echo json_encode($result);
            }else{
                if($result["status"]=="success"){
                    $this->session->set_flashdata('success', _l('Your update successfully done!',$this));
                }else{
                    if(in_array('static_error',$result)) {
                        $this->session->set_flashdata('static_error', $result["error"]);
                        if($this->router->fetch_method() == "providerManipulate")
                            redirect(APPOINTMENT_ADMIN_URL.'providerEdit'.($id != NULL ? '/'.$id : ''));
                        else
                            redirect(APPOINTMENT_ADMIN_URL.'myProviderEdit');
                    }else{
                        $this->session->set_flashdata('error', $result["error"]);
                    }
                }
                if($this->router->fetch_method() == "providerManipulate")
                    redirect(APPOINTMENT_ADMIN_URL.'providers');
                else
                    redirect(APPOINTMENT_ADMIN_URL.'myProviderEdit');
            }
        }else{
            $this->session->set_flashdata('error', _l("Unfortunately you do not have permission to this part of system.",$this));
        }
        redirect(APPOINTMENT_ADMIN_URL.'providers');
    }

    // Make a default provider
    function makeProviderDefault($id)
    {
        // Check admin(group_id = 1) access
        if (in_array($this->session->userdata['group'],array(1))) {
            $data = $this->Appointment_admin_model->getProviderDetail($id);
            if(count($data)!=0){
                $this->Appointment_admin_model->resetProviderDefault($id);
                $this->session->set_flashdata('success', _l('Your default provider was selected!',$this));
            }else{
                $this->session->set_flashdata('error', _l("Your request was wrong!",$this));
            }
        }else{
            $this->session->set_flashdata('error', _l("Unfortunately you do not have permission to this part of system.",$this));
        }
        redirect(APPOINTMENT_ADMIN_URL);
    }

    // Dental Offices remove action
    function providerManagerRemove($id, $user_id)
    {
        // Check admin(group_id = 1) access
        if (in_array($this->session->userdata['group'],array(1, 20,21))) {
            $data = $this->Appointment_admin_model->getProviderManagerById($id);
            if(count($data)!=0){
                $this->Appointment_admin_model->providerManagerRemove($id, $user_id);
                $this->session->set_flashdata('success', _l('Deleted from provider manager!',$this));
            }else{
                $this->session->set_flashdata('error', _l("Your request was wrong!",$this));
            }
        }else{
            $this->session->set_flashdata('error', _l("Unfortunately you do not have permission to this part of system.",$this));
        }
        if($this->router->fetch_method() == "providerManagerRemove")
            redirect(APPOINTMENT_ADMIN_URL."providerManager/".$id);
        else
            redirect(APPOINTMENT_ADMIN_URL."myProviderManager");
    }

    // Dental Offices remove action
    function providerRemove($id)
    {
        // Check admin(group_id = 1) access
        if (in_array($this->session->userdata['group'],array(1))) {
            $provider = $this->Appointment_admin_model->getProviderById($id);
            if(count($provider)!=0){
                $this->Appointment_admin_model->providerRemove($id);
                $this->session->set_flashdata('success', _l('Deleted from providers!',$this));
            }else{
                $this->session->set_flashdata('error', _l("Your request was wrong!",$this));
            }
        }else{
            $this->session->set_flashdata('error', _l("Unfortunately you do not have permission to this part of system.",$this));
        }
        redirect(APPOINTMENT_ADMIN_URL);
    }

    // Dental Office manager for provider admin
    function myProviderEdit(){
        $this->data['post_method']='myProviderEdit/';
        if($this->input->raw_input_stream){
            if (in_array($this->session->userdata['group'],array(1, 20,21))) {
                $setData = $this->input->post("data",TRUE);
                $extensions = $this->input->post("extensions",TRUE);
                if($this->session->userdata('group')!=1){
                    $accepted_data = array(
                        'provider_name',
                        'provider_username',
                        'phone',
                        'address',
                        'payment_type',
                    );
                    foreach ($setData as $key=>$item) {
                        if(!in_array($key, $accepted_data)){
                            unset($_POST['data'][$key]);
                        }
                    }
                    foreach ($extensions as $k=>$ext) {
                        $accepted_data = array('name', 'full_description');
                        foreach($ext as $key=>$item){
                            if(!in_array($key, $accepted_data)){
                                unset($_POST['extensions'][$k][$key]);
                            }
                        }
                    }
                }
                $this->providerManipulate($this->session->userdata('provider_id'));
            }else{
                $this->session->set_flashdata('error', _l("Unfortunately you do not have permission to this part of system.",$this));
            }
        }
        $this->providerEdit($this->session->userdata('provider_id'));
    }

    // Dental Office manager for provider admin
    function myProviderManager(){
        $this->data['local_link'] = TRUE;
        $this->providerManager($this->session->userdata('provider_id'));
    }

    // Remove provider action for provider admin
    function myProviderManagerRemove($id){
        $this->providerManagerRemove($this->session->userdata('provider_id'), $id);
    }

    // Appointment system dashboard
    function dashboard()
    {
        $_SESSION["back_redirect"]=APPOINTMENT_ADMIN_URL;
        $this->data["meeting_point"]=array();
        $services = $this->Appointment_admin_model->getAllServices();
        for($i=0;$i<12;$i++){
            $minDate = mktime(0, 0, 0, (date('m') + $i), 1, date('Y'));
            $maxDate = mktime(0, 0, 0, (date('m') + $i) + 1, 1, date('Y'));
            $this->data["meeting_point"][$minDate]=array();
            foreach ($services as $item) {
                $conditions = array('service_id'=>$item['service_id']);
                $data = $this->Appointment_admin_model->countReservation('reservation_date', $conditions, $minDate, $maxDate);
                $this->data["meeting_point"][$minDate]["lbl".$item['service_id']] = $data;
            }
        }
        $this->data['keys']=array();
        $this->data['labels']=array();
        foreach($services as $item){
            array_push($this->data['keys'],'lbl'.$item['service_id']);
            array_push($this->data['labels'],$item['service_name']);
        }
        $this->data['keys'] = json_encode($this->data['keys']);
        $this->data['labels'] = json_encode($this->data['labels']);
        $this->data["reservations"] = $this->Appointment_admin_model->statisticsReservation();
        // Count of requests of today
        $conditions = array('reservation_date'=>mktime(0,0,0,date('m'),date('d'),date('Y')),'closed'=>0,'trash'=>0);
        $this->data["today_reservation_count"] = $this->Appointment_admin_model->countReservation('reservation_date', $conditions);
        // Count of new requests
        $conditions = array('closed'=>0,'trash'=>0);
        $mkTime = mktime(0,0,0,date('m'),date('d'),date('Y'));
        $this->data["new_reservation_count"] = $this->Appointment_admin_model->countReservation('reservation_date', $conditions, $mkTime);
        // Count of all requests
        $this->data["reservation_count"] = $this->Appointment_admin_model->countReservation('created_date');
        // Count of closed requests
        $conditions = array('closed'=>1, 'trash'=>0);
        $this->data["closed_reservation_count"] = $this->Appointment_admin_model->countReservation('created_date', $conditions);
        // Count of removed requests
        $conditions = array('trash'=>1);
        $this->data["removed_reservation_count"] = $this->Appointment_admin_model->countReservation('created_date', $conditions);
        // Count of tomorrow's requests
        $conditions = array('reservation_date'=>mktime(0,0,0,date('m'),(date('d')+1)), 'closed'=>0, 'reminded'=>0);
        $this->data["tomorrow_reservation_count"] = count($this->Appointment_admin_model->getReservation(NULL, NULL, $conditions));
        // Count of services
        $this->data["services_count"] = count($this->Appointment_admin_model->getAllServices($this->session->userdata('provider_id')));
        $this->data["languages"] = $this->Nodcms_admin_model->get_all_language('public = 1');
        $this->data['title']=_l("Dashboard",$this);
        $this->data['page']='dashboard';
        $this->data['content']=$this->load->view($this->mainTemplate."/appointment/dashboard",$this->data,TRUE);
        $this->loadView();
    }

	function treatment(){
		$provider_id = $this->session->userdata("provider_id");
		$all_treatments =  $this->Appointment_admin_model->getAllTreatment($provider_id);

		$_SESSION["back_redirect"]=APPOINTMENT_ADMIN_URL."treatment";
        $days = array(
            _l('Sun',$this),
            _l('Mon',$this),
            _l('Tue',$this),
            _l('Wed',$this),
            _l('Thu',$this),
            _l('Fri',$this),
            _l('Sat',$this)
        );

		$this->data['data'] = $all_treatments;

		/* foreach($this->data['data'] as &$item){
            $item['languages'] = $this->Appointment_admin_model->getExistedServicesLanguage($item['service_id']);
            $item['work_times'] = array();
            for($i=0;$i<6;$i++){
                if(count($this->Appointment_admin_model->getAllPeriods($item['service_id'], $i))!=0){
                    array_push($item['work_times'], $days[$i]);
                }
            }
        } */

        $this->data['title']=_l("All Treatment",$this);

        $this->data['sub_title']=_l("Treatments list",$this);
        $this->data['breadcrumb']=array(
            array('title'=>$this->data['sub_title'])
        );
        $this->data['page']='treatment';
        $this->data['content']=$this->load->view($this->mainTemplate."/appointment/".$this->data['page'],$this->data,TRUE);


        $this->loadView();
	}

	 function treatmentEdit($id=null)
    {
        if($id!=null){
            $this->data['data'] =  $this->Appointment_admin_model->getSingleTreatment($id);
            if(count($this->data['data'])!=0){
                $this->data['data'] = reset($this->data['data']);
            }else{
                $this->session->set_flashdata('error', _l('Your request was wrong!', $this));
                redirect(APPOINTMENT_ADMIN_URL.'services');
            }
            $extensions = array();
            $data_extensions = $this->Nodcms_admin_model->get_all_extension("r_services",$id);
            if(count($data_extensions)!=0){
                foreach ($data_extensions as $value) {
                    $extensions[$value["language_id"]] = $value;
                }
            }
            $this->data['extensions'] = $extensions;
            if($this->input->is_ajax_request()){
                if(!isset($this->data['data']["service_id"])){
                    echo json_encode(array("status"=>"error","error"=>_l("Your request was wrong!",$this)));
                }else{
                    $data = array(
                        "name"=>$this->data['data']["service_name"],
                        "price"=>$this->data['data']["price"],
                        "description"=>$this->data['data']["service_description"]
                    );
                    echo json_encode(array("status"=>"success", "data"=>$data));
                }
                exit;
            }
            $this->data['sub_title']=_l("Edit a Treatment ",$this);
        }else{
            $this->data['sub_title']=_l("Add new service",$this);
            if($this->input->is_ajax_request()){
                echo json_encode(array("status"=>"error","error"=>_l("Your request was wrong!",$this)));
                exit;
            }
        }
        $this->data['languages'] = $this->Nodcms_admin_model->get_all_language();
        $this->data['title']=_l("Treatments",$this);
        $this->data['breadcrumb']=array(
            array('title'=>_l('Treatment',$this),'url'=>APPOINTMENT_ADMIN_URL.'treatment'),
            array('title'=>$this->data['sub_title'])
        );
        $this->data['page']='treatment_edit';
        $this->data['content']=$this->load->view($this->mainTemplate."/appointment/".$this->data['page'],$this->data,TRUE);
        $this->loadView();
    }

	function treatmentUpdate(){

		if($this->input->post()){
			if($this->Appointment_admin_model->updateTreatment($this->input->post(),$this->input->post('id'))){
				  $this->session->set_flashdata('success', _l('Treatment updated successfully!',$this));
				 redirect(APPOINTMENT_ADMIN_URL.'treatment');
			}else{
				 $this->session->set_flashdata('error', _l('Your request was wrong!', $this));
				 redirect(APPOINTMENT_ADMIN_URL.'treatment');
			}
		}else{
			redirect(APPOINTMENT_ADMIN_URL.'treatment');
		}


	}

	function treatmentRemove($id){
			if($id){
				if($this->Appointment_admin_model->treatmentRemove($id)){
				  $this->session->set_flashdata('success', _l('Removed updated successfully!',$this));
				 redirect(APPOINTMENT_ADMIN_URL.'treatment');
				}else{
					 $this->session->set_flashdata('error', _l('Your request was wrong!', $this));
					 redirect(APPOINTMENT_ADMIN_URL.'treatment');
				}
			}else{
				redirect(APPOINTMENT_ADMIN_URL.'treatment');
			}
	}

    // Services list
    function services()
    {
        $_SESSION["back_redirect"]=APPOINTMENT_ADMIN_URL."services";
        $days = array(
            _l('Sun',$this),
            _l('Mon',$this),
            _l('Tue',$this),
            _l('Wed',$this),
            _l('Thu',$this),
            _l('Fri',$this),
            _l('Sat',$this)
        );
        $this->data['data'] =  $this->Appointment_admin_model->getAllServices();
        foreach($this->data['data'] as &$item){
            $item['languages'] = $this->Appointment_admin_model->getExistedServicesLanguage($item['service_id']);
            $item['work_times'] = array();
            for($i=0;$i<6;$i++){
                if(count($this->Appointment_admin_model->getAllPeriods($item['service_id'], $i))!=0){
                    array_push($item['work_times'], $days[$i]);
                }
            }
        }
        $this->data['title']=_l("Practitioners",$this);
        $this->data['sub_title']=_l("Practitioners list",$this);
        $this->data['breadcrumb']=array(
            array('title'=>$this->data['sub_title'])
        );
        $this->data['page']='service';
        $this->data['content']=$this->load->view($this->mainTemplate."/appointment/".$this->data['page'],$this->data,TRUE);

        $this->loadView();
    }

    // Services add/edit form
    function serviceEdit($id=null)
    {
        if($id!=null){
            $this->data['data'] =  $this->Appointment_admin_model->getServiceDetail($id);
            if(count($this->data['data'])!=0){
                $this->data['data'] = reset($this->data['data']);
            }else{
                $this->session->set_flashdata('error', _l('Your request was wrong!', $this));
                redirect(APPOINTMENT_ADMIN_URL.'services');
            }
            $extensions = array();
            $data_extensions = $this->Nodcms_admin_model->get_all_extension("r_services",$id);
            if(count($data_extensions)!=0){
                foreach ($data_extensions as $value) {
                    $extensions[$value["language_id"]] = $value;
                }
            }
            $this->data['extensions'] = $extensions;
            if($this->input->is_ajax_request()){
                if(!isset($this->data['data']["service_id"])){
                    echo json_encode(array("status"=>"error","error"=>_l("Your request was wrong!",$this)));
                }else{
                    $data = array(
                        "name"=>$this->data['data']["service_name"],
                        "price"=>$this->data['data']["price"],
                        "description"=>$this->data['data']["service_description"]
                    );
                    echo json_encode(array("status"=>"success", "data"=>$data));
                }
                exit;
            }
            $this->data['sub_title']=_l("Edit a service",$this);
        }else{
            $this->data['sub_title']=_l("Add new service",$this);
            if($this->input->is_ajax_request()){
                echo json_encode(array("status"=>"error","error"=>_l("Your request was wrong!",$this)));
                exit;
            }
        }
        $this->data['languages'] = $this->Nodcms_admin_model->get_all_language();
        $this->data['title']=_l("Practitioners",$this);
        $this->data['breadcrumb']=array(
            array('title'=>_l('Practitioners',$this),'url'=>APPOINTMENT_ADMIN_URL.'services'),
            array('title'=>$this->data['sub_title'])
        );
        $this->data['page']='service_edit';
        $this->data['content']=$this->load->view($this->mainTemplate."/appointment/".$this->data['page'],$this->data,TRUE);
        $this->loadView();
    }

    // Services add/edit actions
    function serviceManipulate($id=null)
    {
        // Check admin(group_id = 1) and assistant(group_id = 22) access
        if (in_array($this->session->userdata['group'], array(1,20,21)) && in_array($this->provider_group, array(1, 22))) {
            if($this->input->raw_input_stream){
                $this->load->library('form_validation');
                $this->form_validation->set_rules('data[service_name]', _l('Name',$this), 'required');
                if ($this->form_validation->run() != TRUE){
                    $result = array("status"=>"error","error"=>validation_errors(),"static_error");
                }else{
                    $setData = $this->input->post("data",TRUE);
                    if($this->input->input_stream('extensions'))
                        $extensions = $this->input->post("extensions",TRUE);
                    else
                        $extensions = null;
                    $new_id = $this->Appointment_admin_model->serviceManipulate($setData,$id,$extensions);
                    $result = array("status"=>"success","id",$new_id);
                }
            }else{
                $result = array("status"=>"error","error"=>_l("Your request was wrong!",$this));
            }
            if($this->input->is_ajax_request()){
                echo json_encode($result);
            }else{
                if($result["status"]=="success"){
                    $this->session->set_flashdata('success', _l('Your update successfully done!',$this));
                }else{
                    if(in_array('static_error',$result))
                        $this->session->set_flashdata('static_error', $result["error"]);
                    else
                        $this->session->set_flashdata('error', $result["error"]);
                }
                redirect(APPOINTMENT_ADMIN_URL."services");
            }
        }else{
            // Show to demo account
            $this->session->set_flashdata('error', _l("Unfortunately you do not have permission to this part of system.",$this));
            redirect(APPOINTMENT_ADMIN_URL."services");
        }
    }

    // Services remove action
    function serviceRemove($id)
    {
        // Check admin(group_id = 1) and assistant(group_id = 22) access
        if (in_array($this->session->userdata['group'],array(1,20,21)) && in_array($this->provider_group,array(1,22))) {
            $services =  @reset($this->Appointment_admin_model->getServiceDetail($id));
            if(!isset($services["service_id"])){
                $result = array("status"=>"error","error"=>_l("Service not founded!",$this));
            }else{
                $this->Appointment_admin_model->serviceRemove($id);
                $result = array("status"=>"success");
            }
            if($this->input->is_ajax_request()){
                echo json_encode($result);
            }else{
                if($result["status"]=="success"){
                    $this->session->set_flashdata('success', _l('You have successfully removed a service!',$this));
                }else{
                    $this->session->set_flashdata('error', $result["error"]);
                }
                redirect(APPOINTMENT_ADMIN_URL."services/");
            }
        }else{
            // Show to demo account
            $this->session->set_flashdata('error', _l("Unfortunately you do not have permission to this part of system.",$this));
            redirect(APPOINTMENT_ADMIN_URL."services");
        }
    }

    // Management page for services work times
    function servicePeriodsEdit($id)
    {
        $services =  @reset($this->Appointment_admin_model->getServiceDetail($id));
        if(!isset($services["service_id"])){
            if($this->input->is_ajax_request()){
                echo json_encode(array("status"=>"error","error"=>_l("The request was wrong!",$this)));
            }else{
                $this->session->set_flashdata('error', _l("The request was wrong!",$this));
                redirect(APPOINTMENT_ADMIN_URL."services");
            }
        }else{
            if($this->input->is_ajax_request()){
                $data = array();
                for($i=0;$i<=6;$i++){
                    $data[$i] =  $this->Appointment_admin_model->getAllPeriodsAjax($id,$i);
                }
                echo json_encode(array("status"=>"success","data"=>$data));
            }else{
                $this->data['data'] = array();
                for($i=0;$i<=6;$i++){
                    $this->data['data'][$i] =  $this->Appointment_admin_model->getAllPeriods($id, $i);
                }
                $this->data['days'] = array(

                    _l('Monday',$this),
                    _l('Tuesday',$this),
                    _l('Wednesday',$this),
                    _l('Thursday',$this),
                    _l('Friday',$this),
					 _l('Sunday',$this),
                    _l('Saturday',$this)
                );
                $this->data['service_data'] = $services;
                $this->data['title']=_l("Practitioners",$this);
                $this->data['sub_title']=_l("Work plan",$this);
                $this->data['breadcrumb']=array(
                    array('title'=>_l('Practitioners',$this),'url'=>APPOINTMENT_ADMIN_URL.'services'),
                    array('title'=>$services['service_name'],'url'=>APPOINTMENT_ADMIN_URL.'serviceEdit/'.$services['service_id']),
                    array('title'=>$this->data['sub_title'])
                );
                $this->data['page']='period';

                $this->db->select('provider_id,service_id');
            $this->db->from('r_services');
            $this->db->where('service_id',$id);
            $provider_id = $this->db->get()->result();
            $this->data['this_provider_id'] = $provider_id[0]->provider_id;

                $this->data['content']=$this->load->view($this->mainTemplate."/appointment/".$this->data['page'],$this->data,TRUE);
                $this->loadView();
            }
        }
    }

    // Get a period detail with ajax from services-work-times-management page
    function servicePeriodEditGet($service_id,$id)
    {
        if($this->input->is_ajax_request()){
            $service =  @reset($this->Appointment_admin_model->getServiceDetail($service_id));
            if(isset($service["service_id"])){
                $data =  @reset($this->Appointment_admin_model->getPeriodDetail($service_id,$id));
                if(!isset($data["period_id"])){
                    echo json_encode(array("status"=>"error","error"=>_l("Your request was wrong! No item found!",$this).$service_id));
                }else{
                    $start_time = date("H:i",mktime(0,$data["period_start_time"]));
                    $end_time = date("H:i",mktime(0,$data["period_end_time"]));
                    echo json_encode(array("status"=>"success","data"=>array(
                        "customer"=>$data["max_count"],
                        "start_time"=>$start_time,
                        "end_time"=>$end_time,
                        "day"=>$data["day_no"],
                        "period"=>$data["period_min"],
                    )));
                }
                exit;
            }elseif($this->input->is_ajax_request()){
                echo json_encode(array("status"=>"error","error"=>_l("Your request was wrong!",$this)));
                exit;
            }
        }
    }

    // Period add/edit action
    function servicePeriodsManipulate($service_id,$id=null)
    {
        // Check admin(group_id = 1) and assistant(group_id = 22) access
        if (in_array($this->session->userdata['group'],array(1, 20,21)) && in_array($this->provider_group,array(1, 22))) {
            $services =  @reset($this->Appointment_admin_model->getServiceDetail($service_id));
            if(!isset($services["service_id"])){
                $result = array("status"=>"error","error"=>_l("No service found!",$this));
            }else{
                if($this->input->raw_input_stream){
                    $this->load->library('form_validation');
                    $this->form_validation->set_rules('customer', _l('Customer',$this), 'required');
                    $this->form_validation->set_rules('start_time', _l('Start Time',$this), 'required|callback_regexMatch24Hours');
                    $this->form_validation->set_rules('end_time', _l('End Time',$this), 'required|callback_regexMatch24Hours');
                    $this->form_validation->set_rules('day', _l('Day',$this), 'required|is_natural');
                    $this->form_validation->set_rules('period', _l('Period',$this), 'required|is_natural');
                    $this->form_validation->set_rules('day', _l('Day',$this), 'required|is_natural');
                    if ($this->form_validation->run() != TRUE){
                        $result = array("status"=>"error","error"=>validation_errors(),'static_error');
                    }else{
                        $day = $this->input->post("day",TRUE);
                        $day = $day==7?0:$day;
                        $start_min = explode(":",$this->input->post("start_time",TRUE));
                        $start_min = ((int) $start_min[0]*60) + (int) $start_min[1];
                        $end_min = explode(":",$this->input->post("end_time",TRUE));
                        $end_min = ((int) $end_min[0]*60) + (int) $end_min[1];
                        $period = $this->input->post("period",TRUE);
                        if($start_min < $end_min){
                            if($period <= ($end_min - $start_min)){
                                if($this->Appointment_admin_model->checkExistsTimePeriod($day,$service_id,$start_min,$end_min,$id)==0){
                                    $setData = array(
                                        "max_count"=>$this->input->post("customer",TRUE),
                                        "period_start_time"=>$start_min,
                                        "period_end_time"=>$end_min,
                                        "period_min"=>$period,
                                        "day_no"=>$this->input->post("day",TRUE),
                                    );
                                    $new_id = $this->Appointment_admin_model->periodManipulate($setData,$id,$service_id);
                                    $result = array("status"=>"success","id"=>$new_id);
                                }else{
                                    $result = array("status"=>"error","error"=>_l("You have already entered a time in the period!",$this),'static_error');
                                }
                            }else{
                                $result = array("status"=>"error","error"=>_l('The time required for a customer is more than the work time!',$this),'static_error');
                            }
                        }else{
                            $result = array("status"=>"error","error"=>_l('Start time must be before end time!',$this),'static_error');
                        }
                    }
                }else{
                    $result = array("status"=>"error","error"=>_l("Your request was wrong!",$this));
                }
            }
        }else{
            // Show to demo account
            $result = array("status"=>"error","error"=>_l("Unfortunately you do not have permission to this part of system.",$this));
        }
        if($this->input->is_ajax_request()){
            echo json_encode($result);
        }else{
            if($result["status"]=="success"){
                $this->session->set_flashdata('success', _l('You have successfully registered a new time in your work schedule!',$this));
            }else{
                if(in_array('static_error',$result))
                    $this->session->set_flashdata('static_error', $result["error"]);
                else
                    $this->session->set_flashdata('error', $result["error"]);
            }
            redirect(APPOINTMENT_ADMIN_URL."servicePeriodsEdit/".$service_id);
        }
    }

    // Period remove action
    function servicePeriodRemove($service_id,$id)
    {
        // Check admin(group_id = 1) and assistant(group_id = 22) access
        if (in_array($this->session->userdata['group'],array(1, 20,21)) && in_array($this->provider_group, array(1, 22))) {
            $services =  @reset($this->Appointment_admin_model->getServiceDetail($service_id));
            if(!isset($services["service_id"])){
            $result = array("status"=>"error","error"=>_l("No service found!",$this));
        }else{
            $this->Appointment_admin_model->periodRemove($id,$service_id);
            $result = array("status"=>"success");
        }
        }else{
            // Show to demo account
            $result = array("status"=>"error","error"=>_l("Unfortunately you do not have permission to this part of system.",$this));
        }
        if($this->input->is_ajax_request()){
            echo json_encode($result);
        }else{
            if($result["status"]=="success"){
                $this->session->set_flashdata('success', _l('Your request was successful!',$this));
            }else{
                $this->session->set_flashdata('error', $result["error"]);
            }
            redirect(APPOINTMENT_ADMIN_URL."servicePeriodsEdit/".$service_id);
        }
    }

    // Appointment's requests list
    function reservation($page=1)
    {
        $conditions = array();
        // Print view
        $print_view = $this->input->get("print", TRUE);
        // Search name
        $search_text = $this->input->get("search_name", TRUE);
        if($search_text != NULL){
            $conditions["search_text"] = urldecode($search_text);
            $this->data["search_text"] = htmlspecialchars($search_text);
        }
		//Search reservation id
        $filter = $this->input->get("id", TRUE);
        if($filter != NULL){
            $filter = urldecode($filter);
            $this->data["reservation_id"] = $filter;
            $conditions["reservation_id"] = $filter;
        }
        // Min date filter
        $filter = $this->input->get("min_date", TRUE);
        if($filter != NULL){
            $filter = strtotime($filter);
            $this->data["min_date"] = date($this->_website_info["date_format"], $filter);
            $conditions["min_date"] = $filter;
        }
        // Max date filter
        $filter = $this->input->get("max_date", TRUE);
        if($filter != NULL){
            $filter = strtotime($filter);
            $this->data["max_date"] = date($this->_website_info["date_format"], $filter);
            $conditions["max_date"] = $filter;
        }
        // Min date filter
        $filter = $this->input->get("min_app_date", TRUE);
        if($filter != NULL){
            $filter = strtotime($filter);
            $this->data["min_app_date"] = date($this->_website_info["date_format"], $filter);
            $conditions["min_app_date"] = $filter;
        }
        // Max date filter
        $filter = $this->input->get("max_app_date", TRUE);
        if($filter != NULL){
            $filter = strtotime($filter);
            $this->data["max_app_date"] = date($this->_website_info["date_format"], $filter);
            $conditions["max_app_date"] = $filter;
        }
        // Date filter
        $filter = $this->input->get("date", TRUE);
        if($filter != NULL){
            $filter = intval($filter);
            $this->data["date"] = $filter;
            $conditions['created_date'] = $filter;
        }
        // Service filter
        $filter = $this->input->get("service", TRUE);
        if($filter != NULL){
            $filter = intval($filter);
            $this->data["service_id"] = $filter;
            $conditions['service_id'] = $filter;
        }
        // Language filter
        $filter = $this->input->get("language", TRUE);
        if($filter != NULL){
            $filter = explode(",", trim($filter));
            foreach($filter as &$item)
                $item = intval($item);
            $this->data["language_id"] = $filter;
            $conditions['language_id'] = $filter;
        }
        // Other filter
        $filter = $this->input->get("filters", TRUE);
        if($filter != NULL){
            $filter = explode(",", trim($filter));
            foreach($filter as &$item){
                $item = strval($item);
                if($item == "validated" && !isset($conditions['checked'])){
                    $conditions['checked'] = 1;
                }elseif($item == "invalidated" && !isset($conditions['checked'])){
                    $conditions['checked'] = 0;
                }elseif($item == "closed" && !isset($conditions['closed'])){
                    $conditions['closed'] = 1;
                }elseif($item == "unclosed" && !isset($conditions['closed'])){
                    $conditions['closed'] = 0;
                }elseif($item == "paypal_paid" && !isset($conditions['paypal_paid'])){
                    $conditions['paypal_paid'] = 1;
                }elseif($item == "paypal_unpaid" && !isset($conditions['paypal_paid'])){
                    $conditions['paypal_paid'] = 0;
                }else{
                    unset($item);
                }
            }
            $this->data["filters"] = $filter;
        }

        $config = array();
        $config['base_url'] = APPOINTMENT_ADMIN_URL.'reservation/';
        $config['reuse_query_string'] = TRUE;
        $config['total_rows'] = $this->Appointment_admin_model->getCountReservation(null,null,$conditions);
        $config['uri_segment'] = 3;
        if($print_view != NULL) {
            $config['per_page'] = $config['total_rows'];
        }else{
            $config['per_page'] = 10;
        }
        $this->mkPagination($config);

        $_SESSION["back_redirect"] = $config['base_url']."/".$page;
        $this->data['days'] = array(
            _l('Sunday',$this),
            _l('Monday',$this),
            _l('Tuesday',$this),
            _l('Wednesday',$this),
            _l('Thursday',$this),
            _l('Friday',$this),
            _l('Saturday',$this)
        );
        $page--;

        $this->data['data'] = $this->Appointment_admin_model->getReservation($config['per_page'],$page*$config['per_page'],$conditions);
        $this->data["count"] = $config['total_rows'];
        $this->data["sum_price"] = $this->Appointment_admin_model->getSumReservation("price", $conditions);
        $this->data['languages'] = $this->Nodcms_admin_model->get_all_language();
        $this->data['services'] = $this->Appointment_admin_model->getAllServices();
        $this->data['title']=_l("Appointments",$this);
        $this->data['current_url'] = APPOINTMENT_ADMIN_URL.'reservation/';

        $this->data['sub_title']=_l("Appointment list",$this);
        $this->data['page']='reservation_list';
        $this->data['breadcrumb']=array(
            array('title'=>$this->data['title']),
            array('title'=>$this->data['sub_title']),
        );
        if($print_view != NULL) {
            $this->frameTemplate = $this->mainTemplate."/appointment/print_frame";
            $this->data['content']=$this->load->view($this->mainTemplate."/appointment/reservation_print",$this->data,TRUE);
        }elseif($this->Appointment_admin_model->getCountReservation()){
            $this->data['content']=$this->load->view($this->mainTemplate."/appointment/reservation",$this->data,TRUE);
        }else{
             $this->data['content']=$this->load->view($this->mainTemplate."/appointment/reservation_emty",$this->data,TRUE);;
        }
        $this->loadView();
    }

    // Appointment's request search page
    function reservation_search($search_text,$page=1)
    {

        $search_text = urldecode($search_text);
        $conditions = array();
        $search = explode(' ',$search_text);
        foreach($search as $text){
            array_push($conditions,'fname LIKE "%'.$text.'%"');
            array_push($conditions,'lname LIKE "%'.$text.'%"');
        }
        $conditions = '('.implode(' OR ',$conditions).') ';
        $this->data['current_url'] = APPOINTMENT_ADMIN_URL.'reservation/'.$search_text;
        $config = array();
        $config['base_url'] = APPOINTMENT_ADMIN_URL.'reservation_search/'.$search_text;
        $config['reuse_query_string'] = TRUE;
        $config['total_rows'] = count($this->Appointment_admin_model->getReservation(null,null,$conditions));
        $config['uri_segment'] = 4;
        $config['per_page'] = 10;
        $this->mkPagination($config);
        $page--;
        $this->data['data'] = $this->Appointment_admin_model->getReservation($config['per_page'],$page*$config['per_page'],$conditions);
        $this->data['page'] = 'reservation_search';
        $this->data['title'] = 'reservation_search';
        $this->data['content'] = $this->load->view($this->mainTemplate."/appointment/reservation",$this->data,TRUE);;
        $this->loadView();
    }

    // Page of all details of appointments
    function reservationDetails($id)
    {

        $reservation =  @reset($this->Appointment_admin_model->getReservationDetail($id));
        if(!isset($reservation["reservation_id"])){
            $result = array("status"=>"error","error"=>_l("Reservation not founded!",$this));
        }else{
            $this->data['data'] = $reservation;
            $this->data['comments'] = $this->Appointment_admin_model->reservationGetComment($id);
            $this->data['extra_fields'] = $this->Appointment_admin_model->getExtraFieldsValue(array('reservation_id'=>$id));
            if($this->paypal_addon)
                $this->data['payments'] = $this->Paypal_model->getAppointmentsPaypalPaid(NULL, NULL, NULL, array('reservation_id'=>$id));
            $data = $this->load->view($this->mainTemplate."/appointment/ajax_admin_comments",$this->data,TRUE);
            $result = array("status"=>"success","result"=>$data);
        }
        if (!$this->input->is_ajax_request()) {
            if($result["status"] == "error"){
                $this->session->set_flashdata('error', $result["error"]);
                redirect(APPOINTMENT_ADMIN_URL."reservation/new");
            }
            $allUsers = $this->Appointment_admin_model->getAllUser();
            $this->data['data']['allUsers'] = $allUsers;
            $this->data['title']=_l("Appointments",$this);
            $this->data['sub_title']=_l("Details",$this);
            $this->data['page']='reservation_detail';
            $this->data['content']= $this->load->view($this->mainTemplate."/appointment/reservation_view",$this->data,TRUE);
            $this->loadView();
        }else{
            echo json_encode($result);
        }
    }

    // Appointment's requests edit/remove/close/send a comment/set a color actions
    function reservationAction($id,$type)
    {
        // Check admin(group_id = 1), assistant(group_id = 22) and staff(group_id = 21) access
        if (in_array($this->session->userdata['group'],array(1, 20,21)) ||
            $type=="valid" ||
            $type=="novalid" ||
            $type=="comment" ||
            $type=="color") {
            $reservation =  @reset($this->Appointment_admin_model->getReservationDetail($id));
            if(!isset($reservation["reservation_id"])){
                $result = array("status"=>"error","error"=>_l("Request not found!",$this));
            }else{
                if($type=="remove"){
                    $this->Appointment_admin_model->reservationRemove($id);
                    $result = array("status"=>"success");
                }elseif($type=="valid"){
                    $this->Appointment_admin_model->reservationMakeValid($id);
                    $result = array("status"=>"success");
                }elseif($type=="novalid"){
                    $this->Appointment_admin_model->reservationMakeNotValid($id);
                    $result = array("status"=>"success");
                }elseif($type=="close"){
                    $this->Appointment_admin_model->reservationClose($id);
                    $result = array("status"=>"success");
                }elseif($type=="return"){
                    $this->Appointment_admin_model->reservationCloseBack($id);
                    $result = array("status"=>"success");
                }elseif($type=="cancel"){
                    $provider = @reset($this->Appointment_admin_model->getProviderById($reservation['provider_id']));
                    $email_data = array(
                        "company"=>$this->_website_info['company'],
                        "email"=>$reservation['email'],
                        "first_name"=>$reservation['fname'],
                        "last_name"=>$reservation['lname'],
                        "reservation_date"=>my_int_date($reservation['reservation_date']),
                        "reservation_time"=>my_int_justTime($reservation['reservation_date_time']),
                        "provider_name"=>$provider['provider_name'],
                        "provider_phone"=>$provider['phone'],
                        "provider_address"=>$provider['address'],
                        "service_name"=>$reservation['service_name'],
                        "provider_url"=>base_url().$reservation['lang'].'/provider/'.$provider['provider_username'],
                    );
                    // Send reminder email
                    $this->sendNotificationEmail('reservation_cancel_confirmation', $reservation['language_id'], $reservation['email'], $email_data);
                    // Add one more time reminded
                    $this->Appointment_admin_model->reservationRemove($id);
                    $result = array("status"=>"success");
                }elseif($type=="remind"){
                    if($reservation['reservation_date']>=time()){
                        $provider = @reset($this->Appointment_admin_model->getProviderById($reservation['provider_id']));
                        $email_data = array(
                            "company"=>$this->_website_info['company'],
                            "email"=>$reservation['email'],
                            "first_name"=>$reservation['fname'],
                            "last_name"=>$reservation['lname'],
                            "reservation_date"=>my_int_date($reservation['reservation_date']),
                            "reservation_time"=>my_int_justTime($reservation['reservation_date_time']),
                            "provider_name"=>$provider['provider_name'],
                            "provider_phone"=>$provider['phone'],
                            "provider_address"=>$provider['address'],
                            "service_name"=>$reservation['service_name'],
                            "provider_url"=>base_url().$reservation['lang'].'/provider/'.$provider['provider_username'],
                        );
                        // Send reminder email
                        $this->sendNotificationEmail('reservation_reminder', $reservation['language_id'], $reservation['email'], $email_data);
                        // Add one more time reminded
                        $this->Appointment_admin_model->reservationUpdateRemind($id, $reservation['reminded']+1);
                        $result = array("status"=>"success", "count"=>$reservation['reminded']+1);
                    }else{
                        $result = array("status"=>"error", "error"=>_l("This appointment was expired!",$this));
                    }
                }elseif($type=="comment"){
                    $this->load->library('form_validation');
                    $this->form_validation->set_rules('message', _l('Message',$this), 'required');
                    if ($this->form_validation->run() != TRUE){
                        $result = array("status"=>"error","error"=>validation_errors(),'static_error');
                    }else{
                        $message = $this->input->post('message');
                        $this->Appointment_admin_model->reservationAddComment($id,$message);
                        $result = array("status"=>"success");
                    }
                }elseif($type=="color"){
                    $post_data = $this->input->post('color',TRUE);
                    if(in_array($post_data,array('success','info','warning','danger',''))){
                        $this->Appointment_admin_model->reservationManipulate(array('color'=>$post_data),$id);
                        $result = array("status"=>"success");
                    }else{
                        $result = array("status"=>"error","error"=>_l('Color value is not valid!',$this));
                    }
                }elseif($type=="change"){
                    $post_data = array(
                        'reservation_date_time'=>strtotime(str_replace('T',' ',$this->input->post('start',TRUE))),
                        'reservation_edate_time'=>strtotime($this->input->post('end',TRUE))
                    );
                    $post_data['reservation_date'] = mktime(0,0,0,date('m',$post_data['reservation_date_time']),date('d',$post_data['reservation_date_time']),date('Y',$post_data['reservation_date_time']));
                    $post_data['reservation_day_no'] = date('N',$post_data['reservation_date_time']);
                    if($this->Appointment_admin_model->reservationManipulate($post_data,$id)){
                        $result = array("status"=>"success");
                    }else{
                        $result = array("status"=>"error","error"=>_l('Change date is failed!!',$this));
                    }
                }
            }
        }else{
            // Show to demo account
            $result = array("status"=>"error","error"=>_l("Unfortunately you do not have permission to this part of system.",$this));
        }
        if($this->input->is_ajax_request()){
            echo json_encode($result);
        }else{
            if($result["status"]=="success"){
                $this->session->set_flashdata('success', _l('Your request was successful!',$this));
            }else{
                if(in_array('static_error',$result))
                    $this->session->set_flashdata('static_error', $result["error"]);
                else
                    $this->session->set_flashdata('error', $result["error"]);
            }
            redirect($_SESSION["back_redirect"]);
        }
    }

    // Send group reminder email to who tomorrow have an appointment
    function reservationGroupReminder()
    {
        if (in_array($this->session->userdata('group'),array(1, 20,21))){
            $tomorrow_date = mktime(0, 0, 0, date('m'), (date('d') + 1));
            $conditions = array('reservation_date'=>$tomorrow_date, 'closed'=>0, 'reminded'=>0);
            $reservations = $this->Appointment_admin_model->getReservation(NULL, NULL, $conditions);
            $i=0;
            foreach($reservations as $item){
                $provider = @reset($this->Appointment_admin_model->getProviderById($item['provider_id']));
                $email_data = array(
                    "company"=>$this->_website_info['company'],
                    "email"=>$item['email'],
                    "first_name"=>$item['fname'],
                    "last_name"=>$item['lname'],
                    "reservation_date"=>my_int_date($item['reservation_date']),
                    "reservation_time"=>my_int_justTime($item['reservation_date_time']),
                    "provider_name"=>$provider['provider_name'],
                    "provider_phone"=>$provider['phone'],
                    "provider_address"=>$provider['address'],
                    "service_name"=>$item['service_name'],
                    "provider_url"=>base_url().$item['lang'].'/provider/'.$provider['provider_username'],
                );
                // Send reminder email
                $this->sendNotificationEmail('reservation_reminder', $item['language_id'], $item['email'], $email_data);
                // Add one more time reminded
                $this->Appointment_admin_model->reservationUpdateRemind($item['reservation_id'], $item['reminded']+1);
                $i++;
            }
            if($i!=0){
                $result = array("status"=>"success");
            }else{
                $result = array("status"=>"error","error"=>_l("There wasn't any email, ready to remind!",$this));
            }
        }else{
            // Show to demo account
            $result = array("status"=>"error","error"=>_l("Unfortunately you do not have permission to this part of system.",$this));
        }
        if($this->input->is_ajax_request()){
            echo json_encode($result);
        }else{
            if($result["status"]=="success"){
                $this->session->set_flashdata('success', _l('Your request was successful!',$this));
            }else{
                if(in_array('static_error',$result))
                    $this->session->set_flashdata('static_error', $result["error"]);
                else
                    $this->session->set_flashdata('error', $result["error"]);
            }
            redirect(APPOINTMENT_ADMIN_URL.'dashboard');
        }
    }
    // Page of holidays list
    function holidays($page=1)
    {
        $config = array();
        $config['base_url'] = APPOINTMENT_ADMIN_URL.'holidays/';
        $config['total_rows'] = count($this->Appointment_admin_model->getHolidays());
        $config['uri_segment'] = 3;
        $config['per_page'] = 10;
        $this->mkPagination($config);
        $page--;
        $this->data['data'] = $this->Appointment_admin_model->getHolidays($config['per_page'],$page*$config['per_page']);
        $this->data['title']=_l("Holidays",$this);
        $this->data['breadcrumb']=array(
            array('title'=>$this->data['title'])
        );
        $this->data['page']='holidays';
        $this->data['content']=$this->load->view($this->mainTemplate."/appointment/".$this->data['page'],$this->data,TRUE);
        $this->loadView();
    }

    // Holidays add/edit actions
    function holidaysManipulate($id=null)
    {
        // Check admin(group_id = 1) and assistant(group_id = 22) access
        if (in_array($this->session->userdata['group'],array(1, 20,21)) && in_array($this->provider_group,array(1, 22))) {
            if($this->input->raw_input_stream){
                $this->load->library('form_validation');
                $this->form_validation->set_rules('name', _l('Name',$this), 'required');
                $this->form_validation->set_rules('date', _l('Date',$this), 'required|callback_formRulesDateFormat');
                if ($this->form_validation->run() != TRUE){
                    $result = array("status"=>"error","error"=>validation_errors(),'static_error');
                }else{
                    $free_date = strtotime($this->input->post("date",TRUE));
                    if($id==null && $this->Appointment_admin_model->checkHolidaysDate($free_date)!=0){
                        $result = array("status"=>"error","error"=>_l("This date is already existed.",$this));
                    }else{
                        $setData = array(
                            "date_title"=>$this->input->post("name",TRUE),
                            "free_date"=>$free_date,
                        );
                        $new_id = $this->Appointment_admin_model->holidaysManipulate($setData,$id);
                        $result = array("status"=>"success","id",$new_id);
                    }
                }
            }else{
                $result = array("status"=>"error","error"=>_l("Your request was wrong!",$this));
            }
        }else{
            // Show to demo account
            $result = array("status"=>"error","error"=>_l("Unfortunately you do not have permission to this part of system.",$this));
        }
        if($this->input->is_ajax_request()){
            echo json_encode($result);
        }else{
            if($result["status"]=="success"){
                $this->session->set_flashdata('success', _l('Your request was successful!',$this));
            }else{
                if(in_array('static_error',$result))
                    $this->session->set_flashdata('static_error', $result["error"]);
                else
                    $this->session->set_flashdata('error', $result["error"]);
            }
            redirect(APPOINTMENT_ADMIN_URL."holidays");
        }
    }

    // Holidays get data for edit with ajax
    function holidaysEdit($id=null)
    {
        if($id!=null){
            $this->data['data'] =  @reset($this->Appointment_admin_model->getHolidaysDetail($id));
            if($this->input->is_ajax_request()){
                if(!isset($this->data['data']["date_id"])){
                    echo json_encode(array("status"=>"error","error"=>_l("Your request was wrong!",$this)));
                }else{
                    echo json_encode(array("status"=>"success","data"=>array("name"=>$this->data['data']["date_title"],"date"=>date("m/d/Y",$this->data['data']["free_date"]))));
                }
                exit;
            }
        }elseif($this->input->is_ajax_request()){
            echo json_encode(array("status"=>"error","error"=>_l("Your request was wrong!",$this)));
            exit;
        }
    }

    // Holidays remove action
    function holidaysRemove($id)
    {
        // Check admin(group_id = 1) and assistant(group_id = 22) access
        if (in_array($this->session->userdata['group'],array(1, 20,21)) && in_array($this->provider_group,array(1, 22))) {
            $data =  @reset($this->Appointment_admin_model->getHolidaysDetail($id));
            if(!isset($data["date_id"])){
                $result = array("status"=>"error","error"=>_l("Service not founded!",$this));
            }else{
                $this->Appointment_admin_model->holidaysRemove($id);
                $result = array("status"=>"success");
            }
        }else{
            // Show to demo account
            $result = array("status"=>"error","error"=>_l("Unfortunately you do not have permission to this part of system.",$this));
        }
        if($this->input->is_ajax_request()){
            echo json_encode($result);
        }else{
            if($result["status"]=="success"){
                $this->session->set_flashdata('success', _l('Your request was successful!',$this));
            }else{
                $this->session->set_flashdata('error', $result["error"]);
            }
            redirect(APPOINTMENT_ADMIN_URL."holidays/");
        }
    }

    // Extra fields list
    function extraFields()
    {
        $this->data['data_list']=$this->Appointment_admin_model->getExtraFields();
        $this->data['data_table'] = "appointment/extra_fields";
        $this->data['title'] = _l("Extra Fields",$this);
        $this->data['sub_title'] = _l("Your extra fields list",$this);
        $this->data['page'] = "extra_fields";
        $this->data['addNewLink'] = APPOINTMENT_ADMIN_URL."extraFieldsEdit";
        $this->data['content']=$this->load->view($this->mainTemplate.'/data_list',$this->data,TRUE);
        $this->loadView();
    }

    // Extra-Fields add/edit form
    function extraFieldsEdit($id=null)
    {
        if($id!=null){
            $this->data['data']=$this->Appointment_admin_model->getExtraFieldsDetail($id);
            if($this->data['data']==null)
                redirect(APPOINTMENT_ADMIN_URL."extraFields");
            $this->data['sub_title'] = _l("Edit a field",$this);
        }else{
            $this->data['sub_title'] = _l("Add a new field",$this);
        }
        $titles = array();
        $data_titles = $this->Nodcms_admin_model->get_all_titles("r_extra_fields",$id);
        if(count($data_titles)!=0){
            foreach ($data_titles as $value) {
                $titles[$value["language_id"]] = $value;
            }
        }
        $this->data['titles'] = $titles;
        $this->data['fields_type'] = $this->Appointment_admin_model->getAllFieldType();
        $this->data['languages'] = $this->Nodcms_admin_model->get_all_language();
        $this->data['title'] = _l("Extra Fields",$this);
        $this->data['breadcrumb']=array(
            array('title'=>_l('Extra Fields',$this),'url'=>APPOINTMENT_ADMIN_URL.'extraFields'),
            array('title'=>$this->data['sub_title'])
        );
        $this->data['page'] = "extra_fields";
        $this->data['content']=$this->load->view($this->mainTemplate.'/appointment/extra_fields_edit',$this->data,TRUE);
        $this->loadView();
    }

    // Extra-Fields add/edit action
    function extraFieldsManipulate($id=null)
    {
        // Check admin(group_id = 1) and assistant(group_id = 22) access
        if (in_array($this->session->userdata['group'],array(1, 20,21)) && in_array($this->provider_group,array(1, 22))) {
            if ($this->Appointment_admin_model->extraFieldsManipulate($this->input->post('data',TRUE),$id)){
                $this->session->set_flashdata('success', _l('Updated Extra Fields!',$this));
            }
            else
            {
                $this->session->set_flashdata('error', _l('Update Extra Fields failed!',$this));
            }
        }else{
            $this->session->set_flashdata('error', _l("Unfortunately you do not have permission to this part of system.",$this));
        }
        redirect(APPOINTMENT_ADMIN_URL."extraFields");
    }

    // Extra-Fields remove action
    function extraFieldsRemove($id=0)
    {
        // Check admin(group_id = 1) and assistant(group_id = 22) access
        if (in_array($this->session->userdata['group'],array(1, 20,21)) && in_array($this->provider_group,array(1, 22))) {
            $this->db->trans_start();
            $this->db->delete('r_extra_fields', array('id' => $id));
            $this->db->trans_complete();
            $this->session->set_flashdata('success', _l('Deleted from Extra Fields!',$this));
        }else{
            $this->session->set_flashdata('error', _l("Unfortunately you do not have permission to this part of system.",$this));
        }
        redirect(APPOINTMENT_ADMIN_URL."extraFields");
    }

    // Calendar page (Appointment's requests on calendar)
    function calendar($date=null)
    {
        if($this->input->is_ajax_request()){
            $start = $this->input->post("start", TRUE);
            $start = intval($start);
            $end = $this->input->post("end", TRUE);
            $end = intval($end);
            $conditions = array(
                "min_app_time"=>$start,
                "max_app_time"=>$end,
            );
            $data_list = $this->Appointment_admin_model->getReservation(NULL, NULL, $conditions);
            if(count($data_list)!=0){
                foreach($data_list as $key=>$item){
                    $data_list[$key]["price"] = $this->currency->format($item["price"]);
                    $data_list[$key]["reservation_date_time"] = date("Y/m/d H:i", $item["reservation_date_time"]);
                    $data_list[$key]["reservation_edate_time"] = date("Y/m/d H:i", $item["reservation_edate_time"]);
                    if($item["color"]=="success"){
                        $data_list[$key]["bgcolor"] = "green";
                    }elseif($item["color"]=="info"){
                        $data_list[$key]["bgcolor"] = "blue";
                    }elseif($item["color"]=="warning"){
                        $data_list[$key]["bgcolor"] = "yellow";
                    }elseif($item["color"]=="danger"){
                        $data_list[$key]["bgcolor"] = "red";
                    }else{
                        $data_list[$key]["bgcolor"] = "";
                    }
                }
                $data = array("status"=>"success", "data"=>$data_list);
            }else{
                $data = array("status"=>"error", "error"=>"Noting");
            }
            echo json_encode($data);
        }else{
            // Set calendar time duration (minimum period)
            $hour = '00';
            $minute = '30';
            $duration = $this->Appointment_admin_model->getMinPeriod($this->provider["provider_id"]);
            if($duration != 0 && $duration < 60){
                $minute = $duration;
            }elseif($duration != 0 && $duration >= 60){
                $hour = $duration/60;
                $minute = $duration%60;
            }
            if(intval($hour)<10) $hour = '0'.intval($hour);
            if(intval($minute)<10) $minute = '0'.intval($minute);
            $this->data['slotDuration'] = "$hour:$minute:00";
            $this->data['languages'] = $this->Nodcms_admin_model->get_all_language();
            $this->data['services'] = $this->Appointment_admin_model->getAllServices();
            $this->data['title']=_l("Calendar",$this);
            $this->data['sub_title']=_l("New Requests",$this);
            $this->data['page']='reservation_calendar';
            $this->data['content']=$this->load->view($this->mainTemplate."/appointment/calendar",$this->data,TRUE);;
            $this->loadView();
        }
    }

    // Appointment system settings form and action
    function settings()
    {
        if($this->input->input_stream('data')){
            if ($this->session->userdata['group']==1) {
                $data = $this->input->post('data');
                if(isset($data["options"])){
                    foreach($data["options"] as $key=>$value){
                        if($this->Nodcms_admin_model->check_setting_options($key)){
                            $this->Nodcms_admin_model->edit_setting_options($key,$value);
                        }else{
                            $this->Nodcms_admin_model->insert_setting_options($key,$value);
                        }
                    }
                    unset($data["options"]);
                }
                $this->Nodcms_admin_model->edit_setting($data);
                $this->session->set_flashdata('success', _l("Your Setting has been updated successfully!",$this));
            }else{
                $this->session->set_flashdata('error', _l("Unfortunately you do not have permission to this part of system.",$this));
            }
            redirect(APPOINTMENT_ADMIN_URL.'settings');
        }
        $data_options = array();
        $setting_options = $this->Nodcms_admin_model->get_all_setting_options();
        foreach($setting_options as $value){
            $data_options[$value["language_id"]] = $value;
        }
        $this->data["currency_format"] = array(
            array("code"=>"1.234,56"),
            array("code"=>"1.234"),
            array("code"=>"1,234.56"),
            array("code"=>"1,234"),
        );
        $this->data['options'] = $data_options;
        $this->data['languages'] = $this->Nodcms_admin_model->get_all_language();
        $this->data['title'] = _l('Settings',$this);
        $this->data['sub_title'] = _l('Appointments settings',$this);
        $this->data['breadcrumb'] = array(array('title'=>$this->data['title']),array('title'=>$this->data['sub_title']));
        $this->data['content']=$this->load->view($this->mainTemplate.'/appointment/settings',$this->data,TRUE);
        $this->data['page'] = "appointment_setting";
        $this->loadView();
    }

    // Get NodAPS portable button code
    function portableBtn()
    {
        $this->data['languages'] = $this->Nodcms_admin_model->get_all_language();
        $this->data['title'] = _l('Portable booking button',$this);
        $this->data['sub_title'] = _l('Code generator',$this);
        $this->data['content']=$this->load->view($this->mainTemplate.'/appointment/portable_btn',$this->data,TRUE);
        $this->data['page'] = "portable_btn";
        $this->loadView();
    }

    // Users account setting page
    function accountSetting()
    {

        $this->load->library('form_validation');

            // Check admin(group_id = 1), assistant(group_id = 22) and staff(group_id = 21) access
            if (in_array($this->session->userdata['group'],array(1, 20,21))) {
                $this->form_validation->set_rules('data[username]', _l('Username',$this), 'required|callback_validateUsername');
                $this->form_validation->set_rules('data[email]', _l('Email Address',$this), 'required|valid_email|callback_emailUnique');
                $this->form_validation->set_rules('data[firstname]', _l('First Name',$this), 'required|callback_formRulesName');
                $this->form_validation->set_rules('data[lastname]', _l('Last Name',$this), 'required|callback_formRulesName');
                $this->form_validation->set_rules('data[password]', _l('Password',$this), 'xss_clean|matches[data[confirmPassword]]');
                $this->form_validation->set_rules('data[confirmPassword]', _l('Confirm Password',$this), 'xss_clean|matches[data[password]]');

               // $this->form_validation->set_rules('data[language_id]', _l('Language',$this), 'required|is_natural');
                $this->form_validation->set_rules('data[language_id]', _l('Language',$this), 'is_natural');
                if ($this->form_validation->run() == FALSE){
                    $this->session->set_flashdata('static_error',validation_errors());
                    //redirect(APPOINTMENT_ADMIN_URL.'accountSetting');
                }else{

                    $post_data = $this->input->post('data',TRUE);
                    if($this->session->userdata("group")){
                        $data = array(
                            'lastname'=>$post_data['lastname'],
                            'firstname'=>$post_data['firstname'],
                            //'username'=>$post_data['username'],
                            'email'=>$post_data['email'],
                            //'language_id'=>$post_data['language_id']
                        );
                    }else{
                        $data = array(
                            'lastname'=>$post_data['lastname'],
                            'firstname'=>$post_data['firstname'],
                            'username'=>$post_data['username'],
                            'email'=>$post_data['email'],
                            'language_id'=>$post_data['language_id']
                        );
                    }

                    if($post_data['password']!='') $data['password']=$post_data['password'];
                    if ($this->Nodcms_admin_model->user_manipulate($data,$this->session->userdata['user_id']))
                    {
                        $row = $this->Nodcms_admin_model->get_user_detail($this->session->userdata['user_id']);
                        $data = array(
                            'fullname'  => $row['fullname'],
                            'username'  => $row['username'],
                            'user_id' => $row['user_id'],
                            'group'   => $row['group_id'],
                            'avatar'   => $row['avatar'],
                            'email'   => $row['email'],
                            'language_id'   => $row['language_id'],
                            'logged_in_status'   => true,
                        );
                        $this->session->set_userdata($data);
                        $this->session->set_flashdata('success', _l('Updated user',$this));
                    }
                    else
                    {
                        $this->session->set_flashdata('error', _l('Updated user error. Please try later',$this));
                    }
                }
            }else{
                $this->session->set_flashdata('error', _l("Unfortunately you do not have permission to this part of system.",$this));
            }
            //redirect(APPOINTMENT_ADMIN_URL.'accountSetting');

        $this->data['data'] = $this->userdata;
        $this->data['languages'] = $this->Nodcms_admin_model->get_all_language();
        $this->data['userPictures'] = $this->getPictures();
        $this->data['coverPic'] = $this->Appointment_admin_model->getCover();

        $this->data['content']=$this->load->view($this->mainTemplate.'/account_setting',$this->data,true);

        $this->data['title'] = _l("Account setting",$this);
        $this->data['page'] = "account";

        $this->loadView();
    }

    // End function for change
    private function loadView(){

        $this->selectedMenu($this->data['page']);
        $this->load->view($this->frameTemplate,$this->data);

    }

    // Add selected classes to menus
    private function selectedMenu($page)
    {
        if(isset($this->data['reservation_menu'][$page])) {
            $this->data['reservation_menu'][$page]['class'] = 'star active';
            $this->data['reservation_menu'][$page]['addOn'] = '<span class="selected"></span>';
        }elseif(isset($this->data['reservation_menu'])){
            foreach ($this->data['reservation_menu'] as &$item) {
                if (isset($item['sub_menu']) && isset($item['sub_menu'][$page])) {
                    $item['class'] = 'star active open';
                    $item['sub_menu'][$page]['class'] = 'star active';
                }
            }
        }
    }

    // Set menu links and allow users to access admin specials methods
    private function reservationAdminPermission()
    {
        // Acceptable Methods for provider admin
        $acceptableMethods = array(
            'index',
            'dashboard',
            'accountSetting',
            'reservation',
            'reservationDetails',
            'reservationAction',
            'reservationSearch',
            'calendar',
            'extraFields',
            'extraFieldsEdit',
            'extraFieldsManipulate',
            'extraFieldsRemove',
            'holidays',
            'holidaysManipulate',
            'holidaysEdit',
            'holidaysRemove',
            'treatment',
            'treatmentEdit',
            'treatmentUpdate',
            'treatmentRemove',
            'services',
            'services',
            'serviceEdit',
            'serviceManipulate',
            'serviceRemove',
            'servicePeriodsEdit',
            'servicePeriodEditGet',
            'servicePeriodsManipulate',
            'servicePeriodRemove',
            'getUsername',
            'myProviderEdit',
            'myProviderManager',
            'myProviderManagerRemove',
            'myProviderManagerNotificationEmail',
            'portableBtn',
            'reservationGroupReminder',
            'accountSetting',
            'userProfiles',
            'imageUpload',
            'changeCoverPic',
            'removePic',
        );
        if(!in_array($this->router->fetch_method(),$acceptableMethods)){
            $this->session->set_flashdata('error', _l("Unfortunately you do not have permission to this part of system.",$this));
            redirect(APPOINTMENT_ADMIN_URL);
        }
        $this->data['reservation_menu'] = array(
            'dashboard'=>array(
                'url'=>APPOINTMENT_ADMIN_URL.'dashboard',
                'icon'=>'icon-speedometer',
                'title'=>_l('Dashboard',$this),
                'class'=>'',
                'addOn'=>'',
            ),
            'reservation'=>array(
                'url'=>'javascript:;',
                'icon'=>'icon-list',
                'title'=>_l('Reservation',$this),
                'class'=>'',
                'addOn'=>'<span class="arrow"></span>',
                'sub_menu'=>array(
                    'reservation_calendar'=>array(
                        'url'=>APPOINTMENT_ADMIN_URL.'calendar',
                        'title'=>_l('Calendar',$this),
                        'class'=>'',
                    ),
                    'reservation_list'=>array(
                        'url'=>APPOINTMENT_ADMIN_URL.'reservation?min_app_date='.my_int_date(time()).'&filters=unclosed',
                        'title'=>_l('Listing',$this),
                        'class'=>'',
                    ),
                ),
            ),
            'service'=>array(
                'url'=>APPOINTMENT_ADMIN_URL.'services',
                'icon'=>'icon-user',
                'title'=>_l('Practitioners',$this),
                'class'=>'',
                'addOn'=>'',
				'sub_menu'=>array(
                    'Holidays'=>array(
                        'url'=>APPOINTMENT_ADMIN_URL.'holidays',
                        'title'=>_l('Holidays',$this),
                        'class'=>'',
                    ),
                    'reservation_list'=>array(
                        'url'=>APPOINTMENT_ADMIN_URL.'services',
                        'title'=>_l('All Practitioners',$this),
                        'class'=>'',
                    ),
                ),
            ),
			/*'dental-office'=>array(
                'url'=>'/timepry/Dental/addDentalOffice',
                'icon'=>'icon-briefcase',
                'title'=>_l('Add Dental Office',$this),
                'class'=>'',
                'addOn'=>'',
            ),*/
			'treatment'=>array(
                'url'=>APPOINTMENT_ADMIN_URL.'treatment',
                'icon'=>'icon-briefcase',
                'title'=>_l('Treatments',$this),
                'class'=>'',
                'addOn'=>'',
            ),
            /*'extra_fields'=>array(
                'url'=>APPOINTMENT_ADMIN_URL.'extraFields',
                'icon'=>'icon-paper-clip',
                'title'=>_l('Extra fields',$this),
                'class'=>'',
                'addOn'=>'',
            ),
            'portable_btn'=>array(
                'url'=>APPOINTMENT_ADMIN_URL.'portableBtn',
                'icon'=>'icon-mouse',
                'title'=>_l('Booking button',$this),
                'class'=>'',
                'addOn'=>'',
            ),*/
            'provider_menu'=>array(
                'url'=>'javascript:;',
                'icon'=>'icon-note',
                'title'=>_l('My Dental Office',$this),
                'class'=>'',
                'addOn'=>'',
                'sub_menu'=>array(
                    'provider'=>array(
                        'url'=>APPOINTMENT_ADMIN_URL.'myProviderEdit',
                        'title'=>_l('Details',$this),
                        'class'=>'',
                    ),
                    'list_offices'=>array(
                        'url'=>APPOINTMENT_ADMIN_URL.'?showOption',
                        'title'=>"All Offices",
                        'class'=>'',
                    ),
                    'dental-office'=>array(
                        'url'=>'/timepry/Dental/addDentalOffice',
                        'icon'=>'icon-briefcase',
                        'title'=>_l('Add Dental Office',$this),
                        'class'=>'',
                        'addOn'=>'',
                    ),
                ),
            ),
        );
        if($this->paypal_addon){
            $this->data['reservation_menu']['provider_paypal_payments'] = array(
                'url'=>PAYPAL_ADMIN_URL.'providerPayments',
                'icon'=>'fa fa-paypal',
                'title'=>_l('PayPal Payments',$this),
                'class'=>'',
                'addOn'=>'',
            );
        }
    }

    private function reservationAssistantPermission()
    {
        // Acceptable Methods for assistant
        $acceptableMethods = array(
            'index',
            'dashboard',
            'accountSetting',
            'reservation',
            'reservationDetails',
            'reservationAction',
            'reservationSearch',
            'calendar',
            'extraFields',
            'extraFieldsEdit',
            'extraFieldsManipulate',
            'extraFieldsRemove',
            'holidays',
            'holidaysManipulate',
            'holidaysEdit',
            'holidaysRemove',
            'services',
            'serviceEdit',
            'serviceManipulate',
            'serviceRemove',
            'servicePeriodsEdit',
            'servicePeriodEditGet',
            'servicePeriodsManipulate',
            'servicePeriodRemove',
            'reservationGroupReminder',
            'accountSetting',
            'userProfiles',
            'imageUpload',
            'changeCoverPic',
            'removePic',
        );
        if(!in_array($this->router->fetch_method(),$acceptableMethods)){
            $this->session->set_flashdata('error', _l("Unfortunately you do not have permission to this part of system.",$this));
            redirect(APPOINTMENT_ADMIN_URL);
        }
        $this->data['reservation_menu'] = array(
            'dashboard'=>array(
                'url'=>APPOINTMENT_ADMIN_URL.'dashboard',
                'icon'=>'icon-speedometer',
                'title'=>_l('Dashboard',$this),
                'class'=>'',
                'addOn'=>'',
            ),
            'reservation'=>array(
                'url'=>'javascript:;',
                'icon'=>'icon-list',
                'title'=>_l('Reservation',$this),
                'class'=>'',
                'addOn'=>'<span class="arrow"></span>',
                'sub_menu'=>array(
                    'reservation_calendar'=>array(
                        'url'=>APPOINTMENT_ADMIN_URL.'calendar',
                        'title'=>_l('Calendar',$this),
                        'class'=>'',
                    ),
                    'reservation_list'=>array(
                        'url'=>APPOINTMENT_ADMIN_URL.'reservation?min_app_date='.my_int_date(time()).'&filters=unclosed',
                        'title'=>_l('Listing',$this),
                        'class'=>'',
                    ),
                ),
            ),
            'holidays'=>array(
                'url'=>APPOINTMENT_ADMIN_URL.'holidays',
                'icon'=>'icon-calendar',
                'title'=>_l('Holidays',$this),
                'class'=>'',
                'addOn'=>'',
            ),
            'service'=>array(
                'url'=>APPOINTMENT_ADMIN_URL.'services',
                'icon'=>'icon-user',
                'title'=>_l('Practitioners',$this),
                'class'=>'',
                'addOn'=>'',

            ),
            'extra_fields'=>array(
                'url'=>APPOINTMENT_ADMIN_URL.'extraFields',
                'icon'=>'icon-paper-clip',
                'title'=>_l('Extra fields',$this),
                'class'=>'',
                'addOn'=>'',
            ),
        );
    }

    private function reservationStaffPermission()
    {
        // Acceptable Methods for staffs
        $acceptableMethods = array(
            'index',
            'dashboard',
            'reservation',
            'reservationDetails',
            'reservationAction',
            'reservationSearch',
            'reservationGroupReminder',
            'accountSetting',
            'userProfiles',
            'imageUpload',
            'changeCoverPic',
            'removePic',
        );
        if(!in_array($this->router->fetch_method(),$acceptableMethods)){
            $this->session->set_flashdata('error', _l("Unfortunately you do not have permission to this part of system.",$this));
            redirect(APPOINTMENT_ADMIN_URL);
        }
        $this->data['reservation_menu'] = array(
            'dashboard'=>array(
                'url'=>APPOINTMENT_ADMIN_URL.'dashboard',
                'icon'=>'icon-speedometer',
                'title'=>_l('Dashboard',$this),
                'class'=>'',
                'addOn'=>'',
            ),
            'reservation_new'=>array(
                'url'=>APPOINTMENT_ADMIN_URL.'reservation?min_app_date='.my_int_date(time()).'&filters=unclosed',
                'icon'=>'icon-star',
                'title'=>_l('New Reservation',$this),
                'class'=>'',
                'addOn'=>'',
            ),
            'reservation_now'=>array(
                'url'=>APPOINTMENT_ADMIN_URL.'reservation?min_app_date='.my_int_date(time()).'&max_app_date='.my_int_date(strtotime("tomorrow")).'&filters=unclosed',
                'icon'=>'icon-clock',
                'title'=>_l("Today's Reservation",$this),
                'class'=>'',
                'addOn'=>'',
            ),
            'reservation_expired'=>array(
                'url'=>APPOINTMENT_ADMIN_URL.'reservation?max_app_date='.my_int_date(time()).'&filters=unclosed',
                'icon'=>'icon-hourglass',
                'title'=>_l("Expired Reservation",$this),
                'class'=>'',
                'addOn'=>'',
            ),
            'reservation_closed'=>array(
                'url'=>APPOINTMENT_ADMIN_URL.'reservation?filters=closed',
                'icon'=>'icon-check',
                'title'=>_l("Closed Reservation",$this),
                'class'=>'',
                'addOn'=>'',
            ),
        );
    }

    private function reservationPatientPermission()
    {
        // Acceptable Methods for staffs
        $acceptableMethods = array(
            'index',
            'dashboard',
            'reservation',
            'reservationDetails',
            'reservationAction',
            'reservationSearch',
            'reservationGroupReminder',
            'accountSetting',
            'userProfiles',
            'allAppointments',
            'changeCoverPic',
        );
        if(!in_array($this->router->fetch_method(),$acceptableMethods)){
            $this->session->set_flashdata('error', _l("Unfortunately you do not have permission to this part of system.",$this));
            redirect(APPOINTMENT_ADMIN_URL);
        }
        $this->data['reservation_menu'] = array(

            'reservation_new'=>array(
                'url'=>APPOINTMENT_ADMIN_URL.'allAppointments',
                'icon'=>'icon-star',
               // 'title'=>_l('New Reservation',$this),
                'title'=>'All Appointments',
                'class'=>'',
                'addOn'=>'',
            ),
            'reservation_now'=>array(
                'url'=>APPOINTMENT_ADMIN_URL.'userProfiles',
                'icon'=>'icon-user',
                'title'=>'User Info',
                'class'=>'',
                'addOn'=>'',
            )
        );
    }

    public function userProfiles(){
        $this->load->model('Appointment_model');

        if($this->input->post()){

            $fields = array(
                'dob' => date("Y-m-d",strtotime($this->input->post('dob'))),
                'city' => $this->input->post('city'),
                'q1' => $this->input->post('question1'),
                'q2' => implode(",",$this->input->post('question2')),
                'address' => $this->input->post('address'),
                'about' => $this->input->post('about'),
                'friends' => implode(",",$this->input->post('freinds')),
                'user_id' => $this->session->userdata('user_id')
        );

           $userTelephone = $this->input->post("telephone");

            if(!empty($userTelephone)){

                $this->db->where('user_id',$this->session->userdata('user_id'));
                $this->db->update('users',array('mobile'=>$userTelephone));
            }


        $checkIfQuestionsExist = $this->Appointment_model->checkIfquestions($this->session->userdata('user_id'));

        if(!empty($checkIfQuestionsExist)){
                //update
                $this->Appointment_model->updateQuestion($fields,$this->session->userdata('user_id'));
            }else{
                //insert
                $this->Appointment_model->insertQuestions($fields);
            }

            $this->session->set_flashdata('success', 'Profile Updated Sucessfully!');
        }

        $allUsers = $this->Appointment_admin_model->getAllUser();
        $userProfile = $this->Appointment_admin_model->getProfile($this->session->userdata("user_id"));


        if($userProfile){
            $this->data['data']['currentProfile'] = $userProfile;
        }


       $this->data['data']['allUsers'] = $allUsers;

        $this->data['languages'] = $this->Nodcms_admin_model->get_all_language();
        $this->data['content']=$this->load->view($this->mainTemplate.'/public_profile',$this->data,true);
        $this->data['title'] = "Public Profile";
        $this->data['page'] = "account";
        $this->loadView();

    }

    public function allAppointments(){
        $this->data['languages'] = $this->Nodcms_admin_model->get_all_language();
        $this->data['content']=$this->load->view($this->mainTemplate.'/all_appointments',$this->data,true);
        $this->data['title'] = "Public Profile";
        $this->data['page'] = "account";
        $this->loadView();
    }

    public function getPictures(){

        $data = $this->Appointment_admin_model->getProviderImage($this->session->userdata('user_id'))[0];

        if(!empty($data)){
            return $data['image'];
        }else{
            return "empty";
        }
    }

    public function imageUpload(){

        $time = time();

       $totalFiles = count($_FILES["file"]['name']) - 1;



      for($i=0;$i<=$totalFiles;$i++){

          $target_dir = "upload_file/images/";
          $target_file = $target_dir.$time."-". basename($_FILES["file"]["name"][$i]);
          $uploadOk = 1;
          $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
          // Check if image file is a actual image or fake image
          if(isset($_POST["submit"])) {
              $check = getimagesize($_FILES["file"]["tmp_name"][$i]);
              if($check !== false) {
                  //echo "File is an image - " . $check["mime"] . ".";
                  $uploadOk = 1;
              } else {
                  echo json_encode(array( 'type' => 'failed',
                      'message' => 'File is not an image.'
                  ));
                  $this->session->set_flashdata('error',"Sorry, your file ".$_FILES["file"]["name"][$i]." is not an image.");
                  $uploadOk = 0;
              }
          }
          // Check if file already exists
          if (file_exists($target_file)) {

              echo json_encode(array( 'type' => 'failed',
                  'message' => 'Sorry, file already exists.'
              ));

              $uploadOk = 0;
          }
          // Check file size
          if ($_FILES["file"]["size"][$i] > 5000000) {
              echo json_encode(array( 'type' => 'failed',
                  'message' => 'Sorry, your file is too large.'
              ));
              $this->session->set_flashdata('error',"Sorry, your file ".$_FILES["file"]["name"][$i]." is too large.");
              $uploadOk = 0;
          }
          // Allow certain file formats


          if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
              && $imageFileType != "gif" ) {

               json_encode(array( 'type' => 'failed',
                  'message' => 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.'
              ));
              $this->session->set_flashdata('error',"Sorry, your file ".$_FILES["file"]["name"][$i]." only JPG, JPEG, PNG & GIF files are allowed.");
              $uploadOk = 0;

          }
          // Check if $uploadOk is set to 0 by an error
          if ($uploadOk == 0) {
              //redirect(base_url()."admin-appointment/accountSetting");

              return false;
              // if everything is ok, try to upload file
          } else {
              if (move_uploaded_file($_FILES["file"]["tmp_name"][$i], $target_file)) {

                   $currentProviderImage = $this->Appointment_admin_model->getProviderImage($this->session->userdata("user_id"));

                   if($currentProviderImage[0]['image']){

                       $allImages = json_decode($currentProviderImage[0]['image']);

                       array_push($allImages,$target_file);

                       $this->db->set("image", json_encode($allImages));
                       $this->db->where('provider_id',$this->session->userdata('provider_id'));
                       $this->db->update('r_providers');

                   }else{

                       $target_file = json_encode(array($target_file));

                       $this->db->set("image", $target_file);
                       $this->db->where('provider_id',$this->session->userdata('provider_id'));
                       $this->db->update('r_providers');
                   }

              } else {
                  return false;
              }
          }
      }//For

        $this->session->set_flashdata('success', 'Image(s) uploaded successfully!');
        redirect(base_url()."admin-appointment/accountSetting");

    }

    public function changeCoverPic(){

        $cover =  $this->Appointment_admin_model->getCover();

        if($cover){
                $this->Appointment_admin_model->updateCover($this->input->post("coverPic"));
        }else{
                $this->Appointment_admin_model->setCover($this->input->post("coverPic"));
        }
    }

    public function removePic(){

        //$picName = "upload_file/images/1523586917-images.jpg";

        if($this->input->post("removePick")){

            $picName = $this->input->post("removePick");
            $this->db->select("*");
            $this->db->from('r_providers');
            $this->db->where("provider_id",$this->session->userdata('provider_id'));
            $query = $this->db->get();

            $data = $query->result_array();

            $imagesData = json_decode($data[0]['image']);

            if (($key = array_search($picName, $imagesData)) !== false) {
                unset($imagesData[$key]);
            }

            $this->db->set("image", json_encode(array_values($imagesData)));
            $this->db->where('provider_id',$this->session->userdata('provider_id'));
            $this->db->update('r_providers');
        }else{
            echo "error";
        }
    }

    public function test(){
        echo "worked";
    }

}