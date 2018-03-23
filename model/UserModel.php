<?php

require_once "DBInit.php";

class UserModel {
/*  For creating passwords, use: http://php.net/manual/en/function.password-hash.php
    For checking passwords, use: http://php.net/manual/en/function.password-verify.php */
    
    public static function getUser($email, $password) {
        $db = DBInit::getInstance();
        
        // TODO: db schema is not created yet
        $statement = $db->prepare("
            SELECT uid, email, password, type
            FROM User
            WHERE email = :email
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