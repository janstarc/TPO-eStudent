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
            SELECT p.NAZIV_PROGRAM, s.VPISNA_STEVILKA, p.ID_PROGRAM
            FROM student AS s, program AS p 
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

}