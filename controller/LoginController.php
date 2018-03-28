<?php

require_once("model/UserModel.php");
require_once("model/User.php");
require_once("ViewHelper.php");

class LoginController {
    public static function loginForm() {
        if (!User::isLoggedIn()){
            ViewHelper::render("view/LoginViewer.php", [
                "formAction" => "login"
            ]);
        }else{
            ViewHelper::render("view/DisplayMessageViewer.php", [
                "typeOfUser" => User::getTypeOfUser(),
                "status" => "Failure",
                "message" => "You are already logged in. If you want to log in as another user, please log out first and try again."
            ]);
        }
    }
    
    public static function login() {
        $data = filter_input_array(INPUT_POST, [
            "email" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "password" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);
        $user = UserModel::getUser($data["email"], $data["password"]);
        
        $errorMessage =  empty($data["email"]) || empty($data["password"]) || $user == null ? "Invalid email or password." : "";
        if (empty($errorMessage)) {
            User::login($user);
            // TODO: redirect OR render based on type of user
            if (User::isLoggedInAsProfessor()) {
                ViewHelper::redirect(BASE_URL . "PregledIzpitovProfesor");
            } else if (User::isLoggedInAsStudent()) {
                ViewHelper::redirect(BASE_URL . "PregledIzpitovStudent");
            }
        } else {
            ViewHelper::render("view/LoginViewer.php", [
                "errorMessage" => $errorMessage,
                "formAction" => "login"
            ]);
        }
    }
    
    public static function logout() {
        User::logout();
        ViewHelper::redirect(BASE_URL . "login");
    }
}