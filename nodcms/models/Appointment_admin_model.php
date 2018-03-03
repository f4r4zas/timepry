<?php

/**

 * Created by PhpStorm.

 * User: Mojtaba

 * Date: 2/15/2016

 * Time: 6:48 PM

 * Project: NodCMS

 * Website: http://www.nodcms.com

 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Appointment_admin_model extends CI_Model{

    // Select a list form "r_services" table

    function getAllServices($provider_id=NULL)

    {

        $this->db->select("*");

        $this->db->from('r_services');

        $this->db->join('treatments','treatments.provider_id = r_services.provider_id');

        if($provider_id!=NULL){

            $this->db->where('r_services.provider_id',$provider_id);

        }else{

            $this->db->where('r_services.provider_id',$this->session->userdata('provider_id'));

        }
        
        $this->db->group_by('r_services.service_id');

        $query = $this->db->get();

        return $query->result_array();

    }



    // Select a record form "r_services" table

    function getServiceDetail($id)

    {

        $this->db->select("*");

        $this->db->from('r_services');

        $this->db->join('treatments','treatments.provider_id = r_services.provider_id');

        $this->db->where('r_services.provider_id',$this->session->userdata('provider_id'));

        $this->db->where('r_services.service_id',$id);

        $query = $this->db->get();

        return $query->result_array();

    }



    // Insert/Update on "r_services" table

    function serviceManipulate($data,$id,$extensions=null)

    {

        if($id!=null)

        {

            $this->db->where('provider_id',$this->session->userdata('provider_id'));

            $this->db->where('service_id',$id);

            $this->db->update('r_services',$data);

        }else{

            $data["user_id"]=$this->session->userdata('user_id');

            $data["provider_id"]=$this->session->userdata('provider_id');

            $data["created_date"]=time();

            $this->db->insert('r_services',$data);

            $id = $this->db->insert_id();

        }



        if(isset($extensions))

        {

            foreach ($extensions as $key=>$value) {

                $value['language_id'] = $key;

                $value['relation_id'] = $id;

                $value['data_type'] = 'r_services';

                $value['public'] = 1;

                $where = array('language_id'=>$key,'relation_id'=>$id,'data_type'=>'r_services');

                $query = $this->db->get_where('extensions',$where);

                if($query->num_rows() != 0)

                {

                    $row = $query->first_row();

                    $this->db->update('extensions',$value,array('extension_id'=>$row->extension_id));

                }else{

                    if($value!='')

                    {

                        $this->db->insert('extensions',$value);

                    }

                }

            }

        }

    }



    // Remove a record from "r_services" table

    function serviceRemove($id)

    {

        $this->db->delete('r_services',array("service_id"=>$id));

        // Remove related data

        $this->db->delete('r_time_period',array("service_id"=>$id));

        // Remove related data

        $this->db->delete('extensions',array('relation_id'=>$id,'data_type'=>'r_services'));

        return true;

    }



    // Select from "r_time_period" table

    function getAllPeriods($id, $day_no)

    {

        $this->db->select("*");

        $this->db->from('r_time_period');

        $this->db->where('service_id', $id);

        $this->db->where('day_no', $day_no);

        $this->db->order_by('period_start_time', "ASC");

        $query = $this->db->get();

        return $query->result_array();

    }



    // Select from "r_time_period" table (set output date)

    function getAllPeriodsAjax($id,$day_no)

    {

        $this->db->select("period_id as id, day_no as day, max_count as customers, period_start_time as start_time, period_end_time as end_time,period_min as period");

        $this->db->from('r_time_period');

        $this->db->where('service_id',$id);

        $this->db->where('day_no',$day_no);

        $query = $this->db->get();

        return $query->result_array();

    }



    // Select a record from "r_time_period" table

    function getPeriodDetail($sid,$id)

    {

        $this->db->select("*");

        $this->db->from('r_time_period');

        $this->db->where('service_id',$sid);

        $this->db->where('period_id',$id);

        $query = $this->db->get();

        return $query->result_array();

    }



    // Select a record from "r_time_period" table

    function getMinPeriod($id)

    {

        $this->db->select("min(period_min)");

        $this->db->from('r_time_period');

        $this->db->join('r_services', 'r_time_period.service_id = r_services.service_id');

        $this->db->where('provider_id',$id);

        $query = $this->db->get();

        $result = $query->result_array();

        return count($result)!=0?$result[0]["min(period_min)"]:0;

    }



    // Insert/Update on "r_time_period" table

    function periodManipulate($data,$id,$service_id)

    {

        if($id!=null)

        {

            $this->db->where('period_id',$id);

            $this->db->where('service_id',$service_id);

            $this->db->update('r_time_period',$data,array("period_id"=>$id,"service_id"=>$service_id));

            return $id;

        }else{

            $data["user_id"]=$this->session->userdata('user_id');

            $data["created_date"]=time();

            $data["service_id"]=$service_id;

            $this->db->insert('r_time_period',$data);

            return $this->db->insert_id();

        }

    }



    // Remove a record from "r_time_period" table

    function periodRemove($id,$service_id)

    {

        $this->db->where('period_id',$id);

        $this->db->where('service_id',$service_id);

        $this->db->delete('r_time_period');

        return true;

    }



    // Select from "r_reservation" table

    function getReservation($limit=null, $offset=null, $conditions=null)

    {

        $this->db->select("*,r_reservation.created_date");

        $this->db->from('r_reservation');

        $this->db->join('languages','languages.language_id = r_reservation.language_id');

        $this->db->where('provider_id',$this->session->userdata('provider_id'));

        $this->db->where('trash',0);

        if($conditions!=null){

            $conditions = $this->searchCommands($conditions);

            $this->db->where($conditions);

        }

        $this->db->order_by('reservation_date_time','ASC');

        if($limit!=null) $this->db->limit($limit,$offset);

        $query = $this->db->get();

        return $query->result_array();

    }



    private function searchCommands($conditions){

        if(is_array($conditions)){

            if(isset($conditions["min_date"])){

                $this->db->where("r_reservation.created_date >= '".$conditions["min_date"]."'");

                unset($conditions["min_date"]);

            }

            if(isset($conditions["max_date"])){

                $this->db->where("r_reservation.created_date < '".$conditions["max_date"]."'");

                unset($conditions["max_date"]);

            }

            if(isset($conditions["min_app_date"])){

                $this->db->where("reservation_date >= '".$conditions["min_app_date"]."'");

                unset($conditions["min_app_date"]);

            }

            if(isset($conditions["max_app_date"])){

                $this->db->where("reservation_date < '".$conditions["max_app_date"]."'");

                unset($conditions["max_app_date"]);

            }

            if(isset($conditions["min_app_time"])){

                $this->db->where("reservation_date_time >= '".$conditions["min_app_time"]."'");

                unset($conditions["min_app_time"]);

            }

            if(isset($conditions["max_app_time"])){

                $this->db->where("reservation_date_time < '".$conditions["max_app_time"]."'");

                unset($conditions["max_app_time"]);

            }

            if(isset($conditions["language_id"])){

                $this->db->where_in("r_reservation.language_id", $conditions["language_id"]);

                unset($conditions["language_id"]);

            }

            if(isset($conditions["search_text"])){

                $search = explode(" ", $conditions["search_text"]);

                foreach ($search as $item) {

                    $this->db->group_start();

                    $this->db->like("r_reservation.fname", $item);

                    $this->db->or_like("r_reservation.lname", $item);

                    $this->db->group_end();

                }

                unset($conditions["search_text"]);

            }

        }

        return $conditions;

    }



    // Select count of records from "r_reservation" table

    function getCountReservation($limit=null, $offset=null, $conditions=null)

    {

        $this->db->select("count(*)");

        $this->db->from('r_reservation');

        $this->db->join('languages','languages.language_id = r_reservation.language_id');

        $this->db->where('provider_id',$this->session->userdata('provider_id'));

        $this->db->where('trash',0);

        if($conditions!=null){

            $conditions = $this->searchCommands($conditions);

            $this->db->where($conditions);

        }

        $this->db->order_by('reservation_date_time','ASC');

        if($limit!=null) $this->db->limit($limit,$offset);

        $query = $this->db->get();

        $result = $query->result_array();

        return count($result)!=0?$result[0]["count(*)"]:0;

    }



    // Select sum of records from "r_reservation" table

    function getSumReservation($field, $conditions=null)

    {

        $this->db->select("sum($field)");

        $this->db->from('r_reservation');

        $this->db->join('languages','languages.language_id = r_reservation.language_id');

        $this->db->where('provider_id',$this->session->userdata('provider_id'));

        $this->db->where('trash',0);

        if($conditions!=null){

            $conditions = $this->searchCommands($conditions);

            $this->db->where($conditions);

        }

        $this->db->order_by('reservation_date_time','ASC');

        $query = $this->db->get();

        $result = $query->result_array();

        return count($result)!=0?$result[0]["sum($field)"]:0;

    }



    // Select a record from "r_reservation" table

    function getReservationDetail($id)

    {

        $this->db->select("*");

        $this->db->from('r_reservation');

        $this->db->where('trash',0);

        $this->db->where('provider_id',$this->session->userdata('provider_id'));

        $this->db->where('reservation_id',$id);

        $query = $this->db->get();

        return $query->result_array();

    }



    // Insert/Update on "r_reservation" table

    function reservationManipulate($data,$id)

    {

        if($id!=null)

        {

            $this->db->where('reservation_id',$id);

            $this->db->where('provider_id',$this->session->userdata('provider_id'));

            $this->db->update('r_reservation',$data);

            return $id;

        }else{

            $data["provider_id"]=$this->session->userdata('provider_id');

            $data["owner_user_id"]=$this->session->userdata('user_id');

            $data["created_date"]=time();

            $this->db->insert('r_reservation',$data);

            return $this->db->insert_id();

        }

    }



    // Update a record from "r_reservation" table (set "closed" = 1)

    function reservationClose($id)

    {

        $this->db->where('reservation_id',$id);

        $this->db->where('provider_id',$this->session->userdata('provider_id'));

        $this->db->update('r_reservation',array("closed"=>1));

    }



    // Update a record from "r_reservation" table (set "closed" = 0)

    function reservationCloseBack($id)

    {

        $this->db->where('reservation_id',$id);

        $this->db->where('provider_id',$this->session->userdata('provider_id'));

        $this->db->update('r_reservation',array("closed"=>0));

    }



    // Remove a record from "r_reservation" table

    function reservationRemove($id)

    {

        $this->db->where('reservation_id',$id);

        $this->db->where('provider_id',$this->session->userdata('provider_id'));

        $this->db->update('r_reservation',array("trash"=>1));

    }



    // Update a record from "r_reservation" table

    function reservationUpdateRemind($id, $reminded)

    {

        $this->db->where('reservation_id',$id);

        $this->db->set('reminded', $reminded);

        $this->db->update('r_reservation');

    }

    // Update a record from "r_reservation" table

    function reservationMakeValid($id)

    {

        $this->db->where('reservation_id',$id);

        $this->db->set('checked', 1);

        $this->db->update('r_reservation');

    }

    // Update a record from "r_reservation" table

    function reservationMakeNotValid($id)

    {

        $this->db->where('reservation_id',$id);

        $this->db->set('checked', 0);

        $this->db->update('r_reservation');

    }



    // Select a list from "r_free_dates" table

    function getHolidays($limit=null,$offset=null)

    {

        $this->db->select("*");

        $this->db->from('r_free_dates');

        $this->db->where('provider_id',$this->session->userdata('provider_id'));

        if($limit!=null) $this->db->limit($limit,$offset);

        $query = $this->db->get();

        return $query->result_array();

    }



    // Select a record from "r_free_dates" table

    function getHolidaysDetail($id)

    {

        $this->db->select("*");

        $this->db->from('r_free_dates');

        $this->db->where('provider_id',$this->session->userdata('provider_id'));

        $this->db->where('date_id',$id);

        $query = $this->db->get();

        return $query->result_array();

    }



    // Check exists any record at a time on "r_free_dates" table

    function checkHolidaysDate($date)

    {

        $this->db->select("count(*)");

        $this->db->from('r_free_dates');

        $this->db->where('provider_id',$this->session->userdata('provider_id'));

        $this->db->where('free_date',$date);

        $query = $this->db->get();

        $result = $query->result_array();

        return count($result)!=0?$result[0]["count(*)"]:0;

    }



    // Insert/Update on "r_free_dates" table

    function holidaysManipulate($data,$id)

    {

        if($id!=null)

        {

            $this->db->where('provider_id',$this->session->userdata('provider_id'));

            $this->db->where('date_id',$id);

            $this->db->update('r_free_dates',$data);

            return $id;

        }else{

            $data["user_id"]=$this->session->userdata('user_id');

            $data["provider_id"]=$this->session->userdata('provider_id');

            $data["created_date"]=time();

            $this->db->insert('r_free_dates',$data);

            return $this->db->insert_id();

        }

    }



    // Remove a record from "r_free_dates" table

    function holidaysRemove($id)

    {

        $this->db->where('provider_id',$this->session->userdata('provider_id'));

        $this->db->where('date_id',$id);

        $this->db->delete('r_free_dates');

    }



    // Select related records to "r_services" table from "extensions" and "languages" table

    function getExistedServicesLanguage($service_id,$conditions=null)

    {

        $this->db->select("*,languages.image");

        $this->db->from('extensions');

        $this->db->join('languages',"extensions.language_id = languages.language_id");

        $this->db->where('data_type','r_services');

        if($conditions!=null) $this->db->where($conditions);

        $this->db->where('relation_id',$service_id);

        $this->db->where("(name <> '' OR description <> '' OR full_description <> '' OR tag <> '')");

        $query = $this->db->get();

        return $query->result_array();

    }



    // Select records and data from "r_reservation" table for statistics charts

    function statisticsReservation($dateField='created_date',$GroupBy=null,$conditions=null)

    {

        $addOnSelect = '';

//        Not Removed record's count

        $addOnSelect.=", SUM(CASE WHEN trash = 0 THEN 1 ELSE 0 END) as accepted_count";

//        Closed record's count

        $addOnSelect.=", SUM(CASE WHEN closed = 1 THEN 1 ELSE 0 END) as success_count";

//        Removed record's count

        $addOnSelect.=", SUM(CASE WHEN trash > 0 THEN 1 ELSE 0 END) as trash_count";



//        Count in   Mondays

        $addOnSelect.=", SUM(CASE WHEN DAYNAME(FROM_UNIXTIME($dateField)) = 'Monday' THEN 1 ELSE 0 END) as mon";

//        Count in    Tuesdays

        $addOnSelect.=", SUM(CASE WHEN DAYNAME(FROM_UNIXTIME($dateField)) = 'Tuesday' THEN 1 ELSE 0 END) as tue";

//        Count in      Wednesdays

        $addOnSelect.=", SUM(CASE WHEN DAYNAME(FROM_UNIXTIME($dateField)) = 'Wednesday' THEN 1 ELSE 0 END) as wed";

//        Count in      Fridays

        $addOnSelect.=", SUM(CASE WHEN DAYNAME(FROM_UNIXTIME($dateField)) = 'Friday' THEN 1 ELSE 0 END) as fri";

//        Count in     Thursdays

        $addOnSelect.=", SUM(CASE WHEN DAYNAME(FROM_UNIXTIME($dateField)) = 'Thursday' THEN 1 ELSE 0 END) as thu";

//        Count in  Saturdays

        $addOnSelect.=", SUM(CASE WHEN DAYNAME(FROM_UNIXTIME($dateField)) = 'Saturday' THEN 1 ELSE 0 END) as sat";

//        Count in Sundays

        $addOnSelect.=", SUM(CASE WHEN DAYNAME(FROM_UNIXTIME($dateField)) = 'Sunday' THEN 1 ELSE 0 END) as sun";



        $this->db->select("COUNT(reservation_id) as all_count, min($dateField) as min_date, max($dateField) as max_date".$addOnSelect);

        $this->db->from('r_reservation');

        $this->db->where('provider_id',$this->session->userdata('provider_id'));

        if($conditions!=null)

            $this->db->where($conditions);

        if($GroupBy=='DAYNAME')

        {

            $this->db->group_by("DAYNAME(FROM_UNIXTIME($dateField))");

        }elseif($GroupBy=='DAY')

        {

            $this->db->group_by("DATE_FORMAT(FROM_UNIXTIME($dateField),'%d')");

        }else{

            $this->db->group_by("MONTH(FROM_UNIXTIME($dateField))");

        }

        $query = $this->db->get();

        return $query->result_array();

    }



    // Record's count in "r_reservation" table

    function countReservation($dateField='created_date', $where = null,$start_date = null,$end_date = null,$group_by=null)

    {

        $this->db->select("count(*)");

        $this->db->from('r_reservation');

        $this->db->where('provider_id',$this->session->userdata('provider_id'));

        if($where!=null)

        {

            $this->db->where($where);

        }

        if($start_date!=null)

        {

            $this->db->where("$dateField >= $start_date");

        }

        if($end_date!=null)

        {

            $this->db->where("$dateField < $end_date");

        }

        if($group_by!=null)

        {

            $this->db->group_by($group_by);

        }

        $query = $this->db->get();

        $result = $query->result_array();

        return isset($result[0]["count(*)"])?$result[0]["count(*)"]:0;

    }



    // Insert a record in "r_reservation_comment" table

    function reservationAddComment($reservation_id,$message)

    {

        $data = array('reservation_id'=>$reservation_id, 'comment_message'=>$message);

        $data["user_id"] = $this->session->userdata['user_id'];

        $data["created_date"] = time();

        $this->db->insert("r_reservation_comment",$data);

        return $this->db->insert_id();

    }



    // Select a list from "reservation_get_comment" table

    function reservationGetComment($reservation_id,$conditions=null)

    {

        $this->db->select("*,r_reservation_comment.created_date");

        $this->db->from('r_reservation_comment');

        $this->db->join('users',"users.user_id = r_reservation_comment.user_id");

        if($conditions!=null) $this->db->where($conditions);

        $this->db->where('reservation_id',$reservation_id);

        $this->db->order_by('comment_id','DESC');

        $query = $this->db->get();

        return $query->result_array();

    }



    // Check exists any record at a time period in "r_time_dates" table

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



    // Select a list from "r_field_type" table

    function getAllFieldType()

    {

        $this->db->select("*");

        $this->db->from('r_field_type');

        $query = $this->db->get();

        return $query->result_array();

    }



    // Select a list from "r_extra_fields_value" table

    function getExtraFieldsValue($conditions=null)

    {

        $this->db->select("*");

        $this->db->from('r_extra_fields_value');

        if($conditions!=null) $this->db->where($conditions);

        $query = $this->db->get();

        return $query->result_array();

    }



    // Select a list from "r_extra_fields" table

    function getExtraFields($conditions=null)

    {

        $this->db->select("*");

        $this->db->from('r_extra_fields');

        $this->db->where('provider_id',$this->session->userdata('provider_id'));

        $this->db->join('r_field_type','type_id = field_type');

        if($conditions!=null) $this->db->where($conditions);

        $query = $this->db->get();

        return $query->result_array();

    }



    // Select a record from "r_extra_fields" table

    function getExtraFieldsDetail($id,$conditions=null)

    {

        $this->db->select("*");

        $this->db->from('r_extra_fields');

        $this->db->where('provider_id',$this->session->userdata('provider_id'));

        $this->db->where('id',$id);

        if($conditions!=null) $this->db->where($conditions);

        $query = $this->db->get();

        $result = $query->result_array();

        return count($result)!=0?$result[0]:null;

    }



    // Insert/Update on "r_extra_fields" table

    function extraFieldsManipulate($data,$id)

    {

        $this->db->trans_start();

        if(isset($data["titles"]) && count($data["titles"])!=0)

        {

            $titles = $data["titles"];

            unset($data["titles"]);

        }

        if($id!=null)

        {

            $this->db->where('provider_id',$this->session->userdata('provider_id'));

            $this->db->where('id',$id);

            $this->db->update('r_extra_fields',$data,array("id"=>$id));

        }else{

            $data['provider_id'] = $this->session->userdata('provider_id');

            $this->db->insert('r_extra_fields',$data);

            $id = $this->db->insert_id();

        }

        if(isset($titles))

        {

            $this->db->delete('titles', array("relation_id"=>$id,"data_type"=>"r_extra_fields"));

            foreach ($titles as $key=>$value) {

                if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$id,"data_type"=>"r_extra_fields"));

            }

        }

        $this->db->trans_complete();

        if ($this->db->trans_status() == FALSE)

        {

            return 0;

        }else{

            return $id;

        }

    }



    // check user exists

    function checkUserUnique($conditions, $id){

        $this->db->select("*");

        $this->db->from('users');

        $this->db->where($conditions);

        $this->db->where('user_id !=', $id);

        $query = $this->db->get();

        return (count($query->result_array())!=0)?TRUE:FALSE;

    }



    // check user exists

    function checkProviderUnique($conditions, $id){

        $this->db->select("*");

        $this->db->from('r_providers');

        $this->db->where($conditions);

        $this->db->where('provider_id !=', $id);

        $query = $this->db->get();

        return (count($query->result_array())!=0)?TRUE:FALSE;

    }



    // Select a record from "r_providers" table

    function getProviderById($id,$conditions=NULL){

        $this->db->select("*");

        $this->db->from('r_providers');

        if($conditions!=NULL) $this->db->where($conditions);

        $this->db->where('provider_id',$id);

        $query = $this->db->get();

        return $query->result_array();

    }



    // Select a list from "r_providers" table

    function getProvider($conditions=NULL, $limit = NULL, $offset = NULL){

        $this->db->select("*, r_providers.created_date, r_providers.active");

        $this->db->from('r_providers');

        $this->db->join('users', "users.user_id = r_providers.user_id");

        if($conditions!=NULL) $this->db->where($conditions);
        
        $this->db->order_by("r_providers.provider_id","DESC");

        if($limit!=NULL) $this->db->limit($limit, $offset);
        

        $query = $this->db->get();

        return $query->result_array();

    }

    // Select a list from "r_providers" table

    function getProviderDetail($id, $conditions=NULL){

        $this->db->select("*");

        $this->db->from('r_providers');

        if($conditions!=NULL) $this->db->where($conditions);

        $this->db->where('provider_id', $id);

        $query = $this->db->get();

        return $query->result_array();

    }



    // Select a record from "r_provider_admins" table

    function getProviderManagerById($id,$conditions=NULL){

        $this->db->select("*");

        $this->db->from('r_provider_admins');

        $this->db->join('r_provider_groups', 'r_provider_admins.group_id = r_provider_groups.group_id');

        $this->db->where('provider_id',$id);

        if($conditions!=NULL) $this->db->where($conditions);

        $query = $this->db->get();

        return $query->result_array();

    }



    // Select a list from "r_provider_admin" table

    function getProviderManagers($id = NULL, $conditions=NULL){

        $this->db->select("*, r_provider_admins.user_id");

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



    // Insert/Update on "r_providers" table

    function providerManipulate($data, $id, $extensions = NULL)

    {

        if($id!=null)

        {

            $this->db->where('provider_id',$id);

            $this->db->update('r_providers',$data);

        }else{

            $data["user_id"]=$this->session->userdata('user_id');

            $data["created_date"]=time();

            $this->db->insert('r_providers',$data);

            $id = $this->db->insert_id();

        }

        $this->extensionUpToDate($extensions,$id,'r_providers');

    }



    // Update default on "r_providers" table

    function resetProviderDefault($id)

    {

        $this->db->update('r_providers', array('default'=>0));

        $this->db->where('provider_id', $id);

        $this->db->update('r_providers', array('default'=>1));

    }



    // Remove a record from "r_providers" table

    function providerRemove($id)

    {

        // Remove from "r_providers"

        $this->db->delete('r_providers', array('provider_id' => $id));

        // Remove form "extensions"

        $this->db->delete('extensions', array('data_type'=>'r_providers', 'relation_id' => $id));

        // Remove related data

        $this->db->delete('r_provider_admins', array('provider_id' => $id));

        $this->db->delete('r_extra_fields',array("provider_id"=>$id));

        $this->db->delete('r_free_dates',array("provider_id"=>$id));

        // Remove form "r_reservation_comment"

        $sql = "DELETE FROM r_reservation_comment WHERE reservation_id IN ";

        $sql .= "( SELECT reservation_id FROM r_reservation WHERE provider_id = ? )";

        $this->db->query($sql, $id);

        // Remove form "r_extra_fields_value"

        $sql = "DELETE FROM r_extra_fields_value WHERE reservation_id IN ";

        $sql .= "( SELECT reservation_id FROM r_reservation WHERE provider_id = ? )";

        $this->db->query($sql, $id);

        // Remove from "r_reservation"

        $this->db->delete('r_reservation',array("provider_id"=>$id));

        // Remove form "r_time_period"

        $sql = "DELETE FROM r_time_period WHERE service_id IN ";

        $sql .= "( SELECT service_id FROM r_services WHERE provider_id = ? )";

        $this->db->query($sql, $id);

        // Remove form "extensions"

        $sql = "DELETE FROM extensions WHERE data_type = 'r_services' AND relation_id IN ";

        $sql .= "( SELECT service_id FROM r_services WHERE provider_id = ? )";

        $this->db->query($sql, $id);

        // Remove from "r_services"

        $this->db->delete('r_services',array("provider_id"=>$id));

        // Remove from "r_provider_admins"

        $this->db->delete('r_provider_admins',array("provider_id"=>$id));

        return true;

    }



    // Update a record in r_provider_admins table

    function updateProviderManagerNotificationEmail($provider_id, $user_id, $notification_email)

    {

        $this->db->set("notification_email", $notification_email);

        $this->db->where("provider_id", $provider_id);

        $this->db->where("user_id", $user_id);

        $this->db->update("r_provider_admins");

    }



    // Remove a list from "r_provider_admins" table

    function providerManagerRemove($id, $user_id)

    {

        $this->db->delete('r_provider_admins',array("provider_id"=>$id, "user_id"=>$user_id));

    }



    // Select a list of username from "users" table

    function getUsername($conditions = NULL)

    {

        $this->db->select('username');

        $this->db->from('users');

        if($conditions != NULL) $this->db->where($conditions);

        $query = $this->db->get();

        return $query->result_array();

    }



    // Select a list from "provider_groups" table

    function getManagersGroups($conditions = NULL){

        $this->db->select('*');

        $this->db->from('r_provider_groups');

        if($conditions != NULL) $this->db->where($conditions);

        $query = $this->db->get();

        return $query->result_array();

    }



    // Select a row from "users" table

    function getUserByUsername($username, $conditions = NULL){

        $this->db->select('*');

        $this->db->from('users');

        $this->db->where('username', $username);

        if($conditions!=NULL) $this->db->where($conditions);

        $query = $this->db->get();

        return $query->result_array();

    }



    // Add manager for providers

    function addUserManager($provider_id, $user_id, $group_id){

        $this->db->insert('r_provider_admins', array('provider_id'=>$provider_id, 'user_id'=>$user_id, 'group_id'=>$group_id));

    }



    // Select a list from "users" table

    function getAllUser($limit = NULL, $offset = NULL)

    {

        $this->db->select("*");

        $this->db->from('users');

        $this->db->join('groups','users.group_id = groups.group_id');

        $this->db->order_by('user_id','DESC');

        if($limit!=NULL) $this->db->limit($limit, $offset);

        $query = $this->db->get();

        return $query->result_array();

    }

    

    function getAllUserByType($limit = NULL, $offset = NULL, $type_id = "20")

    {

        $this->db->select("*");

        $this->db->from('users');

        $this->db->join('groups','users.group_id = groups.group_id');

        $this->db->order_by('user_id','DESC');

        $this->db->where('users.group_id',$type_id);

        if($limit!=NULL) $this->db->limit($limit, $offset);

        $query = $this->db->get();

        return $query->result_array();

    }



    /*

     * This is a help method to keep up to date(insert/update) "extensions" for a table.

     * ! "extensions" is a table in DB, that use for any table that you want to have multilingual records.

     * ! This method use just in this file in another methods.

     */

    private function extensionUpToDate($extensions,$id,$data_type){

        if($extensions != NULL)

        {

            foreach ($extensions as $key=>$value) {

                $value['language_id'] = $key;

                $value['relation_id'] = $id;

                $value['data_type'] = $data_type;

                $value['public'] = 1;

                $where = array('language_id'=>$key,'relation_id'=>$id,'data_type'=>$data_type);

                $query = $this->db->get_where('extensions',$where);

                if($query->num_rows() != 0)

                {

                    $row = $query->first_row();

                    $this->db->update('extensions',$value,array('extension_id'=>$row->extension_id));

                }else{

                    if($value!='')

                    {

                        $this->db->insert('extensions',$value);

                    }

                }

            }

        }

    }

}