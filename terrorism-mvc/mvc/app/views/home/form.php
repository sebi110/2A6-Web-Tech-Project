<?php    
    //echo $_SESSION['user'];

    if (!isLoggedIn()) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login');
    }

    if (isset($_GET['submit'])){
        attack_form($data);
    } 

    $data['mode']=array('map','PieChart','BarChart');
    $data['frequency']=array('year', 'month', 'day', 'country', 'region', 
                        'provstate', 'city', 'latitude', 'longitude', 'success', 'attacktype',
                        'targtype', 'gname', 'motive', 'weaptype', 'weapdetail', 'nkill'
                        );
    
?>


<!doctype html>
<html lang="en-US">
    <head> 
        <meta charset="utf-8">
        <link href="../../public/css/styles.css" rel="stylesheet">
        <title>Terrorism</title>
        
    </head>
    <body>
            <script src="../misc/libraries/leaflet-easyPrint-2/dist/bundle.js"></script>
    <div class="page-wrapper">
    <div class="container">
		<h2 class="tag">Search for attacks</h2>
		<p>Choose the filters you want to apply and submit the form below.</p>
        <p>The "Frequency of" field is used only for PieChart/BarChart.</p>
	</div>
        
        <form method="GET" action="form">

        <?php echo display_error(); ?>

            <h2 class="tag">Filter attacks after:</h2>
            <p>
                <label for="mode">Mode</label>
                <input type="text" name="mode" id="mode" list="modeList">
                <datalist id="modeList">
                <?php foreach($data['mode'] as $mode) : ?>
			        <option><?php echo $mode; ?></option>			
                <?php endforeach; ?>
                </datalist>
                <span></span>
            </p> 
            <p>
                <label for="frequency">Frequency Of</label>
                <input type="text" name="frequency" id="frequency" list="frequencyList">
                <datalist id="frequencyList">
                <?php foreach($data['frequency'] as $frequency) : ?>
			        <option><?php echo $frequency; ?></option>			
                <?php endforeach; ?>
                </datalist>
                <span></span>
            </p>  
            <p>
                <label for="year">Year(1970:2017)</label>
                <input type="number" name="iyear" id="iyear" min="1970" max="2017" step="1">
                <span></span>
            </p>

            <p>
                <label for="month">Month(0:12)</label>
                <input type="number" name="imonth" id="imonth" min="0" max="12" step="1">
                <span></span>
            </p>

            <p>
                <label for="day">Day(0:31)</label>
                <input type="number" name="iday" id="iday" min="0" max="31" step="1">
                <span></span>
            </p>


            <p>
                <label for="count">Count(1:1000)</label>
                <input type="number" name="count" id="count" min="1" max="1000" step="1" value="100" required>
                <span></span>
            </p>

            <p>
                    <!--cant use the value thing with POST cause of 'all'-->
                <label for="country">Country</label>
                <input type="text" name="country" id="country" list="countryList">
                <!--<datalist id="targetList">
                <?php foreach($data['targets'] as $target) : ?>
			        <option><?php echo $target; ?></option>			
                <?php endforeach; ?>
                </datalist>-->
                <span></span>
            </p> 
            
            <p>
                <label for="region">Region</label>
                <input type="text" name="region" id="region" list="regionList">
                <!--<datalist id="targetList">
                <?php foreach($data['targets'] as $target) : ?>
			        <option><?php echo $target; ?></option>			
                <?php endforeach; ?>
                </datalist>-->
                <span></span>
            </p>

            <p>
                <label for="provstate">Province/State</label>
                <input type="text" name="provstate" id="provstate" list="provstateList">
                <!--<datalist id="targetList">
                <?php foreach($data['targets'] as $target) : ?>
			        <option><?php echo $target; ?></option>			
                <?php endforeach; ?>
                </datalist>-->
                <span></span>
            </p>
            <p>
                <label for="city">City</label>
                <input type="text" name="city" id="city" list="cityList">
                <!--<datalist id="targetList">
                <?php foreach($data['targets'] as $target) : ?>
			        <option><?php echo $target; ?></option>			
                <?php endforeach; ?>
                </datalist>-->
                <span></span>
            </p>

            <p>
                <label for="success">Was it a succes?(0=false,1=true)</label>
                <input type="number" name="success" id="success" min="0" max="1" step="1">
                <span></span>
            </p>

            <p>
                <label for="attacktype">Attack type</label>
                <input type="text" name="attacktype" id="attacktype" list="atktypeList">
                <!--<datalist id="targetList">F
                <?php foreach($data['targets'] as $target) : ?>
			        <option><?php echo $target; ?></option>			
                <?php endforeach; ?>
                </datalist>-->
                <span></span>
            </p>

            <p>
                    <!--cant use the value thing with POST cause of 'all'-->
                <label for="target">Target</label>
                <input type="text" name="targtype" id="targtype" list="targetList">
                <datalist id="targetList">
                <?php foreach($data['targets'] as $target) : ?>
			        <option><?php echo $target; ?></option>			
                <?php endforeach; ?>
                </datalist>
                <span></span>
            </p>    
            </section>
    
            <p>
                <button type="submit" name="submit">SUBMIT</button>
                <button type="reset" name="reset">RESET</button>
                <p>	<a class="button" href="index">BACK</a></p>
            </p>
    
        </form>

        <div class="container">

        <?php if(!empty($data['params'])) : ?>
            
            <?php 
                $URL = '';
                if(isset($_GET['mode']) && $_GET['mode']=='map')
                    $URL = 'http://localhost/terrorism-mvc/mvc/app/services/map.php?' . parse_url($_SERVER["REQUEST_URI"],PHP_URL_QUERY);
                else
                    $URL = 'http://localhost/terrorism-mvc/mvc/app/services/graph.php?' . parse_url($_SERVER["REQUEST_URI"],PHP_URL_QUERY);
                
                $c = curl_init ($URL); 
                $opt = [CURLOPT_RETURNTRANSFER => TRUE,
                        CURLOPT_SSL_VERIFYPEER => FALSE,
                        CURLOPT_CONNECTTIMEOUT => 10,
                        CURLOPT_FAILONERROR    => TRUE
                    ];

                curl_setopt_array ($c, $opt);        
                $res = curl_exec ($c);

                $codHTTP = curl_getinfo ($c, CURLINFO_RESPONSE_CODE);

                if ($codHTTP == 200) {
                    echo "<div id=\"chart\">";
                    echo $res;
                } 
                else {
                    http_response_code ($codHTTP);
                    echo 'Status code: ' . $codHTTP;
                
                }

                curl_close ($c);
            ?>

            <h2 class="tag">Filters applied:</h2>
            <?php foreach($data['params'] as $key => $value) : ?>
            
                <p> <?php echo $key; ?> = <?php echo $value; ?> </p>   
    
            <?php endforeach; ?>
            <?php if(empty($data['attacks'])) : ?>
                <p>No attacks were found.</p>

            <?php else: ?>
                <h2 class="tag">The first <=10 attacks that were found:</h2>

            <?php foreach(array_slice($data['attacks'], 0, 10) as $attack) : ?>
                
                <p><?php print_r(fromJson($attack->toJson(), '_id')); ?></p>
                <p>The attack took place on 
                <?php echo fromJson($attack->toJson(), 'iday'); ?>/<?php echo fromJson($attack->toJson(), 'imonth'); ?>
                <?php echo fromJson($attack->toJson(), 'iyear'); ?>
                in the country <?php echo fromJson($attack->toJson(), 'country'); ?>
                within the region <?php echo fromJson($attack->toJson(), 'region'); ?>, in the city <?php echo fromJson($attack->toJson(), 'city'); ?>(lat = <?php echo fromJson($attack->toJson(), 'latitude'); ?>, long = <?php echo fromJson($attack->toJson(), 'longitude'); ?>)</p>

                <p>Was it successful? R: <?php echo fromJson($attack->toJson(), 'success'); ?></p>
                <p>The attack type: <?php echo fromJson($attack->toJson(), 'attacktype'); ?></p>
                <p>The target type: <?php echo fromJson($attack->toJson(), 'targtype'); ?></p>
                
                <p>The group's name: <?php echo fromJson($attack->toJson(), 'gname'); ?></p>
                <p>The motive: <?php echo fromJson($attack->toJson(), 'motive'); ?></p>
                <p>The weapon type:  <?php echo fromJson($attack->toJson(), 'weaptype'); ?></p>
                <p>Details about the weapon:  <?php echo fromJson($attack->toJson(), 'weapdetail'); ?></p>
                <p>The no of people slain: <?php echo fromJson($attack->toJson(), 'nkill'); ?></p-->	
                
                <!--p> <?php echo $attack->toJson(); ?> </p-->

            <?php endforeach; ?>

            
            <?php endif; ?>
        <?php endif; ?>
            </div>
            </div>
    </body>
</html>
