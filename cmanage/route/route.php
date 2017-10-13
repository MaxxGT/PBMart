<?php
	require_once("../../connection/pbmartconnection.php");
	session_start();
	
	if($_SESSION['validation'] == false){
		header("location:../authentication/login.php");
	}else{
	
	}
	
	$member = mysqli_query($dbconnect, "SELECT * FROM pbmart_member");
?>

<html>
	<head>
		<title>Route Planner</title>
		<link rel="stylesheet" type="text/css" href="../css/font.css">
		<link rel="stylesheet" type="text/css" href="../css/table.css">
		<link rel="stylesheet" type="text/css" href="../css/menu.css">
		<link rel="stylesheet" type="text/css" href="../css/960.css" />
		<link rel="stylesheet" type="text/css" href="../css/reset.css" />
		<link rel="stylesheet" type="text/css" href="../css/text.css" />
		<link rel="stylesheet" type="text/css" href="../css/red.css" />
		<link type="text/css" href="../css/smoothness/ui.css" rel="stylesheet" /> 
			<script type="text/javascript" src="../../ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
		<script type="text/javascript" src="../js/blend/jquery.blend.js"></script>
		<script type="text/javascript" src="../js/ui.core.js"></script>
		<script type="text/javascript" src="../js/ui.sortable.js"></script>    
		<script type="text/javascript" src="../js/ui.dialog.js"></script>
		<script type="text/javascript" src="../js/ui.datepicker.js"></script>
		<script type="text/javascript" src="../js/effects.js"></script>
		<script type="text/javascript" src="../js/flot/jquery.flot.pack.js"></script>
		<style>
		    #map-canvas {
				height: 100%;
				width:500px;
				margin: 0px;
				padding: 0px
			  }
			#panel {
				display:block;
				top: 20px;
				width:200px;
				float:left;
				z-index: 5;
				background-color: #FFFFF;
				
				border: 1px solid #999;
			  }
		</style>
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
	<script>
		var directionsDisplay;
		var directionsService = new google.maps.DirectionsService();
		var map;

		function initialize() {
			directionsDisplay = new google.maps.DirectionsRenderer();
			var Kuching = new google.maps.LatLng(1.506662, 110.345);
			var mapOptions = {
				zoom: 16,
				center: Kuching
			}
			// map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
			 
			 // This is the minimum zoom level that we'll allow
		var minZoomLevel = 12;

		var map = new google.maps.Map(document.getElementById('map-canvas'), {
			zoom: minZoomLevel,
			center: new google.maps.LatLng(1.56, 110.345),
			mapTypeId: google.maps.MapTypeId.ROADMAP
		});
		directionsDisplay.setMap(map);
	    // Bounds for North America
	    var strictBounds = new google.maps.LatLngBounds(
			new google.maps.LatLng(1.45, 110.26), 
			new google.maps.LatLng(1.65, 110.38)
	    );

		// Listen for the dragend event
		google.maps.event.addListener(map, 'dragend', function() {
			if (strictBounds.contains(map.getCenter())) return;

			// We're out of bounds - Move the map back within the bounds

			 var c = map.getCenter(),
				 x = c.lng(),
				 y = c.lat(),
				 maxX = strictBounds.getNorthEast().lng(),
				 maxY = strictBounds.getNorthEast().lat(),
				 minX = strictBounds.getSouthWest().lng(),
				 minY = strictBounds.getSouthWest().lat();

				 if (x < minX) x = minX;
				 if (x > maxX) x = maxX;
				 if (y < minY) y = minY;
				 if (y > maxY) y = maxY;

			map.setCenter(new google.maps.LatLng(y, x));
		});

	   // Limit the zoom level
	   google.maps.event.addListener(map, 'zoom_changed', function() {
		 if (map.getZoom() < minZoomLevel) map.setZoom(minZoomLevel);
	   });
		}

		function calcRoute() {
			var start = document.getElementById('start').value;
			var end = document.getElementById('end').value;
			var waypts = [];
			var checkboxArray = document.getElementById('waypoints');
			for (var i = 0; i < checkboxArray.length; i++) {
				if (checkboxArray.options[i].selected == true) {
					waypts.push({
						location:checkboxArray[i].value,
						stopover:true});
				}
			}

			var request = {
				origin: start,
				destination: end,
				waypoints: waypts,
				optimizeWaypoints: true,
				 travelMode: google.maps.TravelMode.DRIVING
			};
			directionsService.route(request, function(response, status) {
				if (status == google.maps.DirectionsStatus.OK) {
					directionsDisplay.setDirections(response);
					var route = response.routes[0];
					var summaryPanel = document.getElementById('directions_panel');
					summaryPanel.innerHTML = '';
					// For each route, display summary information.
					for (var i = 0; i < route.legs.length; i++) {
						var routeSegment = i + 1;
						summaryPanel.innerHTML += '<b>Route Segment: ' + routeSegment + '</b><br>';
						summaryPanel.innerHTML += route.legs[i].start_address + ' to ';
						summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
						summaryPanel.innerHTML += route.legs[i].distance.text + '<br><br>';
					}
				}
			});
		}

		google.maps.event.addDomListener(window, 'load', initialize);
    </script>
	</head>
	<body>
		<?php
		include('../header/header.php');
		?>
		<div class="grid_16">
			<!-- TABS START -->
			<div id="tabs">
				 <div class="container">
					<ul>
						<li><a href="route.php?hyperlink=routeplanner" class="current"><span>Route Planner</span></a></li>   
				   </ul>
				</div>
			</div>
			<!-- TABS END -->    
		</div>	
		<div class="grid_16" id="content">	
			<br />						
			<br />	
			<br />	
			<div id="map-canvas" style="float:left;width:70%;height:100%;"></div>
		
			<div id="control_panel" style="float:right;width:30%;text-align:left;padding-top:20px">	
				<div style="margin:20px;border-width:2px;">
					<b>Start:</b>
					<select id="start" disabled>
						<option value="jalan ketitir,kuching,malaysia">Jalan Ketitir</option>
					</select>
					<br>
				</div>
				<div id="waypointlist">
					<b>Waypoints:</b> <br>
					<i>(Ctrl-Click for multiple selection)</i> <br>	
					<select multiple id="waypoints" >
						<?php	while($member_display = mysqli_fetch_array($member)){
									$address = $member_display['member_street_name'].",".$member_display['member_city'].",".$member_display['member_country'];
						?>
									<option value="<?=$address?>"><?=$address?></option>
						<?php	}	?>
					</select>
				</div>
				<div id="waypointlist2" style="margin:20px;border-width:2px;">
					<b>End:</b>
					<select id="end" disabled>
						<option value="jalan ketitir,kuching,malaysia">Jalan Ketitir</option>
					</select>
					<br>
					<br>
					<input type="submit" value="Submit" onclick="calcRoute();">
				</div>
				<div id="directions_panel" style="margin:20px;background-color:#FFEE77;"></div>
				<br />						
				<br />
				<br />
			</div>
		</div>	
		<div class="grid_16" id="content">	
			<?php
				include('../footer.php');
			?>
		</div>	
	</body>
</html>