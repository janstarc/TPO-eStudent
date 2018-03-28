<?php

require_once("model/UserModel.php");
require_once("model/User.php");
require_once("ViewHelper.php");

class ProffesorController {
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
}