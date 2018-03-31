<?php

require_once("model/AdminDB.php");
require_once("model/UserModel.php");
require_once("model/User.php");
require_once("ViewHelper.php");


class AdminController {




    public static function PregledOsebnihPodatkovStudenta() {
        //if (User::isLoggedIn()){
            //if (User::isLoggedInAsAdmin()){

                $namesAndSurnames = AdminDB::getAllNames();
                //var_dump($namesAndSurnames);

                ViewHelper::render("view/OsebniPodatkiStudenta.php", [
                    "namesAndSurnames" => $namesAndSurnames
                ]);

                //ViewHelper::render("view/OsebniPodatkiStudenta.php", []);
                //returnAllNames();
          //  }else{
              //  ViewHelper::error403();
          //  }
        //}else{
          //  ViewHelper::error401();
        //}

    }

    public static function searchByVpisna(){

        $data = filter_input_array(INPUT_POST, [
            "searchVpisna" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);

        //var_dump($data['searchVpisna']);
        $studData = AdminDB::getStudentData($data["searchVpisna"]);
        $vpisData = AdminDB::getEnrollmentDetails($data["searchVpisna"]);
        $namesAndSurnames = AdminDB::getAllNames();

        ViewHelper::render("view/OsebniPodatkiStudenta.php", [
            "studData" => $studData,
            "vpisData" => $vpisData,
            "namesAndSurnames" => $namesAndSurnames
        ]);
    }
}
