<?php

require_once("model/UserModel.php");
require_once("model/User.php");
require_once("model/IzvedbaPredmetaModel.php");
require_once("model/RokModel.php");
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
    
    public static function VnosIzpitnegaRoka() {
        // TODO: check all needed validations
        $data = filter_input_array(INPUT_POST, [
            'idSubject' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => [
                    'min_range' => 1
                ]
            ],
            "DATUM_ROKA" => ["filter" => ...],
            "CAS_ROKA" => ["filter" => ...]
        ]);

        if (self::checkValues($data)) {
            $idIzvedbaPredmeta = IzvedbaPredmetaModel::getIdIzvedbaPredmetaByTheacher(User:getId(), $data["idSubject"]);
            RokModel::insert($idIzvedbaPredmeta, $data["DATUM_ROKA"], $data["CAS_ROKA"]);
            
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