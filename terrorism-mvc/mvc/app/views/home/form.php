<?php    
    //echo $_SESSION['user'];

    if (!isLoggedIn()) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login');
    }

    if (isset($_GET['submit'])){
        attack_form($data);
    } 

    
?>

<!doctype html>
<html lang="en-US">
    <head> 
        <meta charset="utf-8">
        <link href="../../public/css/styles.css" rel="stylesheet">
        <title>Terrorism</title>
        
    </head>
    <body>
    <div class="page-wrapper">
    <div class="container">
		<h2 class="tag">Search for attacks</h2>
		<p>Choose the filters you want to apply and submit the form below.</p>
	</div>
        
        <form method="GET" action="form" enctype="multipart/form-data">

        <?php echo display_error(); ?>

            <h2 class="tag">Filter attacks after:</h2>
               
            <p>
                <label for="year">Year(1970:2017)</label>
                <input type="number" name="iyear" id="iyear" min="1970" max="2017" step="1" required>
                <span></span>
            </p>
            <p>
                <label for="count">Count(1:10)</label>
                <input type="number" name="count" id="count" min="1" max="10" step="1" required>
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

            <h2 class="tag">Filters applied:</h2>
            <?php foreach($data['params'] as $key => $value) : ?>
            
                <p> <?php echo $key; ?> = <?php echo $value; ?> </p>   
    
            <?php endforeach; ?>
            <?php if(empty($data['attacks'])) : ?>
                <p>No attacks were found.</p>

            <?php else: ?>
                <h2 class="tag">The attacks that were found:</h2>

            <?php foreach($data['attacks'] as $attack) : ?>
                
                <!--h3><?php echo $attack->get()->_id; ?></h3>
                <p>The attack took place on 
                <?php echo $attack->get()->iday; ?>/<?php echo $attack->get()->imonth; ?>
                /<?php echo $attack->get()->iyear; ?>
                in the country <?php echo $attack->get()->country; ?>
                within the region <?php echo $attack->get()->region; ?> in the province
                <?php echo $attack->get()->provstate; ?>, city <?php echo $attack->get()->city; ?>(lat = <?php echo $attack->get()->latitude; ?>, long = <?php echo $attack->get()->longitude; ?>)</p>

                <p>Was it successful? R: <?php echo $attack->get()->success; ?></p>
                <p>The attack type: <?php echo $attack->get()->attacktype; ?></p>
                <p>The target type: <?php echo $attack->get()->targtype; ?></p>
                
                <p>The gname: <?php echo $attack->get()->gname; ?></p>
                <p>The motive: <?php echo $attack->get()->motive; ?></p>
                <p>The weapon type:  <?php echo $attack->get()->weaptype; ?></p>
                <p>The no of people slain: <?php echo $attack->get()->nkill; ?></p-->	
                
                <p> <?php echo $attack->toJson(); ?> </p>

            <?php endforeach; ?>

            
            <?php endif; ?>
        <?php endif; ?>
            </div>
            </div>
    </body>
</html>
