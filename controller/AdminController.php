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





    public static function editFormIzvajalec() {

        $data = filter_input_array(INPUT_POST, [
            "predmetId" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
        ]);
        //var_dump($data["predmetId"]);
        //echo"Alo";
         //var_dump($data);
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){
                $subjectProfessors=ProfesorDB::getSubjectProfessors($data["predmetId"]);
                $profData=array();
               // for($i=0;$i<count($subjectProfessors);$i++){
                 foreach ($subjectProfessors as $val){
              //      echo "htnw4";
                   //  echo $val;
                     if($val!=NULL){
                        $temp=ProfesorDB::getOneIzvajalec($val);
                     //  var_dump($temp);
                    //   var_dump($temp[0]["IME"]);
                        array_push($profData,$temp[0]);
                    }

                }

               // var_dump($profData);


                ViewHelper::render("view/PodatkiIzvajalcevForm.php", [
                    "professors" => ProfesorDB::getAllProfessors(),
                    "profData" => $profData,
                    "predmetId" => $data["predmetId"]
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function editIzvajalec() {
        $data = filter_input_array(INPUT_POST, [
            'predmetId' => [
                'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
            ],
            "ime" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "priimek" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "email" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "telefon" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]

        ]);

        //array(5) { ["urediId"]=> string(1) "2" ["ime"]=> string(9) "Jan, Lina" ["priimek"]=> string(9) "Ban,Yolo," ["email"]=> string(12) "testP,testP1" ["telefon"]=> string(10) "030030030," }
        $ime=explode(",",$data["ime"]);
        $ime=array_map('trim',$ime);
        $ime=array_filter($ime);
        $priimek=explode(",",$data["priimek"]);
        $priimek=array_map('trim',$priimek);
        $priimek=array_filter($priimek);
        $email=explode(",",$data["email"]);
        $email=array_map('trim',$email);
        $email=array_filter($email);
        $telefon=explode(",",$data["telefon"]);
        $telefon=array_map('trim',$telefon);
        $telefon=array_filter($telefon);


        $size=count($ime);
        if(!(count($priimek)==$size && count($email)==$size && count($telefon)==$size)){
            echo "ERROR!";
            return ;
        }
        ProfesorDB::IzvajalecEdit($ime,$priimek,$email,$telefon,$data["predmetId"]);
        ViewHelper::redirect(BASE_URL . "PodatkiIzvajalcev");

    }

    public static function addIzvajalec(){

        $data = filter_input_array(INPUT_POST, [
            "ime" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "priimek" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "email" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "geslo" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "telefon" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]

        ]);

        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){

                ProfesorDB::IzvajalecAdd($data["ime"],$data["priimek"],$data["email"],$data["geslo"],$data["telefon"]);
                ViewHelper::render("view/PodatkiIzvajalcevAdd.php", [

                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }


    public static function getFormIzvajalec(){
        if (User::isLoggedIn()) {
            if (User::isLoggedInAsAdmin()) {
                ViewHelper::render("view/PodatkiIzvajalcevAdd.php", [
                ]);
            } else {
                ViewHelper::error403();
            }
        } else {
            ViewHelper::error401();
        }
    }


    // Render user form

    public static function UvozPodatkov(){

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
        //var_dump($sizeSplitted);

        $mainArray = null;
        if($sizeSplitted > 0){
            $mainArray = self::generateMainArray($splitted, $sizeSplitted);
            //var_dump($mainArray);

            if(is_array($mainArray)){

                $allStudents = UserModel::getAllStudents();
                $mainArray = self::findDuplicates($mainArray, $allStudents);
                var_dump($mainArray);
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

    public static function findDuplicates($mainArray, $allStudents){

        foreach($mainArray as $keyMain => $valueMain){          // V mainArray vpisemo, ce je duplikat ali ne

            foreach ($allStudents as $keyAll => $valueAll){
                if($valueMain['ime'] == $valueAll['ime'] && $valueMain['priimek'] == $valueAll['priimek'] && $valueMain['program'] == $valueAll['sifra_evs'] && $valueMain['email'] == $valueAll['email']){
                    $mainArray[$keyMain]['duplikat'] = "DA";
                }
            }
        }

        return $mainArray;
    }

    // Tokenizes input, removes empty lines from input
    public static function splitInput($toSplit){

        $splitted = explode("&#13;&#10;", $toSplit);
        $splitted = array_filter($splitted);    // Removes empty lines
        $splitted = array_values($splitted);    // Re-Index the array

        return $splitted;
    }

    // Checks length constraints of each input, returns associative array
    public static function generateMainArray($splitted, $sizeSplitted){

            $mainArray = array();
            $temp = array();

            for($i = 0; $i < $sizeSplitted; $i++){

                $temp['ime'] = rtrim(substr($splitted[$i], 0, 30));
                $temp['priimek'] = rtrim(substr($splitted[$i], 30, 30));
                $temp['program'] = rtrim(substr($splitted[$i], 60,7));
                $temp['email'] = rtrim(substr($splitted[$i], 67, 60));
                $temp['duplikat'] = "NE";

                array_push($mainArray, $temp);
            }
            return $mainArray;
    }

    // Generates vpisna, username, pass, returns enriched associative array
    public static function generateVpisnaUnPass($mainArray){

        $out = array();

        foreach ($mainArray as $key => $value){

            $vpisna = rand(63180000, 63189999);

            $imePrva = strtolower(substr($value['ime'], 0, 1));
            $priimekPrva = strtolower(substr($value['priimek'], 0, 1));
            $randomUn = rand(1000, 9999);
            $username = $imePrva.$priimekPrva.$randomUn;

            $pass = self::generatePass(6);

            if($value['duplikat'] == "NE"){
                $value['vpisna'] = $vpisna;
                $value['username'] = $username;
                $value['password'] = $pass;
            } else {
                $value['vpisna'] = "";
                $value['username'] = "";
                $value['password'] = "";
            }

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
            if(is_null($data['leto']) or is_null($data['letnik'])  or is_null($data['program']) or is_null($data['delpredmetnika'])){}
            else AdminDB::addPredmetnik($data);
        }

        $predmetniki = AdminDB::predmetniki($data['idPredmet']);
        ViewHelper::render("view/UrediPredmet.php", [
            "predmetniki" => $predmetniki,
            "predmet" => AdminDB::predmetName($data['idPredmet']),
            "data" => $data

        ]);
    }
    public static function toogleActivated()
    {
        $data = filter_input_array(INPUT_POST, [
            "idPredmetnik" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "idPredmet" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "aktivnost" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);

        if (User::isLoggedIn()) {
            if (User::isLoggedInAsAdmin()) {
                AdminDB::changePredmetnik($data['idPredmetnik']);
                $predmetniki = AdminDB::predmetniki($data['idPredmet']);
                ViewHelper::render("view/UrediPredmet.php", [
                    "predmetniki" => $predmetniki,
                    "predmet" => AdminDB::predmetName($data['idPredmet']),
                    "data" => $data

                ]);

            } else {
                ViewHelper::error403();
            }
        } else {
            ViewHelper::error401();
        }
    }
}
