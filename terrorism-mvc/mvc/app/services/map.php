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
		<script src="../misc/libraries/leaflet-easyPrint-2/dist/bundle.js"></script>
		<script>
		var map = L.map('mapContainer').setView({lon: 0, lat: 0}, 2);

		var tiles = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			maxZoom: 18,
			attribution: 'Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors',
		}).addTo(map);

		<?php
        require_once "../database.php";
        require_once "../models/AttackDao.php";

        $possibleInputKeys=array('_id', 'iyear', 'imonth', 'iday', 'country', 'region', 
        'provstate', 'city', 'latitude', 'longitude', 'success', 'attacktype',
        'targtype', 'gname', 'motive', 'weaptype', 'weapdetail', 'nkill','count'
        );
        $possibleInputs=array_fill_keys($possibleInputKeys,0);

        $params=array();
        $out=0;$correct=1;$mode='PieChart';$wichFrequency='imonth';$idmax=0;
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
            if($key=='frequency')
            {
                if($val=='day' || $val=='month' || $val=='year')
                    $val='i'.$val;
                if($val=='all')
                    $val='imonth';
                $wichFrequency=$val;
                continue;
            }
            if($val=='all')continue;
            if($val!=NULL && isset($possibleInputs[$key]))
            {
                $aux=explode(';',$val);
                $id=0;
                foreach($aux as $value)
                {
                    $params[$id][$key]=$value;
                    $id=$id+1;
                }
                if($id>$idmax)
                    $idmax=$id;
            }
        }
        for($id=0;$id<$idmax;$id++)
            $params[$id]['count']=$_GET['count'];
        if($out==0)
            echo "var modout = \"div\" " . ";\n";

        // if(!isset($params['targtype'])){   /// sper ca nu e gresit ca comentez aceste linii...
        //     $params['targtype'] = 'all';
        // }else{
        // $params['targtype'] = str_replace("and", "&", $params['targtype']);
        // }
        if($correct==1){
            $fullQuery=array();
            $db=new AttackDao();
            if($mode=='PieChart')
            {
                $idmax=1;
            }
            if($mode=='map')
            {
                $db_data=$db->find($params[0]);
                foreach($db_data as $row)
                {
                    $fullQuery[]=$row->get();
                }
            }
            else
            {
                for($id=0;$id<$idmax;$id++)
                {
                    $db_data=$db->find($params[$id]);
                    $RawRows=array();
                    $id2=0;
                    foreach($db_data as $row)
                    {
                        $fullQuery[$id][$id2]=$row->get();
                        $id2++;
                        $RawRows[]=$row->get();
                    }
                    $fullQuery[]=$RawRows;
                }
            }
            echo "var json_array = " . json_encode($fullQuery) . ";\n";
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
