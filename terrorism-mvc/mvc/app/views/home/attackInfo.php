<!doctype html>
<html>
    <head> 
        <meta charset="utf-8">
        <title>Terrorism</title>
        
    </head>
    <body>
        <p>
            <strong>Filters applied:</strong>
        </p>
        <?php foreach($data as $key => $value) : ?>
            <?php if ($key != 'attacks') : ?>
                <p> <?php echo $key; ?> = <?php echo $value; ?> </p>   
            <?php endif; ?>    
        <?php endforeach; ?>
        <?php if(empty($data['attacks'])) : ?>
            <p>No attacks were found.</p>

        <?php else: ?>

        <?php foreach($data['attacks'] as $attack) : ?>
			
			<h3><?php echo $attack->_id; ?></h3>
            <p>The attack took place on 
            <?php echo $attack->iday; ?>/<?php echo $attack->imonth; ?>
            /<?php echo $attack->iyear; ?>
            in the country <?php echo $attack->country; ?>
            within the region <?php echo $attack->region; ?> in the province
            <?php echo $attack->provstate; ?>, city <?php echo $attack->city; ?>(lat = <?php echo $attack->latitude; ?>, long = <?php echo $attack->longitude; ?>)</p>

            <p>Was it successful? R: <?php echo $attack->success; ?></p>
            <p>The attack type: <?php echo $attack->attacktype1; ?></p>
            <p>The target type: <?php echo $attack->targtype1; ?></p>
            <p>The target type in txt: <?php echo $attack->targtype1_txt; ?></p>
            <p>The gname: <?php echo $attack->gname; ?></p>
            <p>The motive: <?php echo $attack->motive; ?></p>
			<p>The weapon type:  <?php echo $attack->weaptype1; ?></p>
			<p>The no of people slain: <?php echo $attack->nkill; ?></p>	
			
		<?php endforeach; ?>
        <?php endif; ?>

    </body>
</html>