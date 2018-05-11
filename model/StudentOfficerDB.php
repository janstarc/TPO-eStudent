<?php
class StudentOfficerDB
{
    public static function SearchEMSO($emso){
        $db = DBInit::getInstance();

        $statement = $db->prepare("
                SELECT DISTINCT *, z.aktivnost AS ACT
                FROM  OSEBA as o,LETNIK as l, STUDIJSKO_LETO as s, STUDENT as st, ZETON as z, NACIN_STUDIJA as n, 
                OBLIKA_STUDIJA as obl, PROGRAM as prog, VRSTA_VPISA as vrs
                WHERE st.VPISNA_STEVILKA = :emso and st.ID_OSEBA = o.ID_OSEBA and 
                z.ID_LETNIK = l.ID_LETNIK and z.ID_STUD_LETO = s.ID_STUD_LETO and z.ID_OSEBA = o.ID_OSEBA and 
                z.ID_NACIN = n.ID_NACIN and z.ID_VRSTAVPISA = vrs.ID_VRSTAVPISA and z.ID_PROGRAM = prog.ID_PROGRAM
                and z.ID_OBLIKA = obl.ID_OBLIKA
                ORDER BY l.LETNIK desc
        ");

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

    public static function getAll(){
        $all = [];
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "SELECT * FROM STUDIJSKO_LETO"
        );
        $statement->execute();
        array_push($all, $statement->fetchAll());
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "SELECT * FROM LETNIK"
        );
        $statement->execute();
        array_push($all, $statement->fetchAll());
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "SELECT * FROM PROGRAM"
        );
        $statement->execute();
        array_push($all, $statement->fetchAll());
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "SELECT * FROM VRSTA_VPISA"
        );
        $statement->execute();
        array_push($all, $statement->fetchAll());
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "SELECT * FROM NACIN_STUDIJA"
        );
        $statement->execute();
        array_push($all, $statement->fetchAll());
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "SELECT * FROM OBLIKA_STUDIJA"
        );
        $statement->execute();
        array_push($all, $statement->fetchAll());


        return $all;
    }
    public static function ZetonData($id){
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT * FROM ZETON 
            where ID_ZETON = :id
        ");

        $statement->bindParam(":id", $id);
        $statement->execute();
        return $statement->fetch();
    }
    public static function spremeniZeton($data){
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            UPDATE `tpo`.`zeton`
            SET
                `ID_LETNIK` = :letnik,
                `ID_STUD_LETO` = :leto,
                `ID_OBLIKA` = :oblika,
                `ID_VRSTAVPISA` = :vrsta,
                `ID_NACIN` =:nacin,
                `ID_PROGRAM` = :program
            WHERE `ID_ZETON` = :idZeton;
        ");

        $statement->bindParam(":letnik", $data['letnik']);
        $statement->bindParam(":leto", $data['leto']);
        $statement->bindParam(":oblika", $data['OblikaStudija']);
        $statement->bindParam(":nacin", $data['NacinStudija']);
        $statement->bindParam(":program", $data['program']);
        $statement->bindParam(":vrsta", $data['Vrstavpisa']);
        $statement->bindParam(":idZeton", $data['id_zeton']);

        $statement->execute();

        return true;

    }

    public static function isUnique($ID_LETNIK) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT * 
            FROM zeton 
            WHERE ID_LETNIK = :ID_LETNIK
        ");
        $statement->bindValue(":ID_LETNIK", $ID_LETNIK + 1);
        $statement->execute();
        $result = $statement->fetch();

        if ($result == null) {
            return true;
        } else {
            return false;
        }
    }
    public static function dodajNov($data){
        $db = DBInit::getInstance();
        $letnik =$data['ID_LETNIK']+1;
        $leto = $data['ID_STUD_LETO']+1;

        $statement = $db->prepare("
            INSERT INTO `tpo`.`zeton`
            (`ID_OSEBA`,
            `ID_LETNIK`,
            `ID_STUD_LETO`,
            `ID_OBLIKA`,
            `ID_VRSTAVPISA`,
            `ID_NACIN`,
            `ID_PROGRAM`)
            VALUES
            (:oseba,
            :letnik,
            :leto,
            :oblika,
            :vrstaVpisa,
            :nacin,
            :program); ");

        $statement->bindParam(":oseba", $data['ID_OSEBA']);
        $statement->bindParam(":letnik", $letnik);
        $statement->bindParam(":leto", $leto);
        $statement->bindParam(":oblika", $data['ID_OBLIKA']);
        $statement->bindParam(":vrstaVpisa", $data['ID_VRSTAVPISA']);
        $statement->bindParam(":nacin", $data['ID_NACIN']);
        $statement->bindParam(":program", $data['ID_PROGRAM']);
        $statement->execute();
        return true;

    }



    public static function izracunPovprecje($vpisna){
        $db = DBInit::getInstance();

        $statement = $db->prepare("
                SELECT DISTINCT *
                FROM  OSEBA as o, STUDENT as s,VPIS as v, PREDMETI_STUDENTA as ps , PRIJAVA as p, IZPIT as i
                WHERE s.VPISNA_STEVILKA = :vpisna and s.ID_OSEBA = o.ID_OSEBA and 
                s.VPISNA_STEVILKA=v.VPISNA_STEVILKA and v.ID_VPIS=ps.ID_VPIS and ps.ID_PREDMETISTUDENTA=p.ID_PREDMETISTUDENTA 
                and p.ID_PRIJAVA=i.ID_PRIJAVA
                 ");

        $statement->bindParam(":vpisna", $vpisna);
        $statement->execute();

        $results = $statement->fetchAll();
        if ($results != null) {
            return $results;
        } else {
            throw new InvalidArgumentException("No subject with $vpisna");
        }
    }

    public static function getLeta(){
        $db = DBInit::getInstance();

        $statement = $db->prepare("
                SELECT DISTINCT *
                FROM  studijsko_leto");

        $statement->execute();

        return $statement->fetchAll();

    }

    public static function getPredmeti($leto){

            $db = DBInit::getInstance();

            $statement = $db->prepare("
                    SELECT DISTINCT *
                    FROM  izvedba_predmeta i, predmet p 
                    WHERE ID_STUD_LETO = :leto and p.ID_PREDMET = i.ID_PREDMET");
            $statement->bindParam(":leto", $leto);
            $statement->execute();

            return $statement->fetchAll();

    }

    public static function getPredmet($id){

        $db = DBInit::getInstance();

        $statement = $db->prepare("
                    SELECT DISTINCT *
                    FROM  predmet 
                    WHERE ID_PREDMET = :id");
        $statement->bindParam(":id", $id);
        $statement->execute();

        return $statement->fetchAll()[0];

    }

    public static function getVpisani($predmet, $leto ){
        $db = DBInit::getInstance();
        $statement = $db->prepare("
                    SELECT DISTINCT *
                    FROM  predmeti_studenta p, student s , oseba o, vrsta_vpisa vv, vpis v 
                    WHERE ID_PREDMET = :predmet and p.ID_STUD_LETO = :leto and
                    p.VPISNA_STEVILKA = s.VPISNA_STEVILKA and s.ID_OSEBA = o.ID_OSEBA AND 
                    v.VPISNA_STEVILKA = s.VPISNA_STEVILKA and vv.ID_VRSTAVPISA = v.ID_VRSTAVPISA
                    ORDER BY PRIIMEK ASC
                    ");
        $statement->bindParam(":predmet", $predmet);
        $statement->bindParam(":leto", $leto);
        $statement->execute();

        return $statement->fetchAll();

    }
    public static function getLeto($id){

        $db = DBInit::getInstance();

        $statement = $db->prepare("
                    SELECT STUD_LETO
                    FROM  studijsko_leto 
                    WHERE ID_STUD_LETO = :id");
        $statement->bindParam(":id", $id);
        $statement->execute();

        return $statement->fetchColumn();

    }
}
