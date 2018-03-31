<?php

require_once "DBInit.php";

class AdminDB {

    // User story 2
    public static function getStudentData($vpisna_stevilka){

        $db = DBInit::getInstance();

        // TODO ulica, hisna_stevilka, naslov_za_posiljanje, telefon, email
        $statement = $db -> prepare(
            "SELECT s.vpisna_stevilka, s.ime, s.priimek, n.ulica, n.hisna_stevilka, n.stalni, p.st_posta, p.kraj, n.zavrocanje, o.email, o.telefonska_steviklka 
                        FROM student AS s, 
                              posta AS p,
                              naslov AS n,
                              oseba AS o
                        WHERE s.vpisna_stevilka = :vpisna_stevilka
                        AND s.id_oseba = n.id_oseba
                        AND n.id_posta = p.id_posta
                        AND s.id_oseba = o.id_oseba"
        );

        $statement->bindParam(":vpisna_stevilka", $vpisna_stevilka);
        $statement->execute();

        return $statement->fetchAll();
    }

    // User story 2
    public static function getEnrollmentDetails($vpisna_stevilka){

        $db = DBInit::getInstance();

        $statement = $db->prepare(
            "SELECT DISTINCT s.stud_leto, l.letnik, p.sifra_program, p.naziv_program, vr.opis_vpisa, n.opis_nacin
                        FROM  student AS st, 
                              vpis AS v, 
                              studijsko_leto AS s, 
                              program AS p, 
                              vrsta_vpisa AS vr, 
                              nacin_studija AS n,
                              letnik AS l
                        WHERE st.vpisna_stevilka = :vpisna_stevilka 
                        AND st.id_vpisa = v.id_vpisa
                        AND v.id_stud_leto = s.id_stud_leto
                        AND v.id_program = p.id_program
                        AND v.id_vrstavpisa = vr.id_vrstavpisa
                        AND v.id_nacin = n.id_nacin
                        ORDER BY s.stud_leto DESC"
        );

        $statement->bindValue(":vpisna_stevilka", $vpisna_stevilka);
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function getAllNames(){

        $db = DBInit::getInstance();

        $statement = $db -> prepare(
            "SELECT ime, priimek, vpisna_stevilka FROM student"
        );

        $statement->execute();

        return $statement->fetchAll();
    }
}