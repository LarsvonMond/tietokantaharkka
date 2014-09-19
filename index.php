<?php

require_once 'lib/common.php';
  
if (isset($_SESSION['kirjautunut_kayttaja_id'])) {
    header('Location: askarelistaus.php');
}

naytaNakyma('login.php', array());
