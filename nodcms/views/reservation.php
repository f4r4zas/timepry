<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo $lang; ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <?php
        $pageURL = 'http';
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
        ?>
    <title><?=isset($settings["options"]["company"])?$settings["options"]["company"]:$settings["company"]?><?php echo isset($title)?" | ".$title:""; ?></title>
    <meta name="robots" content="index, follow" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0" />
    <meta name="keywords" content="<?php if(isset($keyword)) echo $keyword; ?>" />
    <meta name="description" content="<?php if(isset($description)) echo substr_string(strip_tags($description),0,50); ?>" />

    <link rel="sitemap" type="application/xml" title="Sitemap" href="<?php echo base_url().$lang; ?>/sitemap.xml" /> <!-- No www -->
    <link rel="shortcut icon" href="<?=base_url().$settings["fav_icon"]?>">

    <!-- BEGIN GLOBAL MANDATORY STYLES -->

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,900" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/metronic/global/plugins/font-awesome/css/font-awesome.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/metronic/global/plugins/simple-line-icons/simple-line-icons.min.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/metronic/admin/pages/css/profile-old.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/metronic/global/plugins/jquery-ui/jquery-ui-datepicker-custom.css"/>
    
<!--    <link rel="stylesheet" type="text/css" href="--><?php //echo base_url(); ?><!--assets/metronic/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.css"/>-->
    <!-- END GLOBAL MANDATORY STYLES -->
    <?php if($_SESSION["language"]["rtl"]!=1){ ?>
        <link href="<?php echo base_url(); ?>assets/metronic/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/metronic/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
        <!-- BEGIN THEME STYLES -->
        <link href="<?php echo base_url(); ?>assets/metronic/global/css/components.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/metronic/global/css/plugins.css" rel="stylesheet" type="text/css"/>
        <link href='<?php echo base_url();?>assets/front/css/calendar/fullcalendar.min.css' rel='stylesheet' />
        <link rel="stylesheet" href="<?php echo base_url();?>assets/front/css/calendar/calendar-mod.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/front/css/dropzone.css">
        <!-- Kendo -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/front/css/kendo.common.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/front/css/kendo.bootstrap.min.css">
        <!-- Kendo -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/front/css/style.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/front/css/bootstrap-datetimepicker.min.css"/>
        <link href="<?php echo base_url(); ?>assets/metronic/admin/layout3/css/layout.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/metronic/admin/layout3/css/themes/green-haze.css.css" rel="stylesheet" type="text/css" id="style_color"/>
        <link href="<?php echo base_url(); ?>assets/metronic/admin/layout3/css/custom.css" rel="stylesheet" type="text/css"/>
        <!-- END THEME STYLES -->
    <?php }else{ ?>
        <link href="<?php echo base_url(); ?>assets/metronic/global/plugins/bootstrap/css/bootstrap-rtl.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/metronic/global/plugins/uniform/css/uniform.default-rtl.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/metronic/global/css/components-rtl.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/metronic/global/css/plugins-rtl.css" rel="stylesheet" type="text/css"/>
        <link href='<?php echo base_url();?>assets/front/css/calendar/fullcalendar.min.css' rel='stylesheet' />
        <link rel="stylesheet" href="<?php echo base_url();?>assets/front/css/calendar/calendar-mod.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/front/css/dropzone.css">
        <!-- Kendo -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/front/css/kendo.common.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/front/css/kendo.bootstrap.min.css">
        <!-- Kendo -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/front/css/style.css">
        <!--<link href="<?php echo base_url(); ?>assets/metronic/admin/layout3/css/layout-rtl.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/metronic/admin/layout3/css/themes/default-rtl.css" rel="stylesheet" type="text/css" id="style_color"/>
        <link href="<?php echo base_url(); ?>assets/metronic/admin/layout3/css/custom-rtl.css" rel="stylesheet" type="text/css"/>-->
    <?php } ?>
    <link href="<?php echo base_url(); ?>assets/metronic/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
    <!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
    <link href="<?php echo base_url(); ?>assets/metronic/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css"/>
    <!-- END PAGE LEVEL PLUGIN STYLES -->

    <script src="<?php echo base_url(); ?>assets/metronic/global/plugins/jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/front/js/kendo.all.min.js"></script>
    
    <!--<script src="<?php echo base_url();?>assets/front/js/jquery.js"></script>-->
    <!-- Charts.js -->
    <script src='<?php echo base_url();?>assets/front/js/Chart.js'></script>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

		<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
	
		<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/extras/loadingoverlay_progress/loadingoverlay_progress.min.js"></script>
		
			<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
	
	<script src="<?php echo base_url();?>assets/front/js/list.min.js"></script>

    <script type="text/javascript">
            $('img').error(function(){
               <?php if(isset($settings['default_image']) && $settings['default_image']!="") {?>
               $(this).attr('src','<?php echo base_url(); ?><?php echo image($settings['default_image'],$settings['default_image'],220,120);?>');
              <?php } else {?>
              $(this).attr('src','<?php echo base_url(); ?><?php echo image("assets/frontend/img/noimage.jpg","assets/frontend/img/noimage.jpg",220,120);?>');
              <?php }?>
            });
    </script>
    <style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      
      #infowindow-content .title {
        font-weight: bold;
      }

      #infowindow-content {
        display: none;
      }

      #dentist_reg_map #infowindow-content {
        display: inline;
      }
.my-popup .modal-content {
	opacity: 1;
	text-align: center;
	font-size: 21px;
	text-transform: uppercase;
	background-image: url("http://techopialabs.com/timepry/assets/front/images/gradient_banner_bg.jpg");
	background-repeat: no-repeat;
	background-size: 100%;
	color: #fff;
}


.my-popup .modal-footer {
	border: none;
	text-align: center;
	color : #fff;
}

.my-popup .btn {
	background-color: #323232;
	border: 1px solid #323232;
	color: #fff;
	font-size: 18px;
	width: 35%;
	padding: 18px;
	border-radius: 3px;
	margin-top: 10px;
	font-family: 'Lato', sans-serif;
}

.my-popup2 .modal-content {
	opacity: 1;
	text-align: center;
	font-size: 21px;
	text-transform: uppercase;
	background-image: url("http://techopialabs.com/timepry/assets/front/images/gradient_banner_bg.jpg");
	background-repeat: no-repeat;
	background-size: 100%;
	color: #fff;
}


.my-popup2 .modal-footer {
	border: none;
	text-align: center;
	color : #fff;
}

.my-popup2 .btn {
	background-color: #F3A9AE;
	border: 1px solid #323232;
	color: #fff;
	font-size: 18px;
	width: 35%;
	padding: 18px;
	border-radius: 3px;
	margin-top: 10px;
	font-family: 'Lato', sans-serif;
}


#update4 > .row > .col-md-2 > .treatment-tabs .nav-tabs > li.active:last-child > a::after {
	display: block;
	border-left: 25px solid #47A6FF;
	border-top: 52px solid transparent;
	border-bottom: 56px solid transparent;
	right: -25px;
	content: "";
	position: absolute;
	top: 2px;
	bottom: 0;
	width: 0;
	height: 0;
}
.form-control {
	font-size: 13px !important;
}
.heading small {
	font-size: 15px;
}
.heading h3 {
	font-size: 26px !important;
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
                                <a href="<?php echo base_url(); ?>">
                                    <img style="max-height: 30px;" src="<?=base_url($settings["logo"])?>" alt="<?=isset($settings["company"])?$settings["company"]:""?>" title="<?=isset($settings["company"])?$settings["company"]:""?>" class="logo-default">
                                </a>
                            </div>
                            <div id="mobilemenuBtn">
                                <i class="fa fa-bars"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="main_menu">
                            <nav class="menu_nav">
                                <ul class="menu" style="text-align:center">
                                    <li>
                                        <a href="<?php echo base_url();?>">Home</a>
                                    </li>
                                    
                                    <li>
                                        <a href="<?php echo base_url();?>find-the-right-treatment">Find The Right Treatment</a>
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
                    </div><!-- main Menu -->
					
					<div class="col-md-3">
					   <div class="main_menu">
                            <nav class="menu_nav">
                                <ul class="menu">
                                    <?php 
                                    
                                    if(!$this->session->userdata('group')):?>
                                    <li>
                                        <a href="<?php echo base_url();?>register">Register</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" class="showLogin">Login</a>
                                    </li>
                                    <?php else:?>
                                        <li>
                                            <a href="<?php echo base_url(); ?>admin-appointment"><?php echo $this->session->userdata("firstname")  ?></a>

                                        </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>admin-sign/logout"><?=_l('Logout',$this);?></a>
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
    
    <?php echo $content; ?>
    

    </div>

    <footer id="footer">
        <div class="footer_wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 box">
                           <div class="footer_logo">
                            <img src="http://techopialabs.com/timepry/assets/front/images/timepry_footer_logo.png" alt="Timepry">
                        </div>
                        <div class="details">
                            <p>
                                This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio.  Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate curs
                            </p>
                        </div>
                    </div>

                    <div class="col-md-2 box">
                        <div class="title">Follow Us On</div>
                        <div class="social_icons">
                            <ul>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-facebook-square"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-twitter-square"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-google-plus-square"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="details">
                            <p>
                                Lorem ipsum dolor sit amet, consectt dipiscing elit esent vestibulum molestie lacus. Aenean nonmy hendrerit mauris. Phasellus porta. Fusce suit varius mi.
                            </p>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-2 box">
                        <div class="title">Company</div>
                        <div class="links">
                            <ul>
                                <li><a href="#">Link</a></li>
                                <li><a href="#">Link</a></li>
                                <li><a href="#">Link</a></li>
                                <li><a href="#">Link</a></li>
                                <li><a href="#">Link</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-2 box">
                        <div class="title">Links</div>
                        <div class="links">
                            <ul class="menu">
                                <li>
                                    <a href="index.php">Home</a>
                                </li>
                                <li>
                                    <a href="about-us.php">About</a>
                                </li>
                                <li>
                                    <a href="faq.php">FAQ</a>
                                </li>
                                <li>
                                    <a href="contact-us.php">Contact</a>
                                </li>
                                <li>
                                    <a href="register.php">Signup</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="showLogin">Login</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

        <div id="copyright">
            <div class="container">
                <p>
                    Copyright &copy; <?php echo date('Y');?> Timepry. All Rights Reserved
                </p>
            </div>
        </div>
    </footer>

    <div class="black_overlay"></div>
    <div id="loginBox">
        <div class="box_wrapper">
            <div class="section-heading">
                <h1>Login</h1>
                <div class="cus-hr"></div>
            </div>
            
            
            
            
            <div class="fields">
                <form class="login-form" action="<?php echo base_url(); ?>admin-sign/login" method="post">
                    <?php if($this->session->flashdata('message')){ ?>
					
						<?php if(!is_array($this->session->flashdata('message'))){ ?>
						
						<div class="alert alert-danger">
							<button class="close" data-close="alert"></button>
							
								<span><?php echo $this->session->flashdata('message'); ?></span>
							
						</div>
						
						<?php } ?>
                    <?php } ?>
                    <div class="form-group input-field">
                        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                        <!--<label class="control-label visible-ie8 visible-ie9"><?php echo _l('Username',$this); ?></label>-->
                        <input class="form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username" data-validation="required"/>
                    </div>
                    <div class="form-group input-field">
                        <!--<label class="control-label visible-ie8 visible-ie9"><?php echo _l('Password',$this); ?></label>-->
                        <input class="form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" data-validation="required"/>
                    </div>
                    <div class="form-group forget_pass">
                        <a href="javascript:void(0)" id="forgot_password-trigger">Forget Password?</a>
                    </div>
                    <div class="form-actions submit-btn">
                        <input type="submit" value="<?php echo _l('Login',$this); ?>" class="greyButton">
                    </div>
                </form>
            
            
                <!--<div class="input-field">
                    <input type="text" name="email" placeholder="Email">
                </div>
                <div class="input-field">
                    <input type="password" name="password" placeholder="Password">
                </div>
                
                <div class="submit-btn">
                    <input type="button" value="Login" class="greyButton">
                </div>
                <div id="errorMsg"></div>-->
            </div>
        </div>
    </div>

    <div id="forget_pass">
        <div class="box_wrapper">
            <div class="section-heading">
                <h1>Forgot Password</h1>
                <div class="cus-hr"></div>
            </div>
            <div class="fields">
                <div class="input-field">
                    <input type="text" name="email" placeholder="Enter Your Email">
                </div>
                <div class="submit-btn">
                    <input type="button" value="Submit" class="greyButton">
                </div>
                <div id="errorMsg"></div>
            </div>
        </div>
    </div>
    <div class="scroll-to-top">
        <i class="icon-arrow-up"></i>
    </div>

<div class="se-pre-con"></div>
    <script src="<?php echo base_url();?>assets/front/js/dropzone.js"></script>
    <script async defer src="<?php echo base_url();?>assets/front/js/bootstrap.min.js"></script>
    <script async defer src="<?php echo base_url();?>assets/front/js/slick.js"></script>
    <script async defer src="<?php echo base_url();?>assets/front/js/scripts.js"></script>
    <script async defer src="<?php echo base_url();?>assets/front/js/google-map.js"></script>

    <script src='<?php echo base_url();?>assets/front/js/lib/moment.min.js'></script>
    <script src='<?php echo base_url();?>assets/front/js/lib/fullcalendar.js'></script>

    
    <!--[if lt IE 9]>
    <script src="<?php echo base_url(); ?>assets/metronic/global/plugins/respond.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/metronic/global/plugins/excanvas.min.js"></script>
    <![endif]-->
    <script src="<?php echo base_url(); ?>assets/metronic/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
    <!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
    <script src="<?php echo base_url(); ?>assets/metronic/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/metronic/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/metronic/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/metronic/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/metronic/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/metronic/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/metronic/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/metronic/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="<?php echo base_url(); ?>assets/metronic/global/scripts/metronic.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/metronic/admin/layout3/scripts/layout.js" type="text/javascript"></script>
    <!--<script src='<?php echo base_url();?>assets/front/js/bootstrap-datetimepicker.min.js'></script>-->
    
    <script src='<?php echo base_url();?>assets/front/js/jquery.mask.js'></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/1.2.3/jquery.payment.min.js"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/front/js/payment.js"></script>
    
    <!-- END PAGE LEVEL SCRIPTS -->
    <?php if(isset($calendar_i18n) && in_array($lang, $calendar_i18n)){ ?>
        <script src="<?php echo base_url(); ?>assets/metronic/global/plugins/jquery-ui/ui/i18n/datepicker-<?php echo $lang; ?>.js" type="text/javascript"></script>
        <script>
            $(function(){
                $.datepicker.setDefaults( $.datepicker.regional[ "<?php echo $lang; ?>" ] );
            });
        </script>
    <?php } ?>
    
    
    <script>

   // $('.time').mask('00:00');
        $(document).ready(function() {

            $('.black_overlay').hide();
            $(".se-pre-con").css("display", "none");
            if ( $('.home-banner').length > 0 ) {
                setTimeout(function() {
                   // $('#site_auto_popup').show();
                    //$('.black_overlay').show();
                }, 2000);
            }
        });
        $('#mobilemenuBtn').on('click', function() {
            $('nav.menu_nav').toggleClass('show');
        });

        $('.showLogin').on('click', function() {
            $('#loginBox').show();
            $('.black_overlay').show();            
        });

        $('.black_overlay').on('click', function() {
            $('#loginBox').hide();
            $('#forget_pass').hide();
            $('#beforeCheckout_popout').hide();
            if ( $('#site_auto_popup').is(':hidden') ){
                $('.black_overlay').hide();
            }
        });
        $('#site_auto_popup .closepopup').on('click', function() {
            $('.black_overlay').hide();
            $('#site_auto_popup').hide();
        });

        $('.treatment-box .details_arrow').click(function() {
            $(this).find('i').toggleClass('fa-chevron-up fa-chevron-down');
            $(this).parents('.treatment-box').find('.treatment-details .detailsDiv').toggleClass('active');
        });

        var orderTotal = '0';
        $('.treatment-box .add_service').click(function() {

            orderTotal = '';
            var getPrice = $(this).parents('.treatment-box').find('.prices').text().replace('$', '');
            var price = $('#service_price').text();
            var servicesCount = $('#service_count').text();
            $(this).find('i').toggleClass('fa-plus-square-o fa-check-square');

            if ( $(this).find('i').hasClass('fa-check-square') ) {
                $(this).css('font-size', '25px');
                orderTotal =  Number(price) + Number(getPrice);
                $('#service_price').text( orderTotal );
                $('#service_count').text( Number(servicesCount) + 1 );
            }else{
                $(this).css('font-size', '30px');
                orderTotal =  Number(price) - Number(getPrice);
                $('#service_price').text( orderTotal );
                $('#service_count').text( Number(servicesCount) - 1 );                
            }
            
            if(orderTotal != '0'){
              $('.bottom-booknow').show();  
            }else{
              $('.bottom-booknow').hide();  
            }
            
            
        });

        $('#services_booknow').click(function() {
            //$('.black_overlay').show();
			//console.log("worked");
			$('#checkout').hide();
            var selectedServices = $('.tab-content').find('.fa-check-square');
            var bodyToAppend = '';
            var final_treatment = '';
            
            //console.log(selectedServices.length);

            console.log(orderTotal);
			
            if ( orderTotal == '0' || orderTotal == '' ) {
                $('#beforeCheckout_popout').find('.order_total').find('.greyButton').addClass('disabledAction');
            }else{
                $('#beforeCheckout_popout').find('.order_total').find('.greyButton').removeClass('disabledAction');
            }

            for (var i = 0; i < selectedServices.length; i++) {

                var serviceName = selectedServices.eq(i).parents('.treatment-box').find('.treatment-title').text();
                var serviceDuration = selectedServices.eq(i).parents('.treatment-box').find('.duration').html();
                var serviceRates = selectedServices.eq(i).parents('.treatment-box').find('.prices').text().replace('$', '');
                var serviceID = selectedServices.eq(i).parents('.treatment-box').find('.serviceID').text();

                bodyToAppend += '<div class="selservice_box" id="treat'+serviceID+'" onclick="$(function(){ $.selectprac('+serviceID+'); });">'
                        + '<div class="row">'
                        + '<div class="col-md-8">'
                        + '<div class="service_title">'+ serviceName +'</div>'
                        + '<div class="service_duration final_treatment_field'+serviceID+' duration">'+ serviceDuration +'</div>'
                        + '</div>'

                        + '<div class="col-md-4">'
                        + '<div class="service_rates">$<span class="price">'+ serviceRates +'</span></div>'
                        + '</div>'
                        
                        
                        + '<div class="col-md-12">'
                        + '<div class="col-md-4">'
                        + '<b>Practitioner:</b><br><span class="final_treatment_field'+serviceID+' practitionername"></span>'
                        + '</div>'
                        + '<div class="col-md-4">'
                        + '<b>Date:</b><br><span class="final_treatment_field'+serviceID+' date"></span>'
                        + '</div>'
                        + '<div class="col-md-4">'
                        + '<b>Time:</b><br><span class="final_treatment_field'+serviceID+' time"></span>'
                        + '</div>'
                        + '</div>'
                        + '</div>'
                        + '</div>';                                                                                                
                        
                        
                        
                        
                                                                                                                                                
         
                final_treatment += '<input type="hidden" class="final_treatment_field'+serviceID+' service" value="'+serviceID+'" name="service[]"/>'
                                + '<input type="hidden" class="final_treatment_field'+serviceID+' practitioner" name="practitioner[]"/>'
                                + '<input type="hidden" class="final_treatment_field'+serviceID+' date" name="date[]"/>'                                
                                + '<input type="hidden" class="final_treatment_field'+serviceID+' time" name="time[]"/>';
                                //+ '<input type="hidden" class="final_treatment_field'+serviceID+' fname" name="fname[]"/>'
                               // + '<input type="hidden" class="final_treatment_field'+serviceID+' lname" name="lname[]"/>'
                                //+ '<input type="hidden" class="final_treatment_field'+serviceID+' email" name="email[]"/>'
                                //+ '<input type="hidden" class="final_treatment_field'+serviceID+' phone" name="phone[]"/>';

            }
            
			
			
            //console.log(bodyToAppend);
            $('#selected_services').html(bodyToAppend);
            $('#final_treatment').html(final_treatment);
            $('#beforeCheckout_popout').find('.order_total').find('.total_prices .rates').text( orderTotal );
            $('#beforeCheckout_popout').find('.selservice_box').eq(0).trigger("click");
            $('#beforeCheckout_popout').show();
            getDiscount();
            
            $('html, body').animate({
                scrollTop: $(".modal-box").offset().top
            }, 1000);
			
			
			
        });

        $('.addmore_services').click(function() {
            $('.black_overlay').hide();
            $('#beforeCheckout_popout').hide();
        });

        $("#forgot_password-trigger").click(function() {
            $('#loginBox').hide();
            $('#forget_pass').show();
        });

        $("#loadMap").click(function() {
            setTimeout(function () {
                registerMap();
            }, 1300);
			
			
        });
    </script>

<script>

	$(document).ready(function() {

		$('#calendar').fullCalendar({
			header: {
				left: 'prev',
				center: 'title',
				right: 'next'
			},
			defaultDate: '2017-10-12',
			navLinks: true,
			editable: false,
            eventLimit: true, // allow "more" link when too many events
            displayEventTime: true,
            displayEventEnd: true,
            evenTimeFormat: 'small',
			events: [
				{
					title: 'Conference',
					start: '2017-10-11',
					end: '2017-10-11'
				},
				{
					title: 'Meeting',
					start: '2017-10-23T10:30:00',
					end: '2017-10-23T12:30:00'
				},
				{
					title: 'Lunch',
					start: '2017-10-23T12:00:00'
				},
				{
					title: 'Meeting',
					start: '2017-10-23T14:30:00'
				},
				{
					title: 'Happy Hour',
					start: '2017-10-23T17:30:00'
				},
				{
					title: 'Dinner',
					start: '2017-10-23T20:00:00'
				},
				{
					title: 'Test',
					start: '2017-10-23T20:00:00'
				},
				{
					title: 'Birthday Party',
					start: '2017-10-13T07:00:00'
				}
			]
        });
		
    });

</script>
    
    
    <script>
        jQuery(document).ready(function() {
            Metronic.init(); // init metronic core componets
            Layout.init(); // init layout
			
		
			
        });
    </script>
    <!-- END JAVASCRIPTS -->

    <script type="text/javascript" src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>
    <!--script for this page-->
    <script src="<?php echo base_url(); ?>assets/metronic/global/plugins/bootstrap-growl/jquery.bootstrap-growl.min.js"></script>

    <script>
        function check_search() {
            url = '<?=base_url().$lang?>/search?';
            var filter_search = $('input[name=\'search\']').attr('value');
            if (filter_search) {
            url += encodeURIComponent(filter_search);
//                url += "filter=" + filter_search.replace(/ /g,"_");
            }
            if (filter_search) {
                window.location = url;
            }
            return false;
        }
    </script>
    
    <script>
	
	var images = [];

	Dropzone.autoDiscover = true;

     Dropzone.options.imageUpload = {
		addRemoveLinks: true,
        maxFilesize:1,
        acceptedFiles: ".jpeg,.jpg,.png",
        addRemoveLinks: true
    };
		
		Dropzone.options.update5 = {
			maxFiles: 5,
		addRemoveLinks: true,
		
		 init: function () {
			 
			 this.on("maxfilesexceeded", function(file){
		bootbox.alert({
		title: '',
		message: "Maximum 5 Files Allowed",
		className: "my-popup2"
		});	
		
		 this.removeFile(file);
    });
			 
        this.on("processing", function (file) {
            
        });

		this.on("complete", function (file) {
			
        });

        this.on("success", function (file, response) {

var obj = JSON.parse(response);

if(obj.type == "success"){
	$(".uploadedImages").append("<input type='hidden' class='update5' name='imageName[]' value="+obj.imageName+">");
}


		if (this.getUploadingFiles().length === 0 && 
			this.getQueuedFiles().length === 0) {
				console.log(response);
				
				if(obj.type == "success"){
					bootbox.alert({
						title: '',
						message: "Image uploaded successfully!",
						className: "my-popup"
					});	
				}else{
					bootbox.alert({
						className: "my-popup",
						message : obj.message
					});
					//bootbox.alert( obj.message);
				}
		}

		console.log(images);

        });

        this.on("error", function (file, error, xhr) {

        });
		

	 }
    };
	

    </script>
	
	<!-- Stripe Events -->
   <script type="text/javascript">
// This identifies your website in the createToken call below
Stripe.setPublishableKey('pk_test_wYNVhacdiXdHg9lwJJ5bK33l');
 
var stripeResponseHandler = function(status, response) {
var $form = $('#payment-form');
 
if (response.error) {
// Show the errors on the form
$form.find('.payment-errors').text(response.error.message);
$form.find('button').prop('disabled', false);
} else {
	console.log("Payment was a success");
// token contains id, last4, and card type
var token = response.id;
// Insert the token into the form so it gets submitted to the server
$form.append($('<input type="hidden" name="stripeToken" />').val(token));
// and re-submit
//$form.get(0).submit();
// Serialize the form
var data=$('#payment-form').serialize(); 
// Send form to server with POST method
$(function() {
	$.ajax({
		type: "POST",
		url: "testphp.php",
		data: data,
		success: function(){
			$form.find('button').prop('disabled', false);
		}
	});
});
// Prevent page from refreshing
return false;
}
};
 
// ONCLICK RESPONSE 
jQuery(function($) {
$('#thebutton').on('click', function(e) {
var $form = $('#payment-form');
 
// Disable the submit button to prevent repeated clicks
$form.find('button').prop('disabled', true);
 
Stripe.card.createToken($form, stripeResponseHandler);
 
// Prevent the form from submitting with the default action
return false;
});
});
</script>
</body>
</html>