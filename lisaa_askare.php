<?php

require_once 'lib/common.php';

if (!kirjautunut()) {
    header('Location: kirjaudu.php');
}

naytaNakyma('lisaa_askare.php', array('navbar' => 1,
     'luokat' => Luokka::get_kayttajan_luokat($_SESSION['kirjautunut_kayttaja_id'])));
