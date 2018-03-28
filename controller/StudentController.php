<?php

require_once("model/UserModel.php");
require_once("model/User.php");
require_once("ViewHelper.php");

class StudentController {
    public static function elektronskiIndeksForm() {
//        if (User::isLoggedIn()){
//            if (User::isLoggedInAsStudent()){
                ViewHelper::render("view/ElektronskiIndeks.php", []);
/*            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
*/
    }
    
    public static function PregledIzpitovStudentForm() {
//        if (User::isLoggedIn()){
//            if (User::isLoggedInAsStudent()){
                ViewHelper::render("view/PregledIzpitovStudent.php", []);
/*            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
*/
    }
}