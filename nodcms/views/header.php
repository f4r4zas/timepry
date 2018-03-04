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





	
	
</head>
<body>

    <header id="header">
        <div class="header_inner">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
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

                    <div class="col-md-8">
                        <div class="main_menu">
                            <nav class="menu_nav">
                                <ul class="menu">
                                    <li>
                                        <a href="<?php echo base_url();?>">Home</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url();?>">Find The Right Treatment</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url();?>">About</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url();?>">FAQ</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url();?>">Contact</a>
                                    </li>
                                    <?php 
                                    
                                    if(!$this->session->userdata('group')):?>
                                    <li>
                                        <a href="<?php echo base_url();?>register">Signup</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" class="showLogin">Login</a>
                                    </li>
                                    <?php else:?>
                                    <li>
                                    <a href="<?php echo base_url(); ?>admin-appointment"><?=_l('Dashboard',$this);?></a>
                                    
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>admin-sign/logout"><?=_l('Log Out',$this);?></a>
                                    </li>
                                    <?php endif;?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    
    <div class="page-content">