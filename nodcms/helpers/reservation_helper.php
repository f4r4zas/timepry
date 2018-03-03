<?php
/**
 * Created by Mojtaba Khodakhah
 * Subject: Homework
 * Date: 11/4/13
 * Connecet: khodakhah.mojtaba@yahoo.com
 */
function reservation_min_to_hours($value,$type="H:i"){
    return gmdate($type,$value*60);
}
function mkhCurrency($number){
   return "Euro ". number_format ( $number ,  2 , $dec_point = "," , $thousands_sep = "." );
//    setlocale(LC_MONETARY, 'en_US');
//    money_format('%.2n', $number);
}
function preview_services(&$obj,&$pageData,&$content){
    $obj->load->model("NodCMS_reservation_model");
    $content['data_list']= $obj->NodCMS_reservation_model->get_all_services();
    $content['title']= $pageData['title_caption'];
}