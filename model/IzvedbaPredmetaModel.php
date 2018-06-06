<?php

require_once "DBInit.php";

class IzvedbaPredmetaModel {
    public static function getIdIzvedbaPredmetaByProfesor($idUser, $idCurrentYear) {
        $db = DBInit::getInstance();
        
        $statement = $db->prepare("
            SELECT ip.ID_IZVEDBA, p.ID_PREDMET, p.IME_PREDMET, p.SIFRA_PREDMET, ID_OSEBA1, ID_OSEBA2, ID_OSEBA3
            FROM IZVEDBA_PREDMETA as ip
            JOIN PREDMET as p ON ip.ID_PREDMET = p.ID_PREDMET
            WHERE ID_STUD_LETO = :idCurrentYear
                AND (
                    ID_OSEBA1 = :idUser OR ID_OSEBA2 = :idUser OR ID_OSEBA3 = :idUser
                )
                AND p.AKTIVNOST = 1
            ORDER BY p.IME_PREDMET
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

    public static function getFirst($id_predmet,$id_leto){
        $db = DBInit::getInstance();

        $statement = $db->prepare("
                SELECT o.IME, o.PRIIMEK,o.UPORABNISKO_IME,o.EMAIL, o.TELEFONSKA_STEVILKA,o.ID_OSEBA
                FROM izvedba_predmeta as ip
                JOIN oseba as o ON o.ID_OSEBA=ip.ID_OSEBA1
                WHERE ip.ID_PREDMET=:id_predmet AND ip.ID_STUD_LETO=:id_leto
              
        ");

        $statement->bindParam(":id_predmet", $id_predmet);
        $statement->bindParam(":id_leto", $id_leto);
        $statement->execute();
        $results = $statement->fetchAll();

        return $results;

    }

    public static function getSecond($id_predmet,$id_leto){
        $db = DBInit::getInstance();

        $statement = $db->prepare("
                SELECT o.IME, o.PRIIMEK,o.UPORABNISKO_IME,o.EMAIL, o.TELEFONSKA_STEVILKA,o.ID_OSEBA
                FROM izvedba_predmeta as ip
                JOIN oseba as o ON o.ID_OSEBA=ip.ID_OSEBA2
                WHERE ip.ID_PREDMET=:id_predmet AND ip.ID_STUD_LETO=:id_leto
              
        ");

        $statement->bindParam(":id_predmet", $id_predmet);
        $statement->bindParam(":id_leto", $id_leto);
        $statement->execute();
        $results = $statement->fetchAll();

        return $results;

    }

    public static function getThird($id_predmet,$id_leto){
        $db = DBInit::getInstance();

        $statement = $db->prepare("
                SELECT o.IME, o.PRIIMEK,o.UPORABNISKO_IME,o.EMAIL, o.TELEFONSKA_STEVILKA,o.ID_OSEBA
                FROM izvedba_predmeta as ip
                JOIN oseba as o ON o.ID_OSEBA=ip.ID_OSEBA3
                WHERE ip.ID_PREDMET=:id_predmet AND ip.ID_STUD_LETO=:id_leto
              
        ");

        $statement->bindParam(":id_predmet", $id_predmet);
        $statement->bindParam(":id_leto", $id_leto);
        $statement->execute();
        $results = $statement->fetchAll();

        return $results;
    }

    public static function getAllProfesori(){
        $db = DBInit::getInstance();

        $statement = $db->prepare("
                SELECT o.IME, o.PRIIMEK,o.ID_OSEBA, o.SIFRA_IZVAJALCA
                FROM oseba as o
                WHERE o.VRSTA_VLOGE='p'
                ORDER BY o.PRIIMEK ASC
              
        ");

        $statement->bindParam(":id_predmet", $id_predmet);
        $statement->bindParam(":id_leto", $id_leto);
        $statement->execute();
        $results = $statement->fetchAll();

        return $results;

    }
}