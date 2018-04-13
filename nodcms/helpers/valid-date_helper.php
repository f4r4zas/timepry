<?php

/*
 * Check if provider avaible on this date
 *
 */


function getDayByDate($date){
echo $date;
    $daysno = [
        'Sunday',
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
    ];

    $ymd = DateTime::createFromFormat('d/m/Y', $date)->format('Y-m-d');


    $no =  date('w', strtotime($ymd));
   return $daysno[$no];

}

function checkValidDate($date,$providerId){
   // echo $date;

     $getDay = getDayByDate($date);

    $CI = get_instance();

    $CI->db->select("*");
    $CI->db->from('r_provider_time');
    $CI->db->where('provider_id',$providerId);
    $CI->db->where('day',$getDay);
    $query = $CI->db->get();
   //echo  $CI->db->last_query();
    if($query->result_array()){
        return $query->result_array();
    }else{
        return false;
    }

}

?>