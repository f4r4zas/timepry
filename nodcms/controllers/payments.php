<?php 


class Payments extends NodCMS_Controller {
	
	
	public function stripe_card_token(){
		
		
session_start();
// Store the received token string in a session variable
if($_POST)
{
$_SESSION['token']=$_POST['stripeToken'];
}

		
	}
	
}