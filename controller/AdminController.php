<?php

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
}
