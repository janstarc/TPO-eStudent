<?php

session_start();

require_once("controller/LoginController.php");
require_once("controller/AdminController.php");
require_once("controller/StudentOfficerController.php");
require_once("controller/ProfessorController.php");
require_once("controller/StudentController.php");
require_once("controller/SifrantController.php");
require_once("model/User.php");

define("APP_NAME", "STUDIS");
define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");
define("PROJECT_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php"));
define("IMAGES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/images/");
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/css/");
define("JS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/js/");

define("CURRENT_YEAR", "2017-2018");

$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";
// ROUTER: defines mapping between URLS and controllers
$urls = [
    "/^$/" => function ($method) {
        if (User::isLoggedIn()){
            if ($method == "GET") LoginController::dashboardForm();
            else ViewHelper::error405();
        }else{
            if ($method == "GET") ViewHelper::redirect(BASE_URL . "login");
            else ViewHelper::error405();
        }
    }, "/^login$/" => function ($method) {
        if ($method == "POST") LoginController::login();
        else if ($method == "GET") LoginController::loginForm();
        else ViewHelper::error405();
    }, "/^logout$/" => function ($method) {
        if ($method == "GET") LoginController::logout();
        else ViewHelper::error405();
    }, "/^ElektronskiIndeks$/" => function ($method) {
        if ($method == "GET") StudentController::elektronskiIndeksForm();
        else ViewHelper::error405();
    }, "/^PregledIzpitovStudent$/" => function ($method) {
        if ($method == "GET") StudentController::PregledIzpitovStudentForm();
        else ViewHelper::error405();
    }, "/^PregledIzpitovProfesor$/" => function ($method) {
        if ($method == "GET") ProfesorController::PregledIzpitovProfesorForm();
        else ViewHelper::error405();
    }, "/^VnosIzpitov$/" => function ($method) {
        if ($method == "GET") ProfesorController::VnosIzpitovForm();
        else ViewHelper::error405();
    }, "/^VnosOcen$/" => function ($method) {
        if ($method == "GET") ProfesorController::VnosOcenForm();
        else ViewHelper::error405();
    }, "/^OsebniPodatkiStudenta$/" => function ($method) {
        if ($method == "GET") AdminController::PregledOsebnihPodatkovStudenta();
        else ViewHelper::error405();
    }, "/^OsebniPodatkiStudenta\/vpisnaSearch$/" => function ($method) {
        if ($method == "POST") AdminController::searchByVpisna();
        else ViewHelper::error405();
    }, "/^PodatkiIzvajalcev$/" => function ($method) {
        if ($method == "GET") AdminController::PregledPodatkovOIzvajalcih();
        else ViewHelper::error405();
    }, "/^PodatkiIzvajalcev\/subjectSearch$/" => function ($method) {
        if ($method == "POST") AdminController::searchBySubject();
        else ViewHelper::error405();
    }, "/^izpitniRok\/profesor$/" => function ($method) {
        if ($method == "GET") ProfesorController::izpitniRokForm();
        else ViewHelper::error405();
    }, "/^izpitniRok\/referent$/" => function ($method) {
        if ($method == "GET") StudentOfficerController::izpitniRokForm();
        else ViewHelper::error405();
    }, "/^Vzdrzevanjepredmetnika\/dodaj$/" => function ($method) {
        if ($method == "POST") ProfesorController::dodaj();
        else ViewHelper::error405();
    }, "/^Vzdrzevanjepredmetnika$/" => function ($method) {
        if ($method == "GET") ProfesorController::VzdrzevanjePredmetnika();
        else ViewHelper::error405();
    }, "/^DelPredmetnikaAdd$/" => function ($method) {
        if ($method == "POST") SifrantController::addDelPredmetnika();
        else ViewHelper::error405();
    },"/^DelPredmetnikaAll$/" => function ($method) {
        if ($method == "GET") SifrantController::getDelPredmetnika();
        else ViewHelper::error405();
    },"/^DrzavaAdd$/" => function ($method) {
        if ($method == "POST") SifrantController::addDrzava();
        else ViewHelper::error405();
    },"/^DrzavaAll$/" => function ($method) {
        if ($method == "GET") SifrantController::getDrzava();
        else ViewHelper::error405();
    },"/^LetnikAdd$/" => function ($method) {
        if ($method == "POST") SifrantController::addLetnik();
        else ViewHelper::error405();
    },"/^LetnikAll$/" => function ($method) {
        if ($method == "GET") SifrantController::getLetnik();
        else ViewHelper::error405();
    },"/^NacinStudijaAdd$/" => function ($method) {
        if ($method == "POST") SifrantController::addNacinStudija();
        else ViewHelper::error405();
    },"/^NacinStudijaAll$/" => function ($method) {
        if ($method == "GET") SifrantController::getNacinStudija();
        else ViewHelper::error405();
    },"/^ObcinaAdd$/" => function ($method) {
        if ($method == "POST") SifrantController::addObcina();
        else ViewHelper::error405();
    },"/^ObcinaAll$/" => function ($method) {
        if ($method == "GET") SifrantController::getObcina();
        else ViewHelper::error405();
    },"/^OblikaStudijaAdd$/" => function ($method) {
        if ($method == "POST") SifrantController::addOblikaStudija();
        else ViewHelper::error405();
    },"/^OblikaStudijaAll$/" => function ($method) {
        if ($method == "GET") SifrantController::getOblikaStudija();
        else ViewHelper::error405();
    },"/^PostaAdd$/" => function ($method) {
        if ($method == "POST") SifrantController::addPosta();
        else ViewHelper::error405();
    },"/^PostaAll$/" => function ($method) {
        if ($method == "GET") SifrantController::getPosta();
        else ViewHelper::error405();
    },"/^PredmetAdd$/" => function ($method) {
        if ($method == "POST") SifrantController::addPredmet();
        else ViewHelper::error405();
    },"/^PredmetAll$/" => function ($method) {
        if ($method == "GET") SifrantController::getPredmet();
        else ViewHelper::error405();
    },"/^StudijskoLetoAdd$/" => function ($method) {
        if ($method == "POST") SifrantController::addStudijskoLeto();
        else ViewHelper::error405();
    },"/^StudijskoLetoAll$/" => function ($method) {
        if ($method == "GET") SifrantController::getStudijskoLeto();
        else ViewHelper::error405();
    },"/^VrstaVpisaAdd$/" => function ($method) {
        if ($method == "POST") SifrantController::addVrstaVpisa();
        else ViewHelper::error405();
    },"/^VrstaVpisaAll$/" => function ($method) {
        if ($method == "GET") SifrantController::getVrstaVpisa();
        else ViewHelper::error405();
    },
];

foreach ($urls as $pattern => $controller) {
    if (preg_match($pattern, $path, $params)) {
        try {
            $params[0] = $_SERVER["REQUEST_METHOD"];
            $controller(...$params);
        } catch (InvalidArgumentException $e) {
            ViewHelper::error404();
        } catch (Exception $e){
            echo $e;
        }
        exit();
    }
}

ViewHelper::error404();
