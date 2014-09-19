<?php

session_start();

unset($_SESSION['kirjautunut_kayttaja_id']);

header('Location: kirjaudu.php');
?>
