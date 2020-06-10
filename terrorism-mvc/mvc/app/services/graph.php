<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    <?php
        require_once "../database.php";
        require_once "../models/AttackDao.php";


        $params=array();
        $out=0;
        foreach($_GET as $key=>$val)
        {
            if($key=="output"){
                echo "var modout = \"" . $val . "\"" . ";\n";
                $out=1;
                continue;
            }
            if($val!=NULL)
                $params[$key]=$val;
        }
        
        if($out==0)
            echo "var modout = \"div\" " . ";\n";

        if(!isset($params['targtype'])){
            $params['targtype'] = 'all';
        }else{
        $params['targtype'] = str_replace("and", "&", $params['targtype']);
        }
        $db=new AttackDao();
        $db_data=$db->find($params);
        $RawRows=array();
        foreach($db_data as $row)
        {
            $RawRows[]=$row->get();
        }
        echo "var json_array = " . json_encode($RawRows) . ";\n";
    ?>
        var freq = {};
        
        for(var i = 0; i<json_array.length; i++)
        {
            var elem = json_array[i].imonth;
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
            sliceVisibilityThreshold: .001,
            title: 'Piechart'
        };

        var chart = new google.visualization.PieChart(document.getElementById('graph_chart'));

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