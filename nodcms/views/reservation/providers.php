<style>
    .search_content .thumb_img {
        max-height: 275px;
        overflow: hidden;
        border-radius: 4px !important;
    }
</style>
<section class="inner-page-banner">
    <div class="banner_wrapper">
        <div class="banner_content">
            <h1>Search Result</h1>
        </div>
    </div>
</section>
<section class="search_body">
<div class="container-fluid">
    <?php if(isset($data_list) && count($data_list)!=0){ $i = 0; ?>
        <div class="row">
            
            <div class="col-md-6 listing-provider">
                <div class="res_wrapper">
                    <div class="row-not">
                        
            <?php 
            $addresses = array();
            $i = 0;
			$total = 0;
			$count = count($data_list);
            foreach($data_list as $item){ 
			$total++;
            if ( $i == 0 ) {
                echo '<div class="row rflex">';
            }
            $i++;
            ?>
            
            <div class="col-md-6">
                <div class="search_content">
                    <div class="thumb_img">
					<?php if(!empty($item['image'])){ ?>
						<img src="<?php echo base_url(); ?><?php 
						echo $item['image'];
						?>" alt="Timepry">
					<?php }else{ ?>
                        <img src="<?php echo base_url(); ?>/assets/front/images/search_re_thumb.png" alt="Timepry">
					<?php } ?>
                    </div>
                    <div class="title"><?php echo $item['provider_name']; ?></div>
                    <!--<div class="ratings">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                    </div>-->
                    <div class="clinic_address"><?php echo $item['address']; ?></div>
                    <div class="details">
                        <p>
                            <?php echo $item['provider_description']; ?> 
                        </p>
                    </div>
                    <div class="readMore_button">
                        <a href="<?php echo base_url().$lang.'/provider/'.$item['provider_username']; ?>" class="greyButton"><?php echo _l('Book a time', $this); ?></a>
                    </div>
                </div>
            </div>
            
            
            
            
                <!--<div class="col-md-6">
                    <div class="portlet light">
                        <div class="portlet-title">
                            <h3 class="caption">
                                <a class="caption-subject bold font-green" href="<?php echo base_url().$lang.'/provider/'.$item['provider_username']; ?>"><?php echo $item['provider_name']; ?></a>
                                <span class="caption-helper"><i class="fa fa-calendar"></i> <?php echo my_int_date($item['created_date']); ?></span>
                            </h3>
                        </div>
                        <div class="portlet-body">
                            <div>
                                <?php echo $item['provider_description']; ?>
                            </div>
                            <p>
                                <a href="<?php echo base_url().$lang.'/provider/'.$item['provider_username']; ?>" class="btn blue">
                                    <?php echo _l('Book a time', $this); ?> <i class="m-icon-swapright m-icon-white"></i>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>-->
                <?php if( ( ($i+1) % 3 ) !=0 ){ ?>
                    <!-- <div class="clearfix"></div> -->
                <?php } 
				
				if($i== 1){
					
					if($count == $total){
						echo '</div>';
					}
					
				}
				
                if ( $i == 2 ) {
                    echo '</div>';
                    $i = 0;
                }
                ?>
            <?php 
            $addresses[] = '"'.$item['address'].'"';
			
            }
            
            $comma_seperated = implode(",",$addresses);
            
            //echo $comma_seperated;
             ?>
        </div>
    </div>
        
        <?php echo isset($pagination)?$pagination:""; ?>
        </div>

    <div class="col-md-6 provider-map">
            <div id="map_canvas" style="height:100%;"></div>
    </div>
<script>
/*$(document).ready(function () {
    var map;
    var elevator;
    var myOptions = {
        zoom: 10,
        center: new google.maps.LatLng(0, 0),
        mapTypeId: 'terrain'
    };
    map = new google.maps.Map($('#map_canvas')[0], myOptions);
    var bounds = new google.maps.LatLngBounds();
    var addresses = [<?php echo $comma_seperated;?>];

    for (var x = 0; x < addresses.length; x++) {
        $.getJSON('http://maps.googleapis.com/maps/api/geocode/json?address='+addresses[x]+'&sensor=false', null, function (data) {
            var p = data.results[0].geometry.location
            var latlng = new google.maps.LatLng(p.lat, p.lng);
            new google.maps.Marker({
                position: latlng,
                map: map
            });
            bounds.extend(marker.position);
        });
    }
    
    map.fitBounds(bounds);
    map.setZoom(3);

});*/

function initialize() {
    var locations = [
        ['DESCRIPTION', 41.926979, 12.517385, 3],
        ['DESCRIPTION', 41.914873, 12.506486, 2],
        ['DESCRIPTION', 61.918574, 12.507201, 1]
    ];
    
    var addresses = [<?php echo $comma_seperated;?>];

    window.map = new google.maps.Map(document.getElementById('map_canvas'), {
	    center: new google.maps.LatLng(45, -122),
    zoom: 4,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var bounds = new google.maps.LatLngBounds();
	
    //for (var x = 0; x < addresses.length-6; x++) {
    for (var x = 0; x < addresses.length; x++) {
		console.log("worked");
       /* marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            map: map
        });*/
        
         $.getJSON('http://maps.googleapis.com/maps/api/geocode/json?address='+addresses[x]+'&sensor=false', null, function (data) {
             console.log(data);
             console.log("================");
             try {
                var p = data.results[0].geometry.location;
                var latlng = new google.maps.LatLng(p.lat, p.lng);
             } catch (error) {
                 console.log(error);         
             }
			 console.log(latlng);
            marker = new google.maps.Marker({
                position: latlng,
                map: map,
                icon: '<?php echo base_url();?>assets/front/images/teeth_marker.png'
            });
            bounds.extend(marker.position);
            });

        

        /*google.maps.event.addListener(marker, 'click', (function (marker, i) {
            return function () {
                infowindow.setContent(locations[i][0]);
                infowindow.open(map, marker);
            }
        })(marker, i));*/
    }

    map.fitBounds(bounds);

    var listener = google.maps.event.addListener(map, "idle", function () {
        map.setZoom(5);
        google.maps.event.removeListener(listener);
    });
}

function loadScript() {
    var script = document.createElement('script');
    script.type = 'text/javascript';
	script.id = "bla";
    script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDZ6v5rVNIY_XwJfCdIntpT1jNj0wLVReY&v=3.exp&sensor=false&' + 'callback=initialize';
    document.body.appendChild(script);
}

jQuery(document).ready(function(){
	loadScript();
	console.log("scripted");
});

$(function() {
    // setTimeout(function() {
        
    // }, 800);
});
</script>        
    <?php }else{ ?>
        <div class="portlet light">
            <div class="portlet-body">
                <div class="note note-warning">
                    <h4 class="title"><?php echo _l('No result!', $this); ?></h4>
                    <p class="text-lg">
                        <?php echo _l("Your search", $this); ?>
                        - <strong><?php echo $search_word; ?></strong> -
                        <?php echo _l("did not match any providers.", $this); ?>
                    </p>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
</section>

