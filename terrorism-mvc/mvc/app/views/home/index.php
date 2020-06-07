
<?php
    session_start();
    $targets = $data;

    if(isset($_SESSION["post-data"]['error'])){
 
        echo $_SESSION["post-data"]['error'] , "<br>";
        
        session_unset();
        session_destroy();
    
    }

	if($_SERVER["REQUEST_METHOD"] == "POST"){

        if(!in_array($_POST['target'], $targets) && !empty($_POST['target']) ){
            
            session_start();
    
            $_SESSION['post-data']['error'] = 'Select something from the datalist or nothing!';
            header("location: home/index");

        }
        
        else{
            
            $year  = $_POST['year'];
            (empty($_POST['target']) == true) ? $target = 'all' : $target = $_POST['target'];
            $count = $_POST['count'];

            // for Airports & Aircraft goddamn
            $target = str_replace("&", "and", $target);
        
            header("location: home/attackInfo/" . $year . "/" . $target . "/" . $count);
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
                    <input type="number" name="year" id="year" min="1970" max="2017" step="1" required>
                    <span></span>
                </p>
                <p>
                    <label for="count">Count(1:10)</label>
                    <input type="number" name="count" id="count" min="1" max="10" step="1" required>
                    <span></span>
                </p>

                <p>
                    <label for="target">Target</label>
                    <input type="text" name="target" id="target" list="targetList">
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
              
    </body>
</html>

	
