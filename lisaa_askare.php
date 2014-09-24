<?php

require_once 'lib/common.php';
require_once 'lib/models/luokka.php';

if (!kirjautunut()) {
    header('Location: kirjaudu.php');
}

if (isset($_POST['kuvaus'])) {
    $askare = new Askare();
    $askare->set_kuvaus(htmlspecialchars($_POST['kuvaus']));
    $askare->set_tarkeys($_POST['tarkeys']);
    $luokat = array();

    foreach (Luokka::get_kayttajan_luokat($_SESSION['kirjautunut_kayttaja_id']) as $luokka) {
        if (isset($_POST[$luokka->get_id()])) {
            $luokat[] = $luokka->get

naytaNakyma('lisaa_askare.php', array('navbar' => 1,
     'luokat' => Luokka::get_kayttajan_luokat($_SESSION['kirjautunut_kayttaja_id'])));
