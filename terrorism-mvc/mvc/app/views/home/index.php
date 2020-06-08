
<?php
    session_start();
    
    $targets = $data['targets'];

    if(isset($_SESSION['error'])){
 
        echo $_SESSION['error'] , "<br>";
        
        session_unset();
        session_destroy();
    
    }

	if($_SERVER["REQUEST_METHOD"] == "POST"){

        if(!in_array($_POST['targtype1_txt'], $targets) && !empty($_POST['targtype1_txt']) ){
                
            $_SESSION['error'] = 'Select something from the datalist or nothing!';
            header("location: home/index");

        }
        
        else{
            
            $year  = $_POST['iyear'];
            (empty($_POST['targtype1_txt']) == true) ? $target = 'all' : $target = $_POST['targtype1_txt'];
            $count = $_POST['count'];

            // for Airports & Aircraft goddamn
            $target = str_replace("&", "and", $target);

            $ary = array('iyear' => $year, 'targtype1_txt' => $target, 'count' => $count);
        
            $query = http_build_query($ary);
           
            header("location: home/index" . "?" . $query);

        }  
       
    }
?>

<!doctype html>
<html lang="en-US">
    <head> 
        <meta charset="utf-8">
        <link href="../../public/css/form.css" rel="stylesheet">
        <title>Terrorism</title>
        
    </head>
    <body>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">

            <h1>Basic form</h1>
                
            <section>
                <h2>Attack details</h2>
                
                <p>
                    <label for="year">Year(1970:2017)</label>
                    <input type="number" name="iyear" value="<?=@$_POST['iyear']?>" id="iyear" min="1970" max="2017" step="1" required>
                    <span></span>
                </p>
                <p>
                    <label for="count">Count(1:10)</label>
                    <input type="number" name="count" value="<?=@$_POST['count']?>" id="count" min="1" max="10" step="1" required>
                    <span></span>
                </p>

                <p>
                    <label for="target">Target</label>
                    <input type="text" name="targtype1_txt" value="<?=@$_POST['targtype1_txt']?>" id="targtype1_txt" list="targetList">
                    <datalist id="targetList">
                    <?php foreach($targets as $target) : ?>
			            <option><?php echo $target; ?></option>			
                    <?php endforeach; ?>
                    </datalist>
                    <span></span>
                </p>    
            </section>
    
            <p>
                <button type="submit" name="submit">SUBMIT</button>
                <button type="reset" name="reset">RESET</button>
            </p>
    
        </form>

        <?php if(empty($data['params'])) : ?>
            <p>Submit the form!</p>

        <?php else: ?>


            <p>
                <strong>Filters applied:</strong>
            </p>
            <?php foreach($data['params'] as $key => $value) : ?>
            
                <p> <?php echo $key; ?> = <?php echo $value; ?> </p>   
    
            <?php endforeach; ?>
            <?php if(empty($data['attacks'])) : ?>
                <p>No attacks were found.</p>

            <?php else: ?>

            <?php foreach($data['attacks'] as $attack) : ?>
                
                <h3><?php echo $attack->get()->_id; ?></h3>
                <p>The attack took place on 
                <?php echo $attack->get()->iday; ?>/<?php echo $attack->get()->imonth; ?>
                /<?php echo $attack->get()->iyear; ?>
                in the country <?php echo $attack->get()->country; ?>
                within the region <?php echo $attack->get()->region; ?> in the province
                <?php echo $attack->get()->provstate; ?>, city <?php echo $attack->get()->city; ?>(lat = <?php echo $attack->get()->latitude; ?>, long = <?php echo $attack->get()->longitude; ?>)</p>

                <p>Was it successful? R: <?php echo $attack->get()->success; ?></p>
                <p>The attack type: <?php echo $attack->get()->attacktype1; ?></p>
                <p>The target type: <?php echo $attack->get()->targtype1; ?></p>
                <p>The target type in txt: <?php echo $attack->get()->targtype1_txt; ?></p>
                <p>The gname: <?php echo $attack->get()->gname; ?></p>
                <p>The motive: <?php echo $attack->get()->motive; ?></p>
                <p>The weapon type:  <?php echo $attack->get()->weaptype1; ?></p>
                <p>The no of people slain: <?php echo $attack->get()->nkill; ?></p>	
                
                <p>And the JSON:</p><br>
                <?php echo $attack->toJson(); ?>

            <?php endforeach; ?>

            
            <?php endif; ?>
        <?php endif; ?>
    </body>
</html>

	