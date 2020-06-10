<?php    

    include('functions.php');

    function attack_form($data){

        if(!in_array($_GET['targtype'], $data['targets']) && !empty($_GET['targtype']) ){

            print_r($data['targets']);                
            array_push($_SESSION['errors'], "Choose a target from the list or no target at all!");
        }

        if (empty($_SESSION['errors'])) {

            (empty($_GET['targtype']) == true) ? $target = 'all' : $target = $_GET['targtype'];

            // for Airports & Aircraft goddamn
            $target = str_replace("&", "and", $target);
                
            $_SESSION['attack_form'] = array(
                'iyear' => $_GET['iyear'],
                'targtype' => $target,
                'count' => $_GET['count']
            );

            $query = http_build_query($_SESSION['attack_form']);
            
            header("location: form?" . $query);

        }
 
    }

    echo $_SESSION['user'];

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
        <link href="../../public/css/form.css" rel="stylesheet">
        <title>Terrorism</title>
        
    </head>
    <body>
        <form method="GET" action="form" enctype="multipart/form-data">

        <?php echo display_error(); ?>

            <h2>Attack details</h2>

            <p>
                <input type="hidden" id="start_prg" name="start_prg" value="1">
                   <span></span>
            </p>
               
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
                <p>The attack type: <?php echo $attack->get()->attacktype; ?></p>
                <p>The target type: <?php echo $attack->get()->targtype; ?></p>
                
                <p>The gname: <?php echo $attack->get()->gname; ?></p>
                <p>The motive: <?php echo $attack->get()->motive; ?></p>
                <p>The weapon type:  <?php echo $attack->get()->weaptype; ?></p>
                <p>The no of people slain: <?php echo $attack->get()->nkill; ?></p>	
                
                <p>And the JSON:</p><br>
                <?php echo $attack->toJson(); ?>

            <?php endforeach; ?>

            
            <?php endif; ?>
        <?php endif; ?>
    </body>
</html>
