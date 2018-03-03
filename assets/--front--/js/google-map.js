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
        script.src = "//maps.googleapis.com/maps/api/js?key=AIzaSyAD7TOm3u657J9Itqd4eQpG2DAGIBA_FnU";
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

    var locations = [
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
    }

}