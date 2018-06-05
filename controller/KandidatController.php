<?php

require_once("model/KandidatModel.php");
require_once("model/ObcinaModel.php");
require_once("model/PostaModel.php");
require_once("model/DrzavaModel.php");
require_once("model/PredmetModel.php");
require_once("model/UserModel.php");
require_once("model/User.php");
require_once("includes/Validation.php");
require_once("ViewHelper.php");

class KandidatController {
    public static function vpisForm($status = null, $message = null) {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsCandidate()) {
                if (KandidatModel::jeVpisniListZeOddan(User::getId())) {
                    ViewHelper::render("view/VpisniListPDFViewer.php", [
                        "vloga"=> "kandidat",
                        "id"=> User::getId(),
                        "status" => "Info",
                        "message" => "Vpisni list ste ze oddali. Prosim pocakajte potrditev referenta."
                    ]);
                } else {
                    $KandidatId = KandidatModel::getKandidatIdWithUserId(User::getId());
                    $KandidatPodatki = KandidatModel::getKandidatPodatki($KandidatId);
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

                    ViewHelper::render("view/VpisniListViewer.php", [
                        "pageTitle" => "Vpisni list",
                        "formAction" => "vpis",
                        "KandidatPodatki" => $KandidatPodatki,
                        "stud_leto" => $stud_leto,
                        "obcine" => $obcine,
                        "poste" => $poste,
                        "drzave" => $drzave,
                        "userName" => $userName,
                        "predmeti" => $predmeti,
                        "status" => $status,
                        "message" => $message
                    ]);
                }
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }
    
    public static function vpis() {
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
            "ulica" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
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
                            $idKandidat = KandidatModel::getKandidatIdWithUserId(User::getId());
                            KandidatModel::updateEmso($idKandidat, $data["emso"]);
                            KandidatModel::updateTelefon($idKandidat, $data["telefonska_stevilka"], $data["DATUM_ROJSTVA"]);
                            KandidatModel::izkoristiZeton(User::getId());
                            
                            KandidatModel::insertNaslov($idKandidat, [
                                "id_drzava" => $data["id_drzava"],
                                "id_posta" => (isset($data["id_posta"]) ? $data["id_posta"] : NULL),
                                "id_obcina" => (isset($data["id_obcina"]) ? $data["id_obcina"] : NULL),
                                "ulica" => $data["ulica"],
                                "je_zavrocanje" => ($data["naslovZaVrocanje"]=="stalni" ? 1 : 0),
                                "je_stalni" => 1
                            ]);
                            KandidatModel::insertNaslov($idKandidat, [
                                "id_drzava" => (isset($data["id_drzava2"]) ? $data["id_drzava2"] : NULL),
                                "id_posta" => (isset($data["id_posta2"]) ? $data["id_posta2"] : NULL),
                                "id_obcina" => (isset($data["id_obcina2"]) ? $data["id_obcina2"] : NULL),
                                "ulica" => (isset($data["ulica2"]) ? $data["ulica2"] : NULL),
                                "je_zavrocanje" => ($data["naslovZaVrocanje"]=="zacasni" ? 1 : 0),
                                "je_stalni" => 0
                            ]);
                            
                            KandidatModel::potrdiVpisKandidat($idKandidat);
                            
                            ViewHelper::render("view/DisplayMessageViewer.php", [
                                "status" => "Success",
                                "message" => "Vpisni list ste uspesno oddali. Prosim pocakajte potrditev referenta."
                            ]);
                        } else {
                            self::vpisForm("Failure", "Napaka, preslikava posta-obcina za zacasni naslov ni veljavna. Poskusite znova.");
                        }
                    } else {
                        self::vpisForm("Failure", "Napaka, preslikava posta-obcina za stalni naslov ni veljavna. Poskusite znova.");
                    }
                } else {
                    self::vpisForm("Failure", "Napaka, emso st. ni veljavna. Poskusite znova.");
                }
            } else {
                self::vpisForm("Failure", "Napaka, datum rojstva in emso st. se ne ujemata. Poskusite znova.");
            }
        } else {
            self::vpisForm("Failure", "Napaka, vnos ni veljaven. Poskusite znova.");
        }
    }
}