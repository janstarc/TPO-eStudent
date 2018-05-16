<?php
/**
 * Created by PhpStorm.
 * User: Paule
 * Date: 09/04/2018
 * Time: 14:35
 */

class SifrantDB
{
    public static function isDuplicateDelPredmetnika($naziv, $kt, $tip){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "SELECT NAZIV_DELAPREDMETNIKA,SKUPNOSTEVILOKT,TIP,AKTIVNOST
                        FROM del_predmetnika
                        WHERE NAZIV_DELAPREDMETNIKA = :naziv
                        AND SKUPNOSTEVILOKT = :kt
                        AND TIP = :tip
                      "
        );
        $statement->bindValue(":naziv", $naziv);
        $statement->bindValue(":kt", $kt);
        $statement->bindValue(":tip", $tip);
        $statement->execute();
        $result = $statement->fetchAll();

        if(empty($result)) return false;
        return true;
    }

    public static function DelPredmetnikaAdd($id, $naziv, $kt, $tip){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "INSERT INTO del_predmetnika
        (ID_DELPREDMETNIKA, NAZIV_DELAPREDMETNIKA,SKUPNOSTEVILOKT,TIP,AKTIVNOST)
        VALUES(:id, :naziv,:kt,:tip,1);"
        );
        $statement->bindValue(":id", $id);
        $statement->bindValue(":naziv", $naziv);
        $statement->bindValue(":kt", $kt);
        $statement->bindValue(":tip", $tip);
        $statement->execute();
        return true;
    }

    public static function isDuplicateAddDrzava($dk, $tk, $iso, $slo){
        $db = DBInit::getInstance();

        $statement = $db -> prepare(
            "SELECT DVOMESTNAKODA, TRIMESTNAKODA, ISONAZIV, SLOVENSKINAZIV, OPOMBA, AKTIVNOST
                        FROM drzava
                        WHERE DVOMESTNAKODA = :dk
                        OR TRIMESTNAKODA = :tk
                        OR ISONAZIV = :iso
                        OR SLOVENSKINAZIV = :slo"
        );

        $statement->bindValue(":dk", $dk);
        $statement->bindValue(":tk", $tk);
        $statement->bindValue(":iso", $iso);
        $statement->bindValue(":slo", $slo);
        $statement->execute();
        $result = $statement->fetchAll();

        if(empty($result)) return false;
        return true;
    }

    public static function isDuplicateEditDrzava($dk, $tk, $iso, $slo, $id){
        $db = DBInit::getInstance();

        $statement = $db -> prepare(
            "SELECT DVOMESTNAKODA, TRIMESTNAKODA, ISONAZIV, SLOVENSKINAZIV, OPOMBA, AKTIVNOST
                        FROM drzava
                        WHERE (DVOMESTNAKODA = :dk
                        OR TRIMESTNAKODA = :tk
                        OR ISONAZIV = :iso
                        OR SLOVENSKINAZIV = :slo)
                        AND ID_DRZAVA != :id"
        );

        $statement->bindValue(":dk", $dk);
        $statement->bindValue(":tk", $tk);
        $statement->bindValue(":iso", $iso);
        $statement->bindValue(":slo", $slo);
        $statement->bindValue(":id", $id);
        $statement->execute();
        $result = $statement->fetchAll();

        if(empty($result)) return false;
        return true;
    }

    public static function DrzavaAdd($dk, $tk, $iso, $slo, $opo){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "INSERT INTO drzava
        (DVOMESTNAKODA,TRIMESTNAKODA,ISONAZIV,SLOVENSKINAZIV,OPOMBA,AKTIVNOST)VALUES
        (:dk, :tk, :iso, :slo, :opo,1);"
        );
        $statement->bindValue(":dk", $dk);
        $statement->bindValue(":tk", $tk);
        $statement->bindValue(":iso", $iso);
        $statement->bindValue(":slo", $slo);
        $statement->bindValue(":opo", $opo);
        $statement->execute();
        return true;

    }

    public static function LetnikAdd($letnik){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "INSERT INTO letnik
              (LETNIK)VALUES
              (:letnik);"
        );
        $statement->bindValue(":letnik", $letnik);
        $statement->execute();
        return true;
    }

    public static function isDuplicateLetnik($letnik){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "SELECT LETNIK
                        FROM letnik
                        WHERE LETNIK = :letnik"
        );
        $statement->bindValue(":letnik", $letnik);
        $statement->execute();
        $result = $statement->fetchAll();
        if(empty($result)) return false;
        return true;
    }



    public static function isDuplicateAddNacinStudija($opis, $angopis){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "SELECT OPIS_NACIN, ANG_OPIS_NACIN
                       FROM nacin_studija
                       WHERE OPIS_NACIN = :opis
                       OR ANG_OPIS_NACIN = :angopis"
        );
        $statement->bindValue(":opis", $opis);
        $statement->bindValue(":angopis", $angopis);
        $statement->execute();
        $result = $statement->fetchAll();

        if(empty($result)) return false;
        return true;
    }

    public static function isDuplicateEditNacinStudija($opis, $angopis, $id){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "SELECT OPIS_NACIN, ANG_OPIS_NACIN, ID_NACIN
                       FROM nacin_studija
                       WHERE (OPIS_NACIN = :opis
                       OR ANG_OPIS_NACIN = :angopis)
                       AND ID_NACIN != :nacin"
        );
        $statement->bindValue(":opis", $opis);
        $statement->bindValue(":angopis", $angopis);
        $statement->bindValue(":nacin", $id);
        $statement->execute();
        $result = $statement->fetchAll();

        if(empty($result)) return false;
        return true;
    }

    public static function NacinStudijaAdd($opis, $angopis, $id){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "INSERT INTO nacin_studija
        (ID_NACIN, OPIS_NACIN,ANG_OPIS_NACIN,AKTIVNOST)
        VALUES(:id,:opis,:angopis,1);"
        );
        $statement->bindValue(":id", $id);
        $statement->bindValue(":opis", $opis);
        $statement->bindValue(":angopis", $angopis);

        try{
            $statement->execute();
            return true;
        } catch (Exception $e){
            return false;
        }
    }

    public static function isDuplicateObcina($ime){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "SELECT IME_OBCINA
                        FROM obcina
                        WHERE IME_OBCINA = :ime"
        );
        $statement->bindValue(":ime", $ime);
        $statement->execute();
        $result = $statement->fetchAll();
        if(empty($result)) return false;
        return true;
    }


    public static function ObcinaAdd($ime, $id){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "INSERT INTO obcina
        (ID_OBCINA, IME_OBCINA,AKTIVNOST)
        VALUES(:id,:ime,1);"
        );
        $statement->bindValue(":id", $id);
        $statement->bindValue(":ime", $ime);

        try{
            $statement->execute();
            return true;
        } catch (Exception $e){
            return false;
        }
    }

    public static function OblikaStudijaAdd($naziv,$ang,$id){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "INSERT INTO oblika_studija
        (ID_OBLIKA,NAZIV_OBLIKA,ANG_OPIS_OBLIKA,AKTIVNOST)
        VALUES(:id,:naziv,:ang,1);"
        );
        $statement->bindValue(":naziv", $naziv);
        $statement->bindValue(":ang", $ang);
        $statement->bindValue(":id", $id);
        try{
            $statement->execute();
            return true;
        } catch (Exception $e){
            return false;
        }
    }

    public static function isDuplicateOblikaStudija($naziv,$ang){

        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "SELECT NAZIV_OBLIKA, ANG_OPIS_OBLIKA
                        FROM oblika_studija
                        WHERE NAZIV_OBLIKA = :naziv
                        AND ANG_OPIS_OBLIKA = :ang"
        );
        $statement->bindValue(":naziv", $naziv);
        $statement->bindValue(":ang", $ang);

        $statement->execute();
        $result = $statement->fetchAll();
        if(empty($result)) return false;
        return true;
    }

    public static function isDuplicateAddPosta($stevilka, $kt){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "SELECT ST_POSTA, KRAJ
                        FROM posta
                        WHERE ST_POSTA = :stevilka
                        OR KRAJ = :kraj"
        );

        $statement->bindValue(":stevilka", $stevilka);
        $statement->bindValue(":kraj", $kt);

        $statement->execute();
        $result = $statement->fetchAll();
        if(empty($result)) return false;
        return true;
    }

    public static function isDuplicateEditPosta($stevilka, $kt, $id){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "SELECT ST_POSTA, KRAJ
                        FROM posta
                        WHERE (ST_POSTA = :stevilka
                        OR KRAJ = :kraj)
                        AND ID_POSTA != :id"
        );

        $statement->bindValue(":stevilka", $stevilka);
        $statement->bindValue(":kraj", $kt);
        $statement->bindValue(":id", $id);

        $statement->execute();
        $result = $statement->fetchAll();
        if(empty($result)) return false;
        return true;
    }

    public static function seNiUporabljena($posta){
        $db = DBInit::getInstance();

        $statement = $db -> prepare(
            "SELECT n.ID_NASLOV
                        FROM posta p
                        JOIN naslov n on p.ID_POSTA = n.ID_POSTA
                        WHERE p.ST_POSTA = :postnaSt"
        );

        $statement->bindValue(":postnaSt", $posta);
        $statement->execute();
        $result = $statement->fetchAll();
        if(empty($result)) return true;
        return false;
    }

    public static function PostaAdd($stevilka, $kt){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "INSERT INTO posta
        (ST_POSTA,KRAJ,AKTIVNOST)
        VALUES(:stevilka,:kraj,1);"
        );
        $statement->bindValue(":stevilka", $stevilka);
        $statement->bindValue(":kraj", $kt);

        $statement->execute();
        return true;
    }



    public static function PredmetAdd($ime,$id){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "INSERT INTO predmet
        (ID_PREDMET,IME_PREDMET,AKTIVNOST)
        VALUES(:id,:ime,1);"
        );
        $statement->bindValue(":ime", $ime);
        $statement->bindValue(":id", $id);
        try{
            $statement->execute();
            return true;
        } catch (Exception $e){
            return false;
        }
    }

    public static function StudijskoLetoAdd($leto, $id){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "INSERT INTO studijsko_leto
        (STUD_LETO, ID_STUD_LETO)
        VALUES(:leto, :id);"
        );
        $statement->bindValue(":leto", $leto);
        $statement->bindValue(":id", $id);
        try{
            $statement->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function VrstaVpisaAdd($opis,$id){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "INSERT INTO vrsta_vpisa
        (ID_VRSTAVPISA,OPIS_VPISA,AKTIVNOST)
        VALUES(:id,:opis,1);"
        );
        $statement->bindValue(":opis", $opis);
        $statement->bindValue(":id", $id);
        try{
            $statement->execute();
            return true;
        } catch (Exception $e){
            return false;
        }
    }




    public static function DelPredmetnikaToogleActivated($id){
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT AKTIVNOST FROM DEL_PREDMETNIKA WHERE ID_DELPREDMETNIKA = :id");
        $statement->bindValue(":id", $id);
        $statement->execute();
        $is_activated_str = ($statement->fetch())["AKTIVNOST"];

        if ($is_activated_str === '1')
            $is_activated = '0';
        else
            $is_activated = '1';

        $statement2 = $db->prepare(
            "UPDATE DEL_PREDMETNIKA
                SET AKTIVNOST = :is_activated
                WHERE ID_DELPREDMETNIKA = :id"
        );
        $statement2->bindValue(":id", $id);
        $statement2->bindParam(":is_activated", $is_activated);
        $statement2->execute();
        return true;
    }

    public static function DrzavaToogleActivated($id){
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT AKTIVNOST FROM DRZAVA WHERE ID_DRZAVA = :id");
        $statement->bindValue(":id", $id);
        $statement->execute();
        $is_activated_str = ($statement->fetch())["AKTIVNOST"];

        if ($is_activated_str === '1')
            $is_activated = '0';
        else
            $is_activated = '1';

        $statement2 = $db->prepare(
            "UPDATE DRZAVA
                SET AKTIVNOST = :is_activated
                WHERE ID_DRZAVA = :id"
        );
        $statement2->bindValue(":id", $id);
        $statement2->bindParam(":is_activated", $is_activated);
        $statement2->execute();
        return true;
    }

    public static function NacinStudijaToogleActivated($id){
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT AKTIVNOST FROM NACIN_STUDIJA WHERE ID_NACIN = :id");
        $statement->bindValue(":id", $id);
        $statement->execute();
        $is_activated_str = ($statement->fetch())["AKTIVNOST"];

        if ($is_activated_str === '1')
            $is_activated = '0';
        else
            $is_activated = '1';

        $statement2 = $db->prepare(
            "UPDATE NACIN_STUDIJA
                SET AKTIVNOST = :is_activated
                WHERE ID_NACIN = :id"
        );
        $statement2->bindValue(":id", $id);
        $statement2->bindParam(":is_activated", $is_activated);
        $statement2->execute();
        return true;
    }


    public static function ObcinaToogleActivated($id){
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT AKTIVNOST FROM OBCINA WHERE ID_OBCINA = :id");
        $statement->bindValue(":id", $id);
        $statement->execute();
        $is_activated_str = ($statement->fetch())["AKTIVNOST"];

        if ($is_activated_str === '1')
            $is_activated = '0';
        else
            $is_activated = '1';

        $statement2 = $db->prepare(
            "UPDATE OBCINA
                SET AKTIVNOST = :is_activated
                WHERE ID_OBCINA = :id"
        );
        $statement2->bindValue(":id", $id);
        $statement2->bindParam(":is_activated", $is_activated);
        $statement2->execute();
        return true;
    }


    public static function OblikaStudijaToogleActivated($id){
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT AKTIVNOST FROM OBLIKA_STUDIJA WHERE ID_OBLIKA = :id");
        $statement->bindValue(":id", $id);
        $statement->execute();
        $is_activated_str = ($statement->fetch())["AKTIVNOST"];

        if ($is_activated_str === '1')
            $is_activated = '0';
        else
            $is_activated = '1';

        $statement2 = $db->prepare(
            "UPDATE OBLIKA_STUDIJA
                SET AKTIVNOST = :is_activated
                WHERE ID_OBLIKA = :id"
        );
        $statement2->bindValue(":id", $id);
        $statement2->bindParam(":is_activated", $is_activated);
        $statement2->execute();
        return true;
    }


    public static function PostaToogleActivated($id){
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT AKTIVNOST FROM POSTA WHERE ID_POSTA = :id");
        $statement->bindValue(":id", $id);
        $statement->execute();
        $is_activated_str = ($statement->fetch())["AKTIVNOST"];

        if ($is_activated_str === '1')
            $is_activated = '0';
        else
            $is_activated = '1';

        $statement2 = $db->prepare(
            "UPDATE POSTA
                SET AKTIVNOST = :is_activated
                WHERE ID_POSTA = :id"
        );
        $statement2->bindValue(":id", $id);
        $statement2->bindParam(":is_activated", $is_activated);
        $statement2->execute();
        return true;
    }

    public static function PredmetToogleActivated($id){
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT AKTIVNOST FROM PREDMET WHERE ID_PREDMET = :id");
        $statement->bindValue(":id", $id);
        $statement->execute();
        $is_activated_str = ($statement->fetch())["AKTIVNOST"];

        if ($is_activated_str === '1')
            $is_activated = '0';
        else
            $is_activated = '1';

        $statement2 = $db->prepare(
            "UPDATE PREDMET
                SET AKTIVNOST = :is_activated
                WHERE ID_PREDMET = :id"
        );
        $statement2->bindValue(":id", $id);
        $statement2->bindParam(":is_activated", $is_activated);
        $statement2->execute();
        return true;
    }


    public static function VrstaVpisaToogleActivated($id){
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT AKTIVNOST FROM VRSTA_VPISA WHERE ID_VRSTAVPISA = :id");
        $statement->bindValue(":id", $id);
        $statement->execute();
        $is_activated_str = ($statement->fetch())["AKTIVNOST"];

        if ($is_activated_str === '1')
            $is_activated = '0';
        else
            $is_activated = '1';

        $statement2 = $db->prepare(
            "UPDATE VRSTA_VPISA
                SET AKTIVNOST = :is_activated
                WHERE ID_VRSTAVPISA = :id"
        );
        $statement2->bindValue(":id", $id);
        $statement2->bindParam(":is_activated", $is_activated);
        $statement2->execute();
        return true;
    }



    public static function DrzavaDelete($id){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "UPDATE drzava SET
        AKTIVNOST = 0
        where  ID_DRZAVE = :id"
        );
        $statement->bindValue(":id", $id);
        $statement->execute();
        return true;
    }
    public static function LetnikDelete($id){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "UPDATE letnik SET
        AKTIVNOST = 0
        where  ID_LETNIK = :id"
        );
        $statement->bindValue(":id", $id);
        $statement->execute();
        return true;
    }
    public static function NacinStudijaDelete($id){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "UPDATE nacin_studija SET
        AKTIVNOST = 0
        where  ID_NACIN = :id"
        );
        $statement->bindValue(":id", $id);
        $statement->execute();
        return true;
    }
    public static function ObcinaDelete($id){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "UPDATE obcina SET
        AKTIVNA_OBCINA = 0
        where  ID_OBCINA = :id"
        );
        $statement->bindValue(":id", $id);
        $statement->execute();
        return true;
    }
    public static function OblikaStudijaDelete($id){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "UPDATE oblika_studija SET
        AKTIVNOST = 0
        where  ID_OBLIKA = :id"
        );
        $statement->bindValue(":id", $id);
        $statement->execute();
        return true;
    }
    public static function PostaDelete($id){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "UPDATE posta SET
        AKTIVNOST = 0
        where  ID_POSTA = :id"
        );
        $statement->bindValue(":id", $id);
        $statement->execute();
        return true;
    }
    public static function PredmetDelete($id){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "UPDATE predmet SET
        AKTIVNOST = 0
        where  ID_PREDMET = :id"
        );
        $statement->bindValue(":id", $id);
        $statement->execute();
        return true;
    }
    public static function StudijskoLetoDelete($id){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "UPDATE studijsko_leto SET
        AKTIVNOST = 0
        where  ID_STUD_LETO = :id"
        );
        $statement->bindValue(":id", $id);
        $statement->execute();
        return true;
    }
    public static function VrstaVpisaDelete($id){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "UPDATE vrsta_vpisa SET
        AKTIVNOST = 0
        where  ID_VRSTAVPISA = :id"
        );
        $statement->bindValue(":id", $id);
        $statement->execute();
        return true;
    }









    public static function DelPredmetnikaGet(){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "SELECT * 
                      FROM DEL_PREDMETNIKA
                      "
        );
        $statement->execute();
        return $statement->fetchAll();
    }
    public static function DrzavaGet(){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "SELECT * FROM DRZAVA"
        );
        $statement->execute();
        return $statement->fetchAll();

    }
    public static function LetnikGet(){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "SELECT * FROM LETNIK"
        );
        $statement->execute();
        return $statement->fetchAll();

    }
    public static function NacinStudijaGet(){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "SELECT * FROM NACIN_STUDIJA"
        );
        $statement->execute();
        return $statement->fetchAll();

    }
    public static function ObcinaGet(){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "SELECT * FROM OBCINA"
        );
        $statement->execute();
        return $statement->fetchAll();

    }
    public static function OblikaStudijaGet(){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "SELECT * FROM OBLIKA_STUDIJA"
        );
        $statement->execute();
        return $statement->fetchAll();

    }
    public static function PostaGet(){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "SELECT * FROM POSTA"
        );
        $statement->execute();
        return $statement->fetchAll();

    }
    public static function PredmetGet(){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "SELECT * FROM PREDMET"
        );
        $statement->execute();
        return $statement->fetchAll();

    }
    public static function StudijskoLetoGet(){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "SELECT * FROM STUDIJSKO_LETO"
        );
        $statement->execute();
        return $statement->fetchAll();

    }
    public static function VrstaVpisaGet(){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "SELECT * FROM VRSTA_VPISA"
        );
        $statement->execute();
        return $statement->fetchAll();

    }



    public static function getOneDelPredmetnika($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare(
            "SELECT dp.ID_DELPREDMETNIKA, dp.NAZIV_DELAPREDMETNIKA, dp.SKUPNOSTEVILOKT, dp.TIP
            FROM DEL_PREDMETNIKA as dp
            WHERE dp.ID_DELPREDMETNIKA = :id "
        );
        $statement->bindParam(":id", $id);
        $statement->execute();
        $product = $statement->fetch();
       // var_dump($product);
        if ($product != null) {
            return $product;
        } else {
            throw new InvalidArgumentException("No record with id $id");
        }
    }

    public static function getOneDrzava($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare(
            "SELECT d.ID_DRZAVA, d.DVOMESTNAKODA, d.TRIMESTNAKODA, d.ISONAZIV, d.SLOVENSKINAZIV, d.OPOMBA
            FROM DRZAVA as d
            WHERE d.ID_DRZAVA = :id "
        );
        $statement->bindParam(":id", $id);
        $statement->execute();
        $product = $statement->fetch();
        // var_dump($product);
        if ($product != null) {
            return $product;
        } else {
            throw new InvalidArgumentException("No record with id $id");
        }
    }


    public static function getOneLetnik($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare(
            "SELECT l.ID_LETNIK, l.LETNIK
            FROM LETNIK as l
            WHERE l.ID_LETNIK = :id "
        );
        $statement->bindParam(":id", $id);
        $statement->execute();
        $product = $statement->fetch();
        // var_dump($product);
        if ($product != null) {
            return $product;
        } else {
            throw new InvalidArgumentException("No record with id $id");
        }
    }

    public static function getOneNacinStudija($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare(
            "SELECT ns.ID_NACIN, ns.OPIS_NACIN, ns.ANG_OPIS_NACIN
            FROM NACIN_STUDIJA as ns
            WHERE ns.ID_NACIN = :id "
        );
        $statement->bindParam(":id", $id);
        $statement->execute();
        $product = $statement->fetch();
        // var_dump($product);
        if ($product != null) {
            return $product;
        } else {
            throw new InvalidArgumentException("No record with id $id");
        }
    }

    public static function getOneObcina($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare(
            "SELECT o.ID_OBCINA, o.IME_OBCINA
            FROM OBCINA as o
            WHERE o.ID_OBCINA = :id "
        );
        $statement->bindParam(":id", $id);
        $statement->execute();
        $product = $statement->fetch();
        // var_dump($product);
        if ($product != null) {
            return $product;
        } else {
            throw new InvalidArgumentException("No record with id $id");
        }
    }

    public static function getOneOblikaStudija($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare(
            "SELECT os.ID_OBLIKA, os.NAZIV_OBLIKA, os.ANG_OPIS_OBLIKA
            FROM OBLIKA_STUDIJA as os
            WHERE os.ID_OBLIKA = :id "
        );
        $statement->bindParam(":id", $id);
        $statement->execute();
        $product = $statement->fetch();
        // var_dump($product);
        if ($product != null) {
            return $product;
        } else {
            throw new InvalidArgumentException("No record with id $id");
        }
    }


    public static function getOnePosta($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare(
            "SELECT p.ID_POSTA, p.ST_POSTA, p.KRAJ
            FROM POSTA as p
            WHERE p.ID_POSTA = :id "
        );
        $statement->bindParam(":id", $id);
        $statement->execute();
        $product = $statement->fetch();
        // var_dump($product);
        if ($product != null) {
            return $product;
        } else {
            throw new InvalidArgumentException("No record with id $id");
        }
    }

    public static function getOnePredmet($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare(
            "SELECT p.ID_PREDMET, p.IME_PREDMET
            FROM PREDMET as p
            WHERE p.ID_PREDMET = :id "
        );
        $statement->bindParam(":id", $id);
        $statement->execute();
        $product = $statement->fetch();
        // var_dump($product);
        if ($product != null) {
            return $product;
        } else {
            throw new InvalidArgumentException("No record with id $id");
        }
    }

    public static function getOneStudijskoLeto($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare(
            "SELECT st.ID_STUD_LETO, st.STUD_LETO
            FROM STUDIJSKO_LETO as st
            WHERE st.ID_STUD_LETO = :id "
        );
        $statement->bindParam(":id", $id);
        $statement->execute();
        $product = $statement->fetch();
        // var_dump($product);
        if ($product != null) {
            return $product;
        } else {
            throw new InvalidArgumentException("No record with id $id");
        }
    }

    public static function getOneVrstaVpisa($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare(
            "SELECT v.ID_VRSTAVPISA, v.OPIS_VPISA
            FROM VRSTA_VPISA as v
            WHERE v.ID_VRSTAVPISA = :id "
        );
        $statement->bindParam(":id", $id);
        $statement->execute();
        $product = $statement->fetch();
        // var_dump($product);
        if ($product != null) {
            return $product;
        } else {
            throw new InvalidArgumentException("No record with id $id");
        }
    }


    public static function DelPredmetnikaEdit($id, $naziv, $kt, $tip, $noviId){
        $db = DBInit::getInstance();

        $statement = $db -> prepare(
            "UPDATE del_predmetnika SET
            NAZIV_DELAPREDMETNIKA = :naziv,
            SKUPNOSTEVILOKT = :kt,
            TIP = :tip,
            ID_DELPREDMETNIKA = :novi_id
            WHERE  ID_DELPREDMETNIKA = :id"
        );
        $statement->bindValue(":id", $id);
        $statement->bindValue(":naziv", $naziv);
        $statement->bindValue(":kt", $kt);
        $statement->bindValue(":tip", $tip);
        $statement->bindValue(":novi_id", $noviId);
        try{
            $statement->execute();
            return true;
        } catch (Exception $e){
            var_dump($e);
            return false;
        }
    }

    public static function DrzavaEdit($id,$dk, $tk, $iso, $slo, $opo){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "UPDATE drzava SET
        DVOMESTNAKODA = :dk,
        ISONAZIV = :iso, 
        OPOMBA = :opo, 
        SLOVENSKINAZIV = :slo,
        TRIMESTNAKODA = :tk
        where  ID_DRZAVA = :id"
        );
        $statement->bindValue(":id", $id);
        $statement->bindValue(":dk", $dk);
        $statement->bindValue(":iso", $iso);
        $statement->bindValue(":opo", $opo);
        $statement->bindValue(":slo", $slo);
        $statement->bindValue(":tk", $tk);
        $statement->execute();
        return true;
    }
    public static function LetnikEdit($id,$letnik){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "UPDATE letnik SET
        LETNIK = :letnik
        where  ID_LETNIK = :id"
        );
        $statement->bindValue(":id", $id);
        $statement->bindValue(":letnik", $letnik);
        $statement->execute();
        return true;
    }
    public static function NacinStudijaEdit($id,$opis, $angopis, $noviId){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "UPDATE nacin_studija SET
            ANG_OPIS_NACIN = :ang,
            OPIS_NACIN = :opis,
            ID_NACIN = :novi_id
            WHERE ID_NACIN = :id"
        );
        $statement->bindValue(":id", $id);
        $statement->bindValue(":opis", $opis);
        $statement->bindValue(":ang", $angopis);
        $statement->bindValue(":novi_id", $noviId);
        try{
            $statement->execute();
            return true;
        } catch (Exception $e){
            return false;
        }
    }
    public static function ObcinaEdit($id,$ime,$noviId){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "UPDATE obcina SET
            IME_OBCINA = :ime,
            ID_OBCINA = :novi_id
            where  ID_OBCINA = :id"
        );
        $statement->bindValue(":id", $id);
        $statement->bindValue(":ime", $ime);
        $statement->bindValue(":novi_id", $noviId);
        try{
            $statement->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    public static function OblikaStudijaEdit($id,$naziv,$ang,$noviId){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "UPDATE oblika_studija SET
        ANG_OPIS_OBLIKA = :ang,
        NAZIV_OBLIKA = :naziv,
        ID_OBLIKA = :novi_id
        where  ID_OBLIKA = :id"
        );
        $statement->bindValue(":id", $id);
        $statement->bindValue(":naziv", $naziv);
        $statement->bindValue(":ang", $ang);
        $statement->bindValue(":novi_id", $noviId);

        try{
            $statement->execute();
            return true;
        } catch (Exception $e){
            return false;
        }
    }
    public static function PostaEdit($id,$stevilka, $kt){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "UPDATE posta SET
        ST_POSTA = :stevilka, 
        KRAJ = :kt
        where  ID_POSTA = :id"
        );
        $statement->bindValue(":id", $id);
        $statement->bindValue(":stevilka", $stevilka);
        $statement->bindValue(":kt", $kt);
        $statement->execute();
        return true;
    }

    public static function PredmetEdit($id,$ime,$noviId){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "UPDATE predmet SET
        IME_PREDMET = :ime,
        ID_PREDMET = :novi_id
        where  ID_PREDMET = :id"
        );
        $statement->bindValue(":ime", $ime);
        $statement->bindValue(":id", $id);
        $statement->bindValue(":novi_id", $noviId);

        try{
            $statement->execute();
            return true;
        } catch (Exception $e){
            return false;
        }
    }
    public static function StudijskoLetoEdit($id,$leto,$noviId){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "UPDATE studijsko_leto SET
            STUD_LETO = :leto,
            ID_STUD_LETO = :novi_id
        where  ID_STUD_LETO = :id"
        );
        $statement->bindValue(":leto", $leto);
        $statement->bindValue(":id", $id);
        $statement->bindValue(":novi_id", $noviId);
        try{
            $statement->execute();
            return true;
        } catch (Exception $e){
            return false;
        }
    }

    public static function VrstaVpisaEdit($id,$opis,$noviId){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "UPDATE vrsta_vpisa SET
        OPIS_VPISA = :opis,
        ID_VRSTAVPISA = :novi_id
        where  ID_VRSTAVPISA = :id"
        );
        $statement->bindValue(":opis", $opis);
        $statement->bindValue(":id", $id);
        $statement->bindValue(":novi_id", $noviId);
        try{
            $statement->execute();
            return true;
        } catch (Exception $e){
            return false;
        }
    }
}