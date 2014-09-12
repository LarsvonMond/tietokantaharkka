<?php

require_once 'lib/tietokantayhteys.php';

class Kayttaja {
  
    private $id;
    private $tunnus;
    private $salasana;

    public function __construct($id, $kayttajatunnus, $salasana) {
        $this->id = $id;
        $this->kayttajatunnus = $kayttajatunnus;
        $this->salasana = $salasana;
    }

    public static function get_kayttajat() {
        $sql = 'SELECT id, kayttajatunnus, salasana from kayttajat';
        $kysely = getTietokantayhteys()->prepare($sql); $kysely->execute();
        
        $tulokset = array();
        foreach($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $id = $tulos->id;
            $kayttajatunnus = $tulos->kayttajatunnus;
            $salasana = $tulos->salasana;
            $kayttaja = new Kayttaja($id, $kayttajatunnus, $salasana);
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
    public function set_kayttajatunnus($tunnus){
        $this->kayttajatunnus = $tunnus;
    }
    public function set_salasana($salasana){
        $this->salasana = $salasana;
    }
    public function set_id($id){
        $this->id = $id;
    }
}
