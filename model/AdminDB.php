<?php

require_once "DBInit.php";

class AdminDB {

    // User story 2
    public static function getStudentData($vpisna_stevilka){

        $db = DBInit::getInstance();

        // TODO ulica, hisna_stevilka, naslov_za_posiljanje, telefon, email
        $statement = $db -> prepare(
            "SELECT s.vpisna_stevilka, o.ime, o.priimek, n.ulica, d.SLOVENSKINAZIV, d.TRIMESTNAKODA, n.je_stalni, p.st_posta, p.kraj, n.je_zavrocanje, o.email, o.telefonska_stevilka 
                        FROM student AS s
                        JOIN oseba o on s.ID_OSEBA = o.ID_OSEBA
                        LEFT JOIN naslov n on o.ID_OSEBA = n.ID_OSEBA
                        LEFT JOIN drzava d on n.ID_DRZAVA = d.ID_DRZAVA
                        LEFT JOIN posta p on n.ID_POSTA = p.ID_POSTA                        
                        WHERE s.vpisna_stevilka = :vpisna_stevilka
                       "
        );


        $statement->bindParam(":vpisna_stevilka", $vpisna_stevilka);
        $statement->execute();

        return $statement->fetchAll();
    }

    // User story 2
    public static function getEnrollmentDetails($vpisna_stevilka){

        $db = DBInit::getInstance();

        $statement = $db->prepare(
            "SELECT sl.stud_leto, l.letnik,  p.sifra_program, p.sifra_evs,  p.naziv_program, vr.opis_vpisa, n.opis_nacin
                        FROM  student AS st
                        JOIN vpis AS v ON st.id_vpis = v.id_vpis
                        JOIN studijsko_leto AS sl ON v.id_stud_leto = sl.id_stud_leto
                        JOIN program AS p ON v.id_program = p.id_program
                        JOIN vrsta_vpisa AS vr ON v.id_vrstavpisa = vr.id_vrstavpisa
                        JOIN nacin_studija AS n ON v.id_nacin = n.id_nacin
                        JOIN letnik AS l ON v.ID_LETNIK = l.ID_LETNIK
  						WHERE st.vpisna_stevilka = :vpisna_stevilka
                        ORDER BY sl.stud_leto DESC"
        );

        $statement->bindValue(":vpisna_stevilka", $vpisna_stevilka);
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function getAllNames(){

        $db = DBInit::getInstance();

        $statement = $db -> prepare(
            "SELECT o.ime, o.priimek, s.vpisna_stevilka 
                        FROM  student as s,
                              oseba as o 
                        WHERE o.id_oseba = s.id_oseba"
        );

        $statement->execute();

        return $statement->fetchAll();
    }

    public static function getPredmeti(){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "SELECT * FROM predmet"
        );
        $statement->execute();
        return $statement->fetchAll();


    }
    public static function predmetniki($idPredmet){
        echo("<script>console.log('ADMINFB: ', ".$idPredmet . ");</script>");
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "SELECT p.id_predmetnik,s.stud_leto, l.letnik, pr.SIFRA_EVS, pr.Naziv_program, d.NAZIV_DELAPREDMETNIKA, p.aktivnost
            FROM predmetnik p, studijsko_leto s, letnik l, program pr, del_predmetnika d
            WHERE p.id_stud_leto = s.id_stud_leto and p.id_program = pr.id_program and p.id_letnik = l.id_letnik 
             and p.id_delpredmetnika = d.id_delpredmetnika and p.id_predmet = :predmet"
        );
        $statement->bindParam(":predmet", $idPredmet);
        $statement->execute();
        return $statement->fetchAll();


    }

    public static function predmetName($id){
        echo("<script>console.log('ADMINFB: ', ".$id . ");</script>");
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "SELECT IME_PREDMET FROM predmet
            WHERE ID_PREDMET = :PREDMET ;"
        );
        $statement->bindParam(":PREDMET", $id);
        $statement->execute();
        return $statement->fetchColumn();
    }
    public static function all(){
        $all = [];
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "SELECT * FROM STUDIJSKO_leto"
        );
        $statement->execute();
        array_push($all, $statement->fetchAll());
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "SELECT * FROM Letnik"
        );
        $statement->execute();
        array_push($all, $statement->fetchAll());
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "SELECT * FROM program"
        );
        $statement->execute();
        array_push($all, $statement->fetchAll());
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "SELECT * FROM del_predmetnika"
        );
        $statement->execute();
        array_push($all, $statement->fetchAll());

        return $all;
    }
    public static function predmetnik($id){
        if ($id == 0) return true;
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "SELECT * FROM predmetnik
            WHERE ID_PREDMETNIK = :id "
        );
        $statement->bindParam(":id", $id);
        $statement->execute();
        return $statement->fetchAll()[0];


    }
    public static function changePredmetnik($id){

        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "SELECT aktivnost from predmetnik where id_predmetnik = :id_predmetnik;"

        );
        $statement->bindParam(":id_predmetnik", $id);
        $statement->execute();
        $aktivnost = $statement->fetchColumn();
        if($aktivnost == "1"){
            $val = 0;
        }
        else $val = 1;

        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "UPDATE predmetnik SET
        AKTIVNOST = :aktivnost
        where  id_predmetnik = :id_predmetnik"
        );
        $statement->bindParam(":id_predmetnik", $id);
        $statement->bindParam(":aktivnost", $val);
        $statement->execute();
        return true;

    }
    public static function getIDPredmet($ime){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "SELECT ID_PREDMET FROM predmet
            WHERE IME_PREDMET = :id "
        );
        $statement->bindParam(":id", $ime);
        $statement->execute();
        return $statement->fetchColumn()[0];
    }
    public static function addPredmetnik($data){
        $db = DBInit::getInstance();

        $statement = $db -> prepare(
            "INSERT INTO predmetnik(ID_PREDMET, ID_DELPREDMETNIKA, ID_LETNIK, ID_STUD_LETO, ID_PROGRAM, AKTIVNOST)
          VALUES (:predmet,:delPredmetnika,:letnik,:stud_leto,:program,1)"
        );
        $statement->bindParam(":stud_leto", $data['leto']);
        $statement->bindParam(":delPredmetnika", $data['delpredmetnika']);
        $statement->bindParam(":letnik", $data['letnik']);
        $statement->bindParam(":predmet", $data['idPredmet']);
        $statement->bindParam(":program", $data['program']);
        $statement->execute();
        return true;
    }

    public static function editPredmetnik($data){$db = DBInit::getInstance();
        $statement = $db -> prepare(
            "UPDATE predmetnik SET 
        ID_PREDMET = :predmet,
        ID_DELPREDMETNIKA=:delPredmetnika,
        ID_LETNIK= :letnik,
        ID_STUD_LETO= :stud_leto,
        ID_PROGRAM = :program
        WHERE ID_PREDMETNIK = :idPredmetnik"
        );
        $statement->bindParam(":stud_leto", $data['leto']);
        $statement->bindParam(":delPredmetnika", $data['delpredmetnika']);
        $statement->bindParam(":letnik", $data['letnik']);
        $statement->bindParam(":predmet", $data['idPredmet']);
        $statement->bindParam(":program", $data['program']);
        $statement->bindParam(":idPredmetnik", $data['idPredmetnik']);
        $statement->execute();
        return true;

    }

    public static function isUniqueVpisna($vpisna){

        $db = DBInit::getInstance();
        $statement = $db ->prepare("
            SELECT s.VPISNA_STEVILKA AS V1, k.VPISNA_STEVILKA AS V2
            FROM student AS s, kandidat AS k
            WHERE s.VPISNA_STEVILKA = :vpisna
            OR k.VPISNA_STEVILKA = :vpisna"
        );
        $statement->bindValue(":vpisna", $vpisna);
        $statement->execute();
        $result = $statement->fetch();

        if(empty($result)) return true;
        return false;
    }

}