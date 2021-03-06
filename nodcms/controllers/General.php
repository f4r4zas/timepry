<?php

/**
 * Created by PhpStorm.
 * User: Mojtaba
 * Date: 9/6/2016
 * Time: 1:03 PM
 * Project: NodCMS
 * Website: http://www.nodcms.com
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class General extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    // Error 404 page
    function error404(){
        if(isset($_SESSION['language'])){
            $this->lang->load($_SESSION['language']['code'], $_SESSION['language']["language_name"]);
            $homeURL = base_url().$_SESSION['language']['code'];
        }else{
            $homeURL = base_url();
        }
        $this->data['title'] = _l('Error 404', $this);
        $this->data['heading'] = _l("Oops! You're lost.", $this);
        $this->data['message'] = _l("We can not find the page you're looking for.", $this);
        $this->data['message'] .= "<br><a href='$homeURL'>"._l("Return to Home", $this)."</a>";
        $this->load->view("errors/dynamic/error_404", $this->data);
    }
    
    
    function index(){
        if(isset($_SESSION['language'])){
            $this->lang->load($_SESSION['language']['code'], $_SESSION['language']["language_name"]);
            $homeURL = base_url().$_SESSION['language']['code'];
        }else{
            $homeURL = base_url();
        }
        
        
        
        $this->data['title'] = _l('Timepry', $this);
        $this->load->view("header", $this->data);
        $this->load->view("home", $this->data);
        $this->load->view("footer", $this->data);
    }
    
    function get_location_matrix(){

       $locationKey =  $this->input->post('company');
        $this-> db->select('*');
		$this->db->from('r_providers');
        $this->db->like('address',$locationKey);
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		$result = $query->result();
        $output = "";
        
        if(!empty($result)) {
        //$fetched = array();    
            $output .= '<ul class="amazetal_companies">';
        $fetched = array();
        foreach($result as $location) {
        
        $location_city = explode(",",$location->address);
        end($location_city);
        $location_city = prev($location_city);

            if (strpos(strtolower($location_city), strtolower($locationKey)) === FALSE) {
                continue;
            }

        if(!in_array($location_city,$fetched)):
                $output .= '<li class="fetched_companies" data-val="'.$location_city.'">'.$location_city.'</li>';
        $fetched[] = $location_city;
        endif;
        } 
            $output .= '</ul>';
            
        } else {
            
            //$output = "sdsa";
            $output .= '<ul id="beneficiary-list">';
                $output .= '<li onClick="selectbeneficiary(\'\',\'\');">No beneficiary found</li>';
            $output .= '</ul>';    
			
			$output = '<ul class="amazetal_companies"><li class="fetched_companies" value=0>Location not found</li></ul>';
			
			
        } 
        
        echo $output; 
    }
    
    
    function get_treatment_matrix(){
        
        $this-> db->select('*');
		$this->db->from('subcategory');
        $this->db->like('subcat_name', $this->input->post('company'));
		
		$query = $this->db->get();
		$result = $query->result();
		
        $output = "";
        
        if(!empty($result)) {
        //$fetched = array();    
            $output .= '<ul class="amazetal_companies">';
        $fetched = array();
        foreach($result as $location) {
        
        
        if(!in_array($location->subcat_name,$fetched)):
                $output .= '<li class="fetched_treats" value="'.$location->subcat_id.'" data-val="'.$location->subcat_name.'">'.$location->subcat_name.'</li>';
        $fetched[] = $location->subcat_name;
        endif;
        } 
            $output .= '</ul>';
            
        } else {
            
            $output = "";
        } 
        
        echo $output; 
    }
    
    
    function about_us(){
        if(isset($_SESSION['language'])){
            $this->lang->load($_SESSION['language']['code'], $_SESSION['language']["language_name"]);
            $homeURL = base_url().$_SESSION['language']['code'];
        }else{
            $homeURL = base_url();
        }
        
        
        
        $this->data['title'] = _l('Timepry', $this);
        $this->load->view("header", $this->data);
        $this->load->view("about", $this->data);
        $this->load->view("footer", $this->data);
    }
    
    
    function faq(){
        if(isset($_SESSION['language'])){
            $this->lang->load($_SESSION['language']['code'], $_SESSION['language']["language_name"]);
            $homeURL = base_url().$_SESSION['language']['code'];
        }else{
            $homeURL = base_url();
        }
        
        
        
        $this->data['title'] = _l('Timepry', $this);
        $this->load->view("header", $this->data);
        $this->load->view("faq", $this->data);
        $this->load->view("footer", $this->data);
    }
    
    
    function register(){
        if(isset($_SESSION['language'])){
            $this->lang->load($_SESSION['language']['code'], $_SESSION['language']["language_name"]);
            $homeURL = base_url().$_SESSION['language']['code'];
        }else{
            $homeURL = base_url();
        }
        
        
        
        $this->data['title'] = _l('Timepry', $this);
        $this->load->view("header", $this->data);
        $this->load->view("register", $this->data);
        $this->load->view("footer", $this->data);
    }
	
	
	function contact(){
		
		
	$this->load->library('email');

	$this->load->helper('email');
	$this->load->helper('form'); 
		
	if(isset($_SESSION['language'])){
		$this->lang->load($_SESSION['language']['code'], $_SESSION['language']["language_name"]);
		$homeURL = base_url().$_SESSION['language']['code'];
	}else{
		$homeURL = base_url();
	}
		
		// load form validation class
		$this->load->library('form_validation');
			// set form validation rules
		$this->form_validation->set_rules('name', 'From', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('subject', 'Subject', 'required');
		$this->form_validation->set_rules('text', 'Message', 'required');
    
	if ($this->form_validation->run() == FALSE){
			
			
			$this->data['title'] = _l('Timepry failed', $this);
			$this->load->view("header", $this->data);
			$this->load->view("reservation/contact", $this->data);
			$this->load->view("footer", $this->data);
			
	}else{
			// you can also load email library here
			// $this->load->library('email');
			// set email data
	    	
			$this->email->from($this->input->post('email'), $this->input->post('name'));
	    	$this->email->to('zeeshan4971@gmail.com');
	    	$this->email->reply_to($this->input->post('email'), $this->input->post('name'));
	    	$this->email->subject($this->input->post('subject'));
	    	$this->email->message($this->input->post('text'));
	    	$this->email->send();
			// create a view named "succes_view" and load it at the end
			$this->session->set_flashdata('message', 'Message send sucessfully you will be contacted soon.');
	    	$this->data['title'] = _l('Timepry success', $this);
			$this->load->view("header", $this->data);
			$this->load->view("reservation/contact", $this->data);
			$this->load->view("footer", $this->data);
		}  
	}
	
	function aboutus(){
		  if(isset($_SESSION['language'])){
            $this->lang->load($_SESSION['language']['code'], $_SESSION['language']["language_name"]);
            $homeURL = base_url().$_SESSION['language']['code'];
        }else{
            $homeURL = base_url();
        }
        
        $this->data['title'] = _l('Timepry', $this);
        $this->load->view("header", $this->data);
        $this->load->view("about", $this->data);
        $this->load->view("footer", $this->data);
	}
    
	 function globalDentists(){
        
        $this-> db->select('*');
		$this->db->from('r_providers');
        $this->db->like('provider_name', $this->input->post('provider'));
		$query = $this->db->get();
		$result = $query->result();
		
        $output = "";
        
        if(!empty($result)) {
        //$fetched = array();    
            $output .= '<ul class="amazetal_companies">';
        $fetched = array();
        foreach($result as $location) {
        
        if(!in_array($location->provider_name,$fetched)):
                $output .= '<li class="fetched_providers" value="'.$location->provider_id.'" data-val="'.$location->provider_name.'">'.$location->provider_name.'</li>';
        $fetched[] = $location->provider_name;
        endif;
        } 
            $output .= '</ul>';
            
        } else {
            
            $output = "";
        } 
        
        echo $output; 
    }

    function rightTreatment(){




        if(isset($_SESSION['language'])){
            $this->lang->load($_SESSION['language']['code'], $_SESSION['language']["language_name"]);
            $homeURL = base_url().$_SESSION['language']['code'];
        }else{
            $homeURL = base_url();
        }


        $this->data['subCats'] = $this->getAllTreatments();
        $this->data['title'] = _l('Timepry', $this);
        $this->load->view("header", $this->data);
        $this->load->view("right-treatment", $this->data);
        $this->load->view("footer", $this->data);
    }

    public function getAllTreatments(){

        $this->db->select("*");
        $this->db->from("subcategory");
        $query = $this->db->get();
        return $query->result_array();

    }

    public function checkout(){

        $this->data['subCats'] = $this->getAllTreatments();
        $this->data['title'] = _l('Timepry', $this);
        $this->load->view("header", $this->data);
        $this->load->view("checkout", $this->data);
        $this->load->view("footer", $this->data);
    }

    public function checkoutSession(){
        if($this->input->post()){
            $sessionData = $this->input->post("checkout");
            $provider = $this->input->post("provider_prefix");

            $this->session->set_userdata("checkout",$sessionData);
            $this->session->set_userdata("provider_prefix",$provider);
        }
    }

    public function checkoutSuccess(){


        $this->session->unset_userdata('checkout');
        $this->session->unset_userdata('provider_prefix');


        $message = array(
            'title'=>_l('Checkout successful!', $this),
            'body'=>_l('You do not need to do anything else. Your reservation is confirmed and you can directly go to the dental office. In case something will change the dental office will get in contact with you directly!', $this),
            'class'=>'alert alert-info'
        );

        $this->session->set_flashdata('message', $message);

        if($this->session->flashdata('message')){
            $message = $this->session->flashdata('message');
            $this->data['title'] = _l('User Registration', $this);
            $this->data['message_title'] = $message['title'];
            $this->data['message'] = $message['body'];
            $this->data['message_class'] = $message['class'];

            $this->load->view("header", $this->data);
            $this->load->view('registration/user_registration_message',$this->data);
            $this->load->view("footer", $this->data);

        }else{
            echo "df;ldsf";
            //redirect(base_url().$lang);
        }
    }

    public function stripe_card_token(){

        session_start();
// Store the received token string in a session variable
        if($_POST)
        {
            $_SESSION['token']=$_POST['stripeToken'];
            /*
             * curl https://api.stripe.com/v1/charges \
   -u sk_test_BQokikJOvBiI2HlWgH4olfQ2: \
   -d amount=999 \
   -d currency=usd \
   -d description="Example charge" \
   -d source=tok_visa \
   -d statement_descriptor="Custom descriptor"
             *
             */
        }

    }

    public function saveCheckout(){



        if(!empty($this->input->post("payment")) && $this->input->post("you")){
            print_r($this->input->post());
            $payment = $this->input->post("payment");
            $you = $this->input->post("you");

            $this->session->set_userdata('radioPayment',$payment);
            $this->session->set_userdata('radioYou',$you);
        }
    }

    public function sendpassword()
    {
        $this->load->library('email');
        $email = $_POST['email'];
        $query1=$this->db->query("SELECT *  from users where email = '".$email."'");
        $row=$query1->result_array();


        if ($query1->num_rows()>0){


            $data = array(
                'reset_pass_status' => 1
            );
            $this->db->where('user_id', $row[0]['user_id']);
            $this->db->update("users", $data);


            $resetLink =  base_url()."reset-pass/".$row[0]['reset_pass_exp'];

            $passwordplain = "";
            $passwordplain  = rand(999999999,9999999999);
            $newpass['password'] = md5($passwordplain);
            /*$this->db->where('email', $email);
            $this->db->update('users', $newpass);*/
            $mail_message='Dear '.$row[0]['first_name'].','. "\r\n";
            $mail_message.='Thanks for contacting regarding to forgot password,<br> You can reset password using this '.'<a href="'.$resetLink.'">Link</a>'.'</b>'."\r\n";
            $mail_message.='<br>Please Update your password.';
            $mail_message.='<br>Thanks & Regards';
            $mail_message.='<br>Timepry';


            $this->email->from('timepry@techopialabs.com', 'Timepry');
            $this->email->to($email);

            $this->email->subject('Password Reset');
            $this->email->message($mail_message);

            $this->email->send();

            //echo $mail_message;
            //mail($email,"Reset Password",$mail_message);

            $this->session->set_flashdata('message','Check email for password reset!');
            redirect(base_url().'change-password','refresh');

            //redirect(base_url().'user/Login','refresh');
        }
        else
        {
            $this->session->set_flashdata('message','Email not found try again!');
            redirect(base_url().'change-password','refresh');
        }
    }

    public function changePassword($reset_pass_exp){
        $query1=$this->db->query("SELECT *  from users where reset_pass_exp = '".$reset_pass_exp."'");

        $row=$query1->result_array();

        if ($query1->num_rows()>0){

            $resetStatus = $row[0]['reset_pass_status'];
            $userId = $row[0]['user_id'];

            if($resetStatus){
                //$this->load->
                //$this->data['title'] = _l('Reset Password', $this);
                $this->data['title'] = "Reset Password";
                $this->data['userId'] = $userId;
                $this->load->view("header", $this->data);
                $this->load->view("change_pass", $this->data);
                $this->load->view("footer", $this->data);
            }
        }
    }

    public function updatePassword(){

        if($this->input->post()){
            if($this->input->post("password_user_id")){
                $newPassword = $this->input->post("password");
                $this->db->where("user_id",$this->input->post("password_user_id"));
                $this->db->update("users",array('password'=>md5($newPassword)));
                $this->session->set_flashdata('message', 'Password reset successfully!!');

                redirect(base_url()."admin-sign");
            }
        }

    }

    public function resetPasswordForm(){
        $this->data['title'] = "Reset Password";
        $this->load->view("header", $this->data);
        $this->load->view("reset_password", $this->data);
        $this->load->view("footer", $this->data);
    }

    public function testMail(){
        
		    $this->load->library('email');
			
			$this->email->from('timepry@techopialabs.com', 'Timepry');
            $this->email->to("zeeshan4971@gmail.com");

            $this->email->subject('Password Reset');
            $this->email->message("Bla Bla");

            $this->email->send();
		
    }
}

