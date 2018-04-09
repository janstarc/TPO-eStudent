<?php

require_once("model/UserModel.php");
require_once("model/User.php");
require_once("model/SifrantDB.php");
require_once("ViewHelper.php");

class SifrantController
{
    public static function getDelPredmetnika() {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                var_dump( SifrantDB::DelPredmetnikaGet());
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