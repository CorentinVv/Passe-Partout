function initMap(){
	var map = new google.maps.Map(document.getElementById('map_canvas'), {
      zoom: 13,
      center: {lat: -34.397, lng: 150.644}
    });
	var geocoder = new google.maps.Geocoder();

	var adresse = adresseMap;

	geocodeAddress(geocoder, map, adresse);

	$('#cacheDefi > div > div.footDefi > div.helpDoc > img').click(function() {
		google.maps.event.trigger(map, 'resize');
	});
	
	// geocoder.getLatLng(address, function(point) {
	//          var latitude = point.y;
	//          var longitude = point.x;  

	//          alert("latitude : ".latitude+"longitude : "+longitude);
	// });
}

function geocodeAddress(geocoder, resultsMap, adresse) {
	// 	var myOptions = {
// 		zoom:14,center:new google.maps.LatLng(50,6),mapTypeId: google.maps.MapTypeId.ROADMAP
// 	};
    var address = adresse;
    geocoder.geocode({'address': address}, function(results, status) {
      if (status === 'OK') {
      	// var data = document.getElementById('dataMap');
      	// data.innerHTML = results[0].geometry.location+"<br>Latitude : "+results[0].geometry.location.lat()+"<br>Longitude : "+results[0].geometry.location.lng();

        // resultsMap.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
          map: resultsMap,
          position: results[0].geometry.location
        });

        google.maps.event.trigger(resultsMap, "resize");
		    resultsMap.panTo(marker.getPosition());
		    resultsMap.setZoom(13);
      } else {
        console.log('Geocode was not successful for the following reason: ' + status);
      }
    });
}