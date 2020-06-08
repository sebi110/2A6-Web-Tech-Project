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
        <?php foreach($data['params'] as $key => $value) : ?>
        
            <p> <?php echo $key; ?> = <?php echo $value; ?> </p>   
  
        <?php endforeach; ?>
        <?php if(empty($data['attacks'])) : ?>
            <p>No attacks were found.</p>

        <?php else: ?>

            <?php foreach($data['attacks'] as $attack) : ?>
                
                <p>JSON:</p><br><?php echo $attack->toJson(); ?>
                
            <?php endforeach; ?>
        <?php endif; ?>

    </body>
</html>