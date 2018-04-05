<?php
require_once "DBInit.php";

class ProfesorDB {

    public static function addPredmet($name)
    {
        $db = DBInit::getInstance();

        // TODO ulica, hisna_stevilka, naslov_za_posiljanje, telefon, email
        $statement = $db->prepare(
            "INSERT INTO predmet
                      (IME_PREDMET,AKTIVNOST_PREDMET)VALUES
                      (:name,1);"
        );
        $statement->bindParam(":name", $name);
        $statement->execute();

        $statement = $db->prepare(
            "SELECT ID_PREDMET FROM predmet 
                      WHERE IME_PREDMET = :name"
        );
        $statement->bindParam(":name", $name);
        $statement->execute();
        return $statement->fetchColumn();
    }
    public static function getIDucitelj($ime, $priimek)
    {$db = DBInit::getInstance();

        // TODO ulica, hisna_stevilka, naslov_za_posiljanje, telefon, email
        $statement = $db->prepare(
            "SELECT ID_UCITELJ FROM ucitelj 
            WHERE ime = :ime 
            AND priimek = :priimek"
        );
        $statement->bindParam(":ime", $ime);
        $statement->bindParam(":priimek", $priimek);
        $statement->execute();
     return $statement->fetchColumn();
    }

    public static function getStudLeto($leto)
    {$db = DBInit::getInstance();

        // TODO ulica, hisna_stevilka, naslov_za_posiljanje, telefon, email
        $statement = $db->prepare(
            "SELECT ID_STUD_LETO FROM studijsko_leto 
            WHERE STUD_LETO = :leto"
        );
        $statement->bindParam(":leto", $leto);
        $statement->execute();
        return $statement->fetchColumn();
    }
    public static function addIzvedbaPredmet($idPredmet,$studLeto,$ucitelj,$ucitelj2,$ucitelj3)
    {

        $db = DBInit::getInstance();

        // TODO ulica, hisna_stevilka, naslov_za_posiljanje, telefon, email
        $statement = $db->prepare(
            "INSERT INTO izvedba_predmeta
          (ID_UCITELJ1,ID_STUD_LETO,ID_UCITELJ2,ID_UCITELJ3,ID_PREDMET)VALUES
          (:ucitelj1,:leto,:ucitelj2,:ucitelj3,:predmet);
"
        );
        $statement->bindParam(":ucitelj1", $ucitelj);
        $statement->bindParam(":leto", $studLeto);
        $statement->bindParam(":ucitelj2", $ucitelj2);
        $statement->bindParam(":ucitelj3", $ucitelj3);
        $statement->bindParam(":predmet", $idPredmet);
        $statement->execute();

        $statement = $db->prepare(
            "SELECT ID_PREDMET FROM predmet 
                      WHERE IME_PREDMET = :name"
        );

        return $statement->fetch();
    }

    public static function getPredmeti(){
        $db = DBInit::getInstance();
        // TODO ulica, hisna_stevilka, naslov_za_posiljanje, telefon, email
        $statement = $db->prepare(
            "SELECT * FROM izvedba_predmeta"
        );
        $statement->execute();
        return $statement->fetchAll();

    }
    public static function getPredmetIme($id){
        $db = DBInit::getInstance();
        // TODO ulica, hisna_stevilka, naslov_za_posiljanje, telefon, email
        $statement = $db->prepare(
            "SELECT IME_PREDMET FROM predmet
            WHERE ID_PREDMET = :id
            "
        );
        $statement->bindParam(":id", $id);
        $statement->execute();
        return $statement->fetchColumn();
    }

    public static function getUcitelj1($id){
        $db = DBInit::getInstance();
        echo("<script>console.log('DATA: : ', ".$id.");</script>");
        // TODO ulica, hisna_stevilka, naslov_za_posiljanje, telefon, email
        $statement = $db->prepare(
            "SELECT IME, PRIIMEK FROM ucitelj
            WHERE ID_UCITELJ = :id
            "
        );
        $statement->bindParam(":id", $id);
        $statement->execute();
        return $statement->fetchColumn();
    }
    public static function getUcitelj2($id){
        $db = DBInit::getInstance();
        // TODO ulica, hisna_stevilka, naslov_za_posiljanje, telefon, email
        $statement = $db->prepare(
            "SELECT IME, PRIIMEK FROM ucitelj
            WHERE ID_UCITELJ = :id
            "
        );
        $statement->bindParam(":id", $id);
        $statement->execute();
        return $statement->fetchColumn();
    }
    public static function getUcitelj3($id){
        $db = DBInit::getInstance();
        // TODO ulica, hisna_stevilka, naslov_za_posiljanje, telefon, email
        $statement = $db->prepare(
            "SELECT IME, PRIIMEK FROM ucitelj
            WHERE ID_UCITELJ = :id
            "
        );
        $statement->bindParam(":id", $id);
        $statement->execute();
        return $statement->fetchColumn();
    }
}

