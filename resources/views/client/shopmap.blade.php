@extends('layout.default')
@section('script')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAsKlLtAYz6kcI5YZ1EpvL6R-HJbOGI1_4"></script>
   <!--  <script type="text/javascript" src="{{URL::asset('js/map.js')}}"></script> -->
   <script>
   	jQuery(function($){

	var longitude = 121.7791801;
	var latitude = 25.1499395;
	var canvas = "map";
	var small_canvas = "small-map";
	

	function randing_map(canvas, lan, lat){		

			var a =<?php echo json_encode($shopInfo); ?>;	
			var myLatlng = new google.maps.LatLng({lat:latitude,lng:longitude});
			var myOptions = {
						zoom: 13,
						center: myLatlng,
						mapTypeId: google.maps.MapTypeId.ROADMAP,
						maxZoom   : 20,
    					disableDefaultUI: true
					}			
			 var map = new google.maps.Map( document.getElementById(canvas), myOptions );
			// var marker = new google.maps.Marker({
			//     position : myLatlng,
			//     map      : map,
			//     icon     : "img/point.png"
			// });
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

			// var infowindow = new google.maps.InfoWindow({
			// 	content:"<div class='map_adresse'><div class='map_address'><span class='address'>Address : </span>1401 South Grand Avenue Los Angeles, CA 90015</div> <div class='map_tel'><span class='tel'>Phone : </span>(213) 748-2411</div></div>"
			// });	
			for (var i=0; i<a.length;i++) {
				var shopLatlng = new google.maps.LatLng({lat:a[i]['lat'],lng:a[i]['lng']});
			    var marker = new google.maps.Marker({
			        map:map,
			        draggable:true,
			        animation: google.maps.Animation.DROP,
			        position: shopLatlng
			    });

			    var contentstring = "<img style='width:300px;' src='shops/img/"+a[i]['img']+"'/img><h3>"+a[i]['name']+"</h3><div class='map_adresse'><div class='map_tel'><span class='tel'>電話 : </span>"+a[i]['tel']+"<div class='map_memo'><span class='memo'>備註 : </span>"+a[i]['memo']+"</div></div></div>";

			    var infowindow = new google.maps.InfoWindow({
			        content: contentstring
			    });

			    google.maps.event.addListener(marker, 'click', function() {
			        infowindow.open(map,marker);
			    });

			} 
			map.setOptions({styles: styles});

			// google.maps.event.addListener(map, 'click', function(event) {
			// //	alert( "Latitude: "+event.latLng.lat()+" "+", longitude: "+event.latLng.lng() ); 

			//   infowindow.open(map,marker);
			// });
	}
	randing_map(canvas, longitude, latitude);
});
   </script>
@stop
@section('wrapper')  
<div id="map">
	</div><!-- end main/map -->
	
	@stop