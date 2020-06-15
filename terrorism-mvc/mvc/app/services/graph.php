<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    var asd=0;
    <?php
        require_once "../database.php";
        require_once "../models/AttackDao.php";

        $possibleInputKeys=array('_id', 'iyear', 'imonth', 'iday', 'country', 'region', 
        'provstate', 'city', 'latitude', 'longitude', 'success', 'attacktype',
        'targtype', 'gname', 'motive', 'weaptype', 'weapdetail', 'nkill','count'
        );
        $possibleInputs=array_fill_keys($possibleInputKeys,0);

        echo "Asdad";
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
            $idmax=1;
            for($id=0;$id<$idmax;$id++)
            {
                $db_data=$db->find($params);
                $RawRows=array();
                foreach($db_data as $row)
                {
                    $RawRows[]=$row->get();
                    break;
                }
                $fullQuery[]=$RawRows;
                break;
            }
            echo "var json_array = " . json_encode($fullQuery) . ";\n";
        }
        else
            echo "var json_array = " . json_encode(array()) . ";\n";
        echo "var mode = '" . $mode . "';\n";
        echo "var nrQuery = " .$idmax .";\n";
    ?>
        var freq = {};
        for(var i = 0; i<json_array.lenght; i++)
            for(var j = 0; j<json_array.length; j++)
            {
                <?php echo "var elem = json_array[i][j]." .$wichFrequency .";\n"?>
                freq[elem][i] = freq[elem][i] ? freq[elem][i]+1 : 1;
            }
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        
        function drawChart() {
            const params = new URLSearchParams(window.location.search)
            var data = new google.visualization.DataTable();
            data.addColumn('string','month');
            <?php 
            for($idd=0;$idd<$idmax;$id++)
            {
                echo 'data.addColumn(\'number\',\'set' . $idd.'\');\n';
            }
            ?>

            for (var i = 0, keys = Object.keys(freq); i < keys.length; i++) {
                data.addRow([
                    keys[i],freq[keys[i][0]]
                    <?php
                    $idmax=1;
                    for($id=0;$id<$idmax;$id++)
                        echo ",freq[keys[i]][".$id."]";
                    ?>    
                ]);
            }
            
        var options = {
            title: mode
        };
        var chart;
        if(mode=='BarChart')
            chart = new google.visualization.BarChart(document.getElementById('graph_chart'));
        else if(mode=='LineChart')
            chart = new google.visualization.LineChart(document.getElementById('graph_chart'));
        else 
            chart = new google.visualization.PieChart(document.getElementById('graph_chart'));

        if(modout!="div"){
            var chart_div = document.getElementById('graph_chart');
            google.visualization.events.addListener(chart, 'ready', function () {
            chart_div.innerHTML = '<img src="' + chart.getImageURI() + '">';
            console.log(chart_div.innerHTML);
            });
        }

        chart.draw(data, options);
      }
    </script>
</head>
<body>
    <div id="graph_chart"></div>
</body>