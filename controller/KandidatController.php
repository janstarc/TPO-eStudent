<?php

require_once("model/KandidatModel.php");
require_once("model/ObcinaModel.php");
require_once("model/PostaModel.php");
require_once("model/DrzavaModel.php");
require_once("model/UserModel.php");
require_once("model/User.php");
require_once("ViewHelper.php");

class KandidatController {
    public static function vpisForm($status = null, $message = null) {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsCandidate()) {
                $KandidatId = KandidatModel::getKandidatIdWithUserId(User::getId());
                $KandidatPodatki = KandidatModel::getKandidatPodatki($KandidatId);
                $stud_leto = KandidatModel::getStudijskoLeto($KandidatPodatki["id_stud_leto"]);
                $obcine = ObcinaModel::getAll();
                $poste = PostaModel::getAll();
                $drzave = DrzavaModel::getAll();
                $userName = UserModel::getUserName(User::getId());
                
                ViewHelper::render("view/VpisniListViewer.php", [
                    "pageTitle" => "Vpisni list",
                    "formAction" => "vpis",
                    "KandidatPodatki" => $KandidatPodatki,
                    "stud_leto" => $stud_leto,
                    "obcine" => $obcine,
                    "poste" => $poste,
                    "drzave" => $drzave,
                    "userName" => $userName,
                    "status" => $status,
                    "message" => $message
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }
}