<?php

require_once "DBInit.php";

class RokModel {
    public static function isUnique(array $params) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT * 
            FROM ROK 
            WHERE ID_IZVEDBA = :ID_IZVEDBA AND DATUM_ROKA = :DATUM_ROKA
        ");
        $statement->bindParam(":ID_IZVEDBA", $params["ID_IZVEDBA"]);
        $statement->bindParam(":DATUM_ROKA", $params["DATUM_ROKA"]);
        $statement->execute();
        $result = $statement->fetch();

        return ($result == null);
    }
    
    public static function isUniqueIfAlreadyCreated(array $params) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT * 
            FROM ROK 
            WHERE ID_IZVEDBA = :ID_IZVEDBA AND DATUM_ROKA = :DATUM_ROKA AND ID_ROK != :ID_ROK
        ");
        $statement->bindParam(":ID_IZVEDBA", $params["ID_IZVEDBA"]);
        $statement->bindParam(":DATUM_ROKA", $params["DATUM_ROKA"]);
        $statement->bindParam(":ID_ROK", $params["ID_ROK"]);
        $statement->execute();
        $result = $statement->fetch();

        return ($result == null);
    }
    
    public static function insert($idIzvedbaPredmeta, $date, $time) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            INSERT INTO ROK (ID_IZVEDBA, DATUM_ROKA, CAS_ROKA, AKTIVNOST)
            VALUES (:idIzvedbaPredmeta, :date, :time, 1)
        ");
        
        $statement->bindParam(":idIzvedbaPredmeta", $idIzvedbaPredmeta, PDO::PARAM_INT);
        $statement->bindParam(":date", $date);
        $statement->bindParam(":time", $time);
        $statement->execute();
    }
    
    public static function getAll($idUser, $idCurrentYear) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT r.ID_ROK, ip.ID_IZVEDBA, p.ID_PREDMET, p.IME_PREDMET, r.DATUM_ROKA, r.CAS_ROKA, r.AKTIVNOST
            FROM IZVEDBA_PREDMETA as ip
            JOIN PREDMET as p ON ip.ID_PREDMET = p.ID_PREDMET
            JOIN ROK as r ON r.ID_IZVEDBA = ip.ID_IZVEDBA
            WHERE ID_STUD_LETO = :idCurrentYear
                AND (
                    ID_OSEBA1 = :idUser OR ID_OSEBA2 = :idUser OR ID_OSEBA3 = :idUser
                )
                AND p.AKTIVNOST = 1
            ORDER BY DATUM_ROKA, CAS_ROKA
        ");
        $statement->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $statement->bindParam(":idCurrentYear", $idCurrentYear, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }
    
    public static function get($idRok) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT r.ID_ROK, ip.ID_IZVEDBA, ip.ID_STUD_LETO, p.ID_PREDMET, p.IME_PREDMET, r.DATUM_ROKA, r.CAS_ROKA
            FROM IZVEDBA_PREDMETA as ip
            JOIN PREDMET as p ON ip.ID_PREDMET = p.ID_PREDMET
            JOIN ROK as r ON r.ID_IZVEDBA = ip.ID_IZVEDBA
            WHERE r.ID_ROK = :idRok
                AND p.AKTIVNOST = 1
        ");
        $statement->bindParam(":idRok", $idRok, PDO::PARAM_INT);
        $statement->execute();
        $IzvedbaPredmeta = $statement->fetch();

        if ($IzvedbaPredmeta != null) {
            return $IzvedbaPredmeta;
        } else {
            throw new InvalidArgumentException("No record with User id $idRok");
        }
    }
    
    public static function update($ID_ROK, $ID_IZVEDBA, $DATUM_ROKA, $CAS_ROKA) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            UPDATE ROK
            SET ID_IZVEDBA = :ID_IZVEDBA, DATUM_ROKA = :DATUM_ROKA, CAS_ROKA = :CAS_ROKA
            WHERE ID_ROK = :ID_ROK
        ");
        $statement->bindParam(":ID_IZVEDBA", $ID_IZVEDBA);
        $statement->bindParam(":DATUM_ROKA", $DATUM_ROKA);
        $statement->bindParam(":CAS_ROKA", $CAS_ROKA);
        $statement->bindParam(":ID_ROK", $ID_ROK, PDO::PARAM_INT);
        $statement->execute();
    }
    
    public static function toogleActivated ($id){
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT AKTIVNOST FROM ROK WHERE ID_ROK = :id");
        $statement->bindValue(":id", $id);
        $statement->execute();
        $is_activated_str = ($statement->fetch())["AKTIVNOST"];

        if ($is_activated_str === '1')
            $is_activated = '0';
        else
            $is_activated = '1';

        $statement2 = $db->prepare("
            UPDATE ROK
            SET AKTIVNOST = :is_activated
            WHERE ID_ROK = :id
        ");
        $statement2->bindValue(":id", $id);
        $statement2->bindParam(":is_activated", $is_activated);
        $statement2->execute();
    }
    
    public static function isActivated($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT AKTIVNOST 
            FROM ROK 
            WHERE ID_ROK = :ID_ROK
        ");
        $statement->bindParam(":ID_ROK", $id);
        $statement->execute();
        $result = $statement->fetch();

        return ($result["AKTIVNOST"] == 1);
    }

    public static function getAllByEnrolledStudent($idUser, $idCurrentYear) {
        $db = DBInit::getInstance();

        // TODO ocena == null OR ocena == 5
        $statement = $db->prepare("
        SELECT  r.ID_ROK, ip.ID_IZVEDBA, p.ID_PREDMET, p.IME_PREDMET, r.DATUM_ROKA, r.CAS_ROKA, r.AKTIVNOST,pr.ID_PRIJAVA,pr.ZAP_ST_POLAGANJ, pr.ZAP_ST_POLAGANJ_LETOS, ps.OCENA
            FROM `rok` AS r
            JOIN `izvedba_predmeta` AS ip ON r.ID_IZVEDBA = ip.ID_IZVEDBA AND ip.ID_STUD_LETO=:idCurrentYear
            JOIN `predmet` AS p ON ip.ID_PREDMET = p.ID_PREDMET
            JOIN `predmetnik` AS pred ON p.ID_PREDMET= pred.ID_PREDMET AND pred.ID_STUD_LETO=:idCurrentYear
            JOIN `student` AS s ON s.ID_PROGRAM=pred.ID_PROGRAM AND s.ID_OSEBA = :idUser
            LEFT JOIN `prijava` AS pr ON r.ID_ROK=pr.ID_ROK AND pr.VPISNA_STEVILKA=s.VPISNA_STEVILKA 
            LEFT JOIN `predmeti_studenta` AS ps ON p.ID_PREDMET=ps.ID_PREDMET AND s.VPISNA_STEVILKA=ps.VPISNA_STEVILKA AND ps.ID_STUD_LETO=:idCurrentYear 
            WHERE  r.AKTIVNOST = 1 
            ORDER BY DATUM_ROKA, CAS_ROKA
    ");
        $statement->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $statement->bindParam(":idCurrentYear", $idCurrentYear, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }
}