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
        (NAZIV_DELAPREDMETNIKA,SKUPNOSTEVILOKT,AKTIVNOST_DELPREDMETNIKA,TIP)
        VALUES(:naziv,:kt,1,:tip);"
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
        (OPIS_NACIN,ANG_OPIS_NACIN,AKTIVNOST_NACIN)
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
        (NAZIV_OBLIKA,ANG_OPIS_OBLIKA,AKTIVNOST_OBLIKA)
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
        (ST_POSTA,KRAJ,AKTIVNOST_POSTA)
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
        (IME_PREDMET,AKTIVNOST_PREDMET)
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
        (STUD_LETO,AKTIVNOST_STUDIJSKOLETO)
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
        (OPIS_VPISA,AKTIVNOST_VPIS)
        VALUES(:opis,1);"
        );
        $statement->bindValue(":opis", $opis);
        $statement->execute();
        return true;
    }




    public static function DelPredmetnikaDelete($id){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "UPDATE del_predmetnika SET
        AKTIVNOST_DELPREDMETNIKA = 0
        where  ID_DELPREDMETNIKA = :id"
        );
        $statement->bindValue(":id", $id);
        $statement->execute();
        return true;
    }
    public static function DrzavaDelete($id){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "UPDATE drzava SET
        AKTIVNOST_DRZAVA = 0
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
        AKTIVNOST_LETNIK = 0
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
        AKTIVNOST_NACIN = 0
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
        AKTIVNOST_OBLIKA = 0
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
        AKTIVNOST_POSTA = 0
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
        AKTIVNOST_PREDMET = 0
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
        AKTIVNOST_STUDIJSKOLETO = 0
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
        AKTIVNOST_VPIS = 0
        where  ID_VRSTAVPISA = :id"
        );
        $statement->bindValue(":id", $id);
        $statement->execute();
        return true;
    }





    public static function DelPredmetnikaGet(){
        $db = DBInit::getInstance();
        $statement = $db -> prepare(
            "SELECT * FROM DEL_PREDMETNIKA"
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




    public static function DelPredmetnikaEdit(){

    }
    public static function DrzavaEdit(){

    }
    public static function LetnikEdit(){

    }
    public static function NacinStudijaEdit(){

    }
    public static function ObcinaEdit(){

    }
    public static function OblikaStudijaEdit(){

    }
    public static function PostaEdit(){

    }
    public static function PredmetEdit(){

    }
    public static function StudijskoLetoEdit(){

    }
    public static function VrstaVpisaEdit(){

    }





}