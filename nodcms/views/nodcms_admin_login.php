<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.4
Version: 3.3.0
Author: KeenThemes
Website: http:/www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http:/themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="<?php $_SESSION['language']['code']; ?>">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>
    <title><?php echo $setting["company"]; ?> - <?php echo _l('Administration',$this); ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <link rel="shortcut icon" href="<?=base_url().$setting["fav_icon"]?>">
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url(); ?>assets/metronic/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url(); ?>assets/metronic/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <?php if($_SESSION["language"]["rtl"]!=1){ ?>
        <link href="<?php echo base_url(); ?>assets/metronic/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/metronic/admin/pages/css/login.css" rel="stylesheet" type="text/css"/>
        <!-- BEGIN THEME STYLES -->
        <link href="<?php echo base_url(); ?>assets/metronic/global/css/components.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/metronic/global/css/plugins.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/metronic/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/metronic/admin/layout/css/themes/darkblue.css" rel="stylesheet" type="text/css" id="style_color"/>
        <link href="<?php echo base_url(); ?>assets/metronic/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
        <!-- END THEME STYLES -->
    <?php }else{ ?>
        <link href="<?php echo base_url(); ?>assets/metronic/rtl/global/plugins/bootstrap/css/bootstrap-rtl.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/metronic/rtl/admin/pages/css/login-rtl.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/metronic/rtl/global/css/components-rtl.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/metronic/rtl/global/css/plugins-rtl.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/metronic/rtl/admin/layout/css/layout-rtl.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/metronic/rtl/admin/layout/css/themes/darkblue-rtl.css" rel="stylesheet" type="text/css" id="style_color"/>
        <link href="<?php echo base_url(); ?>assets/metronic/rtl/admin/layout/css/custom-rtl.css" rel="stylesheet" type="text/css"/>
    <?php } ?>
    <!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
    <link href="<?php echo base_url(); ?>assets/metronic/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css"/>
    <!-- END PAGE LEVEL PLUGIN STYLES -->
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login">
<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGO -->
<div class="logo" style="background: #fff;">
    <a href="<?php echo base_url(); ?>">
        <img style="max-height: 80px;" src="<?php echo base_url().$setting['logo']; ?>" alt=""/>
    </a>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN LOGIN FORM -->
    <form class="login-form" action="<?php echo base_url(); ?>admin-sign/login" method="post">
        <h3 class="form-title"><?php echo _l('Login',$this); ?></h3>
        <?php if($this->session->flashdata('message')){ ?>
        <div class="alert alert-danger">
            <button class="close" data-close="alert"></button>
			<span><?php echo $this->session->flashdata('message'); ?></span>
        </div>
        <?php } ?>
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9"><?php echo _l('Username',$this); ?></label>
            <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username" data-validation="required"/>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9"><?php echo _l('Password',$this); ?></label>
            <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" data-validation="required"/>
        </div>
        <div class="form-group">
            <a href="#" class="reset-link pull-right">Reset password</a>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-success uppercase"><?php echo _l('Login',$this); ?></button>
        </div>
    </form>
    <!-- END LOGIN FORM -->
</div>
<div class="copyright">
    2017 &copy; Produced by <a href="http://www.techopialabs.com">Techopia Labs</a>
</div>
<!-- END LOGIN -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?php echo base_url(); ?>assets/metronic/global/plugins/respond.min.js"></script>
<script src="<?php echo base_url(); ?>assets/metronic/global/plugins/excanvas.min.js"></script>
<![endif]-->
<script src="<?php echo base_url(); ?>assets/metronic/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/metronic/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/metronic/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/metronic/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/metronic/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/metronic/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url(); ?>assets/metronic/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/metronic/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/metronic/admin/layout/scripts/layout.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
    jQuery(document).ready(function() {
        Metronic.init(); // init metronic core components
        Layout.init(); // init current layout
    });
</script
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>