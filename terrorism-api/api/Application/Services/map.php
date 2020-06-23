<?php

    // for naughty children
    if(empty($_SESSION['attacks'])){
        // maybe a msg or sth..
        $this->response->redirect('/terrorism-api/api/home/form');
        die();
    }

?>
<html>
<head>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
   integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
   crossorigin=""/> <!-- Leaftleft Map Library CSS File-->
   
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
   integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
   crossorigin=""></script>  <!--Leaftlet Map Library Js File-->
</head>

<body>

        <div id="mapContainer" style="position:relative; z-index: 0; width:100%; height: 0px; padding-top:80%; margin: auto;"></div>
        <script src="..\Application\Misc\libraries\leaflet-easyPrint-2\dist\bundle.js"></script>
		<script>
		var map = L.map('mapContainer').setView({lon: 0, lat: 0}, 2);

		var tiles = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			maxZoom: 18,
			attribution: 'Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors',
		}).addTo(map);

		<?php

            $x = array();
            foreach($_SESSION['attacks'] as $key => $val){
                $x[$key] = $val;
            }
            $mode = 'map';

            echo "var json_array = " . json_encode($x) . ";\n";
            
            echo "var mode = '" . $mode . "';\n";
        ?>

		for(var i=0; i<json_array.length; i++)
        {
			var tempAttackInfo = "<ul>" + "<li> Date: " + json_array[i].iyear + "." +json_array[i].imonth + "." +json_array[i].iday + "</li>" + "<li> Type: " + json_array[i].attacktype+ "</li>" + "<li> Victims: " + json_array[i].nkill+ "</li>"+"</ul>";
			L.marker({lon: json_array[i].longitude, lat: json_array[i].latitude}).bindPopup(tempAttackInfo).addTo(map);
			if(i>10000) break;
        }
	
		var printer = L.easyPrint({
      		tileLayer: tiles,
      		sizeModes: ['Current', 'A4Landscape', 'A4Portrait'],
      		filename: 'myMap',
      		exportOnly: true,
      		hideClasses: ['leaflet-control-easyPrint'],
      		hideControlContainer: false
		}).addTo(map);

	    </script>
</body>

</html>