$(function () {

    if ( $('.page-home').length > 0 ) {
        // Asynchronously Load the map API 
        var script = document.createElement('script');
        script.src = "//maps.googleapis.com/maps/api/js?key=AIzaSyAD7TOm3u657J9Itqd4eQpG2DAGIBA_FnU&callback=initMap";
        document.body.appendChild(script);
    }

    if ( $('.dentist_registration').length > 0 ) {
        // Asynchronously Load the map API 
        var script = document.createElement('script');
        script.src = "//maps.googleapis.com/maps/api/js?key=AIzaSyDZ6v5rVNIY_XwJfCdIntpT1jNj0wLVReY&libraries=places&callback=initAutocomplete";
        document.body.appendChild(script);
    }
});

function initMap() {

    var locations = [
        ['Eifel Tower', 48.8583701, 2.2944813],
        ['Hôtel The Peninsula Paris', 48.8626334, 2.2883873],
        ['Pont de Bir-Hakeim', 48.8553489, 2.2891169],
        ['Lycée Janson de Sailly', 48.8585113, 2.2835808],
        ['Colette', 48.8624075, 2.3155527]
    ];

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 15,
        center: new google.maps.LatLng(48.8583701, 2.2944813),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var icon = {
        dental: {
            icon: '../images/teeth_marker.png'
        }
    };
    var marker, i;

    for (i = 0; i < locations.length; i++) {
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            map: map,
            icon: '../timepry_upd/images/teeth_marker.png'
        });

        google.maps.event.addListener(marker, 'click', (function (marker, i) {
            return function () {
                infowindow.setContent(locations[i][0]);
                infowindow.open(map, marker);
            }
        })(marker, i));
    }

}

function registerMap() {
    
    initAutocomplete();
    
    
    
    /*var locations = [
        ['Eifel Tower', 48.8583701, 2.2944813]
    ];

    var map = new google.maps.Map(document.getElementById('dentist_reg_map'), {
        zoom: 15,
        center: new google.maps.LatLng(48.8583701, 2.2944813),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var icon = {
        dental: {
            icon: '../images/teeth_marker.png'
        }
    };
    var marker, i;

    for (i = 0; i < locations.length; i++) {
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            map: map,
            icon: '../timepry_upd/images/teeth_marker.png'
        });

        google.maps.event.addListener(marker, 'click', (function (marker, i) {
            return function () {
                infowindow.setContent(locations[i][0]);
                infowindow.open(map, marker);
            }
        })(marker, i));
    }*/

}




var placeSearch, autocomplete;
      var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        //country: 'long_name',
        postal_code: 'short_name'
      };
	  
	 jQuery(document).ready(function(){
		 
		 try{
			 initAutocomplete();
		 }catch(err){
				
		 }
		 
	 });
	  
      function initAutocomplete() {
		  
		 
		  
		   var myLatLng = {lat: -25.363, lng: 131.044};
		 
        var map = new google.maps.Map(document.getElementById('dentist_reg_map'), {
          center: {lat: -33.8688, lng: 151.2195},
          zoom: 13,
          mapTypeId: 'roadmap'
        });
		
		

        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        //map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();
//fillInAddress();
          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            //var place = autocomplete.getPlace();

        for (var component in componentForm) {
          document.getElementById(component).value = '';
          document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
          if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
          }
        }
            
            
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              input.val("");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };
            
            /*var marker = new google.maps.Marker({
                map: map,
                position: latlng,
                draggable:true,
                anchorPoint: new google.maps.Point(0, -29)
            });*/

            // Create a marker for each place.
            markers.push(new google.maps.Marker({
              map: map,
              
              title: place.name,
              draggable:false,
              position: place.geometry.location
            }));
            
            google.maps.event.addListener(markers, 'click', (function (marker, i) {
                return function () {
                    infowindow.setContent(locations[i][0]);
                    infowindow.open(map, marker);
                }
            })(markers, i));
            
            /*google.maps.event.addListener(markers, 'dragend', function (event) {
                var latlng = {lat: this.getPosition().lat(), lng: this.getPosition().lng()};
                geocoder.geocode({'location': latlng}, function(results, status) {
                    if (status === 'OK') {
                        if (results[0]) {
                            map.setZoom(13);
                            markers.forEach(function(marker) {
                                marker.setMap(null);
                              });
                              markers = [];
                            
                            var marker = new google.maps.Marker({
                                position: latlng,
                                map: map
                            });
                            
                            
                        document.getElementById('pac-input').value = results[0].formatted_address;
                        let test  =  document.getElementById('pac-input');
                        autocomplete = new google.maps.places.Autocomplete(test);
                        autocomplete.bindTo('bounds', map);
                        let place = autocomplete.getPlace();
                        infowindow.setContent(results[0].formatted_address); 
                        infowindow.open(map, markers[0]);
                        //superThis.googleMap(results[0], superThis); 
                    
                    } else {
                    //   window.alert('No results found');
                    }
                  } else {
                    // window.alert('Geocoder failed due to: ' + status);
                  }
                });
            });*/
			
			/* var marker = new google.maps.Marker({
				  position: place.geometry.location,
				  map: map,
				  icon: "timepry/assets/front/images/teeth_marker.png",
				  title: place.name,
				draggable:true,
			}); */
			
            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
        });
      }