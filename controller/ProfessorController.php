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

    public static function VnosOcenForm() {
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
            list($y, $m, $d) = explode('-', $data["DATUM_ROKA"]);
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
                                    self::izpitniRokForm("Failure", "Napaka, rok ze obstaja. Poskusite znova.");
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
            list($y, $m, $d) = explode('-', $data["DATUM_ROKA"]);
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
                                    self::izpitniRokEditForm($id, "Failure", "Napaka, rok ze obstaja. Poskusite znova.");
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
                    ViewHelper::redirect(BASE_URL . "izpitniRok/profesor");
                } else {
                    ViewHelper::render("view/DisplayMessageViewer.php", [
                        "status" => "Failure",
                        "message" => "Error toogling activity of the exam."
                    ]);
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