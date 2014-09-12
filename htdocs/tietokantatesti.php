<?php
require_once 'lib/tietokantayhteys.php';
require_once 'lib/kayttaja.php';

$kayttajat = Kayttaja::get_kayttajat();?><!DOCTYPE html>
<html>
    <head>
	    <link href="../css/bootstrap.css" rel="stylesheet">
	    <link href="../css/bootstrap-theme.css" rel="stylesheet">
	    <link href="../css/main.css" rel="stylesheet">
        <title>Muistilista</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <h1>Käyttäjät</h1>
        <table class="table">
            <tr> <th>Käyttäjänimi</th><th>Salasana</th></tr>  
            <?php foreach ($kayttajat as $kayttaja) {?>
                <tr><td><?php $kayttaja->get_kayttajatunnus();?></td>
                    <td><?php $kayttaja->get_salasana();?></td>
                </tr>
            <?php endforeach; ?>
        </table>





