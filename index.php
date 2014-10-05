<?php

require_once 'lib/common.php';
require_once 'lib/models/kayttaja.php';
  
if (isset($_SESSION['kirjautunut_kayttaja_id'])) {
    header('Location: askarelistaus.php');
}

if (isset($_POST['kirjaudu'])) {
    //Tarkistetaan että vaaditut kentät on täytetty:
    if (empty($_POST["kayttajatunnus"])) {
        naytaNakyma("login.php", array(
          'virheet' => array("Kirjautuminen epäonnistui! Et antanut käyttäjätunnusta."),
        ));
    }
    $kayttajatunnus = $_POST["kayttajatunnus"];

    if (empty($_POST["salasana"])) {
        naytaNakyma("login.php", array(
          'kayttajatunnus' => $kayttaja,
          'virheet' => array("Kirjautuminen epäonnistui! Et antanut salasanaa."),
        ));
    }
    $salasana = $_POST["salasana"];

    /* Tarkistetaan onko parametrina saatu oikeat tunnukset */
    $kayttaja = Kayttaja::get_kayttaja_tunnuksilla($kayttajatunnus, $salasana);
    if (!empty($kayttaja)) {
        /* Jos tunnus on oikea, ohjataan käyttäjä sopivalla HTTP-otsakkeella kissalistaan. */
        $_SESSION['kirjautunut_kayttaja_id'] = $kayttaja->get_id();
        header('Location: askarelistaus.php');
    } else {
        /* Väärän tunnuksen syöttänyt saa eteensä lomakkeen ja virheen.
         * Tässä käytetään omassa kirjastotiedostossa määriteltyjä yleiskäyttöisiä funktioita.
         */
        naytaNakyma("login.php", array(
          /* Välitetään näkymälle tieto siitä, kuka yritti kirjautumista */
          'kayttajatunnus' => $kayttajatunnus,
          'virheet' => array("Kirjautuminen epäonnistui! Antamasi tunnus tai salasana on väärä."),
        ));
    }
}
else {
    naytaNakyma('login.php', array());
}
