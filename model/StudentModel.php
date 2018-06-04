<?php

class StudentModel{

    public static function getAllStudentsByStudLeto($idStudLeto) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT s.ID_OSEBA, o.IME, o.PRIIMEK, s.VPISNA_STEVILKA, v.ID_LETNIK, s.VSOTA_OPRAVLJENIH_KREDITNIH_TOCK, s.POVPRECNA_OCENA_OPRAVLJENIH_IZPITOV
            FROM STUDENT as s
            JOIN VPIS as v ON s.VPISNA_STEVILKA = v.VPISNA_STEVILKA
            JOIN OSEBA as o ON s.ID_OSEBA = o.ID_OSEBA
            WHERE v.ID_STUD_LETO = :idStudLeto
        ");
        $statement->bindParam(":idStudLeto", $idStudLeto, PDO::PARAM_INT);
        $statement->execute();
        $res =  $statement->fetchAll();
        $all = array();
        #var_dump($res[0]);
        foreach ($res as $row):

            $db = DBInit::getInstance();

            $statement = $db->prepare("
                    select SUM(p.ST_KREDITNIH_TOCK) as krediti from student s
            JOIN predmeti_studenta studenta ON s.VPISNA_STEVILKA = studenta.VPISNA_STEVILKA
            JOIN predmet p ON studenta.ID_PREDMET = p.ID_PREDMET
            where studenta.OCENA > 5 and s.ID_OSEBA = :id    
    ");
            $statement->bindParam(":id", $row['ID_OSEBA']);
            $statement->execute();
            $row['KREDITI'] = $statement->fetchColumn();
            if($row['KREDITI'] == "") $row['KREDITI'] = 0;

            $db = DBInit::getInstance();
            $statement = $db->prepare("
                   select z.IZKORISCEN from student s
                    join zeton z ON s.ID_OSEBA = z.ID_OSEBA
                    WHERE s.ID_OSEBA = :id
                    ORDER BY ID_STUD_LETO DESC LIMIT 1
    ");
            $statement->bindParam(":id", $row['ID_OSEBA']);
            $statement->execute();
            $row['IZKORISCEN'] = $statement->fetchColumn();

        array_push($all, $row);




        endforeach;


        return $all;
    }

        // To check, ce sploh lahko vidi obrazec za vpis
    public static function imaStudentAktivenZeton($id_oseba){

        $db = DBInit::getInstance();
        $statement = $db->prepare("
            SELECT COUNT(ID_ZETON)
            FROM ZETON
            WHERE ID_OSEBA = :id_oseba
            AND AKTIVNOST = 1
            AND IZKORISCEN = 0
        ");

        $statement->bindValue(":id_oseba", $id_oseba);
        $statement->execute();
        $result = $statement->fetch();

        if($result['COUNT(ID_ZETON)'] == 1) return true;
        return false;
    }

    public static function getStudijskoLeto($id_stud_leto){
        return KandidatModel::getStudijskoLeto($id_stud_leto);
    }



    public static function getStudentPodatkiVpis($id_oseba){

        $db = DBInit::getInstance();

        $statement = $db -> prepare("
            SELECT o.id_oseba, o.ime, o.priimek, o.email, o.telefonska_stevilka, p.naziv_program, p.sifra_evs, p.id_program,
                    p.st_semestrov, s.stud_leto, st.vpisna_stevilka, st.emso, v.id_stud_leto
            FROM oseba AS o 
            JOIN kandidat AS k ON k.id_oseba = o.id_oseba
            JOIN program AS p ON k.id_program = p.id_program
            JOIN studijsko_leto AS s ON k.id_stud_leto = s.id_stud_leto
            JOIN student AS st ON o.ID_OSEBA = st.ID_OSEBA
            JOIN vpis AS v ON p.ID_PROGRAM = v.ID_PROGRAM
            WHERE o.ID_OSEBA = :id_oseba
        ");

        $statement->bindValue(":id_oseba", $id_oseba);
        $statement->execute();
        $result = $statement->fetch();
        return $result;
    }

    public static function getStudentNaslov($id_oseba){
        $db = DBInit::getInstance();

        $statement = $db -> prepare("
            SELECT n.ULICA, n.HISNA_STEVILKA, n.JE_ZAVROCANJE, n.JE_STALNI, p.ST_POSTA, p.KRAJ, d.TRIMESTNAKODA, d.ISONAZIV, d.SLOVENSKINAZIV
            FROM naslov AS n
            JOIN posta AS p ON n.ID_POSTA = p.ID_POSTA
            JOIN drzava AS d ON n.ID_DRZAVA = d.ID_DRZAVA
            JOIN oseba AS o ON n.ID_OSEBA = o.ID_OSEBA
            WHERE o.ID_OSEBA = :id_oseba
        ");

        $statement->bindValue(":id_oseba", $id_oseba);
        $statement->execute();
        $result = $statement->fetch();
        return $result;
    }


    public static function getObvezniPredmeti($id_oseba, $id_stud_leto){
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT p.ID_PREDMET, p.IME_PREDMET, p. dp.NAZIV_DELAPREDMETNIKA, p.ST_KREDITNIH_TOCK
            FROM oseba AS o
            JOIN zeton AS z ON o.ID_OSEBA = z.ID_OSEBA
            JOIN program AS pro ON z.ID_PROGRAM = pro.ID_PROGRAM
            JOIN predmetnik AS pk ON pro.ID_PROGRAM = pk.ID_PROGRAM
            JOIN predmet AS p ON p.ID_PREDMET = pk.ID_PREDMET
            JOIN del_predmetnika AS dp ON pk.ID_DELPREDMETNIKA = dp.ID_DELPREDMETNIKA
            WHERE o.ID_OSEBA = :id_oseba
            AND z.ID_STUD_LETO = :id_stud_leto
            AND z.ID_LETNIK = pk.ID_LETNIK
            AND dp.TIP = 'o'
        ");

        $statement->bindValue(":id_oseba", $id_oseba);
        $statement->bindValue(":id_stud_leto", $id_stud_leto);
        $statement->execute();
        $result = $statement->fetch();
        return $result;
    }

    public static function getSplosniIzbirniPredmeti($id_oseba, $id_stud_leto){

        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT p.ID_PREDMET, p.IME_PREDMET, dp.NAZIV_DELAPREDMETNIKA, p.ST_KREDITNIH_TOCK
            FROM oseba AS o
            JOIN zeton AS z ON o.ID_OSEBA = z.ID_OSEBA
            JOIN program AS pro ON z.ID_PROGRAM = pro.ID_PROGRAM
            JOIN predmetnik AS pk ON pro.ID_PROGRAM = pk.ID_PROGRAM
            JOIN predmet AS p ON p.ID_PREDMET = pk.ID_PREDMET
            JOIN del_predmetnika AS dp ON pk.ID_DELPREDMETNIKA = dp.ID_DELPREDMETNIKA
            WHERE o.ID_OSEBA = :id_oseba
            AND z.ID_STUD_LETO = :id_stud_leto
            AND z.ID_LETNIK = pk.ID_LETNIK
            AND dp.TIP = 'sp'
        ");

        $statement->bindValue(":id_oseba", $id_oseba);
        $statement->bindValue(":id_stud_leto", $id_stud_leto);
        $statement->execute();
        $result = $statement->fetch();
        return $result;
    }

    public static function getStrokovniIzbirniPredmeti($id_oseba, $id_stud_leto){

        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT p.ID_PREDMET, p.IME_PREDMET, dp.NAZIV_DELAPREDMETNIKA, p.ST_KREDITNIH_TOCK
            FROM oseba AS o
            JOIN zeton AS z ON o.ID_OSEBA = z.ID_OSEBA
            JOIN program AS pro ON z.ID_PROGRAM = pro.ID_PROGRAM
            JOIN predmetnik AS pk ON pro.ID_PROGRAM = pk.ID_PROGRAM
            JOIN predmet AS p ON p.ID_PREDMET = pk.ID_PREDMET
            JOIN del_predmetnika AS dp ON pk.ID_DELPREDMETNIKA = dp.ID_DELPREDMETNIKA
            WHERE o.ID_OSEBA = :id_oseba
            AND z.ID_STUD_LETO = :id_stud_leto
            AND z.ID_LETNIK = pk.ID_LETNIK
            AND dp.TIP = 'st'
        ");

        $statement->bindValue(":id_oseba", $id_oseba);
        $statement->bindValue(":id_stud_leto", $id_stud_leto);
        $statement->execute();
        $result = $statement->fetch();
        return $result;
    }

    public static function getModuliInPredmeti($id_oseba, $id_stud_leto){

        $db = DBInit::getInstance();

        $statement = $db -> prepare("
            SELECT p.ID_PREDMET, p.IME_PREDMET, p.ST_KREDITNIH_TOCK, dp.ID_DELPREDMETNIKA, dp.NAZIV_DELAPREDMETNIKA, dp.SKUPNOSTEVILOKT
            FROM oseba AS o
            JOIN zeton AS z ON o.ID_OSEBA = z.ID_OSEBA
            JOIN program AS pro ON z.ID_PROGRAM = pro.ID_PROGRAM
            JOIN predmetnik AS pk ON pro.ID_PROGRAM = pk.ID_PROGRAM
            JOIN predmet AS p ON p.ID_PREDMET = pk.ID_PREDMET
            JOIN del_predmetnika AS dp ON pk.ID_DELPREDMETNIKA = dp.ID_DELPREDMETNIKA
            WHERE o.ID_OSEBA = :id_oseba
            AND z.ID_STUD_LETO = :id_stud_leto
            AND z.ID_LETNIK = pk.ID_LETNIK
            AND dp.TIP = 'm'
            AND dp.AKTIVNOST = 1
            AND p.AKTIVNOST = 1
        ");

        $statement->bindValue(":id_oseba", $id_oseba);
        $statement->bindValue(":id_stud_leto", $id_stud_leto);
        $statement->execute();
        $result = $statement->fetch();
        return $result;
    }

    public static function getModuliBrezPredmetov($id_oseba, $id_stud_leto){

        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT DISTINCT dp.ID_DELPREDMETNIKA, dp.NAZIV_DELAPREDMETNIKA, dp.SKUPNOSTEVILOKT
            FROM oseba AS o
            JOIN zeton AS z ON o.ID_OSEBA = z.ID_OSEBA
            JOIN program AS pro ON z.ID_PROGRAM = pro.ID_PROGRAM
            JOIN predmetnik AS pk ON pro.ID_PROGRAM = pk.ID_PROGRAM
            JOIN predmet AS p ON p.ID_PREDMET = pk.ID_PREDMET
            JOIN del_predmetnika AS dp ON pk.ID_DELPREDMETNIKA = dp.ID_DELPREDMETNIKA
            WHERE o.ID_OSEBA = :id_oseba
            AND z.ID_STUD_LETO = :id_stud_leto
            AND dp.TIP = 'm'
            AND dp.AKTIVNOST = 1
            AND p.AKTIVNOST = 1
        ");

        $statement->bindValue(":id_oseba", $id_oseba);
        $statement->bindValue(":id_stud_leto", $id_stud_leto);
        $statement->execute();
        $result = $statement->fetch();
        return $result;
    }

    public static function setTelefon($id_oseba, $telefon){

        $db = DBInit::getInstance();

        $statement = $db->prepare("
            UPDATE OSEBA
            SET TELEFONSKA_STEVILKA = :telefonska_stevilka
            WHERE ID_OSEBA = :id_oseba
        ");

        $statement->bindValue(":telefonska_stevilka", $telefon);
        $statement->bindValue(":id_oseba", $id_oseba);
        $statement->execute();
    }

    public static function setEmso($id_oseba, $emso){
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            UPDATE STUDENT
            SET EMSO = :emso
            WHERE ID_OSEBA = :id_oseba
        ");

        $statement->bindValue(":emso", $emso);
        $statement->bindValue(":id_oseba", $id_oseba);
        $statement->execute();
    }

    public static function setNaslov($id_oseba, $data){

        $db = DBInit::getInstance();

        $statement = $db -> prepare("
            INSERT INTO `naslov` (`id_posta`, `id_drzava`, `id_oseba`, `je_zavrocanje`, `je_stalni`, `ulica`, `hisna_stevilka`)
            VALUES (:id_posta, :id_drzava, :id_oseba, :je_zavrocanje, :je_stalni, :ulica, :hisna_stevilka)
        ");

        $statement->bindValue(":id_posta", $data['id_posta']);
        $statement->bindValue(":id_drzava", $data['id_drzava']);
        $statement->bindValue(":id_oseba", $id_oseba);
        $statement->bindValue(":je_zavrocanje", $data['je_zavrocanje']);
        $statement->bindValue(":je_stalni", $data['je_stalni']);
        $statement->bindValue(":ulica", $data['ulica']);
        $statement->bindValue(":hisna_stevilka", $data['hisna_stevilka']);
        $statement->execute();
    }

    public static function potrdiVpisStudent($id_oseba){
        $db = DBInit::getInstance();

        // Set zeton izkoriscen to 1
        $statement = $db -> prepare("
            UPDATE ZETON
            SET IZKORISCEN = 1
            WHERE ID_OSEBA = :id_oseba
            AND IZKORISCEN = 0
            AND AKTIVNOST = 1
        ");

        $statement->bindValue(":id_oseba", $id_oseba);
        $statement->execute();

        $studentData = self::getStudentPodatki($id_oseba);

        // Create vpis --> Potrjenost_vpisa == 0 --> Potrdi ga sele referent!
        $statement = $db -> prepare("
            INSERT INTO `vpis`(`id_program`, `id_nacin`, `id_stud_leto`, `id_vrstavpisa`, `id_oblika`, `id_letnik`, `potrjenost_vpisa`, `vpisna_stevilka`)
            VALUES (:id_program, :id_nacin, :id_stud_leto, :id_vrstavpisa, :id_oblika, :id_letnik, 0, :vpisna_stevilka)
        ");

        $statement->bindValue(":id_program", $studentData['id_program']);
        $statement->bindValue(":id_nacin", $studentData['id_nacin']);
        $statement->bindValue(":id_stud_leto", $studentData['id_stud_leto']);
        $statement->bindValue(":id_vrstavpisa", $studentData['id_vrstavpisa']);
        $statement->bindValue(":id_oblika", $studentData['id_oblika']);
        $statement->bindValue(":id_letnik", $studentData['id_letnik']);
        $statement->bindValue(":vpisna_stevilka", $studentData['vpisna_stevilka']);
        $statement->execute();
    }

    public static function getAllStudentsNepotrjenVpis(){
        $db = DBInit::getInstance();

        $statement = $db -> prepare("
            SELECT DISTINCT o.ime, o.priimek, o.email, o.telefonska_stevilka, p.naziv_program, p.sifra_evs, p.id_program,
                    p.st_semestrov, s.stud_leto, st.vpisna_stevilka, st.emso, s.id_stud_leto, v.id_vpis
            FROM oseba AS o 
            JOIN student AS st ON st.id_oseba = o.id_oseba
            JOIN program AS p ON st.id_program = p.id_program
            JOIN vpis AS v ON st.VPISNA_STEVILKA = v.VPISNA_STEVILKA
            JOIN studijsko_leto AS s ON v.id_stud_leto = s.id_stud_leto
            JOIN zeton AS z ON o.ID_OSEBA = z.ID_OSEBA
            AND z.IZKORISCEN = 1
            AND z.AKTIVNOST = 1
            AND v.POTRJENOST_VPISA = 0
        ");

        $statement->execute();
        $result = $statement->fetchAll();

        return $result;
    }

    public static function getVpisId($id_oseba){
        $db = DBInit::getInstance();

        $statement = $db -> prepare("
            SELECT v.ID_VPIS
            FROM vpis AS v
            JOIN student AS s ON v.ID_VPIS = s.ID_VPIS
            JOIN oseba AS o ON o.ID_OSEBA = s.ID_OSEBA
            JOIN zeton AS z ON z.ID_OSEBA = o.ID_OSEBA 
            WHERE o.ID_OSEBA = :id_oseba
            AND v.ID_STUD_LETO = z.ID_STUD_LETO
            AND v.ID_LETNIK = z.ID_LETNIK
            AND v.POTRJENOST_VPISA = 0
            AND z.IZKORISCEN = 1
            AND z.AKTIVNOST = 1
        ");

        $statement->bindValue(":id_oseba", $id_oseba);
        $statement->execute();
        $result = $statement->fetch();

        return $result['id_vpis'];
    }

    public static function getLastNeIzkoriscenZeton($id_oseba){
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT *
            FROM zeton AS z
            WHERE z.ID_OSEBA = :id_oseba
            AND z.IZKORISCEN = 0
            AND z.AKTIVNOST = 1
        ");

        $statement->bindValue(":id_oseba", $id_oseba);
        $statement->execute();
        $result = $statement->fetch();
        return $result;
    }
    
    public static function setZetonToIzkoriscen($id_zeton){
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            UPDATE zeton
            SET IZKORISCEN = 1
            WHERE ID_ZETON = :id_zeton
        ");

        $statement->bindValue(":id_zeton", $id_zeton);
        $statement->execute();
    }

    public static function getIzkoriscenAktivenZeton($id_oseba){

        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT z.id_zeton
            FROM zeton AS z
            WHERE z.ID_OSEBA = :id_oseba
            AND z.IZKORISCEN = 1
            AND z.AKTIVNOST = 1
        ");

        $statement->bindValue(":id_oseba", $id_oseba);
        $statement->execute();
        $result = $statement->fetch();
        return $result['id_zeton'];

    }

    public static function potrdiVpisReferent($id_oseba){
        $db = DBInit::getInstance();

        // Set vpis.potrjenost_vpisa to 1
        $id_vpis = self::getVpisId($id_oseba);
        $statement = $db -> prepare("
            UPDATE vpis
            SET potrjenost_vpisa = 1
            WHERE id_vpis = :id_vpis
        ");
        $statement->bindValue(":id_vpis", $id_vpis);
        $statement->execute();

        // Set zeton.aktivnost to 0 (zeton.izkoriscen je ze setiran na 0, ko student potrdi vpis)
            // KO REFERENT POTRDI VPIS, JE AKTIVNOST ZETON == 0 !
        $id_zeton = self::getIzkoriscenAktivenZeton($id_oseba);
        $statement = $db -> prepare("
            UPDATE zeton
            SET aktivnost = 0
            WHERE id_zeton = :id_zeton
        ");
        $statement->bindValue(":id_zeton", $id_zeton);
        $statement->execute();

        // Create new student
        $studentData = self::getStudentPodatki($id_oseba);
        $statement = $db -> prepare("
            INSERT INTO `student` (`vpisna_stevilka`, `id_oseba`, `id_vpis`, `emso`, `id_program`)
            VALUES (:vpisna_stevilka, :id_oseba, :id_vpis, :emso, :id_program)
        ");

        $statement->bindValue(":vpisna_stevilka", $studentData['vpisna_stevilka']);
        $statement->bindValue(":id_oseba", $id_oseba);
        $statement->bindValue(":id_vpis", $id_vpis);
        $statement->bindValue(":emso", $studentData['emso']);
        $statement->bindValue(":id_program", $studentData['id_program']);
        $statement->execute();
    }

    public static function getStudentPodatki($id_oseba){
        $db = DBInit::getInstance();

        $statement = $db -> prepare("
            SELECT o.ime, o.priimek, o.email, o.uporabnisko_ime, o.telefonska_stevilka, p.naziv_program, p.sifra_evs, p.id_program,
                    p.st_semestrov, sl.stud_leto, s.vpisna_stevilka, s.emso, v.id_stud_leto, v.ID_VRSTAVPISA, v.ID_OBLIKA, v.ID_LETNIK, v.ID_NACIN
            FROM oseba AS o 
            JOIN student AS s ON s.ID_OSEBA = o.ID_OSEBA
            JOIN vpis AS v ON v.VPISNA_STEVILKA = s.VPISNA_STEVILKA
            JOIN program AS p ON v.ID_PROGRAM = p.ID_PROGRAM
            JOIN studijsko_leto AS sl ON v.ID_STUD_LETO = sl.ID_STUD_LETO
            WHERE o.ID_OSEBA = :id_oseba
        ");

        $statement->bindValue(":id_oseba", $id_oseba);
        $statement->execute();
        $result = $statement->fetch();
        return $result;
    }

    public static function getAllStudents($id){
        $db = DBInit::getInstance();

        $statement = $db->prepare("
                SELECT DISTINCT *
FROM  STUDENT s, OSEBA o, VPIS v
WHERE s.ID_OSEBA = o.ID_OSEBA and s.ID_OSEBA = :id
      and v.VPISNA_STEVILKA = s.VPISNA_STEVILKA ORDER BY v.ID_STUD_LETO DESC LIMIT 1");
        $statement->bindParam(":id", $id);

        $statement->execute();

        return $statement->fetchAll();

    }


}