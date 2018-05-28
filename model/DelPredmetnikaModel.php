<?php

require_once "DBInit.php";

class DelPredmetnikaModel {
    public static function getAllModulov() {
        $db = DBInit::getInstance();
        $statement = $db->prepare("
            SELECT *
            FROM del_predmetnika
            WHERE tip = 'm' AND AKTIVNOST = 1
        ");
        $statement->execute();
        return $statement->fetchAll();
    }
    
    public static function getSubjects($id) {
        $db = DBInit::getInstance();
        $statement = $db->prepare("
            SELECT p.ID_PREDMET, IME_PREDMET, ST_KREDITNIH_TOCK
            FROM del_predmetnika AS dp
            JOIN predmetnik as pk ON dp.ID_DELPREDMETNIKA = pk.ID_DELPREDMETNIKA
            JOIN predmet as p ON p.ID_PREDMET = pk.ID_PREDMET
            WHERE tip = 'm' AND dp.ID_DELPREDMETNIKA = :ID_DELPREDMETNIKA
        ");
        $statement->bindValue(":ID_DELPREDMETNIKA", $id);
        $statement->execute();
        return $statement->fetchAll();
    }
}