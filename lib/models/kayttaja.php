<?php

require_once 'lib/common.php';

class Kayttaja {
  
    private $id;
    private $kayttajatunnus;
    private $salasana;
    private $admin;
    private $virheet;

    public function __construct() {
        $this->admin = 0;
        $this->virheet = array();    
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
        if(empty($tulos->admin)) {
            $kayttaja->set_admin(0); 
        }
        return $kayttaja;
    }
    
    public static function onko_kayttajanimi_varattu($kayttajatunnus) {
        $sql = 'SELECT kayttajatunnus from kayttaja where kayttajatunnus = ? LIMIT 1';
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($kayttajatunnus));
        $tulos = $kysely->fetchObject();
        if ($tulos == null) {
            return FALSE;
        }
        return TRUE;
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

    public static function admin_count() {
        $sql = 'SELECT id FROM kayttaja WHERE admin = TRUE';
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute();
        return count($kysely->fetchAll(PDO::FETCH_OBJ));
    }

    public function delete() {
        $sql = 'DELETE FROM kayttaja WHERE id = ?';
        $poistokysely = getTietokantayhteys()->prepare($sql);
        $ok = $poistokysely->execute(array($this->get_id()));
        return $ok;
    }

    public function update() {
        $sql = 'UPDATE kayttaja
                SET salasana = ?,
                    admin = ?
                WHERE id = ?';
        $kysely = getTietokantayhteys()->prepare($sql);
        $ok = $kysely->execute(array($this->get_salasana(), $this->get_admin(), $this->get_id()));
        return $ok;
    }

    public function kelvollinen() {
        return empty($this->virheet);
    }
    
    public function get_virheet() {
        return $this->virheet;
    }

    public function lisaa_kantaan() {
        $sql = 'INSERT INTO kayttaja(kayttajatunnus, salasana, admin) 
                VALUES (?,?,?)
                RETURNING id';
        $kysely = getTietokantayhteys()->prepare($sql);
        $ok = $kysely->execute(array($this->get_kayttajatunnus(), 
                                     $this->get_salasana(), 
                                     $this->get_admin()
                                    )
                              );

        if ($ok) {
            $this->id = $kysely->fetchColumn();
        }
        return $ok;
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

        if (Kayttaja::onko_kayttajanimi_varattu($tunnus)) {
            $this->virheet['kayttajatunnus'] = 'Käyttäjätunnus on jo käytössä.';
        }
        if(trim($tunnus) == '') {
            $this->virheet['kayttajatunnus'] = 'Käyttäjätunnus ei saa olla tyhjä.';
        }
        else
        {
            unset($this->virheet['kayttajatunnus']);
        }
    }
    public function set_salasana($salasana){
        $this->salasana = $salasana;

        if(trim($salasana) == '') {
            $this->virheet['salasana'] = 'Salasana on liian lyhyt.';
        }
        else{
            unset($this->virheet['salasana']);
        }
    }
    public function set_id($id){
        $this->id = $id;
    }
    public function set_admin($value) {
        $this->admin = $value;

        if (!($value == 0 || $value == 1)) {
            $this->virheet['admin'] = 'Attribuutin admin täytyy olla 0 tai 1';
        }else{
            unset($this->virheet['admin']);
        }
    }
}
