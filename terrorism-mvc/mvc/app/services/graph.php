<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    <?php
        require_once "../database.php";
        require_once "../models/AttackDao.php";

        $possibleInputKeys=array('_id', 'iyear', 'imonth', 'iday', 'country', 'region', 
        'provstate', 'city', 'latitude', 'longitude', 'success', 'attacktype',
        'targtype', 'gname', 'motive', 'weaptype', 'weapdetail', 'nkill','count','frequency'
        );
        $possibleInputs=array_fill_keys($possibleInputKeys,0);


        $params=array();
        $out=0;$correct=1;$mode='PieChart';$wichFrequency='iyear';
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
                $wichFrequency=$val;
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
        var freq = {};
        
        for(var i = 0; i<json_array.length; i++)
        {
            <?php echo "var elem = json_array[i]." .$wichFrequency .";\n"?>
            //var elem = json_array[i].wichFrequency;
            freq[elem] = freq[elem] ? freq[elem]+1 : 1;
        }
        //document.getElementById("test").innerHTML = freq[1970];
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        
        function drawChart() {
            const params = new URLSearchParams(window.location.search)
            var data = new google.visualization.DataTable();
            data.addColumn('string','month');
            data.addColumn('number','nr');

            for (var i = 0, keys = Object.keys(freq); i < keys.length; i++) {
                data.addRow([
                    keys[i],freq[keys[i]]
                ])
            }
            
        var options = {
            title: mode
        };
        var chart;
        if(mode=='BarChart')
            chart = new google.visualization.BarChart(document.getElementById('graph_chart'));
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
    <div id="graph_chart"></div>