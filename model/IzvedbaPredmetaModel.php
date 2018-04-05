<?php

require_once "DBInit.php";

class IzvedbaPredmetaModel {
    public static function getIdIzvedbaPredmetaByTheacher($idUser, $idSubject) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT ID_IZVEDBA, ID_PREDMET, ID_UCITELJ, UCI_ID_UCITELJ, UCI_ID_UCITELJ2
            FROM IZVEDBA_PREDMETA
            WHERE ID_PREDMET = :idSubject
                AND (
                    ID_UCITELJ = :idUser OR UCI_ID_UCITELJ = :idUser OR UCI_ID_UCITELJ2 = :idUser
                )
        ");
        $statement->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $statement->bindParam(":idSubject", $idSubject, PDO::PARAM_INT);
        $statement->execute();
        $IzvedbaPredmeta = $statement->fetch();

        if ($IzvedbaPredmeta != null) {
            return $IzvedbaPredmeta;
        } else {
            throw new InvalidArgumentException("No record with User id $idUser and Subject id $idSubject");
        }
    }
}