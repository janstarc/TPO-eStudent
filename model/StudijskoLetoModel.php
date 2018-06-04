<?php

require_once "DBInit.php";

class StudijskoLetoModel {
    public static function getIdOfYear($currentYear) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT ID_STUD_LETO
            FROM STUDIJSKO_LETO
            WHERE STUD_LETO = :currentYear
        ");
        $statement->bindParam(":currentYear", $currentYear);
        $statement->execute();
        $YearId = $statement->fetch();

        if ($YearId != null) {
            return $YearId;
        } else {
            throw new InvalidArgumentException("No record with Year $currentYear");
        }
    }

    public static function getIme($id_stud_leto) {
        $db = DBInit::getInstance();
        $statement = $db->prepare("
            SELECT STUD_LETO
            FROM studijsko_leto
            WHERE ID_STUD_LETO = :id_stud_leto
        ");

        $statement->bindValue(":id_stud_leto", $id_stud_leto);
        $statement->execute();
        $res = $statement->fetch();
        return $res["STUD_LETO"];
    }
    
    public static function getAll() {
        $db = DBInit::getInstance();
        $statement = $db->prepare("
            SELECT *
            FROM STUDIJSKO_LETO
        ");
        $statement->execute();
        $res = $statement->fetchAll();
        return $res;
    }
    public static function getAllProgram() {
        $db = DBInit::getInstance();
        $statement = $db->prepare("
            SELECT *
            FROM PROGRAM
        ");
        $statement->execute();
        $res = $statement->fetchAll();
        return $res;
    }

    public static function getbyLetnik($id1, $id2, $id3) {
        $db = DBInit::getInstance();
        $statement = $db->prepare("
           SELECT DISTINCT v.VPISNA_STEVILKA, o.PRIIMEK, o.IME, v3.OPIS_VPISA  from oseba o
JOIN student s ON o.ID_OSEBA = s.ID_OSEBA
JOIN vpis v on v.VPISNA_STEVILKA = s.VPISNA_STEVILKA
JOIN vrsta_vpisa v3 ON v.ID_VRSTAVPISA = v3.ID_VRSTAVPISA
where v.ID_PROGRAM = :program and v.ID_STUD_LETO = :leto and v.ID_LETNIK = :letnik
        ");
        $statement->bindValue(":leto", $id1);
        $statement->bindValue(":program", $id2);
        $statement->bindValue(":letnik", $id3);
        $statement->execute();
        $res = $statement->fetchAll();

        return $res;
    }
    public static function getAllLetnik() {
        $db = DBInit::getInstance();
        $statement = $db->prepare("
            SELECT *
            FROM LETNIK
        ");
        $statement->execute();
        $res = $statement->fetchAll();
        return $res;
    }
}