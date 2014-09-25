<?php

require_once 'lib/models/askare.php';
require_once 'lib/models/luokka.php';

if (!kirjautunut()) {
    header('Location: kirjaudu.php');
}

if (isset($_POST['kuvaus'])) {
    $askare = new Askare();
    $askare->set_id($_POST['id']);
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
        $askare->update();
        $_SESSION['ilmoitus'] = 'Muutokset tallennettu.';
        header('Location: askarelistaus.php');
    }
    else{
        $virheet = $askare->get_virheet();
        naytaNakyma('muokkaa_askaretta.php', array('navbar' => 1, 'luokat' => Luokka::get_kayttajan_luokat($_SESSION['kirjautunut_kayttaja_id']), 'virheet' => $virheet, 'askare' => $askare));
    }
}
if(isset($_POST['delete'])) {
    $askare = Askare::etsi((int)$_POST['id']);
    if($askare->delete()) {
        $_SESSION['ilmoitus'] = 'Askare poistettu.';
    }
    else{
        $_SESSION['virheet'] = array('Poistaminen epäonnistui.');
    }
    header('Location: askarelistaus.php');
}

else {
    $askare = Askare::etsi((int)$_GET['id']);
        

    naytaNakyma('muokkaa_askaretta.php', array('navbar' => 1, 'luokat' => Luokka::get_kayttajan_luokat($_SESSION['kirjautunut_kayttaja_id']), 'askare' => $askare));
}

