@extends('layout.default')
@section('script')
<script>
function initAutocomplete(){		
	
	var a =<?php echo json_encode($shopInfo); ?>;	
	var myLatlng = new google.maps.LatLng({lat:25.1499395,lng:121.7791801});
	var myOptions = {
				zoom: 13,
				center: myLatlng,
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				maxZoom   : 20,
				disableDefaultUI: true
			}			
	 var map = new google.maps.Map( document.getElementById("map"), myOptions );
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
	map.setOptions({styles: styles});
	var marker;
	var shopLatlng ;
	var infowindow =new google.maps.InfoWindow();
	for (var i=0; i<a.length;i++) {
		shopLatlng= new google.maps.LatLng({lat:a[i]['lat'],lng:a[i]['lng']});
	    marker= new google.maps.Marker({
	        map:map,
	        draggable:true,
	        animation: google.maps.Animation.DROP,
	        position: shopLatlng,
	        icon     : "img/point.png"
	    });

	    var contentstring = "<img style='width:300px;' src='shops/img/"+a[i]['img']+"'/img><h3>"+a[i]['name']+"</h3><div class='map_adresse'><div class='map_tel'><span class='tel'>電話 : </span>"+a[i]['tel']+"<div class='map_memo'><span class='memo'>備註 : </span>"+a[i]['memo']+"</div></div></div>";
	    google.maps.event.addListener(marker, 'click', (function(marker, content) {
        return function() {
          infowindow.setContent(content);
          infowindow.open(map, marker);
        }})(marker, contentstring));

	} 
}
</script>
@stop
@section('wrapper')  
<div id="map">
	</div><!-- end main/map -->
	<script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAP_APIKEY')}}&libraries=places&callback=initAutocomplete"></script>
	@stop