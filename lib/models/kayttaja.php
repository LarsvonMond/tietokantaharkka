<?php

require_once 'lib/tietokantayhteys.php';

class Kayttaja {
  
    private $id;
    private $tunnus;
    private $salasana;
    private $admin;

    public function __construct($id, $kayttajatunnus, $salasana, $admin) {
        $this->id = $id;
        $this->kayttajatunnus = $kayttajatunnus;
        $this->salasana = $salasana;
        $this->admin = $admin;
    }

    public static function get_kayttajat() {
        $sql = 'SELECT id, kayttajatunnus, salasana, admin from kayttajat';
        $kysely = getTietokantayhteys()->prepare($sql); $kysely->execute();
        
        $tulokset = array();
        foreach($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $id = $tulos->id;
            $kayttajatunnus = $tulos->kayttajatunnus;
            $salasana = $tulos->salasana;
            $admin = $tulos->admin;
            $kayttaja = new Kayttaja($id, $kayttajatunnus, $salasana, $admin);
            $tulokset[] = $kayttaja;
        }
        return $tulokset;
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
