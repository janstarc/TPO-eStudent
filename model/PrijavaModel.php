<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 17.5.2018
 * Time: 10:51
 */

class PrijavaModel
{

    public static function prijavaAdd($vpisna,$id_rok,$id_predmet){

            $db = DBInit::getInstance();
          /*  $statement = $db -> prepare(
                "UPDATE prijava as p 
            JOIN student as s ON s.VPISNA_STEVILKA=p.VPISNA_STEVILKA 
            JOIN ROK as r ON r.ID_ROK=p.ID_ROK 
            JOIN IZVEDBA_PREDMETA AS ip ON r.ID_IZVEDBA = ip.ID_IZVEDBA 
            JOIN PREDMET as pr ON pr.ID_PREDMET=ip.ID_PREDMET 
            SET p.ZAP_ST_POLAGANJ=p.ZAP_ST_POLAGANJ+1,p.ZAP_ST_POLAGANJ_LETOS=p.ZAP_ST_POLAGANJ_LETOS+1
             WHERE p.VPISNA_STEVILKA =:vpisna AND p.ID_ROK =:id_rok AND pr.ID_PREDMET=:id_predmet
        "
            );
            $statement->bindValue(":vpisna", $vpisna);
            $statement->bindValue(":id_rok", $id_rok);
            $statement->bindValue(":id_predmet", $id_predmet);

            try{
                $statement->execute();
                if($statement->rowCount()==0){*/

                $stejPrijavLetos=StudentController::zapSteviloPrijavLetosProf($id_rok,$vpisna);
                $stejPrijavSkupno=StudentController::zapSteviloPrijavSkupnoProf($id_rok,$vpisna);

                    $statement2 = $db -> prepare(
                        "INSERT INTO prijava 
                      (ID_ROK, VPISNA_STEVILKA, ZAP_ST_POLAGANJ,ZAP_ST_POLAGANJ_LETOS, PODATKI_O_PLACILU, DATUM_PRIJAVE)
                      VALUES (:id_rok, :vpisna, :stejPrijavLetos, :stejPrijavSkupno, '1', now())
                      "
                    );
                    $statement2->bindValue(":vpisna", $vpisna);
                    $statement2->bindValue(":id_rok", $id_rok);
                    $statement2->bindValue(":stejPrijavLetos", $stejPrijavLetos+1);
                    $statement2->bindValue(":stejPrijavSkupno", $stejPrijavSkupno+1);

                    $statement2->execute();
                    //var_dump($statement2->rowCount());
                //}

                return true;
           /* } catch (Exception $e){
                var_dump($e);
               return false;
            }*/
    }

    public static function getVpisna($id){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "SELECT s.VPISNA_STEVILKA
            FROM student as s 
            WHERE s.ID_OSEBA=:id
        "
        );
        $statement->bindValue(":id", $id);

        try{
            $statement->execute();

            return $statement->fetch();
        } catch (Exception $e){
            return false;
        }
    }

    public static function getIzpitniRok($leto,$id_rok){
        $db = DBInit::getInstance();
        $statement = $db->prepare("
        SELECT DISTINCT p.ID_PREDMET
        FROM `predmet` AS p
        JOIN `predmeti_studenta` AS ps ON ps.ID_PREDMET = p.ID_PREDMET
        JOIN `student` AS s ON s.VPISNA_STEVILKA = ps.VPISNA_STEVILKA
        JOIN `prijava` AS pr ON pr.VPISNA_STEVILKA=s.VPISNA_STEVILKA
        JOIN `rok` AS r ON r.ID_ROK=pr.ID_ROK
        JOIN `izvedba_predmeta` AS ip ON r.ID_IZVEDBA = ip.ID_IZVEDBA
        WHERE ps.ID_STUD_LETO = :leto AND r.ID_ROK=:id_rok AND ip.ID_PREDMET=p.ID_PREDMET
    ");
        $statement->bindParam(":leto", $leto);
        $statement->bindParam(":id_rok", $id_rok);
        $statement->execute();
        return $statement->fetch();
    }


    public static function getZapStPolaganj($vpisna){
        $db = DBInit::getInstance();
        $statement = $db->prepare("
        SELECT DISTINCT p.ZAP_ST_POLAGANJ
        FROM prijava as p
            JOIN student as s ON s.VPISNA_STEVILKA=p.VPISNA_STEVILKA 
            JOIN ROK as r ON r.ID_ROK=p.ID_ROK
            JOIN IZVEDBA_PREDMETA AS ip ON r.ID_IZVEDBA = ip.ID_IZVEDBA
             WHERE p.VPISNA_STEVILKA =:vpisna
    ");
        $statement->bindParam(":vpisna", $vpisna);

        $statement->execute();
        return $statement->fetch();
    }

    public static function getStudLetoPredmetRok($id_rok){
        $db = DBInit::getInstance();
        $statement = $db->prepare("
        SELECT ip.ID_STUD_LETO, ip.ID_PREDMET
        FROM rok as r 
        JOIN izvedba_predmeta as ip ON r.ID_IZVEDBA=ip.ID_IZVEDBA
        WHERE r.ID_ROK=:id_rok
    ");
        $statement->bindParam(":id_rok", $id_rok);

        $statement->execute();
        return $statement->fetch();
    }

    public static function countZapPrijavLetos($vpisna,$id_leto,$id_predmet){
        $db = DBInit::getInstance();
        $statement = $db->prepare("
        SELECT COUNT(p.ID_PRIJAVA)
        FROM prijava as p 
        JOIN rok as r ON p.ID_ROK=r.ID_ROK
        JOIN izvedba_predmeta as ip ON r.ID_IZVEDBA=ip.ID_IZVEDBA
        WHERE p.VPISNA_STEVILKA=:vpisna AND ip.ID_STUD_LETO=:id_leto AND ip.ID_PREDMET=:id_predmet AND p.DATUM_ODJAVE IS NULL
    ");
        $statement->bindParam(":vpisna", $vpisna);
        $statement->bindParam(":id_leto", $id_leto);
        $statement->bindParam(":id_predmet", $id_predmet);

        $statement->execute();
        return $statement->fetchColumn();
    }

    public static function countZapPrijavSkupno($vpisna,$id_predmet){
        $db = DBInit::getInstance();
        $statement = $db->prepare("
        SELECT COUNT(p.ID_PRIJAVA)
        FROM prijava as p 
        JOIN rok as r ON p.ID_ROK=r.ID_ROK
        JOIN izvedba_predmeta as ip ON r.ID_IZVEDBA=ip.ID_IZVEDBA
        WHERE p.VPISNA_STEVILKA=:vpisna AND ip.ID_PREDMET=:id_predmet AND p.DATUM_ODJAVE IS NULL
    ");
        $statement->bindParam(":vpisna", $vpisna);
        $statement->bindParam(":id_predmet", $id_predmet);

        $statement->execute();
        return $statement->fetchColumn();
    }

    public static function countVsehRokovLetos($vpisna,$id_leto,$id_predmet){
        $db = DBInit::getInstance();
        $statement = $db->prepare("
        SELECT COUNT(p.ID_PRIJAVA)
        FROM prijava as p
        JOIN rok as r ON p.ID_ROK=r.ID_ROK
        JOIN izvedba_predmeta as ip ON r.ID_IZVEDBA=ip.ID_IZVEDBA
        WHERE p.VPISNA_STEVILKA=:vpisna AND ip.ID_STUD_LETO=:id_leto AND ip.ID_PREDMET=:id_predmet AND p.DATUM_ODJAVE IS NULL
    ");
        $statement->bindParam(":vpisna", $vpisna);
        $statement->bindParam(":id_leto", $id_leto);
        $statement->bindParam(":id_predmet", $id_predmet);

        $statement->execute();
        return $statement->fetchColumn();
    }

    public static function checkPrijava($vpisna,$id_predmet){
    $db = DBInit::getInstance();
    $statement = $db->prepare("
            SELECT COUNT(p.OCENA_IZPITA)
            FROM prijava as p
            JOIN rok as r ON r.ID_ROK=p.ID_ROK
            JOIN izvedba_predmeta as ip ON ip.ID_IZVEDBA=r.ID_IZVEDBA
            WHERE p.VPISNA_STEVILKA=:vpisna AND ip.ID_PREDMET=:id_predmet AND DATUM_ODJAVE IS NULL AND OCENA_IZPITA IS NOT NULL
        ");
    $statement->bindParam(":vpisna", $vpisna);
    $statement->bindParam(":id_predmet", $id_predmet);
    $statement->execute();
    return $statement->fetchColumn();

}

    public static function getNacinStudija($vpisna){
        $db = DBInit::getInstance();
        $statement = $db->prepare("
        SELECT v.ID_NACIN
        FROM vpis as v
        WHERE v.VPISNA_STEVILKA =:vpisna
    ");
        $statement->bindParam(":vpisna", $vpisna);

        $statement->execute();
        return $statement->fetch();
    }

    public static function odjaviSe($idOseba,$id_rok,$vpisna){
        $db=DBInit::getInstance();
        $statement = $db->prepare("
            UPDATE prijava
            SET DATUM_ODJAVE = CURRENT_TIMESTAMP, ID_OSEBA_ODJAVITELJ = :idOseba, TOCKE_IZPITA = null 
            WHERE ID_ROK =:id_rok AND prijava.VPISNA_STEVILKA=:vpisna
        ");

        $statement->bindValue(":id_rok", $id_rok);
        $statement->bindValue(":idOseba", $idOseba);
        $statement->bindValue(":vpisna", $vpisna);
        if($statement->execute()){
            return true;
        }
        return false;

    }

}