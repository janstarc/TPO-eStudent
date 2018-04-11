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

    public static function uvozPodatkov(){

        ViewHelper::render("view/UvozPodatkov.php", []);
    }

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
                //var_dump($mainArray);
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

    public static function splitInput($toSplit){
        $splitted = explode( "&#13;&#10;", $toSplit);
        $splitted = array_filter($splitted);    // Removes empty lines
        $splitted = array_values($splitted);    // Re-Index the array

        return $splitted;
    }

    // Checks length of each input, returns associative array
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

    public static function insertParsedData(){

        $data = $_SESSION['mainArray'];
        //var_dump($data);
        UserModel::insertNewStudent($data);

    }
}
