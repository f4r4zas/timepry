<?php function getNoReservations($email){
	 $CI = get_instance();
	 
	 $query = $CI->db->query("SELECT * FROM r_reservation where email = '".$email."'");
	 return $query->num_rows();
} ?>