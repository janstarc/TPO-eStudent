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

    public static function addDelPredmetnika($status = null, $message = null) {
        $data = filter_input_array(INPUT_POST, [
            "naziv_delpredmetnika" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "st_Kt" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS] ,
            "tip" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);

        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
               // var_dump( SifrantDB::DelPredmetnikaGet());
                if(!SifrantDB::isDuplicateDelPredmetnika($data["naziv_delpredmetnika"],$data["st_Kt"],$data["tip"])){
                    SifrantDB::DelPredmetnikaAdd($data["naziv_delpredmetnika"],$data["st_Kt"],$data["tip"]);
                    ViewHelper::render("view/Sifrant/DelPredmetnikaAll.php", [
                        "all" => SifrantDB::DelPredmetnikaGet(),
                        "status" => "Success",
                        "message" => "Dodajanje uspešno"
                    ]);
                } else {
                    ViewHelper::render("view/Sifrant/DelPredmetnikaAll.php", [
                        "all" => SifrantDB::DelPredmetnikaGet(),
                        "status" => "Failure",
                        "message" => "Dodajanje neuspešno - duplikat"
                    ]);
                }
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
                    "getId" => SifrantDB::getOneDelPredmetnika($data["urediId"])
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

        if(!SifrantDB::isDuplicateDelPredmetnika($data["naziv_delpredmetnika"],$data["st_Kt"],$data["tip"])){
            SifrantDB::DelPredmetnikaEdit($data["urediId"], $data["naziv_delpredmetnika"], $data["st_Kt"], $data["tip"]);
            ViewHelper::render("view/Sifrant/DelPredmetnikaAll.php", [
                "all" => SifrantDB::DelPredmetnikaGet(),
                "status" => "Success",
                "message" => "Sprememba uspešna"
            ]);
        } else {
            ViewHelper::render("view/Sifrant/DelPredmetnikaAll.php", [
                "all" => SifrantDB::DelPredmetnikaGet(),
                "status" => "Failure",
                "message" => "Sprememba neuspešna - duplikat"
            ]);
        }
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

                if(!SifrantDB::isDuplicateAddDrzava($data["dvomestnakoda"],$data["trimestnakoda"],$data["isonaziv"],$data["slonaziv"])){
                    SifrantDB::DrzavaAdd($data["dvomestnakoda"],$data["trimestnakoda"],$data["isonaziv"],$data["slonaziv"],$data["opomba"]);
                    ViewHelper::render("view/Sifrant/DrzavaAll.php", [
                        "all" => SifrantDB::DrzavaGet(),
                        "status" => "Success",
                        "message" => "Dodajanje uspešno"
                    ]);
                } else {
                    ViewHelper::render("view/Sifrant/DrzavaAll.php", [
                        "all" => SifrantDB::DrzavaGet(),
                        "status" => "Failure",
                        "message" => "Dodajanje neuspešno - duplikat"
                    ]);
                }
                // var_dump( SifrantDB::DelPredmetnikaGet());

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

        if(!SifrantDB::isDuplicateEditDrzava($data["dvomestnakoda"],$data["trimestnakoda"],$data["isonaziv"],$data["slonaziv"],$data["urediId"])){
            SifrantDB::DrzavaEdit($data["urediId"],$data["dvomestnakoda"],$data["trimestnakoda"],$data["isonaziv"],$data["slonaziv"],$data["opomba"]);
            ViewHelper::render("view/Sifrant/DrzavaAll.php", [
                "all" => SifrantDB::DrzavaGet(),
                "status" => "Success",
                "message" => "Sprememba uspešna"
            ]);
        } else {
            ViewHelper::render("view/Sifrant/DrzavaAll.php", [
                "all" => SifrantDB::DrzavaGet(),
                "status" => "Failure",
                "message" => "Sprememba neuspešna - duplikat"
            ]);
        }
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
                if(!SifrantDB::isDuplicateLetnik($data["letnik"])){
                    SifrantDB::LetnikAdd($data["letnik"]);
                    ViewHelper::render("view/Sifrant/LetnikAll.php", [
                        "all" => SifrantDB::LetnikGet(),
                        "status" => "Success",
                        "message" => "Sprememba uspešna"
                    ]);
                } else {
                    ViewHelper::render("view/Sifrant/LetnikAll.php", [
                        "all" => SifrantDB::LetnikGet(),
                        "status" => "Failure",
                        "message" => "Sprememba neuspešna - duplikat"
                    ]);
                }
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

        if(!SifrantDB::isDuplicateLetnik($data["letnik"])){
            SifrantDB::LetnikEdit($data["urediId"],$data["letnik"]);
            ViewHelper::render("view/Sifrant/LetnikAll.php", [
                "all" => SifrantDB::LetnikGet(),
                "status" => "Success",
                "message" => "Sprememba uspešna"
            ]);
        } else {
            ViewHelper::render("view/Sifrant/LetnikAll.php", [
                "all" => SifrantDB::LetnikGet(),
                "status" => "Failure",
                "message" => "Sprememba neuspešna - duplikat"
            ]);
        }
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
                if(!SifrantDB::isDuplicateAddNacinStudija($data["opis"],$data["angopis"])){
                    SifrantDB::NacinStudijaAdd($data["opis"],$data["angopis"]);
                    ViewHelper::render("view/Sifrant/NacinStudijaAll.php", [
                        "all" => SifrantDB::NacinStudijaGet(),
                        "status" => "Success",
                        "message" => "Sprememba uspešna"
                    ]);
                } else {
                    ViewHelper::render("view/Sifrant/NacinStudijaAll.php", [
                        "all" => SifrantDB::NacinStudijaGet(),
                        "status" => "Failure",
                        "message" => "Sprememba neuspešna - Duplikat"
                    ]);
                }
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

        if(!SifrantDB::isDuplicateEditNacinStudija($data["opis"],$data["angopis"], $data["urediId"])){

            SifrantDB::NacinStudijaEdit($data["urediId"],$data["opis"],$data["angopis"]);
            ViewHelper::render("view/Sifrant/NacinStudijaAll.php", [
                "all" => SifrantDB::NacinStudijaGet(),
                "status" => "Success",
                "message" => "Sprememba uspešna"
            ]);
        } else {
            ViewHelper::render("view/Sifrant/NacinStudijaAll.php", [
                "all" => SifrantDB::NacinStudijaGet(),
                "status" => "Failure",
                "message" => "Sprememba neuspešna - Duplikat"
            ]);
        }
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

                if(!SifrantDB::isDuplicateObcina($data["ime"])){

                    SifrantDB::ObcinaAdd($data["ime"]);
                    ViewHelper::render("view/Sifrant/ObcinaAll.php", [
                        "all" => SifrantDB::ObcinaGet(),
                        "status" => "Success",
                        "message" => "Sprememba uspešna"
                    ]);
                } else {
                    ViewHelper::render("view/Sifrant/ObcinaAll.php", [
                        "all" => SifrantDB::ObcinaGet(),
                        "status" => "Failure",
                        "message" => "Sprememba neuspešna - Duplikat"
                    ]);
                }
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

        if(!SifrantDB::isDuplicateObcina($data["ime"])){

            SifrantDB::ObcinaEdit($data["urediId"],$data["ime"]);
            ViewHelper::render("view/Sifrant/ObcinaAll.php", [
                "all" => SifrantDB::ObcinaGet(),
                "status" => "Success",
                "message" => "Sprememba uspešna"
            ]);
        } else {
            ViewHelper::render("view/Sifrant/ObcinaAll.php", [
                "all" => SifrantDB::ObcinaGet(),
                "status" => "Failure",
                "message" => "Sprememba neuspešna - Duplikat"
            ]);
        }
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




    /************************************************************************************/
    //OBLIKA STUDIJA

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

    public static function getAddOblikaStudija() {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                //  var_dump( SifrantDB::DelPredmetnikaGet());
                ViewHelper::render("view/Sifrant/OblikaStudijaAdd.php", [
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function addOblikaStudija() {
        $data = filter_input_array(INPUT_POST, [
            "opis" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "angopis" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]

        ]);

        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                // var_dump( SifrantDB::DelPredmetnikaGet());

                if(!SifrantDB::isDuplicateOblikaStudija($data["opis"],$data["angopis"])){
                    SifrantDB::OblikaStudijaAdd($data["opis"],$data["angopis"]);
                    ViewHelper::render("view/Sifrant/OblikaStudijaAll.php", [
                        "all" => SifrantDB::OblikaStudijaGet(),
                        "status" => "Success",
                        "message" => "Sprememba uspešna - Duplikat"
                    ]);
                } else {
                    ViewHelper::render("view/Sifrant/OblikaStudijaAll.php", [
                        "all" => SifrantDB::OblikaStudijaGet(),
                        "status" => "Failure",
                        "message" => "Sprememba neuspešna - Duplikat"
                    ]);
                }
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }


    public static function editFormOblikaStudija() {

        $data = filter_input_array(INPUT_POST, [
            "urediId" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
        ]);
        //var_dump($data);
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                ViewHelper::render("view/Sifrant/OblikaStudijaEdit.php", [
                    "getId" => SifrantDB::getOneOblikaStudija($data["urediId"])

                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function editOblikaStudija() {
        $data = filter_input_array(INPUT_POST, [
            "urediId" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "opis" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "angopis" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);
        // var_dump($data);

        if(!SifrantDB::isDuplicateOblikaStudija($data["opis"],$data["angopis"])){
            SifrantDB::OblikaStudijaEdit($data["urediId"],$data["opis"],$data["angopis"]);
            ViewHelper::render("view/Sifrant/OblikaStudijaAll.php", [
                "all" => SifrantDB::OblikaStudijaGet(),
                "status" => "Success",
                "message" => "Sprememba uspešna"
            ]);
        } else {
            ViewHelper::render("view/Sifrant/OblikaStudijaAll.php", [
                "all" => SifrantDB::OblikaStudijaGet(),
                "status" => "Failure",
                "message" => "Sprememba neuspešna - Duplikat"
            ]);
        }
    }

    public static function toogleActivatedOblikaStudija(){
        $data = filter_input_array(INPUT_POST, [
            "activateId" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
        ]);
        //var_dump($data);
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){

                SifrantDB::OblikaStudijaToogleActivated($data["activateId"]);

                ViewHelper::redirect(BASE_URL . "OblikaStudijaAll");

            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }


    /************************************************************************************/
    //POSTA
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

    public static function getAddPosta() {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                //  var_dump( SifrantDB::DelPredmetnikaGet());
                ViewHelper::render("view/Sifrant/PostaAdd.php", [
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function addPosta() {
        $data = filter_input_array(INPUT_POST, [
            "st_posta" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "kraj" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);

        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                // var_dump( SifrantDB::DelPredmetnikaGet());
                SifrantDB::PostaAdd($data["st_posta"],$data["kraj"]);
                ViewHelper::render("view/Sifrant/PostaAdd.php", [
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function editFormPosta() {

        $data = filter_input_array(INPUT_POST, [
            "urediId" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
        ]);
        var_dump($data);
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                ViewHelper::render("view/Sifrant/PostaEdit.php", [
                    "getId" => SifrantDB::getOnePosta($data["urediId"])

                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function editPosta() {
        $data = filter_input_array(INPUT_POST, [
            "urediId" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "st_posta" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "kraj" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);
         var_dump($data);
        SifrantDB::PostaEdit($data["urediId"],$data["st_posta"],$data["kraj"]);
        ViewHelper::redirect(BASE_URL . "PostaAll");

    }

    public static function toogleActivatedPosta(){
        $data = filter_input_array(INPUT_POST, [
            "activateId" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
        ]);
        //var_dump($data);
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){

                SifrantDB::PostaToogleActivated($data["activateId"]);

                ViewHelper::redirect(BASE_URL . "PostaAll");

            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }


    /************************************************************************************/
    //PREDMET

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

    public static function getAddPredmet() {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                //  var_dump( SifrantDB::DelPredmetnikaGet());
                ViewHelper::render("view/Sifrant/PredmetAdd.php", [
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function addPredmet() {
        $data = filter_input_array(INPUT_POST, [
            "predmet" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);

        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                // var_dump( SifrantDB::DelPredmetnikaGet());
                SifrantDB::PredmetAdd($data["predmet"]);
                ViewHelper::render("view/Sifrant/PredmetAdd.php", [
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function editFormPredmet() {

        $data = filter_input_array(INPUT_POST, [
            "urediId" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
        ]);
        //var_dump($data);
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                ViewHelper::render("view/Sifrant/PredmetEdit.php", [
                    "getId" => SifrantDB::getOnePredmet($data["urediId"])

                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function editPredmet() {
        $data = filter_input_array(INPUT_POST, [
            "urediId" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "predmet" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]

        ]);
        // var_dump($data);
        SifrantDB::PredmetEdit($data["urediId"],$data["predmet"]);
        ViewHelper::redirect(BASE_URL . "PredmetAll");

    }

    public static function toogleActivatedPredmet(){
        $data = filter_input_array(INPUT_POST, [
            "activateId" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
        ]);
        //var_dump($data);
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){

                SifrantDB::PredmetToogleActivated($data["activateId"]);

                ViewHelper::redirect(BASE_URL . "PredmetAll");

            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }



    /************************************************************************************/
    //STUDIJSKO LETO

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

    public static function getAddStudijskoLeto() {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                //  var_dump( SifrantDB::DelPredmetnikaGet());
                ViewHelper::render("view/Sifrant/StudijskoLetoAdd.php", [
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function addStudijskoLeto() {
        $data = filter_input_array(INPUT_POST, [
            "stud_leto" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);

        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                // var_dump( SifrantDB::DelPredmetnikaGet());
                SifrantDB::StudijskoLetoAdd($data["stud_leto"]);
                ViewHelper::render("view/Sifrant/StudijskoLetoAdd.php", [
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function editFormStudijskoLeto() {

        $data = filter_input_array(INPUT_POST, [
            "urediId" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
        ]);
        //var_dump($data);
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                ViewHelper::render("view/Sifrant/StudijskoLetoEdit.php", [
                    "getId" => SifrantDB::getOneStudijskoLeto($data["urediId"])

                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function editStudijskoLeto() {
        $data = filter_input_array(INPUT_POST, [
            "urediId" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "stud_leto" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]

        ]);
         var_dump($data);
        SifrantDB::StudijskoLetoEdit($data["urediId"],$data["stud_leto"]);
        ViewHelper::redirect(BASE_URL . "StudijskoLetoAll");

    }




    /************************************************************************************/
    //VRSTA VPISA

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

    public static function getAddVrstaVpisa() {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                //  var_dump( SifrantDB::DelPredmetnikaGet());
                ViewHelper::render("view/Sifrant/VrstaVpisaAdd.php", [
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function addVrstaVpisa() {
        $data = filter_input_array(INPUT_POST, [
            "opis" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);

        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                // var_dump( SifrantDB::DelPredmetnikaGet());
                SifrantDB::VrstaVpisaAdd($data["opis"]);
                ViewHelper::render("view/Sifrant/VrstaVpisaAdd.php", [
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function editFormVrstaVpisa() {

        $data = filter_input_array(INPUT_POST, [
            "urediId" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
        ]);
        //var_dump($data);
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                ViewHelper::render("view/Sifrant/VrstaVpisaEdit.php", [
                    "getId" => SifrantDB::getOneVrstaVpisa($data["urediId"])

                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function editVrstaVpisa() {
        $data = filter_input_array(INPUT_POST, [
            "urediId" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "opis" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]

        ]);
        // var_dump($data);
        SifrantDB::VrstaVpisaEdit($data["urediId"],$data["opis"]);
        ViewHelper::redirect(BASE_URL . "VrstaVpisaAll");

    }

    public static function toogleActivatedVrstaVpisa(){
        $data = filter_input_array(INPUT_POST, [
            "activateId" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
        ]);
        //var_dump($data);
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){

                SifrantDB::VrstaVpisaToogleActivated($data["activateId"]);

                ViewHelper::redirect(BASE_URL . "VrstaVpisaAll");

            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

}