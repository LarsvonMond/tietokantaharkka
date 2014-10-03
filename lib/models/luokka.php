<?php

require_once 'lib/common.php';

class Luokka {
  
    private $id;
    private $nimi;
    private $yliluokka;
    private $yliluokka_id;
    private $virheet;

    public function __construct() {
        $this->virheet = array();
        
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
            if (!(isset($tulos->yliluokka_id))) {
                foreach($tulokset as $yliluokkakandidaatti) {
                    if ($tulos->yliluokka_id == $yliluokkakandidaatti->id) {
                        $tulos->yliluokka = $yliluokkakandidaatti;
                    }
                }
            }
        }
        return $tulokset;
    }

    public static function get_luokka_nimella($luokan_nimi, $kayttaja_id) {
        $sql = 'SELECT luokka.id, luokka.nimi, luokka.yliluokka_id
                FROM luokka, kayttaja, askareenluokka, askare
                WHERE
                    kayttaja.id = askare.kayttaja_id AND
                    askare.id = askareenluokka.askare_id AND
                    luokka.id = askareenluokka.luokka_id AND 
                    luokka.nimi = ? AND
                    kayttaja.id = ?
                LIMIT 1';
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($luokan_nimi, $kayttaja_id));
        $tulos = $kysely->fetchObject();
        if ($tulos == null) {
            return null;
        }
        $luokka = new Luokka();
        $luokka->set_id($tulos->id);
        $luokka->set_nimi($tulos->nimi);
        $luokka->set_yliluokka_id($tulos->yliluokka_id);
        return $luokka;
    }

    public function lisaa_kantaan() {
        $sql = 'INSERT INTO luokka(nimi, yliluokka_id) VALUES (?,?) RETURNING id';
        $kysely = getTietokantayhteys()->prepare($sql);
        $ok = $kysely->execute(array($this->get_nimi(), $this->get_yliluokka_id()));
        $this->id = $kysely->fetchColumn();
        return $ok;
    }
        

    public static function get_kayttajan_luokat($kayttaja_id) {
        $sql = 'SELECT DISTINCT luokka.id, luokka.nimi, luokka.yliluokka_id
                FROM 
                    kayttaja, askare, askareenluokka, luokka
                WHERE 
                    kayttaja.id = askare.kayttaja_id AND
                    askareenluokka.askare_id = askare.id AND
                    askareenluokka.luokka_id = luokka.id AND
                    kayttaja.id = ?
                ORDER BY luokka.nimi';
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($kayttaja_id));
        $luokat = array();
        foreach($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $luokka = new Luokka();
            $luokka->set_id($tulos->id);
            $luokka->set_nimi($tulos->nimi);
            $luokka->set_yliluokka_id($tulos->yliluokka_id);
            $luokat[] = $luokka;
        }

        return $luokat;
    }

    public static function etsi_nimi($id) {
        $sql = 'SELECT nimi 
                FROM luokka
                WHERE id = ?';
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($id));
        $tulos = $kysely->fetchObject();
        if ($tulos == null) {
            return null;
        }
        return $kysely->fetchColumn();
    }

    public function kelvollinen() {
        return empty($this->virheet);
    }

    public static function poista_turhat() {
        $sql = 'DELETE FROM luokka WHERE luokka.id NOT IN
                   (SELECT luokka.id
                    FROM luokka, askareenluokka
                    WHERE luokka.id = askareenluokka.luokka_id)';
        $poistokysely = getTietokantayhteys()->prepare($sql);
        $poistokysely->execute();
    }

    /* Getterit ja setterit */
    public function get_yliluokka_nimi() {
        if (empty($this->yliluokka_id)) {
            return "";
        }
        $sql = 'SELECT nimi
                FROM luokka
                WHERE 
                    luokka.id = ?
                LIMIT 1';
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($this->yliluokka_id));
        
        return $kysely->fetchObject()->nimi;
    }

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

        if(trim($value) == '') {
            $this->virheet['nimi'] = 'Nimi ei saa olla tyhjä';
        }else{
            unset($this->virheet['nimi']);
        }
    }
    public function get_yliluokka() {
        return $this->yliluokka;
    }
    public function set_yliluokka($value) {
        $this->yliluokka = $value;
    }
    public function get_yliluokka_id() {
        return $this->yliluokka_id;
    }
    public function set_yliluokka_id($value) {
        $this->yliluokka_id = $value;
    
        $nimi = Luokka::etsi_nimi($value);
        if (empty($nimi)) {
            $this->virheet['yliluokka_id'] = 'Yliluokkaa ei ole olemassa';
        }else{
            unset($this->virheet['yliluokka_id']);
        }
    }
}
