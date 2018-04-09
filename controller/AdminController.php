<?php

require_once("model/AdminDB.php");
require_once("model/UserModel.php");
require_once("model/User.php");
require_once("ViewHelper.php");


class AdminController {
    public static function PregledOsebnihPodatkovStudenta() {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                ViewHelper::render("view/OsebniPodatkiStudenta.php", [
                    "namesAndSurnames" => AdminDB::getAllNames()
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }
    
    public static function searchByVpisna() {
        $data = filter_input_array(INPUT_POST, [
            "searchVpisna" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);

        $studData = AdminDB::getStudentData($data["searchVpisna"]);
        $vpisData = AdminDB::getEnrollmentDetails($data["searchVpisna"]);
        $namesAndSurnames = AdminDB::getAllNames();

        ViewHelper::render("view/OsebniPodatkiStudenta.php", [
            "studData" => $studData,
            "vpisData" => $vpisData,
            "namesAndSurnames" => $namesAndSurnames
        ]);
    }

    public static function PregledPodatkovOIzvajalcih() {
        if (User::isLoggedIn()) {
            if (User::isLoggedInAsAdmin()) {
                ViewHelper::render("view/PodatkiIzvajalcev.php", [
                    "subjects" => array()
                ]);
            } else {
                ViewHelper::error403();
            }
        } else {
            ViewHelper::error401();
        }
    }

    public static function searchBySubject() {
        $data = filter_input_array(INPUT_POST, [
            "searchSubject" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);

        ViewHelper::render("view/PodatkiIzvajalcev.php", [
            "subjects" => IzvedbaPredmetaModel::findSubject($data["searchSubject"])
        ]);
    }


    public static function storeProfessor() {
        $loggedInUser = User::getId();
        $db_connection = DBInit::getInstance();
        $sql = "INSERT INTO izvedba_predmeta (ID_UCITELJ, ID_STUD_LETO, ID_PREDMET) VALUES (?, ?, ?)";
        $stmt = $db_connection->prepare($sql);

        if ($stmt->execute(array((int)$_POST["professor_id"], (int)$_POST["semester_id"], (int)$_POST["subject_id"]))) {
            ViewHelper::redirect(BASE_URL . 'PodatkiOIzvajalcih');
        } else {
            echo "Error: " . $sql . "<br>" . $db_connection->errorInfo();
        }
    }
}
