<?php

require_once("model/AdminDB.php");
require_once("model/UserModel.php");
require_once("model/User.php");
require_once("ViewHelper.php");


class AdminController {




    public static function PregledOsebnihPodatkovStudenta() {
//        if (User::isLoggedIn()){
//            if (User::isLoggedInAsAdmin()){
                ViewHelper::render("view/OsebniPodatkiStudenta.php", []);
        /*    }else{
                        ViewHelper::error403();
                    }
                }else{
                    ViewHelper::error401();
                }
        */
    }

    public static function searchByVpisna(){

        $data = filter_input_array(INPUT_POST, [
            "searchVpisna" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);

        $studData = AdminDB::getStudentData($data["searchVpisna"]);
        $vpisData = AdminDB::getEnrollmentDetails($data["searchVpisna"]);

        ViewHelper::render("view/OsebniPodatkiStudenta.php", [
            "studData" => $studData,
            "vpisData" => $vpisData
        ]);
    }
}
