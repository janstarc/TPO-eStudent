<?php

require_once "DBInit.php";

class PredmetModel {
    public static function getAll($data) {

        $db = DBInit::getInstance();
        $statement = $db->prepare("
            SELECT PREDMET.ID_PREDMET, IME_PREDMET, ST_KREDITNIH_TOCK
            FROM PREDMET
            JOIN PREDMETNIK ON PREDMET.ID_PREDMET = PREDMETNIK.ID_PREDMET
            WHERE ID_LETNIK = :ID_LETNIK AND ID_STUD_LETO = :ID_STUD_LETO AND ID_PROGRAM = :ID_PROGRAM AND PREDMET.AKTIVNOST = 1
        ");
        $statement->bindValue(":ID_STUD_LETO", $data["ID_STUD_LETO"]);
        $statement->bindValue(":ID_PROGRAM", $data["ID_PROGRAM"]);
        $statement->bindValue(":ID_LETNIK", $data["ID_LETNIK"]);
        $statement->execute();
        return $statement->fetchAll();
    }

    public static function getPredmetIme($id_predmet){
        $db = DBInit::getInstance();
        $statement = $db->prepare("
            SELECT IME_PREDMET
            FROM predmet
            WHERE ID_PREDMET = :id_predmet
        ");
        $statement->bindValue(":id_predmet", $id_predmet);
        $statement->execute();
        $result = $statement->fetch();
        return $result["IME_PREDMET"];
    }

    public static function getPredmetSifra($id_predmet){
        $db = DBInit::getInstance();
        $statement = $db->prepare("
            SELECT SIFRA_PREDMET
            FROM predmet
            WHERE ID_PREDMET = :id_predmet
        ");
        $statement->bindValue(":id_predmet", $id_predmet);
        $statement->execute();
        $result = $statement->fetch();
        return $result["SIFRA_PREDMET"];
    }


    public static function getPredmetIzvajalci($id_predmet, $id_stud_leto){
        $db = DBInit::getInstance();
        $statement = $db->prepare("
            SELECT DISTINCT p.ID_PREDMET, p.IME_PREDMET, ip.ID_OSEBA1, ip.ID_OSEBA2, ip.ID_OSEBA3, o1.IME AS IME1, o1.PRIIMEK AS PRIIMEK1, o2.IME AS IME2, o2.PRIIMEK AS PRIIMEK2, o3.IME AS IME3, o3.PRIIMEK AS PRIIMEK3
            FROM predmet AS p
              JOIN izvedba_predmeta AS ip on p.ID_PREDMET = ip.ID_PREDMET
              LEFT JOIN oseba o1 on ip.ID_OSEBA1 = o1.ID_OSEBA
              LEFT JOIN oseba o2 on ip.ID_OSEBA2 = o2.ID_OSEBA
              LEFT JOIN oseba o3 on ip.ID_OSEBA3 = o3.ID_OSEBA
            WHERE p.ID_PREDMET = :id_predmet
            AND ip.ID_STUD_LETO = :id_stud_leto
        ");
        $statement->bindValue(":id_predmet", $id_predmet);
        $statement->bindValue(":id_stud_leto", $id_stud_leto);
        $statement->execute();
        $result = $statement->fetchAll();
        return $result;
    }
}
