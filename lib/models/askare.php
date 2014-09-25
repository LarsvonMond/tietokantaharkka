<?php

require_once 'lib/common.php';
require_once 'lib/models/kayttaja.php';
require_once 'lib/models/luokka.php';

class Askare {
    
    private $id;
    private $kayttaja;
    private $kuvaus;
    private $tarkeys;
    private $luokat;
    private $virheet;

    public function __construct() {
        $this->virheet = array();
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
            $askare = new Askare();
            $askare->set_id($id);
            $askare->set_kayttaja($kayttaja);
            $askare->set_kuvaus($tulos->kuvaus);
            $askare->set_tarkeys($tulos->tarkeys);
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
        foreach($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $askare = new Askare();
            $askare->set_id($tulos->id);
            $askare->set_kayttaja(Kayttaja::get_kayttaja($kayttaja_id));
            $askare->set_kuvaus($tulos->kuvaus);
            $askare->set_tarkeys($tulos->tarkeys);
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
                ';
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($kayttaja_id, $luokka_id));
            
        $askareet = array();
        foreach($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $askare = new Askare();
            $askare->set_id($tulos->id);
            $askare->set_kayttaja(Kayttaja::get_kayttaja($kayttaja_id));
            $askare->set_kuvaus($tulos->kuvaus);
            $askare->set_tarkeys($tulos->tarkeys);
            $askare->set_luokat(array($tulos->nimi));
            $askareet[] = $askare;   
        }

        return $askareet;
    }

    public static function etsi($id) {
        $sql = 'SELECT askare.kuvaus, askare.tarkeys, kayttaja.id
                FROM askare, kayttaja
                WHERE
                    askare.kayttaja_id = kayttaja.id AND
                    askare.id = ?
                ';
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($id));
        $tulos = $kysely->fetchObject();
        $askare = new Askare();
        $askare->set_id($id);
        $askare->set_kayttaja(Kayttaja::get_kayttaja($tulos->id));
        $askare->set_kuvaus($tulos->kuvaus);
        $askare->set_tarkeys($tulos->tarkeys);
        $sql = 'SELECT luokka.id
                FROM askare, askareenluokka, luokka
                WHERE
                    askare.id = askareenluokka.askare_id AND
                    luokka.id = askareenluokka.luokka_id AND
                    askare.id = ?
                ';
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($id));
        $luokka_idt = array();
        foreach($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $luokka_idt[] = $tulos->id;
        }
        $askare->set_luokat($luokka_idt);
        return $askare;
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
    public function lisaa_luokkaviittaus_kantaan($luokka_id) {
        $sql = 'INSERT INTO askareenluokka(askare_id, luokka_id)
                VALUES (?,?)';
        $kysely = getTietokantayhteys()->prepare($sql);
        return $kysely->execute(array($this->get_id(), $luokka_id));
    }
    
    public function delete() {
        if($this->get_kayttaja()->get_id() == $_SESSION['kirjautunut_kayttaja_id']) {
            $sql = 'DELETE FROM askare WHERE id = ?';
            $poistokysely = getTietokantayhteys()->prepare($sql);
            $poistokysely->execute(array($this->get_id()));
            return TRUE;
        }
        return FALSE;
    }

    private function poista_luokkaviittaukset() {
        $sql = 'SELECT askareenluokka.id
                FROM askare, luokka, askareenluokka
                WHERE 
                    askare.id = askareenluokka.askare_id AND
                    luokka.id = askareenluokka.luokka_id AND
                    askare.id = ?';
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($this->get_id()));
        foreach($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $sql = 'DELETE FROM askareenluokka WHERE id = ?';
            $poistokysely = getTietokantayhteys()->prepare($sql);
            $poistokysely->execute(array($tulos->id));
        }
    }
    
    private function paivita_luokkaviittaukset() {
        $this->poista_luokkaviittaukset();
        foreach($this->luokat as $luokka_id) {
            $this->lisaa_luokkaviittaus_kantaan($luokka_id);
        }
    }

    public function update() {
        $sql = 'UPDATE askare
                SET kuvaus = ?,
                    tarkeys = ?
                WHERE id = ?';
        $kysely = getTietokantayhteys()->prepare($sql);
        $ok = $kysely->execute(array($this->get_kuvaus(),
                                     $this->get_tarkeys(),
                                     $this->get_id()
                                    ));
        if($ok) {
            $this->paivita_luokkaviittaukset();
        }
        return $ok;
    }
        

    public function lisaa_kantaan() {
        $sql = 'INSERT INTO askare(kuvaus, tarkeys, kayttaja_id)
                VALUES (?,?,?)
                RETURNING id';
        $kysely = getTietokantayhteys()->prepare($sql);
        $ok = $kysely->execute(array($this->get_kuvaus(), 
                                     $this->get_tarkeys(), 
                                     $this->get_kayttaja()->get_id()
                                    )
                              );

        if ($ok) {
            $this->id = $kysely->fetchColumn();
            foreach($this->luokat as $luokka_id) {
                $this->lisaa_luokkaviittaus_kantaan($luokka_id);
            }
        }
        return $ok;
    }

    public function kelvollinen() {
        return empty($this->virheet);
    }

    public function get_virheet() {
        return $this->virheet;
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
        
        if($value instanceof Kayttaja) {
            if(!(Kayttaja::etsi($value->get_id()) == null)) {
                unset($this->virheet['kayttaja']);
            }
        } else {
            $this->virheet['kayttaja'] = 'Käyttäjää ei löydy';
        }
    }
    public function get_kuvaus() {
        return $this->kuvaus;
    }
    public function set_kuvaus($value) {
        $this->kuvaus = $value;

        if(trim($value) == '') {
            $this->virheet['kuvaus'] = 'Kuvaus ei saa olla tyhjä';
        }else{
            unset($this->virheet['kuvaus']);
        }
    }
    public function get_tarkeys() {
        return $this->tarkeys;
    }
    public function set_tarkeys($value) {
        $this->tarkeys = $value;

        if(!is_numeric($value)) {
            $this->virheet['tarkeys'] = 'Tärkeyden täytyy olla numeerinen';
        }else{
            unset($this->virheet['tarkeys']);
        }
    }
    public function get_luokat() {
        return $this->luokat;
    }
    public function set_luokat($value) {
        $this->luokat = $value;
    }
}
