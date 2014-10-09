<!DOCTYPE html>
<html>
    <head>
	    <link href="../css/bootstrap.css" rel="stylesheet">
	    <link href="../css/bootstrap-theme.css" rel="stylesheet">
	    <link href="../css/main.css" rel="stylesheet">
        <script src="../js/jquery.min.js"></script>
        <script src="../js/sivu.js"></script>
        <title>Muistilista</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <?php if (!empty($data->virheet)): ?>
            <?php foreach($data->virheet as $virhe) : ?>
                <div class="alert alert-danger"><?php echo $virhe; ?></div>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['ilmoitus'])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['ilmoitus']; ?>
            </div>
            <?php unset($_SESSION['ilmoitus']); ?>
         <?php endif; ?>

        <h1>Muistilista</h1>    

        <?php if (isset($data->navbar)): ?>
            <ul class="nav nav-pills" role="tablist">
                <li <?php if ($data->navbar == 0) : ?>
                        class="active"
                    <?php endif; ?>><a href="askarelistaus.php">Askarelista</a></li>
                <li <?php if ($data->navbar == 1) : ?>
                        class="active"
                    <?php endif; ?>><a href="lisaa_askare.php">Lisää askare</a></li>
                <li <?php if ($data->navbar == 2) : ?>
                        class="active"
                    <?php endif; ?>><a href="vaihda_salasana.php">Vaihda salasana</a></li>
                <?php if ($data->admin == TRUE) : ?>
                <li <?php if ($data->navbar == 4) : ?>
                        class="active"
                    <?php endif; ?>> <a href="kayttajat.php">Käyttäjät</a></li>
                <?php endif; ?>
                <li <?php if ($data->navbar == 3) : ?>
                        class="active"
                    <?php endif; ?>><a href="logout.php">Kirjaudu ulos</a></li>
            </ul>
        <?php endif; ?>
        <?php require 'views/'.$sivu; ?>
    </body>
</html>
