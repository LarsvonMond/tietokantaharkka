<?php

require_once 'lib/common.php';
require_once 'lib/models/luokka.php';
require_once 'lib/models/askare.php';
require_once 'lib/models/kayttaja.php';

if (!kirjautunut()) {
    header('Location: kirjaudu.php');
}

if (isset($_POST['kuvaus'])) {
    $askare = new Askare();
    $askare->set_kuvaus(htmlspecialchars($_POST['kuvaus']));
    $askare->set_tarkeys($_POST['tarkeys']);
    $askare->set_kayttaja(Kayttaja::get_kayttaja($_SESSION['kirjautunut_kayttaja_id']));
    $luokat = array();

    foreach (Luokka::get_kayttajan_luokat($_SESSION['kirjautunut_kayttaja_id']) as $luokka) {
        if (isset($_POST[$luokka->get_id()])) {
            $luokat[] = $luokka->get_id();
        }
    }
    $askare->set_luokat($luokat);
    if ($askare->kelvollinen()) {
        $askare->lisaa_kantaan();
        header('Location: askarelistaus.php');
    }
    else{
        $virheet = $askare->get_virheet();
        naytaNakyma('lisaa_askare.php', array('navbar' => 1, 'luokat' => Luokka::get_kayttajan_luokat($_SESSION['kirjautunut_kayttaja_id']), 'virheet' => $virheet));
    }
}    

naytaNakyma('lisaa_askare.php', array('navbar' => 1,
     'luokat' => Luokka::get_kayttajan_luokat($_SESSION['kirjautunut_kayttaja_id'])));
