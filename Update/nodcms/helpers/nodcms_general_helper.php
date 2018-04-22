<?php
/**
 * Created by PhpStorm.
 * User: Mojtaba
 * Date: 9/15/2015
 * Time: 8:00 PM
 * Project: NodCMS
 * Website: http://www.nodcms.com
 */


if ( ! function_exists('_l')){
    function _l($label, $obj)
    {

        $label = str_replace('"','&quot;',$label);
        $return = $obj->lang->line($label, FALSE);
        if ($return){
            return $return;
        }elseif(isset($_SESSION['language'])){
            if(isset($obj->controllerType) && $obj->controllerType == "backend"){
                if(!in_array($label,$obj->langArray)){
                    $file = getcwd()."/nodcms/language/".$_SESSION["language"]["language_name"]."/backend_lang.php";
                }
            }else{
                if(!in_array($label,$obj->langArray)){
                    $file = getcwd()."/nodcms/language/".$_SESSION["language"]["language_name"].'/'.$_SESSION["language"]["code"]."_lang.php";
                }
            }
            if(isset($file) && file_exists($file)){
                $current = file_get_contents($file);
                $current .= "\n";
                $current .= '$lang["'.$label.'"] = "'.$label.'";';
                file_put_contents($file, $current);
                $obj->langArray[$label] = $label;
            }
            return $label;
        }
    }
}
if ( ! function_exists('substr_string')){
    function substr_string($text,$start = 0,$count = 10,$end_text=" ..."){
        $explode = explode(" ",strip_tags($text));
        return implode(" ",array_splice($explode,$start,$count)).(count($explode)>$count?$end_text:"");
    }
}
if ( ! function_exists('my_int_date')){
    function my_int_date($date)
    {
        return date($_SESSION["settings"]["date_format"] ,$date);
    }
}
if ( ! function_exists('my_int_fullDate')){
    function my_int_fullDate($time){
        return date_translate(date("j F Y | ".$_SESSION["settings"]["time_format"],$time));
    }
}
if ( ! function_exists('my_int_justDate')){
    function my_int_justDate($time){
        return date_translate(date("j F Y",$time));
    }
}

if ( ! function_exists('my_int_justTime')){
    function my_int_justTime($time){
        return date_translate(date($_SESSION["settings"]["time_format"], $time));
    }
}

if( !function_exists('date_translate')){
    function date_translate($text){
        $CI =& get_instance();
        $language = $_SESSION['language'];
        $CI->lang->load($language['code'].'_lang', $language['language_name']);

        $translation = array(
            "January" => $CI->lang->line("January"),
            "February" => $CI->lang->line("February"),
            "March" => $CI->lang->line("March"),
            "April" => $CI->lang->line("April"),
            "May" => $CI->lang->line("May"),
            "June" => $CI->lang->line("June"),
            "July" => $CI->lang->line("July"),
            "August" => $CI->lang->line("August"),
            "September" => $CI->lang->line("September"),
            "October" => $CI->lang->line("October"),
            "November" => $CI->lang->line("November"),
            "December" => $CI->lang->line("December"),
            "Jan" => $CI->lang->line("Jan"),
            "Feb" => $CI->lang->line("Feb"),
            "Mar" => $CI->lang->line("Mar"),
            "Apr" => $CI->lang->line("Apr"),
            "Jun" => $CI->lang->line("Jun"),
            "Jul" => $CI->lang->line("Jul"),
            "Aug" => $CI->lang->line("Aug"),
            "Sep" => $CI->lang->line("Sep"),
            "Oct" => $CI->lang->line("Oct"),
            "Nov" => $CI->lang->line("Nov"),
            "Dec" => $CI->lang->line("Dec"),
            "Sunday" => $CI->lang->line("Sunday"),
            "Monday" => $CI->lang->line("Monday"),
            "Tuesday" => $CI->lang->line("Tuesday"),
            "Wednesday" => $CI->lang->line("Wednesday"),
            "Thursday" => $CI->lang->line("Thursday"),
            "Friday" => $CI->lang->line("Friday"),
            "Saturday" => $CI->lang->line("Saturday"),
            "Sun" => $CI->lang->line("Sun"),
            "Mon" => $CI->lang->line("Mon"),
            "Tue" => $CI->lang->line("Tue"),
            "Wed" => $CI->lang->line("Wed"),
            "Thu" => $CI->lang->line("Thu"),
            "Fri" => $CI->lang->line("Fri"),
            "Sat" => $CI->lang->line("Sat"),
            "Su" => $CI->lang->line("Su"),
            "Mo" => $CI->lang->line("Mo"),
            "Tu" => $CI->lang->line("Tu"),
            "We" => $CI->lang->line("We"),
            "Th" => $CI->lang->line("Th"),
            "Fr" => $CI->lang->line("Fr"),
            "Sa" => $CI->lang->line("Sa"),
            "AM" => $CI->lang->line("AM"),
            "am" => $CI->lang->line("am"),
            "PM" => $CI->lang->line("PM"),
            "pm" => $CI->lang->line("pm"),
        );
        $search = array_keys($translation);
        $replace = array_values($translation);

        return str_replace($search, $replace, $text);
    }
}

if ( ! function_exists('frontendStatisticCalc')){
    function frontendStatisticCalc($obj,$language){
        //        Statistic
        $visitorMinDate = $obj->NodCMS_general_model->get_min_date_visitor();
        if($visitorMinDate!=0){
            $visitorMaxDate = $obj->NodCMS_general_model->get_max_date_visitor();
            $times = $visitorMaxDate - $visitorMinDate;
            if($times >= 86400){
                $days = round($times / 86400);
                $visitorMinDate = (mktime(0,0,0,date("m",$visitorMinDate),(date("j",$visitorMinDate)),date("Y",$visitorMinDate)));
                for($d=0;$d<$days;$d++){
                    $maxTime = (mktime(0,0,0,date("m",$visitorMinDate),(date("j",$visitorMinDate)),date("Y",$visitorMinDate))) + 86400;
                    $obj->NodCMS_general_model->update_statistic(strtotime(date("d.m.Y",$visitorMinDate)),$maxTime);
                    $visitorMinDate = $maxTime;
                }
            }
        }
        $visitor = $obj->NodCMS_general_model->get_duplicate_visitor(session_id(),$_SERVER["REQUEST_URI"]);
        if(count($visitor) == 0){
            // Get IP address
            if ( isset($_SERVER['HTTP_CLIENT_IP']) && ! empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif ( isset($_SERVER['HTTP_X_FORWARDED_FOR']) && ! empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = (isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
            }

            $ip = filter_var($ip, FILTER_VALIDATE_IP);
            $ip = ($ip === false) ? '0.0.0.0' : $ip;
            $obj->load->library('spyc');
            $visitor_data = array(
                "session_id"=>session_id(),
                "user_id"=>isset($_SESSION["user"]["user_id"])?$_SESSION["user"]["user_id"]:0,
                "created_date"=>time(),
                "updated_date"=>time(),
                "user_agent"=>Spyc::YAMLDump($_SERVER["HTTP_USER_AGENT"]),
                "user_ip"=>$ip,
                "language_id"=>$language["language_id"],
                "language_code"=>$language["code"],
                "referrer"=>isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:"",
                "request_url"=>$_SERVER['REQUEST_URI'],
                "count_view"=>1
            );
            $obj->NodCMS_general_model->insert_visitors($visitor_data);
        }else{
            $visitor = @reset($visitor);
            $visitor_data = array(
                "user_id"=>isset($_SESSION["user"]["user_id"])?$_SESSION["user"]["user_id"]:0,
                "updated_date"=>time(),
                "count_view"=>$visitor["count_view"]+1
            );
            $obj->NodCMS_general_model->update_duplicate_visitor(session_id(),$_SERVER["REQUEST_URI"],$visitor_data);
        }
    }
}