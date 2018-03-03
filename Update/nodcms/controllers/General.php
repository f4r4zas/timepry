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
}