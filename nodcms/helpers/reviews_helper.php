<?php

 function getReviews($providerId){
	
	 // Get a reference to the controller object
    $CI = get_instance();

    // You may need to load the model if it hasn't been pre-loaded
    $CI->load->model('Appointment_model');

    // Call a function of the model
	
   $reviews = $CI->Appointment_model->getReviews($providerId);
		
   if(!empty($reviews)){
	   $reviewsAvg = array();
	   
	   if(count($reviews) > 1 ){
		   foreach($reviews as $allReviews){
				$reviewsAvg[] = $allReviews['ratings'];
		   }
		   
		  $reviewsAvg = array_filter($reviewsAvg);
		  $average = array_sum($reviewsAvg)/count($reviewsAvg);
		 return round($average);
		   
	   }else{
		   return round($reviews[0]['ratings']);   
	   }
	   
   }else{
	   return 0;
   }
	
	
}

 ?>