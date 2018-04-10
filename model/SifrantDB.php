<?php
/**
 * Created by PhpStorm.
 * User: Paule
 * Date: 09/04/2018
 * Time: 14:35
 */

class SifrantDB
{
    public static function DelPredmetnikaAdd($naziv, $kt, $tip){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "INSERT INTO del_predmetnika
        (NAZIV_DELAPREDMETNIKA,SKUPNOSTEVILOKT,TIP,AKTIVNOST)
        VALUES(:naziv,:kt,:tip,1);"
        );
        $statement->bindValue(":naziv", $naziv);
        $statement->bindValue(":kt", $kt);
        $statement->bindValue(":tip", $tip);
        $statement->execute();
        return true;
    }
    public static function DrzavaAdd($dk, $tk, $iso, $slo, $opo){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "INSERT INTO drzava
        (DVOMESTNAKODA,TRIMESTNAKODA,ISONAZIV,SLOVENSKINAZIV,OPOMBA)VALUES
        (:dk, :tk, :iso, :slo, :opo);"
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
              (LETNIK,MOZEN_VPIS)VALUES
              (:letnik,1);"
        );
        $statement->bindValue(":letnik", $letnik);
        $statement->execute();
        return true;
    }
    public static function NacinStudijaAdd($opis, $angopis){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "INSERT INTO nacin_studija
        (OPIS_NACIN,ANG_OPIS_NACIN,AKTIVNOST)
        VALUES(:opis,:angopis,1);"
        );
        $statement->bindValue(":opis", $opis);
        $statement->bindValue(":angopis", $angopis);

        $statement->execute();
        return true;
    }
    public static function ObcinaAdd($ime){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "INSERT INTO obcina
        (IME_OBCINA,AKTIVNA_OBCINA)
        VALUES(:ime,1);"
        );
        $statement->bindValue(":ime", $ime);
        $statement->execute();
        return true;
    }

    public static function OblikaStudijaAdd($naziv,$ang){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "INSERT INTO oblika_studija
        (NAZIV_OBLIKA,ANG_OPIS_OBLIKA,AKTIVNOST)
        VALUES(:naziv,:ang,1);"
        );
        $statement->bindValue(":naziv", $naziv);
        $statement->bindValue(":ang", $ang);

        $statement->execute();
        return true;
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
    public static function PredmetAdd($ime){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "INSERT INTO predmet
        (IME_PREDMET,AKTIVNOST)
        VALUES(:ime,1);"
        );
        $statement->bindValue(":ime", $ime);
        $statement->execute();
        return true;
    }
    public static function StudijskoLetoAdd($leto){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "INSERT INTO studijsko_leto
        (STUD_LETO,AKTIVNOST)
        VALUES(:leto,1);"
        );
        $statement->bindValue(":leto", $leto);
        $statement->execute();
        return true;

    }
    public static function VrstaVpisaAdd($opis){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "INSERT INTO vrsta_vpisa
        (OPIS_VPISA,AKTIVNOST)
        VALUES(:opis,1);"
        );
        $statement->bindValue(":opis", $opis);
        $statement->execute();
        return true;
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



    public static function getOneDelPredmetniks($id) {
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



    public static function DelPredmetnikaEdit($id, $naziv, $kt, $tip){
        $db = DBInit::getInstance();
        //echo $id . $naziv . $kt .$tip;
        $statement = $db -> prepare(
            "UPDATE del_predmetnika SET
        NAZIV_DELAPREDMETNIKA = :naziv,
        SKUPNOSTEVILOKT = :kt,
        TIP = :tip
        where  ID_DELPREDMETNIKA = :id"
        );
        $statement->bindValue(":id", $id);
        $statement->bindValue(":naziv", $naziv);
        $statement->bindValue(":kt", $kt);
        $statement->bindValue(":tip", $tip);
        $statement->execute();
        return true;
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
        where  ID_DRZAVE = :id"
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
    public static function NacinStudijaEdit($id,$opis, $angopis){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "UPDATE nacin_studija SET
        ANG_OPIS_NACIN = :ang,
        OPIS_NACIN = :opis
        where  ID_NACIN = :id"
        );
        $statement->bindValue(":id", $id);
        $statement->bindValue(":opis", $opis);
        $statement->bindValue(":ang", $angopis);
        $statement->execute();
        return true;
    }
    public static function ObcinaEdit($id,$ime){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "UPDATE obcina SET
        IME_OBCINA = :ime
        where  ID_OBCINA = :id"
        );
        $statement->bindValue(":id", $id);
        $statement->bindValue(":ime", $ime);
        $statement->execute();
        return true;
    }
    public static function OblikaStudijaEdit($id,$naziv,$ang){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "UPDATE oblika_studija SET
        ANG_OPIS_OBLIKA = :ang,
        NAZIV_OBLIKA = :naziv
        where  ID_OBLIKA = :id"
        );
        $statement->bindValue(":id", $id);
        $statement->bindValue(":naziv", $naziv);
        $statement->bindValue(":ang", $ang);
        $statement->execute();
        return true;
    }
    public static function PostaEdit($id,$stevilka, $kt){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "UPDATE posta SET
        ST_POSTA = :st, 
        KRAJ = :kr
        where  ID_POSTA = :id"
        );
        $statement->bindValue(":id", $id);
        $statement->bindValue(":st", $stevilka);
        $statement->bindValue(":kr", $kt);
        $statement->execute();
        return true;
    }
    public static function PredmetEdit($id,$ime){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "UPDATE predmet SET
        IME_PREDMET = :ime
        where  ID_PREDMET = :id"
        );
        $statement->bindValue(":ime", $ime);
        $statement->bindValue(":id", $id);
        $statement->execute();
        return true;
    }
    public static function StudijskoLetoEdit($id,$leto){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "UPDATE studijsko_leto SET
            STUD_LETO = :leto
        where  ID_STUD_LETO = :id"
        );
        $statement->bindValue(":leto", $leto);
        $statement->bindValue(":id", $id);
        $statement->execute();
        return true;
    }
    public static function VrstaVpisaEdit($id,$opis ){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "UPDATE vrsta_vpisa SET
        OPIS_VPISA = :opis
        where  ID_VRSTAVPISA = :id"
        );
        $statement->bindValue(":opis", $opis);
        $statement->bindValue(":id", $id);
        $statement->execute();
        return true;

    }

}