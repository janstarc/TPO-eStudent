<?php

require_once "DBInit.php";

class PredmetModel {
    public static function getAll($data) {

        var_dump($data);
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
}
