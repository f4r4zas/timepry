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
        <link href="<?php echo base_url(); ?>assets/metronic/admin/layout3/css/layout.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/metronic/admin/layout3/css/themes/green-haze.css.css" rel="stylesheet" type="text/css" id="style_color"/>
        <link href="<?php echo base_url(); ?>assets/metronic/admin/layout3/css/custom.css" rel="stylesheet" type="text/css"/>
        <!-- END THEME STYLES -->
    <?php }else{ ?>
        <link href="<?php echo base_url(); ?>assets/metronic/global/plugins/bootstrap/css/bootstrap-rtl.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/metronic/global/plugins/uniform/css/uniform.default-rtl.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/metronic/global/css/components-rtl.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/metronic/global/css/plugins-rtl.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/metronic/admin/layout3/css/layout-rtl.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/metronic/admin/layout3/css/themes/default-rtl.css" rel="stylesheet" type="text/css" id="style_color"/>
        <link href="<?php echo base_url(); ?>assets/metronic/admin/layout3/css/custom-rtl.css" rel="stylesheet" type="text/css"/>
    <?php } ?>
    <!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
    <link href="<?php echo base_url(); ?>assets/metronic/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css"/>
    <!-- END PAGE LEVEL PLUGIN STYLES -->

    <script src="<?php echo base_url(); ?>assets/metronic/global/plugins/jquery.min.js" type="text/javascript"></script>

    <script type="text/javascript">
            $('img').error(function(){
               <?php if(isset($settings['default_image']) && $settings['default_image']!="") {?>
               $(this).attr('src','<?php echo base_url(); ?><?php echo image($settings['default_image'],$settings['default_image'],220,120);?>');
              <?php } else {?>
              $(this).attr('src','<?php echo base_url(); ?><?php echo image("assets/frontend/img/noimage.jpg","assets/frontend/img/noimage.jpg",220,120);?>');
              <?php }?>
            });
    </script>
</head>
<body>

<div class="page-header">
    <!-- BEGIN HEADER TOP -->
    <div class="page-header-top">
        <div class="container">
            <!-- BEGIN LOGO -->
            <div class="page-logo">
                <a href="<?php echo base_url().$lang; ?>"><img style="max-height: 30px;" src="<?=base_url($settings["logo"])?>" alt="<?=isset($settings["company"])?$settings["company"]:""?>" title="<?=isset($settings["company"])?$settings["company"]:""?>" class="logo-default"></a>
            </div>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="menu-toggler"></a>
            <!-- END RESPONSIVE MENU TOGGLER -->
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <?php foreach($languages as $item) {?>
                        <?php if($item["language_id"]!=$_SESSION["language"]["language_id"]){ ?>
                            <li><a href="<?=$item["lang_url"]?>"> <?php if(isset($item['image'])){ ?><img src="<?=base_url().$item["image"]?>" style="width: 18px"><?php } ?> <?=$item['language_name']?></a></li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
    </div>
    <!-- END HEADER TOP -->
    <!-- BEGIN HEADER MENU -->
    <div class="page-header-menu">
        <div class="container">
            <?php if($this->_website_info['appointment_multiowner']){ ?>
                <form method="GET" action="<?php echo base_url().$lang; ?>" class="search-form" onsubmit="check_search()">
                    <div class="input-group">
                        <input type="text" name="search" placeholder="<?php echo _l("Search", $this); ?>" value="<?php echo isset($search_word)?$search_word:''; ?>" class="form-control">
                        <span class="input-group-btn">
					<a class="btn submit" href="javascript:;"><i class="icon-magnifier"></i></a>
					</span>
                    </div>
                </form>
            <?php } ?>
            <div class="hor-menu ">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="<?php  echo base_url().$lang; ?>"><?php echo _l("Home",$this); ?></a>
                    </li>
                    <?php if($settings['registration']==1){ ?>
                        <li>
                            <a href="<?php echo base_url().$lang; ?>/user-registration"><?php echo _l("Registration",$this); ?></a>
                        </li>
                    <?php } ?>
                    <?php if(isset($data_menu) && count($data_menu)!=0){ ?>
                        <?php foreach($data_menu as $item){ ?>
                            <li>
                                <a href="<?php echo $item["url"]; ?>"><?php echo $item["name"]; ?></a>
                            </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </div>
            <!-- END MEGA MENU -->
        </div>
    </div>
    <!-- END HEADER MENU -->
</div>
<div class="page-container">
    <div class="page-head">
        <div class="container">
            <div class="row">
                <div class="col-sm-9">
                    <div class="page-title">
                        <h1><?php echo $title; ?> <?php if(isset($sub_title)){ ?><small><?php echo $sub_title; ?></small><?php } ?></h1>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="navbar">
                        <ul class="nav navbar-nav navbar-right">
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content">
        <?php echo $content; ?>
    </div>
</div>

    <div class="page-prefooter">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 footer-block">
                    <h2><?php echo _l('About', $this); ?></h2>
                    <p>
                        <?php echo isset($description)?$description:''; ?>
                    </p>
                </div>
                <div class="col-sm-3 footer-block">
                    <h2><?php echo _l('Contacts',$this); ?></h2>
                    <address class="margin-bottom-40">
                        <?php if($settings['phone']!=''){ ?>
                            <p><i class="icon-call-end"></i> <?php echo $settings['phone']; ?></p>
                        <?php } ?>
                        <?php if($settings['email']!=''){ ?>
                            <p><i class="fa fa-envelope-o"></i> <a href="mailto:<?php echo $settings['email']; ?>"><?php echo $settings['email']; ?></a></p>
                        <?php } ?>
                        <?php if($settings['address']!=''){ ?>
                            <p><i class="glyphicon glyphicon-map-marker"></i> <?php echo $settings['address']; ?></p>
                        <?php } ?>
                    </address>
                </div>
                <div class="col-sm-3 footer-block">
                    <h2><?php echo _l('Menu',$this); ?></h2>
                    <p>
                        <a class="font-grey-cararra" href="<?php  echo base_url().$lang; ?>"><?php echo _l("Home",$this); ?></a>
                    </p>
                    <?php if($settings['registration']==1){ ?>
                        <p>
                            <a class="font-grey-cararra" href="<?php echo base_url().$lang; ?>/user-registration"><?php echo _l("Registration",$this); ?></a>
                        </p>
                    <?php } ?>
                    <?php if(isset($data_menu) && count($data_menu)!=0){ ?>
                        <?php foreach($data_menu as $item){ ?>
                            <p>
                                <a class="font-grey-cararra" href="<?php echo $item["url"]; ?>"><?php echo $item["name"]; ?></a>
                            </p>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <!-- END PRE-FOOTER -->
    <!-- BEGIN FOOTER -->
    <div class="page-footer">
        <div class="container">
            <?php echo isset($settings["options"]["company"])?$settings["options"]["company"]:$settings["company"]?> <i class="fa fa-copyright"></i> <?php echo date("Y")?> <a href="http://codecanyon.net/item/appointment-management-system-nodaps/16197805" target="_blank" title="Purchase NodAPS just $24">Purchase NodAPS</a>
        </div>
    </div>
    <div class="scroll-to-top">
        <i class="icon-arrow-up"></i>
    </div>
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
</body>
</html>