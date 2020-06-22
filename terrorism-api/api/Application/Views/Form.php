<?php    
    //echo $_SESSION['user'];

    /*if (!isLoggedIn()) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login');
    }

    if (isset($_GET['submit'])){
        attack_form($data);
    }*/ 

    if (isset($_GET['back'])) {
        $this->response->redirect('/terrorism-api/api/home/index');
    }
    
    if (isset($_GET['map'])) {
        $this->response->redirect('/terrorism-api/api/home/map');
    }
    
?>


<!doctype html>
<html lang="en-US">
    <head> 
        <meta charset="utf-8">
        <link href="../css/styles.css" rel="stylesheet">
        <title>Terrorism</title>
        
    </head>
    <body>
        
    <div class="page-wrapper">
    <div class="container">
		<h2 class="tag">Search for attacks</h2>
		<p>Choose the filters you want to apply and submit the form below.</p>
        <p>The "Frequency of" field is used only for PieChart/BarChart.</p>
	</div>
        
        <form method="POST" action="/terrorism-api/api/attack/find">

        <input type="hidden" id="form" name="form" value="1">

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
            <?php
                foreach($data['countable'] as $key=>$val)
                {
                    echo "<p>";
                    echo "<label for=".$key.">" .$val[0] . "(" . $val[1]. ":" . $val[2] . ")</label>";
                    echo "<input type=\"number\" name=\"" .$key . "\" id= \"" .$key. "\" min=\"" .$val[1] ."\" max=\"" .$val[2] ."\" step=\"1\" ";
                    if($key=='count') 
                        echo "value=\"10\" required";
                    echo ">";
                    echo "<span></span>";
                    echo "</p>";
                }
            ?>

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
                <label for="attacktype">Attack type</label>
                <input type="text" name="attacktype" id="attacktype" list="attackList">
                <datalist id="attackList">
                <?php foreach($data['attacktypes'] as $atactype) : ?>
			        <option><?php echo $atactype; ?></option>			
                <?php endforeach; ?>
                </datalist>
                <span></span>
            </p>

            <p>
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
                <p>	<a class="button" href="form?back='1'">BACK</a></p>
            </p>
    
        </form>

        <?php if(!empty($_SESSION['attacks'])) : ?>
        <div class="container">
            <p><a class="button" href="form?map='1'">Map</a></p>
        </div>
        <?php endif; ?>

        <div class="container">

        <?php if(!empty($_SESSION['attacks'])) : ?>

            <?php foreach($_SESSION['attacks'] as $key => $val) : ?>
                
                <p><?php echo json_encode($val); ?></p>

            <?php endforeach; ?>

        <?php endif; ?>
        
        </div>
        </div>
    </body>
</html>
