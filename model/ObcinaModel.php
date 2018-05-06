<?php

require_once "DBInit.php";

class ObcinaModel {
    public static function getAll() {
        $db = DBInit::getInstance();
        $statement = $db->prepare("
            SELECT *
            FROM OBCINA
            WHERE AKTIVNOST = 1
            ORDER BY IME_OBCINA
        ");
        $statement->execute();
        return $statement->fetchAll();
    }
}