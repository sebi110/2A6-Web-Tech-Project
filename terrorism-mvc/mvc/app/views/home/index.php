<?php    

    function simple_prg ($start_prg = false, $targets = null){

        if(isset($_SESSION['error'])){
 
            echo $_SESSION['error'] , "<br>";
            
            session_unset();
            session_destroy();
        
        }

        // check to see if we should start prg
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){

            if(!in_array($_POST['targtype'], $targets) && !empty($_POST['targtype']) ){

                print_r($targets);
                
                $_SESSION['error'] = 'Select something from the datalist or nothing!';
                header("location: home/index?start_prg=1");
    
            }
            else {

                $uniqid = uniqid();

                (empty($_POST['targtype']) == true) ? $target = 'all' : $target = $_POST['targtype'];

                // for Airports & Aircraft goddamn
                $target = str_replace("&", "and", $target);
                
                $_SESSION = array('post' => array($uniqid => array(
                    'iyear' => $_POST['iyear'],
                    'targtype' => $target,
                    'count' => $_POST['count']
                )));

                header("HTTP/1.1 303 See Other");

                $query = http_build_query($_SESSION['post'][$uniqid]);
            
                header("location: home/index" . '?prg=1&uniqid=' . $uniqid . '&' . $query);

            }
            die;
        }
    
        if ($start_prg){        
            echo "start on";
            echo "<br><br>";
            
            @$_SESSION['post'] = '';
        } else {
            echo "start off";
            echo "<br><br>";

            if (isset($_GET['prg'])){

                $uniqid = $_GET['uniqid'];
                $_POST = @$_SESSION['post'][$uniqid];

            } 
        } 
    }

    session_start();

    if (isset($_GET['start_prg'])){
        simple_prg(true, $data['targets']);
    } else {
        simple_prg(null, $data['targets']);
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

                <input type="hidden" id="start_prg" name="start_prg" value="1">
                
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
                <!--currently reset ain't workin-->
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
                <p>The target type in txt: <?php echo $attack->get()->targtype; ?></p>
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

	
