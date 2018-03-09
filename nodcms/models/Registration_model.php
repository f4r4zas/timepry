<?php
/**
 * Created by Mojtaba Khodakhah.
 * Date: 7/1/2016
 * Time: 11:28 AM
 * Project: NodCMS
 * Website: http://www.nodcms.com
 */


defined('BASEPATH') OR exit('No direct script access allowed');
class Registration_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    // Check unique username in "users" table
    function userUniqueUsername($text){
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('username', $text);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?FALSE:TRUE;
    }

    // Check unique email in "users" table
    function userUniqueEmail($text){
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('email', $text);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?FALSE:TRUE;
    }

    // Insert to "users" table
    function insertUser($data){
		$user_id =	$this->db->insert('users',$data);
		
		if($user_id){
			return $user_id;
		}else{
			return false;
		}
		
    }

    // Select a row from "users" table
    function getUserByEmailHashAndActiveCode($email_hash,$active_code)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('email_hash',$email_hash);
        $this->db->where('active_code',$active_code);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:0;
    }

    // Update a user after click on activate code
    function activeUser($id){
        $this->db->set('status', 1);
        $this->db->set('active_register', 1);
        $this->db->where('user_id', $id);
        $this->db->update('users');
    }

}