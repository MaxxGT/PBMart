<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
	<div style="overflow:hidden;height:300px;width:400px;">
		<div id="gmap_canvas" style="height:300px; width:400px;"></div>
			<style>#gmap_canvas img{max-width:none!important;background:none!important}</style>
				<a class="google-map-code" href="http://wptiger.com/premium-wordpress-themes/" id="get-map-data">pretty good mobile themes</a>
	</div>
	<script type="text/javascript"> function init_map(){var myOptions = {zoom:19,center:new google.maps.LatLng(1.5070207278520444,110.32105485186764),mapTypeId: google.maps.MapTypeId.HYBRID};map = new google.maps.Map(document.getElementById("gmap_canvas"), myOptions);marker = new google.maps.Marker({map: map,position: new google.maps.LatLng(1.5070207278520444, 110.32105485186764)});infowindow = new google.maps.InfoWindow({content:"<b>PULAU BURUNG SDN.BHD</b><br/>Jalan Ketitir Batu Kawa<br/>93250 Kuching Sarawak" });google.maps.event.addListener(marker, "click", function(){infowindow.open(map,marker);});infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);</script>