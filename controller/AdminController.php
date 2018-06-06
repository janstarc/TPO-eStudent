<?php

require_once("model/AdminDB.php");
require_once("model/UserModel.php");
require_once("model/User.php");
require_once("ViewHelper.php");
require ("view/includes/fpdf.php");
require_once ("view/includes/tfpdf.php");
require ("view/includes/helveticab.php");


class AdminController {
    public static function pregledOsebnihPodatkovStudenta() {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin() || User::isLoggedInAsProfessor()){
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

    public static function PregledIzvajalcevIzbiraPredmet($id_leto,$status = null, $message = null) {
        if (User::isLoggedIn()) {
            if (User::isLoggedInAsAdmin()) {


                $allData=StudentOfficerDB::getPredmetiZaStudLeto($id_leto);

                ViewHelper::render("view/PodatkiIzvajalcevPredmet.php", [
                    "pageTitle" => "Seznam vseh predmetov",
                    "allData" => $allData,
                    "id_leto" => $id_leto,
                    "status" => $status,
                    "message" => $message,
                ]);
            } else {
                ViewHelper::error403();
            }
        } else {
            ViewHelper::error401();
        }
    }



    public static function PregledIzvajalcevIzbiraLeto($status = null, $message = null) {
        if (User::isLoggedIn()) {
            if (User::isLoggedInAsAdmin()) {

                ViewHelper::render("view/PodatkiIzvajalcevLeto.php", [
                    "pageTitle" => "Seznam vseh študijskih let",
                    "allData" => PredmetModel::getAllLeta(),
                    "formAction" => "PodatkiIzvajalcev/leto",
                    "status" => $status,
                    "message" => $message,


                ]);
            } else {
                ViewHelper::error403();
            }
        } else {
            ViewHelper::error401();
        }
    }

    public static function prikazIzvajalcev($id_leto,$id_predmet,$status = null, $message = null){
        if (User::isLoggedIn()) {
            if (User::isLoggedInAsAdmin()) {

                $profesori=IzvedbaPredmetaModel::getAllProfesori();
                ViewHelper::render("view/PodatkiIzvajalcev.php", [
                    "first" => IzvedbaPredmetaModel::getFirst($id_predmet,$id_leto),
                    "second" => IzvedbaPredmetaModel::getSecond($id_predmet,$id_leto),
                    "third" => IzvedbaPredmetaModel::getThird($id_predmet,$id_leto),
                    "status" => $status,
                    "message" => $message,
                    "profesori" => $profesori,
                    "id_predmet" => $id_predmet,
                    "id_leto" => $id_leto
                ]);
            } else {
                ViewHelper::error403();
            }
        } else {
            ViewHelper::error401();
        }
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





    public static function editFormIzvajalec($id_predmet,$id_leto) {

        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){

               $getIzvajalec1= IzvedbaPredmetaModel::getFirst($id_predmet,$id_leto);
              // var_dump($getIzvajalec1);
                ViewHelper::render("view/PodatkiIzvajalcevForm.php", [
                    "getIzvajalec1" => $getIzvajalec1,
                    "profesori" => IzvedbaPredmetaModel::getAllProfesori(),
                    "id_predmet" => $id_predmet,
                    "id_leto" => $id_leto
                    ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function editIzvajalec($id_predmet,$id_leto) {
        $data = filter_input_array(INPUT_POST, [
            "uporabnisko_ime" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "email" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "telefonska_stevilka" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]

        ]);

        $razdeli=explode(" ",$data["imePriimek"]);
        var_dump($razdeli);
        $ime=$razdeli[0];
        $priimek=$razdeli[1];
        $id_oseba=$razdeli[2];
        $email=$data["email"];
        $uporabnisko_ime=$data["uporabnisko_ime"];
        $telefon=$data["telefonska_stevilka"];
        ProfesorDB::IzvajalecEdit($ime,$priimek,$email,$uporabnisko_ime,$telefon,$id_predmet,$id_leto,$id_oseba);
        ViewHelper::redirect(BASE_URL . "PodatkiIzvajalcev/leto/".$id_predmet."/".$id_leto);

    }


    public static function editFirstIzvajalec($id_leto,$id_predmet) {
        $data = filter_input_array(INPUT_POST, [
            "imePriimek" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],

        ]);

        $razdeli=explode(" ",$data["imePriimek"]);
        //var_dump($razdeli);
        $id_oseba=$razdeli[2];


        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){


                $id_oseba1=ProfesorDB::GetIzvajalec1($id_leto,$id_predmet);
                $id_oseba2=ProfesorDB::GetIzvajalec2($id_leto,$id_predmet);
                $id_oseba3=ProfesorDB::GetIzvajalec3($id_leto,$id_predmet);


                if($id_oseba == $id_oseba1["ID_OSEBA1"] || $id_oseba == $id_oseba2["ID_OSEBA2"] || $id_oseba == $id_oseba3["ID_OSEBA3"]){
                    //echo "NAPAKA";
                    ViewHelper::redirect(BASE_URL . "PodatkiIzvajalcev/leto/".$id_leto."/".$id_predmet);

                }else{
                    ProfesorDB::FirstIzvajalecEdit($id_predmet,$id_leto,$id_oseba);
                    ViewHelper::redirect(BASE_URL . "PodatkiIzvajalcev/leto/".$id_leto."/".$id_predmet);
                }



            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function editFirstIzvajalecForm($id_leto,$id_predmet) {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){

                ViewHelper::render("view/PodatkiIzvajalcevForm.php", [
                    "profesori" => IzvedbaPredmetaModel::getAllProfesori(),
                    "id_predmet" => $id_predmet,
                    "id_leto" => $id_leto
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }

    }


    public static function editSecondIzvajalec($id_leto,$id_predmet) {
        $data = filter_input_array(INPUT_POST, [
            "imePriimek" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],

        ]);

        $razdeli=explode(" ",$data["imePriimek"]);
        //var_dump($razdeli);
        $id_oseba=$razdeli[2];


        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){

                $id_oseba1=ProfesorDB::GetIzvajalec1($id_leto,$id_predmet);
                $id_oseba2=ProfesorDB::GetIzvajalec2($id_leto,$id_predmet);
                $id_oseba3=ProfesorDB::GetIzvajalec3($id_leto,$id_predmet);


                if($id_oseba == $id_oseba1["ID_OSEBA1"] || $id_oseba == $id_oseba2["ID_OSEBA2"] || $id_oseba == $id_oseba3["ID_OSEBA3"]){
                    //echo "NAPAKA";
                    ViewHelper::redirect(BASE_URL . "PodatkiIzvajalcev/leto/".$id_leto."/".$id_predmet);

                }else{
                    ProfesorDB::SecondIzvajalecEdit($id_predmet,$id_leto,$id_oseba);
                    ViewHelper::redirect(BASE_URL . "PodatkiIzvajalcev/leto/".$id_leto."/".$id_predmet);
                }


            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function editSecondIzvajalecForm($id_leto,$id_predmet) {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){

                ViewHelper::render("view/PodatkiIzvajalcevForm2.php", [
                    "profesori" => IzvedbaPredmetaModel::getAllProfesori(),
                    "id_predmet" => $id_predmet,
                    "id_leto" => $id_leto
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }

    }

    public static function editThirdIzvajalec($id_leto,$id_predmet) {
        $data = filter_input_array(INPUT_POST, [
            "imePriimek" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],

        ]);

        $razdeli=explode(" ",$data["imePriimek"]);
        //var_dump($razdeli);
        $id_oseba=$razdeli[2];


        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){

                $id_oseba1=ProfesorDB::GetIzvajalec1($id_leto,$id_predmet);
                $id_oseba2=ProfesorDB::GetIzvajalec2($id_leto,$id_predmet);
                $id_oseba3=ProfesorDB::GetIzvajalec3($id_leto,$id_predmet);


                if($id_oseba == $id_oseba1["ID_OSEBA1"] || $id_oseba == $id_oseba2["ID_OSEBA2"] || $id_oseba == $id_oseba3["ID_OSEBA3"]){
                    //echo "NAPAKA";
                    ViewHelper::redirect(BASE_URL . "PodatkiIzvajalcev/leto/".$id_leto."/".$id_predmet);

                }else{
                    ProfesorDB::ThirdIzvajalecEdit($id_predmet,$id_leto,$id_oseba);
                    ViewHelper::redirect(BASE_URL . "PodatkiIzvajalcev/leto/".$id_leto."/".$id_predmet);
                }



            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function editThirdIzvajalecForm($id_leto,$id_predmet) {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){

                ViewHelper::render("view/PodatkiIzvajalcevForm3.php", [
                    "profesori" => IzvedbaPredmetaModel::getAllProfesori(),
                    "id_predmet" => $id_predmet,
                    "id_leto" => $id_leto
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }

    }


    public static function deleteSecondIzvajalec($id_leto,$id_predmet){
        ProfesorDB::deleteSecondIzvajalec($id_leto,$id_predmet);
        ViewHelper::redirect(BASE_URL . "PodatkiIzvajalcev/leto/".$id_leto."/".$id_predmet);
    }

    public static function deleteThirdIzvajalec($id_leto,$id_predmet){
        ProfesorDB::deleteThirdIzvajalec($id_leto,$id_predmet);
        ViewHelper::redirect(BASE_URL . "PodatkiIzvajalcev/leto/".$id_leto."/".$id_predmet);
    }

    public static function addIzvajalec1($id_leto,$id_predmet){
        $data = filter_input_array(INPUT_POST, [
            "imePriimek" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
        ]);


        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){

                $razdeli=explode(" ",$data["imePriimek"]);

                $ime=$razdeli[0];
                $priimek=$razdeli[1];
                $id_oseba=$razdeli[2];
               // var_dump($ime);
              //  var_dump($priimek);
              //  var_dump($id_oseba);


                $id_oseba1=ProfesorDB::GetIzvajalec1($id_leto,$id_predmet);
                $id_oseba2=ProfesorDB::GetIzvajalec2($id_leto,$id_predmet);
                $id_oseba3=ProfesorDB::GetIzvajalec3($id_leto,$id_predmet);

                /*  var_dump($id_oseba);
                  var_dump($id_oseba1["ID_OSEBA1"]);
                  var_dump($id_oseba2["ID_OSEBA2"]);
                  var_dump($id_oseba3["ID_OSEBA3"]);*/


                if($id_oseba == $id_oseba1["ID_OSEBA1"] || $id_oseba == $id_oseba2["ID_OSEBA2"] || $id_oseba == $id_oseba3["ID_OSEBA3"]){
                    //echo "NAPAKA";
                    ViewHelper::redirect(BASE_URL . "PodatkiIzvajalcev/leto/".$id_leto."/".$id_predmet);

                }else{
                    ProfesorDB::IzvajalecAdd($id_predmet,$id_leto,$id_oseba);
                    ViewHelper::redirect(BASE_URL . "PodatkiIzvajalcev/leto/".$id_leto."/".$id_predmet);
                }



            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function addIzvajalec2($id_leto,$id_predmet){
        $data = filter_input_array(INPUT_POST, [
            "imePriimek2" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
        ]);



        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){

                $razdeli=explode(" ",$data["imePriimek2"]);

                $ime=$razdeli[0];
                $priimek=$razdeli[1];
                $id_oseba=$razdeli[2];
                // var_dump($ime);
                //  var_dump($priimek);
                //  var_dump($id_oseba);

                $id_oseba1=ProfesorDB::GetIzvajalec1($id_leto,$id_predmet);
                $id_oseba2=ProfesorDB::GetIzvajalec2($id_leto,$id_predmet);
                $id_oseba3=ProfesorDB::GetIzvajalec3($id_leto,$id_predmet);

              /*  var_dump($id_oseba);
                var_dump($id_oseba1["ID_OSEBA1"]);
                var_dump($id_oseba2["ID_OSEBA2"]);
                var_dump($id_oseba3["ID_OSEBA3"]);*/


                if($id_oseba == $id_oseba1["ID_OSEBA1"] || $id_oseba == $id_oseba2["ID_OSEBA2"] || $id_oseba == $id_oseba3["ID_OSEBA3"]){
                    //echo "NAPAKA";
                    ViewHelper::redirect(BASE_URL . "PodatkiIzvajalcev/leto/".$id_leto."/".$id_predmet);

                }else{
                    ProfesorDB::IzvajalecAdd2($id_predmet,$id_leto,$id_oseba);
                    ViewHelper::redirect(BASE_URL . "PodatkiIzvajalcev/leto/".$id_leto."/".$id_predmet);
                }


            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function addIzvajalec3($id_leto,$id_predmet){
        $data = filter_input_array(INPUT_POST, [
            "imePriimek3" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
        ]);


        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){

                $razdeli=explode(" ",$data["imePriimek3"]);

                $ime=$razdeli[0];
                $priimek=$razdeli[1];
                $id_oseba=$razdeli[2];
                // var_dump($ime);
                //  var_dump($priimek);
                //  var_dump($id_oseba);

                $id_oseba1=ProfesorDB::GetIzvajalec1($id_leto,$id_predmet);
                $id_oseba2=ProfesorDB::GetIzvajalec2($id_leto,$id_predmet);
                $id_oseba3=ProfesorDB::GetIzvajalec3($id_leto,$id_predmet);

                if($id_oseba == $id_oseba1["ID_OSEBA1"] || $id_oseba == $id_oseba2["ID_OSEBA2"] || $id_oseba == $id_oseba3["ID_OSEBA3"]){
                    //echo "NAPAKA";
                    ViewHelper::redirect(BASE_URL . "PodatkiIzvajalcev/leto/".$id_leto."/".$id_predmet);

                }else{
                    ProfesorDB::IzvajalecAdd3($id_predmet,$id_leto,$id_oseba);
                    ViewHelper::redirect(BASE_URL . "PodatkiIzvajalcev/leto/".$id_leto."/".$id_predmet);
                }


            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function addIzvajalec($id_leto,$id_predmet){
        $data = filter_input_array(INPUT_POST, [
            "imePriimek" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
        ]);


        if (User::isLoggedIn()){
            if (User::isLoggedInAsAdmin()){

                $razdeli=explode(" ",$data["imePriimek"]);

                $ime=$razdeli[0];
                $priimek=$razdeli[1];
                $id_oseba=$razdeli[2];
                // var_dump($ime);
                //  var_dump($priimek);
                //  var_dump($id_oseba);

                ProfesorDB::IzvajalecAdd($id_predmet,$id_leto,$id_oseba);
                ViewHelper::redirect(BASE_URL . "PodatkiIzvajalcev/leto/".$id_leto."/".$id_predmet);
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
                ViewHelper::render("view/PodatkiIzvajalcevLetoAdd.php", [
                    "pageTitle" => "Seznam vseh študijski leta",
                    "allData" => PredmetModel::getAllLeta(),
                    "formAction" => "PodatkiIzvajalcevAdd/leto"
                ]);
            } else {
                ViewHelper::error403();
            }
        } else {
            ViewHelper::error401();
        }
    }


    public static function getFormPredmetIzvajalec($id_leto){
        if (User::isLoggedIn()) {
            if (User::isLoggedInAsAdmin()) {
                ViewHelper::render("view/PodatkiIzvajalcevPredmetAdd.php", [
                    "pageTitle" => "Seznam vseh predmetov",
                    "allData" => PredmetModel::getAllSubjects(),
                    "id_leto" => $id_leto,
                ]);
            } else {
                ViewHelper::error403();
            }
        } else {
            ViewHelper::error401();
        }
    }

    public static function getIzbiraDelPremdetnika($id_leto,$id_predmet,$status = null, $message = null) {
        if (User::isLoggedIn()) {
            if (User::isLoggedInAsAdmin()) {


                $allData=StudentOfficerDB::getDelPredmetnikai();

                //var_dump($allData);
                
                ViewHelper::render("view/PodatkiIzvajalcevDelPredmetnikaAdd.php", [
                    "pageTitle" => "Seznam vseh delov predmetnika",
                    "allData" => $allData,
                    "id_leto" => $id_leto,
                    "id_predmet" => $id_predmet,
                    "status" => $status,
                    "message" => $message,
                ]);
            } else {
                ViewHelper::error403();
            }
        } else {
            ViewHelper::error401();
        }
    }

    public static function getNewIzvajalec($id_leto,$id_predmet){
        if (User::isLoggedIn()) {
            if (User::isLoggedInAsAdmin()) {
                ViewHelper::render("view/PodatkiIzvajalcevAdd.php", [
                    "id_leto" => $id_leto,
                    "id_predmet" => $id_predmet,
                    "profesori" => IzvedbaPredmetaModel::getAllProfesori(),
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

    // Parse input and put it to associative array
    public static function parseInput(){

        $target_file = basename($_FILES["fileToUpload"]["name"]);
        $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        if(isset($_POST["submit"])) {
            if ($fileType == "txt") {
                $fileContent = filter_var(file_get_contents($_FILES["fileToUpload"]["tmp_name"]), FILTER_SANITIZE_SPECIAL_CHARS);

                $splitted = self::splitInput($fileContent);
                $sizeSplitted = count($splitted);
                //var_dump($splitted);

                $mainArray = null;
                if ($sizeSplitted > 0) {
                    $mainArray = self::generateMainArray($splitted, $sizeSplitted);
                    //self::generateMainArray2($splitted);
                    //var_dump($mainArray);


                    if (is_array($mainArray)) {

                        $allStudents = UserModel::getAllStudents();
                        $allCandidates = UserModel::getAllCandidates();
                        //var_dump($allCandidates);

                        // If duplicate student is found - do nothing
                        $mainArray = self::findDuplicateStudents($mainArray, $allStudents);
                        // If duplicate candidate is found - update
                        $mainArray = self::findDuplicateCandidates($mainArray, $allCandidates);

                        // TODO Change here!
                        $mainArray = self::generateVpisnaUnPass($mainArray);

                        // Renders user form to confirm the insert!
                        ViewHelper::render("view/UvozPodatkovConfirm.php", [
                            "mainArray" => $mainArray,
                        ]);
                    }
                } else {
                    echo "Naložena datoteka je prazna.";
                }
            } else {
                echo "Napaka - datoteka ni ustreznega tipa. Uvoz sprejme le datoteke v formatu .TXT";
            }
        }
    }

    public static function findDuplicateStudents($mainArray, $allStudents){

        foreach($mainArray as $keyMain => $valueMain){          // V mainArray vpisemo, ce je duplikat ali ne

            foreach ($allStudents as $keyAll => $valueAll){
                if($valueMain['ime'] == $valueAll['ime'] && $valueMain['priimek'] == $valueAll['priimek'] && $valueMain['program'] == $valueAll['sifra_evs'] && $valueMain['email'] == $valueAll['email']){
                    $mainArray[$keyMain]['duplikat'] = "DA";
                    $mainArray[$keyMain]['tipDuplikata'] = "študent";
                    $mainArray[$keyMain]['izkoriscen'] = "DA";
                }
            }
        }

        return $mainArray;
    }

    // Duplicate candidate --> Ce se iz datoteke dvakrat uvaza istega kandidata - ima ze generiran un, pass,...
        // MainArray je nasa import datoteka
        // AllStudents so vsi kandidati v bazi
    public static function findDuplicateCandidates($mainArray, $allCandidates){

        foreach($mainArray as $keyMain => $valueMain){          // V mainArray vpisemo, ce je duplikat ali ne

            foreach ($allCandidates as $keyAll => $valueAll){
                if($valueMain['email'] == $valueAll['email']){
                    $mainArray[$keyMain]['duplikat'] = "DA";
                    $mainArray[$keyMain]['tipDuplikata'] = "kandidat";
                    $mainArray[$keyMain]['izkoriscen'] = ($valueAll['izkoriscen'] == 1 ? "DA" : "NE");

                    // V primeru, da je kandidat duplikat --> Preverimo, ce je DUPLIKAT ali POSODOBITEV
                    $isUpdate = UserModel::isUpdate($valueMain);
                    if($isUpdate == 0) $mainArray[$keyMain]['update'] = "NE";
                    else $mainArray[$keyMain]['update'] = "DA";
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

            //var_dump($sizeSplitted);
            //var_dump($splitted);
            for($i = 0; $i < $sizeSplitted; $i++) {

                $krneki = $splitted[$i];
                if($i == 0){
                    $temp['ime'] = rtrim(mb_substr($krneki, 0, 29, 'UTF-8'));
                    $temp['priimek'] = rtrim(mb_substr($krneki, 31, 30, 'UTF-8'));
                    $temp['program'] = rtrim(mb_substr($krneki, 61,7, 'UTF-8'));
                    $temp['email'] = rtrim(mb_substr($krneki, 68, 60, 'UTF-8'));
                    $temp['username'] = rtrim(mb_substr($krneki, 68, 6, 'UTF-8'));
                } else {
                    $temp['ime'] = rtrim(mb_substr($krneki, 0, 30, 'UTF-8'));
                    $temp['priimek'] = rtrim(mb_substr($krneki, 30, 30, 'UTF-8'));
                    $temp['program'] = rtrim(mb_substr($krneki, 60,7, 'UTF-8'));
                    $temp['email'] = rtrim(mb_substr($krneki, 67, 60, 'UTF-8'));
                    $temp['username'] = rtrim(mb_substr($krneki, 67, 6, 'UTF-8'));
                }

                $temp['duplikat'] = "NE";
                $temp['tipDuplikata'] = "/";
                $temp['update'] = "NE";
                $temp['izkoriscen'] = "NE";
                //var_dump($temp);

                array_push($mainArray, $temp);
            }
            return $mainArray;
    }

    public static function generateMainArray2($splitted){

        $mainArray=[];
        $temp=[];

        foreach ($splitted as $key => $value){
            $temp['ime'] = mb_substr($value, 0, 30, 'UTF-8');
            $temp['priimek'] = mb_substr($value, 30, 30, 'UTF-8');
            $temp['program'] = mb_substr($value, 60,7, 'UTF-8');
            $temp['email'] =mb_substr($value, 67, 60, 'UTF-8');
            $temp['duplikat'] = "NE";
            $temp['tipDuplikata'] = "/";
            $temp['update'] = "NE";
            $temp['izkoriscen'] = "NE";
            var_dump($temp);
        }
    }

    public static function isUniqueVpisnaInMainArray($mainArray, $vpisna){
        foreach ($mainArray as $key => $value){
            if(isset($value['vpisna']) && $value['vpisna'] == $vpisna) return false;
        }
        return true;
    }

    // Generates vpisna, username, pass, returns enriched associative array
    public static function generateVpisnaUnPass($mainArray){

        $out = array();

        foreach ($mainArray as $key => $value){

            $vpisna = "";
            while(true){
                $vpisna = rand(63180000, 63189999);
                if(AdminDB::isUniqueVpisna($vpisna) && self::isUniqueVpisnaInMainArray($mainArray, $vpisna)) break;
            }

            $pass = self::generatePass(6);

            if($value['duplikat'] == "NE"){
                $value['vpisna'] = $vpisna;
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
            // Vstavimo KANDIDATA!
    public static function insertParsedData(){

        $data = $_SESSION['mainArray'];
        UserModel::insertNewCandidate($data);
        $result = UserModel::getAllNeizkorisceniKandidati();
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

    public static function exportCSV(){

        $data = filter_input_array(INPUT_POST, [
            "searchVpisna" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);

        $studData = AdminDB::getStudentData($data["searchVpisna"]);
        $vpisData = AdminDB::getEnrollmentDetails($data["searchVpisna"]);

        $delimiter = ",";
        $filename = "data.csv";
        $f = fopen('php://memory', 'w');

        $text = array("UNIVERZA V LJUBLJANI, FAKULTETA ZA RAČUNALNIŠTVO IN INFORMATIKO");
        fputcsv($f, $text, $delimiter);


        $fields = array('Vpisna številka','Ime', 'Priimek', 'Naslov Stalnega Bivališča', 'Začasni naslov','Telefonska številka','Naslov elektronske pošte');

        $id=PrijavaModel::getIdPoVpisna($studData[0]["vpisna_stevilka"]);
        $naslove=KandidatModel::getKandidatVseNaslove($id["ID_OSEBA"]);


        $naslovStalnegaBivalisca=NULL;
        $naslovPrejemanje=NULL;
        $zacasniNaslov=NULL;
        foreach ($naslove as $key => $value) {
            if($value["ID_POSTA"]==NULL){
                $posta='';
            }else{
                $gPosta=NasloveData::getPosta($value["ID_POSTA"]);
                $posta=$gPosta[0]["ST_POSTA"].' '.$gPosta[0]["KRAJ"];
            }

            if($value["ID_OBCINA"]==NULL){
                $obcina='';
            }else{
                $gObcina=NasloveData::getObcina($value["ID_OBCINA"]);
                $obcina=$gObcina[0]["IME_OBCINA"];
            }

            if($value["ID_DRZAVA"]==NULL){
                $drzava='';
            }else{
                $gDrzava=NasloveData::getDrzava($value["ID_DRZAVA"]);
                //var_dump($gDrzava);
                $drzava=$gDrzava[0]["SLOVENSKINAZIV"];;
            }

            if ($value['JE_STALNI'] == 1) {
                $naslovStalnegaBivalisca=$value["ULICA"].' '.$posta.' '.$obcina.' '.$drzava;
            }else{
                $zacasniNaslov=$value["ULICA"].' '.$posta.' '.$obcina.' '.$drzava;
            }
        }


        $lineData = array($studData[0]['vpisna_stevilka'], $studData[0]['ime'], $studData[0]['priimek'], $naslovStalnegaBivalisca,$zacasniNaslov, $studData[0]['telefonska_stevilka'], $studData[0]['email']);

        $text = array("Izpis osebnih podatkov studenta");
        fputcsv($f, $text, $delimiter);
        for($i=0; $i<count($fields);$i++){
            $add=array($fields[$i],$lineData[$i]);
            fputcsv($f, $add, $delimiter);
        }

        $fields = array();
        fputcsv($f, $fields, $delimiter);
        $fields = array("Izpis podatkov o vpisih");
        fputcsv($f, $fields, $delimiter);
        $fields = array('Letnik','Naziv program', 'Šifra programa', 'Vrsta vpisa', 'Nacin študija');


        foreach ($vpisData as $key => $value){
            $lineData = array($value['letnik'], $value['naziv_program'], $value['sifra_evs'], $value['opis_vpisa'],$value['opis_nacin']);

        }

        //for($i=0; $i<count($fields);$i++){
        //    $add=array($fields[$i],$lineData[$i]);

        fputcsv($f, $fields, $delimiter);
        fputcsv($f, $lineData, $delimiter);
        //}


        fseek($f, 0);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
        fpassthru($f);

    }




    public static function exportPDF(){
        $data = filter_input_array(INPUT_POST, [
            "searchVpisna" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);

        $studData = AdminDB::getStudentData($data["searchVpisna"]);
        $vpisData = AdminDB::getEnrollmentDetails($data["searchVpisna"]);

        $header = array('Vpisna številka','Ime', 'Priimek', 'Naslov Stalnega Bivališča', 'Začasni naslov','Telefonska številka','Naslov elektronske pošte');

        $id=PrijavaModel::getIdPoVpisna($studData[0]["vpisna_stevilka"]);
        $naslove=KandidatModel::getKandidatVseNaslove($id["ID_OSEBA"]);


        $naslovStalnegaBivalisca=NULL;
        $naslovPrejemanje=NULL;
        $zacasniNaslov=NULL;
        foreach ($naslove as $key => $value) {
            if($value["ID_POSTA"]==NULL){
                $posta='';
            }else{
                $gPosta=NasloveData::getPosta($value["ID_POSTA"]);
                $posta=$gPosta[0]["ST_POSTA"].' '.$gPosta[0]["KRAJ"];
            }

            if($value["ID_OBCINA"]==NULL){
                $obcina='';
            }else{
                $gObcina=NasloveData::getObcina($value["ID_OBCINA"]);
                $obcina=$gObcina[0]["IME_OBCINA"];
            }

            if($value["ID_DRZAVA"]==NULL){
                $drzava='';
            }else{
                $gDrzava=NasloveData::getDrzava($value["ID_DRZAVA"]);
                //var_dump($gDrzava);
                $drzava=$gDrzava[0]["SLOVENSKINAZIV"];;
            }

            if ($value['JE_STALNI'] == 1) {
                $naslovStalnegaBivalisca=$value["ULICA"].', '.$posta.', '.$drzava;
            }else{
                $zacasniNaslov=$value["ULICA"].', '.$posta.', '.$drzava;
            }
        }


        $lineData = array($studData[0]['vpisna_stevilka'], $studData[0]['ime'], $studData[0]['priimek'], $naslovStalnegaBivalisca,$zacasniNaslov, $studData[0]['telefonska_stevilka'], $studData[0]['email']);

        $header2 = array('Letnik','Naziv program', 'Šifra programa', 'Vrsta vpisa', 'Nacin študija');

        $lineData2=null;
        foreach ($vpisData as $key => $value){
            $lineData2 = array($value['letnik'], $value['naziv_program'], $value['sifra_evs'], $value['opis_vpisa'],$value['opis_nacin']);
        }

        $pdf= new tFPDF();
        $pdf->AddPage('');
        $pdf->AddFont('DejaVu','','DejaVuSans.ttf',true);

        $pdf->Image('./static/images/logo-ul.jpg', 8, 8, 20, 20, 'JPG');
        $pdf->SetFont('DejaVu','',15);
        $pdf->Cell(200,10,'Univerza v Ljubjani, Fakulteta za računalništvo in informatiko ',0,0,'C');
        $pdf->Ln();
        $tDate=date("Y-m-d");
        $sloDate=ProfessorController::formatDateSlo($tDate);
        $pdf->Cell(0, 10, 'Datum izdaje : '.$sloDate, 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $pdf->Ln();

        $imePriimek=$studData[0]["ime"].' '.$studData[0]["priimek"];

        $pdf->SetFont('DejaVu','',25);
        $pdf->Cell(180,10,'Osebni podatki študenta: '. $imePriimek,0,0);
        $pdf->Ln();
        $pdf->Ln();

        $pdf->SetFont('DejaVu','',15);
        $pdf->Cell(80,10,'Izpis osebnih podatkov studenta');
        $pdf->Ln();

        $pdf->SetFont('DejaVu','',10);
        $pdf->BasicTableOsebni($header,$lineData);
        $pdf->SetFont('DejaVu','',15);
        $pdf->Ln();
        $pdf->Cell(80,10,'Izpis podatkov o vpisih');
        $pdf->Ln();
        $pdf->SetFont('DejaVu','',10);
        $pdf->BasicTableP($header2,$lineData2);

        $pdf->SetX(180);
        $pdf->SetY(265);
        $pdf->AliasNbPages('{totalPages}');
        $pdf->Cell(0, 10, 'Stran '.$pdf->PageNo(). "/{totalPages}", 0, false, 'C', 0, '', 0, false, 'T', 'M');


        $pdf->Output();

        $filename="data.pdf";
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
    }


}
