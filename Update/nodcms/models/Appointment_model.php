<?php
/**
 * Created by PhpStorm.
 * User: Mojtaba
 * Date: 9/15/2015
 * Time: 11:19 PM
 * Project: NodCMS
 * Website: http://www.nodcms.com
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Appointment_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    // select from r_time_period
    function getTimePeriod($day_no,$service_id=null,$selectMin=null){
        $this->db->select("*");
        $this->db->from('r_time_period');
        $this->db->where('day_no',"$day_no");
        if($service_id!=null) $this->db->where('service_id',$service_id);
        if($selectMin!=null){
            $this->db->where('period_start_time <= "'.$selectMin.'"');
            $this->db->where('period_end_time > "'.$selectMin.'"');
        }
        $this->db->order_by('period_start_time',"ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    function checkExistsTimePeriod($day_no,$service_id,$startMin,$endMin,$period_id=null)
    {
        $this->db->select("count(*)");
        $this->db->from('r_time_period');
        $this->db->where('day_no',"$day_no");
        $this->db->where('service_id',$service_id);
        if($period_id!=null) $this->db->where('period_id <> '.$period_id);
        $this->db->where('((period_start_time > "'.$startMin.'" AND period_start_time < "'.$endMin.'") OR (period_start_time <= "'.$startMin.'" AND period_end_time > "'.$startMin.'"))');
        $query = $this->db->get();
        $result = $query->result_array();
        return count($result)!=0?$result[0]["count(*)"]:0;
    }

    function getAllFreeDays()
    {
        $this->db->select("*");
        $this->db->from('r_free_dates');
        $this->db->where('provider_id',$this->provider['provider_id']);
        $this->db->order_by('created_date',"DESC");
        $query = $this->db->get();
        return $query->result_array();
    }

    function checkFreeDate($date,$service_id)
    {
        $this->db->select("count(*)");
        $this->db->from('r_free_dates');
        $this->db->where('provider_id',$this->provider['provider_id']);
        $this->db->where('service_id',$service_id);
        $this->db->where('free_date',$date);
        $this->db->order_by('created_date',"DESC");
        $query = $this->db->get();
        $result = $query->result_array();
        return count($result)!=0?$result[0]["count(*)"]:0;
    }

    function getAllServices()
    {
        $this->db->select("*,r_services.image");
        $this->db->from('r_services');
//        $this->db->join('extensions','extensions.relation_id = service_id');
        $this->db->where('provider_id', $this->provider['provider_id']);
//        $this->db->where('extensions.data_type','r_services');
//        $this->db->where('extensions.language_id',$_SESSION['language']['language_id']);
//        $this->db->where('extensions.status',1);
        $this->db->where('r_services.public',1);
        $query = $this->db->get();
        return $query->result_array();
    }

    function getServiceDetail($id)
    {
        $this->db->select("*");
        $this->db->from('r_services');
        $this->db->where('provider_id',$this->provider['provider_id']);
        $this->db->where('service_id',$id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function getPreServiceDetail($id)
    {
        $this->db->select("*");
        $this->db->from('r_services');
        $this->db->where('service_id',$id);
        $query = $this->db->get();
        return $query->result_array();
    }

    // check for exists an appointment in a time range
    function checkReservation($service_id,$start_time,$end_time)
    {
        $this->db->select("count(*)");
        $this->db->from('r_reservation');
        $this->db->where('provider_id',$this->provider['provider_id']);
        $this->db->where('((reservation_edate_time > "'.$start_time.'"  AND reservation_edate_time <= "'.$end_time.'") OR (reservation_date_time >= "'.$start_time.'" AND reservation_date_time < "'.$end_time.'"))');
        $this->db->where('service_id',$service_id);
        $this->db->where('trash','0');
        $query = $this->db->get();
        $result = $query->result_array();
        return count($result)!=0?$result[0]["count(*)"]:0;
    }

    // Count of appointments in a time
    function countReservation($service_id,$date)
    {
        $this->db->select("count(*)");
        $this->db->from('r_reservation');
        $this->db->where('provider_id',$this->provider['provider_id']);
        $this->db->where('service_id',$service_id);
        $this->db->where('reservation_date_time',$date);
        $this->db->where('trash','0');
        $query = $this->db->get();
        $result = $query->result_array();
        return count($result)!=0?$result[0]["count(*)"]:0;
    }

    // Check for exists appointment with optional conditions
    function reservationExists($conditions=null)
    {
        $this->db->select("*");
        $this->db->from('r_reservation');
        $this->db->where('provider_id',$this->provider['provider_id']);
        if($conditions!=null) $this->db->where($conditions);
        $this->db->where('reservation_date >= "'.time().'"');
        $this->db->where('trash','0');
        $query = $this->db->get();
        $result = $query->result_array();
        return count($result)!=0?1:0;
    }

    function getReservationDetail($id)
    {
        $this->db->select("*");
        $this->db->from('r_reservation');
        $this->db->where('provider_id',$this->provider['provider_id']);
        $this->db->where('reservation_id',$id);
        $this->db->where('trash','0');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Select a record from r_pre_reservation
    function getPreReservationDetail($id)
    {
        $this->db->select("*, r_pre_reservation.created_date");
        $this->db->from('r_pre_reservation');
        $this->db->join('r_providers', 'r_pre_reservation.provider_id = r_providers.provider_id');
//        $this->db->where('provider_id',$this->provider['provider_id']);
        $this->db->where('reservation_id',$id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function checkFullReservationDate($service_id,$day_no,$times)
    {
        $this->db->select("reservation_date,((reservation_date_time - reservation_date)/60) as test,count(*) as reservation_count");
        $this->db->from('r_reservation');
        $this->db->where('provider_id',$this->provider['provider_id']);
        $this->db->where('service_id',$service_id);
        $this->db->where('reservation_day_no',$day_no);
        $this->db->where('trash','0');
        $this->db->where('reservation_date >= "'.time().'"');
        if($times!="") $this->db->where('((reservation_date_time - reservation_date)/60) in ('.$times.')');
        $this->db->group_by('reservation_date_time');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Add a new appointment
    function addToReservation($data)
    {
        $data["created_date"]=time();
        $data["provider_id"]=$this->provider['provider_id'];
        $this->db->insert('r_reservation',$data);
        return $this->db->insert_id();
    }

    // Add a new pre-appointment
    function addToPreReservation($data)
    {
        $data["created_date"]=time();
        $data["provider_id"]=$this->provider['provider_id'];
        $this->db->insert('r_pre_reservation',$data);
        return $this->db->insert_id();
    }

    function getAllExtraFields()
    {
        $this->db->select("*");
        $this->db->from('r_extra_fields');
        $this->db->join('titles','titles.relation_id = id');
        $this->db->join('r_field_type','type_id = field_type');
        $this->db->where('provider_id', $this->provider['provider_id']);
        $this->db->where('titles.data_type','r_extra_fields');
        $this->db->where('titles.language_id',$_SESSION['language']['language_id']);
        $query = $this->db->get();
        return $query->result_array();
    }

    function addExtraFieldValue($reservation_id,$field_name,$value)
    {
        $data = array(
            'reservation_id'=>$reservation_id,
            'field_name'=>$field_name,
            'value'=>$value
        );
        $this->db->insert('r_extra_fields_value',$data);
        return $this->db->insert_id();
    }

    function addPreExtraFieldValue($reservation_id,$field_name,$value)
    {
        $data = array(
            'reservation_id'=>$reservation_id,
            'field_name'=>$field_name,
            'value'=>$value
        );
        $this->db->insert('r_pre_extra_fields_value',$data);
        return $this->db->insert_id();
    }

    // Select a row from "r_providers" table
    function getProviderByUsername($username){
        $this->db->select("*");
        $this->db->from('r_providers');
        $this->db->where('provider_username',$username);
        $this->db->where('active',1);
        $query = $this->db->get();
        return $query->result_array();
    }

    // Select a row from "r_providers" table
    function getProviderById($id){
        $this->db->select("*");
        $this->db->from('r_providers');
        $this->db->where('provider_id',$id);
        $this->db->where('active',1);
        $query = $this->db->get();
        return $query->result_array();
    }

    // Select a list from "r_providers" table
    function getAllProvider($conditions = NULL, $limit = NULL, $offset = NULL){
        $this->db->select("*");
        $this->db->from('r_providers');
//        $this->db->join('extensions', 'relation_id = provider_id');
//        $this->db->where('language_id',$_SESSION["language"]['language_id']);
//        $this->db->where('data_type','r_providers');

        if($conditions!=NULL) $this->db->where($conditions);
        $this->db->where('active',1);
        if($limit!=NULL) $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result_array();
    }

    // Select a list from "r_providers" table
    function countProvider($conditions = NULL){
        $this->db->select("count(*)");
        $this->db->from('r_providers');
        if($conditions!=NULL) $this->db->where($conditions);
        $this->db->where('active',1);
        $query = $this->db->get();
        $result = $query->result_array();
        return count($result!=0)?$result[0]["count(*)"]:0;
    }

    // Get related provider's extension in current language
    function getProviderExtensions($provider_id, $conditions = NULL){
        $this->db->select("*");
        $this->db->from('extensions');
        if($conditions!=NULL) $this->db->where($conditions);
        $this->db->where('language_id',$_SESSION["language"]['language_id']);
        $this->db->where('data_type','r_providers');
        $this->db->where('relation_id',$provider_id);
        $this->db->where('status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get related service's extension in current language
    function getServiceExtensions($service_id, $conditions = NULL){
        $this->db->select("*");
        $this->db->from('extensions');
        if($conditions!=NULL) $this->db->where($conditions);
        $this->db->where('language_id',$_SESSION["language"]['language_id']);
        $this->db->where('data_type','r_services');
        $this->db->where('relation_id',$service_id);
        $this->db->where('status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    // Move records from r_pre_registration to r_registration and r_pre_extra_fields_value to r_extra_fields_value
    function movePreAppointment($id){
        // Copy from r_pre_reservation to r_reservation
        $query_code = "INSERT INTO r_reservation" .
            " (pre_reservation_id, owner_user_id, provider_id, service_id, reservation_day_no, reservation_date, reservation_date_time, reservation_edate_time, language_id, lang, price, service_name, reservation_number, email, tel, fname, lname, paypal_paid)" .
            " SELECT" .
            " $id, r_pre_reservation.owner_user_id, r_pre_reservation.provider_id, r_pre_reservation.service_id, r_pre_reservation.reservation_day_no, r_pre_reservation.reservation_date, r_pre_reservation.reservation_date_time, r_pre_reservation.reservation_edate_time, r_pre_reservation.language_id, r_pre_reservation.lang, r_pre_reservation.price, r_pre_reservation.service_name, r_pre_reservation.reservation_number, r_pre_reservation.email, r_pre_reservation.tel, r_pre_reservation.fname, r_pre_reservation.lname, '1'" .
            " FROM r_pre_reservation WHERE r_pre_reservation.reservation_id = '$id'";
        $this->db->query($query_code);
        $reservation_id = $this->db->insert_id();
        // Copy from r_pre_extra_fields_value to r_extra_fields_value
        $query_code = "INSERT INTO r_extra_fields_value" .
            " (field_name, value, reservation_id)" .
            " SELECT r_pre_extra_fields_value.field_name, r_pre_extra_fields_value.value, $reservation_id FROM r_pre_extra_fields_value " .
            "WHERE r_pre_extra_fields_value.reservation_id = '$id'";
        $this->db->query($query_code);
        $update_data = array("related_reservation_id"=>$reservation_id);
        $conditions = array("reservation_id"=>$id);
        $this->db->update("r_pre_reservation", $update_data, $conditions);
        return $reservation_id;
    }

    // Delete records from r_pre_registration and r_pre_extra_fields_value
    function removePreAppointment($id){
        // Delete from r_pre_reservation
        $query_code = "DELETE FROM r_pre_reservation WHERE reservation_id = '$id'";
        $this->db->query($query_code);
        // DELETE from r_pre_extra_fields_value
        $query_code = "DELETE FROM r_pre_extra_fields_value WHERE reservation_id = '$id'";
        $this->db->query($query_code);
    }

    // Update paid field in r_reservation
    function updateAppointmentPaid($id){
        $this->db->set("paid", 1);
        $this->db->set("paypal_paid", 1);
        $this->db->where("reservation_id", $id);
        $this->db->insert("r_reservation");
    }

    // Add a record in r_paypal_payments
    function addPaypalPaid($data){
        $data["created_date"] = time();
        $this->db->insert("r_paypal_payments", $data);
    }

    // Add a record in r_paypal_payments
    function getPaypalPaid($id, $conditions){
        $this->db->select("*");
        $this->db->from('r_services');
        if($conditions!=NULL) $this->db->where($conditions);
        $this->db->where('provider_id', $this->provider['provider_id']);
        $this->db->where('reservation_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    // Select a list from "r_provider_admins" table
    function getProviderManagers($id = NULL, $conditions=NULL){
        $this->db->select("*, r_provider_admins.user_id, users.email");
        $this->db->from('r_provider_admins');
        $this->db->join('users', "users.user_id = r_provider_admins.user_id");
        $this->db->join('r_provider_groups', "r_provider_groups.group_id = r_provider_admins.group_id");
        $this->db->join('r_providers', "r_providers.provider_id = r_provider_admins.provider_id");
        if($id != NULL) $this->db->where('r_providers.provider_id',$id);
        if($conditions != NULL) $this->db->where($conditions);
        $this->db->order_by('users.username');
        $query = $this->db->get();
        return $query->result_array();
    }
}