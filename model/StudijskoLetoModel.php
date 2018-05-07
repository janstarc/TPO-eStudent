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
}