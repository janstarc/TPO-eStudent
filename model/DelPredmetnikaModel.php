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
}