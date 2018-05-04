<?php

require_once("model/AdminDB.php");
require_once("model/UserModel.php");
require_once("model/User.php");
require_once("ViewHelper.php");
require ("view/includes/fpdf.php");
require ("view/includes/helveticab.php");


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

    // Parse input and put it to associative array
    public static function parseInput(){

        $target_file = basename($_FILES["fileToUpload"]["name"]);
        $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        if(isset($_POST["submit"])) {
            if ($fileType == "txt") {
                $fileContent = filter_var(file_get_contents($_FILES["fileToUpload"]["tmp_name"]), FILTER_SANITIZE_SPECIAL_CHARS);

                $splitted = self::splitInput($fileContent);
                $sizeSplitted = count($splitted);

                $mainArray = null;
                if ($sizeSplitted > 0) {
                    $mainArray = self::generateMainArray($splitted, $sizeSplitted);
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

            for($i = 0; $i < $sizeSplitted; $i++){

                $temp['ime'] = rtrim(substr($splitted[$i], 0, 30));
                $temp['priimek'] = rtrim(substr($splitted[$i], 30, 30));
                $temp['program'] = rtrim(substr($splitted[$i], 60,7));
                $temp['email'] = rtrim(substr($splitted[$i], 67, 60));
                $temp['duplikat'] = "NE";
                $temp['tipDuplikata'] = "/";
                $temp['update'] = "NE";

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
            // Vstavimo KANDIDATA!
    public static function insertParsedData(){

        $data = $_SESSION['mainArray'];
        UserModel::insertNewCandidate($data);
        $result = UserModel::getAllCandidates();
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

        //set column headers
        $fields = array('VpisnaStevilka','Ime', 'Priimek', 'NaslovStalnegaBivalisca', 'NaslovZaPrejemanjePoste','TelefonskaStevilka','NaslovElektronskePoste');


        $naslovStalnegaBivalisca=null;
        $naslovPrejemanje=null;
        foreach ($studData as $key => $value) {
            if($value['je_stalni'] == 1 ){
                $naslovStalnegaBivalisca= $value['ulica'].$value['hisna_stevilka'].", ".$value['st_posta'].$value['kraj'];
            }

            if($value['je_zavrocanje'] == 1 ){
                $naslovPrejemanje= $value['ulica'].$value['hisna_stevilka'].", ".$value['st_posta'].$value['kraj'];
            }
        }

        $lineData = array($value['vpisna_stevilka'], $value['ime'], $value['priimek'], $naslovStalnegaBivalisca,$naslovPrejemanje, $value['telefonska_stevilka'], $value['email']);

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
        $fields = array('Letnik','NazivProgram', 'SifraPrograma', 'VrstaVpisa', 'NacinStudija');


        foreach ($vpisData as $key => $value){
            $lineData = array($value['letnik'], $value['naziv_program'], $value['sifra_evs'], $value['opis_vpisa'],$value['opis_nacin']);

        }

        for($i=0; $i<count($fields);$i++){
            $add=array($fields[$i],$lineData[$i]);
            fputcsv($f, $add, $delimiter);
        }


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

        $header = array('VpisnaStevilka','Ime', 'Priimek', 'NaslovStalnegaBivalisca', 'NaslovZaPrejemanjePoste','TelefonskaStevilka','NaslovElektronskePoste');

        foreach ($studData as $key => $value) {
            if($value['je_stalni'] == 1 ){
                $naslovStalnegaBivalisca= $value['ulica']." ".$value['hisna_stevilka'].", ".$value['st_posta']." ".$value['kraj'];
            }

            if($value['je_zavrocanje'] == 1 ){
                $naslovPrejemanje= $value['ulica']." ".$value['hisna_stevilka'].", ".$value['st_posta']." ".$value['kraj'];
            }
        }

        $lineData = array($value['vpisna_stevilka'], $value['ime'], $value['priimek'], $naslovStalnegaBivalisca,$naslovPrejemanje, $value['telefonska_stevilka'], $value['email']);

        $header2 = array('Letnik','NazivProgram', 'SifraPrograma', 'VrstaVpisa', 'NacinStudija');

        $lineData2=null;
        foreach ($vpisData as $key => $value){
            $lineData2 = array($value['letnik'], $value['naziv_program'], $value['sifra_evs'], $value['opis_vpisa'],$value['opis_nacin']);
        }


        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(40,10,'Izpis osebnih podatkov studenta');
        $pdf->Ln();
        $pdf->BasicTable($header,$lineData);
        $pdf->Cell(40,10,'Izpis podatkov o vpisih');
        $pdf->Ln();
        $pdf->BasicTable($header2,$lineData2);
        $pdf->Output('I','data.pdf');

        $filename="data.pdf";
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
    }


}
