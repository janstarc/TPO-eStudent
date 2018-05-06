<?php

require_once "DBInit.php";

class DrzavaModel {
    public static function getAll() {
        $db = DBInit::getInstance();
        $statement = $db->prepare("
            SELECT *
            FROM DRZAVA
            WHERE AKTIVNOST = 1
            ORDER BY SLOVENSKINAZIV
        ");
        $statement->execute();
        return $statement->fetchAll();
    }
}