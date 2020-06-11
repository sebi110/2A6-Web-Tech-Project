<html>


<head>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
   integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
   crossorigin=""/> <!-- Leaftleft Map Library CSS File-->
   
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
   integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
   crossorigin=""></script>  <!--Leaftlet Map Library Js File-->
<script src="../misc/libraries/leaflet-easyPrint-2/dist/leaflet.easyPrint.js"></script>  <!-- Leaflet EasyPrint js file-->
<script src="../misc/libraries/leaflet-easyPrint-2/dist/bundle.js"></script>
</head>

<body>

        <div id="mapContainer" style="position:relative; z-index: 0; width:100%; height: 0px; padding-top:80%; margin: auto;"></div>
		<script>
		var map = L.map('mapContainer').setView({lon: 0, lat: 0}, 2);

		var tiles = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			maxZoom: 18,
			attribution: 'Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors',
		}).addTo(map);

		//var json_array = [{"_id":{"$oid":"5ee09092495d0000880b8890"},"iyear":"1970","imonth":"7","iday":"2","country":"Dominican Republic","region":"Central America & Caribbean","provstate":"","city":"Santo Domingo","latitude":"18.456792","longitude":"-69.951164","success":"1","attacktype":"Assassination","targtype":"Private Citizens & Property","gname":"MANO-D","motive":"","weaptype":"Unknown","weapdetail":"","nkill":"1"},{"_id":{"$oid":"5ee09092495d0000880b8891"},"iyear":"1970","imonth":"0","iday":"0","country":"Mexico","region":"North America","provstate":"Federal","city":"Mexico city","latitude":"19.371887","longitude":"-99.086624","success":"1","attacktype":"Hostage Taking (Kidnapping)","targtype":"Government (Diplomatic)","gname":"23rd of September Communist League","motive":"","weaptype":"Unknown","weapdetail":"","nkill":"0"},{"_id":{"$oid":"5ee09092495d0000880b8892"},"iyear":"1970","imonth":"1","iday":"0","country":"Philippines","region":"Southeast Asia","provstate":"Tarlac","city":"Unknown","latitude":"15.478598","longitude":"120.599741","success":"1","attacktype":"Assassination","targtype":"Journalists & Media","gname":"Unknown","motive":"","weaptype":"Unknown","weapdetail":"","nkill":"1"},{"_id":{"$oid":"5ee09092495d0000880b8893"},"iyear":"1970","imonth":"1","iday":"0","country":"Greece","region":"Western Europe","provstate":"Attica","city":"Athens","latitude":"37.99749","longitude":"23.762728","success":"1","attacktype":"Bombing\/Explosion","targtype":"Government (Diplomatic)","gname":"Unknown","motive":"","weaptype":"Explosives","weapdetail":"Explosive","nkill":""},{"_id":{"$oid":"5ee09092495d0000880b8894"},"iyear":"1970","imonth":"1","iday":"0","country":"Japan","region":"East Asia","provstate":"Fukouka","city":"Fukouka","latitude":"33.580412","longitude":"130.396361","success":"1","attacktype":"Facility\/Infrastructure Attack","targtype":"Government (Diplomatic)","gname":"Unknown","motive":"","weaptype":"Incendiary","weapdetail":"Incendiary","nkill":""},{"_id":{"$oid":"5ee09092495d0000880b8895"},"iyear":"1970","imonth":"1","iday":"1","country":"United States","region":"North America","provstate":"Illinois","city":"Cairo","latitude":"37.005105","longitude":"-89.176269","success":"1","attacktype":"Armed Assault","targtype":"Police","gname":"Black Nationalists","motive":"To protest the Cairo Illinois Police Deparment","weaptype":"Firearms","weapdetail":"Several gunshots were fired.","nkill":"0"},{"_id":{"$oid":"5ee09092495d0000880b8896"},"iyear":"1970","imonth":"1","iday":"2","country":"Uruguay","region":"South America","provstate":"Montevideo","city":"Montevideo","latitude":"-34.891151","longitude":"-56.187214","success":"0","attacktype":"Assassination","targtype":"Police","gname":"Tupamaros (Uruguay)","motive":"","weaptype":"Firearms","weapdetail":"Automatic firearm","nkill":"0"},{"_id":{"$oid":"5ee09092495d0000880b8897"},"iyear":"1970","imonth":"1","iday":"2","country":"United States","region":"North America","provstate":"California","city":"Oakland","latitude":"37.791927","longitude":"-122.225906","success":"1","attacktype":"Bombing\/Explosion","targtype":"Utilities","gname":"Unknown","motive":"","weaptype":"Explosives","weapdetail":"","nkill":"0"},{"_id":{"$oid":"5ee09092495d0000880b8898"},"iyear":"1970","imonth":"1","iday":"2","country":"United States","region":"North America","provstate":"Wisconsin","city":"Madison","latitude":"43.076592","longitude":"-89.412488","success":"1","attacktype":"Facility\/Infrastructure Attack","targtype":"Military","gname":"New Year's Gang","motive":"To protest the War in Vietnam and the draft","weaptype":"Incendiary","weapdetail":"Firebomb consisting of gasoline","nkill":"0"},{"_id":{"$oid":"5ee09092495d0000880b8899"},"iyear":"1970","imonth":"1","iday":"3","country":"United States","region":"North America","provstate":"Wisconsin","city":"Madison","latitude":"43.07295","longitude":"-89.386694","success":"1","attacktype":"Facility\/Infrastructure Attack","targtype":"Government (General)","gname":"New Year's Gang","motive":"To protest the War in Vietnam and the draft","weaptype":"Incendiary","weapdetail":"Poured gasoline on the floor and lit it with a match","nkill":"0"}];

		<?php
			require_once "../database.php";
			require_once "../models/AttackDao.php";

			$possibleInputKeys=array('_id', 'iyear', 'imonth', 'iday', 'country', 'region', 
			'provstate', 'city', 'latitude', 'longitude', 'success', 'attacktype',
			'targtype', 'gname', 'motive', 'weaptype', 'weapdetail', 'nkill','count'
			);
			$possibleInputs=array_fill_keys($possibleInputKeys,0);


			$params=array();
			$out=0;$correct=1;$mode='PieChart';
			foreach($_GET as $key=>$val)
			{
				if($key=="output"){
					echo "var modout = \"" . $val . "\"" . ";\n";
					$out=1;
					continue;
				}
				if($key=='correctForm' && $val==0)
				{
					$correct=0;
					continue;
				}
				if($key=='mode'){
					$mode=$val;
					continue;
				}
				if($val=='all')continue;
				if($val!=NULL && isset($possibleInputs[$key]))
					$params[$key]=$val;
			}
			
			if($out==0)
				echo "var modout = \"div\" " . ";\n";

			if(!isset($params['targtype'])){
				$params['targtype'] = 'all';
			}else{
			$params['targtype'] = str_replace("and", "&", $params['targtype']);
			}
			if($correct==1){
				$db=new AttackDao();
				$db_data=$db->find($params);
				$RawRows=array();
				foreach($db_data as $row)
				{
					$RawRows[]=$row->get();
				}
				echo "var json_array = " . json_encode($RawRows) . ";\n";
			}
			else
				echo "var json_array = " . json_encode(array()) . ";\n";
			echo "var mode = '" . $mode . "';\n";
    	?>
	
		for(var i=0;i<json_array.length;i++)
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
