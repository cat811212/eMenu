function initAutocomplete(){
		var myLatlng = new google.maps.LatLng(121.7791801,25.1499395);
		var map = new google.maps.Map(document.getElementById('small-map'), {
		    center: {lat: 25.1499395, lng: 121.7791801},
		    zoom: 14,
		    mapTypeId: google.maps.MapTypeId.ROADMAP
  		});
  		var marker = new google.maps.Marker({
			    position : myLatlng,
			    map      : map,
			    icon     : "img/point.png"
			});
			var styles = [
			  {
			    featureType: "all",
			    stylers: [
			      { saturation: -80 }
			    ]
			  },{
			    featureType: "road.arterial",
			    elementType: "geometry",
			    stylers: [
			      { hue: "#00ffee" },
			      { saturation: 50 }
			    ]
			  },{
			    featureType: "poi.business",
			    elementType: "labels",
			    stylers: [
			      { visibility: "off" }
			    ]
			  }
			];	
  		// Create the search box and link it to the UI element.
		var input = document.getElementById('pac-input');
		var searchBox = new google.maps.places.SearchBox(input);
		map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
		map.setOptions({styles: styles});
		// Bias the SearchBox results towards current map's viewport.
		map.addListener('bounds_changed', function() {
		searchBox.setBounds(map.getBounds());
		});

		markers = [];
		// [START region_getplaces]
		// Listen for the event fired when the user selects a prediction and retrieve
		// more details for that place.
		searchBox.addListener('places_changed', function() {
		var places = searchBox.getPlaces();

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
		  var icon = {
		    url: place.icon,
		    size: new google.maps.Size(71, 71),
		    origin: new google.maps.Point(0, 0),
		    anchor: new google.maps.Point(17, 34),
		    scaledSize: new google.maps.Size(25, 25)
		  };

		  // Create a marker for each place.
		  markers.push(new google.maps.Marker({
		    map: map,
		    icon: icon,
		    title: place.name,
		    position: place.geometry.location
		  }));

		  if (place.geometry.viewport) {
		    // Only geocodes have viewport.
		    bounds.union(place.geometry.viewport);
		  } else {
		    bounds.extend(place.geometry.location);
		  }
		});
		map.fitBounds(bounds);
		});
		google.maps.event.addListener(map, 'click', function(event) {
			//	alert( "Latitude: "+event.latLng.lat()+" "+", longitude: "+event.latLng.lng() ); 
				marker.setPosition(event.latLng);
				$('#shop-lat').val(event.latLng.lat());
				$('#shop-lng').val(event.latLng.lng());
			  // infowindow.open(map,marker);
			});
		// [END region_getplaces]


	}
// jQuery(function($){

// 	var longitude = 25.1499395;
// 	var latitude = 121.7791801;
// 	var canvas = "map";
// 	var small_canvas = "small-map";

// 	function randing_small_map(canvas, lan, lat){			
// 			var myLatlng = new google.maps.LatLng(lan,lat);
// 			var input = document.getElementById('pac-input');
//   			var searchBox = new google.maps.places.SearchBox(input);
  			

// 			var myOptions = {
// 						zoom: 13,
// 						center: myLatlng,
// 						mapTypeId: google.maps.MapTypeId.ROADMAP,
// 						maxZoom   : 20,
//     					disableDefaultUI: true
// 					}			
// 			var map = new google.maps.Map( document.getElementById(canvas), myOptions );
// 			var marker = new google.maps.Marker({
// 			    position : myLatlng,
// 			    map      : map,
// 			    icon     : "img/point.png"
// 			});
// 			var styles = [
// 			  {
// 			    featureType: "all",
// 			    stylers: [
// 			      { saturation: -80 }
// 			    ]
// 			  },{
// 			    featureType: "road.arterial",
// 			    elementType: "geometry",
// 			    stylers: [
// 			      { hue: "#00ffee" },
// 			      { saturation: 50 }
// 			    ]
// 			  },{
// 			    featureType: "poi.business",
// 			    elementType: "labels",
// 			    stylers: [
// 			      { visibility: "off" }
// 			    ]
// 			  }
// 			];	
// 			map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
// 			var infowindow = new google.maps.InfoWindow({
// 				content:"<div class='map_adresse'><div class='map_address'><span class='address'>Address : </span>1401 South Grand Avenue Los Angeles, CA 90015</div> <div class='map_tel'><span class='tel'>Phone : </span>(213) 748-2411</div></div>"
// 			});	
			
// 			map.setOptions({styles: styles});
// 			// Bias the SearchBox results towards current map's viewport.
// 		  map.addListener('bounds_changed', function() {
// 		    searchBox.setBounds(map.getBounds());
// 		  });
// 		  searchBox.addListener('places_changed', function() {
// 		    var places = searchBox.getPlaces();

// 		    if (places.length == 0) {
// 		      return;
// 		    }

// 		    // Clear out the old markers.
// 		    markers.forEach(function(marker) {
// 		      marker.setMap(null);
// 		    });
// 		    markers = [];

// 		    // For each place, get the icon, name and location.
// 		    var bounds = new google.maps.LatLngBounds();
// 		    places.forEach(function(place) {
// 		      var icon = {
// 		        url: place.icon,
// 		        size: new google.maps.Size(71, 71),
// 		        origin: new google.maps.Point(0, 0),
// 		        anchor: new google.maps.Point(17, 34),
// 		        scaledSize: new google.maps.Size(25, 25)
// 		      };

// 		      // Create a marker for each place.
// 		      markers.push(new google.maps.Marker({
// 		        map: map,
// 		        icon: icon,
// 		        title: place.name,
// 		        position: place.geometry.location
// 		      }));

// 		      if (place.geometry.viewport) {
// 		        // Only geocodes have viewport.
// 		        bounds.union(place.geometry.viewport);
// 		      } else {
// 		        bounds.extend(place.geometry.location);
// 		      }
// 		    });
// 		    map.fitBounds(bounds);
// 		  });
// 			google.maps.event.addListener(map, 'click', function(event) {
// 			//	alert( "Latitude: "+event.latLng.lat()+" "+", longitude: "+event.latLng.lng() ); 
// 				marker.setPosition(event.latLng);
// 				$('#shop-lat').val(event.latLng.lat());
// 				$('#shop-lng').val(event.latLng.lng());
// 			  // infowindow.open(map,marker);
// 			});
// 	}
// //	randing_small_map(small_canvas, longitude, latitude);

	 

// });