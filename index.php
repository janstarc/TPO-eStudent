<?php

session_start();

require_once("controller/LoginController.php");
require_once("controller/AdminController.php");
require_once("controller/StudentOfficerController.php");
require_once("controller/ProfessorController.php");
require_once("controller/StudentController.php");
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
        // TODO: if already logged in, then redirect based on type of logged-in user
        if ($method == "GET") ViewHelper::redirect(BASE_URL . "login");
        else ViewHelper::error405();
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
    },"/^Vzdrzevanjepredmetnika$/" => function ($method) {
        if ($method == "GET") ProfesorController::VzdrzevanjePredmetnika();
        else ViewHelper::error405();
    }

];

foreach ($urls as $pattern => $controller) {
   // print($path) ;
    //print("<br>");
   // print_r($params);
   // print("<br>");
    if (preg_match($pattern, $path, $params)) {
        try {
     //       print( "begin");
      //      print("<br>");
            $params[0] = $_SERVER["REQUEST_METHOD"];
            $controller(...$params);
       //     print ("end");
        //    print("<br>");
        } catch (InvalidArgumentException $e) {
          //  print_r($e);
          //  print("<br>");
            ViewHelper::error404();
        } catch (Exception $e){
            //ViewHelper::displayError($e, true);
            echo $e;
        }
        exit();
    }
}

ViewHelper::error404();
