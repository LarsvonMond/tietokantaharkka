<?php

require_once 'lib/common.php';
require_once 'lib/models/kayttaja.php';
require_once 'lib/models/askare.php';
require_once 'lib/models/luokka.php';

if (!kirjautunut()) {
    header('Location: kirjaudu.php');
}

$askareet = array();
foreach(Luokka::get_kayttajan_luokat($_SESSION['kirjautunut_kayttaja_id']) as $luokka) {
    if (isset($_POST[$luokka->get_id()])) {
        foreach(Askare::get_kayttajan_askareet_luokan_mukaan($_SESSION['kirjautunut_kayttaja_id'], $luokka->get_id()) as $askare) {
            $askareet[] = $askare;
        }
    }
}

if ($askareet) {
    naytaNakyma('askarelistaus.php', array('navbar' => 0, 'askareet' => $askareet));
}

naytaNakyma('askarelistaus.php', array('navbar' => 0,
        'askareet' => Askare::get_kayttajan_askareet($_SESSION['kirjautunut_kayttaja_id'])));

