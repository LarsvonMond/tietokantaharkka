<!DOCTYPE html>
<html>
    <head>
	    <link href="../css/bootstrap.css" rel="stylesheet">
	    <link href="../css/bootstrap-theme.css" rel="stylesheet">
	    <link href="../css/main.css" rel="stylesheet">
        <title>Muistilista</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <?php if (!empty($data->virheet)): ?>
            <?php foreach($data->virheet as $virhe) : ?>
                <div class="alert alert-danger"><?php echo $virhe; ?></div>
            <?php endforeach; ?>
        <?php endif; ?>

        <h1>Muistilista</h1>    

        <?php if (isset($data->navbar)): ?>
            <ul class="nav nav-pills" role="tablist">
                <li <?php activeif($data->navbar, 0); ?>><a href="askarelistaus.php">Askarelista</a></li>
                <li <?php activeif($data->navbar, 1); ?>><a href="lisaa_askare.php">Lisää askare</a></li>
                <li <?php activeif($data->navbar, 2); ?>><a href="#">Vaihda salasana</a></li>
                <li <?php activeif($data->navbar, 3); ?>><a href="logout.php">Kirjaudu ulos</a></li>
            </ul>
        <?php endif; ?>
        <?php require 'views/'.$sivu; ?>
    </body>
</html>
