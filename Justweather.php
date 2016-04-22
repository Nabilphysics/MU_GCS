
<!DOCTYPE html>

<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Local Weather</title>
	
    <style>
	table#t01 {
		width: 100%;
		font-family: 'Microsoft Sans Serif,7pt';
		background-color: #8080FF;
	} 
	
	
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
        left: 100%;
       
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
		echo "
		
		<html>
		
		<head>
		<link rel=\"stylesheet\" href=\"table.css\" type=\"text/css\"/>	
		</head>
		
		<body>

		<div class=\"CSS_Table_Example\" style=\"width:100%;height:60px;\">

		";
		$lati = $_GET["lat"];
		$longi = $_GET["lon"];
		$zoomi = $_GET["zoom"];
		
		
		
		$home =  "Dhaka,BD";
		

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
	
		
		echo "<font color=\"#000000\" >";
		
		echo "<table>";
		echo "<th><td><b>${home}</b></br><i>${weather}</i></td>";
		echo "<td><img src=\"${iconURL}\" alt=\"Mountain View\"> </td><td><b>Temperature</b></br><i>${temp_c}</i></td><td><b>Humidity</b></br><i>${relative_humidity}</i></td><td><b>Wind Dir. and Speed</b></br><i>$wind_string</i></td><td><b>Dew point</b></br><i>${dewPoint}</i></td><td><b>Visibility</b></br><i>${visibility_mi}</i></td><td><b>UV</b></br><i>${UV_index}</i></td></th></table>";
		
		echo "</font></div>";
	?>
	
	</div>
	
	
	
  </body>
</html>