<?php

require_once "DBInit.php";

class IzvedbaPredmetaModel {
    public static function getIdIzvedbaPredmetaByProfesor($idUser, $idCurrentYear) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT ip.ID_IZVEDBA, p.ID_PREDMET, p.IME_PREDMET
            FROM IZVEDBA_PREDMETA as ip
            JOIN PREDMET as p ON ip.ID_PREDMET = p.ID_PREDMET
            WHERE ID_STUD_LETO = :idCurrentYear
                AND (
                    ID_UCITELJ1 = :idUser OR ID_UCITELJ2 = :idUser OR ID_UCITELJ3 = :idUser
                )
            ");
        $statement->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $statement->bindParam(":idCurrentYear", $idCurrentYear, PDO::PARAM_INT);
        $statement->execute();
        $IzvedbaPredmeta = $statement->fetchAll();

        if ($IzvedbaPredmeta != null) {
            return $IzvedbaPredmeta;
        } else {
            throw new InvalidArgumentException("No record with User id $idUser");
        }
    }
}