<?php
class StudentOfficerDB
{
    public static function SearchEMSO($emso){
        $db = DBInit::getInstance();

        $statement = $db->prepare("
                SELECT DISTINCT *, z.aktivnost as ACT
                FROM  OSEBA as o,LETNIK as l, STUDIJSKO_LETO as s, VPIS as v, STUDENT as st, ZETON as z, NACIN_STUDIJA as n, 
                OBLIKA_STUDIJA as obl, PROGRAM as prog, VRSTA_VPISA as vrs
                WHERE st.EMSO = :emso and st.ID_OSEBA = o.ID_OSEBA and st.VPISNA_STEVILKA = v.VPISNA_STEVILKA AND 
                z.ID_LETNIK = l.ID_LETNIK and z.ID_STUD_LETO = s.ID_STUD_LETO and z.ID_OSEBA = o.ID_OSEBA and 
                z.ID_NACIN = n.ID_NACIN and z.ID_VRSTAVPISA = vrs.ID_VRSTAVPISA and z.ID_PROGRAM = prog.ID_PROGRAM
                and z.ID_OBLIKA = obl.ID_OBLIKA
                ORDER BY z.ID_STUD_LETO desc       ");

        $statement->bindParam(":emso", $emso);
        $statement->execute();
        $results = $statement->fetchAll();
        if ($results != null) {
            return $results;
        } else {
            throw new InvalidArgumentException("No subject with $emso");
        }
    }
    public static function ChangeAktivnost($idZeton,$aktivnost){

    $db = DBInit::getInstance();

    if($aktivnost == "0") {
        $set = 1;
    }
    else{$set = 0;}

        $statement = $db->prepare("UPDATE ZETON SET
        AKTIVNOST = :aktivnost
        where  ID_ZETON = :idZeton
        ");
        $statement->bindParam(":aktivnost", $set);
        $statement->bindParam(":idZeton", $idZeton);
        $statement->execute();

    return true;
    }
}