
<!DOCTYPE html>

<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Local Weather</title>
	
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
	<input name="city"  type="text" value="Sylhet">
	<input name="country"  type="text" value="Bangladesh">
	
	</div>

<?php

	$city_name = $_GET['city'];
	
	$country_name = $_GET['country'];
	
    $json_string = file_get_contents("http://api.wunderground.com/api/d213477ab5c32dd7/hourly/lang:EN/q/${country_name}/${city_name}.json");
		
	echo "
		
		<html>
		
		<head>
		<link rel=\"stylesheet\" href=\"table.css\" type=\"text/css\"/>	
		</head>
		
		<body>

		<div class=\"CSS_Table_Example\" style=\"width:600px;height:150px;\">

		<table>
		";
		
	echo "<tr> <td>Time & Date</td> <td>Icon</td> <td>Temperature Deg_Cel</td><td>Wind Speed</td> <td>Wind Dir.</td> <td>RH</td><td>Snow</td><td>Weather Condition</td><td>Rain Risk</td><td>Pressure</td></tr>";	
	
	for($hour=0;$hour<24;$hour++)
	{
		echo "<tr>";
		
		echo "<td>";
		$parsed_json = json_decode($json_string, true);	
		$parsed_json = $parsed_json['hourly_forecast'][$hour]['FCTTIME'];
		
		//	print_r($parsed_json);
	 
		$stunde = $parsed_json['hour_padded'];
		$min = $parsed_json['min'];
		$tag = $parsed_json['mday_padded'];
		$monat = $parsed_json['mon_abbrev'];
		$jahr = $parsed_json['year'];
		
		echo $stunde.":".$min." ".$tag.".".$monat.".".$jahr."\n";
		
		echo "</td>";
		
		echo "<td>";
		$parsed_json = json_decode($json_string, true);
		$icon_link = $parsed_json['hourly_forecast'][$hour]['icon_url'];
		echo "<img src=\"${icon_link}\" alt=\"Mountain View\"></td>";
		
		echo "<td>";
		$parsed_json = json_decode($json_string, true);
		$parsed_json = $parsed_json['hourly_forecast'][$hour]['temp'];
		$temp = $parsed_json['metric'];
		echo "".$temp." C"."\n";
		echo "</td>";
		
		
		echo "<td>";
		$parsed_json = json_decode($json_string, true);
		$parsed_json = $parsed_json['hourly_forecast'][$hour]['wspd'];
		$windspeed = $parsed_json['metric'];
		echo "".$windspeed." Km/h"."\n";
		echo "</td>";
		
		echo "<td>";
		$parsed_json = json_decode($json_string, true);
		$parsed_json = $parsed_json['hourly_forecast'][$hour]['wdir'];
		$winddir = $parsed_json['dir'];
		echo "".$winddir."\n";
		echo "</td>";
		
		echo "<td>";
		$parsed_json = json_decode($json_string, true);
		$parsed_json = $parsed_json['hourly_forecast'][$hour];
		$humy = $parsed_json['humidity'];
		echo "".$humy."%"."\n";
		echo "</td>";
	
		
		echo "<td>";
		$parsed_json = json_decode($json_string, true);
		$parsed_json = $parsed_json['hourly_forecast'][$hour]['snow'];
		$snow = $parsed_json['metric'];
		echo "".$snow." mm"."\n";
		echo "</td>";
		
		echo "<td>";
		$parsed_json = json_decode($json_string, true);
		$parsed_json = $parsed_json['hourly_forecast'][$hour];
		$zustand = $parsed_json['condition'];
		echo $zustand."\n";
		echo "</td>";
		
		echo "<td>";
		$parsed_json = json_decode($json_string, true);
		$parsed_json = $parsed_json['hourly_forecast'][$hour];
		$regenwar = $parsed_json['pop'];
		echo "".$regenwar."%"."\n";
		echo "</td>";
		
		echo "<td>";
		$parsed_json = json_decode($json_string, true);
		$parsed_json = $parsed_json['hourly_forecast'][$hour]['mslp'];
		$druck = $parsed_json['metric'];
		echo "".$druck." hPa"."\n";
		echo "</td>";
		
		echo "</tr>";
	}
	echo "</table> </div></html>";
?>