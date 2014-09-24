<?php

require_once 'lib/common.php';
require_once 'lib/models/luokka.php';

if (!kirjautunut()) {
    header('Location: kirjaudu.php');
}

naytaNakyma('suodata.php', array('navbar' => 0,
        'luokat' => Luokka::get_kayttajan_luokat($_SESSION['kirjautunut_kayttaja_id'])));
