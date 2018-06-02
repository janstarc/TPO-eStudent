<?php

require_once("model/UserModel.php");
require_once("model/ProfesorDB.php");
require_once("model/User.php");
require_once("model/IzvedbaPredmetaModel.php");
require_once("model/KartotecniListDB.php");
require_once("model/RokModel.php");
require_once("model/StudijskoLetoModel.php");
require_once("ViewHelper.php");

class ProfessorController {

    /********* VNOS OCEN IZPITNEGA ROKA *********/

    public static function vnosOcenIzpitaChooseLeto($status = null, $message = null) {
        if (User::isLoggedIn()) {
            if (User::isLoggedInAsProfessor()) {

                ViewHelper::render("view/VnosOcenIzpitaChooseLeto.php", [
                    "pageTitle" => "Vnos ocen izpita",
                    "allData" => StudijskoLetoModel::getAll(),
                    "formAction" => "VnosOcenIzpitaP/leto",
                    "status" => $status,
                    "message" => $message
                ]);
            } else {
                ViewHelper::error403();
            }
        } else {
            ViewHelper::error401();
        }
    }

    public static function vnosOcenIzpitaIzberiPredmetInRok($id_stud_leto) {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsProfessor()){

                // Get izpiti for profesor
                $id_oseba = User::getId();
                //var_dump("ID_OSEBA=".$id_oseba." ID_STUD_LETO=".$id_stud_leto);
                $predmetiProfesorja = ProfesorDB::getPredmetiProfesorja($id_oseba, $id_stud_leto);
                //var_dump($predmetiProfesorja);

                // Najdi izvajalce predmeta, kreiraj locen array $izvajalciPredmetov
                $izvajalciPredmetov=[];
                foreach ($predmetiProfesorja as $key => $value){

                    $izvajalciRoka = "";
                    $tmp = PredmetModel::getPredmetIzvajalci($value["ID_PREDMET"], $id_stud_leto);
                    $tmp = $tmp[0];

                    if($tmp["ID_OSEBA1"] != null) $izvajalciRoka .= $tmp["IME1"]." ".$tmp["PRIIMEK1"];
                    if ($tmp["ID_OSEBA2"] != null) $izvajalciRoka .= ", ".$tmp["IME2"]." ".$tmp["PRIIMEK2"];
                    if ($tmp["ID_OSEBA3"] != null) $izvajalciRoka .= ", ".$tmp["IME3"]." ".$tmp["PRIIMEK3"];
                    $temp["ID_PREDMET"] = $value["ID_PREDMET"];
                    $temp["IZVAJALEC"] = $izvajalciRoka;

                    array_push($izvajalciPredmetov, $temp);
                }

                // Get izpitni roki za vse izpite profesorja
                $izpitniRokiProfesorja = ProfesorDB::getIzpitniRokiProfesorja($id_oseba, $id_stud_leto);

                foreach($izpitniRokiProfesorja as $key => $value){
                    $izpitniRokiProfesorja[$key]["DATUM_ROKA"] = self::formatDateSlo($value["DATUM_ROKA"]);

                    foreach($izvajalciPredmetov as $k1 => $v1){
                        if($v1["ID_PREDMET"] === $value["ID_PREDMET"]){
                            $izpitniRokiProfesorja[$key]["IZVAJALEC"] = $v1["IZVAJALEC"];
                        }
                    }
                }

                ViewHelper::render("view/VnosOcenIzpitaChoosePredmetInRok.php", [
                    "predmeti" => $predmetiProfesorja,
                    "izpitniRoki" => $izpitniRokiProfesorja,
                    "izvajalciPredmetov" => $izvajalciPredmetov,
                    "id_stud_leto" => $id_stud_leto
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    // Forma za vnos ocen, ko je ze izbran predmet in izpitni rok
    public static function vnosOcenIzpita($id_stud_leto){

        if (User::isLoggedIn()){
            if (User::isLoggedInAsProfessor()){

                $data = filter_input_array(INPUT_POST, [
                    "id_predmet" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
                    "id_rok" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],

                ]);
                //var_dump("ID SL: " . $id_stud_leto);

                $prijavljeniStudenti = ProfesorDB::getPrijavljeniNaIzpit($data['id_rok']);
                $izvajalciArray = PredmetModel::getPredmetIzvajalci($data["id_predmet"], $id_stud_leto);
                $izprasevalciArray = RokModel::getRokIzprasevalci($data["id_rok"]);

                $izvajalci = self::createIzvajalciString($izvajalciArray);
                $izprasevalci = self::createIzprasevalciString($izprasevalciArray);

                $rokData = RokModel::get($data["id_rok"]);

                /*
                foreach ($prijavljeniStudenti as $i=>$value){
                    $stejPrijavLetos=StudentController::zapSteviloPrijavLetosProf($data["id_rok"],$value["VPISNA_STEVILKA"]);
                    $stejPrijavSkupno=StudentController::zapSteviloPrijavSkupnoProf($data["id_rok"],$value["VPISNA_STEVILKA"]);

                    $prijavljeniStudenti[$i]["ZAP_ST_POLAGANJ"]=$stejPrijavSkupno;
                    $prijavljeniStudenti[$i]["ZAP_ST_POLAGANJ_LETOS"]=$stejPrijavLetos;
                }
                */


                ViewHelper::render("view/VnosOcenIzpitaPoStudentih.php", [
                    "id_predmet" => $data["id_predmet"],
                    "id_rok" => $data["id_rok"],
                    "datum_roka" => $data["id_rok"],
                    "prijavljeniStudenti" => $prijavljeniStudenti,
                    "izvajalci" => $izvajalci,
                    "izprasevalci" => $izprasevalci,
                    "rok_data" => $rokData
                ]);

            }else{
                ViewHelper::error403();
            }
        }else{
          ViewHelper::error401();
        }
    }

    // Ajax klic za vnos ene ocene --> Iz vnosOcenPoStudentih()
    public static function vnosEneOceneIzpitaAjax(){
        $data = filter_input_array(INPUT_POST, [
            "id_prijava" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "tocke" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);

        ProfesorDB::updateTockeIzpita($data["id_prijava"], $data["tocke"]);
    }

    // Ajax klic za vracanje prijave --> Iz vnosOcenPoStudentih()
    public static function vrniPrijavoNaIzpitAjax(){
        $data = filter_input_array(INPUT_POST, [
            "id_prijava" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
        ]);

        ProfesorDB::vrniPrijavoProfesor($data["id_prijava"], User::getId());
    }

    // Ajax klic za vracanje prijave --> Iz vnosOcenPoStudentih()
    public static function prekliciVrnjenoPrijavoAjax(){
        $data = filter_input_array(INPUT_POST, [
            "id_prijava" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
        ]);

        ProfesorDB::prekliciVrnjenoPrijavoProfesor($data["id_prijava"], User::getId());
    }

    /********* VNOS KONCNIH OCEN ********/
    public static function vnosKoncnihOcenChooseLeto($status = null, $message = null) {
        if (User::isLoggedIn()) {
            if (User::isLoggedInAsProfessor()) {

                ViewHelper::render("view/VnosKoncnihOcenChooseLeto.php", [
                    "pageTitle" => "Končne ocene",
                    "allData" => StudijskoLetoModel::getAll(),
                    "formAction" => "VnosKoncnihOcenP/leto",
                    "status" => $status,
                    "message" => $message
                ]);
            } else {
                ViewHelper::error403();
            }
        } else {
            ViewHelper::error401();
        }
    }

    public static function vnosKoncnihOcenIzberiPredmetInRok($id_stud_leto) {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsProfessor()){

                // Get izpiti for profesor
                $id_oseba = User::getId();
                //var_dump("ID_OSEBA=".$id_oseba." ID_STUD_LETO=".$id_stud_leto);
                $predmetiProfesorja = ProfesorDB::getPredmetiProfesorja($id_oseba, $id_stud_leto);
                //var_dump($predmetiProfesorja);

                // Najdi izvajalce predmeta, kreiraj locen array $izvajalciPredmetov
                $izvajalciPredmetov=[];
                foreach ($predmetiProfesorja as $key => $value){

                    $izvajalciRoka = "";
                    $tmp = PredmetModel::getPredmetIzvajalci($value["ID_PREDMET"], $id_stud_leto);
                    $tmp = $tmp[0];

                    if($tmp["ID_OSEBA1"] != null) $izvajalciRoka .= $tmp["IME1"]." ".$tmp["PRIIMEK1"];
                    if ($tmp["ID_OSEBA2"] != null) $izvajalciRoka .= ", ".$tmp["IME2"]." ".$tmp["PRIIMEK2"];
                    if ($tmp["ID_OSEBA3"] != null) $izvajalciRoka .= ", ".$tmp["IME3"]." ".$tmp["PRIIMEK3"];
                    $temp["ID_PREDMET"] = $value["ID_PREDMET"];
                    $temp["IZVAJALEC"] = $izvajalciRoka;

                    array_push($izvajalciPredmetov, $temp);
                }

                // Get izpitni roki za vse izpite profesorja
                $izpitniRokiProfesorja = ProfesorDB::getIzpitniRokiProfesorja($id_oseba, $id_stud_leto);

                foreach($izpitniRokiProfesorja as $key => $value){
                    $izpitniRokiProfesorja[$key]["DATUM_ROKA"] = self::formatDateSlo($value["DATUM_ROKA"]);

                    foreach($izvajalciPredmetov as $k1 => $v1){
                        if($v1["ID_PREDMET"] === $value["ID_PREDMET"]){
                            $izpitniRokiProfesorja[$key]["IZVAJALEC"] = $v1["IZVAJALEC"];
                        }
                    }
                }

                ViewHelper::render("view/VnosKoncnihOcenChoosePredmetInRok.php", [
                    "predmeti" => $predmetiProfesorja,
                    "izpitniRoki" => $izpitniRokiProfesorja,
                    "izvajalciPredmetov" => $izvajalciPredmetov,
                    "id_stud_leto" => $id_stud_leto
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    // Forma za vnos ocen, ko je ze izbran predmet in izpitni rok
    public static function vnosKoncnihOcen($id_stud_leto){

        if (User::isLoggedIn()){
            if (User::isLoggedInAsProfessor()){

                $data = filter_input_array(INPUT_POST, [
                    "id_predmet" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
                    "id_rok" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],

                ]);
                //var_dump("ID SL: " . $id_stud_leto);


                $prijavljeniStudenti = ProfesorDB::getPrijavljeniNaIzpit($data['id_rok']);
                //var_dump($prijavljeniStudenti);
                $prijavljeniStudenti = self::vnesiVP($prijavljeniStudenti);
                $izvajalciArray = PredmetModel::getPredmetIzvajalci($data["id_predmet"], $id_stud_leto);
                $izprasevalciArray = RokModel::getRokIzprasevalci($data["id_rok"]);

                $izvajalci = self::createIzvajalciString($izvajalciArray);
                $izprasevalci = self::createIzprasevalciString($izprasevalciArray);
                $rokData = RokModel::get($data["id_rok"]);

                /*
                foreach ($prijavljeniStudenti as $i=>$value){
                    $stejPrijavLetos=StudentController::zapSteviloPrijavLetosProf($data["id_rok"],$value["VPISNA_STEVILKA"]);
                    $stejPrijavSkupno=StudentController::zapSteviloPrijavSkupnoProf($data["id_rok"],$value["VPISNA_STEVILKA"]);

                    $prijavljeniStudenti[$i]["ZAP_ST_POLAGANJ"]=$stejPrijavSkupno;
                    $prijavljeniStudenti[$i]["ZAP_ST_POLAGANJ_LETOS"]=$stejPrijavLetos;
                }
                */

                ViewHelper::render("view/VnosKoncnihOcenPoStudentih.php", [
                    "id_predmet" => $data["id_predmet"],
                    "id_rok" => $data["id_rok"],
                    "datum_roka" => $data["id_rok"],
                    "prijavljeniStudenti" => $prijavljeniStudenti,
                    "izvajalci" => $izvajalci,
                    "izprasevalci" => $izprasevalci,
                    "rok_data" => $rokData,
                ]);

            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function vnesiVP($prijavljeniStudenti){

        foreach ($prijavljeniStudenti as $key => $value){

            if(isset($value["DATUM_ODJAVE"])){
                $prijavljeniStudenti[$key]["TOCKE_IZPITA"] = "VP";
                $prijavljeniStudenti[$key]["ZAP_ST_POLAGANJ"] = "";
                $prijavljeniStudenti[$key]["ZAP_ST_POLAGANJ_LETOS"] = "";
            }
        }
        return $prijavljeniStudenti;
    }

    // Forma za vnos ocen, ko je ze izbran predmet in izpitni rok
    public static function izpisKoncnihOcen($id_stud_leto){

        if (User::isLoggedIn()){
            if (User::isLoggedInAsProfessor()){

                $data = filter_input_array(INPUT_POST, [
                    "id_predmet" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
                    "id_rok" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],

                ]);

                $prijavljeniStudenti = ProfesorDB::getPrijavljeniNaIzpit($data['id_rok']);
                $prijavljeniStudenti = self::vnesiVP($prijavljeniStudenti);
                $izvajalciArray = PredmetModel::getPredmetIzvajalci($data["id_predmet"], $id_stud_leto);
                $izprasevalciArray = RokModel::getRokIzprasevalci($data["id_rok"]);
                $izvajalci = self::createIzvajalciString($izvajalciArray);
                $izprasevalci = self::createIzprasevalciString($izprasevalciArray);
                $rokData = RokModel::get($data["id_rok"]);

                /*
                foreach ($prijavljeniStudenti as $i=>$value){
                    $stejPrijavLetos=StudentController::zapSteviloPrijavLetosProf($data["id_rok"],$value["VPISNA_STEVILKA"]);
                    $stejPrijavSkupno=StudentController::zapSteviloPrijavSkupnoProf($data["id_rok"],$value["VPISNA_STEVILKA"]);

                    $prijavljeniStudenti[$i]["ZAP_ST_POLAGANJ"]=$stejPrijavSkupno;
                    $prijavljeniStudenti[$i]["ZAP_ST_POLAGANJ_LETOS"]=$stejPrijavLetos;
                }
                */

                ViewHelper::render("view/IzpisKoncnihOcenPoStudentih.php", [
                    "id_predmet" => $data["id_predmet"],
                    "id_rok" => $data["id_rok"],
                    "datum_roka" => $data["id_rok"],
                    "prijavljeniStudenti" => $prijavljeniStudenti,
                    "izvajalci" => $izvajalci,
                    "izprasevalci" => $izprasevalci,
                    "rok_data" => $rokData
                ]);

            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function najdiZadnjoOceno($prijavljeniStudenti, $prijava){

        foreach($prijavljeniStudenti as $psKey => $psValue){
            $maxIdPrijava = null;
            $stPolaganj = null;
            $stPolaganjLetos = null;
            $tocke = null;
            $cntrPrijav = 0;
            $cntrVrnjenihPrijav = 0;

            foreach ($prijava as $pKey => $pValue){
                if($psValue["VPISNA_STEVILKA"] === $pValue["VPISNA_STEVILKA"] && $pValue["ZAP_ST_POLAGANJ"] > $stPolaganj && !isset($pValue["DATUM_ODJAVE"])){
                    $maxIdPrijava = $pValue["ID_PRIJAVA"];
                    $stPolaganj = $pValue["ZAP_ST_POLAGANJ"];
                    $stPolaganjLetos = $pValue["ZAP_ST_POLAGANJ_LETOS"];
                    $tocke = $pValue["TOCKE_IZPITA"];
                }

                if($psValue["VPISNA_STEVILKA"] == $pValue["VPISNA_STEVILKA"]) $cntrPrijav++;
                if($psValue["VPISNA_STEVILKA"] == $pValue["VPISNA_STEVILKA"] && isset($pValue["DATUM_ODJAVE"])) $cntrVrnjenihPrijav++;
            }

            if($cntrPrijav == $cntrVrnjenihPrijav) $tocke = "VP";

            $prijavljeniStudenti[$psKey]["ID_PRIJAVA"] = $maxIdPrijava;
            $prijavljeniStudenti[$psKey]["ZAP_ST_POLAGANJ"] = $stPolaganj;
            $prijavljeniStudenti[$psKey]["ZAP_ST_POLAGANJ_LETOS"] = $stPolaganjLetos;
            $prijavljeniStudenti[$psKey]["TOCKE_IZPITA"] = $tocke;
        }

        //var_dump($prijavljeniStudenti);
        return $prijavljeniStudenti;
    }

    // Ajax klic za vnos ene ocene --> Iz vnosOcenPoStudentih()
    public static function vnosEneKoncneOceneAjax(){

        $data = filter_input_array(INPUT_POST, [
            "id_prijava" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "ocena" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);

        ProfesorDB::updateOcenaIzpita($data["id_prijava"], $data["ocena"]);
    }

    /********* VNOS IZPITOV *********/

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
                    "pageTitle" => "Seznam vseh rokov",
                    "roki" => $roki,
                    "formAction" => "izpitniRok/profesor/",
                    "idOseba" => User::getId(),
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
                    RokModel::odjaviStudente($data['activateId'], User::getId());
                    if(RokModel::isActivated($data['activateId'])) {
                        self::izpitniRokAllForm("Success", "Rok aktiviran.");
                    } else {
                        self::izpitniRokAllForm("Success", "Rok deaktiviran, vsi prijavljeni študentje so bili odjavljeni.");
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

    /********* VZDRZEVANJE PREDMETNIKA *********/

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

        #ump($data);

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

    public static function formatDateSlo($date){
        list($d, $m, $y) = explode('-', $date);
        return $y.".".$m.".".$d;
    }

    public static function formatDateTimeSlo($dateTime){

        $date = substr($dateTime, 0, 10);
        $time = substr($dateTime, 11, 8);
        list($d, $m, $y) = explode('-', $date);
        list($h, $min) = explode(':', $time);
        return $y.".".$m.".".$d." (".$h.":".$min.")";
    }



//PAVLIN: seznam vpisanih v predmet
    public static function VpisaniForm1($status = null, $message = null) {
        if (User::isLoggedIn()) {
            if (User::isLoggedInAsProfessor()) {

                ViewHelper::render("view/VpisaniChooseLetoP.php", [
                    "pageTitle" => "Seznam vseh študijskih let",
                    "allData" => StudijskoLetoModel::getAll(),
                    "formAction" => "vpisPredmetP/leto",
                    "status" => $status,
                    "message" => $message
                ]);
            } else {
                ViewHelper::error403();
            }
        } else {
            ViewHelper::error401();
        }
    }

    public static function VpisaniForm2($id, $status = null, $message = null) {
        if (User::isLoggedIn()) {
            if (User::isLoggedInAsProfessor()) {

                $data = ProfesorDB::getPredmetiProfesorja2($id);

                if(count($data) == 0){
                    $status = 1;
                    $message = "V tem letu še ni predmetov";
                }

                ViewHelper::render("view/VpisaniChoosePredmetP.php", [
                    "pageTitle" => "Seznam vseh študijskih let",
                    "predmeti" => $data,
                    "formAction" => "vpisPredmetP/predmet",
                    "idLeto" => $id,
                    "status" => $status,
                    "message" => $message
                ]);
            } else {
                ViewHelper::error403();
            }
        } else {
            ViewHelper::error401();
        }
    }


    public static function VpisaniForm3($leto, $predmet, $status = null, $message = null) {
        if (User::isLoggedIn()) {
            if (User::isLoggedInAsProfessor()) {

                $data = StudentOfficerDB::getVpisani($predmet, $leto);
                if(count($data) == 0){
                    $status = 1;
                    $message = "V predmet v tem letu ni vpisanih študentov! ";
                }

                ViewHelper::render("view/VpisaniPrikazP.php", [
                    "vpisani" => $data,
                    "pageTitle" => "Seznam vseh študijskih let",
                    "formAction" => "predmet",
                    "leto" => StudentOfficerDB::getLeto($leto),
                    "predmet" => StudentOfficerDB::getPredmet($predmet),
                    "idLeto" => $leto,
                    "idPredmet" => $predmet,
                    "status" => $status,
                    "message" => $message
                ]);
            } else {
                ViewHelper::error403();
            }
        } else {
            ViewHelper::error401();
        }
    }
    public static function kartotecniListForm1($status = null, $message = null) {
    if (User::isLoggedIn()) {
        if (User::isLoggedInAsProfessor()) {

            ViewHelper::render("view/KartotecniListChooseProgram.php", [
                "pageTitle" => "Izberite program",
                "allData" => StudijskoLetoModel::getAllProgram(),
                "formAction" => "kartotecniListP/programID",
                "status" => $status,
                "oseba" => 3,
                "message" => $message
            ]);
        } else {
            ViewHelper::error403();
        }
    } else {
        ViewHelper::error401();
    }
}
    public static function kartotecniListForm2($id, $status = null, $message = null) {
        if (User::isLoggedIn()) {
            if (User::isLoggedInAsProfessor()) {
                $data = StudijskoLetoModel::getAll();

                ViewHelper::render("view/KartotecniListChooseLeto.php", [
                    "pageTitle" => "Izberite študijsko leto",
                    "allData" => $data,
                    "formAction" => $id."/letoID",
                    "status" => $status,
                    "oseba" => 3,
                    "message" => $message
                ]);
            } else {
                ViewHelper::error403();
            }
        } else {
            ViewHelper::error401();
        }
    }
    public static function kartotecniListForm3($id1, $id2, $status = null, $message = null) {
        if (User::isLoggedIn()) {
            if (User::isLoggedInAsProfessor()) {

                ViewHelper::render("view/KartotecniListChooseStudent.php", [
                    "pageTitle" => "Izberite študenta",
                    "allData" => KartotecniListDB::getAllStudents($id1, $id2),
                    "formAction" => "kartotecniListP/programID/" . $id1."/letoID/".$id2."/studentID",
                    "status" => $status,
                    "oseba" => 3,
                    "message" => $message
                ]);
            } else {
                ViewHelper::error403();
            }
        } else {
            ViewHelper::error401();
        }
    }public static function kartotecniListForm4($id1, $id2, $id3, $id4, $status = null, $message = null)
{

    if (User::isLoggedIn()) {
        if (User::isLoggedInAsProfessor()) {
            $studData = KartotecniListDB::getStudData($id3);
            $ocenePoLetih = KartotecniListDB::getOcenePoLetih($id3);

            $title = "Prosimo izberite program študenta " . $studData[0]['IME'] . " " . $studData[0]['PRIIMEK'] . "  (" .
                $studData[0]['VPISNA_STEVILKA'] . ")";

            if ($id4 == 1) {
                $data = KartotecniListDB::getAllPolaganja($id3);
            } else {
                $data = KartotecniListDB::getZadnjaPolaganja($id3);
            }
            $program = $data[1];
            $data = $data[0];
            $programi = array();
            foreach ($program as $key=>$value):
                if (!in_array($key, $programi)){
                    array_push($programi, $key);
                }

            endforeach;

            if(count($program) > 1){
                $programi = KartotecniListDB::getProgrami($programi);
                ViewHelper::render("view/KartotecniListStudentChoose.php", [
                    "pageTitle" => $title,
                    "allData" => $programi,
                    "formAction" => $id4."/program",
                    "studData" => $studData,
                    "ocene" => $ocenePoLetih,
                    "status" => $status,
                    "oseba" => 3,
                    "message" => $message
                ]);
            }
            else {
                self::kartotecniListForm5($programi[0], $id1, $id2,$id3, $id4, $status, $message);}
        } else {
            ViewHelper::error403();
        }
    } else {
        ViewHelper::error401();
    }
}
    public static function kartotecniListForm5($program, $id1, $id2, $id3, $id4, $status = null, $message = null) {

        if (User::isLoggedIn()) {
            if (User::isLoggedInAsProfessor()) {
                $studData = KartotecniListDB::getStudData($id3);
                $ocenePoLetih = KartotecniListDB::getOcenePoLetih($id3);

                $title = "Kartotečni list študenta ".$studData[0]['IME'] . " " .$studData[0]['PRIIMEK'] ."  (" .
                    $studData[0]['VPISNA_STEVILKA'] . ")";

                if ($id4 == 1){
                    $data = KartotecniListDB::getAllPolaganja($id3);
                }
                else{
                    $data = KartotecniListDB::getZadnjaPolaganja($id3);
                }
                $data = $data[0];
                $midData = array();
                $midStudData = array();
                if ($program != 0) {

                    foreach ($data as $key => $value):
                        if($value[0]['ID_PROGRAM'] == $program){
                            $midData[$key] = $value;
                        }
                    endforeach;

                    foreach ($studData as $value):

                        if($value['ID_PROGRAM'] == $program){
                            array_push($midStudData, $value);
                        }
                    endforeach;
                    $data = $midData;
                    $studData = $midStudData;
                }
                #var_dump($studData);

                ViewHelper::render("view/KartotecniListShowStudent.php", [
                    "pageTitle" => $title,
                    "allData" => $data,
                    "formAction" => "studentID",
                    "studData" => $studData,
                    "oseba" => 3,
                    "ocene" => $ocenePoLetih,
                    "status" => $status,
                    "student" => $id3,
                    "pogled" => $id4,
                    "program" => $program,
                    "message" => $message
                ]);
            } else {
                ViewHelper::error403();
            }
        } else {
            ViewHelper::error401();
        }
    }

    public static function createIzvajalciString($izvajalciArray){
        $izvajalciArray = $izvajalciArray[0];
        $izvajalci = "";
        if($izvajalciArray["ID_OSEBA1"] != null) $izvajalci .= $izvajalciArray["IME1"]." ".$izvajalciArray["PRIIMEK1"];
        if($izvajalciArray["ID_OSEBA2"] != null) $izvajalci .= ", ".$izvajalciArray["IME2"]." ".$izvajalciArray["PRIIMEK2"];
        if($izvajalciArray["ID_OSEBA3"] != null) $izvajalci .= ", ".$izvajalciArray["IME3"]." ".$izvajalciArray["PRIIMEK3"];
        return $izvajalci;
    }

    public static function createIzprasevalciString($izprasevalciArray){
        $izprasevalciArray = $izprasevalciArray[0];
        $izprasevalci = "";
        if($izprasevalciArray["ID_OSEBA_IZPRASEVALEC1"] != null) $izprasevalci .= $izprasevalciArray["IME1"]." ".$izprasevalciArray["PRIIMEK1"];
        if($izprasevalciArray["ID_OSEBA_IZPRASEVALEC2"] != null) $izprasevalci .= ", ".$izprasevalciArray["IME2"]." ".$izprasevalciArray["PRIIMEK2"];
        if($izprasevalciArray["ID_OSEBA_IZPRASEVALEC3"] != null) $izprasevalci .= ", ".$izprasevalciArray["IME3"]." ".$izprasevalciArray["PRIIMEK3"];
        return $izprasevalci;
    }


    public static function kartotecniListExportPDF(){
        $input = filter_input_array(INPUT_POST, [
            "student" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "pogled" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "program" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);
        $program = $input['program'];
        $studData = KartotecniListDB::getStudData($input['student']);

        $ocenePoLetih = KartotecniListDB::getOcenePoLetih($input['student']);
        if ($input['pogled'] == 1){
            $data = KartotecniListDB::getAllPolaganja($input['student']);
        } else {
            $data = KartotecniListDB::getZadnjaPolaganja($input['student']);
        }
        $data = $data[0];

        if ($program != 0) {
            $midData = array();
            $midStudData = array();
            foreach ($data as $key => $value):

                if($value[0]['ID_PROGRAM'] == $program){
                    $midData[$key] = $value;
                }
            endforeach;

            foreach ($studData as $value):

                if($value['ID_PROGRAM'] == $program){
                    array_push($midStudData, $value);
                }
            endforeach;
            $data = $midData;
            $studData = $midStudData;
        }


        $list = array_keys($data);

        $mainHead = "Kartotečni list študenta " . $studData[0]['IME'] . " " . $studData[0]['PRIIMEK'] . "  (" .
            $studData[0]['VPISNA_STEVILKA'] . ")";
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
        $pdf->SetFont('DejaVu','',14);
        $pdf->Cell(180,10, $mainHead,0,0);
        $pdf->Ln();
        $pdf->Ln();
        for ( $i = 0; $i< sizeof($studData); $i++){

            $header = array('Študijsko leto', 'Študijski program', 'Letnik', 'Vrsta vpisa', 'Način študija');
            $lineData = array($studData[$i]['STUD_LETO'], $studData[$i]['NAZIV_PROGRAM'], $studData[$i]['STUD_LETO'],
                $studData[$i]['ID_LETNIK'],$studData[$i]['OPIS_VPISA'],$studData[$i]['OPIS_NACIN']);
            $pdf->Ln();
            $pdf->SetFont('DejaVu','',10);
            $pdf->BasicTableO($header,$lineData);
            $pdf->SetFont('DejaVu','',12);
            $pdf->Ln();


            $header2 = array('Šifra predmeta', 'Ime predmeta', 'KT/U', 'Izpraševalec/ci', 'Datum izpita', 'št.polaganj', 'ocena');
            $lineData2=null;
            $c = -1;
            $all = array();
            foreach ($data[$list[$i]] as $key => $value){
                if($value['DATUM_ROKA'] != "/") {
                    list($d, $m, $y) = explode('-', $value['DATUM_ROKA']);
                    $datum = $y . "." . $m . "." . $d;
                }
                else $datum = "";

                if($datum != ""){
                    $izvajalci = $value['izvajalci'];
                    $polaganja = $value['ZAP_ST_POLAGANJ']."/".$value['ZAP_ST_POLAGANJ_LETOS'];
                    $ocena = $value['OCENA_IZPITA'];
                }
                else{
                    $izvajalci = "";
                    $polaganja = "";
                    $ocena = "";
                }

                $c+=1;
                $lineData2 = array($value['SIFRA_PREDMET'], $value['IME_PREDMET'], $value['ST_KREDITNIH_TOCK'],
                    $izvajalci,$datum, $polaganja, $ocena );
                array_push($all, $lineData2);
            }
            $pdf->Ln();
            $pdf->SetFont('DejaVu','',8);
            $pdf->BasicTableHKT($header2,$all);
            $pdf->AddPage('');
        }
        $noga = array("#", "Studijsko leto","Letnik", "KT/U", "Ocena");
        $pdf->Ln();
        $pdf->SetFont('DejaVu','',8);
        $pdf->BasicTableH5($noga, $ocenePoLetih);


        $pdf->Output();
        $filename="data.pdf";
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
    }

    public static function kartotecniListexportCSV(){
        $input = filter_input_array(INPUT_POST, [
            "student" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "pogled" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "program" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);
        $filename = "data.csv";
        $f = fopen('php://memory', 'w');
        $delimiter =",";
        $program = $input['program'];
        $studData = KartotecniListDB::getStudData($input['student']);

        $ocenePoLetih = KartotecniListDB::getOcenePoLetih($input['student']);
        if ($input['pogled'] == 1){
            $data = KartotecniListDB::getAllPolaganja($input['student']);
        } else {
            $data = KartotecniListDB::getZadnjaPolaganja($input['student']);
        }
        $data = $data[0];

        if ($program != 0) {
            $midData = array();
            $midStudData = array();
            foreach ($data as $key => $value):

                if($value[0]['ID_PROGRAM'] == $program){
                    $midData[$key] = $value;
                }
            endforeach;

            foreach ($studData as $value):

                if($value['ID_PROGRAM'] == $program){
                    array_push($midStudData, $value);
                }
            endforeach;
            $data = $midData;
            $studData = $midStudData;
        }
        $tDate=date("Y-m-d");
        $sloDate=ProfessorController::formatDateSlo($tDate);

        $list = array_keys($data);

        $mainHead = array("Kartotečni list študenta " . $studData[0]['IME'] . " " . $studData[0]['PRIIMEK'] . "  (" .
            $studData[0]['VPISNA_STEVILKA'] . ")");
        fputcsv($f, $mainHead, $delimiter);
        fputcsv($f, array(), $delimiter);
        fputcsv($f, array(), $delimiter);


        for ( $i = 0; $i< sizeof($studData); $i++){

            $header = array('Študijsko leto', 'Študijski program', 'Letnik', 'Vrsta vpisa', 'Način študija');
            $lineData = array($studData[$i]['STUD_LETO'], $studData[$i]['NAZIV_PROGRAM'], $studData[$i]['STUD_LETO'],
                $studData[$i]['ID_LETNIK'],$studData[$i]['OPIS_VPISA'],$studData[$i]['OPIS_NACIN']);
            fputcsv($f, array(), $delimiter);
            fputcsv($f, $header, $delimiter);
            fputcsv($f, $lineData, $delimiter);

            fputcsv($f, array(), $delimiter);


            $header2 = array('Šifra predmeta', 'Ime predmeta', 'KT/U', 'Izpraševalec/ci', 'Datum izpita', 'št.polaganj', 'ocena');
            fputcsv($f, $header2, $delimiter);
            $lineData2=null;
            $c = -1;
            $all = array();
            foreach ($data[$list[$i]] as $key => $value){
                if($value['DATUM_ROKA'] != "/") {
                    list($d, $m, $y) = explode('-', $value['DATUM_ROKA']);
                    $datum = $y . "." . $m . "." . $d;
                }
                else $datum = "";

                if($datum != ""){
                    $izvajalci = $value['izvajalci'];
                    $polaganja = $value['ZAP_ST_POLAGANJ']."/".$value['ZAP_ST_POLAGANJ_LETOS'];
                    $ocena = $value['OCENA_IZPITA'];
                }
                else{
                    $izvajalci = "";
                    $polaganja = "";
                    $ocena = "";
                }

                $c+=1;
                $lineData2 = array($value['SIFRA_PREDMET'], $value['IME_PREDMET'], $value['ST_KREDITNIH_TOCK'],
                    $izvajalci,$datum, $polaganja, $ocena );
                fputcsv($f, $lineData2, $delimiter);
            }
            fputcsv($f, array(), $delimiter);
            fputcsv($f, array(), $delimiter);

        }
        fputcsv($f, array(), $delimiter);


        $noga = array("Studijsko leto","Letnik", "KT/U", "Ocena");
        fputcsv($f, $noga, $delimiter );
        foreach ($ocenePoLetih as $row):
            $lineData = array($row['STUD_LETO'], $row['ID_LETNIK'], $row['SUM'], $row['AVG']);
            fputcsv($f, $lineData, $delimiter);


        endforeach;


        fseek($f, 0);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
        fpassthru($f);
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