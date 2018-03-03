<script type="text/javascript">
    function check_request(){
        var input = $('#contact input.require');
        for(var i=0;i<input.length;i++){
            var each = input[i];
            if($(each).val()==''){
                alert('<?=_l('Please Fill Require Fealds',$this);?> '+ $(each).parent().parent().find('span.lbname').text()+'!');
                $(each).focus();
                return false;
            }
        }
    }
</script>


<!-- page start-->

<div class="container">
    <div class="row row-color">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <section class="panel">
                <header class="panel-heading">
                    <?=_l("Map",$this)?>
                    <span class="tools pull-right">
                                <a href="javascript:;" class="fa fa-chevron-down"></a>
                                <a href="javascript:;" class="fa fa-remove"></a>
                            </span>
                </header>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <h4 style="margin-top: 0;padding-top: 0"><?=$settings["company"]?></h4>
                            <p><i class="fa fa-phone-square"></i> <?=$settings["phone"]?></p>
                            <p><i class="fa fa-location-arrow"></i> <?=$settings["address"]?></p>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                            <div id="gmap_marker" class="gmaps"></div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <section class="panel">
                <header class="panel-heading">
                    <?=_l('Contact form',$this);?>
                </header>
                <div class="panel-body">
                    <?php if($this->session->flashdata('message_success')){?>
                        <div class="alert alert-success fade in">
                            <button type="button" class="close close-sm" data-dismiss="alert">
                                <i class="fa fa-times"></i>
                            </button>
                            <strong><?=_l('Success:',$this);?>  </strong> <?=_l('Your Request have been successfully sent!',$this);?>
                        </div>
                    <?php } ?>

                    <?php if($this->session->flashdata('message_error')){?>
                        <div class="alert alert-block alert-danger fade in">
                            <button type="button" class="close close-sm" data-dismiss="alert">
                                <i class="fa fa-times"></i>
                            </button>
                            <strong><?=_l('Oh snap!',$this);?></strong><?=_l('Problem with messages. Please notify the site administrator via the phone numbers listed',$this);?>
                        </div>
                    <?php } ?>

                    <form class="" id="contact" onsubmit="return check_request();" action="" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="name" class="control-label"><?=_l('Full Name',$this);?></label>
                                    <input type="text" id="name" name="data[name]" class="form-control require">

                                </div>
                                <div class="form-group">
                                    <label for="email" class="control-label"><?=_l('Email address',$this);?></label>
                                    <input type="text" id="email" name="data[email]" class="form-control require" placeholder="example@webmail.com">
                                </div>

                                <div class="form-group">
                                    <label for="subject" class="control-label"><?=_l('Subject',$this);?></label>
                                    <input type="text" id="subject" name="data[subject]" class="form-control require">
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="text" class="control-label"><?=_l('Request',$this);?></label>
                                    <textarea id="text" class="form-control" rows="10" name="data[text]"></textarea>
                                </div>
                            </div>
                        </div>


                        <div class="form-group text-center">
                            <input type="submit" class="btn btn-danger" value="<?=_l('Send email',$this);?>"/>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>
<script>

    function initMap() {
        var myLatLng = {lat: -25.363, lng: 131.044};

        var map = new google.maps.Map(document.getElementById('gmap_marker'), {
            zoom: 4,
            center: myLatLng
        });

        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: 'Hello World!'
        });
    }
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCfkzWoPeDKw-RbhGbYp3-RWGgzCVaHvZU&callback=initMap">
</script>
<!--<script type="text/javascript" src="http://maps.google.com/maps/api/js"></script>-->
<!--<script type="text/javascript" src="--><?php //echo base_url()?><!--assets/metronic/global/plugins/gmaps/gmaps.js"></script>-->
<!---->
<!--<script>-->
<!--    var GoogleMaps = function () {-->
<!---->
<!--        var mapMarker = function () {-->
<!--            var map = new GMaps({-->
<!--                div: '#gmap_marker',-->
<!--                lat: --><?php //echo substr($settings["location"],0,10)?>//,
//                lng: <?php //echo substr($settings["location"],11,10)?>
//            });
//            map.addMarker({
//                lat: <?//=substr($settings["location"],0,10)?>//,
//                lng: <?//=substr($settings["location"],11,10)?>//,
//                title: 'Lima',
//                details: {
//                    database_id: 42,
//                    author: 'HPNeo'
//                },
//                click: function (e) {
//                    if (console.log) console.log(e);
//                    alert('You clicked in this marker');
//                }
//            });
//        }
//        return {
//            //main function to initiate map samples
//            init: function () {
//                mapMarker();
//            }
//        };
//    }();
//    jQuery(document).ready(function() {
//        GoogleMaps.init();
//    });
//</script>
