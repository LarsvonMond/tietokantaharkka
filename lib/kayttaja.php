<?php
class Kayttaja {
  
    private $id;
    private $tunnus;
    private $salasana;

    public function __construct($id, $kayttajatunnus, $salasana) {
        $this->id = $id;
        $this->kayttajatunnus = $tunnus;
        $this->salasana = $salasana;
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
}
