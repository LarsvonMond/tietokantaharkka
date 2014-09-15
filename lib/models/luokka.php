<?php

require_once 'lib/common.php';

class Luokka {
  
    private $id;
    private $nimi;
    private $yliluokka;
    private $yliluokka_id;

    public function __construct($id, $nimi, $yliluokka_id) {
        $this->id = $id;
        $this->nimi = $nimi;
        $this->yliluokka_id = $yliluokka_id; 
        
    }

    public static function get_luokat() {
        $sql = 'SELECT id, nimi, yliluokka_id from luokat';
        $kysely = getTietokantayhteys()->prepare($sql); $kysely->execute();
        
        $tulokset = array();
        foreach($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $id = $tulos->id;
            $nimi = $tulos->nimi;
            $yliluokka_id = $tulos->yliluokka_id;
            $luokka = new Luokka($id, $nimi, $yliluokka_id);
            $tulokset[] = $luokka;
        }

        foreach($tulokset as $tulos) {
            if ($tulos->yliluokka_id != null) {
                foreach($tulokset as $yliluokkakandidaatti) {
                    if ($tulos->yliluokka_id == $yliluokkakandidaatti->id) {
                        $tulos->yliluokka = $yliluokkakandidaatti;
                    }
                }
            }
        }

        return $tulokset;
    }

    /* Getterit ja setterit */

    public function get_id() {
        return $this->id;
    }
    public function set_id($value) {
        $this->id = $value;
    }
    public function get_nimi() {
        return $this->nimi;
    }
    public function set_nimi($value) {
        $this->nimi = $value;
    }
    public function get_yliluokka() {
        return $this->yliluokka;
    }
    public function set_yliluokka($value) {
        $this->yliluokka = $value;
    }
