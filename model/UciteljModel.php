<?php

require_once "DBInit.php";

class UciteljModel {
    public static function getProfesorId($idUser) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT ID_UCITELJ
            FROM UCITELJ
            WHERE ID_OSEBA = :idUser
        ");
        $statement->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $statement->execute();
        $ProfesorId = $statement->fetch();

        if ($ProfesorId != null) {
            return $ProfesorId;
        } else {
            throw new InvalidArgumentException("No record with User id $idUser");
        }
    }
}