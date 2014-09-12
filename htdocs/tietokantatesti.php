<?php
require 'lib/tietokantayhteys.php';

$yhteys = getTietokantayhteys();

$sql = 'SELECT id, kayttajatunnus, salasana from kayttajat';
$kysely = $yhteys->prepare($sql);
$kysely->execute();

$assosiaatiotaulu = $kysely->fetch();
echo $assosiaatiotaulu['kayttajatunnus'];

