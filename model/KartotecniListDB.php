<?php
/**
 * Created by PhpStorm.
 * User: Paule
 * Date: 25/05/2018
 * Time: 23:42
 */

class KartotecniListDB
{
    public static function getStudData($id)
    {
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT IME, PRIIMEK, s.VPISNA_STEVILKA, STUD_LETO, NAZIV_PROGRAM, ID_LETNIK, OPIS_VPISA, OPIS_NACIN, p.ID_PROGRAM
from oseba o
  JOIN student s ON o.ID_OSEBA = s.ID_OSEBA
  JOIN vpis v ON s.VPISNA_STEVILKA = v.VPISNA_STEVILKA
  JOIN studijsko_leto l ON v.ID_STUD_LETO = l.ID_STUD_LETO
  JOIN program p ON v.ID_PROGRAM = p.ID_PROGRAM
  join vrsta_vpisa v3 ON v.ID_VRSTAVPISA = v3.ID_VRSTAVPISA
  JOIN nacin_studija n ON v.ID_NACIN = n.ID_NACIN

WHERE o.ID_OSEBA = s.ID_OSEBA and o.ID_OSEBA = :id
order by  STUD_LETO ASC
        ");
        $statement->bindParam(":id", $id);
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function getOcenePoLetih($id)
    {
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            select l.ID_STUD_LETO, l.STUD_LETO, v.ID_LETNIK
from student s
  join vpis v ON s.VPISNA_STEVILKA = v.VPISNA_STEVILKA
  JOIN studijsko_leto l ON v.ID_STUD_LETO = l.ID_STUD_LETO

where s.ID_OSEBA = :id
        ");
        $statement->bindParam(":id", $id);
        $statement->execute();
        $leta = $statement->fetchAll();

        $all = [];

        foreach ($leta as $row){
            $db = DBInit::getInstance();

            $statement = $db->prepare("
            select SUM(ST_KREDITNIH_TOCK) as SUM, avg(studenta.OCENA) as AVG 
            from student s
            JOIN predmeti_studenta studenta ON s.VPISNA_STEVILKA = studenta.VPISNA_STEVILKA
            JOIN predmet p ON studenta.ID_PREDMET = p.ID_PREDMET
            
            
            where s.ID_OSEBA = :id and studenta.ID_STUD_LETO = :leto and studenta.OCENA > 5
        ");
            $statement->bindParam(":id", $id);
            $statement->bindParam(":leto", $row['ID_STUD_LETO']);
            $statement->execute();
            $podatki = $statement->fetch();
            $row['SUM'] = $podatki['SUM'];
            $row['AVG'] = $podatki['AVG'];
            array_push($all, $row);
        }

        return $all;
    }

    public static function getAllPolaganja($id){

        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT SIFRA_PREDMET, IME_PREDMET, o.IME, o2.IME as p2i, o2.PRIIMEK as p2p, o3.IME as p3i,
o3.PRIIMEK as p3p, o4.IME as p4i, o4.PRIIMEK as p4p, OCENA, predmeta.ID_IZVEDBA,
l.STUD_LETO as leto, v.ID_PROGRAM, v.ID_VPIS, p.ST_KREDITNIH_TOCK
from oseba o
JOIN student s ON o.ID_OSEBA = s.ID_OSEBA
JOIN predmeti_studenta studenta ON s.VPISNA_STEVILKA = studenta.VPISNA_STEVILKA
JOIN predmet p ON studenta.ID_PREDMET = p.ID_PREDMET
JOIN izvedba_predmeta predmeta ON p.ID_PREDMET = predmeta.ID_PREDMET
JOIN oseba o2 ON predmeta.ID_OSEBA1 = o2.ID_OSEBA
JOIN studijsko_leto l ON predmeta.ID_STUD_LETO = l.ID_STUD_LETO
LEFT JOIN oseba o3 ON predmeta.ID_OSEBA2 = o3.ID_OSEBA
LEFT JOIN oseba o4 ON predmeta.ID_OSEBA3 = o4.ID_OSEBA
JOIN vpis v ON s.VPISNA_STEVILKA = v.VPISNA_STEVILKA

where o.ID_OSEBA = :id and predmeta.ID_STUD_LETO = studenta.ID_STUD_LETO and v.ID_STUD_LETO = studenta.ID_STUD_LETO ORDER BY  leto ASC");
        $statement->bindParam(":id", $id);
        $statement->execute();

        $all = $statement->fetchAll();


        $out = [];
        foreach ($all as $row){
            $i = 0;
            $row['izvajalci'] = $row['p2i']." ". $row['p2p'];
            if ($row['p3i'] != null){
                $row['izvajalci'] = $row['izvajalci']. ", " . $row['p3i']." ". $row['p3p'];
                if ($row['p4i'] != null){
                    $row['izvajalci'] = $row['izvajalci']. ", " . $row['p4i']." ". $row['p4p'];
                }
            }
            $db = DBInit::getInstance();

            $statement = $db->prepare("
                  SELECT s.ID_OSEBA,r.ID_IZVEDBA, r.DATUM_ROKA, r.CAS_ROKA, p.ZAP_ST_POLAGANJ, p.ZAP_ST_POLAGANJ_LETOS, p.TOCKE_IZPITA, p.OCENA_IZPITA  FROM ROK r
                      JOIN prijava p ON r.ID_ROK = p.ID_ROK
                      JOIN student s ON p.VPISNA_STEVILKA = s.VPISNA_STEVILKA
                    where s.ID_OSEBA = :id and ID_IZVEDBA = :iz");
            $statement->bindParam(":id", $id);
            $statement->bindParam(":iz", $row['ID_IZVEDBA']);
            $statement->execute();

            $izpiti = $statement->fetchAll();
            if(count($izpiti) == 0){
                $row['DATUM_ROKA'] = "/";
                $row['CAS_ROKA'] = "/";
                $row['ZAP_ST_POLAGANJ'] = 0;
                $row['ZAP_ST_POLAGANJ_LETOS'] = 0;
                $row['TOCKE_IZPITA'] = "/";
                array_push($out, $row);

            }
            else{
                $newrow = $row;
                foreach ($izpiti as $izpit) {
                    $i+=1;
                    if($i > 1){
                        #$newrow['SIFRA_PREDMET']="";
                        $newrow['IME_PREDMET']="";
                        $newrow['IME_PREDMET']="";

                    }
                    $newrow['DATUM_ROKA'] =  $izpit['DATUM_ROKA'];
                    $newrow['CAS_ROKA'] = $izpit['CAS_ROKA'];
                    $newrow['ZAP_ST_POLAGANJ'] =  $izpit['ZAP_ST_POLAGANJ'];
                    $newrow['ZAP_ST_POLAGANJ_LETOS'] =  $izpit['ZAP_ST_POLAGANJ_LETOS'];
                    $newrow['TOCKE_IZPITA'] =  $izpit['TOCKE_IZPITA'];
                    $newrow['OCENA_IZPITA'] =  $izpit['OCENA_IZPITA'];

                    array_push($out, $newrow);

                }

            }


        }

        $all=array();
        $programi=array();
        foreach ($out as $row){

            if (!array_key_exists($row['leto'], $all)){
                $all[$row['leto']] = array();
            }
            array_push($all[$row['leto']], $row);

            if (!array_key_exists($row['ID_PROGRAM'], $programi)){
                $programi[$row['ID_PROGRAM']] = array();
            }
            array_push($programi[$row['ID_PROGRAM']], $row);


        }


        return [$all, $programi];
    }

    public static function getZadnjaPolaganja($id){

        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT SIFRA_PREDMET, IME_PREDMET, o.IME, o2.IME as p2i, o2.PRIIMEK as p2p, o3.IME as p3i,
o3.PRIIMEK as p3p, o4.IME as p4i, o4.PRIIMEK as p4p, OCENA, predmeta.ID_IZVEDBA,
l.STUD_LETO as leto, v.ID_PROGRAM, v.ID_VPIS, p.ST_KREDITNIH_TOCK
from oseba o
JOIN student s ON o.ID_OSEBA = s.ID_OSEBA
JOIN predmeti_studenta studenta ON s.VPISNA_STEVILKA = studenta.VPISNA_STEVILKA
JOIN predmet p ON studenta.ID_PREDMET = p.ID_PREDMET
JOIN izvedba_predmeta predmeta ON p.ID_PREDMET = predmeta.ID_PREDMET
JOIN oseba o2 ON predmeta.ID_OSEBA1 = o2.ID_OSEBA
JOIN studijsko_leto l ON predmeta.ID_STUD_LETO = l.ID_STUD_LETO
LEFT JOIN oseba o3 ON predmeta.ID_OSEBA2 = o3.ID_OSEBA
LEFT JOIN oseba o4 ON predmeta.ID_OSEBA3 = o4.ID_OSEBA
JOIN vpis v ON s.VPISNA_STEVILKA = v.VPISNA_STEVILKA

where o.ID_OSEBA = :id and predmeta.ID_STUD_LETO = studenta.ID_STUD_LETO and v.ID_STUD_LETO = studenta.ID_STUD_LETO ORDER BY  leto ASC");
        $statement->bindParam(":id", $id);
        $statement->execute();

        $all = $statement->fetchAll();


        $out = [];
        foreach ($all as $row){
            $i = 0;
            $row['izvajalci'] = $row['p2i']." ". $row['p2p'];
            if ($row['p3i'] != null){
                $row['izvajalci'] = $row['izvajalci']. ", " . $row['p3i']." ". $row['p3p'];
                if ($row['p4i'] != null){
                    $row['izvajalci'] = $row['izvajalci']. ", " . $row['p4i']." ". $row['p4p'];
                }
            }
            $db = DBInit::getInstance();

            $statement = $db->prepare("
                  SELECT s.ID_OSEBA,r.ID_IZVEDBA, r.DATUM_ROKA, r.CAS_ROKA, p.ZAP_ST_POLAGANJ, p.ZAP_ST_POLAGANJ_LETOS, p.TOCKE_IZPITA, p.OCENA_IZPITA  FROM ROK r
                      JOIN prijava p ON r.ID_ROK = p.ID_ROK
                      JOIN student s ON p.VPISNA_STEVILKA = s.VPISNA_STEVILKA
                      where s.ID_OSEBA = :id and ID_IZVEDBA = :iz ORDER BY r.DATUM_ROKA DESC LIMIT 1");

            $statement->bindParam(":id", $id);
            $statement->bindParam(":iz", $row['ID_IZVEDBA']);
            $statement->execute();

            $izpiti = $statement->fetchAll();
            if(count($izpiti) == 0){
                $row['DATUM_ROKA'] = "/";
                $row['CAS_ROKA'] = "/";
                $row['ZAP_ST_POLAGANJ'] = 0;
                $row['ZAP_ST_POLAGANJ_LETOS'] = 0;
                $row['TOCKE_IZPITA'] = "/";
                array_push($out, $row);

            }
            else{
                $newrow = $row;
                foreach ($izpiti as $izpit) {
                    $i+=1;
                    if($i > 1){
                        #$newrow['SIFRA_PREDMET']="";
                        $newrow['IME_PREDMET']="";
                        $newrow['IME_PREDMET']="";

                    }
                    $newrow['DATUM_ROKA'] =  $izpit['DATUM_ROKA'];
                    $newrow['CAS_ROKA'] = $izpit['CAS_ROKA'];
                    $newrow['ZAP_ST_POLAGANJ'] =  $izpit['ZAP_ST_POLAGANJ'];
                    $newrow['ZAP_ST_POLAGANJ_LETOS'] =  $izpit['ZAP_ST_POLAGANJ_LETOS'];
                    $newrow['TOCKE_IZPITA'] =  $izpit['TOCKE_IZPITA'];
                    $newrow['OCENA_IZPITA'] =  $izpit['OCENA_IZPITA'];

                    array_push($out, $newrow);

                }

            }


        }

        $all=array();
        $programi=array();
        foreach ($out as $row){

            if (!array_key_exists($row['leto'], $all)){
                $all[$row['leto']] = array();
            }
            array_push($all[$row['leto']], $row);

            if (!array_key_exists($row['ID_PROGRAM'], $programi)){
                $programi[$row['ID_PROGRAM']] = array();
            }
            array_push($programi[$row['ID_PROGRAM']], $row);


        }


        return [$all, $programi];

    }
    public static function getProgrami($data)
    {
        $out = array();
        foreach ($data as $id):
            $db = DBInit::getInstance();

            $statement = $db->prepare("
                        SELECT DISTINCT ID_PROGRAM, NAZIV_PROGRAM, SIFRA_EVS
                        FROM  program 
                        WHERE ID_PROGRAM = :id");
            $statement->bindParam(":id", $id);
            $statement->execute();
            $rez = $statement->fetchAll()[0];
            array_push($out, $rez);

        endforeach;
        $all = array();
        $all['NAZIV_PROGRAM']='VSI PROGRAMI';
        $all['SIFRA_EVS']='0000000';
        $all['ID_PROGRAM']='0';
        array_push($out, $all);
        return $out;

    }

    public static function getAllStudents($program, $leto){
        $db = DBInit::getInstance();

        $statement = $db->prepare("
                SELECT DISTINCT *
                FROM  STUDENT s, OSEBA o, VPIS v 
                WHERE s.ID_OSEBA = o.ID_OSEBA and v.ID_STUD_LETO = :leto and v.ID_PROGRAM = :program
                and v.VPISNA_STEVILKA = s.VPISNA_STEVILKA ");
        $statement->bindParam(":leto", $leto);
        $statement->bindParam(":program", $program);

        $statement->execute();

        return $statement->fetchAll();

    }
}