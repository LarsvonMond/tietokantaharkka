<?php

require_once 'lib/common.php';
require_once 'lib/models/kayttaja.php';

if (!kirjautunut()) {
    header('Location: kirjaudu.php');
}
if (!Kayttaja::onko_admin($_SESSION['kirjautunut_kayttaja_id'])) {
    header('Location: askarelistaus.php');
}

if (isset($_POST['add'])) {
    $kayttaja = new Kayttaja();
    $kayttaja->set_kayttajatunnus(htmlspecialchars($_POST['kayttajatunnus']));
    $kayttaja->set_salasana($_POST['salasana']);
    if($kayttaja->kelvollinen()) {
        $kayttaja->lisaa_kantaan();
        $_SESSION['ilmoitus'] = 'Käyttäjä lisätty';
        naytaNakyma('kayttajat.php', array('admin' => Kayttaja::onko_admin($_SESSION['kirjautunut_kayttaja_id']), 'navbar' => 4, 'kayttajat' => Kayttaja::get_kayttajat()));
    }
    else{
        naytaNakyma('kayttajat.php', array('admin' => Kayttaja::onko_admin($_SESSION['kirjautunut_kayttaja_id']), 'navbar' => 4, 'kayttajat' => Kayttaja::get_kayttajat(), 'virheet' => $kayttaja->get_virheet()));
    }
}
else{
    naytaNakyma('kayttajat.php', array('admin' => Kayttaja::onko_admin($_SESSION['kirjautunut_kayttaja_id']), 'navbar' => 4, 'kayttajat' => Kayttaja::get_kayttajat()));
}
