<?php

class DataForExportModel
{
    public static function getEmso($id_kandidat){
        $db = DBInit::getInstance();

        $statement = $db -> prepare("
            SELECT s.EMSO
            FROM student AS s 
            WHERE s.id_kandidat = :id_kandidat
        ");

        $statement->bindValue(":id_kandidat", $id_kandidat);
        $statement->execute();
        $result = $statement->fetch();
        return $result;
    }


    public static function getVpisPodatki($id_kandidat){
        $db = DBInit::getInstance();

        $statement = $db -> prepare("
            SELECT p.NAZIV_PROGRAM, s.VPISNA_STEVILKA, p.ID_PROGRAM,n.OPIS_NACIN,o.NAZIV_OBLIKA,l.LETNIK,v3.OPIS_VPISA
            FROM student AS s, program AS p 
            JOIN vpis v ON p.ID_PROGRAM = v.ID_PROGRAM
            JOIN nacin_studija n ON v.ID_NACIN = n.ID_NACIN
            JOIN oblika_studija o ON v.ID_OBLIKA = o.ID_OBLIKA
            JOIN letnik l ON v.ID_LETNIK = l.ID_LETNIK
            JOIN vrsta_vpisa v3 ON v.ID_VRSTAVPISA = v3.ID_VRSTAVPISA
            WHERE s.id_kandidat = :id_kandidat and s.ID_PROGRAM=p.ID_PROGRAM
        ");

        $statement->bindValue(":id_kandidat", $id_kandidat);
        $statement->execute();
        $result = $statement->fetch();
        return $result;
    }

    public static function getStudijskoLetoAndVpisna($id_kandidat){
        $db = DBInit::getInstance();

        $statement = $db -> prepare("
            SELECT s.STUD_LETO, st.VPISNA_STEVILKA,v.ID_LETNIK
            FROM studijsko_leto as s, VPIS as v, student as st
            WHERE st.id_kandidat = :id_kandidat and st.ID_VPIS=v.ID_VPIS and v.ID_STUD_LETO=s.ID_STUD_LETO
        ");

        $statement->bindValue(":id_kandidat", $id_kandidat);
        $statement->execute();
        $result = $statement->fetch();
        return $result;
    }

    //TODO: Zamenjaj podatki z argumentov v funkcijo
    public static function getPredmete($stud_leto,$id_program,$id_letnik ) {

        $db = DBInit::getInstance();
        $statement = $db->prepare("
            SELECT DISTINCT IME_PREDMET,ST_KREDITNIH_TOCK,p.ID_PREDMET 
            FROM PREDMET as p
            JOIN PREDMETNIK as pr
            ON p.ID_PREDMET=pr.ID_PREDMET 
            WHERE ID_LETNIK=:id_letnik AND ID_PROGRAM=:id_program 
        ");
       // $statement->bindValue(":stud_leto", $stud_leto);
        $statement->bindValue(":id_program", $id_program);
        $statement->bindValue(":id_letnik", $id_letnik);
        $statement->execute();
        return $statement->fetchAll();
    }

    public static function getIzvajalec($id_predmet,$stud_leto) {
       // var_dump($id_predmet);
       // var_dump($stud_leto);
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT DISTINCT o.IME, o.PRIIMEK
            FROM IZVEDBA_PREDMETA as ip
            JOIN PREDMET as p ON ip.ID_PREDMET = p.ID_PREDMET
            JOIN STUDIJSKO_LETO as st ON ip.ID_STUD_LETO=st.ID_STUD_LETO
            JOIN OSEBA as o ON (ip.ID_OSEBA1 = o.ID_OSEBA OR ip.ID_OSEBA2 = o.ID_OSEBA OR ip.ID_OSEBA3 = ID_OSEBA)
            WHERE ip.ID_PREDMET=:id_predmet 
        ");
        $statement->bindParam(":id_predmet", $id_predmet);
        //$statement->bindParam(":stud_leto", $stud_leto);
        $statement->execute();
        $IzvedbaPredmeta = $statement->fetch();

     //   var_dump($IzvedbaPredmeta);

        if ($IzvedbaPredmeta != null) {
            return $IzvedbaPredmeta;
        } else {
            throw new InvalidArgumentException("No record with User id $id_predmet");
        }
    }


}