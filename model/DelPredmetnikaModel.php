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
            SELECT DISTINCT  p.ID_PREDMET, IME_PREDMET, ST_KREDITNIH_TOCK, SIFRA_PREDMET
            FROM del_predmetnika AS dp
            JOIN predmetnik as pk ON dp.ID_DELPREDMETNIKA = pk.ID_DELPREDMETNIKA
            JOIN predmet as p ON p.ID_PREDMET = pk.ID_PREDMET
            WHERE tip = 'm' AND dp.ID_DELPREDMETNIKA = :ID_DELPREDMETNIKA
        ");
        $statement->bindValue(":ID_DELPREDMETNIKA", $id);
        $statement->execute();
        return $statement->fetchAll();
    }
    
    public static function getAllSubjectsByType($data) {
        $db = DBInit::getInstance();
        $statement = $db->prepare("
            SELECT dp.ID_DELPREDMETNIKA, p.ID_PREDMET, IME_PREDMET, ST_KREDITNIH_TOCK, SIFRA_PREDMET
            FROM del_predmetnika AS dp
            JOIN predmetnik as pk ON dp.ID_DELPREDMETNIKA = pk.ID_DELPREDMETNIKA
            JOIN predmet as p ON p.ID_PREDMET = pk.ID_PREDMET
            WHERE tip = :TIP AND ID_LETNIK = :ID_LETNIK AND ID_STUD_LETO = :ID_STUD_LETO AND ID_PROGRAM = :ID_PROGRAM AND dp.AKTIVNOST = 1
        ");
        $statement->bindValue(":ID_STUD_LETO", $data["ID_STUD_LETO"]);
        $statement->bindValue(":ID_PROGRAM", $data["ID_PROGRAM"]);
        $statement->bindValue(":ID_LETNIK", $data["ID_LETNIK"]);
        $statement->bindValue(":TIP", $data["TIP"]);
        $statement->execute();
        return $statement->fetchAll();
    }
}