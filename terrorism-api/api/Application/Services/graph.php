<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    <?php

        $possibleInputKeys=array('_id', 'iyear', 'imonth', 'iday', 'country', 'region', 
        'provstate', 'city', 'latitude', 'longitude', 'success', 'attacktype',
        'targtype', 'gname', 'motive', 'weaptype', 'weapdetail', 'nkill','count'
        );
        $possibleInputs=array_fill_keys($possibleInputKeys,0);

        $mode='PieChart'; $wich_frequency='imonth'; $idmax=0;

        if(isset($_SESSION['details']['mode'])) $mode=$_SESSION['details']['mode'];
        if(isset($_SESSION['details']['frequency']) && $_SESSION['details']['frequency']!=null) { 
            $value = $_SESSION['details']['frequency'];
            if($value == 'day' || $value == 'month' || $value =='year' ) $value= 'i'.$value;
            $wich_frequency=$value;
        }

        if($mode=='PieChart')
            $idmax=1;
        else 
            $idmax=count($_SESSION['attacks']);

        /*for($id=0;$id<$idmax;$id++)
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
        }*/
        echo "var json_array = " . json_encode($_SESSION['attacks']) . ";\n";
        echo "var mode = '" . $mode . "';\n";
    ?>
        
        var freq = {};
        var keysJSON = {};
        for(var i = 0; i<json_array.length; i++)
            for(var j = 0; j<json_array[i].length; j++)
            {
                <?php echo "var elem = json_array[i][j]." .$wich_frequency .";\n"?>
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

        var chart_div = document.getElementById('graph_chart');
        google.visualization.events.addListener(chart, 'ready', function () {
        //chart_div.innerHTML = '<img src="' + chart.getImageURI() + '">';
        console.log(chart_div.innerHTML);
        document.getElementById('png').outerHTML = '<a href="' + chart.getImageURI() + '" class=\'button\' id=\'png\' download>Download png</a>';
        });

        chart.draw(data, options);
      }
    </script>
</head>
<body>
    <div id="test"></div>
    <div id="graph_chart"></div>
    <div id='png'></div>
</body>