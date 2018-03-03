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
class Nodcms_general_admin extends NodCMS_Controller{
    function __construct(){
//        Load NodCMS_Controller construct
        parent::__construct();
    }

    function index()
    {
        $extension_count = $this->Nodcms_admin_model->count_extensions();
        $comment_count = $this->Nodcms_admin_model->count_comment();
        $this->data['languages'] = $this->Nodcms_admin_model->get_all_language();
        foreach($this->data['languages'] as &$item){
            $item["content_percent"] = $this->Nodcms_admin_model->count_extensions(array("language_id"=>$item["language_id"]))!=0?(($this->Nodcms_admin_model->count_extensions(array("language_id"=>$item["language_id"])) * 100) / $extension_count):0;
            $item["comment_percent"] = $this->Nodcms_admin_model->count_comment(array("lang"=>$item["code"]))!=0?(($this->Nodcms_admin_model->count_comment(array("lang"=>$item["code"])) * 100) / $comment_count):0;
        }
        $this->data['extension_count']=$extension_count;
//        The new statistic
        $this->data['statistic_max_visitors']=$this->Nodcms_admin_model->get_statistic_max_visitors();
        $this->data['statistic']=$this->Nodcms_admin_model->get_all_statistic();
        krsort($this->data['statistic']);
        $this->data['statistic_total_visits']=$this->Nodcms_admin_model->get_statistic_total_visits();
        $this->data['statistic_total_visitors']=$this->Nodcms_admin_model->get_statistic_total_visitors();

        $this->data['page_count']=$this->Nodcms_admin_model->count_page();
        $this->data['gallery_count']=$this->Nodcms_admin_model->count_gallery();
        $this->data['gallery_image_count']=$this->Nodcms_admin_model->count_gallery_image();
        $this->data['image_count']=$this->Nodcms_admin_model->count_uploaded_image();
        $this->data['users_count']=$this->Nodcms_admin_model->count_users();
        $this->data['content']=$this->load->view($this->mainTemplate.'/main',$this->data,true);
        $this->data['title'] = "home";
        $this->data['page'] = "home";
        $this->load->view($this->mainTemplate,$this->data);
    }
    function settings($sub_page='general'){
        if($this->input->input_stream('data')){
            if ($this->session->userdata['group']==1) {
                $data = $this->input->post('data');
                // Email templates and messages save
                if(isset($data["auto_messages"])){
                    foreach($data["auto_messages"] as $key=>$value){
                        $auto_emails = $this->config->item('autoEmailMessages');
                        foreach($auto_emails as $msg_key=>$msg_val){
                            if($this->Nodcms_admin_model->check_auto_messages($key,$msg_key)){
                                $this->Nodcms_admin_model->edit_auto_messages($key,$msg_key,$value[$msg_key]);
                            }else{
                                $this->Nodcms_admin_model->insert_auto_messages($key,$msg_key,$value[$msg_key]);
                            }
                        }
                    }
                    unset($data["auto_messages"]);
                }
                // Options in all languages save
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
                $this->session->set_flashdata('error', _l('This request is just fore real admin.',$this));
            }
            redirect(base_url().'admin/settings/'.$sub_page);
        }
        $data_options = array();
        $setting_options = $this->Nodcms_admin_model->get_all_setting_options();
        foreach($setting_options as $value){
            $data_options[$value["language_id"]] = $value;
        }
        $this->data['options'] = $data_options;
        $this->data['languages'] = $this->Nodcms_admin_model->get_all_language();

        if($sub_page=='general'){
            $this->data['page'] = "setting";
            $this->data['sub_title'] = _l('General settings',$this);
            $this->data['content']=$this->load->view($this->mainTemplate.'/setting',$this->data,true);
        }elseif($sub_page=='seo'){
            $this->data['page'] = "seo_setting";
            $this->data['sub_title'] = _l('SEO optimise',$this);
            $this->data['content']=$this->load->view($this->mainTemplate.'/setting_seo',$this->data,true);
        }elseif($sub_page=='contact'){
            $this->data['page'] = "contact_setting";
            $this->data['sub_title'] = _l('Contact settings',$this);
            $this->data['content']=$this->load->view($this->mainTemplate.'/setting_contact',$this->data,true);
        }elseif($sub_page=='date-and-time'){
            $this->data['date_format'] = array(
                array("format"=>"d.m.Y", "name"=>"dd.mm.yy"),
                array("format"=>"m/d/Y", "name"=>"mm/dd/yy"),
                array("format"=>"Y-m-d", "name"=>"yy-mm-dd"),
            );
            $this->data['time_format'] = array(
                array("format"=>"H:i", "name"=>"24"),
                array("format"=>"h:i A", "name"=>"12"),
            );
            $this->data['page'] = "date_setting";
            $this->data['sub_title'] = _l('Date and time settings',$this);
            $this->data['content']=$this->load->view($this->mainTemplate.'/setting_datetime',$this->data,true);
        }elseif($sub_page=='mail'){
            $this->data['page'] = "mail_setting";
            $this->data['auto_emails'] = $this->config->item('autoEmailMessages');
            $auto_messages_data = array();
            foreach($this->data['auto_emails'] as $key=>$val){
                $autoMsgData = $this->Nodcms_admin_model->get_all_auto_messages($key);
                foreach($autoMsgData as $value){
                    $auto_messages_data[$value["language_id"]][$key] = $value;
                }
            }
            $this->data['auto_messages_data'] = $auto_messages_data;

            $this->data['sub_title'] = _l('Send mail settings',$this);
            $this->data['content']=$this->load->view($this->mainTemplate.'/setting_mail',$this->data,true);
        }
        $this->data['title'] = _l('Settings',$this);
        $this->data['breadcrumb'] = array(array('title'=>$this->data['title']),array('title'=>$this->data['sub_title']));
        $this->load->view($this->mainTemplate,$this->data);
    }

    function menu(){
        $this->data['title'] = _l("Menu Manager", $this);
        $this->data['sub_title'] = _l("Menu List", $this);
        $this->data['data_list'] = $this->Nodcms_admin_model->get_all_menu(array('sub_menu'=>0));
        foreach($this->data['data_list'] as &$item){
            $item['sub_menu_data'] = $this->Nodcms_admin_model->get_all_menu(array('sub_menu'=>$item['menu_id']));
        }
        $this->data['breadcrumb']=array(
            array('title'=>_l('Menu',$this)),
        );
        $this->data['page'] = "menu";
        $this->data['content']=$this->load->view($this->mainTemplate.'/menu',$this->data,true);
        $this->load->view($this->frameTemplate,$this->data);
    }
    function editmenu($id=0)
    {
        if($this->input->input_stream('data')){
            if ($this->session->userdata['group']==1) {
                $data = $this->input->post('data',TRUE);
                $this->Nodcms_admin_model->edit_setting($data);
                $this->session->set_flashdata('success', _l("Your Setting has been updated successfully!",$this));
            }else{
                $this->session->set_flashdata('error', _l('This request is just fore real admin.',$this));
            }
            redirect(base_url().'admin/admin_setting', 'refresh');
        }
        if($id!='')
        {
            $this->data['data']=$this->Nodcms_admin_model->get_menu_detail($id);
            if($this->data['data']==null)
                redirect(base_url()."admin/editmenu");
            $this->data["form_title"] = _l("Edit Item", $this);
        }else{
            $this->data["form_title"] = _l("Insert New Item", $this);
        }
        $titles = array();
        $data_titles = $this->Nodcms_admin_model->get_all_titles("menu",$id);
        if(count($data_titles)!=0){
            foreach ($data_titles as $value) {
                $titles[$value["language_id"]] = $value;
            }
            $this->data['sub_title'] = _l("Edit Item", $this);
        }else{
            $this->data['sub_title'] = _l("Add New Item", $this);
        }
        $this->load->library('spyc');
        $icons = spyc_load_file(getcwd()."/icons.yml");
        $this->data['faicons'] = $icons["fa"];

        $this->data['parents'] = $this->Nodcms_admin_model->get_all_menu(array('sub_menu'=>0));
        $this->data['pages'] = $this->Nodcms_admin_model->get_all_page();
        $this->data['languages'] = $this->Nodcms_admin_model->get_all_language();
        $this->data['title'] = _l("Menu Manager", $this);
        $this->data['breadcrumb']=array(
            array('title'=>_l('Menu',$this),'url'=>ADMIN_URL.'menu'),
            array('title'=>$this->data['sub_title'])
        );
        $this->data['page'] = "menu_edit";
        $this->data['content']=$this->load->view($this->mainTemplate.'/menu_edit',$this->data,true);
        $this->load->view($this->frameTemplate,$this->data);
    }
    function menu_manipulate($id=null)
    {
        if ($this->session->userdata['group']==1) {
            if ($this->Nodcms_admin_model->menu_manipulate($this->input->post('data',TRUE),$id))
            {
                $this->session->set_flashdata('success', _l('Updated menu',$this));
            }
            else
            {
                $this->session->set_flashdata('error', _l('Updated menu error. Please try later',$this));
            }
        }else{
            $this->session->set_flashdata('error', _l('This request is just fore real admin.',$this));
        }
        redirect(base_url()."admin/menu/");
    }
    function deletemenu($id=0)
    {
        if ($this->session->userdata['group']==1) {
            $this->db->trans_start();
            $this->db->delete('menu', array('menu_id' => $id));
            $this->db->trans_complete();
            $this->session->set_flashdata('success', _l('Deleted Menu',$this));
        }else{
            $this->session->set_flashdata('error', _l('This request is just fore real admin.',$this));
        }
        redirect(base_url()."admin/editmenu/");
    }

    function language()
    {
        $this->data['data_list']=$this->Nodcms_admin_model->get_all_language();
        $this->data['title'] = _l("language",$this);
        $this->data['page'] = "language";
        $this->data['content']=$this->load->view($this->mainTemplate.'/language',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }
    function editlanguage($id='')
    {
        if($id!='')
        {
            $this->data['data']=$this->Nodcms_admin_model->get_language_detail($id);
            if($this->data['data']==null)
                redirect(base_url()."admin/language");
        }
        $this->data['title'] = _l("language",$this);
        $this->data['page'] = "language";
        $this->data['content']=$this->load->view($this->mainTemplate.'/language_edit',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }
    function language_manipulate($id=null)
    {
        if ($this->session->userdata['group']==1) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('data[language_name]', _l('Language Name',$this), 'required|callback_validateUsernameType');
            $this->form_validation->set_rules('data[code]', _l('Language Code',$this), 'required|exact_length[2]|alpha');
            if ($this->form_validation->run() != TRUE){
                $this->session->set_flashdata('static_error', validation_errors());
                redirect(base_url()."admin/editlanguage/".$id);
            }else{
                $post_data = $this->input->post('data',TRUE);
                if ($this->Nodcms_admin_model->language_manipulate($post_data,$id)){
                    $dir = getcwd().'/nodcms/language/'.$post_data['language_name'].'/';
                    $file = $dir.$post_data['code'].'_lang.php';
                    if(!file_exists($dir)){
                        mkdir($dir);
                    }
                    if(!file_exists($file)){
                        $myfile = fopen($file, "w") or die("Unable to open file!");
                        $txt = "<?php\n";
                        fwrite($myfile, $txt);
                        fclose($myfile);
                    }
                    $file = $dir.'backend_lang.php';
                    if(!file_exists($file)){
                        $myfile = fopen($file, "w") or die("Unable to open file!");
                        $txt = "<?php\n";
                        fwrite($myfile, $txt);
                        fclose($myfile);
                    }
                    $this->session->set_flashdata('success', _l('Updated Language',$this));
                }else{
                    $this->session->set_flashdata('error', _l('Updated Language error. Please try later',$this));
                }
            }
        }else{
            $this->session->set_flashdata('error', _l('This request is just fore real admin.',$this));
        }
        redirect(base_url()."admin/language/");
    }
    function deletelanguage($id=0)
    {
        if ($this->session->userdata['group']==1) {
            $this->db->trans_start();
            $this->db->delete('languages', array('language_id' => $id));
            $this->db->trans_complete();
            $this->session->set_flashdata('success', _l('Deleted Language',$this));
        }else{
            $this->session->set_flashdata('error', _l('This request is just fore real admin.',$this));
        }
        redirect(base_url()."admin/language/");
    }
    function edit_lang_file($id,$file_name)
    {
        $this->data['data']=$this->Nodcms_admin_model->get_language_detail($id);
        if($this->data['data']==null || !file_exists(getcwd().'/nodcms/language/'.$this->data['data']['language_name'].'/'.$file_name.'_lang.php')){
            $this->session->set_flashdata('error', _l('URL-Request was not exists!',$this));
            redirect(base_url()."admin/language");
        }
        $this->load->library('Get_lang_in_array');
        $CI = new Get_lang_in_array();
        $this->data['lang_list'] = $CI->load($file_name,$this->data['data']['language_name']);
        if(count($this->data['lang_list'])==0){
            $defaultLangFileName = strlen($file_name)==2?$_SESSION['language']['code']:$file_name;
            $this->data['lang_list'] = $CI->load($defaultLangFileName,$_SESSION['language']['language_name']);
        }
        if($this->input->input_stream('data')){
            if ($this->session->userdata['group']==1) {
                $post_data = $this->input->post('data');
                $i=0;
                $fileContent = "<?php\n";
                foreach ($this->data['lang_list'] as $key=>&$val) {
                    $fileContent .= '$lang["'.$key.'"] = "'.$post_data[$i].'";'."\n";
                    $val = $post_data[$i];
                    $i++;
                }
                $file = getcwd().'/nodcms/language/'.$this->data['data']['language_name'].'/'.$file_name.'_lang.php';
                if(file_exists($file)){
                    file_put_contents($file, $fileContent);
                }
                $this->session->set_flashdata('success', _l('Edit language file successfully!',$this));
                redirect(base_url()."admin/edit_lang_file/".$id.'/'.$file_name);
            }else{
                $this->session->set_flashdata('error', _l('This request is just fore real admin.',$this));
                redirect(base_url()."admin/language");
            }
        }
        $this->data['file_name'] = $file_name;
        $this->data['languages']=$this->Nodcms_admin_model->get_all_language();
        $this->data['title'] = _l("Edit language file",$this);
        $this->data['page'] = "edit lang file";
        $this->data['content']=$this->load->view($this->mainTemplate.'/language_edit_file',$this->data,true);
        $this->load->view($this->frameTemplate,$this->data);
    }

    function user()
    {
        if($this->session->userdata['group']!=1){
            $this->session->set_flashdata('error', _l('This request is just fore real admin.',$this));
            redirect(base_url()."admin/");
        }
        $this->data['data_list']=$this->Nodcms_admin_model->get_all_user();
        $this->data['title'] = _l("Users",$this);
        $this->data['sub_title'] = _l("User's list",$this);
        $this->data['page'] = "user";
        $this->data['content']=$this->load->view($this->mainTemplate.'/user',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }
    function edituser($id=''){
        if($this->session->userdata['group']!=1){
            $this->session->set_flashdata('error', _l('This request is just fore real admin.',$this));
            redirect(base_url()."admin/");
        }
        if($id!=''){
            $this->data['data']=$this->Nodcms_admin_model->get_user_detail($id);
            if($this->data['data']==null)
                redirect(base_url()."admin/user");
            $this->data['sub_title'] = _l("Edit a user",$this);
        }else{
            $this->data['sub_title'] = _l("Add new user",$this);
        }
        $this->data['languages'] = $this->Nodcms_admin_model->get_all_language();
        $this->data['groups']=$this->Nodcms_admin_model->get_all_groups();
        $this->data['title'] = _l("Users",$this);
        $this->data['page'] = "user";
        $this->data['content']=$this->load->view($this->mainTemplate.'/user_edit',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }
    function user_manipulate($id=null){
        if ($this->session->userdata['group']==1) {
            $data_post = $this->input->post('data',TRUE);
            $data_post["fullname"] = $data_post["firstname"]." ".$data_post["lastname"];
            if ($this->Nodcms_admin_model->user_manipulate($data_post,$id)) {
                $this->session->set_flashdata('success', _l('Updated user',$this));
            }else{
                $this->session->set_flashdata('error', _l('Updated user error. Please try later',$this));
            }
        }else{
            $this->session->set_flashdata('error', _l('This request is just fore real admin.',$this));
            redirect(base_url()."admin/");
        }
        redirect(base_url()."admin/user/");
    }
    function deleteuser($id=0,$status=0)
    {
        if ($this->session->userdata['group']==1) {
            $this->db->trans_start();
            $this->db->where('user_id',$id);
            $this->db->update('users', array('status' => $status));
            $this->db->trans_complete();
            $this->session->set_flashdata('success', _l('Deleted user',$this));
        }
        redirect(base_url()."admin/user/");
    }

    function upload_image($type=null,$data_type=null,$relation_id=null,$gallery_id=null){
        if ($this->session->userdata['group']==1) {
            if($type==null){
                echo json_encode(array("status"=>"error","errors"=>"empty"));
            }elseif($type==1){
                $folder = "logo/";
                $config['upload_path'] ='upload_file/'.$folder;
                $config['allowed_types'] = 'gif|jpg|png';
                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload("file"))
                {
                    echo json_encode(array("status"=>"error","errors"=>$this->upload->display_errors('<p>', '</p>')));
                }
                else
                {
                    $data = $this->upload->data();
                    $data_image = array(
                        "image"=>$config['upload_path'].$data["file_name"],
                        "width"=>$data["image_width"],
                        "height"=>$data["image_height"],
                        "name"=>$data["file_name"],
                        "root"=>$config["upload_path"],
                        "folder"=>$folder,
                        "size"=>$data["file_size"]
                    );
                    $getid = $this->Nodcms_admin_model->insert_image($data_image);
                    if($getid!=0){
                        echo json_encode(array("status"=>"success","file_patch"=>$config['upload_path'].$data["file_name"],"file_url"=>base_url().$config['upload_path'].$data["file_name"]));
                    }else{
                        unlink(getcwd()."/".$data_image["image"]);
                        echo json_encode(array("status"=>"error","errors"=>_l("Data Set error 1!",$this)));
                    }
                }
            }elseif($type==2){
                $folder = "lang/";
                $config['upload_path'] ='upload_file/'.$folder;
                $config['allowed_types'] = 'gif|jpg|png';

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload("file"))
                {
                    echo json_encode(array("status"=>"error","errors"=>$this->upload->display_errors('<p>', '</p>')));
                }
                else
                {
                    $data = $this->upload->data();
                    $data_image = array(
                        "image"=>$config['upload_path'].$data["file_name"],
                        "width"=>$data["image_width"],
                        "height"=>$data["image_height"],
                        "name"=>$data["file_name"],
                        "root"=>$config['upload_path'],
                        "folder"=>$folder,
                        "size"=>$data["file_size"]
                    );
                    $getid = $this->Nodcms_admin_model->insert_image($data_image);
                    if($getid!=0){
                        echo json_encode(array("status"=>"success","file_patch"=>$config['upload_path'].$data["file_name"],"file_url"=>base_url().$config['upload_path'].$data["file_name"]));
                    }else{
                        unlink(getcwd()."/".$data_image["image"]);
                        echo json_encode(array("status"=>"error","errors"=>_l("Data Set error 2!",$this)));
                    }
                }
            }elseif($type=="10" && $data_type!=null && $relation_id!=null && is_numeric($relation_id) && $gallery_id!=null && is_numeric($gallery_id)){
                $accept_type = array("city","tours","page");
                if(in_array($data_type,$accept_type)){
                    $folder = "images/";
                    $config['upload_path'] ='upload_file/'.$folder;
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['encrypt_name'] = true;

                    $this->load->library('upload', $config);

                    if ( ! $this->upload->do_upload("file"))
                    {
                        echo json_encode(array("status"=>"error","errors"=>$this->upload->display_errors('<p>', '</p>')));
                    }
                    else
                    {
                        $data = $this->upload->data();
                        $data_gallery = array(
                            "gallery_id"=>$gallery_id,
                            "relation_id"=>$relation_id,
                            "data_type"=>$data_type,
                            "image"=>$config['upload_path'].$data["file_name"],
                            "width"=>$data["image_width"],
                            "height"=>$data["image_height"],
                            "name"=>$data["file_name"],
                            "size"=>$data["file_size"]
                        );
                        $getid = $this->Nodcms_admin_model->get_insert_gallery_image($data_gallery);
                        if($getid!=0){
                            echo json_encode(array("status"=>"success","getid"=>$getid,"file_patch"=>$config['upload_path'].$data["file_name"],"file_url"=>base_url().$config['upload_path'].$data["file_name"]));
                        }else{
                            echo json_encode(array("status"=>"error","errors"=>_l("System problem!",$this)));
                        }
                    }
                }else{
                    echo json_encode(array("status"=>"error","errors"=>_l('Your request is problem!',$this)));
                }
            }elseif($type=="20"){
                $folder = "images20/";
                $config['upload_path'] ='upload_file/'.$folder;
                $config['allowed_types'] = 'gif|jpg|png';
                $config['encrypt_name'] = true;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload("file"))
                {
                    echo json_encode(array("status"=>"error","errors"=>$this->upload->display_errors('<p>', '</p>')));
                }
                else
                {
                    $data = $this->upload->data();
                    $data_image = array(
                        "image"=>$config['upload_path'].$data["file_name"],
                        "width"=>$data["image_width"],
                        "height"=>$data["image_height"],
                        "name"=>$data["file_name"],
                        "root"=>$config["upload_path"],
                        "folder"=>$folder,
                        "size"=>$data["file_size"]
                    );
                    $getid = $this->Nodcms_admin_model->insert_image($data_image);
                    if($getid!=0){
                        echo json_encode(array("status"=>"success","file_patch"=>$config['upload_path'].$data["file_name"],"file_url"=>base_url().$config['upload_path'].$data["file_name"]));
                    }else{
                        unlink(getcwd()."/".$data_image["image"]);
                        echo json_encode(array("status"=>"error","errors"=>_l("Data Set error 10!",$this)));
                    }
                }
            }else{
                echo json_encode(array("status"=>"error","errors"=>_l('Cannot find url!',$this)));
            }
        }else{
            echo json_encode(array("status"=>"error","errors"=>_l('This request just for real admin!',$this)));
        }
    }
}
