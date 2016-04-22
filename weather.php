
<!DOCTYPE html>

<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Reverse Geocoding</title>
	
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 100%;
      }
      #floating-panel {
        position: absolute;
        top: 10px;
        left: 99%;
       
        background-color: #fff;
       
        text-align: center;
        font-family: 'Roboto','sans-serif';
        line-height: 0px;
        padding-left: 0px;
      }
      
      #latlng {
        width: 0px;
		height: 0px;
      }
	  
    </style>

  </head>
  <body>
	<div id = "floating-panel">
	<input id="latlng" type="text" value="<?php echo $_GET["lat"]; ?>,<?php echo $_GET["lon"]; ?>,<?php echo $_GET["zoom"]; ?>">
	</div>
	
	
	
   
	<div id="weather">
    
	<?php
		/*
		$lati = 24.90;
		$longi = 91.8;
		$zoomi = 12;
		*/
		/*
		$lati = $_GET["lat"];
		$longi = $_GET["lon"];
		$zoomi = $_GET["zoom"];
		
		
		
		$json_string2 = file_get_contents("http://api.openweathermap.org/data/2.5/weather?lat=$lati&lon=$longi&appid=9625d5a354fb59b48949b112091f6b69");
		
		$openWeather_json = json_decode($json_string2);
		$home =  $openWeather_json->{'name'};
		

		$json_string1 = file_get_contents("http://api.wunderground.com/api/d213477ab5c32dd7/conditions/q/$home.json");
		$wunderground_json = json_decode($json_string1);
		
		$temp_c = $wunderground_json->{'current_observation'}->{'temperature_string'};
		$relative_humidity = $wunderground_json->{'current_observation'}->{'relative_humidity'};
		$wind_string = $wunderground_json->{'current_observation'}->{'wind_string'};
		$iconURL = $wunderground_json->{'current_observation'}->{'icon_url'};
		$weather = $wunderground_json->{'current_observation'}->{'weather'};
		$dewPoint = $wunderground_json->{'current_observation'}->{'dewpoint_string'};
		$visibility_mi = $wunderground_json->{'current_observation'}->{'visibility_mi'};
		$UV_index = $wunderground_json->{'current_observation'}->{'UV'};
	
		
		echo "<font color=\"#000080\" >";
		
		echo "<table border=\"1px\">";
		echo "<tr><td><b>${home}</b></br><i>${weather}</i></td>";
		echo "<td><img src=\"${iconURL}\" alt=\"Mountain View\"> </td><td><b>Temperature</b></br><i>${temp_c}</i></td><td><b>Humidity</b></br><i>${relative_humidity}</i></td><td><b>Wind Dir. and Speed</b></br><i>$wind_string</i></td><td><b>Dew point</b></br><i>${dewPoint}</i></td><td><b>Visibility</b></br><i>${visibility_mi}</i></td><td><b>UV</b></br><i>${UV_index}</i></td></tr></table>";
		
		echo "</font>";
		
	*/
	?>
	
	</div>
	
	<div id="map">
	<script>
	  
      function initMap() {
		var input = document.getElementById('latlng').value;
        var latlngStr = input.split(',', 3);
        var latlng = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};
		var zoomValue = parseInt(latlngStr[2]);
		
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: zoomValue,
          center: latlng
        });
		
		var image = 'https://cdn4.iconfinder.com/data/icons/yellow-commerce/100/.svg-18-48.png';
		
		var marker = new google.maps.Marker({
          position: latlng,
          map: map,
		  icon:image,
          title: latlng
        });
		
        var geocoder = new google.maps.Geocoder;
        var infowindow = new google.maps.InfoWindow;
        
      }

      function geocodeLatLng(geocoder, map, infowindow) {
        var input = document.getElementById('latlng').value;
        var latlngStr = input.split(',', 2);
        var latlng = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};
        geocoder.geocode({'location': latlng}, function(results, status) {
          if (status === google.maps.GeocoderStatus.OK) 
		  {
            if (results[1]) {
              map.setZoom(zoomValue);
              var marker = new google.maps.Marker({
                position: latlng,
                map: map
              });
              infowindow.setContent(results[1].formatted_address);
              infowindow.open(map, marker);
            } else {
              window.alert('No results found');
            }
          } else {
            window.alert('Geocoder failed due to: ' + status);
          }
        });
      }
	  
    </script>
    
	<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBTZQHG4prdW8CKW5CDZWmXNM4Mg-WO95k&v=3.2&callback=initMap">
    </script>
	
	</div>
	
  </body>
</html>