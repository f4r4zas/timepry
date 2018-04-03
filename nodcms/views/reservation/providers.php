<?php
//Get the avg review for every provider
get_instance()->load->helper('reviews');
get_instance()->load->helper('distance');


 ?>
<style>
    .search_content .thumb_img {
        max-height: 275px;
        overflow: hidden;
        border-radius: 4px !important;
    }
	.search_content div {
	padding: 15px 20px;
}
.title {
	margin: 20px;
}
.details p {
	margin: 16px 25px;
	max-width: 100%;
	max-height: 40px;
	overflow: hidden;
	min-height: 12px;
}
.greyButton {
	margin: 0px 20px;
}
 #map_canvas {
	 height: 100%;
	 position: relative;
	height: 100% !important;
	padding-bottom: 150% !important;
	width: 100%;
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
        <div class="row athicating">
           <br>
			
			<form action="" id="zipform" method="get">
				<div class="form-group">
				
				<label>Zipcode
					<input type="text" value="<?php echo $this->input->get("zip"); ?>" name="zip" class="form-control" required>
				</label>
				
					<label>Distance
						<select name="distance" class="form-control" required>
							<option value="">Select</option>
							<option <?php if($this->input->get("distance") == "10"){echo "selected";} ?> value="10">Under 10KM</option>
							<option <?php if($this->input->get("distance") == "20"){echo "selected";} ?> value="20">Under 20KM</option>
							<option <?php if($this->input->get("distance") == "35"){echo "selected";} ?> value="35">Under 35KM</option>
							<option <?php if($this->input->get("distance") == "50"){echo "selected";} ?> value="50">Under 50KM</option>
							<option <?php if($this->input->get("distance") == "100"){echo "selected";} ?> value="100">Under 100KM</option>
							<option <?php if($this->input->get("distance") == "200"){echo "selected";} ?> value="200">Under 200KM</option>
							<option <?php if($this->input->get("distance") == "300"){echo "selected";} ?> value="300">Under 300KM</option>
						</select>
					</label>
					<input type="submit" value="Zip Search"  class="btn btn-primary">
				</div>
			</form>
			<br>
		   <div class="form-group">
			   <select name="selectfilter" class="form-control">
					<option value="">Most relevant</option>
					<option value="desc" data-class="hiddenRating">Rating of the dental office</option>
					<option value="asc" data-class="priceHidden">Lowest price on top</option>
					<option value="desc" data-class="priceHidden">Highest price on top</option>
				</select>
		   </div>
		   
            <div class="col-md-6 listing-provider">
               <div id="listId" class="res_wrapper">
                    <ul class="row-not list">       
					
            <?php 
				$addresses = array();
				$i = 0;
				$total = 0;
				$zipRecordsTotal=0;
				$count = count($data_list);
				foreach($data_list as $item){ 
				$total++;
				
				$userZipcountry = end(explode(",",$item['address']));
										
				if($this->input->get("zip") && $this->input->get("distance")){
					
					$userZip = $this->input->get("zip");
					$distance = getDistance($userZip." ,".$userZipcountry, $item['address'], "k");
					$userDistance = $this->input->get("distance");
					
					if($distance > $userDistance){
						continue;
					}else{
						$zipRecordsTotal++;
					}
				
				}
				
            ?>
           <li  class="row">
            <div class="col-md-12">
			
                <div class="search_content">
                    <div class="thumb_img">
					<?php if(!empty($item['image'])){ ?>
						<?php $images = json_decode($item['image']); ?>
						
						<?php if(is_array($images)){ ?>
								<img src="<?php echo base_url(); ?><?php 
							echo $images[0];
						?>" alt="Timepry">
						<?php }else{ ?>
							<img src="<?php echo base_url(); ?><?php 
							echo $item['image'];
						?>" alt="Timepry">
						<?php } ?>
						
						<!-- <img src="<?php echo base_url(); ?><?php 
						//echo $item['image'];
						?>" alt="Timepry"> -->
					<?php }else{ ?>
                        <img src="<?php echo base_url(); ?>/assets/front/images/search_re_thumb.png" alt="Timepry">
					<?php } ?>
                    </div>
					
					<div class="col-md-8">
						<div class="title"><?php echo $item['provider_name']; ?></div>
                    <div class="ratings">
					
					<?php  $review = getReviews($item['provider_id']); ?>
                       <?php for($i=1;$i<=5;$i++){ ?>
							<?php if($i<$review || $i==$review  ){ ?>
								<i class="fa fa-star"></i>
							<?php }else{ ?>
							<i class="fa fa-star no-ratings"></i>
							<?php  } ?>
						
						<?php  } ?>
   					    
				<div style="display:none" class="hiddenRating"><?php echo $review; ?></div>		
				<div style="display:none" class="priceHidden"><?php echo $item['price']; ?></div>
                    </div>
						<div class="clinic_address"><?php echo $item['address']; ?></div>
						<?php if($this->input->get("zip") & $this->input->get("distance")){ ?>
						<div class="distance">
						<span><strong>Distance</strong></span>
							<?php echo round($distance)." KM" ?>
						</div>
						<?php } ?>
						
						
						<div class="details">
								<?php echo $item['provider_description']; ?> 
						</div>
					</div>
					<div class="col-md-4">
					<br>
					<br>
						<div class="readMore_button">
							<a style="background-color: #518ed2;border: #518ed2;
" href="<?php echo base_url().$lang.'/provider/'.$item['provider_username']; ?>" class="greyButton"><?php echo _l('Book a time', $this); ?></a>
						</div>
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
				 
               </li> <!-- Row List -->
            <?php 
			$addresses[] = '"'.$item['address'].'"';
            }
            $comma_seperated = implode(",",$addresses);
             ?>
			</ul><!-- List ID -->	
			
			
			<?php if($this->input->get("zip") & $this->input->get("distance")){ ?>
			
				<?php if($zipRecordsTotal < 1){ ?>
				
					<div class="note note-warning">
						<h4 class="title"><?php echo _l('No result!', $this); ?></h4>
						<p class="text-lg">
							<?php echo _l("Your search", $this); ?>
							- <strong><?php echo $search_word; ?></strong> -
							<?php echo _l("Cannot locate any nearby clinics try increasing distance.", $this); ?>
						</p>
					</div>
				
				<?php } ?>
			
			<?php } ?>
			
			
			
			<ul class="pagination"></ul>
		</div>
     </div>
	 
    <div class="col-md-6 provider-map">
            <div id="map_canvas" style=""></div>
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

<script>


jQuery(document).ready(function(){
	
	var options = {
		valueNames: [ 'priceHidden', 'hiddenRating' ],
		page: 3,
		pagination: true
	};

    var listObj = new List('listId', options);
  
	//listObj.sort('hiddenRating', { order: "asc" }); 
  
  jQuery("[name='selectfilter']").change(function(){
	 
	 console.log($(this).val());
	 if($(this).val() == ""){
		 console.log("redirect");
		 window.location.href = window.location.href;
		 
	 }else{
		var values =  $(this).val();
		var options =  $("option:selected",this).attr('data-class');
		listObj.sort(options, { order: values });	
	 }

	 
  });
  
  
  jQuery("#zipform").submit(function(e){
	  e.preventDefault();
	  
	  var zip = "";
	  var distance = "";
	  if(jQuery("[name='zip']").val() != ""){
		  zip = jQuery("[name='zip']").val();
	  }else{
		  return false;
	  }
	  
	  if(jQuery("[name='distance']").val() != ""){
		  distance = jQuery("[name='distance']").val();
	  }else{
		  return false;
	  }
	  
	  
	  var fullUrl = updateQueryStringParameter(window.location.href,"distance",distance);
	  
	  var fullUrl = updateQueryStringParameter(fullUrl,"zip",zip);
	  
	  window.location.href = fullUrl;
	  
	  
  });
	
});


	function updateQueryStringParameter(uri, key, value) {
	  var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
	  var separator = uri.indexOf('?') !== -1 ? "&" : "?";
	  if (uri.match(re)) {
		return uri.replace(re, '$1' + key + "=" + value + '$2');
	  }
	  else {
		return uri + separator + key + "=" + value;
	  }
	}


</script>
