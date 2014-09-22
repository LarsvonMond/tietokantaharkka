<?php

require_once 'lib/common.php';

class Askare {
    
    private $id;
    private $kayttaja;
    private $kuvaus;
    private $tarkeys;
    private $luokat;

    public function __construct($id, $kayttaja, $kuvaus, $tarkeys) {
        $this->id = $id;
        $this->kayttaja = $kayttaja;
        $this->kuvaus = $kuvaus;
        $this->tarkeys = $tarkeys;
        $this->luokat = array();
    }

    public static function get_askareet($kayttajat, $luokat) {
        $sql = 'SELECT id, kayttaja_id, kuvaus, tarkeys from kayttaja';
        $kysely = getTietokantayhteys()->prepare($sql); $kysely->execute();
        
        $tulokset = array();
        foreach($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $id = $tulos->id;         
            foreach($kayttajat as $k) {
                if ($k->id == $tulos->kayttaja_id) {
                    $kayttaja = $k;
                }
            }
            if (isset($kayttaja)) {
                throw new Exception('Ei id:n mukaista käyttäjää');
            }
            $kuvaus = $tulos->kuvaus;
            $tarkeys = $tulos->tarkeys;

            $askare = new Askare($id, $kayttaja, $kuvaus, $tarkeys);
            $tulokset[] = $askare;
        }

        aseta_luokkaviittaukset($tulokset, $luokat);
        return $tulokset;
    }

    public static function get_kayttajan_askareet($kayttaja_id) {
        $sql = '(SELECT askare.id, askare.kuvaus, askare.tarkeys, luokka.nimi
                FROM askare, askareenluokka, luokka
                WHERE 
                    askare.id = askareenluokka.askare_id AND
                    luokka.id = askareenluokka.luokka_id AND
                    askare.kayttaja_id = ?
                )
                UNION
                (
                SELECT askare.id, askare.kuvaus, askare.tarkeys, NULL
                FROM askare
                WHERE
                    askare.kayttaja_id = ? AND
                    askare.id NOT IN 
                   (SELECT askare_id FROM askareenluokka)
                )';
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($kayttaja_id, $kayttaja_id));

        $askareet = array();
        $kayttaja = Kayttaja::get_kayttaja($kayttaja_id);
        foreach($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $askare = new Askare($tulos->id, $kayttaja, $tulos->kuvaus, $tulos->tarkeys);
            $askare->set_luokat(array($tulos->nimi));
            $askareet[] = $askare;   
        }

        return $askareet;
    }

    public static function get_kayttajan_askareet_luokan_mukaan($kayttaja_id, $luokka_id) {
        $sql = 'SELECT askare.id, askare.kuvaus, askare.tarkeys, luokka.nimi
                FROM askare, askareenluokka, luokka
                WHERE
                    askare.id = askareenluokka.askare_id AND
                    luokka.id = askareenluokka.luokka_id AND
                    askare.kayttaja_id = ? AND
                    luokka.id = ?
                ORDER BY askare.kuvaus
                ');
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($kayttaja_id, $luokka_id));
            
        $askareet = array();
        $kayttaja = Kayttaja::get_kayttaja($kayttaja_id);
        foreach($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $askare = new Askare($tulos->id, $kayttaja, $tulos->kuvaus, $tulos->tarkeys);
            $askare->set_luokat(array($tulos->nimi));
            $askareet[] = $askare;   
        }

        return $askareet;
    }


    private function aseta_luokkaviittauset($askareet, $luokat) {
        $sql = 'SELECT askare_id, luokka_id from askareidenluokat';
        $kysely = getTietokantayhteys()->prepare($sql); $kysely->execute();

        foreach($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            foreach($luokat as $luokka) {
                if ($luokka->id == $tulos->luokka_id) {
                    foreach($askareet as $askare) {
                        if ($askare->id == $tulos->askare_id) {
                            $askare->luokat[] = $luokka;
                            break;
                        }
                    }
                    break;
                }
            }
        }
    }
            

    /* Getterit ja setterit */

    public function get_id() {
        return $this->id;
    }
    public function set_id($value) {
        $this->id = $value;
    }
    public function get_kayttaja() {
        return $this->kayttaja;
    }
    public function set_kayttaja($value) {
        $this->kayttaja = $value;
    }
    public function get_kuvaus() {
        return $this->kuvaus;
    }
    public function set_kuvaus($value) {
        $this->kuvaus = $value;
    }
    public function get_tarkeys() {
        return $this->tarkeys;
    }
    public function set_tarkeys($value) {
        $this->tarkeys = $value;
    }
    public function get_luokat() {
        return $this->luokat;
    }
    public function set_luokat($value) {
        $this->luokat = $value;
    }
}
