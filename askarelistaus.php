<?php

require_once 'lib/common.php';
require_once 'lib/models/kayttaja.php';
require_once 'lib/models/askare.php';
require_once 'lib/models/luokka.php';

if (!kirjautunut()) {
    header('Location: index.php');
}

$askareet = array();
$luokka_idt = array();
foreach(Luokka::get_kayttajan_luokat($_SESSION['kirjautunut_kayttaja_id']) as $luokka) {
    if (isset($_POST[$luokka->get_id()])) {
        $luokka_idt[] = $luokka->get_id();
    }
}

$askareet = Askare::get_kayttajan_askareet_luokkien_mukaan($_SESSION['kirjautunut_kayttaja_id'], $luokka_idt);

naytaNakyma('askarelistaus.php', array('admin' => Kayttaja::onko_admin($_SESSION['kirjautunut_kayttaja_id']), 'navbar' => 0, 'askareet' => $askareet));


