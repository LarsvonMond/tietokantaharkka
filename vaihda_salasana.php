<?php

require_once 'lib/common.php';
require_once 'lib/models/kayttaja.php';

if (!kirjautunut()) {
    header('Location: kirjaudu.php');
}

if (isset($_POST['vaihda'])) {
    $kayttaja = Kayttaja::get_kayttaja($_SESSION['kirjautunut_kayttaja_id']);
    if ($kayttaja->get_salasana() != $_POST['vanha_salasana']) {
        $virheet = array('Vanha salasana on väärin.');
        naytaNakyma('vaihda_salasana.php', array('admin' => Kayttaja::onko_admin($_SESSION['kirjautunut_kayttaja_id']), 'navbar' => 3, 'virheet' => $virheet));
    }
    if ($_POST['uusi_salasana'] != $_POST['uusi_salasana_uudelleen']) {
        $virheet = array('Salasanat eivät vastaa toisiaan.');
        naytaNakyma('vaihda_salasana.php', array('admin' => Kayttaja::onko_admin($_SESSION['kirjautunut_kayttaja_id']), 'navbar' => 3, 'virheet' => $virheet));
    }
    $kayttaja->set_salasana($_POST['uusi_salasana']);
    if ($kayttaja->kelvollinen()) {
        $kayttaja->update();
        $_SESSION['ilmoitus'] = 'Salasana vaihdettu.';
        naytaNakyma('vaihda_salasana.php', array('admin' => Kayttaja::onko_admin($_SESSION['kirjautunut_kayttaja_id']), 'navbar' => 2));
    }
    else{
        naytaNakyma('vaihda_salasana.php', array('admin' => Kayttaja::onko_admin($_SESSION['kirjautunut_kayttaja_id']), 'navbar' => 2, 'virheet' => $kayttaja->get_virheet()));
    }
}
else{
    naytaNakyma('vaihda_salasana.php', array('admin' => Kayttaja::onko_admin($_SESSION['kirjautunut_kayttaja_id']), 'navbar' => 2));
}
