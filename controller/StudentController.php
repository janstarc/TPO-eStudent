<?php

require_once("model/UserModel.php");
require_once("model/StudentModel.php");
require_once("model/PredmetModel.php");
require_once("model/DataForExportModel.php");
require_once("model/DelPredmetnikaModel.php");
require_once("model/User.php");
require_once("ViewHelper.php");
require_once ("view/includes/tfpdf.php");


class StudentController {
    public static function vpisForm() {
        $zeton = StudentModel::getLastNeIzkoriscenZeton(User::getId());
        if ($zeton == null) {
            ViewHelper::render("view/DisplayMessageViewer.php", [
                "status" => "Info",
                "message" => "Vpisni list ste ze oddali ali ne ispolnujete pogoje za vpis v visji letnik."
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
        
        $ObvPredmeti = PredmetModel::getAllByType([
            "ID_STUD_LETO" => 2, //$KandidatPodatki["id_stud_leto"],
            "ID_PROGRAM" => 11, //$KandidatPodatki["id_program"],
            "ID_LETNIK" => 2,
            "TIP" => 'o'
        ]);
        $StrIzbPredmeti = PredmetModel::getAllByType([
            "ID_STUD_LETO" => 2, //$KandidatPodatki["id_stud_leto"],
            "ID_PROGRAM" => 11, //$KandidatPodatki["id_program"],
            "ID_LETNIK" => 2,
            "TIP" => 'st'
        ]);
        $SplIzbPredmeti = PredmetModel::getAllByType([
            "ID_STUD_LETO" => 2, //$KandidatPodatki["id_stud_leto"],
            "ID_PROGRAM" => 11, //$KandidatPodatki["id_program"],
            "ID_LETNIK" => 2,
            "TIP" => 'sp'
        ]);
        // echo '<pre>' . var_export($ObvPredmeti, true) . '</pre>';
        // echo '<pre>' . var_export($StrIzbPredmeti, true) . '</pre>';
        // echo '<pre>' . var_export($SplIzbPredmeti, true) . '</pre>';
        
        ViewHelper::render("view/VpisniList2Viewer.php", [
            "pageTitle" => "Vpisni list",
            "formAction" => "vpis2L",
            "KandidatPodatki" => $KandidatPodatki,
            "userName" => $userName,
            "StudijskaLeta" => StudijskoLetoModel::getAll(),
            "StudijskiProgrami" => StudijskiProgramModel::getAll(),
            "obcine" => $obcine,
            "poste" => $poste,
            "drzave" => $drzave,
            "naslov" => KandidatModel::getKandidatVseNaslove(User::getId()),
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
        $obcine = ObcinaModel::getAll();
        $poste = PostaModel::getAll();
        $drzave = DrzavaModel::getAll();
        
        $ObvPredmeti = PredmetModel::getAllByType([
            "ID_STUD_LETO" => 2, //$KandidatPodatki["id_stud_leto"],
            "ID_PROGRAM" => 11, //$KandidatPodatki["id_program"],
            "ID_LETNIK" => 3,
            "TIP" => 'o'
        ]);
        $IzbModulov = DelPredmetnikaModel::getAllModulov();
        $SplIzbPredmeti = PredmetModel::getAllByType([
            "ID_STUD_LETO" => 2, //$KandidatPodatki["id_stud_leto"],
            "ID_PROGRAM" => 11, //$KandidatPodatki["id_program"],
            "ID_LETNIK" => 2,
            "TIP" => 'sp'
        ]);
        // echo '<pre>' . var_export($ObvPredmeti, true) . '</pre>';
        // echo '<pre>' . var_export($IzbModulov, true) . '</pre>';
        // echo '<pre>' . var_export($SplIzbPredmeti, true) . '</pre>';
        
        ViewHelper::render("view/VpisniList31Viewer.php", [
            "pageTitle" => "Vpisni list",
            "formAction" => "vpis3L1",
            "KandidatPodatki" => $KandidatPodatki,
            "userName" => $userName,
            "StudijskaLeta" => StudijskoLetoModel::getAll(),
            "StudijskiProgrami" => StudijskiProgramModel::getAll(),
            "obcine" => $obcine,
            "poste" => $poste,
            "drzave" => $drzave,
            "naslov" => KandidatModel::getKandidatVseNaslove(User::getId()),
            "predmeti" => $ObvPredmeti,
            "IzbModulov" => $IzbModulov,
            "SplIzbPredmeti" => $SplIzbPredmeti,
            "status" => $status,
            "message" => $message
        ]);
    }

    public static function vpis3L2Form($status = null, $message = null) {
        $userName = UserModel::getUserName(User::getId());
        $KandidatPodatki = KandidatModel::getStudentPodatki(User::getId());
        $obcine = ObcinaModel::getAll();
        $poste = PostaModel::getAll();
        $drzave = DrzavaModel::getAll();
        
        $ObvPredmeti = PredmetModel::getAllByType([
            "ID_STUD_LETO" => 2, //$KandidatPodatki["id_stud_leto"],
            "ID_PROGRAM" => 11, //$KandidatPodatki["id_program"],
            "ID_LETNIK" => 3,
            "TIP" => 'o'
        ]);
        $ModIzbPredmeti = PredmetModel::getAllByType([
            "ID_STUD_LETO" => 2, //$KandidatPodatki["id_stud_leto"],
            "ID_PROGRAM" => 11, //$KandidatPodatki["id_program"],
            "ID_LETNIK" => 3,
            "TIP" => 'm'
        ]);
        $SplIzbPredmeti = PredmetModel::getAllByType([
            "ID_STUD_LETO" => 2, //$KandidatPodatki["id_stud_leto"],
            "ID_PROGRAM" => 11, //$KandidatPodatki["id_program"],
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
            "StudijskaLeta" => StudijskoLetoModel::getAll(),
            "StudijskiProgrami" => StudijskiProgramModel::getAll(),
            "obcine" => $obcine,
            "poste" => $poste,
            "drzave" => $drzave,
            "naslov" => KandidatModel::getKandidatVseNaslove(User::getId()),
            "predmeti" => $ObvPredmeti,
            "ModIzbPredmeti" => $ModIzbPredmeti,
            "SplIzbPredmeti" => $SplIzbPredmeti,
            "status" => $status,
            "message" => $message
        ]);
    }
    
    public static function vpis2L($status = null, $message = null) {
        // echo '<pre>' . var_export($_POST, true) . '</pre>';
        
        $data = filter_input_array(INPUT_POST, [
            "emso" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
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
            
            // TODO validate chosen subjects
//            if () {
                KandidatModel::updateOsebaEmsoInTelefon(User::getId(), $data["emso"], $data["telefonska_stevilka"]);
                
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
                $KandidatPodatki = KandidatModel::getStudentPodatki(User::getId());
                $ObvPredmeti = PredmetModel::getAllByType([
                    "ID_STUD_LETO" => 2, //$KandidatPodatki["id_stud_leto"],
                    "ID_PROGRAM" => $KandidatPodatki["id_program"],
                    "ID_LETNIK" => 2,
                    "TIP" => 'o'
                ]);
                
                // TODO ID STUD LETO
                KandidatModel::insertPredmetiKandidat($VPISNA_STEVILKA, $ObvPredmeti, 2); // $data["ID_STUD_LETO"]);
                if (isset($_POST["ModIzbPredmeti"])) {
                    $ModIzbPredmeti = array();
                    foreach ($_POST["ModIzbPredmeti"] as $key => $value) {
                        $ModIzbPredmeti[] = PredmetModel::get($value);
                    }
                    // echo '<pre>' . var_export($ModIzbPredmeti, true) . '</pre>';
                    KandidatModel::insertPredmetiKandidat($VPISNA_STEVILKA, $ModIzbPredmeti, 2); // $data["ID_STUD_LETO"]);
                }
                if (isset($_POST["SplIzbPredmeti"])) {
                    $SplIzbPredmeti = array();
                    foreach ($_POST["SplIzbPredmeti"] as $key => $value) {
                        $SplIzbPredmeti[] = PredmetModel::get($value);
                    }
                    // echo '<pre>' . var_export($SplIzbPredmeti, true) . '</pre>';
                    KandidatModel::insertPredmetiKandidat($VPISNA_STEVILKA, $SplIzbPredmeti, 2); // $data["ID_STUD_LETO"]);
                }
                
                ViewHelper::render("view/DisplayMessageViewer.php", [
                    "status" => "Success",
                    "message" => "Vpisni list ste uspesno oddali. Prosim pocakajte potrditev referenta."
                ]);
//            }
        } else {
            self::vpisForm("Failure", "Napaka, vnos ni veljaven. Poskusite znova.");
        }
    }
    
    public static function vpis3L1($status = null, $message = null) {
    
    }
    
    public static function vpis3L2($status = null, $message = null) {
        // echo '<pre>' . var_export($_POST, true) . '</pre>';
        
        $data = filter_input_array(INPUT_POST, [
            "emso" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
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
            
            // TODO validate chosen subjects
//            if () {
                KandidatModel::updateOsebaEmsoInTelefon(User::getId(), $data["emso"], $data["telefonska_stevilka"]);
                
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
                $KandidatPodatki = KandidatModel::getStudentPodatki(User::getId());
                $ObvPredmeti = PredmetModel::getAllByType([
                    "ID_STUD_LETO" => 2, //$KandidatPodatki["id_stud_leto"],
                    "ID_PROGRAM" => $KandidatPodatki["id_program"],
                    "ID_LETNIK" => 2,
                    "TIP" => 'o'
                ]);
                
                // TODO ID STUD LETO
                KandidatModel::insertPredmetiKandidat($VPISNA_STEVILKA, $ObvPredmeti, 2); // $data["ID_STUD_LETO"]);
                if (isset($_POST["StrIzbPredmeti"])) {
                    $StrIzbPredmeti = array();
                    foreach ($_POST["StrIzbPredmeti"] as $key => $value) {
                        $StrIzbPredmeti[] = PredmetModel::get($value);
                    }
                    // echo '<pre>' . var_export($StrIzbPredmeti, true) . '</pre>';
                    KandidatModel::insertPredmetiKandidat($VPISNA_STEVILKA, $StrIzbPredmeti, 2); // $data["ID_STUD_LETO"]);
                }
                if (isset($_POST["SplIzbPredmeti"])) {
                    $SplIzbPredmeti = array();
                    foreach ($_POST["SplIzbPredmeti"] as $key => $value) {
                        $SplIzbPredmeti[] = PredmetModel::get($value);
                    }
                    // echo '<pre>' . var_export($SplIzbPredmeti, true) . '</pre>';
                    KandidatModel::insertPredmetiKandidat($VPISNA_STEVILKA, $SplIzbPredmeti, 2); // $data["ID_STUD_LETO"]);
                }
                
                ViewHelper::render("view/DisplayMessageViewer.php", [
                    "status" => "Success",
                    "message" => "Vpisni list ste uspesno oddali. Prosim pocakajte potrditev referenta."
                ]);
//            }
        } else {
            self::vpisForm("Failure", "Napaka, vnos ni veljaven. Poskusite znova.");
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
        $header = array('Ime', 'Priimek', 'Email', 'EMŠO','Telefon','Državljanstvo');
        $lineData = array($studData['ime'], $studData['priimek'], $studData['email'], $emso['EMSO'], $studData['telefonska_stevilka'],"Slovenija");

        // TODO
        //Naslov za vrocanje in stalni naslov
        $naslove=KandidatModel::getOsebaVseNaslove($studentId);
        $header1 = array('Ulica', 'Hišna številka', 'Kraj','Poštna številka');
        foreach ($naslove as $key => $value) {
            if ($value['JE_STALNI'] == 1) {
                $naslovStalnegaBivalisca=array($value['ULICA'],$value['HISNA_STEVILKA'],$value['KRAJ'],$value['ST_POSTA']);
            }

            if ($value['JE_ZAVROCANJE'] == 1) {
                $naslovPrejemanje=array($value['ULICA'],$value['HISNA_STEVILKA'],$value['KRAJ'],$value['ST_POSTA']);
            }
        }



        //Podatki o vpisu
        $vpisData=DataForExportModel::getVpisPodatki($studentId);
        $studLetoVpisna=DataForExportModel::getStudijskoLetoAndVpisna($studentId);
        $username=$studData['uporabnisko_ime'];
        $header2=array('Štidijski program','Študijsko leto','Vpisna Številka','Uporabniško ime');
        $lineData2=array($vpisData['NAZIV_PROGRAM'],$studLetoVpisna['STUD_LETO'],$studLetoVpisna['VPISNA_STEVILKA'],$username);

        //Predmetnik
        $header3=array('Ime predmeta','Šifra predmeta','KT','Izvajalec');
        $imena=array();
        $lineData3=array();
        $sifre=array();
        $izvajalec=array();

        $predmete=DataForExportModel::getPredmete($studLetoVpisna['STUD_LETO'],$vpisData['ID_PROGRAM'],$studLetoVpisna['ID_LETNIK']);

        for($i=0; $i<count($predmete);$i++){
            $imena[$i]=$predmete[$i]['IME_PREDMET'];
            $sifre[$i]=$predmete[$i]['ID_PREDMET'];
            $lineData3[$i]=$predmete[$i]['ST_KREDITNIH_TOCK'];
            $getIzvajalec=DataForExportModel::getIzvajalec($sifre[$i],$studLetoVpisna['STUD_LETO']);

            $izvajalec[$i]=$getIzvajalec["IME"] . " " . $getIzvajalec["PRIIMEK"];
        }

        $pdf= new tFPDF();
        $pdf->AddPage();
        $pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);


        $pdf->SetFont('DejaVu','',30);
        $pdf->Cell(200,50,'VPISNI LIST ',0,0,'C');
        $pdf->Ln();

        $pdf->SetFont('DejaVu','',15);
        $pdf->Cell(80,10,'Osebni podatki študenta',0,0,'C');
        $pdf->Cell(100,10,'Naslov za vročanje',0,0,'C');
        $pdf->Ln();
        $pdf->SetFont('DejaVu','',8);
        $pdf->BasicTable3($header,$lineData,$header1,$naslovPrejemanje);
        $pdf->Ln();

        $pdf->SetFont('DejaVu','',15);
        $pdf->Cell(80,10,'Podatki o vpisu',0,0,'C');
        $pdf->Cell(100,10,'Stalni naslov',0,0,'C');
        $pdf->Ln();
        $pdf->SetFont('DejaVu','',8);
        $pdf->BasicTable3($header2,$lineData2,$header1,$naslovStalnegaBivalisca);
        $pdf->Ln();
        $pdf->Ln();

        $pdf->SetFont('DejaVu','',15);
        $pdf->Cell(180,10,'Predmetnik študenta',0,0,'C');
        $pdf->Ln();
        $pdf->SetFont('DejaVu','',8);
        $pdf->BasicTable2($header3,$imena,$lineData3,$sifre,$izvajalec);

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
        $header = array('Ime', 'Priimek', 'Email', 'EMŠO','Telefon','Državljanstvo');
        $lineData = array($studData['ime'], $studData['priimek'], $studData['email'], $emso['EMSO'], $studData['telefonska_stevilka'],"Slovenija");

        // TODO
        //Naslov za vrocanje in stalni naslov
        $naslove=KandidatModel::getOsebaVseNaslove($studentId);
        $header1 = array('Ulica', 'Hišna številka', 'Kraj','Poštna številka');
        foreach ($naslove as $key => $value) {
            if ($value['JE_STALNI'] == 1) {
                $naslovStalnegaBivalisca=array($value['ULICA'],$value['HISNA_STEVILKA'],$value['KRAJ'],$value['ST_POSTA']);
            }

            if ($value['JE_ZAVROCANJE'] == 1) {
                $naslovPrejemanje=array($value['ULICA'],$value['HISNA_STEVILKA'],$value['KRAJ'],$value['ST_POSTA']);
            }
        }



        //Podatki o vpisu
        $vpisData=DataForExportModel::getVpisPodatki($studentId);
        $studLetoVpisna=DataForExportModel::getStudijskoLetoAndVpisna($studentId);
        $username=$studData['uporabnisko_ime'];
        $header2=array('Štidijski program','Študijsko leto','Vpisna Številka','Uporabniško ime');
        $lineData2=array($vpisData['NAZIV_PROGRAM'],$studLetoVpisna['STUD_LETO'],$studLetoVpisna['VPISNA_STEVILKA'],$username);

        //Predmetnik
        $header3=array('Ime predmeta','Šifra predmeta','KT','Izvajalec');
        $imena=array();
        $lineData3=array();
        $sifre=array();
        $izvajalec=array();

        $predmete=DataForExportModel::getPredmete($studLetoVpisna['STUD_LETO'],$vpisData['ID_PROGRAM'],$studLetoVpisna['ID_LETNIK']);

        for($i=0; $i<count($predmete);$i++){
            $imena[$i]=$predmete[$i]['IME_PREDMET'];
            $sifre[$i]=$predmete[$i]['ID_PREDMET'];
            $lineData3[$i]=$predmete[$i]['ST_KREDITNIH_TOCK'];
            $getIzvajalec=DataForExportModel::getIzvajalec($sifre[$i],$studLetoVpisna['STUD_LETO']);

            $izvajalec[$i]=$getIzvajalec["IME"] . " " . $getIzvajalec["PRIIMEK"];
        }

        $pdf= new tFPDF();
        for($i=0;$i<6;$i++){
            $pdf->AddPage();
            $pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);


            $pdf->SetFont('DejaVu','',30);
            $pdf->Cell(200,50,'VPISNI LIST ',0,0,'C');
            $pdf->Ln();

            $pdf->SetFont('DejaVu','',15);
            $pdf->Cell(80,10,'Osebni podatki študenta',0,0,'C');
            $pdf->Cell(100,10,'Naslov za vročanje',0,0,'C');
            $pdf->Ln();
            $pdf->SetFont('DejaVu','',8);
            $pdf->BasicTable3($header,$lineData,$header1,$naslovPrejemanje);
            $pdf->Ln();

            $pdf->SetFont('DejaVu','',15);
            $pdf->Cell(80,10,'Podatki o vpisu',0,0,'C');
            $pdf->Cell(100,10,'Stalni naslov',0,0,'C');
            $pdf->Ln();
            $pdf->SetFont('DejaVu','',8);
            $pdf->BasicTable3($header2,$lineData2,$header1,$naslovStalnegaBivalisca);
            $pdf->Ln();
            $pdf->Ln();

            $pdf->SetFont('DejaVu','',15);
            $pdf->Cell(180,10,'Predmetnik študenta',0,0,'C');
            $pdf->Ln();
            $pdf->SetFont('DejaVu','',8);
            $pdf->BasicTable2($header3,$imena,$lineData3,$sifre,$izvajalec);



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
                if (empty($roki)) {
                    $status = "Info";
                    $message = "Trenutno ni razpisanih izpitne roke.";
                }
                ViewHelper::render("view/IzpitniRokStudent.php", [
                    "pageTitle" => "Seznam vse roke",
                    "roki" => $roki,
                    "formAction" => "izpitniRok/student/",
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
}