<?php

require_once "DBInit.php";

class UserModel {
/*  For creating passwords, use: http://php.net/manual/en/function.password-hash.php
    For checking passwords, use: http://php.net/manual/en/function.password-verify.php */
    
    public static function getUser($email, $password) {
        $db = DBInit::getInstance();
        
        $statement = $db->prepare("
            SELECT ID_OSEBA, EMAIL, GESLO, STAT
            FROM OSEBA
            WHERE EMAIL = :email
        ");
        $statement->bindValue(":email", $email);
        $statement->execute();
        
        $user = $statement->fetch();
        if (password_verify($password, $user["password"])) {
            unset($user["password"]);
            return $user;
        } else {
            return false;
        }
    }
}