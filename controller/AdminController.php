<?php

require_once("model/AdminDB.php");
require_once("model/UserModel.php");
require_once("model/User.php");
require_once("ViewHelper.php");


class AdminController {
    public static function pregledOsebnihPodatkovStudenta() {
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

    public static function pregledPodatkovOIzvajalcih() {
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

    // TODO --> Napaka: ne izvajaj QUERYjev iz controllerja, klici model
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

    // Render user form
    public static function uvozPodatkov(){

        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
            ViewHelper::render("view/UvozPodatkov.php", []);
            } else {
                ViewHelper::error403();
            }
        } else {
            ViewHelper::error401();
        }
    }

    // Parse input asd put it to associative array
    public static function parseInput(){

        $data = filter_input_array(INPUT_POST, [
            "podatkiInput" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);

        $splitted = self::splitInput($data["podatkiInput"]);
        $sizeSplitted = count($splitted);

        $mainArray = null;
        if($sizeSplitted % 4 == 0){
            $mainArray = self::generateMainArray($splitted, $sizeSplitted);

            if(is_array($mainArray)){
                $mainArray = self::generateVpisnaUnPass($mainArray);

                // Renders user form to confirm the insert!
                ViewHelper::render("view/UvozPodatkovConfirm.php", [
                    "mainArray" => $mainArray,
                ]);

            } else {
                echo "Vnos '".$mainArray."' presega maksimalno dolžino [Omejitve: Ime in priimek - 30 znakov, Program - 7 znakov, Email - 60 znakov]";
            }
        } else {
            echo "Nepravilna dolžina vnosa - manjkajoči atributi";
        }
    }

    // Tokenizes input, removes empty lines from input
    public static function splitInput($toSplit){
        $splitted = explode( "&#13;&#10;", $toSplit);
        $splitted = array_filter($splitted);    // Removes empty lines
        $splitted = array_values($splitted);    // Re-Index the array

        return $splitted;
    }

    // Checks length constraints of each input, returns associative array
    public static function generateMainArray($splitted, $sizeSplitted){

            $mainArray = array();
            $temp = array();

            for($i = 0; $i < $sizeSplitted; $i+=4){

                if(strlen($splitted[$i]) <= 30){
                    $temp['ime'] = $splitted[$i];
                } else {
                    return $splitted[$i];
                }

                if(strlen($splitted[$i+1]) <= 30){
                    $temp['priimek'] = $splitted[$i+1];
                } else {
                    return $splitted[$i+1];
                }

                if(strlen($splitted[$i+2]) <= 7){
                    $temp['program'] = $splitted[$i+2];
                } else {
                    return $splitted[$i+2];
                }

                if(strlen($splitted[$i+3]) <= 60){
                    $temp['email'] = $splitted[$i+3];
                } else {
                    return $splitted[$i+3];
                }

                array_push($mainArray, $temp);
            }

            return $mainArray;
    }

    // Generates vpisna, username, pass, returns enriched associative array
    public static function generateVpisnaUnPass($mainArray){

        $out = array();

        foreach ($mainArray as $key => $value){

            $vpisna = rand(63180000, 63189999);

            $imePrva = substr($value['ime'], 0, 1);
            $priimekPrva = substr($value['priimek'], 0, 1);
            $randomUn = rand(1000, 9999);
            $username = $imePrva.$priimekPrva.$randomUn;

            $pass = self::generatePass(6);

            $value['vpisna'] = $vpisna;
            $value['username'] = $username;
            $value['password'] = $pass;
            array_push($out, $value);
        }

        return $out;
    }

    // Random string generator
    public static function generatePass($len){

        //Under the string $Caracteres you write all the characters you want to be used to randomly generate the code.
        $Caracteres = 'ABCDEFGHIJKLMNOPQRSTUVXWYZabcdefghijklmnopqrstuvxyz0123456789';
        $QuantidadeCaracteres = strlen($Caracteres);
        $QuantidadeCaracteres--;

        $Hash=NULL;
        for($x=1;$x<=$len;$x++){
            $Posicao = rand(0,$QuantidadeCaracteres);
            $Hash .= substr($Caracteres,$Posicao,1);
        }

        return $Hash;
    }

    // Called from "UvozPodatkovConfirm.php" when user input is confirmed to be inserted
    public static function insertParsedData(){

        $data = $_SESSION['mainArray'];
        UserModel::insertNewStudent($data);
        $result = UserModel::getAllStudents();
        //var_dump($result);
        ViewHelper::render("view/UvozPodatkovSuccess.php", [
            "result" => $result,
        ]);
    }
    public static function VzdrzevanjePredmetnika() {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                $data = AdminDB::getPredmeti();
                ViewHelper::render("view/Vzdrzevanjepredmetnika.php", [
                    "data" => $data
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }
    public static function Predmet(){
        $data = filter_input_array(INPUT_POST, [
            "idPredmet" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);
        $predmetniki = AdminDB::predmetniki($data['idPredmet']);
        ViewHelper::render("view/UrediPredmet.php", [
            "predmetniki" => $predmetniki,
            "predmet" => AdminDB::predmetName($data['idPredmet']),
            "data" => $data

        ]);
    }
    public static function addInPredmetnik(){
        $data = filter_input_array(INPUT_POST, [
            "idPredmetnik" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "idPredmet" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "tip"  => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);
        if($data['tip'] == "d"){
            AdminDB::changePredmetnik($data['idPredmetnik']);
            $predmetniki = AdminDB::predmetniki($data['idPredmet']);
            ViewHelper::render("view/UrediPredmet.php", [
                "predmetniki" => $predmetniki,
                "predmet" => AdminDB::predmetName($data['idPredmet']),
                "data" => $data

            ]);
        }
        else {
            ViewHelper::render("view/predmetnik.php", [
                "data" => $data,
                "all" => AdminDB::all(),
                "predmetnik" => AdminDB::predmetnik($data['idPredmetnik'])

            ]);
        }

    }
    public static function spremeniPredmetnik(){
        $data = filter_input_array(INPUT_POST, [
            "tip" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "leto" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS] ,
            "letnik" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "program" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "delpredmetnika" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "id" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "idPredmet" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "idPredmetnik" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]

        ]);

        if($data['tip'] == "e"){

            AdminDB::editPredmetnik($data);
        }
        else{
            AdminDB::addPredmetnik($data);
        }

        $predmetniki = AdminDB::predmetniki($data['idPredmet']);
        ViewHelper::render("view/UrediPredmet.php", [
            "predmetniki" => $predmetniki,
            "predmet" => AdminDB::predmetName($data['idPredmet']),
            "data" => $data

        ]);
    }
}
