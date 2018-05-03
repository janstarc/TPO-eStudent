<?php

require_once "Mail.php"; // Pear Mail Library
require_once("model/UserModel.php");
require_once("model/User.php");
require_once("ViewHelper.php");

class LoginController {
    public static function checkValues($input) {
        if (empty($input)) {
            return FALSE;
        }
        $result = TRUE;
        foreach ($input as $value) {
            $result = $result && $value != false;
        }
        return $result;
    }
    
    public static function dashboardForm() {
        if (User::isLoggedInAsAdmin()) {
            ViewHelper::render("view/DashboardViewer.php", [
                "typeOfUser" => "admin"
            ]);
        } else if (User::isLoggedInAsProfessor()) {
            ViewHelper::render("view/DashboardViewer.php", [
                "typeOfUser" => "professor"
            ]);
        } else if (User::isLoggedInAsStudent()) {
            ViewHelper::render("view/DashboardViewer.php", [
                "typeOfUser" => "student"
            ]);
        } else if (User::isLoggedInAsStudentOfficer()){
            ViewHelper::render("view/DashboardViewer.php", [
                "typeOfUser" => "student-officer"
            ]);
        }
    }
    
    public static function loginForm($status = null, $message = null) {
        if (!User::isLoggedIn()){
            ViewHelper::render("view/LoginViewer.php", [
                "formAction" => "login",
                "status" => $status,
                "message" => $message
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
        
        if (self::checkValues($data)) {
            $user = UserModel::getUser($data["email"], $data["password"]);
            if ($user != null) {
                User::login($user);
                ViewHelper::redirect(BASE_URL);
            } else {
                self::loginForm("Failure", "Napaka, napacen email ali geslo. Poskusite znova.");
            }
        } else {
            self::loginForm("Failure", "Napaka, vnos ni veljaven. Poskusite znova.");
        }
    }
    
    public static function logout() {
        User::logout();
        ViewHelper::redirect(BASE_URL . "login");
    }
    
    public static function forgottenPasswordForm($status = null, $message = null) {
        if (!User::isLoggedIn()){
            ViewHelper::render("view/ForgottenPasswordViewer.php", [
                "formAction" => "forgottenPassword",
                "status" => $status,
                "message" => $message
            ]);
        }else{
            ViewHelper::render("view/DisplayMessageViewer.php", [
                "status" => "Failure",
                "message" => "You are already logged in. If you want to receive an email to reset your password, please log out first and try again."
            ]);
        }
    }

    public static function forgottenPassword() {
        $data = filter_input_array(INPUT_POST, [
            "email" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);

        if (self::checkValues($data)) {
            if (UserModel::checkEmail($data["email"])) {
                $token =  strtr(base64_encode(openssl_random_pseudo_bytes(30)), "+/=", "XYZ");
                $url = $_SERVER['HTTP_HOST'] . BASE_URL . "resetPassword?token=" . $token;
                $from = '<app.tpo@gmail.com>';
                $to = '<' . $data["email"] . '>';
                $subject = '[TPO] Reset your password';
                
                $headers = array(
                    'From' => $from,
                    'To' => $to,
                    'Subject' => $subject,
                    'MIME-Version' => 1,
                    'Content-type' => 'text/html; charset=UTF-8'
                );
                
                // TODO: change to https protocol in production
                $body = "Hi,<br><br>You've recently asked to reset your password. You can use the following link to reset it:" .
                    "<br><br><a href=http://" . $url . " target='_blank'>http://" . $url . "</a><br><br>" .
                    "If you don't use this link within 1 hour, it will expire.<br>" .
                    "If you didn't ask us to reset your password, you can ignore this email.<br><br>" .
                    "Regards,<br>TPO team.";
                
                $smtp = Mail::factory('smtp', array(
                    'host' => 'ssl://smtp.gmail.com',
                    'port' => '465',
                    'auth' => true,
                    'username' => 'app.tpo@gmail.com',
                    'password' => 'HiB9W0Xg6pxb2VqX'
                ));
                
                $mail = $smtp->send($to, $headers, $body);
                
                if (!PEAR::isError($mail)) {
                    $data["token"] = $token;
                    $data["expiration"] = mktime(date("H")+1, date("i"), date("s"), date("m"), date("d"), date("Y"));
                    UserModel::saveToken($data);
                    ViewHelper::render("view/DisplayMessageViewer.php", [
                        "status" => "Success",
                        "message" => "Email je bil uspesno poslan."
                    ]);
                } else {
                    //echo('<p>' . $mail->getMessage() . '</p>');
                    self::loginForm("Failure", "Napaka, email ni bil uspesno poslan. Poskusite znova.");
                }
            } else {
                self::loginForm("Failure", "Napaka, email naslov ne obstaja. Poskusite znova.");
            }
        } else {
            self::loginForm("Failure", "Napaka, vnos ni veljaven. Poskusite znova.");
        }
    }

    public static function resetPasswordForm() {
        $data = filter_input_array(INPUT_GET, [
            "token" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);
        
        if (self::checkValues($data)) {
            if (!User::isLoggedIn()){
                $data["expiration"] = mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y"));
                if (UserModel::checkToken($data)) {
                    ViewHelper::render("view/ResetPasswordViewer.php", [
                        "formAction" => "resetPassword"
                    ]);
                } else {
                    self::forgottenPasswordForm("Failure", "Napaka, zeton ne obstaja, je bil ze enkrat uporabljen ali je potekel. Poskusite znova.");
                }
            }else{
                ViewHelper::render("view/DisplayMessageViewer.php", [
                    "status" => "Failure",
                    "message" => "You are already logged in. If you want to reset your password, please log out first and try again."
                ]);
            }
        } else {
            self::forgottenPasswordForm("Failure", "Napaka, zeton ni v veljaven format. Poskusite znova.");
        }
    }

    public static function resetPassword() {
        $data = filter_input_array(INPUT_POST, [
            "token" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "new-password" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "retype-password" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);
        
        if (self::checkValues($data)) {
            if ($data["new-password"]==$data["retype-password"]) {
                UserModel::changePasswordUsingToken($data);
                self::loginForm("Success", "Uspesno ste spremenili geslo svojega profila.");
            } else {
                ViewHelper::render("view/DisplayMessageViewer.php", [
                    "status" => "Failure",
                    "message" => "Napaka, gesla niso enaka. Odprite link ki ste dobili na email se enkrat."
                ]);
            }
        } else {
            ViewHelper::render("view/DisplayMessageViewer.php", [
                "status" => "Failure",
                "message" => "Napaka, vnos ni veljaven. Poskusite znova."
            ]);
        }
    }
}