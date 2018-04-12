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
                    ID_OSEBA1 = :idUser OR ID_OSEBA2 = :idUser OR ID_OSEBA3 = :idUser
                )
                AND p.AKTIVNOST = 1
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

    public static function findSubject($ime_predmeta){
        $db = DBInit::getInstance();

        $statement = $db->prepare("
                SELECT DISTINCT p.IME_PREDMET,p.ID_PREDMET, o.ID_OSEBA ,o.IME, o.PRIIMEK, o.EMAIL, o.TELEFONSKA_STEVILKA
                FROM IZVEDBA_PREDMETA as ip 
                JOIN (PREDMET as p, OSEBA as o)
                ON ip.ID_PREDMET=p.ID_PREDMET 
                    AND (ip.ID_OSEBA1=o.ID_OSEBA OR ip.ID_OSEBA2=o.ID_OSEBA OR ip.ID_OSEBA3=o.ID_OSEBA)
                    
                WHERE p.IME_PREDMET LIKE :ime_predmeta
        ");
        $ime_predmeta_like="%" . $ime_predmeta . "%";
        $statement->bindParam(":ime_predmeta", $ime_predmeta_like, PDO::PARAM_STR);
        $statement->execute();
        $results = $statement->fetchAll();

        if ($results != null) {
            return $results;
        } else {
            throw new InvalidArgumentException("No subject with $ime_predmeta");
        }
    }
}