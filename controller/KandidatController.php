<?php

require_once("model/KandidatModel.php");
require_once("model/ObcinaModel.php");
require_once("model/PostaModel.php");
require_once("model/DrzavaModel.php");
require_once("model/UserModel.php");
require_once("model/User.php");
require_once("includes/Validation.php");
require_once("ViewHelper.php");

class KandidatController {
    public static function vpisForm($status = null, $message = null) {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsCandidate()) {
                if (KandidatModel::jeVpisniListZeOddan(User::getId())) {
                    ViewHelper::render("view/DisplayMessageViewer.php", [
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
                    
                    ViewHelper::render("view/VpisniListViewer.php", [
                        "pageTitle" => "Vpisni list",
                        "formAction" => "vpis",
                        "KandidatPodatki" => $KandidatPodatki,
                        "stud_leto" => $stud_leto,
                        "obcine" => $obcine,
                        "poste" => $poste,
                        "drzave" => $drzave,
                        "userName" => $userName,
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
        $data2 = filter_input_array(INPUT_POST, [
            "optradio" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);
        if (Validation::checkValues($data2)) {
            if ($data2["optradio"]=="je_zavrocanje" || $data2["optradio"]=="ni_zavrocanje") {
                if ($data2["optradio"]=="je_zavrocanje") {
                    $data = filter_input_array(INPUT_POST, [
                        "email" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
                        "emso" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
                        "telefonska_stevilka" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
                        "id_drzava" => [
                            'filter' => FILTER_VALIDATE_INT,
                            'options' => [
                                'min_range' => 1
                            ]
                        ],
                        "ulica" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
                        "hisna_stevilka" => [
                            'filter' => FILTER_VALIDATE_INT,
                            'options' => [
                                'min_range' => 1
                            ]
                        ],
                        "id_posta" => [
                            'filter' => FILTER_VALIDATE_INT,
                            'options' => [
                                'min_range' => 1
                            ]
                        ]
                    ]);
                } else if ($data2["optradio"]=="ni_zavrocanje") {
                    $data = filter_input_array(INPUT_POST, [
                        "email" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
                        "emso" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
                        "telefonska_stevilka" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
                        "id_drzava" => [
                            'filter' => FILTER_VALIDATE_INT,
                            'options' => [
                                'min_range' => 1
                            ]
                        ],
                        "ulica" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
                        "hisna_stevilka" => [
                            'filter' => FILTER_VALIDATE_INT,
                            'options' => [
                                'min_range' => 1
                            ]
                        ],
                        "id_posta" => [
                            'filter' => FILTER_VALIDATE_INT,
                            'options' => [
                                'min_range' => 1
                            ]
                        ],
                        "ulica2" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
                        "hisna_stevilka2" => [
                            'filter' => FILTER_VALIDATE_INT,
                            'options' => [
                                'min_range' => 1
                            ]
                        ],
                        "id_posta2" => [
                            'filter' => FILTER_VALIDATE_INT,
                            'options' => [
                                'min_range' => 1
                            ]
                        ]
                    ]);
                }
                
                if (Validation::checkValues($data)) {
                    $idKandidat = KandidatModel::getKandidatIdWithEmail($data["email"]);
                    KandidatModel::setEmso($idKandidat, $data["emso"]);
                    KandidatModel::setTelefon($idKandidat, $data["telefonska_stevilka"]);
                    if (isset($_POST["je_zavrocanje"])) {
                        KandidatModel::setNaslov($idKandidat, [
                            "id_drzava" => $data["id_drzava"],
                            "je_zavrocanje" => 1,
                            "je_stalni" => 1,
                            "ulica" => $data["ulica"],
                            "hisna_stevilka" => $data["hisna_stevilka"]
                        ]);
                    } else if (isset($_POST["ni_zavrocanje"])) {
                        KandidatModel::setNaslov($idKandidat, [
                            "id_drzava" => $data["id_drzava"],
                            "je_zavrocanje" => 0,
                            "je_stalni" => 1,
                            "ulica" => $data["ulica"],
                            "hisna_stevilka" => $data["hisna_stevilka"]
                        ]);
                        KandidatModel::setNaslov($idKandidat, [
                            "id_drzava" => $data["id_drzava2"],
                            "je_zavrocanje" => 1,
                            "je_stalni" => 0,
                            "ulica" => $data["ulica2"],
                            "hisna_stevilka" => $data["hisna_stevilka2"]
                        ]);
                    }
                    KandidatModel::potrdiVpisKandidat($idKandidat);
                    ViewHelper::render("view/DisplayMessageViewer.php", [
                        "status" => "Success",
                        "message" => "Vpisni list ste uspesno oddali. Prosim pocakajte potrditev referenta."
                    ]);
                } else {
                    var_dump($data);
                    self::vpisForm("Failure", "Napaka, vnos ni veljaven. Poskusite znova.");
                }
            } else {
                self::vpisForm("Failure", "Napaka, potrebno je izbira med je ali ni stalni naslov tudi za vrocanje. Poskusite znova.");
            }
        } else {
            self::vpisForm("Failure", "Napaka, potrebno je izbira med je ali ni stalni naslov tudi za vrocanje. Poskusite znova.");
        }
    }
}