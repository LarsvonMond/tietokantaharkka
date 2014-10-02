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
    if(isset($_POST['admin'])) {
        $kayttaja->set_admin(1);
    }
    if($kayttaja->kelvollinen()) {
        $kayttaja->lisaa_kantaan();
        $_SESSION['ilmoitus'] = 'Käyttäjä lisätty';
        naytaNakyma('kayttajat.php', array('admin' => Kayttaja::onko_admin($_SESSION['kirjautunut_kayttaja_id']), 'navbar' => 4, 'kayttajat' => Kayttaja::get_kayttajat(),
    'lisattava_kayttaja' => new Kayttaja()));
    }
    else{
        naytaNakyma('kayttajat.php', array('admin' => Kayttaja::onko_admin($_SESSION['kirjautunut_kayttaja_id']), 'navbar' => 4, 'kayttajat' => Kayttaja::get_kayttajat(), 'virheet' => $kayttaja->get_virheet(), 'lisattava_kayttaja' => $kayttaja));
    }
}
else{
    naytaNakyma('kayttajat.php', array('admin' => Kayttaja::onko_admin($_SESSION['kirjautunut_kayttaja_id']), 'navbar' => 4, 'kayttajat' => Kayttaja::get_kayttajat(), 'lisattava_kayttaja' => new Kayttaja()));
}
