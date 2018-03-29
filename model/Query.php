<?php

require_once "DBInit.php";

class Query{

    // User story 2
    public static function getStudentData($vpisna_stevilka){

        $db = DBInit::getInstance();

        // TODO ulica, hisna_stevilka, naslov_za_posiljanje, telefon, email
        $statement = $db -> prepare(
            "SELECT s.vpisna_stevilka, s.ime, s.priimek, p.kraj
                        FROM student AS s, posta AS p
                        WHERE s.vpisna_stevilka = :vpisna_stevilka
                        AND s.id_posta = p.id_posta"
        );

        $statement->bindParam(":vpisna_stevilka", $vpisna_stevilka);
        $statement->execute();

        return $statement->fetchAll();
    }

    // User story 2
    public static function getEnrollmentDetails($vpisna_stevilka){

        $db = DBInit::getInstance();

        $statement = $db->prepare(
            "SELECT s.stud_leto, l.letnik, p.sifra_program, p.naziv_program, vr.opis_vpisa, n.opis_nacin
                        FROM  student AS st, 
                              vpis AS v, 
                              studijsko_leto AS s, 
                              id_program AS p, 
                              vrsta_vpisa AS vr, 
                              nacin_studija AS n,
                              letnik AS l
                        WHERE st.vpisna_stevilka = :vpisna_stevilka 
                        AND st.id_vpisa = v.id_vpisa
                        AND v.id_stud_leto = s.id_stud_leto
                        AND v.id_program = p.id_program
                        AND v.id_vrstavpisa = vr.id_vrstavpisa
                        AND v.id_nacin = n.id_nacin"
        );

        $statement->bindValue(":vpisna_stevilka", $vpisna_stevilka);
        $statement->execute();
    }
}