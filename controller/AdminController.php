<?php

require_once("model/AdminDB.php");
require_once("model/UserModel.php");
require_once("model/User.php");
require_once("ViewHelper.php");


class AdminController {
    public static function PregledOsebnihPodatkovStudenta() {
        //if (User::isLoggedIn()){
            //if (User::isLoggedInAsAdmin()){
                ViewHelper::render("view/OsebniPodatkiStudenta.php", [
                    "namesAndSurnames" => AdminDB::getAllNames()
                ]);
          //  }else{
              //  ViewHelper::error403();
          //  }
        //}else{
          //  ViewHelper::error401();
        //}
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

    public static function PregledPodatkovOIzvajalcih()
    {
        $db = DBInit::getInstance();
        $sql = "SELECT * FROM ucitelj";
        $stmt = $db->prepare($sql);

        $professors = array();
        if ($stmt->execute()) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $professors[] = $row;
            }
        }

        $sql1 = "SELECT * FROM studijsko_leto";
        $stmt1 = $db->prepare($sql1);

        $semesters = array();
        if ($stmt1->execute()) {
            while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                $semesters[] = $row;
            }
        }

        $sql2 = "SELECT * FROM predmet";
        $stmt2 = $db->prepare($sql2);

        $subjects = array();
        if ($stmt2->execute()) {
            while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                $subjects[] = $row;
            }
        }

        if (User::isLoggedIn()) {
            if (User::isLoggedInAsStudent()) {  //FIXME:loggedInAsAdmin
                ViewHelper::render("view/PodatkiIzvajalcev.php", [
                    "formAction" => "PodatkiOIzvajalcih",
                    "professors" => $professors,
                    "semesters" => $semesters,
                    "subjects" => $subjects
                ]);
            } else {
                ViewHelper::error403();
            }
        } else {
            ViewHelper::error401();
        }
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
