<?php

require_once "DBInit.php";

class RokModel {

    public static function getRokIzprasevalci($id_rok){
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT DISTINCT r.ID_OSEBA_IZPRASEVALEC1, ID_OSEBA_IZPRASEVALEC2, ID_OSEBA_IZPRASEVALEC3, o1.IME AS IME1, o1.PRIIMEK AS PRIIMEK1, o2.IME AS IME2, o2.PRIIMEK AS PRIIMEK2, o3.IME AS IME3, o3.PRIIMEK AS PRIIMEK3
            FROM rok AS r
              LEFT JOIN oseba o1 on r.ID_OSEBA_IZPRASEVALEC1 = o1.ID_OSEBA
              LEFT JOIN oseba o2 on r.ID_OSEBA_IZPRASEVALEC2 = o2.ID_OSEBA
              LEFT JOIN oseba o3 on r.ID_OSEBA_IZPRASEVALEC3 = o3.ID_OSEBA
            WHERE r.ID_ROK = :id_rok
        ");

        $statement->bindParam(":id_rok", $id_rok);
        $statement->execute();
        return $statement->fetchAll();

    }

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
            SELECT * FROM izvedba_predmeta where ID_IZVEDBA = :id
        ");$statement->bindParam(":id", $idIzvedbaPredmeta);
        $statement->execute();
        $result = $statement->fetch();

        $db = DBInit::getInstance();

        $statement = $db->prepare("
            INSERT INTO ROK (ID_IZVEDBA, DATUM_ROKA, CAS_ROKA, AKTIVNOST,ID_OSEBA_IZPRASEVALEC1, ID_OSEBA_IZPRASEVALEC2, ID_OSEBA_IZPRASEVALEC3)
            VALUES (:idIzvedbaPredmeta, :date, :time, 1, :r1, :r2, :r3)
        ");
        
        $statement->bindParam(":idIzvedbaPredmeta", $idIzvedbaPredmeta, PDO::PARAM_INT);
        $statement->bindParam(":date", $date);
        $statement->bindParam(":time", $time);
        $statement->bindParam(":r1", $result['ID_OSEBA1']);
        $statement->bindParam(":r2", $result['ID_OSEBA2']);
        $statement->bindParam(":r3", $result['ID_OSEBA3']);
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
        $rezult =  $statement->fetchAll();
        $all = array();
        foreach ($rezult as $row):

            $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT COUNT(*) as STP from prijava WHERE ID_ROK = :rok
        ");
        $statement->bindParam(":rok", $row['ID_ROK'] ) ;
        $statement->execute();
        $row['StevlioPrijavljenih'] = $statement->fetchColumn();
        array_push($all, $row);
        endforeach;
        return $all;
    }
    
    public static function get($idRok) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT r.ID_ROK, ip.ID_IZVEDBA, ip.ID_STUD_LETO, p.ID_PREDMET, p.IME_PREDMET, r.DATUM_ROKA, r.CAS_ROKA,
  r.ID_OSEBA_IZPRASEVALEC1, r.ID_OSEBA_IZPRASEVALEC2, r.ID_OSEBA_IZPRASEVALEC3,
  o.ID_OSEBA as ID_IZPRASEVALEC1, o.IME as IME_IZPRASEVALEC1, o.PRIIMEK as PRIIMEK_IZPRASEVALEC1,
  o2.ID_OSEBA as ID_IZPRASEVALEC2, o2.IME as IME_IZPRASEVALEC2, o2.PRIIMEK as PRIIMEK_IZPRASEVALEC2,
  o3.ID_OSEBA as ID_IZPRASEVALEC3, o.IME as IME_IZPRASEVALEC3, o.PRIIMEK as PRIIMEK_IZPRASEVALEC3,
  o4.ID_OSEBA as ID_IZVAJALEC1, o4.IME as IME_IZVAJALEC1, o4.PRIIMEK as PRIIMEK_IZVAJALEC1,
  o5.ID_OSEBA as ID_IZVAJALEC2, o5.IME as IME_IZVAJALEC2, o5.PRIIMEK as PRIIMEK_IZVAJALEC2,
  o6.ID_OSEBA as ID_IZVAJALEC3, o6.IME as IME_IZVAJALEC3, o6.PRIIMEK as PRIIMEK_IZVAJALEC3
FROM IZVEDBA_PREDMETA as ip
  JOIN PREDMET as p ON ip.ID_PREDMET = p.ID_PREDMET
  JOIN ROK as r ON r.ID_IZVEDBA = ip.ID_IZVEDBA
  LEFT JOIN oseba o ON r.ID_OSEBA_IZPRASEVALEC1 = o.ID_OSEBA
  LEFT JOIN oseba o2 ON r.ID_OSEBA_IZPRASEVALEC2 = o2.ID_OSEBA
  LEFT JOIN oseba o3 ON r.ID_OSEBA_IZPRASEVALEC3 = o3.ID_OSEBA
  LEFT JOIN oseba o4 ON ip.ID_OSEBA1 = o4.ID_OSEBA
  LEFT JOIN oseba o5 ON ip.ID_OSEBA2 = o5.ID_OSEBA
  LEFT JOIN oseba o6 ON ip.ID_OSEBA3 = o6.ID_OSEBA
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
    
    public static function update($ID_ROK, $DATUM_ROKA, $CAS_ROKA, $prof1, $prof2, $prof3) {
        $db = DBInit::getInstance();
        if($prof1 == "0") $prof1 = NULL;
        if($prof2 == "0") $prof2 = NULL;
        if($prof3 == "0") $prof3 = NULL;


        $statement = $db->prepare("
            UPDATE ROK
            SET DATUM_ROKA = :DATUM_ROKA, CAS_ROKA = :CAS_ROKA,
            ID_OSEBA_IZPRASEVALEC1= :prof1,ID_OSEBA_IZPRASEVALEC2 = :prof2 ,ID_OSEBA_IZPRASEVALEC3 = :prof3
            WHERE ID_ROK = :ID_ROK
        ");
        $statement->bindParam(":DATUM_ROKA", $DATUM_ROKA);
        $statement->bindParam(":CAS_ROKA", $CAS_ROKA);
        $statement->bindParam(":prof1", $prof1);
        $statement->bindParam(":prof2", $prof2);
        $statement->bindParam(":prof3", $prof3);
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

    public static function getAllByEnrolledStudentOld($idUser, $idCurrentYear) {
        $db = DBInit::getInstance();

        // TODO ocena == null OR ocena == 5
        $statement = $db->prepare("
        SELECT  r.ID_ROK, ip.ID_IZVEDBA, p.ID_PREDMET, p.IME_PREDMET, r.DATUM_ROKA, r.CAS_ROKA, r.AKTIVNOST,pr.ID_PRIJAVA,pr.ZAP_ST_POLAGANJ, pr.ZAP_ST_POLAGANJ_LETOS, pr.OCENA_IZPITA,pr.DATUM_ODJAVE
            FROM `rok` AS r
            JOIN `izvedba_predmeta` AS ip ON r.ID_IZVEDBA = ip.ID_IZVEDBA AND ip.ID_STUD_LETO=:idCurrentYear
            JOIN `predmet` AS p ON ip.ID_PREDMET = p.ID_PREDMET
            JOIN `predmetnik` AS pred ON p.ID_PREDMET= pred.ID_PREDMET AND pred.ID_STUD_LETO=:idCurrentYear
            JOIN `student` AS s ON s.ID_PROGRAM=pred.ID_PROGRAM AND s.ID_OSEBA = :idUser
            JOIN `vpis` AS v ON s.ID_VPIS=v.ID_VPIS AND pred.ID_LETNIK=v.ID_LETNIK
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

    public static function getAllByEnrolledStudent($idUser, $idCurrentYear) {
        $db = DBInit::getInstance();

        // TODO ocena == null OR ocena == 5
        $statement = $db->prepare("
       SELECT  r.ID_ROK, ip.ID_IZVEDBA, p.ID_PREDMET, p.IME_PREDMET, r.DATUM_ROKA, r.CAS_ROKA, r.AKTIVNOST,pr.ID_PRIJAVA,pr.ZAP_ST_POLAGANJ, pr.ZAP_ST_POLAGANJ_LETOS, pr.OCENA_IZPITA,pr.DATUM_ODJAVE, s.VSOTA_OPRAVLJENIH_KREDITNIH_TOCK
        FROM predmeti_studenta as ps
        JOIN predmet as p ON ps.ID_PREDMET=p.ID_PREDMET
        JOIN izvedba_predmeta AS ip ON p.ID_PREDMET = ip.ID_PREDMET
        JOIN rok as r ON ip.ID_IZVEDBA = r.ID_IZVEDBA
        JOIN student as s ON s.VPISNA_STEVILKA=ps.VPISNA_STEVILKA
        LEFT JOIN prijava pr ON r.ID_ROK = pr.ID_ROK AND s.VPISNA_STEVILKA=pr.VPISNA_STEVILKA AND pr.DATUM_ODJAVE IS NULL
        WHERE s.ID_OSEBA=:idUser AND (ps.OCENA<=5 OR ps.OCENA IS NULL) and r.AKTIVNOST = '1'
        ORDER BY DATUM_ROKA, CAS_ROKA
    ");
        $statement->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }

    public static function odjaviStudente($id, $idOseba)
    {
        $date ="2018-05-31 10:00:00";
        $db = DBInit::getInstance();
        $statement = $db->prepare("
       SELECT * FROM rok WHERE ID_ROK = :rok
    ");

        $statement->bindParam(":rok", $id);
        $statement->execute();
        $akt = $statement->fetchAll()[0]['AKTIVNOST'];

        if ($akt == "0") {


            $db = DBInit::getInstance();

            // TODO ocena == null OR ocena == 5
            $statement = $db->prepare("
           SELECT * FROM prijava WHERE ID_ROK = :rok  AND ID_OSEBA_ODJAVITELJ is NULL 
        ");
            $statement->bindParam(":rok", $id);
            $statement->execute();
            $prijave = $statement->fetchAll();


            foreach ($prijave as $item):

                $db = DBInit::getInstance();
                $statement = $db->prepare("
                     DELETE from prijava where ID_PRIJAVA = :id
    
              ");
                $statement->bindParam(":id", $item['ID_PRIJAVA']);
                $statement->execute();

            endforeach;
        }
    }




}/*$statement = $db->prepare("
                     UPDATE `prijava` SET
                     ZAP_ST_POLAGANJ=:st1,
                     ZAP_ST_POLAGANJ_LETOS=:st2,
                     DATUM_ODJAVE=:datum,
                     ID_OSEBA_ODJAVITELJ=:idOseba
                     WHERE ID_PRIJAVA = :id

              ");
                $statement->bindParam(":st1", $item['ZAP_ST_POLAGANJ']);
                $statement->bindParam(":st2", $item['ZAP_ST_POLAGANJ_LETOS']);
                $statement->bindParam(":datum", $date);
                $statement->bindParam(":id", $item['ID_PRIJAVA']);
                $statement->bindParam(":idOseba",$idOseba );
                $statement->execute();*/