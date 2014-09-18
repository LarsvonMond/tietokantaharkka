<?php

require_once 'lib/common.php';

if (!kirjautunut()) {
    naytaNakyma('kirjaudu.php', array());
}

naytaNakyma('lisaa_askare.php', array('navbar' => 1));
