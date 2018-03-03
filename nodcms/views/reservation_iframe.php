<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?$lang?>">
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

    <link href='http://fonts.googleapis.com/css?family=Dosis|Lato|Poiret+One|BenchNine|Anton|Electrolize|Marvel|Coda' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="<?php echo base_url()?>assets/reservation/jquery-ui/jquery-ui.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" />

    <link href="<?=base_url()?>assets/reservation/css/style.css" rel="stylesheet">
    <?php if($_SESSION["language"]["rtl"]==1){ ?>
    <link href="<?=base_url()?>assets/reservation/css/rtl.css" rel="stylesheet">
    <?php } ?>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
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
    <div class="info-bar">
        <div class="container">
            <div class="col-sm-6">
                <p><i class="fa fa-phone"></i> <?php echo $settings['phone']; ?></p>
            </div>
            <div class="col-sm-6 text-right">
                <p><i class="fa fa-map-marker"></i> <?php echo $settings['address']; ?></p>
            </div>
        </div>
    </div>
    <div class="container container-sm">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?=base_url().$lang."/"?>"><img style="max-height: 100%;" src="<?php echo base_url().$settings['logo']; ?>" alt="<?php echo $title; ?>" title="<?php echo $title; ?>"></a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <?php foreach($languages as $item) {?>
                            <?php if($item["language_id"]!=$_SESSION["language"]["language_id"]){ ?>
                                <li><a href="<?=$item["lang_url"]?>"> <?php if(isset($item['image'])){ ?><img src="<?=base_url().$item["image"]?>" style="width: 24px"><?php } ?> <span class="title"><?=$item['language_name']?></span></a></li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
    </div>
    <?php echo $content; ?>

    <script src="<?=base_url()?>assets/reservation/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>assets/reservation/jquery-ui/jquery-ui.min.js"></script>
    <script>
        function check_search() {
            url = '<?=base_url().$lang?>/search?';
            var filter_search = $('input[name=\'filter_search\']').attr('value');
            if (filter_search) {
//            url += encodeURIComponent(filter_search);
                url += "filter=" + filter_search.replace(/ /g,"_");
            }
            if (filter_search) {
                window.location = url;
            }
            return false;
        }
    </script>
    <footer>
        <div class="text-center"><?=isset($settings["options"]["company"])?$settings["options"]["company"]:$settings["company"]?> <i class="fa fa-copyright"></i> <?php echo date("Y")?> </div>
    </footer>
</body>
</html>