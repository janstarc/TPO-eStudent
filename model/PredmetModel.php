<?php

require_once "DBInit.php";

class PredmetModel {
    public static function getAll($data) {
        $db = DBInit::getInstance();
        $statement = $db->prepare("
            SELECT PREDMET.ID_PREDMET, IME_PREDMET, ST_KREDITNIH_TOCK
            FROM PREDMET
            JOIN PREDMETNIK ON PREDMET.ID_PREDMET = PREDMETNIK.ID_PREDMET
            WHERE ID_LETNIK = :ID_LETNIK AND ID_STUD_LETO = :ID_STUD_LETO AND ID_PROGRAM = :ID_PROGRAM AND PREDMET.AKTIVNOST = 1
        ");
        $statement->bindValue(":ID_STUD_LETO", $data["ID_STUD_LETO"]);
        $statement->bindValue(":ID_PROGRAM", $data["ID_PROGRAM"]);
        $statement->bindValue(":ID_LETNIK", $data["ID_LETNIK"]);
        $statement->execute();
        return $statement->fetchAll();
    }

    public static function getAllByType($data) {
        $db = DBInit::getInstance();
        $statement = $db->prepare("
            SELECT PREDMET.ID_PREDMET, IME_PREDMET, ST_KREDITNIH_TOCK
            FROM PREDMET
            JOIN PREDMETNIK ON PREDMET.ID_PREDMET = PREDMETNIK.ID_PREDMET
            JOIN DEL_PREDMETNIKA ON DEL_PREDMETNIKA.ID_DELPREDMETNIKA = PREDMETNIK.ID_DELPREDMETNIKA
            WHERE ID_LETNIK = :ID_LETNIK AND ID_STUD_LETO = :ID_STUD_LETO AND ID_PROGRAM = :ID_PROGRAM AND TIP = :TIP AND PREDMET.AKTIVNOST = 1
        ");
        $statement->bindValue(":ID_STUD_LETO", $data["ID_STUD_LETO"]);
        $statement->bindValue(":ID_PROGRAM", $data["ID_PROGRAM"]);
        $statement->bindValue(":ID_LETNIK", $data["ID_LETNIK"]);
        $statement->bindValue(":TIP", $data["TIP"]);
        $statement->execute();
        return $statement->fetchAll();
    }
    
    public static function get($id) {
        $db = DBInit::getInstance();
        $statement = $db->prepare("
            SELECT ID_PREDMET, IME_PREDMET, ST_KREDITNIH_TOCK
            FROM PREDMET
            WHERE ID_PREDMET = :ID_PREDMET
        ");
        $statement->bindValue(":ID_PREDMET", $id);
        $statement->execute();
        return $statement->fetch();
    }
    
    public static function getAllByStudent($VPISNA_STEVILKA) {
        $db = DBInit::getInstance();
        $statement = $db->prepare("
            SELECT p.ID_PREDMET, IME_PREDMET, ST_KREDITNIH_TOCK
            FROM predmeti_studenta AS ps
            JOIN PREDMET AS p ON ps.ID_PREDMET = p.ID_PREDMET
            WHERE VPISNA_STEVILKA = :VPISNA_STEVILKA
        ");
        $statement->bindValue(":VPISNA_STEVILKA", $VPISNA_STEVILKA);
        $statement->execute();
        return $statement->fetchAll();
    }
}
