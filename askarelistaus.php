<?php

require_once 'lib/common.php';
require_once 'lib/models/kayttaja.php';
require_once 'lib/models/askare.php';

if (!kirjautunut()) {
    naytaNakyma('kirjaudu.php', array());
}

naytaNakyma('askarelistaus.php', array('navbar' => 0,
        'askareet' => Askare::get_kayttajan_askareet($_SESSION['kirjautunut_kayttaja_id'])));
