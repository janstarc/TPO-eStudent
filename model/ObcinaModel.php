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

    public static function isMatchPostaObcina($id_posta, $id_obcina){

        $db = DBInit::getInstance();
        $statement = $db -> prepare("
            SELECT po.MID_OBCINA, po.MID_POSTA
            FROM posta_obcina AS po
            JOIN posta AS p ON p.MID_POSTA = po.MID_POSTA
            JOIN obcina AS o ON o.MID_OBCINA = po.MID_OBCINA
            WHERE p.ID_POSTA = :id_posta
            AND o.ID_OBCINA = :id_obcina;
        ");

        $statement->bindValue(":id_posta", $id_posta);
        $statement->bindValue(":id_obcina", $id_obcina);

        $statement->execute();
        $result = $statement->fetch();

        if(empty($result)) return false;
        return true;
    }
}