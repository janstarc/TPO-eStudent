<?php

require_once "DBInit.php";

class RokModel {
    public static function insert($idIzvedbaPredmeta, $date, $time) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            INSERT INTO ROK (ID_IZVEDBA, DATUM_ROKA, CAS_ROKA, AKTIVNOST_ROKA)
            VALUES (:idIzvedbaPredmeta, :date, :time, TRUE)
        ");
        
        $statement->bindParam(":idIzvedbaPredmeta", $idIzvedbaPredmeta, PDO::PARAM_INT);
        $statement->bindParam(":date", $date);
        $statement->bindParam(":time", $time);
        $statement->execute();
    }
}