<?php
session_start();

/** Funktio joka palauttaa yhteyden tietokantaan PDO-oliona. */
function getTietokantayhteys() {
  //Muuttuja, jonka sisältö säilyy getTietokantayhteys-kutsujen välillä.
  static $yhteys = null; 
  
  //Jos $yhteys on null, pitää se muodostaa.
  if ($yhteys == null) { 
    //Tämä koodi suoritetaan vain kerran, sillä seuraavilla 
    //funktion suorituskerroilla $yhteys-muuttujassa on sisältöä.
    $yhteys = new PDO('pgsql:');
    $yhteys->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  }

  return $yhteys;
}

function naytaNakyma($sivu, $data) {
    $data = (object)$data;
    require 'views/pohja.php';
    exit();
}

function kirjautunut() {
    if (isset($_SESSION['kirjautunut_kayttaja_id'])) {
        return TRUE;
    }
    return FALSE;
}

function activeif($exp, $value) {
    if ($exp == $value) {
        return 'class="active"';
    }
}

