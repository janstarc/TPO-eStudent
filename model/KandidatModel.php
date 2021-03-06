<?php

class KandidatModel {

    // email --> kandidat_id
    public static function getKandidatIdWithEmail($email){
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT k.ID_KANDIDAT
            FROM kandidat AS k
            JOIN oseba AS o ON k.ID_OSEBA = o.ID_OSEBA
            WHERE o.EMAIL = :email
        ");

        $statement->bindValue(":email", $email);
        $statement->execute();
        $result = $statement->fetch();
        return $result["ID_KANDIDAT"];
    }
    public static function izkoristiZeton($id){
        $db = DBInit::getInstance();

        $statement = $db->prepare("
           SELECT z.ID_ZETON FROM kandidat k
JOIN zeton z on k.ID_OSEBA = z.ID_OSEBA
WHERE k.ID_OSEBA = :id
ORDER BY z.ID_STUD_LETO DESC LIMIT 1
        ");

        $statement->bindValue(":id", $id);
        $statement->execute();
        $result = $statement->fetchColumn();

        $db = DBInit::getInstance();

        $statement = $db->prepare("
         UPDATE zeton SET IZKORISCEN = 1 WHERE ID_ZETON = :rez
        ");

        $statement->bindValue(":rez", $result);
        $statement->execute();

        return TRUE;
    }
    
    // id_oseba --> kandidat_id
    public static function getKandidatIdWithUserId($id_oseba){
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT ID_KANDIDAT
            FROM kandidat
            WHERE ID_OSEBA = :id_oseba
        ");

        $statement->bindValue(":id_oseba", $id_oseba);
        $statement->execute();
        $result = $statement->fetch();
        return $result["ID_KANDIDAT"];
    }

    public static function getZetonPodatki($id_oseba){
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT *
            FROM zeton
            JOIN studijsko_leto l ON zeton.ID_STUD_LETO = l.ID_STUD_LETO
            WHERE ID_OSEBA = :id_oseba
            ORDER BY zeton.ID_STUD_LETO DESC LIMIT 1
        ");

        $statement->bindValue(":id_oseba", $id_oseba);
        $statement->execute();

        return $statement->fetch();
    }

    // id_stud_leto --> studijsko_leto
    public static function getStudijskoLeto($id_stud_leto){
        $db = DBInit::getInstance();

        $statement = $db ->prepare("
            SELECT STUD_LETO, ID_STUD_LETO
            FROM studijsko_leto AS s
            WHERE s.ID_STUD_LETO = :id_stud_leto
        ");

        $statement->bindValue(":id_stud_leto", $id_stud_leto);
        $statement->execute();
        $result = $statement->fetch();
        return $result;
    }

    // id_kandidat --> id_oseba
    public static function getOsebaIdWithKandidatId($id_kandidat){
        $db = DBInit::getInstance();

        $statement = $db ->prepare("
            SELECT o.ID_OSEBA
            FROM kandidat AS k
            JOIN oseba AS o ON k.ID_OSEBA = o.ID_OSEBA
            WHERE k.ID_KANDIDAT = :id_kandidat
        ");

        $statement->bindValue(":id_kandidat", $id_kandidat);
        $statement->execute();
        $result = $statement->fetch();
        return $result["ID_OSEBA"];
    }

    // id_kandidat --> Ime, priimek, email, telefon, program, stud_leto, vpisna, emso, naslov, hisna stevilka, je_stalni, je_zavrocanje
    public static function getKandidatPodatki($id_kandidat){
        $db = DBInit::getInstance();

        $statement = $db -> prepare("
            SELECT o.id_oseba, o.ime, o.priimek, o.email,o.uporabnisko_ime, o.telefonska_stevilka, o.DATUM_ROJSTVA, p.naziv_program, p.sifra_evs, p.id_program, p.st_semestrov, s.stud_leto, k.vpisna_stevilka, k.emso, k.id_stud_leto, k.ID_KANDIDAT,v3.OPIS_VPISA, l.LETNIK, n.OPIS_NACIN, o2.NAZIV_OBLIKA
            FROM oseba AS o 
            JOIN kandidat AS k ON k.id_oseba = o.id_oseba
            JOIN program AS p ON k.id_program = p.id_program
            JOIN studijsko_leto AS s ON k.id_stud_leto = s.id_stud_leto
            JOIN vpis v ON p.ID_PROGRAM = v.ID_PROGRAM
            JOIN vrsta_vpisa v3 ON v.ID_VRSTAVPISA = v3.ID_VRSTAVPISA
            JOIN letnik l ON v.ID_LETNIK = l.ID_LETNIK
            JOIN nacin_studija n ON v.ID_NACIN = n.ID_NACIN
            JOIN oblika_studija o2 ON v.ID_OBLIKA = o2.ID_OBLIKA
            WHERE k.id_kandidat = :id_kandidat
        ");

        $statement->bindValue(":id_kandidat", $id_kandidat);
        $statement->execute();
        $result = $statement->fetch();
        return $result;
    }

    public static function getStudentPodatki($id_oseba){

        $db = DBInit::getInstance();

        $statement = $db -> prepare("
            SELECT o.ime, o.priimek, o.email, o.uporabnisko_ime, o.telefonska_stevilka, o.DATUM_ROJSTVA, p.naziv_program, p.sifra_evs, p.id_program,
  p.st_semestrov, sl.stud_leto, s.vpisna_stevilka, s.emso, v.id_stud_leto, v.ID_VRSTAVPISA, v.ID_OBLIKA, v.ID_LETNIK, v.ID_NACIN,
  o2.NAZIV_OBLIKA,n.OPIS_NACIN,v3.OPIS_VPISA,l.LETNIK
FROM oseba AS o
  JOIN student AS s ON s.ID_OSEBA = o.ID_OSEBA
  JOIN zeton v ON s.ID_OSEBA = v.ID_OSEBA

  JOIN program AS p ON v.ID_PROGRAM = p.ID_PROGRAM
  JOIN studijsko_leto AS sl ON v.ID_STUD_LETO = sl.ID_STUD_LETO
  JOIN oblika_studija o2 ON v.ID_OBLIKA = o2.ID_OBLIKA
  JOIN nacin_studija n ON v.ID_NACIN = n.ID_NACIN
  JOIN vrsta_vpisa v3 ON v.ID_VRSTAVPISA = v3.ID_VRSTAVPISA
  JOIN letnik l ON v.ID_LETNIK = l.ID_LETNIK
  JOIN vpis v2 ON v2.VPISNA_STEVILKA = s.VPISNA_STEVILKA
WHERE o.ID_OSEBA = :id_oseba
ORDER BY v.ID_LETNIK DESC  LIMIT 1
        ");

        $statement->bindValue(":id_oseba", $id_oseba);
        $statement->execute();
        $result = $statement->fetch();
        return $result;
    }


    /*
    public static function getKandidatNaslov($id_kandidat){
        $db = DBInit::getInstance();

        $statement = $db -> prepare("
            SELECT n.ID_NASLOV, n.ULICA, n.HISNA_STEVILKA, n.JE_ZAVROCANJE, n.JE_STALNI, p.ST_POSTA, p.KRAJ, d.TRIMESTNAKODA, d.ISONAZIV, d.SLOVENSKINAZIV
            FROM naslov AS n
            JOIN posta AS p ON n.ID_POSTA = p.ID_POSTA
            JOIN drzava AS d ON n.ID_DRZAVA = d.ID_DRZAVA
            JOIN oseba AS o ON n.ID_OSEBA = o.ID_OSEBA
            JOIN kandidat AS k ON k.ID_OSEBA = o.ID_OSEBA
            WHERE k.ID_KANDIDAT = :id_kandidat
        ");

        $statement->bindValue(":id_kandidat", $id_kandidat);
        $statement->execute();
        $result = $statement->fetch();
        return $result;
    }
    */
    
    /*
    public static function getKandidatVseNaslove($id_oseba){
        $db = DBInit::getInstance();

        $statement = $db -> prepare("
            SELECT n.ID_NASLOV, n.ID_DRZAVA, n.ID_POSTA, n.ID_OBCINA, n.ULICA, n.JE_ZAVROCANJE, n.JE_STALNI, d.TRIMESTNAKODA, d.ISONAZIV, d.SLOVENSKINAZIV
            FROM naslov AS n
            JOIN drzava AS d ON n.ID_DRZAVA = d.ID_DRZAVA
            JOIN oseba AS o ON n.ID_OSEBA = o.ID_OSEBA
            JOIN kandidat AS k ON k.ID_OSEBA = o.ID_OSEBA
            WHERE o.ID_OSEBA = :id_oseba
        ");

        $statement->bindValue(":id_oseba", $id_oseba);
        $statement->execute();
        $result = $statement->fetchAll();
        return $result;
    }
    */
    public static function getKandidatVseNaslove($id_oseba){
        $db = DBInit::getInstance();

        $statement = $db -> prepare("
           SELECT n.ID_NASLOV, n.ID_DRZAVA, n.ID_POSTA, n.ID_OBCINA, n.ULICA, n.JE_ZAVROCANJE, n.JE_STALNI
FROM naslov AS n
  JOIN oseba AS o ON n.ID_OSEBA = o.ID_OSEBA
WHERE o.ID_OSEBA = :id_oseba
        ");

        $statement->bindValue(":id_oseba", $id_oseba);
        $statement->execute();
        $result = $statement->fetchAll();
        return $result;
    }

    public static function getStudentVseNaslove($id_oseba){
        $db = DBInit::getInstance();

        $statement = $db -> prepare("
            SELECT n.ID_NASLOV, n.ID_DRZAVA, n.ID_POSTA, n.ID_OBCINA, n.ULICA, n.JE_ZAVROCANJE, n.JE_STALNI
            FROM naslov AS n
            JOIN oseba AS o ON n.ID_OSEBA = o.ID_OSEBA
            JOIN student AS s ON s.ID_OSEBA = o.ID_OSEBA
            WHERE o.ID_OSEBA = :id_oseba
        ");

        $statement->bindValue(":id_oseba", $id_oseba);
        $statement->execute();
        $result = $statement->fetchAll();
        return $result;
    }
    
    public static function getOsebaVseNaslove($id_oseba){
        $db = DBInit::getInstance();

        $statement = $db -> prepare("
            SELECT n.ID_NASLOV, n.ID_DRZAVA, n.ID_POSTA, n.ULICA, n.JE_ZAVROCANJE, n.JE_STALNI, p.ST_POSTA, p.KRAJ, d.TRIMESTNAKODA, d.ISONAZIV, d.SLOVENSKINAZIV
            FROM naslov AS n
            JOIN posta AS p ON n.ID_POSTA = p.ID_POSTA
            JOIN drzava AS d ON n.ID_DRZAVA = d.ID_DRZAVA
            JOIN oseba AS o ON n.ID_OSEBA = o.ID_OSEBA
            WHERE o.ID_OSEBA = :id_oseba
        ");

        $statement->bindValue(":id_oseba", $id_oseba);
        $statement->execute();
        $result = $statement->fetchAll();
        return $result;
    }

    public static function getKandidatPredmetnik($id_kandidat, $id_stud_leto){
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT p.ID_PREDMET, p.IME_PREDMET, dp.NAZIV_DELAPREDMETNIKA
            FROM kandidat AS k 
            JOIN program AS pro ON k.ID_PROGRAM = pro.ID_PROGRAM
            JOIN predmetnik AS pk ON pro.ID_PROGRAM = pk.ID_PROGRAM
            JOIN predmet AS p ON p.ID_PREDMET = pk.ID_PREDMET
            JOIN del_predmetnika AS dp ON pk.ID_DELPREDMETNIKA = dp.ID_DELPREDMETNIKA
            WHERE k.ID_KANDIDAT = :id_kandidat
            AND pk.ID_STUD_LETO = :id_stud_leto
        ");

        $statement->bindValue(":id_kandidat", $id_kandidat);
        $statement->bindValue(":id_stud_leto", $id_stud_leto);
        $statement->execute();
        $result = $statement->fetch();
        return $result;
    }

    public static function updateImeInPriimek($id_kandidat, $ime, $priimek){

        $id_oseba = self::getOsebaIdWithKandidatId($id_kandidat);
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            UPDATE OSEBA
            SET IME = :ime, PRIIMEK = :priimek
            WHERE ID_OSEBA = :id_oseba
        ");

        $statement->bindValue(":ime", $ime);
        $statement->bindValue(":priimek", $priimek);
        $statement->bindValue(":id_oseba", $id_oseba);

        $statement->execute();
    }

    public static function updateTelefon($id_kandidat, $telefon, $DATUM_ROJSTVA){
        $id_oseba = self::getOsebaIdWithKandidatId($id_kandidat);
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            UPDATE OSEBA
            SET TELEFONSKA_STEVILKA = :telefonska_stevilka, DATUM_ROJSTVA = :DATUM_ROJSTVA
            WHERE ID_OSEBA = :oseba_id
        ");

        $statement->bindValue(":telefonska_stevilka", $telefon);
        $statement->bindValue(":DATUM_ROJSTVA", $DATUM_ROJSTVA);
        $statement->bindValue(":oseba_id", $id_oseba);
        $statement->execute();
    }

    public static function updateEmso($id_kandidat, $emso){
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            UPDATE KANDIDAT
            SET EMSO = :emso
            WHERE ID_KANDIDAT = :id_kandidat
        ");

        $statement->bindValue(":emso", $emso);
        $statement->bindValue(":id_kandidat", $id_kandidat);
        $statement->execute();
    }
    
    public static function updateOsebaEmsoInTelefon($id_oseba, $emso, $telefon, $DATUM_ROJSTVA){
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            UPDATE OSEBA
            SET TELEFONSKA_STEVILKA = :telefonska_stevilka, DATUM_ROJSTVA = :DATUM_ROJSTVA
            WHERE ID_OSEBA = :oseba_id
        ");
        $statement->bindValue(":telefonska_stevilka", $telefon);
        $statement->bindValue(":DATUM_ROJSTVA", $DATUM_ROJSTVA);
        $statement->bindValue(":oseba_id", $id_oseba);
        $statement->execute();
        
        $statement = $db->prepare("
            UPDATE STUDENT
            SET EMSO = :emso
            WHERE ID_OSEBA = :oseba_id
        ");
        $statement->bindValue(":emso", $emso);
        $statement->bindValue(":oseba_id", $id_oseba);
        $statement->execute();
    }

    public static function updateNaslov($id_naslov, $value){
        $db = DBInit::getInstance();

        $statement = $db -> prepare("
            UPDATE naslov
            SET id_drzava = :id_drzava, ulica = :ulica, id_posta = :id_posta, id_obcina = :id_obcina, je_zavrocanje = :je_zavrocanje
            WHERE ID_NASLOV = :id_naslov
        ");
        $statement->bindValue(":id_drzava", $value['id_drzava']);
        $statement->bindValue(":ulica", $value['ulica']);
        $statement->bindValue(":id_posta", $value['id_posta']);
        $statement->bindValue(":id_obcina", $value['id_obcina']);
        $statement->bindValue(":je_zavrocanje", $value['je_zavrocanje']);
        $statement->bindValue(":id_naslov", $id_naslov);
        $statement->execute();
    }

    public static function updateNaslovi($id_kandidat, $data){
        $id_oseba = self::getOsebaIdWithKandidatId($id_kandidat);
        $db = DBInit::getInstance();

        foreach ($data as $key => $value)
        $statement = $db -> prepare("
            UPDATE naslov
            SET id_posta = :id_posta, id_drzava = :id_drzava, id_oseba = :id_oseba, je_zavrocanje = :je_zavrocanje, je_stalni = :je_stalni, ulica = :ulica
            WHERE ID_NASLOV = :id_naslov
        ");

        $statement->bindValue(":id_posta", $value['id_posta']);
        $statement->bindValue(":id_drzava", $value['id_drzava']);
        $statement->bindValue(":id_oseba", $id_oseba);
        $statement->bindValue(":je_zavrocanje", $value['je_zavrocanje']);
        $statement->bindValue(":je_stalni", $value['je_stalni']);
        $statement->bindValue(":ulica", $value['ulica']);
        $statement->bindValue(":id_naslov", $value['id_naslov']);
        $statement->execute();
    }



    // Izbira vsega iz dropdown menijev --> Input je $data array, z id-ji
    public static function insertNaslov($id_kandidat, $data){
        $id_oseba = self::getOsebaIdWithKandidatId($id_kandidat);
        $db = DBInit::getInstance();

        $statement = $db -> prepare("
            INSERT INTO `naslov` (`id_posta`, `id_drzava`, `id_obcina`, `id_oseba`, `je_zavrocanje`, `je_stalni`, `ulica`)
            VALUES (:id_posta, :id_drzava, :id_obcina, :id_oseba, :je_zavrocanje, :je_stalni, :ulica)
        ");

        $statement->bindValue(":id_oseba", $id_oseba);
        $statement->bindValue(":id_drzava", $data['id_drzava']);
        $statement->bindValue(":id_posta", $data['id_posta']);
        $statement->bindValue(":id_obcina", $data['id_obcina']);
        $statement->bindValue(":je_zavrocanje", $data['je_zavrocanje']);
        $statement->bindValue(":je_stalni", $data['je_stalni']);
        $statement->bindValue(":ulica", $data['ulica']);
        $statement->execute();
    }

    public static function potrdiVpisKandidat($id_kandidat){
        $db = DBInit::getInstance();

        // Set izkoriscen to 1
        $statement = $db -> prepare("
            UPDATE KANDIDAT
            SET IZKORISCEN = 1
            WHERE ID_KANDIDAT = :id_kandidat
        ");

        $statement->bindValue(":id_kandidat", $id_kandidat);
        $statement->execute();

        $kandidatData = self::getKandidatPodatki($id_kandidat);

        // Create vpis
        $statement = $db -> prepare("
            INSERT INTO `vpis`(`id_program`, `id_nacin`, `id_stud_leto`, `id_vrstavpisa`, `id_oblika`, `id_letnik`, `potrjenost_vpisa`, `vpisna_stevilka`)
            VALUES (:id_program, 1, :id_stud_leto, 1, 1, 1, 0, :vpisna_stevilka)
        ");

        $statement->bindValue(":id_program", $kandidatData['id_program']);
        $statement->bindValue(":id_stud_leto", $kandidatData['id_stud_leto']);
        $statement->bindValue(":vpisna_stevilka", $kandidatData['vpisna_stevilka']);
        $statement->execute();
    }
    
    public static function potrdiVpisStudent($vpisna_stevilka, $zeton){
        $db = DBInit::getInstance();

        $statement = $db -> prepare("
            INSERT INTO `vpis`(`id_program`, `id_nacin`, `id_stud_leto`, `id_vrstavpisa`, `id_oblika`, `id_letnik`, `potrjenost_vpisa`, `vpisna_stevilka`)
            VALUES (:id_program, :id_nacin, :id_stud_leto, :id_vrstavpisa, :id_oblika, :id_letnik, 0, :vpisna_stevilka)
        ");
        $statement->bindValue(":id_program", $zeton['ID_PROGRAM']);
        $statement->bindValue(":id_nacin", $zeton['ID_NACIN']);
        $statement->bindValue(":id_stud_leto", $zeton['ID_STUD_LETO']);
        $statement->bindValue(":id_vrstavpisa", $zeton['ID_VRSTAVPISA']);
        $statement->bindValue(":id_oblika", $zeton['ID_OBLIKA']);
        $statement->bindValue(":id_letnik", $zeton['ID_LETNIK']);
        $statement->bindValue(":vpisna_stevilka", $vpisna_stevilka);
        $statement->execute();
    }
    
    public static function jeVpisniListZeOddan($id_oseba){
        $db = DBInit::getInstance();

        $statement = $db ->prepare("
            SELECT IZKORISCEN
            FROM kandidat AS k
            WHERE ID_OSEBA = :id_oseba
        ");

        $statement->bindValue(":id_oseba", $id_oseba);
        $statement->execute();
        $result = $statement->fetch();
        return $result["IZKORISCEN"]==1;
    }
    
    public static function getAllCandidates(){
        $db = DBInit::getInstance();

        $statement = $db -> prepare("
            SELECT o.ime, o.priimek, o.email, o.telefonska_stevilka, o.id_oseba, p.naziv_program, p.sifra_evs, p.id_program,
                       p.st_semestrov, s.stud_leto, k.vpisna_stevilka, k.emso, k.id_stud_leto, k.id_kandidat, v.id_vpis
            FROM oseba AS o 
            JOIN kandidat AS k ON k.id_oseba = o.id_oseba
            JOIN program AS p ON k.id_program = p.id_program
            JOIN studijsko_leto AS s ON k.id_stud_leto = s.id_stud_leto
            JOIN vpis AS v ON k.VPISNA_STEVILKA = v.VPISNA_STEVILKA
            AND k.IZKORISCEN = 1
            AND v.POTRJENOST_VPISA = 0
            WHERE o.VRSTA_VLOGE = 'k'
        ");

        $statement->execute();
        $result = $statement->fetchAll();

        return $result;
    }
    
    public static function getAllNepotrjeniStudenti(){
        $db = DBInit::getInstance();

        $statement = $db -> prepare("
            SELECT o.ime, o.priimek, o.id_oseba, v.vpisna_stevilka
            FROM vpis AS v
            JOIN student AS s ON v.VPISNA_STEVILKA = s.VPISNA_STEVILKA
            JOIN oseba AS o ON s.ID_OSEBA = o.ID_OSEBA
            WHERE v.POTRJENOST_VPISA = 0
        ");

        $statement->execute();
        $result = $statement->fetchAll();

        return $result;
    }

    public static function getAllVpisaniStudenti($id_stud_leto){
        $db = DBInit::getInstance();

        $statement = $db -> prepare("
            SELECT o.id_oseba, o.ime, o.priimek, o.email, o.telefonska_stevilka, p.naziv_program, p.sifra_evs, p.id_program,
                    p.st_semestrov, s.stud_leto, st.vpisna_stevilka, st.emso, v.id_stud_leto, v.id_vpis, v.ID_LETNIK
            FROM oseba AS o 
            JOIN kandidat AS k ON k.id_oseba = o.id_oseba
            JOIN program AS p ON k.id_program = p.id_program
            JOIN studijsko_leto AS s ON k.id_stud_leto = s.id_stud_leto
            JOIN student AS st ON st.ID_OSEBA = o.ID_OSEBA
            JOIN vpis AS v ON k.VPISNA_STEVILKA = v.VPISNA_STEVILKA
            WHERE v.ID_STUD_LETO = :id_stud_leto
        ");

        $statement->bindValue(":id_stud_leto", $id_stud_leto);
        $statement->execute();
        $result = $statement->fetchAll();

        return $result;
    }

    public static function getVpisId($id_kandidat){
        $db = DBInit::getInstance();

        $statement = $db -> prepare("
            SELECT v.ID_VPIS
            FROM vpis AS v 
            JOIN kandidat AS k ON v.VPISNA_STEVILKA = k.VPISNA_STEVILKA
            WHERE k.ID_KANDIDAT = :id_kandidat
        ");

        $statement->bindValue(":id_kandidat", $id_kandidat);
        $statement->execute();
        $result = $statement->fetch();

        return $result['ID_VPIS'];
    }
    
    public static function getVpisnaStevilkaWithKandidatId($id_kandidat){
        $db = DBInit::getInstance();

        $statement = $db -> prepare("
            SELECT v.VPISNA_STEVILKA
            FROM vpis AS v 
            JOIN kandidat AS k ON v.VPISNA_STEVILKA = k.VPISNA_STEVILKA
            WHERE k.ID_KANDIDAT = :id_kandidat
        ");

        $statement->bindValue(":id_kandidat", $id_kandidat);
        $statement->execute();
        $result = $statement->fetch();

        return $result['VPISNA_STEVILKA'];
    }
    
    public static function getVpisnaStevilkaWithOsebaId($id_oseba){
        $db = DBInit::getInstance();

        $statement = $db -> prepare("
            SELECT VPISNA_STEVILKA 
            FROM STUDENT 
            WHERE ID_OSEBA = :id_oseba
        ");

        $statement->bindValue(":id_oseba", $id_oseba);
        $statement->execute();
        $result = $statement->fetch();

        return $result['VPISNA_STEVILKA'];
    }
    
    public static function updateProgram($id_vpis, $ID_PROGRAM){
        $db = DBInit::getInstance();
        $statement = $db -> prepare("
            UPDATE vpis
            SET ID_PROGRAM = :ID_PROGRAM
            WHERE id_vpis = :id_vpis
        ");
        $statement->bindValue(":ID_PROGRAM", $ID_PROGRAM);
        $statement->bindValue(":id_vpis", $id_vpis);
        $statement->execute();
    }
    
    public static function updateStudLeto($id_vpis, $ID_STUD_LETO){
        $db = DBInit::getInstance();
        $statement = $db -> prepare("
            UPDATE vpis
            SET ID_STUD_LETO = :ID_STUD_LETO
            WHERE id_vpis = :id_vpis
        ");
        $statement->bindValue(":ID_STUD_LETO", $ID_STUD_LETO);
        $statement->bindValue(":id_vpis", $id_vpis);
        $statement->execute();
    }

    public static function potrdiVpisReferent($id_kandidat){
        $db = DBInit::getInstance();

        // Set potrjenost_vpisa to 1
        $id_vpis = self::getVpisId($id_kandidat);
        $statement = $db -> prepare("
            UPDATE vpis
            SET potrjenost_vpisa = 1
            WHERE id_vpis = :id_vpis
        ");

        $statement->bindValue(":id_vpis", $id_vpis);
        $statement->execute();

        // Create new student
        $kandidatData = self::getKandidatPodatki($id_kandidat);
        $statement = $db -> prepare("
            INSERT INTO `student` (`vpisna_stevilka`, `id_oseba`, `id_kandidat`, `id_vpis`, `emso`, `id_program`)
            VALUES (:vpisna_stevilka, :id_oseba, :id_kandidat, :id_vpis, :emso, :id_program)
        ");

        $statement->bindValue(":vpisna_stevilka", $kandidatData['vpisna_stevilka']);
        $statement->bindValue(":id_oseba", $kandidatData['id_oseba']);
        $statement->bindValue(":id_kandidat", $id_kandidat);
        $statement->bindValue(":id_vpis", $id_vpis);
        $statement->bindValue(":emso", $kandidatData['emso']);
        $statement->bindValue(":id_program", $kandidatData['id_program']);
        $statement->execute();

        // Set vloga from k to s
        $statement = $db -> prepare("
            UPDATE oseba
            SET VRSTA_VLOGE = 's'
            WHERE id_oseba = :id_oseba
        ");
        $statement->bindValue(":id_oseba", $kandidatData['id_oseba']);
        $statement->execute();
    }

    public static function potrdiVpisForStudentByReferent($VPISNA_STEVILKA){
        $db = DBInit::getInstance();
        $statement = $db -> prepare("
            UPDATE vpis
            SET potrjenost_vpisa = 1
            WHERE VPISNA_STEVILKA = :VPISNA_STEVILKA AND potrjenost_vpisa = 0
        ");
        $statement->bindValue(":VPISNA_STEVILKA", $VPISNA_STEVILKA);
        $statement->execute();
    }
    
    // Funkcijo klicati SAMO KO JE STUDENT ZE KREIRAN!
    public static function getVpisnaFromKandidatId($id_kandidat){

        $db = DBInit::getInstance();
        $statement = $db -> prepare("
            SELECT VPISNA_STEVILKA
            FROM student
            WHERE ID_KANDIDAT = :id_kandidat
        ");

        $statement->bindValue(":id_kandidat", $id_kandidat);
        $statement->execute();
        $result = $statement->fetch();
        return $result['VPISNA_STEVILKA'];
    }
    
    public static function insertPredmetiKandidat($VPISNA_STEVILKA, $predmeti, $id_stud_leto){
        $db = DBInit::getInstance();

        //var_dump($VPISNA_STEVILKA." ".$predmeti." ".$id_stud_leto);
        foreach ($predmeti as $key => $value){
            $statement = $db -> prepare("
                INSERT INTO predmeti_studenta (VPISNA_STEVILKA, ID_PREDMET, ID_STUD_LETO)
                VALUES (:VPISNA_STEVILKA, :id_predmet, :id_stud_leto)
            ");
            $statement->bindValue(":VPISNA_STEVILKA", $VPISNA_STEVILKA);
            $statement->bindValue(":id_predmet", $value['ID_PREDMET']);
            $statement->bindValue(":id_stud_leto", $id_stud_leto);
            $statement->execute();
        }
    }

    public static function jeIzkoriscen($id){
        if(User::isLoggedInAsCandidate()) {
            $db = DBInit::getInstance();
            $statement = $db->prepare("
            SELECT k.IZKORISCEN
            FROM kandidat AS k
            JOIN oseba o ON k.ID_OSEBA = o.ID_OSEBA
            WHERE k.ID_OSEBA =:id
        ");

            $statement->bindValue(":id", $id);
            $statement->execute();
            $result = $statement->fetch();
            return $result['IZKORISCEN'];
        }
        else{
            $db = DBInit::getInstance();
            $statement = $db->prepare("
            SELECT IZKORISCEN
            FROM zeton
            WHERE ID_OSEBA = :id
            ORDER BY ID_STUD_LETO DESC 
            LIMIT 1
        ");

            $statement->bindValue(":id", $id);
            $statement->execute();
            return $statement->fetchColumn();
        }
    }
}