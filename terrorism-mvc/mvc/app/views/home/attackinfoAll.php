<!doctype html>
<html>
    <head> 
        <meta charset="utf-8">
        <title>Terrorism</title>
        
    </head>
    <body>
        <p>
            <strong>Welcome to the home/attackInfoAll/count view</strong>
        </p>
        <p>List of <?=$data['count']?> attacks</p>
        <?php foreach($data['attacks'] as $attack) : ?>
			
			<p>JSON:</p><br><?php echo $attack->toJson(); ?>
			
		<?php endforeach; ?>
    </body>
</html>