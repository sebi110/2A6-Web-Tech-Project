<!doctype html>
<html>
    <head> 
        <meta charset="utf-8">
        <title>Terrorism</title>
        
    </head>
    <body>
        <p>
            <strong>Welcome to the home/targets view</strong>
        </p>
        <p>List of targets</p>
        <?php foreach($data as $target) : ?>
			<h3><?php print_r($target); ?></h3>			
		<?php endforeach; ?>
    </body>
</html>