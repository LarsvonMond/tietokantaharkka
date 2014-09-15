<!DOCTYPE html>
<html>
    <head>
	    <link href="../css/bootstrap.css" rel="stylesheet">
	    <link href="../css/bootstrap-theme.css" rel="stylesheet">
	    <link href="../css/main.css" rel="stylesheet">

        <script src="../js/jquery.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <title>Kirjaudu</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <h1>Muistilista</h1>
        <form action="login.php" method="POST">
            <label for="kayttajatunnus">Käyttäjätunnus</label>
            <input type="text" class="form-control" name="kayttajatunnus" placeholder="Käyttäjätunnus">
            <label for="salasana">Salasana</label>
            <input type="password" class="form-control" name="salasana" placeholder="Salasana">       
            <button class="btn btn-default" type="submit">Kirjaudu</button>
        </form>
    </body>
</html>
