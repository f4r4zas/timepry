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
class Nodcms_admin_sign extends CI_Controller {
    public $data;
    function __construct(){
        parent::__construct();
        $this->load->model("Nodcms_admin_model");
        $this->load->model("NodCMS_admin_sign_model");
        $banner = @reset($this->Nodcms_admin_model->get_website_info());
        $_SESSION['language'] = $language = $this->Nodcms_admin_model->get_language_detail($banner["language_id"]);
        $this->lang->load($language["code"], $language["language_name"]);
        $this->data['setting'] = $banner;
    }
    function index(){
        if ($this->session->userdata('logged_in_status') == TRUE){
            redirect('/admin-appointment');
        }else{
            $this->load->view('nodcms_admin_login',$this->data);
        }
    }
    function login(){
        $username = $this->input->post('username', TRUE);//$this->security->xss_clean($this->input->post('username', TRUE));
        $password = md5($this->input->post('password', TRUE));
        $result = $this->NodCMS_admin_sign_model->check_login($username, $password);


        if(count($result)!=0 && in_array($result[0]['group_id'], array(1, 20, 21, 100, 101))){
            $result = reset($result);
            $data = array(
                'fullname'  => $result['firstname']." ".$result['firstname'],
                'username'  => $result['username'],
                'firstname'  => $result['firstname'],
                'user_id' => $result['user_id'],
                'group'   => $result['group_id'],
                'avatar'   => $result['avatar'],
                'email'   => $result['email'],
                'logged_in_status'   => true,

            );

            $this->session->set_userdata($data);
            $_SESSION['Session_Admin'] = $data['user_id'];
            redirect(base_url().'admin-appointment');
        }else{
            $this->session->set_flashdata('message', _l('Oopsie, Username or password is incorrect',$this));
            redirect(base_url().'admin-sign');
        }
    }
    function logout(){
        $this->session->unset_userdata('fullname');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('group');
        $this->session->unset_userdata('avatar');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('logged_in_status');
        redirect(base_url().'admin-sign');
    }
}