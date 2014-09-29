<?php

require_once 'lib/common.php';

class Kayttaja {
  
    private $id;
    private $tunnus;
    private $salasana;
    private $admin;

    public function __construct() {

    }

    public static function etsi($kayttaja_id) {
        $sql = 'SELECT id from kayttaja';
        $kysely = getTietokantayhteys()->prepare($sql); $kysely->execute();
        $tulos = $kysely->fetchObject();
        return $tulos->id;
    }

    public static function get_kayttajat() {
        $sql = 'SELECT id, kayttajatunnus, salasana, admin from kayttaja';
        $kysely = getTietokantayhteys()->prepare($sql); $kysely->execute();
         
        $tulokset = array();
        foreach($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $kayttaja = new Kayttaja();
            $kayttaja->set_id($tulos->id);
            $kayttaja->set_kayttajatunnus($tulos->kayttajatunnus);
            $kayttaja->set_salasana($tulos->salasana);
            $kayttaja->set_admin($tulos->admin);
            $tulokset[] = $kayttaja;
        }
        return $tulokset;
    }

    public static function get_kayttaja($id) {
        $sql = 'SELECT id, kayttajatunnus, salasana, admin from kayttaja where id = ? LIMIT 1';
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($id));
        $tulos = $kysely->fetchObject();
        $kayttaja = new Kayttaja();
        $kayttaja->set_id($tulos->id);
        $kayttaja->set_kayttajatunnus($tulos->kayttajatunnus);
        $kayttaja->set_salasana($tulos->salasana);
        $kayttaja->set_admin($tulos->admin);
        return $kayttaja;
}

    public static function get_kayttaja_tunnuksilla($kayttajatunnus, $salasana) {
        $sql = 'SELECT id, kayttajatunnus, salasana, admin from kayttaja where kayttajatunnus = ? AND salasana = ? LIMIT 1';
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($kayttajatunnus, $salasana));

        $tulos = $kysely->fetchObject();
        if ($tulos == null) {
            return null;
        }
        else {
            $kayttaja = new Kayttaja();
            $kayttaja->set_id($tulos->id);
            $kayttaja->set_kayttajatunnus($tulos->kayttajatunnus);
            $kayttaja->set_salasana($tulos->salasana);
            $kayttaja->set_admin($tulos->admin);
            return $kayttaja;
        }
    }

    public static function onko_admin($id) {
        $sql = 'SELECT admin FROM kayttaja WHERE id = ? LIMIT 1';
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($id));
        return $kysely->fetchColumn();
    }
        

    

  /* Kirjoita tähän gettereitä ja settereitä */
    
    public function get_kayttajatunnus(){
        return $this->kayttajatunnus;
    }
    public function get_salasana(){
        return $this->salasana;
    }
    public function get_id(){
        return $this->id;
    }
    public function get_admin(){
        return $this->admin;
    }
    public function set_kayttajatunnus($tunnus){
        $this->kayttajatunnus = $tunnus;
    }
    public function set_salasana($salasana){
        $this->salasana = $salasana;
    }
    public function set_id($id){
        $this->id = $id;
    }
    public function set_admin($value) {
        $this->admin = $value;
    }
}
