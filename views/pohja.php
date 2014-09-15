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
        <h1>Muistilista</h1>
        <ul class="nav nav-pills" role="tablist">
            <li class="active"><a href="#">Askarelista</a></li>
            <li><a href="lisaa_askare.html">Lisää askare</a></li>
            <li><a href="#">Vaihda salasana</a></li>
            <li><a href="kirjaudu.html">Kirjaudu ulos</a></li>
        </ul>
        <div id="content">
        <?php require 'views/'.$sivu; ?>
        </div>
    </body>
</html>