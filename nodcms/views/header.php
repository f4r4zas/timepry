<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Timepry</title>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/front/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/front/css/bootstrap.min.css">
    <!-- Google Font 'Lato' -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,900" rel="stylesheet">
    <link href='<?php echo base_url();?>assets/front/css/calendar/fullcalendar.min.css' rel='stylesheet' />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/front/css/calendar/calendar-mod.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/front/css/dropzone.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/front/css/kendo.common.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/front/css/kendo.bootstrap.min.css">
    <!-- <link rel="stylesheet" href="<?php echo base_url();?>assets/front/css/bootstrap-datetimepicker.min.css"> -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/front/css/style.css">

    <script src="<?php echo base_url();?>assets/front/js/jquery.js"></script>
    <!-- <script src="<?php echo base_url();?>assets/front/js/bootstrap-datetimepicker.min.js"></script> -->
    <script src="<?php echo base_url();?>assets/front/js/kendo.all.min.js"></script>
  
    <!-- Charts.js -->
    <script src='<?php echo base_url();?>assets/front/js/Chart.js'></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
	
	
	<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/additional-methods.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/additional-methods.min.js"></script>
	
		<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
	
		<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/extras/loadingoverlay_progress/loadingoverlay_progress.min.js"></script>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
	
    <style>
        span.help-block {
            display: none;
        }
        span.help-block.form-error {
            display: block;
        }
    </style>
	
</head>
<body>

    <header id="header">
        <div class="header_inner">
            <div class="container">
                <div class="row">
                    <div class="col-md-2">
                        <div class="site_branding">
                            <div class="logo">
                                <a href="index.php">
                                    <img src="<?php echo base_url();?>assets/front/images/timepry_logo.png" alt="Timepry">
                                </a>
                            </div>
                            <div id="mobilemenuBtn">
                                <i class="fa fa-bars"></i>
                            </div>
                        </div>
                    </div>

                    
                        
					<?php if($this->session->userdata("group") == 21){ ?>
					
					<div class="col-md-7 tex-center">
					
					<?php }else{ ?>
					 
					 <div class="col-md-8 tex-center">
					 
					<?php } ?>
						
						<div class="main_menu">
                            <nav class="menu_nav">
                                <ul class="menu" style="text-align:center">
                                    <li>
                                        <a href="<?php echo base_url();?>">Home</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url();?>">Find The Right Treatment</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url();?>about">About</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url();?>faq">FAQ</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url();?>contact">Contact</a>
                                    </li>
                                  
                                </ul>
								
                            </nav>
                        </div>
                    </div> <!-- End Menu -->
					
					
					<?php if($this->session->userdata("group") == 21){ ?>
					
					<div class="col-md-3">
					
					<?php }else{ ?>
					 
					 <div class="col-md-2">
					 
					<?php } ?>
					
                        <div class="main_menu">
                            <nav class="menu_nav">
                             
								<ul class="menu pull-right">
									<?php 
                                    
                                    if(!$this->session->userdata('group')):?>
                                    <li>
                                        <a href="<?php echo base_url();?>register">Register</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" class="showLogin">Login</a>
                                    </li>
                                    <?php else:?>
									
									<?php if($this->session->userdata("group") == 21){ ?>
									
									<li>
                                    <a href="<?php echo base_url(); ?>admin-appointment"><?php echo $this->session->userdata("firstname")  ?></a>
                                    
                                    </li>
									<?php } ?>
									
								   <li>
                                    <a href="<?php echo base_url(); ?>admin-appointment"><  ?=_l('Dashboard',$this);?></a>
                                    
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>admin-sign/logout"><?=_l('Logout',$this);?></a>
                                    </li>
									
                                    <?php endif;?>
								</ul>
                            </nav>
                        </div>
                    </div> <!-- End Menu -->
					
					
                </div>
            </div>
        </div>
    </header>
    
    <div class="page-content">