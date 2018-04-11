<?php

require_once("model/UserModel.php");
require_once("model/User.php");
require_once("model/SifrantDB.php");
require_once("ViewHelper.php");

class SifrantController
{

    /************************************************************************************/
    //DEL PREDMETNIKA
    public static function getDelPredmetnika() {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
              //  var_dump( SifrantDB::DelPredmetnikaGet());
                ViewHelper::render("view/Sifrant/DelPredmetnikaAll.php", [
                    "all" => SifrantDB::DelPredmetnikaGet()
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function getAddDelPredmetnika() {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                //  var_dump( SifrantDB::DelPredmetnikaGet());
                ViewHelper::render("view/Sifrant/DelPredmetnikaAdd.php", [
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function addDelPredmetnika() {
        $data = filter_input_array(INPUT_POST, [
            "naziv_delpredmetnika" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "st_Kt" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS] ,
            "tip" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);

        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
               // var_dump( SifrantDB::DelPredmetnikaGet());
                SifrantDB::DelPredmetnikaAdd($data["naziv_delpredmetnika"],$data["st_Kt"],$data["tip"]);
                ViewHelper::render("view/Sifrant/DelPredmetnikaAdd.php", [
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function editFormDelPredmetnika() {

        $data = filter_input_array(INPUT_POST, [
            "urediId" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
        ]);
       // var_dump($data);
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                   ViewHelper::render("view/Sifrant/DelPredmetnikaEdit.php", [
                    "getId" => SifrantDB::getOneDelPredmetniks($data["urediId"])

                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function editDelPredmetnika() {
        $data = filter_input_array(INPUT_POST, [
            'urediId' => [
                'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
            ],
            "naziv_delpredmetnika" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "st_Kt" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "tip" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);
       //     echo "Edit del predmetnika";
           // var_dump($data);
            SifrantDB::DelPredmetnikaEdit($data["urediId"], $data["naziv_delpredmetnika"], $data["st_Kt"], $data["tip"]);
            ViewHelper::redirect(BASE_URL . "DelPredmetnikaAll");

    }

    public static function toogleActivatedDelPredmetnika(){
        $data = filter_input_array(INPUT_POST, [
            "activateId" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
        ]);
        var_dump($data);
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){

                SifrantDB::DelPredmetnikaToogleActivated($data["activateId"]);

                ViewHelper::redirect(BASE_URL . "DelPredmetnikaAll");

            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }


    /************************************************************************************/
    //DRZAVA
    public static function getDrzava() {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                ViewHelper::render("view/Sifrant/DrzavaAll.php", [
                    "all" => SifrantDB::DrzavaGet()
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function getAddDrzava() {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                //  var_dump( SifrantDB::DelPredmetnikaGet());
                ViewHelper::render("view/Sifrant/DrzavaAdd.php", [
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function addDrzava() {
        $data = filter_input_array(INPUT_POST, [
            "dvomestnakoda" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "trimestnakoda" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS] ,
            "isonaziv" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "slonaziv" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "opomba" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);

        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                // var_dump( SifrantDB::DelPredmetnikaGet());
                SifrantDB::DrzavaAdd($data["dvomestnakoda"],$data["trimestnakoda"],$data["isonaziv"],$data["slonaziv"],$data["opomba"]);
                ViewHelper::render("view/Sifrant/DrzavaAdd.php", [
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function editFormDrzava() {

        $data = filter_input_array(INPUT_POST, [
            "urediId" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
        ]);
         var_dump($data);
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                ViewHelper::render("view/Sifrant/DrzavaEdit.php", [
                    "getId" => SifrantDB::getOneDrzava($data["urediId"])

                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function editDrzava() {
        $data = filter_input_array(INPUT_POST, [
            "urediId" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "dvomestnakoda" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "trimestnakoda" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS] ,
            "isonaziv" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "slonaziv" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "opomba" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);
       // var_dump($data);
        SifrantDB::DrzavaEdit($data["urediId"],$data["dvomestnakoda"],$data["trimestnakoda"],$data["isonaziv"],$data["slonaziv"],$data["opomba"]);
        ViewHelper::redirect(BASE_URL . "DrzavaAll");

    }

    public static function toogleActivatedDrzava(){
        $data = filter_input_array(INPUT_POST, [
            "activateId" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
        ]);
        //var_dump($data);
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){

                SifrantDB::DrzavaToogleActivated($data["activateId"]);

                ViewHelper::redirect(BASE_URL . "DrzavaAll");

            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    /************************************************************************************/
    //LETNIK

    public static function getLetnik() {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                ViewHelper::render("view/Sifrant/LetnikAll.php", [
                    "all" => SifrantDB::LetnikGet()
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function getAddLetnik() {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                //  var_dump( SifrantDB::DelPredmetnikaGet());
                ViewHelper::render("view/Sifrant/LetnikAdd.php", [
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function addLetnik() {
        $data = filter_input_array(INPUT_POST, [
            "letnik" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);

        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                // var_dump( SifrantDB::DelPredmetnikaGet());
                SifrantDB::LetnikAdd($data["letnik"]);
                ViewHelper::render("view/Sifrant/LetnikAdd.php", [
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function editFormLetnik() {

        $data = filter_input_array(INPUT_POST, [
            "urediId" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
        ]);
        //var_dump($data);
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                ViewHelper::render("view/Sifrant/LetnikEdit.php", [
                    "getId" => SifrantDB::getOneLetnik($data["urediId"])

                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function editLetnik() {
        $data = filter_input_array(INPUT_POST, [
            "urediId" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "letnik" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]

        ]);
        // var_dump($data);
        SifrantDB::LetnikEdit($data["urediId"],$data["letnik"]);
        ViewHelper::redirect(BASE_URL . "LetnikAll");

    }

    /************************************************************************************/
    //NACIN STUDIJA

    public static function getNacinStudija() {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                ViewHelper::render("view/Sifrant/NacinStudijaAll.php", [
                    "all" => SifrantDB::NacinStudijaGet()
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function getAddNacinStudija() {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                //  var_dump( SifrantDB::DelPredmetnikaGet());
                ViewHelper::render("view/Sifrant/NacinStudijaAdd.php", [
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function addNacinStudija() {
        $data = filter_input_array(INPUT_POST, [
            "opis" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "angopis" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]

        ]);

        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                // var_dump( SifrantDB::DelPredmetnikaGet());
                SifrantDB::NacinStudijaAdd($data["opis"],$data["angopis"]);
                ViewHelper::render("view/Sifrant/NacinStudijaAdd.php", [
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }


    public static function editFormNacinStudija() {

        $data = filter_input_array(INPUT_POST, [
            "urediId" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
        ]);
        //var_dump($data);
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                ViewHelper::render("view/Sifrant/NacinStudijaEdit.php", [
                    "getId" => SifrantDB::getOneNacinStudija($data["urediId"])

                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function editNacinStudija() {
        $data = filter_input_array(INPUT_POST, [
            "urediId" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "opis" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "angopis" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);
        // var_dump($data);
        SifrantDB::NacinStudijaEdit($data["urediId"],$data["opis"],$data["angopis"]);
        ViewHelper::redirect(BASE_URL . "NacinStudijaAll");

    }

    public static function toogleActivatedNacinStudija(){
        $data = filter_input_array(INPUT_POST, [
            "activateId" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
        ]);
        //var_dump($data);
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){

                SifrantDB::NacinStudijaToogleActivated($data["activateId"]);

                ViewHelper::redirect(BASE_URL . "NacinStudijaAll");

            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }


    /************************************************************************************/
    //OBCINA

    public static function getObcina() {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                ViewHelper::render("view/Sifrant/ObcinaAll.php", [
                    "all" => SifrantDB::ObcinaGet()
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function getAddObcina() {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                //  var_dump( SifrantDB::DelPredmetnikaGet());
                ViewHelper::render("view/Sifrant/ObcinaAdd.php", [
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function addObcina() {
        $data = filter_input_array(INPUT_POST, [
            "ime" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]

        ]);

        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                // var_dump( SifrantDB::DelPredmetnikaGet());
                SifrantDB::ObcinaAdd($data["ime"]);
                ViewHelper::render("view/Sifrant/ObcinaAdd.php", [
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }


    public static function editFormObcina() {

        $data = filter_input_array(INPUT_POST, [
            "urediId" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
        ]);
        //var_dump($data);
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                ViewHelper::render("view/Sifrant/ObcinaEdit.php", [
                    "getId" => SifrantDB::getOneObcina($data["urediId"])

                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function editObcina() {
        $data = filter_input_array(INPUT_POST, [
            "urediId" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "ime" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);
        // var_dump($data);
        SifrantDB::ObcinaEdit($data["urediId"],$data["ime"]);
        ViewHelper::redirect(BASE_URL . "ObcinaAll");

    }

    public static function toogleActivatedObcina(){
        $data = filter_input_array(INPUT_POST, [
            "activateId" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
        ]);
        //var_dump($data);
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){

                SifrantDB::ObcinaToogleActivated($data["activateId"]);

                ViewHelper::redirect(BASE_URL . "ObcinaAll");

            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }





    public static function getOblikaStudija() {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                ViewHelper::render("view/Sifrant/OblikaStudijaAll.php", [
                    "all" => SifrantDB::OblikaStudijaGet()
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function getPosta() {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                ViewHelper::render("view/Sifrant/PostaAll.php", [
                    "all" => SifrantDB::PostaGet()
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function getPredmet() {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                ViewHelper::render("view/Sifrant/PredmetAll.php", [
                    "all" => SifrantDB::PredmetGet()
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function getStudijskoLeto() {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                ViewHelper::render("view/Sifrant/StudijskoLetoAll.php", [
                    "all" => SifrantDB::StudijskoLetoGet()
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function getVrstaVpisa() {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                ViewHelper::render("view/Sifrant/VrstaVpisaAll.php", [
                    "all" => SifrantDB::VrstaVpisaGet()
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }




}