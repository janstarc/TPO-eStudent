<?php

require_once "DBInit.php";

class PostaModel {
    public static function getAll() {
        $db = DBInit::getInstance();
        $statement = $db->prepare("
            SELECT *
            FROM POSTA
            WHERE AKTIVNOST = 1
            ORDER BY KRAJ
        ");
        $statement->execute();
        return $statement->fetchAll();
    }
}