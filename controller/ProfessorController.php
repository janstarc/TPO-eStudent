<?php

require_once("model/UserModel.php");
require_once("model/ProfesorDB.php");
require_once("model/User.php");
require_once("model/IzvedbaPredmetaModel.php");
require_once("model/RokModel.php");
require_once("model/UciteljModel.php");
require_once("model/StudijskoLetoModel.php");
require_once("ViewHelper.php");

class ProfesorController {
    public static function PregledIzpitovProfesorForm() {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsProfessor()){
                ViewHelper::render("view/PregledIzpitovProfesor.php", []);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }
    
    public static function VnosIzpitovForm() {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsProfessor()){
                ViewHelper::render("view/VnosIzpitov.php", []);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function VnosOcenForm() {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsProfessor()){
                ViewHelper::render("view/VnosOcen.php", []);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }
    
    public static function izpitniRokForm() {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsProfessor()){
                $IdProfesor = UciteljModel::getProfesorId(User::getId());
                $IdProfesor = (int)$IdProfesor["ID_UCITELJ"];
                $IdYear = 2;// TODO StudijskoLetoModel::getIdOfYear(CURRENT_YEAR);
//                var_dump($IdYear);
                $IdIzvedbaPredmeta = IzvedbaPredmetaModel::getIdIzvedbaPredmetaByProfesor($IdProfesor, $IdYear);
//                var_dump($IdIzvedbaPredmeta);
                ViewHelper::render("view/IzpitniRokProfesor.php", [
                    "IdIzvedbaPredmeta" => $IdIzvedbaPredmeta
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function VnosIzpitnegaRoka() {
        // TODO: check all needed validations
        $data = filter_input_array(INPUT_POST, [
            'idSubject' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => [
                    'min_range' => 1
                ]
            ],
            #"DATUM_ROKA" => ["filter" => ...],
            #"CAS_ROKA" => ["filter" => ...]
        ]);

        if (self::checkValues($data)) {
            #$idIzvedbaPredmeta = IzvedbaPredmetaModel::getIdIzvedbaPredmetaByTheacher(User:getId(), $data["idSubject"]);
            #RokModel::insert($idIzvedbaPredmeta, $data["DATUM_ROKA"], $data["CAS_ROKA"]);
            
            //TODO: add name of the view
            ViewHelper::render("view/....php", [
                //"typeOfUser" => (User::isLoggedIn() ? User::getTypeOfUser() : "anonymous-client"),
                "status" => "Success",
                "message" => "You have successfully created a new product."
            ]);
        } else {
            //TODO: add name of the view
            ViewHelper::render("view/....php", [
                //"typeOfUser" => (User::isLoggedIn() ? User::getTypeOfUser() : "anonymous-client"),
                "status" => "Failure",
                "message" => "You have entered an invalid value. Please try again."
            ]);
        }
    }
    
    



    public static function VzdrzevanjePredmetnika() {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsProfessor()){
                ViewHelper::render("view/Vzdrzevanjepredmetnika.php", []);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }
    public static function getPredmeti(){
        return ProfesorDB::getPredmeti();
    }
    public static function getPredmetIme($val){
        return ProfesorDB::getPredmetIme($val);
    }


    public static function getUcitelj($val, $st){
        echo("<script>console.log('controller: ', ".$val.");</script>");
        if ($st == 1)return ProfesorDB::getUcitelj1($val);
        else if($st == 2 )return ProfesorDB::getUcitelj2($val);
        else if($st == 3)return ProfesorDB::getUcitelj3($val);
        else return -1;
    }
    public static function dodaj()
    {

        $data = filter_input_array(INPUT_POST, [
            "ime" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "leto" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS] ,
            "GlavniIme" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "GlavniPriimek" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "2Ime" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "2Priimek" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "3Ime" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "3Priimek" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],

        ]);

        echo("<script>console.log('PHP: ', ".$data["leto"].");</script>");
        $idPredmet = ProfesorDB::addPredmet($data["ime"]);
        $studLeto=ProfesorDB::getStudLeto($data["leto"]);
        $ucitelj = ProfesorDB::getIDucitelj($data["GlavniIme"], $data["GlavniPriimek"]);
        if ($data["2Ime"] != '' or $data["2Priimek"] != '')  $ucitelj2 =getIDucitelj($data["2Ime"], $data["2Priimek"]);
        else $ucitelj2 = "";
        if ($data["3Ime"] != '' or $data["3Priimek"] != '')  $ucitelj3 =getIDucitelj($data["3Ime"], $data["3Priimek"]);
        else $ucitelj3 = "";


        ProfesorDB::addIzvedbaPredmet($idPredmet,$studLeto,$ucitelj,$ucitelj2,$ucitelj3);
        ViewHelper::render("view/Vzdrzevanjepredmetnika.php", []);
    }




    // leave this code on the end of the file
    public static function checkValues($input) {
        if (empty($input)) {
            return FALSE;
        }
        $result = TRUE;
        foreach ($input as $value) {
            $result = $result && $value != false;
        }
        return $result;
    }
    // add code above this code
}