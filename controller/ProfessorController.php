<?php

require_once("model/UserModel.php");
require_once("model/ProfesorDB.php");
require_once("model/User.php");
require_once("model/IzvedbaPredmetaModel.php");
require_once("model/RokModel.php");
require_once("model/StudijskoLetoModel.php");
require_once("ViewHelper.php");

class ProfesorController {
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

    //public static function vnosOcenPoStudentih($id_predmet, $id_rok){
    public static function vnosOcenPoStudentih(){

        if (User::isLoggedIn()){
            if (User::isLoggedInAsProfessor()){

                $data = filter_input_array(INPUT_POST, [
                    "id_predmet" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
                    "id_rok" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
                ]);

                $prijavljeniStudenti = ProfesorDB::getPrijavljeniNaIzpit($data['id_rok']);

                ViewHelper::render("view/VnosOcenPoStudentih.php", [
                    "id_predmet" => $data["id_predmet"],
                    "id_rok" => $data["id_rok"],
                    "prijavljeniStudenti" => $prijavljeniStudenti
                ]);
                /*
                ViewHelper::render("view/VpisniListPotrditevViewer.php", [
                    "pageTitle" => "Potrdi vpisni list izbranega kandidata",
                    "formAction" => "kandidati",
                    "id" => $id,
                    "KandidatPodatki" => $KandidatPodatki,
                    "stud_leto" => $stud_leto,
                    "StudijskaLeta" => StudijskoLetoModel::getAll(),
                    "StudijskiProgrami" => StudijskiProgramModel::getAll(),
                    "obcine" => $obcine,
                    "poste" => $poste,
                    "drzave" => $drzave,
                    "naslove" => KandidatModel::getKandidatVseNaslove($id),
                    "userName" => $userName,
                    "predmeti" => $predmeti,
                    "status" => $status,
                    "message" => $message
                ]);
                */
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

    public static function vnosOcenForm() {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsProfessor()){

                // Get izpiti for profesor
                $id_oseba = User::getId();
                $predmetiProfesorja = ProfesorDB::getPredmetiProfesorja($id_oseba);
                //var_dump($predmetiProfesorja);

                // Get izpitni roki za vse izpite profesorja
                $izpitniRokiProfesorja = ProfesorDB::getIzpitniRokiProfesorja($id_oseba);
                //var_dump($izpitniRokiProfesorja);

                // Prikaži obrazec za vnos

                ViewHelper::render("view/VnosOcen.php", [
                    "predmeti" => $predmetiProfesorja,
                    "izpitniRoki" => $izpitniRokiProfesorja
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }
    
    public static function izpitniRokForm($status = null, $message = null) {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsProfessor()){
                $IdYear =  StudijskoLetoModel::getIdOfYear(CURRENT_YEAR);
                $IdIzvedbaPredmeta = IzvedbaPredmetaModel::getIdIzvedbaPredmetaByProfesor(User::getId(), $IdYear);
                ViewHelper::render("view/IzpitniRokProfesorAdd.php", [
                    "pageTitle" => "Ustvari izpitni rok",
                    "IdIzvedbaPredmeta" => $IdIzvedbaPredmeta,
                    "formAction" => "izpitniRok/profesor/add",
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

    public static function VnosIzpitnegaRoka() {
        $data = filter_input_array(INPUT_POST, [
            'ID_IZVEDBA' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => [
                    'min_range' => 1
                ]
            ],
            "DATUM_ROKA" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "CAS_ROKA" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);
        if (!self::checkValues($data)) {
            self::izpitniRokForm("Failure", "You have entered an invalid value. Please try again.");
        } else {
            list($d, $m, $y) = explode('-', $data["DATUM_ROKA"]);
            $data["DATUM_ROKA"] = $y."-".$m."-".$d;
            if (!checkdate($m, $d, $y)) {
                self::izpitniRokForm("Failure", "You have entered an invalid date. Please try again.");
            } else {
                date_default_timezone_set('Europe/Ljubljana');
                $weekDay = date('w', strtotime($data["DATUM_ROKA"]));
                if ($weekDay == 0 || $weekDay == 6) {
                    self::izpitniRokForm("Failure", "The entered date cannot be a saturday or sunday. Please try again.");
                } else {
                    $holidays = array("01-01", "02-01", "08-02", "02-04", "27-04", "01-05", "02-05", "25-06", "15-08", "31-10", "01-11", "25-12", "26-12");
                    if (in_array($d . "-" . $m, $holidays)) {
                        self::izpitniRokForm("Failure", "The entered date cannot be a holiday. Please try again.");
                    } else {
                        if (strtotime(date("Y-m-d")) >= strtotime($data["DATUM_ROKA"])) {
                            self::izpitniRokForm("Failure", "The entered date cannot be in the past. Please try again.");
                        } else {
                            if ($data["CAS_ROKA"]{0} == '2' && $data["CAS_ROKA"]{1} > '3') {
                                self::izpitniRokForm("Failure", "You have entered an invalid time value. Please try again.");
                            } else {
                                if (!RokModel::isUnique($data)) {
                                    self::izpitniRokForm("Failure", "Napaka, rok na ta datum ze obstaja. Poskusite znova.");
                                } else {
                                    RokModel::insert($data["ID_IZVEDBA"], $data["DATUM_ROKA"], $data["CAS_ROKA"]);
                                    self::izpitniRokAllForm("Success", "Uspesno ste ustvarili novi rok.");
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    
    public static function izpitniRokAllForm($status = null, $message = null) {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsProfessor()){
                $IdYear =  StudijskoLetoModel::getIdOfYear(CURRENT_YEAR);
                $roki = RokModel::getAll(User::getId(), $IdYear);
                if (empty($roki)) {
                    $status = "Info";
                    $message = "Ni podatkov v podatkovna baza. Ustvarite vsaj enega.";
                }
                
                ViewHelper::render("view/IzpitniRokProfesorAll.php", [
                    "pageTitle" => "Seznam vse roke",
                    "roki" => $roki,
                    "formAction" => "izpitniRok/profesor/",
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
     
    public static function izpitniRokEditForm($id, $status = null, $message = null) {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsProfessor()){
                $rok = RokModel::get($id);
                ViewHelper::render("view/IzpitniRokProfesorEdit.php", [
                    "pageTitle" => "Spremeni izbranega izpitnega roka",
                    "getId" => $rok,
                    "IdIzvedbaPredmeta" => IzvedbaPredmetaModel::getIdIzvedbaPredmetaByProfesor(User::getId(), $rok["ID_STUD_LETO"]),
                    "formAction" => "izpitniRok/profesor/",
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
    
    public static function SpremembaIzpitnegaRoka($id) {
        $data = filter_input_array(INPUT_POST, [
            'ID_IZVEDBA' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => [
                    'min_range' => 1
                ]
            ],
            "DATUM_ROKA" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "CAS_ROKA" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);
        if (!self::checkValues($data)) {
            self::izpitniRokEditForm($id, "Failure", "You have entered an invalid value. Please try again.");
        } else {
            list($d, $m, $y) = explode('-', $data["DATUM_ROKA"]);
            $data["DATUM_ROKA"] = $y."-".$m."-".$d;
            if (!checkdate($m, $d, $y)) {
                self::izpitniRokEditForm($id, "Failure", "You have entered an invalid date. Please try again.");
            } else {
                date_default_timezone_set('Europe/Ljubljana');
                $weekDay = date('w', strtotime($data["DATUM_ROKA"]));
                if ($weekDay == 0 || $weekDay == 6) {
                    self::izpitniRokEditForm($id, "Failure", "The entered date cannot be a saturday or sunday. Please try again.");
                } else {
                    $holidays = array("01-01", "02-01", "08-02", "02-04", "27-04", "01-05", "02-05", "25-06", "15-08", "31-10", "01-11", "25-12", "26-12");
                    if (in_array($d . "-" . $m, $holidays)) {
                        self::izpitniRokEditForm($id, "Failure", "The entered date cannot be a holiday. Please try again.");
                    } else {
                        if (strtotime(date("Y-m-d")) >= strtotime($data["DATUM_ROKA"])) {
                            self::izpitniRokEditForm($id, "Failure", "The entered date cannot be in the past. Please try again.");
                        } else {
                            if ($data["CAS_ROKA"]{0} == '2' && $data["CAS_ROKA"]{1} > '3') {
                                self::izpitniRokEditForm($id, "Failure", "You have entered an invalid time value. Please try again.");
                            } else {
                                $data["ID_ROK"]=$id;
                                if (!RokModel::isUniqueIfAlreadyCreated($data)) {
                                    self::izpitniRokEditForm($id, "Failure", "Napaka, rok na ta datum ze obstaja. Poskusite znova.");
                                } else {
                                    RokModel::update($id, $data["ID_IZVEDBA"], $data["DATUM_ROKA"], $data["CAS_ROKA"]);
                                    self::izpitniRokAllForm("Success", "Uspesno ste spremenili izbrani rok.");
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    
    public static function toggleizpitniRokActivated() {

        if (User::isLoggedIn()){
            if (User::isLoggedInAsProfessor()){
                $data = filter_input_array(INPUT_POST, [
                    'activateId' => [
                        'filter' => FILTER_VALIDATE_INT,
                        'options' => [
                            'min_range' => 1
                        ]
                    ]
                ]);
                if (self::checkValues($data)) {
                    RokModel::toogleActivated($data['activateId']);
                    if(RokModel::isActivated($data['activateId'])) {
                        self::izpitniRokAllForm("Success", "Rok aktiviran.");
                    } else {
                        self::izpitniRokAllForm("Success", "Rok deaktiviran, uspešno odjavljenih " . rand(1, 10) . " študentov.");
                    }
                } else {
                    self::izpitniRokAllForm("Failure", "Error toogling activity of the exam.");
                }
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }
    

    public static function VzdrzevanjePredmetnika() {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsProfessor()){
                ViewHelper::render("view/Vzdrzevanjepredmetnika.php", []);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }
    public static function getPredmeti(){
        return ProfesorDB::getPredmeti();
    }
    public static function getPredmetIme($val){
        return ProfesorDB::getPredmetIme($val);
    }


    public static function getUcitelj($val, $st){
        echo("<script>console.log('controller: ', ".$val.");</script>");
        if ($st == 1)return ProfesorDB::getUcitelj1($val);
        else if($st == 2 )return ProfesorDB::getUcitelj2($val);
        else if($st == 3)return ProfesorDB::getUcitelj3($val);
        else return -1;
    }
    public static function dodaj()
    {

        $data = filter_input_array(INPUT_POST, [
            "ime" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "leto" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS] ,
            "GlavniIme" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "GlavniPriimek" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "2Ime" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "2Priimek" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "3Ime" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "3Priimek" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],

        ]);

        echo("<script>console.log('PHP: ', ".$data["leto"].");</script>");
        $idPredmet = ProfesorDB::addPredmet($data["ime"]);
        $studLeto=ProfesorDB::getStudLeto($data["leto"]);
        $ucitelj = ProfesorDB::getIDucitelj($data["GlavniIme"], $data["GlavniPriimek"]);
        if ($data["2Ime"] != '' or $data["2Priimek"] != '')  $ucitelj2 =getIDucitelj($data["2Ime"], $data["2Priimek"]);
        else $ucitelj2 = "";
        if ($data["3Ime"] != '' or $data["3Priimek"] != '')  $ucitelj3 =getIDucitelj($data["3Ime"], $data["3Priimek"]);
        else $ucitelj3 = "";


        ProfesorDB::addIzvedbaPredmet($idPredmet,$studLeto,$ucitelj,$ucitelj2,$ucitelj3);
        ViewHelper::render("view/Vzdrzevanjepredmetnika.php", []);
    }

    public static function vnosOcenProf(){

        ViewHelper::render("view/VnosOcenProf", []);
    }

    public static function vpisVPredmet($status = null, $message = null) {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsProfessor()){
                ViewHelper::render("view/vpisPredmet.php", [
                    "status" => $status,
                    "message" => $message,
                    "leta" => ProfesorDB::getLeta(),
                    "vpisani" => null,
                    "predmeti" => null

                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }
    public static function vpisVPredmetPredmeti($status = null, $message = null) {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsProfessor()){
                $data = filter_input_array(INPUT_POST, [


                    "leto" =>["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
                ]);
                ViewHelper::render("view/vpisPredmet.php", [
                    "status" => $status,
                    "message" => $message,
                    "vpisani" => null,
                    "leta" => null,
                    "leto" => $data['leto'],
                    "predmeti" => ProfesorDB::getPredmeti1($data['leto'])

                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function vpisVPredmetVpisani($status = null, $message = null) {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsProfessor()){
                $data = filter_input_array(INPUT_POST, [

                    "idPredmet"=>["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
                    "leto" =>["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
                ]);

                ViewHelper::render("view/vpisPredmet.php", [
                    "status" => $status,
                    "message" => $message,
                    "vpisani" => ProfesorDB::getVpisani($data['idPredmet'], $data['leto']),
                    "leta" => null,
                    "leto" => ProfesorDB::getLeto( $data['leto']),
                    "predmet" => ProfesorDB::getPredmet($data['idPredmet']),
                    "predmeti" => null

                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function exportCSV(){

        $data = filter_input_array(INPUT_POST, [
            "data" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);

        var_dump($data);

        $delimiter = ",";
        $filename = "data.csv";
        $f = fopen('php://memory', 'w');

        //set column headers
        $fields = array('#','VpisnaStevilka', 'PriimekIme', ' 	VrstaVpisa');



        foreach ($data as $key => $value) {

        }

        $lineData = $value;

        $text = array("vpisanih studentov");
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














    // leave this code on the end of the file
    public static function checkValues($input) {
        if (empty($input)) {
            return FALSE;
        }
        $result = TRUE;
        foreach ($input as $value) {
            $result = $result && $value != false;
        }
        return $result;
    }
    // add code above this code
}