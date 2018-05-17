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
            SELECT o.ID_OSEBA, o.IME, o.PRIIMEK , o.EMAIL, o.TELEFONSKA_STEVILKA
            FROM OSEBA AS o
            WHERE o.VRSTA_VLOGE='p'
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

    public static function IzvajalecEdit($ime, $priimek, $email, $tel, $id_predmet)
    {
        /*  var_dump($ime);
          var_dump($priimek);
          var_dump($email);
          var_dump($tel);*/
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


            /* $statement = $db -> prepare(
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
             echo "bteh4eh46j";*/
        }

        return true;


    }

    public static function IzvajalecAdd($ime, $priimek, $email, $geslo, $telefon)
    {
        $db = DBInit::getInstance();


        $statement = $db->prepare(
            "INSERT INTO OSEBA
        (IME,PRIIMEK,EMAIL,GESLO,VRSTA_VLOGE,TELEFONSKA_STEVILKA)
        VALUES(:ime,:priimek,:email,:geslo,'p',:telefon);"
        );

        $statement->bindValue(":ime", $ime);
        $statement->bindValue(":priimek", $priimek);
        $statement->bindValue(":email", $email);
        $statement->bindValue(":geslo", $geslo);
        $statement->bindValue(":telefon", $telefon);


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

    public static function getPredmetiProfesorja($id_oseba)
    {

        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT DISTINCT ip.ID_PREDMET, p.IME_PREDMET
            FROM izvedba_predmeta AS ip
            JOIN predmet AS p ON ip.ID_PREDMET = p.ID_PREDMET
            WHERE ip.ID_OSEBA1 = :id_oseba
            OR ip.ID_OSEBA2 = :id_oseba
            OR ip.ID_OSEBA3 = :id_oseba
        ");

        $statement->bindValue(":id_oseba", $id_oseba);
        $statement->execute();
        return $statement->fetchAll();
    }

    public static function getIzpitniRokiProfesorja($id_oseba)
    {

        $db = DBInit::getInstance();
        $statement = $db->prepare("
            SELECT ip.ID_PREDMET, r.ID_ROK, r.ID_IZVEDBA, r.DATUM_ROKA, r.CAS_ROKA
            FROM rok AS r
            JOIN izvedba_predmeta AS ip ON r.ID_IZVEDBA = ip.ID_IZVEDBA
            WHERE ip.ID_STUD_LETO = 2
            AND (ip.ID_OSEBA1 = :id_oseba
            OR ip.ID_OSEBA2 = :id_oseba
            OR ip.ID_OSEBA3 = :id_oseba)
        ");

        $statement->bindValue(":id_oseba", $id_oseba);
        $statement->execute();
        return $statement->fetchAll();
    }

    public static function getPrijavljeniNaIzpit($id_rok)
    {

        $db = DBInit::getInstance();
        $statement = $db->prepare("
            SELECT p.ID_PRIJAVA, p.VPISNA_STEVILKA, o.IME, o.PRIIMEK
            FROM prijava AS p
            JOIN student AS s ON p.VPISNA_STEVILKA = s.VPISNA_STEVILKA
            JOIN oseba AS o ON s.ID_OSEBA = o.ID_OSEBA
            WHERE p.ID_ROK = :id_rok
        ");

        $statement->bindValue(":id_rok", $id_rok);
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

}

