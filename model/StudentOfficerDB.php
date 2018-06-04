<?php
class StudentOfficerDB
{
    public static function getZetoni($id){
        $db = DBInit::getInstance();

        $statement = $db->prepare("
                SELECT DISTINCT *, z.aktivnost AS ACT
                FROM  OSEBA as o,LETNIK as l, STUDIJSKO_LETO as s, STUDENT as st, ZETON as z, NACIN_STUDIJA as n, 
                OBLIKA_STUDIJA as obl, PROGRAM as prog, VRSTA_VPISA as vrs
                WHERE o.ID_oseba = :id and st.ID_OSEBA = o.ID_OSEBA and 
                z.ID_LETNIK = l.ID_LETNIK and z.ID_STUD_LETO = s.ID_STUD_LETO and z.ID_OSEBA = o.ID_OSEBA and 
                z.ID_NACIN = n.ID_NACIN and z.ID_VRSTAVPISA = vrs.ID_VRSTAVPISA and z.ID_PROGRAM = prog.ID_PROGRAM
                and z.ID_OBLIKA = obl.ID_OBLIKA
               
        ");

        $statement->bindParam(":id", $id);
        $statement->execute();


        $results = $statement->fetchAll();
        if ($results != null) {
            return $results;
        } else {
            throw new InvalidArgumentException("No subject with $id");
        }
    }


    public static function toogleActivated ($id){
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT AKTIVNOST FROM zeton WHERE ID_ZETON = :id");
        $statement->bindValue(":id", $id);
        $statement->execute();
        $is_activated_str = ($statement->fetch())["AKTIVNOST"];

        if ($is_activated_str === '1')
            $is_activated = '0';
        else
            $is_activated = '1';

        $statement2 = $db->prepare("
            UPDATE zeton
            SET AKTIVNOST = :is_activated
            WHERE ID_ZETON = :id
        ");
        $statement2->bindValue(":id", $id);
        $statement2->bindParam(":is_activated", $is_activated);
        $statement2->execute();
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
    public static function getOseba($id)
    {
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT ID_OSEBA FROM zeton 
            WHERE ID_ZETON = :id
        ");
        $statement->bindParam(":id", $id);
        $statement->execute();
        return $statement->fetchColumn();
    }

    public static function getProgram($id)
    {
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT NAZIV_PROGRAM FROM program 
            WHERE ID_PROGRAM = :id
        ");
        $statement->bindParam(":id", $id);
        $statement->execute();
        return $statement->fetchColumn();
    }

    public static function getStudData($id)
    {
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT IME, PRIIMEK, s.VPISNA_STEVILKA, STUD_LETO, NAZIV_PROGRAM, ID_LETNIK, OPIS_VPISA, OPIS_NACIN
from oseba o
  JOIN student s ON o.ID_OSEBA = s.ID_OSEBA
  JOIN vpis v ON s.VPISNA_STEVILKA = v.VPISNA_STEVILKA
  JOIN studijsko_leto l ON v.ID_STUD_LETO = l.ID_STUD_LETO
  JOIN program p ON s.ID_PROGRAM = p.ID_PROGRAM
  join vrsta_vpisa v3 ON v.ID_VRSTAVPISA = v3.ID_VRSTAVPISA
  JOIN nacin_studija n ON v.ID_NACIN = n.ID_NACIN

WHERE o.ID_OSEBA = s.ID_OSEBA and o.ID_OSEBA = :id
order by STUD_LETO DESC LIMIT 1 
        ");
        $statement->bindParam(":id", $id);
        $statement->execute();
        return $statement->fetch();
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
        $statement->bindParam(":idZeton", $data['IdZeton']);
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
    public static function dodajNov($id){
        //_dump("dkgbdikgvbsdkrgbrdl");
        $db = DBInit::getInstance();
        $statement = $db->prepare("
           SELECT * FROM `zeton` WHERE id_oseba = :oseba
            ORDER BY ID_STUD_LETO DESC limit 1 ");

        $statement->bindParam(":oseba", $id);
        $statement->execute();
        $data = $statement->fetchAll()[0];

        $db = DBInit::getInstance();
        $letnik =$data['ID_LETNIK']+1;
        $leto = $data['ID_STUD_LETO']+1;
        if ($letnik >3) $letnik = 3;

        if ($letnik == 3){

            $db = DBInit::getInstance();
            $statement = $db->prepare("
            SELECT AVG(ocena)  as ocena
            FROM predmeti_studenta p, student s, oseba o 
            WHERE o.ID_OSEBA=:id and s.ID_OSEBA = o.ID_OSEBA 
            and p.VPISNA_STEVILKA = s.VPISNA_STEVILKA
            ");

            $statement->bindParam(":id", $id);
            $statement->execute();
            $vn = $statement->fetchAll()[0]['ocena'];

            $ocena = explode(".", $vn)[0];
            $vrsta = 1;

           // echo("<script>console.log('datasdsaa: : ', ".$ocena . ");</script>");
            if ($ocena >8.5) $izbirnost = 1;
            else $izbirnost = 0;
            $statement = $db->prepare("
            INSERT INTO `tpo`.`zeton`
            (`ID_OSEBA`,
            `ID_LETNIK`,
            `ID_STUD_LETO`,
            `ID_OBLIKA`,
            `ID_VRSTAVPISA`,
            `ID_NACIN`,
            `ID_PROGRAM`,
            `PROSTA_IZBIRNOST`)
            VALUES
            (:oseba,
            :letnik,
            :leto,
            :oblika,
            :vrstaVpisa,
            :nacin,
            :program,
            :izbirnost); ");

            $statement->bindParam(":oseba", $id);
            $statement->bindParam(":letnik", $letnik);
            $statement->bindParam(":leto", $leto);
            $statement->bindParam(":oblika", $data['ID_OBLIKA']);
            $statement->bindParam(":vrstaVpisa", $vrsta);
            $statement->bindParam(":nacin", $data['ID_NACIN']);
            $statement->bindParam(":program", $data['ID_PROGRAM']);
            $statement->bindParam(":izbirnost", $izbirnost);
            $statement->execute();

            return true;
        }
        else{
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

        $statement->bindParam(":oseba", $id);
        $statement->bindParam(":letnik", $letnik);
        $statement->bindParam(":leto", $leto);
        $statement->bindParam(":oblika", $data['ID_OBLIKA']);
        $statement->bindParam(":vrstaVpisa", $data['ID_VRSTAVPISA']);
        $statement->bindParam(":nacin", $data['ID_NACIN']);
        $statement->bindParam(":program", $data['ID_PROGRAM']);
        $statement->execute();

        return true;}

    }

    public static function dodajNov2($id){

        $db = DBInit::getInstance();
        $statement = $db->prepare("
           SELECT * FROM `zeton` WHERE id_oseba = :oseba
            ORDER BY ID_STUD_LETO DESC limit 1 ");

        $statement->bindParam(":oseba", $id);
        $statement->execute();
        $data = $statement->fetchAll()[0];
        $data['ID_VRSTAVPISA'] = 2 ;
        $db = DBInit::getInstance();
        $letnik =$data['ID_LETNIK'];
        $leto = $data['ID_STUD_LETO']+1;
        if ($letnik >3) $letnik = 3;

        if ($letnik == 3){

            $db = DBInit::getInstance();
            $statement = $db->prepare("
            SELECT AVG(ocena) 
            FROM predmeti_studenta p, student s, oseba o 
            WHERE o.ID_OSEBA=:id and s.ID_OSEBA = o.ID_OSEBA 
            and p.VPISNA_STEVILKA = s.VPISNA_STEVILKA
            ");

            $statement->bindParam(":id", $id);
            $statement->execute();
            $ocena = $statement->fetchAll()[0];

            if ($ocena >8.5) $izbirnost = 1;
            else $izbirnost = 0;
            $statement = $db->prepare("
            INSERT INTO `tpo`.`zeton`
            (`ID_OSEBA`,
            `ID_LETNIK`,
            `ID_STUD_LETO`,
            `ID_OBLIKA`,
            `ID_VRSTAVPISA`,
            `ID_NACIN`,
            `ID_PROGRAM`,
            `PROSTA_IZBIRNOST`)
            VALUES
            (:oseba,
            :letnik,
            :leto,
            :oblika,
            :vrstaVpisa,
            :nacin,
            :program,
            :izbirnost); ");

            $statement->bindParam(":oseba", $id);
            $statement->bindParam(":letnik", $letnik);
            $statement->bindParam(":leto", $leto);
            $statement->bindParam(":oblika", $data['ID_OBLIKA']);
            $statement->bindParam(":vrstaVpisa", $data['ID_VRSTAVPISA']);
            $statement->bindParam(":nacin", $data['ID_NACIN']);
            $statement->bindParam(":program", $data['ID_PROGRAM']);
            $statement->bindParam(":izbirnost", $izbirnost);
            $statement->execute();

            return true;
        }
        else{
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

            $statement->bindParam(":oseba", $id);
            $statement->bindParam(":letnik", $letnik);
            $statement->bindParam(":leto", $leto);
            $statement->bindParam(":oblika", $data['ID_OBLIKA']);
            $statement->bindParam(":vrstaVpisa", $data['ID_VRSTAVPISA']);
            $statement->bindParam(":nacin", $data['ID_NACIN']);
            $statement->bindParam(":program", $data['ID_PROGRAM']);
            $statement->execute();

            return true;}

    }
    public static function dodajNov1($id){

        $db = DBInit::getInstance();
        $statement = $db->prepare("
           SELECT * FROM `zeton` WHERE id_oseba = :oseba
            ORDER BY ID_STUD_LETO DESC limit 1 ");

        $statement->bindParam(":oseba", $id);
        $statement->execute();
        $data = $statement->fetchAll()[0];

        $db = DBInit::getInstance();

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

        $statement->bindParam(":oseba", $id);
        $statement->bindParam(":letnik", $data['ID_LETNIK']);
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

    }public static function getAllStudents($program, $leto){
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

    public static function getPredmeti($leto){

            $db = DBInit::getInstance();

            $statement = $db->prepare("
                    SELECT DISTINCT * 
                    FROM   predmet p ,izvedba_predmeta i, oseba o 
                    WHERE i.ID_STUD_LETO = :leto and p.id_predmet = i.id_predmet and o.ID_OSEBA = i.ID_OSEBA1
                    ");
            $statement->bindParam(":leto", $leto);
            $statement->execute();

            return $statement->fetchAll();

    }
    public static function getPredmetiSteviloVpisanih($leto, $program, $letnik)
    {
        $all = [];
        $db = DBInit::getInstance();

        $statement = $db->prepare("
                    SELECT p.ID_PREDMET, p.IME_PREDMET, o.IME as i1, o.PRIIMEK as p1, o2.IME as i2, o2.PRIIMEK as p2, o3.IME as i3, o3.PRIIMEK as p3 FROM predmetnik pr, predmet p, studijsko_leto s, letnik l, program po , oseba o, izvedba_predmeta i LEFT JOIN oseba o2 ON i.ID_OSEBA2 = o2.ID_OSEBA LEFT JOIN oseba o3 on i.ID_OSEBA3 = o3.ID_OSEBA
where pr.ID_PREDMET = p.ID_PREDMET and pr.ID_STUD_LETO = s.ID_STUD_LETO and i.ID_STUD_LETO = pr.ID_STUD_LETO
      and pr.ID_LETNIK = l.ID_LETNIK and pr.ID_PROGRAM = po.ID_PROGRAM and i.ID_PREDMET = p.ID_PREDMET
      and :letnik = l.ID_LETNIK and :program = pr.ID_PROGRAM and s.ID_STUD_LETO = :leto
      and i.ID_OSEBA1 = o.ID_OSEBA");
        $statement->bindParam(":leto", $leto);
        $statement->bindParam(":program", $program);
        $statement->bindParam(":letnik", $letnik);
        $statement->execute();

        $retultat = $statement->fetchAll();

/*SELECT * FROM predmetnik pr, predmet p, studijsko_leto s, letnik l, program po , izvedba_predmeta i, oseba o
        where pr.ID_PREDMET = p.ID_PREDMET and pr.ID_STUD_LETO = s.ID_STUD_LETO and i.ID_STUD_LETO = pr.ID_STUD_LETO
        and pr.ID_LETNIK = l.ID_LETNIK and pr.ID_PROGRAM = po.ID_PROGRAM and i.ID_PREDMET = p.ID_PREDMET
        and :letnik = l.ID_LETNIK and :program = pr.ID_PROGRAM and s.ID_STUD_LETO = :leto and i.ID_OSEBA1 = o.ID_OSEBA*/
        foreach ($retultat as $var) {

            $db = DBInit::getInstance();
            $statement = $db->prepare("
                         SELECT count(*) FROM
                        predmeti_studenta pr WHERE pr.ID_PREDMET = :id AND pr.ID_STUD_LETO = :leto
                        ");
            $statement->bindParam(":leto", $leto);
            $statement->bindParam(":id", $var['ID_PREDMET']);
            $statement->execute();
            $count = $statement->fetchColumn();
            $var['COUNT'] = $count;
            array_push($all, $var);
         }
        return $all;

    }

    public static function getPredmet($id){

        $db = DBInit::getInstance();

        $statement = $db->prepare("
                    SELECT DISTINCT *
                    FROM  predmet 
                    WHERE ID_PREDMET = :id");
        $statement->bindParam(":id", $id);
        $statement->execute();

        $rez =  $statement->fetch();

        return $rez;
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


    public static function getAllPolaganja($id){

        $db = DBInit::getInstance();

        $statement = $db->prepare("
                   SELECT SIFRA_PREDMET, IME_PREDMET, o.IME, o2.IME as p2i, o2.PRIIMEK as p2p, o3.IME as p3i,
                                          o3.PRIIMEK as p3p, o4.IME as p4i, o4.PRIIMEK as p4p, OCENA, predmeta.ID_IZVEDBA,
                                          l.STUD_LETO as leto
from oseba o
  JOIN student s ON o.ID_OSEBA = s.ID_OSEBA
  JOIN predmeti_studenta studenta ON s.VPISNA_STEVILKA = studenta.VPISNA_STEVILKA
  JOIN predmet p ON studenta.ID_PREDMET = p.ID_PREDMET
  JOIN izvedba_predmeta predmeta ON p.ID_PREDMET = predmeta.ID_PREDMET
  JOIN oseba o2 ON predmeta.ID_OSEBA1 = o2.ID_OSEBA
  JOIN studijsko_leto l ON predmeta.ID_STUD_LETO = l.ID_STUD_LETO
  LEFT JOIN oseba o3 ON predmeta.ID_OSEBA2 = o3.ID_OSEBA
  LEFT JOIN oseba o4 ON predmeta.ID_OSEBA3 = o4.ID_OSEBA
  
where o.ID_OSEBA = :id and predmeta.ID_STUD_LETO = studenta.ID_STUD_LETO");
        $statement->bindParam(":id", $id);
        $statement->execute();

        $all = $statement->fetchAll();


        $out = [];
        foreach ($all as $row){
            $row['izvajalci'] = $row['p2i']." ". $row['p2p'];
            if ($row['p3i'] != null){
                $row['izvajalci'] = $row['izvajalci']. ", " . $row['p3i']." ". $row['p3p'];
                if ($row['p4i'] != null){
                    $row['izvajalci'] = $row['izvajalci']. ", " . $row['p4i']." ". $row['p4p'];
                }
            }
            $db = DBInit::getInstance();

            $statement = $db->prepare("
                  SELECT s.ID_OSEBA,r.ID_IZVEDBA, r.DATUM_ROKA, r.CAS_ROKA, p.ZAP_ST_POLAGANJ, p.ZAP_ST_POLAGANJ_LETOS, p.TOCKE_IZPITA  FROM ROK r
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
                    $newrow['DATUM_ROKA'] =  $izpit['DATUM_ROKA'];
                    $newrow['CAS_ROKA'] = $izpit['CAS_ROKA'];
                    $newrow['ZAP_ST_POLAGANJ'] =  $izpit['ZAP_ST_POLAGANJ'];
                    $newrow['ZAP_ST_POLAGANJ_LETOS'] =  $izpit['ZAP_ST_POLAGANJ_LETOS'];
                    $newrow['TOCKE_IZPITA'] =  $izpit['TOCKE_IZPITA'];
                    array_push($out, $newrow);

                }

            }


        }
        return $out;
    }

    public static function getZadnjaPolaganja($id){

        $db = DBInit::getInstance();

        $statement = $db->prepare("
                   SELECT SIFRA_PREDMET, IME_PREDMET, o.IME, o2.IME as p2i, o2.PRIIMEK as p2p, o3.IME as p3i,
                                          o3.PRIIMEK as p3p, o4.IME as p4i, o4.PRIIMEK as p4p, OCENA, predmeta.ID_IZVEDBA,
                                          l.STUD_LETO as leto
from oseba o
  JOIN student s ON o.ID_OSEBA = s.ID_OSEBA
  JOIN predmeti_studenta studenta ON s.VPISNA_STEVILKA = studenta.VPISNA_STEVILKA
  JOIN predmet p ON studenta.ID_PREDMET = p.ID_PREDMET
  JOIN izvedba_predmeta predmeta ON p.ID_PREDMET = predmeta.ID_PREDMET
  JOIN oseba o2 ON predmeta.ID_OSEBA1 = o2.ID_OSEBA
  JOIN studijsko_leto l ON predmeta.ID_STUD_LETO = l.ID_STUD_LETO
  LEFT JOIN oseba o3 ON predmeta.ID_OSEBA2 = o3.ID_OSEBA
  LEFT JOIN oseba o4 ON predmeta.ID_OSEBA3 = o4.ID_OSEBA
  
where o.ID_OSEBA = :id and predmeta.ID_STUD_LETO = studenta.ID_STUD_LETO");
        $statement->bindParam(":id", $id);
        $statement->execute();

        $all = $statement->fetchAll();


        $out = [];
        foreach ($all as $row){
            $row['izvajalci'] = $row['p2i']." ". $row['p2p'];
            if ($row['p3i'] != null){
                $row['izvajalci'] = $row['izvajalci']. ", " . $row['p3i']." ". $row['p3p'];
                if ($row['p4i'] != null){
                    $row['izvajalci'] = $row['izvajalci']. ", " . $row['p4i']." ". $row['p4p'];
                }
            }

            $db = DBInit::getInstance();

            $statement = $db->prepare("
                  SELECT s.ID_OSEBA,r.ID_IZVEDBA, r.DATUM_ROKA, r.CAS_ROKA, p.ZAP_ST_POLAGANJ, p.ZAP_ST_POLAGANJ_LETOS, p.TOCKE_IZPITA  FROM ROK r
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
                    $newrow['DATUM_ROKA'] =  $izpit['DATUM_ROKA'];
                    $newrow['CAS_ROKA'] = $izpit['CAS_ROKA'];
                    $newrow['ZAP_ST_POLAGANJ'] =  $izpit['ZAP_ST_POLAGANJ'];
                    $newrow['ZAP_ST_POLAGANJ_LETOS'] =  $izpit['ZAP_ST_POLAGANJ_LETOS'];
                    $newrow['TOCKE_IZPITA'] =  $izpit['TOCKE_IZPITA'];
                    array_push($out, $newrow);

                }

            }


        }
        return $out;
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
            
            
            where s.ID_OSEBA = :id and studenta.ID_STUD_LETO = :leto and studenta.OCENA > 0
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
    public static function PreveriOcene($id){
#1 - gre naprej
        #2 - ponavlja

        #preveri če ima zadnji žeton že porabljen
        $db = DBInit::getInstance();
        $statement = $db->prepare(" 
        select * from oseba o, student s , zeton z
        where s.ID_OSEBA = o.ID_OSEBA and s.VPISNA_STEVILKA = :id and z.ID_OSEBA = s.ID_OSEBA
        order by z.ID_STUD_LETO desc 
        limit 1  ");


        $statement->bindParam(":id", $id);
        $statement->execute();
        $check = $statement->fetchAll();
        if(count($check)<1) return 0;
        $check = $check[0];

        if($check['IZKORISCEN'] == "0") return 0;
        if($check['AKTIVNOST'] == "0") return 0;
        $db = DBInit::getInstance();

        $statement = $db->prepare("  
            select p.ID_PREDMET from predmeti_studenta ps, predmet p, student s
            where ps.ID_PREDMET = p.ID_PREDMET and s.VPISNA_STEVILKA = ps.VPISNA_STEVILKA and s.VPISNA_STEVILKA = :id and ps.OCENA < 6
                    ");


        $statement->bindParam(":id", $id);
        $statement->execute();



        $neizdelani = $statement->fetchAll();

        if(count($neizdelani) == 0) {
            return 1;
        }
        elseif (count($neizdelani) >= 4){
            return 0;
        }
        elseif (count($neizdelani) == 1 ){
            $db = DBInit::getInstance();

            $statement = $db->prepare("  
            SELECT p.ID_PREDMET from predmet p, predmetnik pr ,
                (select (l.ID_LETNIK) from letnik l, vpis v , student s
                where l.ID_LETNIK = v.ID_LETNIK and 
                v.VPISNA_STEVILKA = s.VPISNA_STEVILKA and 
                s.VPISNA_STEVILKA = :id 
                ORDER by l.ID_LETNIK DESC 
                LIMIT 1) as r 
                where p.ID_PREDMET = pr.ID_PREDMET and pr.ID_LETNIK = r.ID_LETNIK
                    ");


            $statement->bindParam(":id", $id);
            $statement->execute();

            $vsi = $statement->fetchAll();

            foreach ($vsi as &$value) {
                if ($value == $neizdelani[0]){
                    $db = DBInit::getInstance();

                    $statement = $db->prepare("  
            select ID_LETNIK from vpis s
            where s.VPISNA_STEVILKA = :id
            order BY  letnik DESC 
            LIMIT 1
                    ");


                    $statement->bindParam(":id", $id);
                    $statement->execute();
                    $letnik = $statement->fetchColumn();
                    if ($letnik == "3") return 2;
                } return 1;
            }
            return 2;
        }
        else{
            return 2;
        }
    }


    public static function getPredmetiZaStudLeto($id_stud_leto)
    {

        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT DISTINCT ip.ID_PREDMET, p.IME_PREDMET, p.SIFRA_PREDMET, o1.IME AS IME1, o1.PRIIMEK AS PRIIMEK1, o2.IME AS IME2, o2.PRIIMEK AS PRIIMEK2, o3.IME AS IME3, o3.PRIIMEK AS PRIIMEK3
            FROM izvedba_predmeta AS ip
            JOIN predmet AS p ON ip.ID_PREDMET = p.ID_PREDMET
            LEFT JOIN oseba o1 on ip.ID_OSEBA1 = o1.ID_OSEBA
            LEFT JOIN oseba o2 on ip.ID_OSEBA2 = o2.ID_OSEBA
            LEFT JOIN oseba o3 on ip.ID_OSEBA3 = o3.ID_OSEBA
            WHERE ip.ID_STUD_LETO = :id_stud_leto
        ");

        $statement->bindValue(":id_stud_leto", $id_stud_leto);
        $statement->execute();
        return $statement->fetchAll();
    }

    public static function getIzpitniRokiZaStudLeto($id_stud_leto)
    {

        $db = DBInit::getInstance();
        $statement = $db->prepare("
            SELECT ip.ID_PREDMET, r.ID_ROK, r.ID_IZVEDBA, r.DATUM_ROKA, r.CAS_ROKA
            FROM rok AS r
            JOIN izvedba_predmeta AS ip ON r.ID_IZVEDBA = ip.ID_IZVEDBA
            WHERE ip.ID_STUD_LETO = :id_stud_leto
        ");

        $statement->bindValue(":id_stud_leto", $id_stud_leto);
        $statement->execute();
        return $statement->fetchAll();
    }

}
