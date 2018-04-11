<?php

require_once "DBInit.php";

class UserModel {
/*  For creating passwords, use: http://php.net/manual/en/function.password-hash.php
    For checking passwords, use: http://php.net/manual/en/function.password-verify.php */
    
    public static function getUser($email, $password) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT ID_OSEBA, EMAIL, GESLO, VRSTA_VLOGE
            FROM OSEBA
            WHERE EMAIL = :email
        ");

        $statement->bindValue(":email", $email);
        $statement->execute();

        $user = $statement->fetch();
        // TODO Change if statement when password hashing is added!
        //if (password_verify($password, $user["GESLO"])) {
        if($password == $user["GESLO"]){
            unset($user["GESLO"]);
            return $user;
        } else {
            return false;
        }
    }

    /*
     BEGIN;
     INSERT INTO users (username, password)
       VALUES('test', 'test');
     INSERT INTO profiles (userid, bio, homepage)
       VALUES(LAST_INSERT_ID(),'Hello world!', 'http://www.stackoverflow.com');
     COMMIT;
     */

    public static function insertNewStudent($studentArray){
        $db = DBInit::getInstance();

        var_dump($studentArray);


        foreach ($studentArray as $key => $value){


        }


        $statement = $db->prepare("
           BEGIN;
           INSERT INTO `oseba`(`ime`, `priimek`, )
                VALUES 
           COMMIT;
        ");

    }
}