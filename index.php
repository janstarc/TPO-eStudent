<?php

session_start();

require_once("controller/LoginController.php");
require_once("controller/AdminController.php");
require_once("controller/OfficeController.php");
require_once("controller/ProfessorController.php");
require_once("controller/StudentController.php");

define("APP_NAME", "STUDIS");
define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");
define("PROJECT_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php"));
define("IMAGES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/images/");
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/css/");
define("JS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/js/");

$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";
// ROUTER: defines mapping between URLS and controllers
$urls = [
    "/^$/" => function ($method) {
        // TODO: redirect based on type of logged-in user
        if ($method == "GET") ViewHelper::redirect(BASE_URL . "login");
        else ViewHelper::error405();
    }, "/^login$/" => function ($method) {
        if ($method == "POST") LoginController::login();
        else if ($method == "GET") LoginController::loginForm();
        else ViewHelper::error405();
    }, "/^logout$/" => function ($method) {
        if ($method == "GET") LoginController::logout();
        else ViewHelper::error405();
    }
];

foreach ($urls as $pattern => $controller) {
    if (preg_match($pattern, $path, $params)) {
        try {
            $params[0] = $_SERVER["REQUEST_METHOD"];
            $controller(...$params);
        } catch (InvalidArgumentException $e) {
            ViewHelper::error404();
        } catch (Exception $e) {
            //ViewHelper::displayError($e, true);
            echo $e;
        }
        exit();
    }
}

ViewHelper::error404();
