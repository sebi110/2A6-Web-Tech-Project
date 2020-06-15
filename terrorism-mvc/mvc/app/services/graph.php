<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
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
            echo "var json_array = " . json_encode($fullQuery) . ";\n";
        }
        else
            echo "var json_array = " . json_encode(array()) . ";\n";
        echo "var mode = '" . $mode . "';\n";
        echo "var nrQuery = " .$idmax .";\n";
    ?>
        
        var freq = {};
        var keysJSON = {};
        for(var i = 0; i<json_array.length; i++)
            for(var j = 0; j<json_array[i].length; j++)
            {
                <?php echo "var elem = json_array[i][j]." .$wichFrequency .";\n"?>
                keysJSON[elem] = keysJSON[elem] ? keysJSON[elem] : elem;
                if(!freq[elem])
                    freq[elem]= {};
                freq[elem][i] = freq[elem][i] ? freq[elem][i]+1 : 1;
            }
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        
        function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string','data');
            <?php 
            for($id=0;$id<$idmax;$id++)
            {
                echo "data.addColumn('number','set" . $id."');\n";
            }
            ?>
            var element = document.getElementById("test");
            for (var i = 0,keys=Object.keys(keysJSON); i < keys.length; i++) {
                data.addRow([
                    keys[i]
                    <?php
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
    <div id="test"></div>
    <div id="graph_chart"></div>
    <script>
        // var element = document.getElementById("test");
        // element.innerHTML = freq[0][0];
    </script>
</body>