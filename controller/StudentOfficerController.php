<?php

require_once("model/StudentOfficerDB.php");
require_once("model/StudijskoLetoModel.php");
require_once("model/StudijskiProgramModel.php");
require_once("model/KandidatModel.php");
require_once("model/UserModel.php");
require_once("model/User.php");
require_once("ViewHelper.php");

class StudentOfficerController {
    public static function kandidatiList($status = null, $message = null) {
        if (User::isLoggedIn()) {
            if (User::isLoggedInAsStudentOfficer()) {
                ViewHelper::render("view/Kandidati.php", [
                    "pageTitle" => "Seznam vseh kandidatov",
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
    
    public static function kandidatiPreglejVpisForm($id, $status = null, $message = null) {
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
        //var_dump($predmeti);

        $id_vpis = KandidatModel::getVpisId($id);
        KandidatModel::insertPredmetiKandidat($id_vpis, $predmeti, $KandidatPodatki["id_stud_leto"]);
        //self::kandidatiList("Success", "Vpis za študenta ".$data['ime']." ".$data['priimek']." uspešno potrjen!");
    }
    
    public static function Zeton() {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsStudentOfficer()){
                ViewHelper::render("view/Zeton.php", [
                    "zetoni" => array()
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
        ]);
        StudentOfficerDB::dodajNov(StudentOfficerDB::ZetonData($data["idZeton"]));
        ViewHelper::render("view/Zeton.php", [
            "zetoni" => array()
        ]);
    }

    public static function uredi() {
        $data = filter_input_array(INPUT_POST, [
            "idZeton" =>["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
        ]);
        ViewHelper::render("view/ZetonAdd.php", [
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
        var_dump($dataForAverage);
    }

}
