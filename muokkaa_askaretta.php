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
    $luokka_idt = array();

    if (isset($_POST['uusi_luokka'])) {
        $luokan_nimi = trim($_POST['uusi_luokka']);
        if(!(trim($luokan_nimi) == '')) {
            $luokka = Luokka::get_luokka_nimella($luokan_nimi);
            if (!$luokka) {
                $luokka = new Luokka();
                $luokka->set_nimi(htmlspecialchars($luokan_nimi));
                $luokka->set_yliluokka_id($_POST['yliluokka_id']);
                if (TRUE) {            
                    $luokka->lisaa_kantaan();
                }
            }
            $luokka_idt[] = $luokka->get_id();
        }
    }


    foreach (Luokka::get_kayttajan_luokat($_SESSION['kirjautunut_kayttaja_id']) as $luokka) {
        if (isset($_POST[$luokka->get_id()])) {
            $luokka_idt[] = $luokka->get_id();
        }
    }
    $askare->set_luokat($luokka_idt);
    if ($askare->kelvollinen()) {
        $askare->update();
        Luokka::poista_turhat();
        $_SESSION['ilmoitus'] = 'Muutokset tallennettu.';
        header('Location: askarelistaus.php');
    }
    else{
        $virheet = $askare->get_virheet();
        naytaNakyma('muokkaa_askaretta.php', array('navbar' => 1, 'luokat' => Luokka::get_kayttajan_luokat($_SESSION['kirjautunut_kayttaja_id']), 'virheet' => $virheet, 'askare' => $askare));
    }
}
else {
    if(isset($_POST['delete'])) {
        $askare = Askare::etsi((int)$_POST['id']);
        if($askare->delete()) {
            Luokka::poista_turhat();
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
}
