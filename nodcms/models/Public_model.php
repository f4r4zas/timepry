<?php
/**
 * Created by Mojtaba Khodakhah.
 * Date: 7/1/2016
 * Time: 11:28 AM
 * Project: NodCMS
 * Website: http://www.nodcms.com
 */


defined('BASEPATH') OR exit('No direct script access allowed');
class Public_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    // Select from "auto_email_message" for notification emails
    function getAutoMessages($key, $language_id="1"){
        $this->db->select("*");
        $this->db->where('code_key',$key);
        $this->db->where('language_id',$language_id);
        $this->db->from('auto_email_messages');
        $query = $this->db->get();
        $result = $query->result_array();
        return count($result)!=0?$result[0]:'';
    }
}