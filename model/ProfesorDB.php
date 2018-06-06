<?php
require_once "DBInit.php";

class ProfesorDB
{

    public static function addPredmet($name)
    {
        $db = DBInit::getInstance();

        // TODO ulica, hisna_stevilka, naslov_za_posiljanje, telefon, email
        $statement = $db->prepare(
            "INSERT INTO predmet
                      (IME_PREDMET,AKTIVNOST_PREDMET)VALUES
                      (:name,1);"
        );
        $statement->bindParam(":name", $name);
        $statement->execute();

        $statement = $db->prepare(
            "SELECT ID_PREDMET FROM predmet 
                      WHERE IME_PREDMET = :name"
        );
        $statement->bindParam(":name", $name);
        $statement->execute();
        return $statement->fetchColumn();
    }

    public static function getIDucitelj($ime, $priimek)
    {
        $db = DBInit::getInstance();

        // TODO ulica, hisna_stevilka, naslov_za_posiljanje, telefon, email
        $statement = $db->prepare(
            "SELECT ID_UCITELJ FROM ucitelj 
            WHERE ime = :ime 
            AND priimek = :priimek"
        );
        $statement->bindParam(":ime", $ime);
        $statement->bindParam(":priimek", $priimek);
        $statement->execute();
        return $statement->fetchColumn();
    }

    public static function getStudLeto($leto)
    {
        $db = DBInit::getInstance();

        // TODO ulica, hisna_stevilka, naslov_za_posiljanje, telefon, email
        $statement = $db->prepare(
            "SELECT ID_STUD_LETO FROM studijsko_leto 
            WHERE STUD_LETO = :leto"
        );
        $statement->bindParam(":leto", $leto);
        $statement->execute();
        return $statement->fetchColumn();
    }

    public static function addIzvedbaPredmet($idPredmet, $studLeto, $ucitelj, $ucitelj2, $ucitelj3)
    {

        $db = DBInit::getInstance();

        // TODO ulica, hisna_stevilka, naslov_za_posiljanje, telefon, email
        $statement = $db->prepare(
            "INSERT INTO izvedba_predmeta
          (ID_UCITELJ1,ID_STUD_LETO,ID_UCITELJ2,ID_UCITELJ3,ID_PREDMET)VALUES
          (:ucitelj1,:leto,:ucitelj2,:ucitelj3,:predmet);
"
        );
        $statement->bindParam(":ucitelj1", $ucitelj);
        $statement->bindParam(":leto", $studLeto);
        $statement->bindParam(":ucitelj2", $ucitelj2);
        $statement->bindParam(":ucitelj3", $ucitelj3);
        $statement->bindParam(":predmet", $idPredmet);
        $statement->execute();

        $statement = $db->prepare(
            "SELECT ID_PREDMET FROM predmet 
                      WHERE IME_PREDMET = :name"
        );

        return $statement->fetch();
    }

    public static function getPredmeti()
    {
        $db = DBInit::getInstance();
        // TODO ulica, hisna_stevilka, naslov_za_posiljanje, telefon, email
        $statement = $db->prepare(
            "SELECT * FROM izvedba_predmeta"
        );
        $statement->execute();
        return $statement->fetchAll();

    }

    public static function getPredmetIme($id)
    {
        $db = DBInit::getInstance();
        // TODO ulica, hisna_stevilka, naslov_za_posiljanje, telefon, email
        $statement = $db->prepare(
            "SELECT IME_PREDMET FROM predmet
            WHERE ID_PREDMET = :id
            "
        );
        $statement->bindParam(":id", $id);
        $statement->execute();
        return $statement->fetchColumn();
    }

    public static function getUcitelj1($id)
    {
        $db = DBInit::getInstance();
        echo("<script>console.log('DATA: : ', " . $id . ");</script>");
        // TODO ulica, hisna_stevilka, naslov_za_posiljanje, telefon, email
        $statement = $db->prepare(
            "SELECT IME, PRIIMEK FROM ucitelj
            WHERE ID_UCITELJ = :id
            "
        );
        $statement->bindParam(":id", $id);
        $statement->execute();
        return $statement->fetchColumn();
    }

    public static function getUcitelj2($id)
    {
        $db = DBInit::getInstance();
        // TODO ulica, hisna_stevilka, naslov_za_posiljanje, telefon, email
        $statement = $db->prepare(
            "SELECT IME, PRIIMEK FROM ucitelj
            WHERE ID_UCITELJ = :id
            "
        );
        $statement->bindParam(":id", $id);
        $statement->execute();
        return $statement->fetchColumn();
    }

    public static function getUcitelj3($id)
    {
        $db = DBInit::getInstance();
        // TODO ulica, hisna_stevilka, naslov_za_posiljanje, telefon, email
        $statement = $db->prepare(
            "SELECT IME, PRIIMEK FROM ucitelj
            WHERE ID_UCITELJ = :id
            "
        );
        $statement->bindParam(":id", $id);
        $statement->execute();
        return $statement->fetchColumn();
    }

    public static function getAllProfessors()
    {
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT o.ID_OSEBA, o.IME, o.PRIIMEK , o.EMAIL, o.TELEFONSKA_STEVILKA, o.SIFRA_IZVAJALCA
            FROM OSEBA AS o
            WHERE o.VRSTA_VLOGE='p'
            ORDER BY o.PRIIMEK
        ");

        $statement->execute();
        return $statement->fetchAll();

    }

    public static function getOneIzvajalec($id)
    {
        $db = DBInit::getInstance();

        $statement = $db->prepare(
            "
            SELECT DISTINCT o.ID_OSEBA, o.IME, o.PRIIMEK, o.EMAIL, o.TELEFONSKA_STEVILKA
            FROM OSEBA AS o
            WHERE o.ID_OSEBA=:id"
        );
        $statement->bindParam(":id", $id);
        $statement->execute();
        $product = $statement->fetchAll();
        // var_dump($product);
        if ($product != null) {
            return $product;
        } else {
            throw new InvalidArgumentException("No record with id $id");
        }
    }

    public static function IzvajalecEdit($ime,$priimek,$email,$uporabnisko_ime,$telefonska_stevlika,$id_predmet,$id_leto,$id_oseba)
    {
        /*var_dump($ime);
        var_dump($priimek);
        var_dump($email);
        var_dump($uporabnisko_ime);
        var_dump($telefonska_stevlika);
        var_dump($id_predmet);
        var_dump($id_leto);
        var_dump($id_oseba);*/
        $db = DBInit::getInstance();

        $statement = $db -> prepare(
            "UPDATE izvedba_predmeta as ip 
            JOIN oseba as o ON ip.ID_OSEBA1=o.ID_OSEBA
            SET
            o.IME = :ime,
            o.PRIIMEK = :priimek,
            o.EMAIL = :email,
            o.UPORABNISKO_IME = :uporabnisko_ime,
            o.TELEFONSKA_STEVILKA=:telefonska_stevilka,
            ip.ID_OSEBA1=:id_oseba
            WHERE  ip.ID_PREDMET=:id_predmet AND ip.ID_STUD_LETO=:id_leto"
        );
        $statement->bindValue(":ime", $ime);
        $statement->bindValue(":priimek", $priimek);
        $statement->bindValue(":email", $email);
        $statement->bindValue(":uporabnisko_ime", $uporabnisko_ime);
        $statement->bindValue(":telefonska_stevilka", $telefonska_stevlika);
        $statement->bindValue(":id_predmet", $id_predmet);
        $statement->bindValue(":id_leto", $id_leto);
        $statement->bindValue(":id_oseba", $id_oseba);
        try{
            $statement->execute();
            return true;
        } catch (Exception $e){
            var_dump($e);
            return false;
        }

        /*  var_dump($ime);
          var_dump($priimek);
          var_dump($email);
          var_dump($tel);
        $db = DBInit::getInstance();



        for ($i = 0; $i < count($ime); $i++) {


            $statement = $db->prepare("
             SELECT ID_OSEBA 
             FROM OSEBA   
             WHERE IME=:ime AND PRIIMEK=:priimek AND EMAIL=:email AND TELEFONSKA_STEVILKA=:tel
            ");

            $statement->bindValue(":ime", $ime[$i]);
            $statement->bindValue(":priimek", $priimek[$i]);
            $statement->bindValue(":email", $email[$i]);
            $statement->bindValue(":tel", $tel[$i]);
            $statement->execute();

            $result = $statement->fetch();
            //  var_dump($result);
            if ($result == null) {
                echo "ERROR11111!";
                return;
            }

            $id = $result["ID_OSEBA"];

            if ($i == 0) {
                $statement = $db->prepare(
                    "UPDATE IZVEDBA_PREDMETA 
                      SET
                     ID_OSEBA1 = :id 
                    WHERE  ID_PREDMET = :id_predmet"
                );
                //var_dump($id_predmet);
                $statement->bindValue(":id", $id);
                $statement->bindValue(":id_predmet", $id_predmet);
                $statement->execute();
            } else if ($i == 1) {
                $statement = $db->prepare(
                    "UPDATE IZVEDBA_PREDMETA 
                      SET
                     ID_OSEBA2 = :id
                    WHERE  ID_PREDMET = :id_predmet"
                );
                $statement->bindValue(":id", $id);
                $statement->bindValue(":id_predmet", $id_predmet);
                $statement->execute();
            } else {
                $statement = $db->prepare(
                    "UPDATE IZVEDBA_PREDMETA 
                      SET
                     ID_OSEBA3 = :id
                    WHERE  ID_PREDMET = :id_predmet"
                );
                $statement->bindValue(":id", $id);
                $statement->bindValue(":id_predmet", $id_predmet);
                $statement->execute();
            }


             $statement = $db -> prepare(
                 "UPDATE OSEBA
                 SET
             IME = :ime,
             PRIIMEK = :priimek,
             EMAIL = :email,
             TELEFONSKA_STEVILKA = :tel
             where  ID_OSEBA = :id;"
             );
             echo "ALOOOO".$id.$ime[$i].$priimek[$i].$email[$i].$tel[$i];
             $statement->bindValue(":id", $id);
            $statement->bindValue(":ime", $ime[$i]);
            $statement->bindValue(":priimek", $priimek[$i]);
            $statement->bindValue(":email", $email[$i]);
            $statement->bindValue(":tel", $tel[$i]);
             $statement->execute();
             echo "bteh4eh46j";
        }*/

        return true;


    }

    public static function IzvajalecAdd($id_predmet,$id_leto,$id_oseba)
    {
        $db = DBInit::getInstance();


        /* $statement = $db->prepare(
             "UPDATE IZVEDBA_PREDMETA
                       SET
                      ID_OSEBA1 = :id_oseba
                     WHERE  ID_PREDMET = :id_predmet AND ID_STUD_LETO=:id_leto"
         );

         if($statement->rowCount()==0){*/

        $statement2 = $db->prepare(
            "INSERT INTO IZVEDBA_PREDMETA 
              (ID_STUD_LETO, ID_OSEBA1, ID_OSEBA2,ID_OSEBA3, ID_PREDMET)
               VALUES (:id_leto, :id_oseba, NULL, NULL, :id_predmet)
               "
        );

        $statement2->bindValue(":id_predmet", $id_predmet);
        $statement2->bindValue(":id_leto", $id_leto);
        $statement2->bindValue(":id_oseba", $id_oseba);
        $statement2->execute();
        return true;

        /*  }

          $statement->bindValue(":id_predmet", $id_predmet);
          $statement->bindValue(":id_leto", $id_leto);
          $statement->bindValue(":id_oseba", $id_oseba);


          $statement->execute();

          return true;*/
    }

    public static function IzvajalecAdd2($id_predmet,$id_leto,$id_oseba)
    {
        $db = DBInit::getInstance();


        $statement = $db->prepare(
            "UPDATE IZVEDBA_PREDMETA 
                      SET
                     ID_OSEBA2 = :id_oseba
                    WHERE  ID_PREDMET = :id_predmet AND ID_STUD_LETO=:id_leto"
        );

        /*if($statement->rowCount()==0){

            $statement2 = $db->prepare(
                "INSERT INTO IZVEDBA_PREDMETA 
              (ID_STUD_LETO, ID_OSEBA1, ID_OSEBA2,ID_OSEBA3, ID_PREDMET)
               VALUES (:id_leto, NULL, :id_oseba, NULL, :id_predmet)
               "
            );

            $statement2->bindValue(":id_predmet", $id_predmet);
            $statement2->bindValue(":id_leto", $id_leto);
            $statement2->bindValue(":id_oseba", $id_oseba);
            $statement2->execute();
            return true;

        }*/

        $statement->bindValue(":id_predmet", $id_predmet);
        $statement->bindValue(":id_leto", $id_leto);
        $statement->bindValue(":id_oseba", $id_oseba);


        $statement->execute();

        return true;
    }

    public static function IzvajalecAdd3($id_predmet,$id_leto,$id_oseba)
    {
        $db = DBInit::getInstance();


        $statement = $db->prepare(
            "UPDATE IZVEDBA_PREDMETA 
                      SET
                     ID_OSEBA3 = :id_oseba
                    WHERE  ID_PREDMET = :id_predmet AND ID_STUD_LETO=:id_leto"
        );

        /* if($statement->rowCount()==0){

             $statement2 = $db->prepare(
                 "INSERT INTO IZVEDBA_PREDMETA
               (ID_STUD_LETO, ID_OSEBA1, ID_OSEBA2,ID_OSEBA3, ID_PREDMET)
                VALUES (:id_leto, NULL, NULL, :id_oseba, :id_predmet)
                "
             );

             $statement2->bindValue(":id_predmet", $id_predmet);
             $statement2->bindValue(":id_leto", $id_leto);
             $statement2->bindValue(":id_oseba", $id_oseba);
             $statement2->execute();
             return true;

         }*/

        $statement->bindValue(":id_predmet", $id_predmet);
        $statement->bindValue(":id_leto", $id_leto);
        $statement->bindValue(":id_oseba", $id_oseba);


        $statement->execute();

        return true;
    }


    public static function getSubjectProfessors($id_subject)
    {
        $db = DBInit::getInstance();

        $statement = $db->prepare(
            "SELECT ID_OSEBA1,ID_OSEBA2, ID_OSEBA3
            FROM IZVEDBA_PREDMETA 
            WHERE ID_PREDMET=:id_subject
            "
        );
        $statement->bindValue(":id_subject", $id_subject);
        $statement->execute();
        $result = $statement->fetch();

        return $result;
    }

    public static function getPredmetiProfesorja($id_oseba, $id_stud_leto)
    {

        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT DISTINCT ip.ID_PREDMET, p.IME_PREDMET, p.SIFRA_PREDMET
            FROM izvedba_predmeta AS ip
            JOIN predmet AS p ON ip.ID_PREDMET = p.ID_PREDMET
            WHERE (ip.ID_OSEBA1 = :id_oseba
            OR ip.ID_OSEBA2 = :id_oseba
            OR ip.ID_OSEBA3 = :id_oseba)
            AND ip.ID_STUD_LETO = :id_stud_leto
        ");

        $statement->bindValue(":id_oseba", $id_oseba);
        $statement->bindValue(":id_stud_leto", $id_stud_leto);
        $statement->execute();
        return $statement->fetchAll();
    }

    public static function getIzpitniRokiProfesorja($id_oseba, $id_stud_leto)
    {

        $db = DBInit::getInstance();
        $statement = $db->prepare("
            SELECT ip.ID_PREDMET, r.ID_ROK, r.ID_IZVEDBA, r.DATUM_ROKA, r.CAS_ROKA
            FROM rok AS r
            JOIN izvedba_predmeta AS ip ON r.ID_IZVEDBA = ip.ID_IZVEDBA
            WHERE (ip.ID_OSEBA1 = :id_oseba
            OR ip.ID_OSEBA2 = :id_oseba
            OR ip.ID_OSEBA3 = :id_oseba)
            AND ip.ID_STUD_LETO = :id_stud_leto
        ");

        $statement->bindValue(":id_oseba", $id_oseba);
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

    public static function getPrijavljeniNaIzpit($id_rok)
    {

        $db = DBInit::getInstance();
        $statement = $db->prepare("
            SELECT o.ID_OSEBA, o.IME, o.PRIIMEK, p.ID_PRIJAVA, ip.ID_PREDMET, p.ID_ROK, p.PODATKI_O_PLACILU, p.ZAP_ST_POLAGANJ, p.ZAP_ST_POLAGANJ_LETOS, p.VPISNA_STEVILKA, p.DATUM_ODJAVE, p.DATUM_PRIJAVE, p.TOCKE_IZPITA, p.OCENA_IZPITA
            FROM prijava AS p
              JOIN student AS s ON p.VPISNA_STEVILKA = s.VPISNA_STEVILKA
              JOIN oseba AS o ON s.ID_OSEBA = o.ID_OSEBA
              JOIN rok AS r ON p.ID_ROK = r.ID_ROK
              JOIN izvedba_predmeta AS ip ON r.ID_IZVEDBA = ip.ID_IZVEDBA
            WHERE p.ID_ROK = :id_rok
            AND ISNULL(p.DATUM_ODJAVE)
        ");

        $statement->bindValue(":id_rok", $id_rok);
        $statement->execute();
        return $statement->fetchAll();
    }

    /*
    public static function getPrijavljeniNaIzpitIncludingVP($id_rok)
    {

        $db = DBInit::getInstance();
        $statement = $db->prepare("
            SELECT o.ID_OSEBA, o.IME, o.PRIIMEK, p.ID_PRIJAVA, ip.ID_PREDMET, p.ID_ROK, p.PODATKI_O_PLACILU, p.ZAP_ST_POLAGANJ, p.ZAP_ST_POLAGANJ_LETOS, p.VPISNA_STEVILKA, p.DATUM_ODJAVE, p.DATUM_PRIJAVE, p.TOCKE_IZPITA, p.OCENA_IZPITA
            FROM prijava AS p
              JOIN student AS s ON p.VPISNA_STEVILKA = s.VPISNA_STEVILKA
              JOIN oseba AS o ON s.ID_OSEBA = o.ID_OSEBA
              JOIN rok AS r ON p.ID_ROK = r.ID_ROK
              JOIN izvedba_predmeta AS ip ON r.ID_IZVEDBA = ip.ID_IZVEDBA
            WHERE p.ID_ROK = :id_rok
        ");

        $statement->bindValue(":id_rok", $id_rok);
        $statement->execute();
        return $statement->fetchAll();
    }
    */

    public static function updateTockeIzpita($id_prijava, $tocke){

        $db=DBInit::getInstance();
        $statement = $db->prepare("
            UPDATE prijava
            SET TOCKE_IZPITA = :tocke
            WHERE ID_PRIJAVA = :id_prijava
        ");

        $statement->bindValue(":id_prijava", $id_prijava);
        $statement->bindValue(":tocke", $tocke);
        $statement->execute();
    }

    public static function updateOcenaIzpita($id_prijava, $ocena){

        //var_dump("ID ps: ".$id_prijava." Ocena: ".$ocena);
        $db=DBInit::getInstance();
        $statement = $db->prepare("
            UPDATE prijava
            SET OCENA_IZPITA = :ocena
            WHERE ID_PRIJAVA = :id_prijava
        ");

        $statement->bindValue(":id_prijava", $id_prijava);
        $statement->bindValue(":ocena", $ocena);
        $statement->execute();

        self::updateKoncnaOcena($id_prijava, $ocena);
    }

    public static function updateKoncnaOcena($id_prijava, $ocena){

        $db = DBInit::getInstance();
        $statement = $db->prepare("
            SELECT ps.ID_PREDMETISTUDENTA, ps.OCENA
            FROM predmeti_studenta AS ps
            JOIN prijava AS p ON ps.VPISNA_STEVILKA = p.VPISNA_STEVILKA
            JOIN rok AS r ON p.ID_ROK = r.ID_ROK
            JOIN izvedba_predmeta ip on r.ID_IZVEDBA = ip.ID_IZVEDBA
            WHERE ip.ID_PREDMET = ps.ID_PREDMET
            AND p.ID_PRIJAVA = :id_prijava
        ");
        $statement->bindValue(":id_prijava", $id_prijava);
        $statement->execute();
        $result = $statement->fetchAll();

        $statement = $db->prepare("
            UPDATE predmeti_studenta
            SET OCENA = :ocena
            WHERE ID_PREDMETISTUDENTA = :id_predmetistudenta
        ");

        $statement->bindValue(":ocena", $ocena);
        //$statement->bindValue(":id_predmetistudenta", 1372);
        $statement->bindValue(":id_predmetistudenta", $result[0]["ID_PREDMETISTUDENTA"]);
        $statement->execute();
    }




    public static function vrniPrijavoProfesor($id_prijava, $id_odjavitelj){

        $db=DBInit::getInstance();
        $statement = $db->prepare("
            UPDATE prijava
            SET DATUM_ODJAVE = CURRENT_TIMESTAMP, ID_OSEBA_ODJAVITELJ = :id_odjavitelj, TOCKE_IZPITA = null 
            WHERE ID_PRIJAVA = :id_prijava
        ");

        $statement->bindValue(":id_prijava", $id_prijava);
        $statement->bindValue(":id_odjavitelj", $id_odjavitelj);
        $statement->execute();
    }

    public static function prekliciVrnjenoPrijavoProfesor($id_prijava){

        $db=DBInit::getInstance();
        $statement = $db->prepare("
            UPDATE prijava
            SET DATUM_ODJAVE = null, ID_OSEBA_ODJAVITELJ = null, TOCKE_IZPITA = null 
            WHERE ID_PRIJAVA = :id_prijava
        ");

        $statement->bindValue(":id_prijava", $id_prijava);
        //$statement->bindValue(":id_odjavitelj", $id_odjavitelj);
        $statement->execute();
    }

    public static function getPrijavljeniNaPredmet($id_predmet, $id_stud_leto)
    {

        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT o.ID_OSEBA, o.IME, o.PRIIMEK, s.VPISNA_STEVILKA, p.OCENA, p.ID_PREDMETISTUDENTA
            FROM oseba o
              JOIN student s on o.ID_OSEBA = s.ID_OSEBA
              JOIN predmeti_studenta p on s.VPISNA_STEVILKA = p.VPISNA_STEVILKA
            WHERE p.ID_STUD_LETO = :id_stud_leto
            AND p.ID_PREDMET = :id_predmet
        ");

        $statement->bindValue(":id_predmet", $id_predmet);
        $statement->bindValue(":id_stud_leto", $id_stud_leto);
        $statement->execute();
        return $statement->fetchAll();
    }

    public static function getTockeIzpita($id_predmet, $id_stud_leto)
    {

        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT p.ID_PRIJAVA, i.ID_PREDMET, i.ID_STUD_LETO, p.VPISNA_STEVILKA, p.ZAP_ST_POLAGANJ, p.ZAP_ST_POLAGANJ_LETOS, p.TOCKE_IZPITA, p.DATUM_PRIJAVE, p.DATUM_ODJAVE
            FROM prijava p
              JOIN rok r on p.ID_ROK = r.ID_ROK
              JOIN izvedba_predmeta i ON r.ID_IZVEDBA = i.ID_IZVEDBA
            WHERE i.ID_STUD_LETO = :id_stud_leto
                  AND i.ID_PREDMET = :id_predmet
        ");

        $statement->bindValue(":id_predmet", $id_predmet);
        $statement->bindValue(":id_stud_leto", $id_stud_leto);
        $statement->execute();
        return $statement->fetchAll();
    }


    public static function getLeta()
    {
        $db = DBInit::getInstance();

        $statement = $db->prepare("
                SELECT DISTINCT *
                FROM  studijsko_leto");

        $statement->execute();

        return $statement->fetchAll();

    }

    public static function getPredmeti1($leto)
    {

        $db = DBInit::getInstance();

        $statement = $db->prepare("
                    SELECT DISTINCT *
                    FROM  izvedba_predmeta i, predmet p
                    WHERE ID_STUD_LETO = :leto AND p.ID_PREDMET = i.ID_PREDMET AND p.ID_PREDMET = 1");
        $statement->bindParam(":leto", $leto);
        $statement->execute();

        return $statement->fetchAll();

    }

    public static function getPredmet($id)
    {

        $db = DBInit::getInstance();

        $statement = $db->prepare("
                    SELECT DISTINCT *
                    FROM  predmet 
                    WHERE ID_PREDMET = :id");
        $statement->bindParam(":id", $id);
        $statement->execute();

        return $statement->fetchAll()[0];

    }

    public static function getVpisani($predmet, $leto)
    {
        $db = DBInit::getInstance();
        $statement = $db->prepare("
                    SELECT DISTINCT *
                    FROM  predmeti_studenta p, student s , oseba o, vrsta_vpisa vv, vpis v 
                    WHERE ID_PREDMET = :predmet AND p.ID_STUD_LETO = :leto AND
                    p.VPISNA_STEVILKA = s.VPISNA_STEVILKA AND s.ID_OSEBA = o.ID_OSEBA AND 
                    v.VPISNA_STEVILKA = s.VPISNA_STEVILKA AND vv.ID_VRSTAVPISA = v.ID_VRSTAVPISA
                    ORDER BY PRIIMEK ASC
                    ");
        $statement->bindParam(":predmet", $predmet);
        $statement->bindParam(":leto", $leto);
        $statement->execute();

        return $statement->fetchAll();

    }

    public static function getLeto($id)
    {

        $db = DBInit::getInstance();

        $statement = $db->prepare("
                    SELECT STUD_LETO
                    FROM  studijsko_leto 
                    WHERE ID_STUD_LETO = :id");
        $statement->bindParam(":id", $id);
        $statement->execute();

        return $statement->fetchColumn();

    }


    //seznam vpisanih v predmet:

    public static function getPredmetiProfesorja2($leto)
    {
        $id_oseba = User::getId();
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT DISTINCT * 
                    FROM   predmet p ,izvedba_predmeta i, oseba o 
                    WHERE i.ID_STUD_LETO = :leto and p.id_predmet = i.id_predmet and o.ID_OSEBA = i.ID_OSEBA1 
                    and (:prof = ID_OSEBA1 or :prof = ID_OSEBA2 or :prof = ID_OSEBA3 )
            
        ");


        $statement->bindValue(":leto", $leto);
        $statement->bindValue(":prof", User::getId());
        $statement->execute();
        return $statement->fetchAll();
    }

    public static function FirstIzvajalecEdit($id_predmet,$id_leto,$id_oseba){
        $db = DBInit::getInstance();

        $statement = $db -> prepare(
            "UPDATE izvedba_predmeta as ip 
            SET
            ip.ID_OSEBA1=:id_oseba
            WHERE  ip.ID_PREDMET=:id_predmet AND ip.ID_STUD_LETO=:id_leto"
        );

        $statement->bindValue(":id_predmet", $id_predmet);
        $statement->bindValue(":id_leto", $id_leto);
        $statement->bindValue(":id_oseba", $id_oseba);
        try{
            $statement->execute();
            return true;
        } catch (Exception $e){
            var_dump($e);
            return false;
        }
        return true;
    }
    public static function SecondIzvajalecEdit($id_predmet,$id_leto,$id_oseba){
        $db = DBInit::getInstance();

        $statement = $db -> prepare(
            "UPDATE izvedba_predmeta as ip 
            SET
            ip.ID_OSEBA2=:id_oseba
            WHERE  ip.ID_PREDMET=:id_predmet AND ip.ID_STUD_LETO=:id_leto"
        );

        $statement->bindValue(":id_predmet", $id_predmet);
        $statement->bindValue(":id_leto", $id_leto);
        $statement->bindValue(":id_oseba", $id_oseba);
        try{
            $statement->execute();
            return true;
        } catch (Exception $e){
            var_dump($e);
            return false;
        }
        return true;
    }
    public static function ThirdIzvajalecEdit($id_predmet,$id_leto,$id_oseba){
        $db = DBInit::getInstance();

        $statement = $db -> prepare(
            "UPDATE izvedba_predmeta as ip 
            SET
            ip.ID_OSEBA3=:id_oseba
            WHERE  ip.ID_PREDMET=:id_predmet AND ip.ID_STUD_LETO=:id_leto"
        );

        $statement->bindValue(":id_predmet", $id_predmet);
        $statement->bindValue(":id_leto", $id_leto);
        $statement->bindValue(":id_oseba", $id_oseba);
        try{
            $statement->execute();
            return true;
        } catch (Exception $e){
            var_dump($e);
            return false;
        }
        return true;
    }

    public static function deleteSecondIzvajalec($id_leto,$id_predmet){
        $db = DBInit::getInstance();

        $statement = $db -> prepare(
            "UPDATE izvedba_predmeta as ip 
            SET
            ip.ID_OSEBA2=NULL
            WHERE  ip.ID_PREDMET=:id_predmet AND ip.ID_STUD_LETO=:id_leto"
        );

        $statement->bindValue(":id_predmet", $id_predmet);
        $statement->bindValue(":id_leto", $id_leto);
        try{
            $statement->execute();
            return true;
        } catch (Exception $e){
            var_dump($e);
            return false;
        }
        return true;
    }

    public static function deleteThirdIzvajalec($id_leto,$id_predmet){
        $db = DBInit::getInstance();

        $statement = $db -> prepare(
            "UPDATE izvedba_predmeta as ip 
            SET
            ip.ID_OSEBA3=NULL
            WHERE  ip.ID_PREDMET=:id_predmet AND ip.ID_STUD_LETO=:id_leto"
        );

        $statement->bindValue(":id_predmet", $id_predmet);
        $statement->bindValue(":id_leto", $id_leto);
        try{
            $statement->execute();
            return true;
        } catch (Exception $e){
            var_dump($e);
            return false;
        }
        return true;
    }

    public static function GetIzvajalec1($id_leto,$id_predmet){
        $db = DBInit::getInstance();

        $statement = $db -> prepare(
            "SELECT ip.ID_OSEBA1
            FROM izvedba_predmeta as ip 
            WHERE  ip.ID_PREDMET=:id_predmet AND ip.ID_STUD_LETO=:id_leto"
        );

        $statement->bindValue(":id_predmet", $id_predmet);
        $statement->bindValue(":id_leto", $id_leto);

        $statement->execute();
        return $statement->fetch();
    }

    public static function GetIzvajalec2($id_leto,$id_predmet){
        $db = DBInit::getInstance();

        $statement = $db -> prepare(
            "SELECT ip.ID_OSEBA2
            FROM izvedba_predmeta as ip 
            WHERE  ip.ID_PREDMET=:id_predmet AND ip.ID_STUD_LETO=:id_leto"
        );

        $statement->bindValue(":id_predmet", $id_predmet);
        $statement->bindValue(":id_leto", $id_leto);

        $statement->execute();
        return $statement->fetch();
    }

    public static function GetIzvajalec3($id_leto,$id_predmet){
        $db = DBInit::getInstance();

        $statement = $db -> prepare(
            "SELECT ip.ID_OSEBA3
            FROM izvedba_predmeta as ip 
            WHERE  ip.ID_PREDMET=:id_predmet AND ip.ID_STUD_LETO=:id_leto"
        );

        $statement->bindValue(":id_predmet", $id_predmet);
        $statement->bindValue(":id_leto", $id_leto);

        $statement->execute();
        return $statement->fetch();
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


}

