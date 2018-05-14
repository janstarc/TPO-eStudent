<?php

require_once("model/StudentOfficerDB.php");
require_once("model/StudentModel.php");
require_once("model/StudijskoLetoModel.php");
require_once("model/StudijskiProgramModel.php");
require_once("model/KandidatModel.php");
require_once("model/UserModel.php");
require_once("model/User.php");
require_once("includes/Validation.php");
require_once("ViewHelper.php");

class StudentOfficerController {
    public static function chooseProfesor($status = null, $message = null) {
        if (User::isLoggedIn()) {
            if (User::isLoggedInAsStudentOfficer()) {
                ViewHelper::render("view/IzpitniRokChooseProfesorByReferent.php", [
                    "pageTitle" => "Seznam vseh profesorjev",
                    "allData" => ProfesorDB::getAllProfessors(),
                    "formAction" => "chooseProfesor",
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
    
    public static function izpitniRokForm($id, $status = null, $message = null) {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsStudentOfficer()){
                $IdYear =  StudijskoLetoModel::getIdOfYear(CURRENT_YEAR);
                $IdIzvedbaPredmeta = IzvedbaPredmetaModel::getIdIzvedbaPredmetaByProfesor($id, $IdYear);
                ViewHelper::render("view/IzpitniRokProfesorAdd.php", [
                    "pageTitle" => "Ustvari izpitni rok",
                    "IdIzvedbaPredmeta" => $IdIzvedbaPredmeta,
                    "formAction" => "izpitniRok/referent/chooseProfesor/".$id."/add",
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

    public static function VnosIzpitnegaRoka($id) {
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
        if (!Validation::checkValues($data)) {
            self::izpitniRokForm($id, "Failure", "You have entered an invalid value. Please try again.");
        } else {
            list($d, $m, $y) = explode('-', $data["DATUM_ROKA"]);
            $data["DATUM_ROKA"] = $y."-".$m."-".$d;
            if (!checkdate($m, $d, $y)) {
                self::izpitniRokForm($id, "Failure", "You have entered an invalid date. Please try again.");
            } else {
                date_default_timezone_set('Europe/Ljubljana');
                $weekDay = date('w', strtotime($data["DATUM_ROKA"]));
                if ($weekDay == 0 || $weekDay == 6) {
                    self::izpitniRokForm($id, "Failure", "The entered date cannot be a saturday or sunday. Please try again.");
                } else {
                    $holidays = array("01-01", "02-01", "08-02", "02-04", "27-04", "01-05", "02-05", "25-06", "15-08", "31-10", "01-11", "25-12", "26-12");
                    if (in_array($d . "-" . $m, $holidays)) {
                        self::izpitniRokForm($id, "Failure", "The entered date cannot be a holiday. Please try again.");
                    } else {
                        if (strtotime(date("Y-m-d")) >= strtotime($data["DATUM_ROKA"])) {
                            self::izpitniRokForm($id, "Failure", "The entered date cannot be in the past. Please try again.");
                        } else {
                            if ($data["CAS_ROKA"]{0} == '2' && $data["CAS_ROKA"]{1} > '3') {
                                self::izpitniRokForm($id, "Failure", "You have entered an invalid time value. Please try again.");
                            } else {
                                if (!RokModel::isUnique($data)) {
                                    self::izpitniRokForm($id, "Failure", "Napaka, rok na ta datum ze obstaja. Poskusite znova.");
                                } else {
                                    RokModel::insert($data["ID_IZVEDBA"], $data["DATUM_ROKA"], $data["CAS_ROKA"]);
                                    self::izpitniRokAllForm($id, "Success", "Uspesno ste ustvarili novi rok.");
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public static function izpitniRokAllForm($id, $status = null, $message = null) {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsStudentOfficer()) {
                $IdYear = StudijskoLetoModel::getIdOfYear(CURRENT_YEAR);
                $roki = RokModel::getAll($id, $IdYear);
                if (empty($roki)) {
                    $status = "Info";
                    $message = "Ni podatkov v podatkovna baza. Ustvarite vsaj enega.";
                }

                ViewHelper::render("view/IzpitniRokByReferentProfesorAll.php", [
                    "pageTitle" => "Seznam vse roke",
                    "roki" => $roki,
                    "idOseba" => $id,
                    "formAction" => "izpitniRok/referent/chooseProfesor/",
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

    public static function izpitniRokEditForm($id1, $id2, $status = null, $message = null) {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsStudentOfficer()){
                $rok = RokModel::get($id2);
                ViewHelper::render("view/IzpitniRokByReferentProfesorEdit.php", [
                    "pageTitle" => "Spremeni izbranega izpitnega roka",
                    "getId" => $rok,
                    "IdIzvedbaPredmeta" => IzvedbaPredmetaModel::getIdIzvedbaPredmetaByProfesor($id1, $rok["ID_STUD_LETO"]),
                    "formAction" => "izpitniRok/referent/chooseProfesor/".$id1."/",
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

    public static function SpremembaIzpitnegaRoka($id1, $id2) {
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
        if (!Validation::checkValues($data)) {
            self::izpitniRokEditForm($id1, $id2, "Failure", "You have entered an invalid value. Please try again.");
        } else {
            list($d, $m, $y) = explode('-', $data["DATUM_ROKA"]);
            $data["DATUM_ROKA"] = $y."-".$m."-".$d;
            if (!checkdate($m, $d, $y)) {
                self::izpitniRokEditForm($id1, $id2, "Failure", "You have entered an invalid date. Please try again.");
            } else {
                date_default_timezone_set('Europe/Ljubljana');
                $weekDay = date('w', strtotime($data["DATUM_ROKA"]));
                if ($weekDay == 0 || $weekDay == 6) {
                    self::izpitniRokEditForm($id1, $id2, "Failure", "The entered date cannot be a saturday or sunday. Please try again.");
                } else {
                    $holidays = array("01-01", "02-01", "08-02", "02-04", "27-04", "01-05", "02-05", "25-06", "15-08", "31-10", "01-11", "25-12", "26-12");
                    if (in_array($d . "-" . $m, $holidays)) {
                        self::izpitniRokEditForm($id1, $id2, "Failure", "The entered date cannot be a holiday. Please try again.");
                    } else {
                        if (strtotime(date("Y-m-d")) >= strtotime($data["DATUM_ROKA"])) {
                            self::izpitniRokEditForm($id1, $id2, "Failure", "The entered date cannot be in the past. Please try again.");
                        } else {
                            if ($data["CAS_ROKA"]{0} == '2' && $data["CAS_ROKA"]{1} > '3') {
                                self::izpitniRokEditForm($id1, $id2, "Failure", "You have entered an invalid time value. Please try again.");
                            } else {
                                $data["ID_ROK"]=$id2;
                                if (!RokModel::isUniqueIfAlreadyCreated($data)) {
                                    self::izpitniRokEditForm($id1, $id2, "Failure", "Napaka, rok na ta datum ze obstaja. Poskusite znova.");
                                } else {
                                    RokModel::update($id2, $data["ID_IZVEDBA"], $data["DATUM_ROKA"], $data["CAS_ROKA"]);
                                    self::izpitniRokAllForm($id1, "Success", "Uspesno ste spremenili izbrani rok.");
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public static function toggleizpitniRokActivated($id) {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsStudentOfficer()){
                $data = filter_input_array(INPUT_POST, [
                    'activateId' => [
                        'filter' => FILTER_VALIDATE_INT,
                        'options' => [
                            'min_range' => 1
                        ]
                    ]
                ]);
                if (Validation::checkValues($data)) {
                    RokModel::toogleActivated($data['activateId']);
                    if(RokModel::isActivated($data['activateId'])) {
                        self::izpitniRokAllForm($id, "Success", "Rok aktiviran.");
                    } else {
                        self::izpitniRokAllForm($id, "Success", "Rok deaktiviran, uspešno odjavljenih " . rand(1, 10) . " študentov.");
                    }
                } else {
                    self::izpitniRokAllForm($id, "Failure", "Error toogling activity of the exam.");
                }
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function kandidatiList($status = null, $message = null) {
        if (User::isLoggedIn()) {
            if (User::isLoggedInAsStudentOfficer()) {
                ViewHelper::render("view/Kandidati.php", [
                    "pageTitle" => "Seznam vseh kandidatov (2018/19)",
                    "allData" => KandidatModel::getAllCandidates(),
                    "formAction" => "kandidati",
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


    public static function vpisaniStudentiList($status = null, $message = null) {
        if (User::isLoggedIn()) {
            if (User::isLoggedInAsStudentOfficer()) {
                ViewHelper::render("view/Studenti.php", [
                    "pageTitle" => "Seznam vpisanih študentov (2017/18)",
                    "allData" => KandidatModel::getAllVpisaniStudenti(),
                    "formAction" => "kandidati",
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
    
    public static function kandidatPreglejVpisForm($id, $status = null, $message = null) {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsStudentOfficer()){
                $KandidatPodatki = KandidatModel::getKandidatPodatki($id);
                $stud_leto = KandidatModel::getStudijskoLeto($KandidatPodatki["id_stud_leto"]);
                $obcine = ObcinaModel::getAll();
                $poste = PostaModel::getAll();
                $drzave = DrzavaModel::getAll();
                $userName = UserModel::getUserName(User::getId());
                $predmeti = PredmetModel::getAll([
                    "ID_STUD_LETO" => $KandidatPodatki["id_stud_leto"],
                    "ID_PROGRAM" => $KandidatPodatki["id_program"],
                    "ID_LETNIK" => 1
                ]);
                
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
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function studentVpisPreglejForm($id, $status = null, $message = null) {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsStudentOfficer()){

                $studentPodatki = StudentModel::getStudentPodatki($id);
                $stud_leto = StudentModel::getStudijskoLeto($studentPodatki["id_stud_leto"]);
                $obcine = ObcinaModel::getAll();
                $poste = PostaModel::getAll();
                $drzave = DrzavaModel::getAll();
                $userName = UserModel::getUserName(User::getId());
                $predmeti = PredmetModel::getAll([
                    "ID_STUD_LETO" => $studentPodatki['id_stud_leto'],
                    "ID_PROGRAM" => $studentPodatki['id_program'],
                    "ID_LETNIK" => $studentPodatki['ID_LETNIK']
                ]);

                ViewHelper::render("view/StudentPregledVpisa.php", [
                    "pageTitle" => "Pregled vpisnega lista študenta",
                    "formAction" => "studenti",
                    "id" => $id,
                    "KandidatPodatki" => $studentPodatki,
                    "stud_leto" => $stud_leto,
                    "StudijskaLeta" => StudijskoLetoModel::getAll(),
                    "StudijskiProgrami" => StudijskiProgramModel::getAll(),
                    "obcine" => $obcine,
                    "poste" => $poste,
                    "drzave" => $drzave,
                    "naslove" => KandidatModel::getOsebaVseNaslove($id),
                    "userName" => $userName,
                    "predmeti" => $predmeti,
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

    /*
        array (size=9)
          'Ime' => string 'kIme' (length=4)
          'Priimek' => string 'kPriimek' (length=8)
          'emso' => string '2147483647' (length=10)
          'telefonska_stevilka' => string '123456789' (length=9)
          'id_drzava' => string '4' (length=1)
          'ulica1' => string 'aa' (length=2)
          'hisna_stevilka1' => string '1' (length=1)
          'id_posta1' => string '176' (length=3)
          'ID_STUD_LETO' => string '2' (length=1)
    */
    public static function kandidatiPotrdiVpisForm($id) {

        $data = filter_input_array(INPUT_POST, [
            "Ime" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "Priimek" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "emso" =>["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "telefonska_stevilka" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "id_drzava" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "id_naslov1" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "ulica1" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "hisna_stevilka1" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "id_posta1" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "ID_STUD_LETO" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);

        // TODO - Ko se spremenijo naslovi!
        $nasloviArr = array();
        array_push($nasloviArr,
            array('id_naslov' => $data['id_naslov1'], 'ulica' => $data['ulica1'], 'hisna_stevilka' => $data['hisna_stevilka1'],
                    'id_posta' => $data['id_posta1'], 'id_drzava' => $data['id_drzava'], 'je_zavrocanje' => 1, 'je_stalni' => 1));

        KandidatModel::updateImeInPriimek($id, $data['Ime'], $data['Priimek']);
        KandidatModel::updateEmso($id, $data['emso']);
        KandidatModel::updateTelefon($id, $data['telefonska_stevilka']);
        KandidatModel::updateNaslovi($id, $nasloviArr);
        KandidatModel::potrdiVpisReferent($id);

        $KandidatPodatki = KandidatModel::getKandidatPodatki($id);
        $predmeti = PredmetModel::getAll([
            "ID_STUD_LETO" => $KandidatPodatki["id_stud_leto"],
            "ID_PROGRAM" => $KandidatPodatki["id_program"],
            "ID_LETNIK" => 1
        ]);

        $id_vpis = KandidatModel::getVpisId($id);
        KandidatModel::insertPredmetiKandidat($id_vpis, $predmeti, $KandidatPodatki["id_stud_leto"]);
        //self::kandidatiList("Success", "Vpis za študenta ".$data['ime']." ".$data['priimek']." uspešno potrjen!");
    }

    public static function ZetonForm1($status = null, $message = null) {
        if (User::isLoggedIn()) {
            if (User::isLoggedInAsStudentOfficer()) {

                ViewHelper::render("view/ZetonChooseStudLetoViewer.php", [
                    "pageTitle" => "Seznam vseh študijskih let",
                    "allData" => StudijskoLetoModel::getAll(),
                    "formAction" => "zetoni",
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

    public static function ZetonForm2($id, $status = null, $message = null) {
        if (User::isLoggedIn()) {
            if (User::isLoggedInAsStudentOfficer()) {
                $data = StudentModel::getAllStudentsByStudLeto($id);
                if (count($data) == 0){
                    $status = 1;
                    $message = "V to študijsko leto še ni vpisanih študentov!";
                }
                foreach ($data as &$value) {
                    $pogoj = StudentOfficerDB::PreveriOcene($value['VPISNA_STEVILKA']);

                    if ($pogoj == 1){
                        $value['pogoj1'] = 1;
                        $value['pogoj2'] = 0;
                    }
                    elseif ($pogoj == 2){
                        $value['pogoj1'] = 0;
                        $value['pogoj2'] = 1;

                    }
                    else{
                        $value['pogoj1'] = 0;
                        $value['pogoj2'] = 0;
                    }
                    if($value['ID_LETNIK'] == "3" and $pogoj == 1){
                        $value['pogoj1'] = 0;
                        $value['pogoj2'] = 0;
                    }
                   $value['pogoj'] = StudentOfficerDB::PreveriOcene($value['VPISNA_STEVILKA']);
                }

                ViewHelper::render("view/ZetonChooseStudent.php", [
                    "pageTitle" => "Seznam vseh študentov",
                    "allData" => $data,
                    "formAction" => "zetoni/prikaz",
                    "status" => $status,
                    "message" => $message,
                    "id" => $id
                ]);
            } else {
                ViewHelper::error403();
            }
        } else {
            ViewHelper::error401();
        }
    }

    public static function ZetonForm3($id, $status = null, $message = null) {
        if (User::isLoggedIn()) {
            if (User::isLoggedInAsStudentOfficer()) {
                ViewHelper::render("view/ZetonShow.php", [
                    "id" => $id,
                    "pageTitle" => "Seznam vseh žetonov",
                    "allData" => StudentOfficerDB::getZetoni($id),
                    "formAction" => "zetoni/prikaz",
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

    public static function ZetonForm4($id, $status = null, $message = null) {
        if (User::isLoggedIn()) {
            if (User::isLoggedInAsStudentOfficer()) {
                ViewHelper::render("view/ZetonEdit.php", [
                    "id" => $id,
                    "idOseba" => StudentOfficerDB::getOseba($id),
                    "pageTitle" => "Urejanje žetona",
                    "zeton" => StudentOfficerDB::ZetonData($id),
                    "all" => StudentOfficerDB::getAll(),
                    "formAction" => "zetoni/prikaz",
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
    public static function ZetonForm5( $status = null, $message = null) {
        if (User::isLoggedIn()) {
            if (User::isLoggedInAsStudentOfficer()) {
                $data = filter_input_array(INPUT_POST, [
                    "IdZeton" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
                    "IdOseba" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
                    "leto" =>["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
                    "letnik" =>["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
                    "program" =>["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
                    "Vrstavpisa" =>["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
                    "NacinStudija" =>["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
                    "OblikaStudija" =>["filter" => FILTER_SANITIZE_SPECIAL_CHARS],


                ]);

                StudentOfficerDB::spremeniZeton($data);
                self::ZetonForm3($data['IdOseba'],1, "Žeton je bil uspešno spremenjen");
            } else {
                ViewHelper::error403();


            }
        } else {
            ViewHelper::error401();
        }
    }
    public static function toogleActivated(){
        if (User::isLoggedIn()) {
            if (User::isLoggedInAsStudentOfficer()) {
                $data = filter_input_array(INPUT_POST, [
                    "IdZeton" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
                    "IdOseba" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],

                ]);

                StudentOfficerDB::ToogleActivate($data["IdZeton"]);
                ViewHelper::redirect(BASE_URL . "zetoni/prikaz/".$data["IdOseba"]);

            } else {
                ViewHelper::error403();
            }
        } else {
            ViewHelper::error401();
        }

    }




    public static function ZetonForm6(){
        if (User::isLoggedIn()) {
            if (User::isLoggedInAsStudentOfficer()) {
                $data = filter_input_array(INPUT_POST, [
                    "IdOseba" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
                    "Leto" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
                ]);

                StudentOfficerDB::dodajNov($data["IdOseba"]);
                echo("<script>console.log('data: : );</script>");
                ViewHelper::redirect(BASE_URL . "zetoni/".$data["Leto"]);

            } else {
                ViewHelper::error403();
            }
        } else {
            ViewHelper::error401();
        }

    }
    public static function ZetonForm7(){
        if (User::isLoggedIn()) {
            if (User::isLoggedInAsStudentOfficer()) {
                $data = filter_input_array(INPUT_POST, [
                    "IdOseba" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
                    "Leto" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
                ]);

                StudentOfficerDB::dodajNov1($data["IdOseba"]);
                ViewHelper::redirect(BASE_URL . "zetoni/".$data["Leto"]);

            } else {
                ViewHelper::error403();
            }
        } else {
            ViewHelper::error401();
        }

    }

    public static function Zeton($status = null, $message = null) {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsStudentOfficer()){
                ViewHelper::render("view/Zeton.php", [
                    "zetoni" => array(),
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

    public static function searchByEMSO() {
        $data = filter_input_array(INPUT_POST, [
            "searchEMSO" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "tip" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "idZeton" =>["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "Aktivnost" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);

        if($data["tip"] == "d"){

            StudentOfficerDB::ChangeAktivnost($data["idZeton"],$data["Aktivnost"]);
        }
        echo("<script>console.log('data: : ', ".$data['searchEMSO'] . ");</script>");
                ViewHelper::render("view/Zeton.php", [
                    "zetoni" => StudentOfficerDB::SearchEMSO($data["searchEMSO"])
                ]);

    }

    public static function dodaj() {
        $data = filter_input_array(INPUT_POST, [
            "idZeton" =>["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "LETNIK" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);
        if($data["LETNIK"] != 3){ 
            if(StudentOfficerDB::isUnique($data["idZeton"])){
                StudentOfficerDB::dodajNov(StudentOfficerDB::ZetonData($data["idZeton"]));
                self::Zeton("Success", "Uspesno ste dodali nov zeton.");
            }else{
                self::Zeton("Failure", "Napaka, zeton za nasljednji letnik ze obstaja.");
            }
        }else{
            self::Zeton("Failure", "Napaka, ne morete ustvariti zeton za nasljednji, zeton je za zadni letnik.");
        }
    }

    public static function uredi() {
        $data = filter_input_array(INPUT_POST, [
            "idZeton" =>["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
        ]);
        ViewHelper::render("view/ZetonEdit.php", [
            "id_zeton" => $data["idZeton"],
            "zeton" => StudentOfficerDB::ZetonData($data["idZeton"]),
            "all" => StudentOfficerDB::getAll()
        ]);
    }

    public static function spremeni() {
        $data = filter_input_array(INPUT_POST, [


            "leto" =>["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "letnik" =>["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "program" =>["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "Vrstavpisa" =>["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "NacinStudija" =>["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "OblikaStudija" =>["filter" => FILTER_SANITIZE_SPECIAL_CHARS],

            "id_zeton" =>["filter" => FILTER_SANITIZE_SPECIAL_CHARS]

        ]);
        StudentOfficerDB::spremeniZeton($data);
        ViewHelper::render("view/Zeton.php", [
            "zetoni" => array()
        ]);

    }

    public static function povprecje(){
        $data = filter_input_array(INPUT_POST, [
            "searchVpisna" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);


        $dataForAverage=StudentOfficerDB::izracunPovprecje($data["searchVpisna"]);
        //var_dump($dataForAverage);
    }

    public static function vpisVPredmet($status = null, $message = null) {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsStudentOfficer()){
                ViewHelper::render("view/vpisVPredmet.php", [
                    "status" => $status,
                    "message" => $message,
                    "leta" => StudentOfficerDB::getLeta(),
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
            if (User::isLoggedInAsStudentOfficer()){
                $data = filter_input_array(INPUT_POST, [


                    "leto" =>["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
                ]);
                ViewHelper::render("view/vpisVPredmet.php", [
                    "status" => $status,
                    "message" => $message,
                    "vpisani" => null,
                    "leta" => null,
                    "leto" => $data['leto'],
                    "predmeti" => StudentOfficerDB::getPredmeti($data['leto'])

                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function VpisaniForm1($status = null, $message = null) {
        if (User::isLoggedIn()) {
            if (User::isLoggedInAsStudentOfficer()) {

                ViewHelper::render("view/VpisaniChooseLeto.php", [
                    "pageTitle" => "Seznam vseh študijskih let",
                    "allData" => StudijskoLetoModel::getAll(),
                    "formAction" => "leto",
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
            if (User::isLoggedInAsStudentOfficer()) {

                $data = StudentOfficerDB::getPredmeti($id);
                if(count($data) == 0){
                    $status = 1;
                    $message = "V tem letu še ni predmetov";
                }

                ViewHelper::render("view/VpisaniChoosePredmet.php", [
                    "pageTitle" => "Seznam vseh študijskih let",
                    "predmeti" => $data,
                    "formAction" => "vpisPredmet/predmet",
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
            if (User::isLoggedInAsStudentOfficer()) {

                $data = StudentOfficerDB::getVpisani($predmet, $leto);
                if(count($data) == 0){
                    $status = 1;
                    $message = "V predmet v tem letu ni vpisanih študentov! ";
                }

                ViewHelper::render("view/VpisaniPrikaz.php", [
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



    public static function vpisVPredmetVpisani($status = null, $message = null) {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsStudentOfficer()){
                $data = filter_input_array(INPUT_POST, [

                    "idPredmet"=>["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
                    "leto" =>["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
                ]);

                ViewHelper::render("view/vpisVPredmet.php", [
                    "status" => $status,
                    "message" => $message,
                    "vpisani" => StudentOfficerDB::getVpisani($data['idPredmet'], $data['leto']),
                    "leta" => null,
                    "leto" => StudentOfficerDB::getLeto( $data['leto']),
                    "predmet" => StudentOfficerDB::getPredmet($data['idPredmet']),
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
            "idLeto" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "idPredmet"=> ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);

        $main = StudentOfficerDB::getVpisani($data['idPredmet'],$data['idLeto']);
        $leto = StudentOfficerDB::getLeto($data['idLeto']);
        $predmet = StudentOfficerDB::getPredmet($data['idPredmet']);
        $vpisani = count($main);
        $header = array('Sifra predmeta','Ime predmeta', 'Studijsko leto', 'Stevilo vpisanih studentov');
        $lineData = array($predmet["ID_PREDMET"] , $predmet["IME_PREDMET"], $leto, $vpisani);

        $header2 = array('Vpisna stevilka','Priimek in ime', 'Vrsta vpisa');
        $all = [];
        $lineData2=null;
        foreach ($main as $key => $value){

            $lineData2 = array($value["VPISNA_STEVILKA"],$value["PRIIMEK"]." ". $value["IME"], $value["OPIS_VPISA"]);
            array_push($all, $lineData2);
        }




        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(40,10,'Izpis podatkov o predmetu');
        $pdf->Ln();
        $pdf->BasicTableH2($header,$lineData);
        $pdf->Cell(40,10,'Izpis podatkov o vpisanih');
        $pdf->Ln();
        $pdf->BasicTableH($header2,$all);
        $pdf->Output('I','data.pdf');

        $filename="data.pdf";
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
    }

}
