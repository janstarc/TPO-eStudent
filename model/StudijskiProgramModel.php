<?php

require_once "DBInit.php";

class StudijskiProgramModel {
    public static function getAll() {
        $db = DBInit::getInstance();
        $statement = $db->prepare("
            SELECT *
            FROM PROGRAM
        ");
        $statement->execute();
        $res = $statement->fetchAll();
        return $res;
    }
}