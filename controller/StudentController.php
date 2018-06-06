<?php

require_once("model/UserModel.php");
require_once("model/StudentModel.php");
require_once("model/PredmetModel.php");
require_once("model/DataForExportModel.php");
require_once("model/PrijavaModel.php");
require_once("model/NasloveData.php");
require_once("model/DelPredmetnikaModel.php");
require_once("model/User.php");
require_once("ViewHelper.php");
require_once("model/KartotecniListDB.php");
require_once ("view/includes/tfpdf.php");



class StudentController {
    public static function vpisForm() {
        $zeton = StudentModel::getLastNeIzkoriscenZeton(User::getId());
        if ($zeton == null) {
            ViewHelper::render("view/VpisniListPDFViewer.php", [
                "vloga"=> "student",
                "id"=> User::getId(),
                "status" => "Info",
                "message" => "Vpisni list ste ze oddali. Prosim pocakajte potrditev referenta."
            ]);
        } else {
            // echo '<pre>' . var_export($zeton, true) . '</pre>';
            if ($zeton["ID_LETNIK"] == 2) {
                self::vpis2LForm();
            } else if ($zeton["ID_LETNIK"] == 3 && $zeton["PROSTA_IZBIRNOST"] == 0) {
                self::vpis3L1Form();
            } else if ($zeton["ID_LETNIK"] == 3 && $zeton["PROSTA_IZBIRNOST"] == 1) {
                self::vpis3L2Form();
            }
        }
    }

    public static function vpis2LForm($status = null, $message = null) {
        $obcine = ObcinaModel::getAll();
        $poste = PostaModel::getAll();
        $drzave = DrzavaModel::getAll();
        $userName = UserModel::getUserName(User::getId());
        $KandidatPodatki = KandidatModel::getStudentPodatki(User::getId());
        $Pravipodatki = KandidatModel::getZetonPodatki(User::getId());
        
        $ObvPredmeti = PredmetModel::getAllByType([
            "ID_STUD_LETO" => $KandidatPodatki["id_stud_leto"],
            "ID_PROGRAM" => $KandidatPodatki["id_program"],
            "ID_LETNIK" => 2,
            "TIP" => 'o'
        ]);
        $StrIzbPredmeti = PredmetModel::getAllByType([
            "ID_STUD_LETO" => $KandidatPodatki["id_stud_leto"],
            "ID_PROGRAM" => $KandidatPodatki["id_program"],
            "ID_LETNIK" => 2,
            "TIP" => 'st'
        ]);
        $SplIzbPredmeti = PredmetModel::getAllByType([
            "ID_STUD_LETO" => $KandidatPodatki["id_stud_leto"],
            "ID_PROGRAM" => $KandidatPodatki["id_program"],
            "ID_LETNIK" => 2,
            "TIP" => 'sp'
        ]);
        // echo '<pre>' . var_export($ObvPredmeti, true) . '</pre>';
        // echo '<pre>' . var_export($StrIzbPredmeti, true) . '</pre>';
        // echo '<pre>' . var_export($SplIzbPredmeti, true) . '</pre>';
        $KandidatPodatki['ID_LETNIK'] = $Pravipodatki['ID_LETNIK'];
        ViewHelper::render("view/VpisniList2Viewer.php", [
            "pageTitle" => "Vpisni list",
            "formAction" => "vpis2L",
            "KandidatPodatki" => $KandidatPodatki,
            "userName" => $userName,
            "StudijskaLeta" => $Pravipodatki['STUD_LETO'],
            "StudijskiProgrami" => StudijskiProgramModel::getAll(),
            "obcine" => $obcine,
            "poste" => $poste,
            "drzave" => $drzave,
            "naslov" => KandidatModel::getStudentVseNaslove(User::getId()),
            "predmeti" => $ObvPredmeti,
            "StrIzbPredmeti" => $StrIzbPredmeti,
            "SplIzbPredmeti" => $SplIzbPredmeti,
            "status" => $status,
            "message" => $message
        ]);
    }

    public static function vpis3L1Form($status = null, $message = null) {
        $userName = UserModel::getUserName(User::getId());
        $KandidatPodatki = KandidatModel::getStudentPodatki(User::getId());
        $Pravipodatki = KandidatModel::getZetonPodatki(User::getId());
        $obcine = ObcinaModel::getAll();
        $poste = PostaModel::getAll();
        $drzave = DrzavaModel::getAll();
        
        $ObvPredmeti = PredmetModel::getAllByType([
            "ID_STUD_LETO" => $KandidatPodatki["id_stud_leto"],
            "ID_PROGRAM" => $KandidatPodatki["id_program"],
            "ID_LETNIK" => 3,
            "TIP" => 'o'
        ]);
        $IzbModulov = DelPredmetnikaModel::getAllModulov();
        
        $ModulPredmeti = DelPredmetnikaModel::getAllSubjectsByType([
            "ID_STUD_LETO" => $KandidatPodatki["id_stud_leto"],
            "ID_PROGRAM" => $KandidatPodatki["id_program"],
            "ID_LETNIK" => 3,
            "TIP" => 'm'
        ]);
        $SplIzbPredmeti = PredmetModel::getAllByType([
            "ID_STUD_LETO" => $KandidatPodatki["id_stud_leto"],
            "ID_PROGRAM" => $KandidatPodatki["id_program"],
            "ID_LETNIK" => 2,
            "TIP" => 'sp'
        ]);
        // echo '<pre>' . var_export($ObvPredmeti, true) . '</pre>';
        // echo '<pre>' . var_export($IzbModulov, true) . '</pre>';
        // echo '<pre>' . var_export($ModulPredmeti, true) . '</pre>';
        // echo '<pre>' . var_export($SplIzbPredmeti, true) . '</pre>';
        
        ViewHelper::render("view/VpisniList31Viewer.php", [
            "pageTitle" => "Vpisni list",
            "formAction" => "vpis3L1",
            "KandidatPodatki" => $KandidatPodatki,
            "userName" => $userName,
            "StudijskaLeta" =>$Pravipodatki['STUD_LETO'],
            "StudijskiProgrami" => StudijskiProgramModel::getAll(),
            "obcine" => $obcine,
            "poste" => $poste,
            "drzave" => $drzave,
            "naslov" => KandidatModel::getStudentVseNaslove(User::getId()),
            "predmeti" => $ObvPredmeti,
            "IzbModulov" => $IzbModulov,
            "ModulPredmeti" => $ModulPredmeti,
            "SplIzbPredmeti" => $SplIzbPredmeti,
            "status" => $status,
            "message" => $message
        ]);
    }

    public static function vpis3L2Form($status = null, $message = null) {
        $userName = UserModel::getUserName(User::getId());
        $KandidatPodatki = KandidatModel::getStudentPodatki(User::getId());
        $Pravipodatki = KandidatModel::getZetonPodatki(User::getId());
        $obcine = ObcinaModel::getAll();
        $poste = PostaModel::getAll();
        $drzave = DrzavaModel::getAll();


        $ObvPredmeti = PredmetModel::getAllByType([
            "ID_STUD_LETO" => $KandidatPodatki["id_stud_leto"],
            "ID_PROGRAM" => $KandidatPodatki["id_program"],
            "ID_LETNIK" => 3,
            "TIP" => 'o'
        ]);
        $ModIzbPredmeti = PredmetModel::getAllByType([
            "ID_STUD_LETO" => $KandidatPodatki["id_stud_leto"],
            "ID_PROGRAM" => $KandidatPodatki["id_program"],
            "ID_LETNIK" => 3,
            "TIP" => 'm'
        ]);
        $SplIzbPredmeti = PredmetModel::getAllByType([
            "ID_STUD_LETO" => $KandidatPodatki["id_stud_leto"],
            "ID_PROGRAM" => $KandidatPodatki["id_program"],
            "ID_LETNIK" => 2,
            "TIP" => 'sp'
        ]);
        // echo '<pre>' . var_export($ObvPredmeti, true) . '</pre>';
        // echo '<pre>' . var_export($ModIzbPredmeti, true) . '</pre>';
        // echo '<pre>' . var_export($SplIzbPredmeti, true) . '</pre>';
        
        ViewHelper::render("view/VpisniList32Viewer.php", [
            "pageTitle" => "Vpisni list",
            "formAction" => "vpis3L2",
            "KandidatPodatki" => $KandidatPodatki,
            "userName" => $userName,
            "StudijskaLeta" => $Pravipodatki['STUD_LETO'],
            "StudijskiProgrami" => StudijskiProgramModel::getAll(),
            "obcine" => $obcine,
            "poste" => $poste,
            "drzave" => $drzave,
            "naslov" => KandidatModel::getStudentVseNaslove(User::getId()),
            "predmeti" => $ObvPredmeti,
            "ModIzbPredmeti" => $ModIzbPredmeti,
            "SplIzbPredmeti" => $SplIzbPredmeti,
            "status" => $status,
            "message" => $message
        ]);
    }
    
    public static function vpis2L($status = null, $message = null) {
        $data = filter_input_array(INPUT_POST, [
            "emso" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "DATUM_ROJSTVA" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "telefonska_stevilka" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "naslovZaVrocanje" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "id_drzava" => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => [
                    'min_range' => 1
                ]
            ],
            "ulica" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "ID_NASLOV1" => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => [
                    'min_range' => 1
                ]
            ],
            "ID_NASLOV2" => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => [
                    'min_range' => 1
                ]
            ]
        ]);
        
        if($data["id_drzava"] == 705) {
            $data = $data + filter_input_array(INPUT_POST, [
                "id_posta" => [
                    'filter' => FILTER_VALIDATE_INT,
                    'options' => [
                        'min_range' => 1
                    ]
                ],
                "id_obcina" => [
                    'filter' => FILTER_VALIDATE_INT,
                    'options' => [
                        'min_range' => 1
                    ]
                ]
            ]);
        }
        $data["ID_STUD_LETO"] = KandidatModel::getZetonPodatki(User::getID())['ID_STUD_LETO'];
        if (Validation::checkValues($data)) {
            $data = $data + filter_input_array(INPUT_POST, [
                "id_drzava2" => [
                    'filter' => FILTER_VALIDATE_INT,
                    'options' => [
                        'min_range' => 1
                    ]
                ],
                "ulica2" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
            ]);
            if($data["id_drzava2"] == 705) {
                $data = $data + filter_input_array(INPUT_POST, [
                    "id_posta2" => [
                        'filter' => FILTER_VALIDATE_INT,
                        'options' => [
                            'min_range' => 1
                        ]
                    ],
                    "id_obcina2" => [
                        'filter' => FILTER_VALIDATE_INT,
                        'options' => [
                            'min_range' => 1
                        ]
                    ]
                ]);
            }

            if (Validation::verifyDatumRojstvaInEMSO($data["DATUM_ROJSTVA"], $data["emso"])) {
                if (Validation::verifyEMSO($data["emso"])) {
                    if (($data["id_drzava"] != 705 &&
                    (isset($data["id_posta"]) ? $data["id_posta"] : NULL)==NULL &&
                    (isset($data["id_obcina"]) ? $data["id_obcina"] : NULL)==NULL) 
                    || ObcinaModel::isMatchPostaObcina((isset($data["id_posta"]) ? $data["id_posta"] : NULL), (isset($data["id_obcina"]) ? $data["id_obcina"] : NULL))) {
                        if (($data["id_drzava2"] != 705 &&
                        (isset($data["id_posta2"]) ? $data["id_posta2"] : NULL)==NULL &&
                        (isset($data["id_obcina2"]) ? $data["id_obcina2"] : NULL)==NULL) 
                        || ObcinaModel::isMatchPostaObcina((isset($data["id_posta2"]) ? $data["id_posta2"] : NULL), (isset($data["id_obcina2"]) ? $data["id_obcina2"] : NULL))) {
                            if (isset($_POST["StrIzbPredmeti"]) && isset($_POST["SplIzbPredmeti"]) && count($_POST["StrIzbPredmeti"])==1) {
                                $sum = 0;
                                foreach ($_POST["SplIzbPredmeti"] as $key => $value) {
                                    $sum = $sum + (int)PredmetModel::get($value)["ST_KREDITNIH_TOCK"];
                                }
                                if ($sum == 6) {
                                    KandidatModel::updateOsebaEmsoInTelefon(User::getId(), $data["emso"], $data["telefonska_stevilka"], $data["DATUM_ROJSTVA"]);
                                    
                                    KandidatModel::updateNaslov($data["ID_NASLOV1"], [
                                        "id_drzava" => $data["id_drzava"],
                                        "ulica" => $data["ulica"],
                                        "id_posta" => (isset($data["id_posta"]) ? $data["id_posta"] : NULL),
                                        "id_obcina" => (isset($data["id_obcina"]) ? $data["id_obcina"] : NULL),
                                        "je_zavrocanje" => ($data["naslovZaVrocanje"]=="stalni" ? 1 : 0)
                                    ]);
                                    
                                    KandidatModel::updateNaslov($data["ID_NASLOV2"], [
                                        "id_drzava" => (isset($data["id_drzava2"]) ? $data["id_drzava2"] : NULL),
                                        "ulica" => (isset($data["ulica2"]) ? $data["ulica2"] : NULL),
                                        "id_posta" => (isset($data["id_posta2"]) ? $data["id_posta2"] : NULL),
                                        "id_obcina" => (isset($data["id_obcina2"]) ? $data["id_obcina2"] : NULL),
                                        "je_zavrocanje" => ($data["naslovZaVrocanje"]=="zacasni" ? 1 : 0)
                                    ]);
                                    
                                    $zeton = StudentModel::getLastNeIzkoriscenZeton(User::getId());
                                    StudentModel::setZetonToIzkoriscen($zeton["ID_ZETON"]);
                                    $VPISNA_STEVILKA = KandidatModel::getVpisnaStevilkaWithOsebaId(User::getId());
                                    KandidatModel::potrdiVpisStudent($VPISNA_STEVILKA, $zeton);
                                    
                                    $KandidatPodatki = KandidatModel::getStudentPodatki(User::getId());
                                    #$praviPodatki = KandidatModel::getZetonPodatki(User::getId());
                                    $ObvPredmeti = PredmetModel::getAllByType([
                                        "ID_STUD_LETO" => $KandidatPodatki["id_stud_leto"],
                                        "ID_PROGRAM" => $KandidatPodatki["id_program"],
                                        "ID_LETNIK" => 2,
                                        "TIP" => 'o'
                                    ]);
                                    
                                    KandidatModel::insertPredmetiKandidat($VPISNA_STEVILKA, $ObvPredmeti, $data["ID_STUD_LETO"]);
                                    if (isset($_POST["StrIzbPredmeti"])) {
                                        $StrIzbPredmeti = array();
                                        foreach ($_POST["StrIzbPredmeti"] as $key => $value) {
                                            $StrIzbPredmeti[] = PredmetModel::get($value);
                                        }
                                        // echo '<pre>' . var_export($StrIzbPredmeti, true) . '</pre>';
                                        KandidatModel::insertPredmetiKandidat($VPISNA_STEVILKA, $StrIzbPredmeti, $data["ID_STUD_LETO"]);
                                    }
                                    if (isset($_POST["SplIzbPredmeti"])) {
                                        $SplIzbPredmeti = array();
                                        foreach ($_POST["SplIzbPredmeti"] as $key => $value) {
                                            $SplIzbPredmeti[] = PredmetModel::get($value);
                                        }
                                        // echo '<pre>' . var_export($SplIzbPredmeti, true) . '</pre>';
                                        KandidatModel::insertPredmetiKandidat($VPISNA_STEVILKA, $SplIzbPredmeti, $data["ID_STUD_LETO"]);
                                    }

                                    ViewHelper::render("view/VpisniListPDFViewer.php", [
                                        "vloga"=> "student",
                                        "id"=> User::getId(),
                                        "status" => "Success",
                                        "message" => "Vpisni list ste uspešno oddali. Prosim počakajte potrditev referenta."
                                    ]);
                                } else {
                                    self::vpis2LForm("Failure", "Napaka! Potrebna je izbira 6 KT splošnih izbirnih predmetov in 6KT strokovnih izbirnih predmetov. Poskusite znova.");
                                }
                            } else {
                                self::vpis2LForm("Failure", "Napaka! Potrebna je izbira 6 KT splošnih izbirnih predmetov in 6KT strokovnih izbirnih predmetov. Poskusite znova.");
                            }
                        } else {
                            self::vpis2LForm("Failure", "Napaka! Pošta in občina pri začasnem naslovu se ne ujemata. Poskusite znova.");
                        }
                    } else {
                        self::vpis2LForm("Failure", "Napaka! Pošta in občina pri stalnem naslovu se ne ujemata. Poskusite znova.");
                    }
                } else {
                    self::vpis2LForm("Failure", "Napaka! EMŠO ni veljaven. Poskusite znova.");
                }
            } else {
                self::vpis2LForm("Failure", "Napaka, datum rojstva in emso st. se ne ujemata. Poskusite znova.");
            }
        } else {
            self::vpis2LForm("Failure", "Napaka! Vnos ni veljaven. Poskusite znova.");
        }
    }
    
    public static function vpis3L1($status = null, $message = null) {
        $data = filter_input_array(INPUT_POST, [
            "emso" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "DATUM_ROJSTVA" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "telefonska_stevilka" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "naslovZaVrocanje" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "id_drzava" => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => [
                    'min_range' => 1
                ]
            ],

            "ulica" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "ID_NASLOV1" => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => [
                    'min_range' => 1
                ]
            ],
            "ID_NASLOV2" => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => [
                    'min_range' => 1
                ]
            ]
        ]);
        if($data["id_drzava"] == 705) {
            $data = $data + filter_input_array(INPUT_POST, [
                "id_posta" => [
                    'filter' => FILTER_VALIDATE_INT,
                    'options' => [
                        'min_range' => 1
                    ]
                ],
                "id_obcina" => [
                    'filter' => FILTER_VALIDATE_INT,
                    'options' => [
                        'min_range' => 1
                    ]
                ]
            ]);
        }
        $data["ID_STUD_LETO"] = KandidatModel::getZetonPodatki(User::getID())['ID_STUD_LETO'];
        if (Validation::checkValues($data)) {
            $data = $data + filter_input_array(INPUT_POST, [
                "id_drzava2" => [
                    'filter' => FILTER_VALIDATE_INT,
                    'options' => [
                        'min_range' => 1
                    ]
                ],
                "ulica2" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
            ]);
            if($data["id_drzava2"] == 705) {
                $data = $data + filter_input_array(INPUT_POST, [
                    "id_posta2" => [
                        'filter' => FILTER_VALIDATE_INT,
                        'options' => [
                            'min_range' => 1
                        ]
                    ],
                    "id_obcina2" => [
                        'filter' => FILTER_VALIDATE_INT,
                        'options' => [
                            'min_range' => 1
                        ]
                    ]
                ]);
            }

            if (Validation::verifyDatumRojstvaInEMSO($data["DATUM_ROJSTVA"], $data["emso"])) {
                if (Validation::verifyEMSO($data["emso"])) {
                    if (($data["id_drzava"] != 705 &&
                    (isset($data["id_posta"]) ? $data["id_posta"] : NULL)==NULL &&
                    (isset($data["id_obcina"]) ? $data["id_obcina"] : NULL)==NULL) 
                    || ObcinaModel::isMatchPostaObcina((isset($data["id_posta"]) ? $data["id_posta"] : NULL), (isset($data["id_obcina"]) ? $data["id_obcina"] : NULL))) {
                        if (($data["id_drzava2"] != 705 &&
                        (isset($data["id_posta2"]) ? $data["id_posta2"] : NULL)==NULL &&
                        (isset($data["id_obcina2"]) ? $data["id_obcina2"] : NULL)==NULL) 
                        || ObcinaModel::isMatchPostaObcina((isset($data["id_posta2"]) ? $data["id_posta2"] : NULL), (isset($data["id_obcina2"]) ? $data["id_obcina2"] : NULL))) {
                            if (isset($_POST["IzbModulov"]) && isset($_POST["SplIzbPredmeti"]) && count($_POST["IzbModulov"])==2) {
                                $sum = 0;
                                foreach ($_POST["SplIzbPredmeti"] as $key => $value) {
                                    $sum = $sum + (int)PredmetModel::get($value)["ST_KREDITNIH_TOCK"];
                                }
                                if ($sum == 6) {
                                    KandidatModel::updateOsebaEmsoInTelefon(User::getId(), $data["emso"], $data["telefonska_stevilka"], $data["DATUM_ROJSTVA"]);
                                    
                                    KandidatModel::updateNaslov($data["ID_NASLOV1"], [
                                        "id_drzava" => $data["id_drzava"],
                                        "ulica" => $data["ulica"],
                                        "id_posta" => (isset($data["id_posta"]) ? $data["id_posta"] : NULL),
                                        "id_obcina" => (isset($data["id_obcina"]) ? $data["id_obcina"] : NULL),
                                        "je_zavrocanje" => ($data["naslovZaVrocanje"]=="stalni" ? 1 : 0)
                                    ]);
                                    
                                    KandidatModel::updateNaslov($data["ID_NASLOV2"], [
                                        "id_drzava" => (isset($data["id_drzava2"]) ? $data["id_drzava2"] : NULL),
                                        "ulica" => (isset($data["ulica2"]) ? $data["ulica2"] : NULL),
                                        "id_posta" => (isset($data["id_posta2"]) ? $data["id_posta2"] : NULL),
                                        "id_obcina" => (isset($data["id_obcina2"]) ? $data["id_obcina2"] : NULL),
                                        "je_zavrocanje" => ($data["naslovZaVrocanje"]=="zacasni" ? 1 : 0)
                                    ]);
                                    
                                    $zeton = StudentModel::getLastNeIzkoriscenZeton(User::getId());
                                    StudentModel::setZetonToIzkoriscen($zeton["ID_ZETON"]);
                                    $VPISNA_STEVILKA = KandidatModel::getVpisnaStevilkaWithOsebaId(User::getId());
                                    KandidatModel::potrdiVpisStudent($VPISNA_STEVILKA, $zeton);
                                    
                                    $KandidatPodatki = KandidatModel::getStudentPodatki(User::getId());
                                    $ObvPredmeti = PredmetModel::getAllByType([
                                        "ID_STUD_LETO" => $KandidatPodatki["id_stud_leto"],
                                        "ID_PROGRAM" => $KandidatPodatki["id_program"],
                                        "ID_LETNIK" => 3,
                                        "TIP" => 'o'
                                    ]);
                                    
                                    KandidatModel::insertPredmetiKandidat($VPISNA_STEVILKA, $ObvPredmeti, $data["ID_STUD_LETO"]);
                                    if (isset($_POST["IzbModulov"])) {
                                        foreach ($_POST["IzbModulov"] as $key => $value) {
                                            $IzbModulov = DelPredmetnikaModel::getSubjects($value);
                                            KandidatModel::insertPredmetiKandidat($VPISNA_STEVILKA, $IzbModulov, $data["ID_STUD_LETO"]);
                                            //echo '<pre>' . var_export($IzbModulov, true) . '</pre>';
                                        }
                                    }
                                    if (isset($_POST["SplIzbPredmeti"])) {
                                        $SplIzbPredmeti = array();
                                        foreach ($_POST["SplIzbPredmeti"] as $key => $value) {
                                            $SplIzbPredmeti[] = PredmetModel::get($value);
                                        }
                                        // echo '<pre>' . var_export($SplIzbPredmeti, true) . '</pre>';
                                        KandidatModel::insertPredmetiKandidat($VPISNA_STEVILKA, $SplIzbPredmeti, $data["ID_STUD_LETO"]);
                                    }

                                    ViewHelper::render("view/VpisniListPDFViewer.php", [
                                        "vloga"=> "student",
                                        "id"=> User::getId(),
                                        "status" => "Success",
                                        "message" => "Vpisni list ste uspešno oddali. Prosim počakajte potrditev referenta."
                                    ]);
                                } else {
                                    self::vpis3L1Form("Failure", "Napaka, potrebna je izbira 2 modulov in za 6KT splošnih izbirnih predmetov. Poskusite znova.");
                                }
                            } else {
                                self::vpis3L1Form("Failure", "Napaka, potrebna je izbira 2 modulov in za 6KT splošnih izbirnih predmetov. Poskusite znova.");
                            }
                        } else {
                            self::vpis3L1Form("Failure", "Napaka! Pošta in občina pri začasnem naslovu se ne ujemata. Poskusite znova.");
                        }
                    } else {
                        self::vpis3L1Form("Failure", "Napaka! Pošta in občina pri stalnem naslovu se ne ujemata. Poskusite znova.");
                    }
                } else {
                    self::vpis3L1Form("Failure", "Napaka! EMŠO ni veljaven. Poskusite znova.");
                }
            } else {
                self::vpis3L1Form("Failure", "Napaka, datum rojstva in emso st. se ne ujemata. Poskusite znova.");
            }
        } else {
            self::vpis3L1Form("Failure", "Napaka! Vnos ni veljaven. Poskusite znova.");
        }
    }
    
    public static function vpis3L2($status = null, $message = null) {
        $data = filter_input_array(INPUT_POST, [
            "emso" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "DATUM_ROJSTVA" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "telefonska_stevilka" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "naslovZaVrocanje" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "id_drzava" => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => [
                    'min_range' => 1
                ]
            ],
            "ulica" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "ID_NASLOV1" => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => [
                    'min_range' => 1
                ]
            ],
            "ID_NASLOV2" => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => [
                    'min_range' => 1
                ]
            ]
        ]);
        $data["ID_STUD_LETO"] = KandidatModel::getZetonPodatki(User::getID())['ID_STUD_LETO'];
        if($data["id_drzava"] == 705) {
            $data = $data + filter_input_array(INPUT_POST, [
                "id_posta" => [
                    'filter' => FILTER_VALIDATE_INT,
                    'options' => [
                        'min_range' => 1
                    ]
                ],
                "id_obcina" => [
                    'filter' => FILTER_VALIDATE_INT,
                    'options' => [
                        'min_range' => 1
                    ]
                ]
            ]);
        }
        
        if (Validation::checkValues($data)) {
            $data = $data + filter_input_array(INPUT_POST, [
                "id_drzava2" => [
                    'filter' => FILTER_VALIDATE_INT,
                    'options' => [
                        'min_range' => 1
                    ]
                ],
                "ulica2" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
            ]);
            if($data["id_drzava2"] == 705) {
                $data = $data + filter_input_array(INPUT_POST, [
                    "id_posta2" => [
                        'filter' => FILTER_VALIDATE_INT,
                        'options' => [
                            'min_range' => 1
                        ]
                    ],
                    "id_obcina2" => [
                        'filter' => FILTER_VALIDATE_INT,
                        'options' => [
                            'min_range' => 1
                        ]
                    ]
                ]);
            }
            
            if (Validation::verifyDatumRojstvaInEMSO($data["DATUM_ROJSTVA"], $data["emso"])) {
                if (Validation::verifyEMSO($data["emso"])) {
                    if (($data["id_drzava"] != 705 &&
                    (isset($data["id_posta"]) ? $data["id_posta"] : NULL)==NULL &&
                    (isset($data["id_obcina"]) ? $data["id_obcina"] : NULL)==NULL) 
                    || ObcinaModel::isMatchPostaObcina((isset($data["id_posta"]) ? $data["id_posta"] : NULL), (isset($data["id_obcina"]) ? $data["id_obcina"] : NULL))) {
                        if (($data["id_drzava2"] != 705 &&
                        (isset($data["id_posta2"]) ? $data["id_posta2"] : NULL)==NULL &&
                        (isset($data["id_obcina2"]) ? $data["id_obcina2"] : NULL)==NULL) 
                        || ObcinaModel::isMatchPostaObcina((isset($data["id_posta2"]) ? $data["id_posta2"] : NULL), (isset($data["id_obcina2"]) ? $data["id_obcina2"] : NULL))) {
                            $ModIzbPredmeti = 0;
                            if (isset($_POST["ModIzbPredmeti"])) {
                                foreach ($_POST["ModIzbPredmeti"] as $key => $value) {
                                    $ModIzbPredmeti = $ModIzbPredmeti + (int)PredmetModel::get($value)["ST_KREDITNIH_TOCK"];
                                }
                            }
                            $SplIzbPredmetiSum = 0;
                            if (isset($_POST["SplIzbPredmeti"])) {
                                foreach ($_POST["SplIzbPredmeti"] as $key => $value) {
                                    $SplIzbPredmetiSum = $SplIzbPredmetiSum + (int)PredmetModel::get($value)["ST_KREDITNIH_TOCK"];
                                }
                            }
                            if ($ModIzbPredmeti == 42 && $SplIzbPredmetiSum == 0 || $ModIzbPredmeti == 36 && $SplIzbPredmetiSum == 6) {
                                KandidatModel::updateOsebaEmsoInTelefon(User::getId(), $data["emso"], $data["telefonska_stevilka"], $data["DATUM_ROJSTVA"]);
                                
                                KandidatModel::updateNaslov($data["ID_NASLOV1"], [
                                    "id_drzava" => $data["id_drzava"],
                                    "ulica" => $data["ulica"],
                                    "id_posta" => (isset($data["id_posta"]) ? $data["id_posta"] : NULL),
                                    "id_obcina" => (isset($data["id_obcina"]) ? $data["id_obcina"] : NULL),
                                    "je_zavrocanje" => ($data["naslovZaVrocanje"]=="stalni" ? 1 : 0)
                                ]);
                                
                                KandidatModel::updateNaslov($data["ID_NASLOV2"], [
                                    "id_drzava" => (isset($data["id_drzava2"]) ? $data["id_drzava2"] : NULL),
                                    "ulica" => (isset($data["ulica2"]) ? $data["ulica2"] : NULL),
                                    "id_posta" => (isset($data["id_posta2"]) ? $data["id_posta2"] : NULL),
                                    "id_obcina" => (isset($data["id_obcina2"]) ? $data["id_obcina2"] : NULL),
                                    "je_zavrocanje" => ($data["naslovZaVrocanje"]=="zacasni" ? 1 : 0)
                                ]);
                                
                                $zeton = StudentModel::getLastNeIzkoriscenZeton(User::getId());
                                StudentModel::setZetonToIzkoriscen($zeton["ID_ZETON"]);
                                //echo '<pre>' . var_export($zeton, true) . '</pre>';
                                $VPISNA_STEVILKA = KandidatModel::getVpisnaStevilkaWithOsebaId(User::getId());
                                KandidatModel::potrdiVpisStudent($VPISNA_STEVILKA, $zeton);
                                
                                $KandidatPodatki = KandidatModel::getStudentPodatki(User::getId());
                                $ObvPredmeti = PredmetModel::getAllByType([
                                    "ID_STUD_LETO" => $KandidatPodatki["id_stud_leto"],
                                    "ID_PROGRAM" => $KandidatPodatki["id_program"],
                                    "ID_LETNIK" => 3,
                                    "TIP" => 'o'
                                ]);
                                
                                KandidatModel::insertPredmetiKandidat($VPISNA_STEVILKA, $ObvPredmeti, $data["ID_STUD_LETO"]);
                                if (isset($_POST["ModIzbPredmeti"])) {
                                    $ModIzbPredmeti = array();
                                    foreach ($_POST["ModIzbPredmeti"] as $key => $value) {
                                        $ModIzbPredmeti[] = PredmetModel::get($value);
                                    }
                                    // echo '<pre>' . var_export($ModIzbPredmeti, true) . '</pre>';
                                    KandidatModel::insertPredmetiKandidat($VPISNA_STEVILKA, $ModIzbPredmeti, $data["ID_STUD_LETO"]);
                                }
                                if (isset($_POST["SplIzbPredmeti"])) {
                                    $SplIzbPredmeti = array();
                                    foreach ($_POST["SplIzbPredmeti"] as $key => $value) {
                                        $SplIzbPredmeti[] = PredmetModel::get($value);
                                    }
                                    // echo '<pre>' . var_export($SplIzbPredmeti, true) . '</pre>';
                                    KandidatModel::insertPredmetiKandidat($VPISNA_STEVILKA, $SplIzbPredmeti, $data["ID_STUD_LETO"]);
                                }

                                ViewHelper::render("view/VpisniListPDFViewer.php", [
                                    "vloga"=> "student",
                                    "id"=> User::getId(),
                                    "status" => "Success",
                                    "message" => "Vpisni list ste uspešno oddali. Prosim počakajte potrditev referenta."
                                ]);
                            } else {
                                self::vpis3L2Form("Failure", "Napaka! Potrebna je izbira natančno 42KT, od katerih je 42KT modulskih ali 36KT modulskih in 6KT splošnih izbirnih. Poskusite znova.");
                            }
                        } else {
                            self::vpis3L2Form("Failure", "Napaka! Pošta in občina pri začasnem naslovu se ne ujemata. Poskusite znova.");
                        }
                    } else {
                        self::vpis3L2Form("Failure", "Napaka! Pošta in občina pri stalnem naslovu se ne ujemata. Poskusite znova.");
                    }
                } else {
                    self::vpis3L2Form("Failure", "Napaka! EMŠO ni veljaven. Poskusite znova.");
                }
            } else {
                self::vpis3L2Form("Failure", "Napaka, datum rojstva in emso st. se ne ujemata. Poskusite znova.");
            }
        } else {
            self::vpis3L2Form("Failure", "Napaka! Vnos ni veljaven. Poskusite znova.");
        }
    }

    public static function elektronskiIndeksForm() {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsStudent()){
                ViewHelper::render("view/ElektronskiIndeks.php", []);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }
    
    public static function PregledIzpitovStudentForm() {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsStudent()){
                ViewHelper::render("view/PregledIzpitovStudent.php", []);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function exportPDF($id){
        $studentId = KandidatModel::getKandidatIdWithUserId($id);
        $studData = KandidatModel::getKandidatPodatki($studentId);
        $emso=DataForExportModel::getEmso($studentId);
        //Osebni podatki
        $header = array('Priimek, ime', 'Vpisna številka', 'Email', 'EMŠO','Datum Rojstva');
        $priimekIme=$studData['priimek'].', '.$studData['ime'];
        $studLetoVpisna=DataForExportModel::getStudijskoLetoAndVpisna($studentId);

        // TODO
        //Naslov za vrocanje in stalni naslov
        $drzava=NULL;
        $naslove=KandidatModel::getOsebaVseNaslove($studentId);
        foreach ($naslove as $key => $value) {
            if ($value['JE_STALNI'] == 1) {
                $gDrzava=NasloveData::getDrzava($value["ID_DRZAVA"]);
                $drzava=$gDrzava[0]["SLOVENSKINAZIV"];;
            }
        }

        $lineData = array($priimekIme,$studLetoVpisna['VPISNA_STEVILKA'], $studData['email'], $emso['EMSO'], $studData['DATUM_ROJSTVA']);
        //Podatki o vpisu
       // $vpisData=DataForExportModel::getVpisPodatki($studentId);
        $vpisData=DataForExportModel::getVpisPodatkeeee($studLetoVpisna["ID_STUD_LETO"],$studLetoVpisna['VPISNA_STEVILKA']);
        $header2=array('Štidijski program','Študijsko leto','Nacin študija','Obliika študija','Vrsta vpisa','Letnik');
        $lineData2=array($vpisData['naziv_program'],$studLetoVpisna['STUD_LETO'],$vpisData['OPIS_NACIN'],$vpisData['NAZIV_OBLIKA'],$vpisData['OPIS_VPISA'],$vpisData['ID_LETNIK']);


        $pdf= new tFPDF();
        $pdf->AddPage();
        $pdf->AddFont('DejaVu','','DejaVuSans.ttf',true);

        $pdf->Image('./static/images/logo-ul.jpg', 8, 8, 20, 20, 'JPG');
        $pdf->SetFont('DejaVu','',15);
        $pdf->Cell(200,10,'Univerza v Ljubjani, Fakulteta za računalništvo in informatiko ',0,0,'C');
        $pdf->Ln();
        $tDate=date("Y-m-d");
        $sloDate=ProfessorController::formatDateSlo($tDate);
        $pdf->Cell(0, 10, 'Datum izdaje : '.$sloDate, 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $pdf->Ln();
        $pdf->Ln();

        $pdf->SetFont('DejaVu','',25);
        $pdf->Cell(200,30,'POTRDILO O VPISU ',0,0,'C');
        $pdf->Ln();
        $pdf->SetFont('DejaVu','',10);
        $pdf->BasicTablePotrdilo($header,$lineData);
        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetFont('DejaVu','',10);
        $pdf->BasicTablePotrdilo($header2,$lineData2);
        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetY(265);
        $pdf->Cell(0, 10, 'Stran '.$pdf->PageNo().'/'.$pdf->PageNo(), 0, false, 'C', 0, '', 0, false, 'T', 'M');

        $pdf->Output();

        $filename="data.pdf";
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
    }

    public static function exportPDF6($id){
        $studentId = KandidatModel::getKandidatIdWithUserId($id);
        $studData = KandidatModel::getKandidatPodatki($studentId);
        $emso=DataForExportModel::getEmso($studentId);
        //Osebni podatki
        $header = array('Priimek, ime', 'Vpisna številka', 'Email', 'EMŠO','Datum rojstva');
        $priimekIme=$studData['priimek'].', '.$studData['ime'];
        $studLetoVpisna=DataForExportModel::getStudijskoLetoAndVpisna($studentId);

        // TODO
        //Naslov za vrocanje in stalni naslov
        $drzava=NULL;
        $naslove=KandidatModel::getOsebaVseNaslove($studentId);
        foreach ($naslove as $key => $value) {
            if ($value['JE_STALNI'] == 1) {
                $gDrzava=NasloveData::getDrzava($value["ID_DRZAVA"]);
                $drzava=$gDrzava[0]["SLOVENSKINAZIV"];;
            }
        }

        $lineData = array($priimekIme,$studLetoVpisna['VPISNA_STEVILKA'], $studData['email'], $emso['EMSO'], $studData['DATUM_ROJSTVA']);
        //Podatki o vpisu
        $vpisData=DataForExportModel::getVpisPodatkeeee($studLetoVpisna["ID_STUD_LETO"],$studLetoVpisna['VPISNA_STEVILKA']);
        $header2=array('Štidijski program','Študijsko leto','Nacin študija','Obliika študija','Vrsta vpisa','Letnik');
        $lineData2=array($vpisData['naziv_program'],$studLetoVpisna['STUD_LETO'],$vpisData['OPIS_NACIN'],$vpisData['NAZIV_OBLIKA'],$vpisData['OPIS_VPISA'],$vpisData['ID_LETNIK']);


        $pdf= new tFPDF();
        for($i=0;$i<6;$i++){
            $pdf->AddPage();
            $pdf->AddFont('DejaVu','','DejaVuSans.ttf',true);

            $pdf->Image('./static/images/logo-ul.jpg', 8, 8, 20, 20, 'JPG');
            $pdf->SetFont('DejaVu','',15);
            $pdf->Cell(200,10,'Univerza v Ljubjani, Fakulteta za računalništvo in informatiko ',0,0,'C');
            $pdf->Ln();
            $tDate=date("Y-m-d");
            $sloDate=ProfessorController::formatDateSlo($tDate);
            $pdf->Cell(0, 10, 'Datum izdaje : '.$sloDate, 0, false, 'C', 0, '', 0, false, 'T', 'M');
            $pdf->Ln();
            $pdf->Ln();

            $pdf->SetFont('DejaVu','',25);
            $pdf->Cell(200,30,'POTRDILO O VPISU ',0,0,'C');
            $pdf->Ln();
            $pdf->SetFont('DejaVu','',10);
            $pdf->BasicTablePotrdilo($header,$lineData);
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetFont('DejaVu','',10);
            $pdf->BasicTablePotrdilo($header2,$lineData2);
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetX(180);
            $pdf->SetY(265);
            $pdf->AliasNbPages('{totalPages}');
            $pdf->Cell(0, 10, 'Stran '.$pdf->PageNo(). "/{totalPages}", 0, false, 'C', 0, '', 0, false, 'T', 'M');

        }


        $pdf->Output();

        $filename="data.pdf";
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
    }

    public static function izpitniRokForm($status = null, $message = null) {



        $IdYear = StudijskoLetoModel::getIdOfYear(CURRENT_YEAR);
        if (User::isLoggedIn()){
            if (User::isLoggedInAsStudent()){
                $IdYear = StudijskoLetoModel::getIdOfYear(CURRENT_YEAR);
                $roki = RokModel::getAllByEnrolledStudent(User::getId(), $IdYear["ID_STUD_LETO"]);
                $vpisna=PrijavaModel::getVpisna(User::getId1());

                $zapPolaganj=PrijavaModel::getZapStPolaganj($vpisna["VPISNA_STEVILKA"]);
                //var_dump($roki);
                if (empty($roki)) {
                    $status = "Info";
                    $message = "Trenutno ni razpisanih izpitnih rokov.";
                }
                ViewHelper::render("view/IzpitniRokStudent.php", [
                    "pageTitle" => "Seznam vseh rokov",
                    "roki" => $roki,
                    "formAction" => "izpitniRok/student/",
                    "status" => $status,
                    "message" => $message,
                    "zapPolaganj" => $zapPolaganj
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }


    public static function prijavaNaIzpitu(){
        $data1 = filter_input_array(INPUT_POST, [
            "rokId" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);

        if (User::isLoggedIn()){
            if (User::isLoggedInAsStudent()){
                $IdYear = StudijskoLetoModel::getIdOfYear(CURRENT_YEAR);
                $id_predmet = PrijavaModel::getIzpitniRok($IdYear["ID_STUD_LETO"],$data1["rokId"]);
                $vpisna=PrijavaModel::getVpisna(User::getId1());
                PrijavaModel::prijavaAdd($vpisna["VPISNA_STEVILKA"], $data1["rokId"],$id_predmet["ID_PREDMET"]);

                ViewHelper::redirect(BASE_URL . "izpitniRok/student");
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function dozvoliPrijava($roki, $id_rok){

        $trenutniRok = null;

        // Najdi trenutni rok, in ga shrani
        foreach ($roki as $key => $value){
            if($value["ID_ROK"] === $id_rok) {
                $trenutniRok = $value;
                break;
            }
        }


        // Obstaja prijava na trenutni rok, ni se ocene ali je ocena negativna
        if(isset($trenutniRok["ID_PRIJAVA"]) && $trenutniRok["OCENA_IZPITA"] < 6){
            return $trenutniRok["ID_ROK"];
        }

        // Ni prijave na trenutni rok
            // --> Sploh ni prijav na ta predmet
            // --> Obstaja kasnejsa prijava brez ocene
            // --> Obstaja prijava z oceno
        if(!isset($trenutniRok["ID_PRIJAVA"]) && $trenutniRok["OCENA_IZPITA"] < 6){

            if(self::obstajajoPrijave($roki, $trenutniRok["ID_ROK"], $trenutniRok["ID_PREDMET"])){

                if(isset($trenutniRok["OCENA_IZPITA"]) && $trenutniRok["OCENA_IZPITA"] < 6) return 0;
                elseif(!isset($trenutniRok["OCENA_IZPITA"])) return self::najdiIdRoka($roki, $trenutniRok["ID_ROK"], $trenutniRok["ID_PREDMET"]);     // Fail - SHOW ALL
                else return -1;                             // Pass - HIDE ALL
            } else {
                return 0;
            }
        }
        if($trenutniRok["OCENA_IZPITA"] > 5) return -1;

        return -2;          // ERROR
    }

    // Returns ID_ROK, ce obstaja prijava brez ocene
    // Returns -1, ce ne obstaja prijave brez ocene
    public static function najdiIdRoka($rokiTab, $id_rok, $id_predmet){

        foreach($rokiTab as $key => $value){
            if($value["ID_PREDMET"] == $id_predmet && $value["ID_ROK"] != $id_rok){     // Najdi rok tega predmeta
                if(isset($value["ID_PRIJAVA"])){            // Ali obstaja prijava?
                    return $value["ID_ROK"];
                }
            }
        }
        return 0;
    }



    public static function dozvoliPrijava2($roki, $id_rok){
        //var_dump($id_rok);
        //var_dump($roki);

        $trenutniRok = null;

        // Najdi trenutni rok, in ga shrani
        foreach ($roki as $key => $value){
            if($value["ID_ROK"] === $id_rok) {
                $trenutniRok = $value;
                break;
            }
        }

        //var_dump($trenutniRok);
        // Obstaja prijava na trenutni rok, ni se ocene
        if(isset($trenutniRok["ID_PRIJAVA"]) && !isset($trenutniRok["OCENA_IZPITA"])){

            return $trenutniRok["ID_ROK"];
        }


        // Ni prijave na trenutni rok
            // --> Sploh ni prijav na ta predmet
            // --> Obstaja kasnejsa prijava brez ocene
            // --> Obstaja prijava z oceno
        if(!isset($trenutniRok["ID_PRIJAVA"]) && !isset($trenutniRok["OCENA_IZPITA"])){

            if(self::obstajajoPrijave($roki, $trenutniRok["ID_ROK"], $trenutniRok["ID_PREDMET"])){

                $prijavaBrezOcene = self::findPrijavaBrezOcene($roki, $trenutniRok["ID_ROK"], $trenutniRok["ID_PREDMET"]);
               // var_dump($prijavaBrezOcene);
                if($prijavaBrezOcene > 0){
                    return $prijavaBrezOcene;           // ID_ROKA je shranjen v $prijavaBrezOcene
                }

                // Prijava brez ocene NE obstaja --> Mora obstajati prijava z oceno
                $ocenaPrijaveZOceno = self::findPrijavaZOceno($roki, $trenutniRok["ID_ROK"], $trenutniRok["ID_PREDMET"]);

                //var_dump($ocenaPrijaveZOceno);
                if($ocenaPrijaveZOceno > 5) return -1;
                if($ocenaPrijaveZOceno < 6) return 0;
            } else {
                return 0;           // Sploh ni prijav na ta predmet
            }
        }

        if($trenutniRok["OCENA_IZPITA"] > 5) return -1;
        if($trenutniRok["OCENA_IZPITA"] < 6) return 0;
        return -2;          // ERROR
    }

    // Returns ID_ROK, ce obstaja prijava brez ocene
    // Returns -1, ce ne obstaja prijave brez ocene
    public static function findPrijavaZOceno($rokiTab, $id_rok, $id_predmet){

        $maxIdPrijava = 0;
        $maxOcena = 0;

        //var_dump("benetj");
        foreach($rokiTab as $key => $value){
            if($value["ID_PREDMET"] == $id_predmet && $value["ID_ROK"] != $id_rok){     // Najdi rok tega predmeta
                //var_dump($value["DATUM_ODJAVE"]);
                if(isset($value["ID_PRIJAVA"]) && isset($value["OCENA_IZPITA"]) && !isset($value["DATUM_ODJAVE"])){            // Ali obstaja prijava?

                    if($maxOcena < $value["OCENA_IZPITA"]){
                        $maxOcena=$value["OCENA_IZPITA"];
                    }
                }
            }
        }
        //var_dump($maxIdPrijava);
        //var_dump($maxOcena);
        return $maxOcena;
    }

    // Returns ID_ROK, ce obstaja prijava brez ocene
    // Returns -1, ce ne obstaja prijave brez ocene
    public static function findPrijavaBrezOcene($rokiTab, $id_rok, $id_predmet){

        foreach($rokiTab as $key => $value){
            if($value["ID_PREDMET"] == $id_predmet && $value["ID_ROK"] != $id_rok && !isset($value["DATUM_ODJAVE"])){     // Najdi rok tega predmeta
                if(isset($value["ID_PRIJAVA"]) && !isset($value["OCENA_IZPITA"])){            // Ali obstaja prijava?
                    return $value["ID_ROK"];
                }
            }
        }
        return 0;
    }

    public static function obstajajoPrijave($rokiTab, $id_rok, $id_predmet){

        foreach($rokiTab as $key => $value){
            if($value["ID_PREDMET"] == $id_predmet && $value["ID_ROK"] != $id_rok){     // Najdi rok tega predmeta
                if(isset($value["ID_PRIJAVA"])){            // Ali obstaja prijava?
                    return true;
                }
            }
        }
        return false;
    }


    public static function zapSteviloPrijavLetos($id_rok){
        $vpisna=PrijavaModel::getVpisna(User::getId1());
        $studLetoPredmet=PrijavaModel::getStudLetoPredmetRok($id_rok);

        $vpisnaSt=$vpisna["VPISNA_STEVILKA"];
        $leto=$studLetoPredmet["ID_STUD_LETO"];
        $predmet=$studLetoPredmet["ID_PREDMET"];


        $countPrijav=PrijavaModel::countZapPrijavLetos($vpisnaSt,$leto,$predmet);
        return $countPrijav;
    }

    public static function zapSteviloPrijavLetosProf($id_rok,$vpisna){

        $studLetoPredmet=PrijavaModel::getStudLetoPredmetRok($id_rok);


        $leto=$studLetoPredmet["ID_STUD_LETO"];
        $predmet=$studLetoPredmet["ID_PREDMET"];


        $countPrijav=PrijavaModel::countZapPrijavLetos($vpisna,$leto,$predmet);
        return $countPrijav;
    }



    public static function zapSteviloPrijavSkupno($id_rok){

        $vpisna=PrijavaModel::getVpisna(User::getId1());
        $studLetoPredmet=PrijavaModel::getStudLetoPredmetRok($id_rok);

        $vpisnaSt=$vpisna["VPISNA_STEVILKA"];
        $predmet=$studLetoPredmet["ID_PREDMET"];

        $countPrijav=PrijavaModel::countZapPrijavSkupno($vpisnaSt,$predmet);

        return $countPrijav;
    }


    public static function zapSteviloPrijavSkupnoProf($id_rok,$vpisna){


        $studLetoPredmet=PrijavaModel::getStudLetoPredmetRok($id_rok);


        $predmet=$studLetoPredmet["ID_PREDMET"];

        $countPrijav=PrijavaModel::countZapPrijavSkupno($vpisna,$predmet);

        return $countPrijav;
    }

    public static function vsehprijavljenihRokovLetos($id_rok){
        $vpisna=PrijavaModel::getVpisna(User::getId1());
        $studLetoPredmet=PrijavaModel::getStudLetoPredmetRok($id_rok);
        $vpisnaSt=$vpisna["VPISNA_STEVILKA"];
        $leto=$studLetoPredmet["ID_STUD_LETO"];
        $predmet=$studLetoPredmet["ID_PREDMET"];
        $countRokov=PrijavaModel::countVsehRokovLetos($vpisnaSt,$leto,$predmet);
        //var_dump("COUNTROKOV". $countRokov);
        return $countRokov;

    }

    public static function postoiPrijavaVoBazata($id_predmet){
        $vpisna=PrijavaModel::getVpisna(User::getId1());
        $vpisnaSt=$vpisna["VPISNA_STEVILKA"];
        $checkPrijava=PrijavaModel::checkPrijava($vpisnaSt,$id_predmet);
        //var_dump($checkPrijava);
        if($checkPrijava>0){
            return $checkPrijava;
        }
        return false;
    }


    public static function findDatumPrejnegaRoka($roki,$id_rok, $id_predmet){
        foreach ($roki as $i=>$rok){
            if($rok["ID_PREDMET"]==$id_predmet && $rok["ID_ROK"]!=$id_rok && $rok["OCENA_IZPITA"]<=5){
                return $rok["DATUM_ROKA"];
            }
        }
        return -1;
    }

    public static function getNacinStudija(){
        $vpisna=PrijavaModel::getVpisna(User::getId1());
        $vpisnaSt=$vpisna["VPISNA_STEVILKA"];
        $nacinStudija=PrijavaModel::getNacinStudija($vpisnaSt);
        return $nacinStudija["ID_NACIN"];
    }

    public static function odjavaOdIzpitu(){
        $data1 = filter_input_array(INPUT_POST, [
            "odjava" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);

        $vpisna=PrijavaModel::getVpisna(User::getId1());
        $vpisnaSt=$vpisna["VPISNA_STEVILKA"];
       //data1["odjava"] e id_rok
        $checkOdjava=PrijavaModel::odjaviSe(User::getId1(),$data1["odjava"],$vpisnaSt);
        ViewHelper::redirect(BASE_URL . "izpitniRok/student");

    }

    public static function setAllSubjects($roki,$id_rok,$id_predmet){
        foreach ($roki as $i=>$rok){
            if($rok["ID_PREDMET"]==$id_predmet && $rok["ID_ROK"]!=$id_rok){
                return $i;
            }
        }
        return -1;
    }



        /*
        $prijavenIdx=NULL;
        $padnatIdx=NULL;
        $imaPolozen=false;
       // var_dump($tekoven);echo "<br>";
        foreach ($roki as $i=>$rok ){
            var_dump($rok["ID_PREDMET"],$tekoven["ID_PREDMET"]);
            echo "<br>";
            if(($rok["ID_PREDMET"]!=$tekoven["ID_PREDMET"])){
                continue;
            }
            if($rok["ID_PRIJAVA"]!=NULL){
                if($rok["OCENA_IZPITA"] > 5){
                    $imaPolozen=true;
                }else if($rok["OCENA_IZPITA"] <= 5){
                    $padnatIdx=$i;
                }else{
                    $prijavenIdx=$i;
                }

            }

        }
        // var_dump($idx,$prijavenIdx,$padnatIdx,$imaPolozen);echo "<br>";
        if($prijavenIdx!=NULL ){
            if($idx==$prijavenIdx){
                return 2;
            }else{
                return 3;
            }
        }
        if($idx<=$padnatIdx) return 4;
        if($imaPolozen) return 4;

        return 1;
        */


    public static function exportPDFTiskaj($id){
        $studentId = KandidatModel::getKandidatIdWithUserId($id);
        if (UserModel::getTypeOfUser($id) == 'k') $studData = KandidatModel::getKandidatPodatki($studentId);
        else if (UserModel::getTypeOfUser($id) == 's') $studData = KandidatModel::getStudentPodatki($id);
        //Osebni podatki
        $header = array('Ime', 'Priimek', 'Email', 'EMŠO','Telefon','Datum rojstva');
        $lineData = array($studData['ime'], $studData['priimek'], $studData['email'], $studData["emso"], $studData['telefonska_stevilka'], $studData['DATUM_ROJSTVA']);

        //Naslov za vrocanje in stalni naslov
        $naslove=KandidatModel::getKandidatVseNaslove($id);
        $header1 = array('Ulica', 'Pošta', 'Občina','Država');

        $naslovStalnegaBivalisca=NULL;
        $naslovPrejemanje=NULL;
        $zacasniNaslov=NULL;
        $i = 1;
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
                $naslovStalnegaBivalisca=array($value['ULICA'],$posta,$obcina,$drzava);
            }else{
                $zacasniNaslov=array($value["ULICA"],$posta,$obcina,$drzava);
            }

            if ($value['JE_ZAVROCANJE'] == 1) {
                $naslovPrejemanje=array($value['ULICA'],$posta,$obcina,$drzava);
            }
        }


          //Podatki o vpisu
        $vpisData=DataForExportModel::getVpisPodatki($studentId);
        $studLetoVpisna=DataForExportModel::getStudijskoLetoAndVpisna($studentId);
        $username=$studData['uporabnisko_ime'];
        $header2=array('Štidijski program','Študijsko leto','Vpisna Številka','Uporabniško ime','Način študija','Vrsta študija','Letnik','Oblika Študija');
        //$lineData2=array($vpisData['NAZIV_PROGRAM'],$studLetoVpisna['STUD_LETO'],$studLetoVpisna['VPISNA_STEVILKA'],$username,$vpisData["OPIS_NACIN"],$vpisData["OPIS_VPISA"],$vpisData["LETNIK"],$vpisData["NAZIV_OBLIKA"]);
        $lineData2=array($studData['naziv_program'],$studData['stud_leto'],$studData['vpisna_stevilka'],$username,$studData["OPIS_NACIN"],$studData["OPIS_VPISA"],$studData["LETNIK"],$studData["NAZIV_OBLIKA"]);


        //Predmetnik
        $header3=array('#','Ime predmeta','Šifra predmeta','KT','Izvajalec');
        $imena=array();
        $lineData3=array();
        $sifre=array();
        $izvajalec=array();

        $VPISNA_STEVILKA = KandidatModel::getVpisnaStevilkaWithOsebaId($id);

        if (UserModel::getTypeOfUser($id) == 'k')
            $predmete = PredmetModel::getAll([
                "ID_STUD_LETO" => $studData["id_stud_leto"],
                "ID_PROGRAM" => $studData["id_program"],
                "ID_LETNIK" => 1
            ]);
        else if (UserModel::getTypeOfUser($id) == 's')
            $predmete = PredmetModel::getAllByStudent($studData['vpisna_stevilka'], $studData["id_stud_leto"]);

        // TODO fix getIzvajalec ID_STUD_LETO
        for($i=0; $i<count($predmete);$i++) {
            $imena[$i]=$predmete[$i]['IME_PREDMET'];
            $sifre[$i]=$predmete[$i]['SIFRA_PREDMET'];
            $lineData3[$i]=$predmete[$i]['ST_KREDITNIH_TOCK'];
            $idPredmet=$predmete[$i]['ID_PREDMET'];
            $getIzvajalec=DataForExportModel::getIzvajalec($idPredmet,$studData["id_stud_leto"]);
            $izvajalec[$i]=$getIzvajalec["IME"] . " " . $getIzvajalec["PRIIMEK"];
        }

        $pdf= new tFPDF();
        $pdf->AddPage();
        $pdf->AddFont('DejaVu','','DejaVuSans.ttf',true);

        $pdf->Image('./static/images/logo-ul.jpg', 8, 8, 20, 20, 'JPG');
        $pdf->SetFont('DejaVu','',15);
        $pdf->Cell(200,10,'Univerza v Ljubjani, Fakulteta za računalništvo in informatiko ',0,0,'C');
        $pdf->Ln();
        $tDate=date("Y-m-d");
        $sloDate=self::formatDateSlo($tDate);
        $pdf->Cell(0, 10, 'Datum izdaje : '.$sloDate, 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $pdf->Ln();


        $pdf->SetFont('DejaVu','',30);
        $pdf->Cell(200,50,'VPISNI LIST ',0,0,'C');
        $pdf->Ln();

        $pdf->SetFont('DejaVu','',15);
        $pdf->Cell(80,10,'Osebni podatki študenta',0,0,'C');
        $pdf->Cell(100,10,'Podatki o vpisu',0,0,'C');
        $pdf->Ln();
        $pdf->SetFont('DejaVu','',8);
        $pdf->BasicTable4($header,$lineData,$header2,$lineData2);
        $pdf->Ln();

        $pdf->SetFont('DejaVu','',15);
        $pdf->Cell(80,10,'Stalni naslov',0,0,'C');
        $pdf->Cell(100,10,'Začasni naslov',0,0,'C');
        $pdf->Ln();
        $pdf->SetFont('DejaVu','',8);
        $pdf->BasicTable4($header1,$naslovStalnegaBivalisca,$header1,$zacasniNaslov);
        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetFont('DejaVu','',15);
        $pdf->Cell(80,10,'Naslov za prejemanje',0,0,'C');
        $pdf->Ln();
        $pdf->SetFont('DejaVu','',8);
        $pdf->BasicTable($header1,$naslovPrejemanje);
        $pdf->Ln();

        $pdf->SetX(180);
        $pdf->SetY(265);
        $pdf->AliasNbPages('{totalPages}');
        $pdf->Cell(0, 10, 'Stran '.$pdf->PageNo(). "/{totalPages}", 0, false, 'C', 0, '', 0, false, 'T', 'M');


        $pdf->AddPage();

        $pdf->SetFont('DejaVu','',15);
        $pdf->Cell(180,10,'Predmetnik študenta',0,0,'C');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetFont('DejaVu','',8);
        $pdf->BasicTable2($header3,$imena,$lineData3,$sifre,$izvajalec);

        $pdf->SetX(180);
        $pdf->SetY(265);
        $pdf->AliasNbPages('{totalPages}');
        $pdf->Cell(0, 10, 'Stran '.$pdf->PageNo(). "/{totalPages}", 0, false, 'C', 0, '', 0, false, 'T', 'M');

        $pdf->Output();

        $filename="data.pdf";
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
    }

    public static function formatDateSlo($date){
        list($d, $m, $y) = explode('-', $date);
        return $y.".".$m.".".$d;
    }

    public static function kartotecniListForm1($status = null, $message = null) {
        if (User::isLoggedIn()) {
            if (User::isLoggedInAsStudent()) {
                $ID_STUDENT = User::getId();
                ViewHelper::render("view/KartotecniListChooseStudent.php", [
                    "pageTitle" => "Izberite pogled",
                    "allData" => StudentModel::getAllStudents($ID_STUDENT),
                    "formAction" => "kartotecniListS/pogled" ,
                    "status" => $status,
                    "oseba" => 2,
                    "message" => $message
                ]);
            } else {
                ViewHelper::error403();
            }
        } else {
            ViewHelper::error401();
        }
    }
    public static function kartotecniListForm2($id3, $id4, $status = null, $message = null)
    {

        if (User::isLoggedIn()) {
            if (User::isLoggedInAsStudent()) {
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
                foreach ($program as $key=>$value) {
                    if (!in_array($key, $programi)){
                        array_push($programi, $key);
                    }
                }

                if(count($program) > 1){
                    $programi = KartotecniListDB::getProgrami($programi);
                    ViewHelper::render("view/KartotecniListStudentChoose.php", [
                        "pageTitle" => $title,
                        "allData" => $programi,
                        "formAction" => $id4."/program",
                        "studData" => $studData,
                        "ocene" => $ocenePoLetih,
                        "status" => $status,
                        "oseba" => 1,
                        "message" => $message
                    ]);
                }
                else {
                    self::kartotecniListForm3($programi[0],$id3, $id4, $status, $message);}
            } else {
                ViewHelper::error403();
            }
        } else {
            ViewHelper::error401();
        }
    }
    public static function kartotecniListForm3($program,  $id3, $id4, $status = null, $message = null)
    {
        if (User::isLoggedIn()) {
            if (User::isLoggedInAsStudent()) {
                $studData = KartotecniListDB::getStudData($id3);
                $ocenePoLetih = KartotecniListDB::getOcenePoLetih($id3);

                $title = "Kartotečni list študenta " . $studData[0]['IME'] . " " . $studData[0]['PRIIMEK'] . "  (" .
                    $studData[0]['VPISNA_STEVILKA'] . ")";

                if ($id4 == 1) {
                    $data = KartotecniListDB::getAllPolaganja($id3);
                } else {
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


                ViewHelper::render("view/KartotecniListShowStudent.php", [
                    "pageTitle" => $title,
                    "allData" => $data,
                    "formAction" => "studentID",
                    "studData" => $studData,
                    "ocene" => $ocenePoLetih,
                    "status" => $status,
                    "oseba" => 1,
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
    public static function kartotecniListForm5( $id3, $id4, $program,$status = null, $message = null)
    {
        if (User::isLoggedIn()) {
            if (User::isLoggedInAsStudent()) {
                $studData = KartotecniListDB::getStudData($id3);
                $ocenePoLetih = KartotecniListDB::getOcenePoLetih($id3);

                $title = "Kartotečni list študenta " . $studData[0]['IME'] . " " . $studData[0]['PRIIMEK'] . "  (" .
                    $studData[0]['VPISNA_STEVILKA'] . ")";

                if ($id4 == 1) {
                    $data = KartotecniListDB::getAllPolaganja($id3);
                } else {
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

                ViewHelper::render("view/KartotecniListShowStudent.php", [
                    "pageTitle" => $title,
                    "allData" => $data,
                    "formAction" => "studentID",
                    "studData" => $studData,
                    "ocene" => $ocenePoLetih,
                    "status" => $status,
                    "oseba" => 1,
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

    public static function gumbTiskaj(){
        $id=User::getId();
        $jeIzkoriscen=KandidatModel::jeIzkoriscen($id);
       // var_dump($id);
      //  var_dump($jeIzkoriscen);
        ViewHelper::render("view/TiskajGumb.php", [
            "id" => $id,
            "jeIzkoriscen" => $jeIzkoriscen
        ]);
    }

}