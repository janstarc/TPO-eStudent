<?php

require_once "DBInit.php";

class NasloveData {

    public static function getPosta($id){
       // var_dump("FIrst".$id);

        $db = DBInit::getInstance();
        $statement = $db->prepare("
            SELECT DISTINCT p.ST_POSTA,p.KRAJ
            FROM posta as p
            JOIN naslov n ON p.ID_POSTA = n.ID_POSTA
            WHERE p.ID_POSTA=:id
        ");

        $statement->bindValue(":id", $id);

        $statement->execute();
        return $statement->fetchAll();
    }

    public static function getObcina($id){
      //  var_dump("Sec".$id);
        $db = DBInit::getInstance();
        $statement = $db->prepare("
            SELECT DISTINCT ob.IME_OBCINA
            FROM obcina as ob
            JOIN naslov n ON ob.ID_OBCINA = n.ID_OBCINA 
            WHERE ob.ID_OBCINA=:id
        ");

        $statement->bindValue(":id", $id);
        $statement->execute();
        return $statement->fetchAll();
    }

    public static function getDrzava($id){

        $db = DBInit::getInstance();
        $statement = $db->prepare("
            SELECT DISTINCT d.SLOVENSKINAZIV
            FROM drzava as d
            JOIN naslov n ON d.ID_DRZAVA = n.ID_DRZAVA 
            WHERE d.ID_DRZAVA=:id
        ");
        $statement->bindValue(":id", $id);
        $statement->execute();
        return $statement->fetchAll();
    }


}