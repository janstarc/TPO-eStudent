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

    public static function insertNewStudent($studentArray)
    {
        $db = DBInit::getInstance();

        foreach ($studentArray as $key => $value) {

            if($value['duplikat'] == "NE"){
                $id_program = self::getIdProgram($db, $value);

                if($id_program != null){
                    $id_oseba = self::insertOseba($db, $value);
                    self::insertStudent($db, $value, $id_oseba, $id_program);
                } else {
                    echo "Program '".$value['program']."' ne obstaja. Vnos od studenta '".$value['ime']." ".$value['priimek']."' naprej je bil prekinjen";
                }
            }

            }

            /*
            $count = self::checkIfUserIsUnique($db, $value['username']);
            if ($count != 0) {
                echo "Duplikat vnosa! Uporabnik '" . $value['username'] . "' že obstaja!'";
                return;
            }
            */
            /*
            $id_program = self::getIdProgram($db, $value);
            if($id_program == null){
                echo "Program '".$value['program']."' ne obstaja. Vnos od studenta '".$value['ime']." ".$value['priimek']."' naprej je bil prekinjen";
                return;
            }


            // Insert new oseba
            $id_oseba = self::insertOseba($db, $value);
            // Insert new student
            self::insertStudent($db, $value, $id_oseba, $id_program);
            */



    }


    public static function checkIfUserIsUnique($db, $uporabnisko_ime){
        $statement = $db->prepare("
            SELECT COUNT(uporabnisko_ime) FROM oseba
            WHERE uporabnisko_ime = :uporabnisko_ime;
        ");

        $statement->bindValue(":uporabnisko_ime", $uporabnisko_ime);
        $statement->execute();
        $result = $statement->fetch();

        return $result['COUNT(uporabnisko_ime)'];
    }

    // TODO Remove randomly generated Telefonska Stevilka
    public static function insertOseba($db, $value){

        $statement = $db->prepare("
           INSERT INTO `oseba`(`ime`, `priimek`, `email`, `uporabnisko_ime`, `geslo`, `vrsta_vloge`, `telefonska_stevilka`)
                VALUES (:ime, :priimek, :email, :uporabnisko_ime, :geslo, 's', :telefonska_stevilka);
        ");

        $statement->bindValue(":ime", $value['ime']);
        $statement->bindValue(":priimek", $value['priimek']);
        $statement->bindValue(":email", $value['email']);
        $statement->bindValue(":uporabnisko_ime", $value['username']);
        $statement->bindValue(":geslo", $value['password']);
        $statement->bindValue(":telefonska_stevilka", rand(120000000, 129999999));
        $statement->execute();

        // Get ID from created oseba
        $statement = $db->prepare("
            SELECT id_oseba FROM oseba
            WHERE uporabnisko_ime = :uporabnisko_ime
        ");

        $statement->bindValue(":uporabnisko_ime", $value['username']);
        $statement->execute();
        $result = $statement->fetch();

        return $result['id_oseba'];
    }


    public static function getIdProgram($db, $value){

        // TODO Figure out if sifra_program OR sifra_evs is used in import text files!
        $statement = $db->prepare("
            SELECT id_program
            FROM program
            WHERE sifra_program = :sifra1
            OR sifra_evs = :sifra1
        ");

        $statement->bindValue(":sifra1", $value['program']);
        $statement->execute();
        $result = $statement -> fetch();
        //var_dump($result);

        return $result['id_program'];
    }

    // Add attributes to student with oseba_ID
        // TODO Set ID_KANDIDAT, ID_VPIS and ID_PROGRAM back to NOT NULL!!!
        // TODO Remove randomly generated EMSO
    public static function insertStudent($db, $value, $id_oseba, $id_program){

        $statement = $db->prepare("
            INSERT INTO `student`(`id_oseba`, `vpisna_stevilka`, `id_program`, `emso`)
              VALUES (:id_oseba, :vpisna_stevilka, :id_program, :emso);
        ");

        $statement->bindValue(":id_oseba", $id_oseba);
        $statement->bindValue(":vpisna_stevilka", $value['vpisna']);
        $e1 = rand(1000000, 9999999);
        $e2 = rand(100000, 999999);
        $statement->bindValue(":emso", $e1 . $e2);
        $statement->bindValue(":id_program", $id_program);
        $statement->execute();
    }

    public static function getAllStudents(){

        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT o.ime, o.priimek, o.email, o.uporabnisko_ime, s.vpisna_stevilka, s.id_program, p.naziv_program, p.sifra_evs
            FROM oseba AS o, student AS s, program AS p
            WHERE o.id_oseba = s.id_oseba
            AND s.id_program = p.id_program
            AND o.vrsta_vloge = 's';
        ");

        $statement->execute();
        $result = $statement->fetchAll();

        return $result;
    }
    
    public static function checkEmail($email) {
        $db = DBInit::getInstance();
        
        $statement = $db->prepare("
            SELECT ID_OSEBA 
            FROM oseba 
            WHERE EMAIL = :email
        ");
        $statement->bindValue(":email", $email);
        $statement->execute();
        
        $user = $statement->fetch();
        return ($user != null);
    }

    public static function saveToken(array $params){
        $db = DBInit::getInstance();
        $statement = $db->prepare("
            UPDATE oseba 
            SET resetPwToken = :token, resetPwExpiration = :expiration, resetPwUsed = 0 
            WHERE EMAIL = :email
        ");
        $statement->bindParam(":token", $params["token"]);
        $statement->bindParam(":expiration", $params["expiration"]);
        $statement->bindParam(":email", $params["email"]);
        $statement->execute();
    }
    
    public static function checkToken(array $params){
        $db = DBInit::getInstance();
        $statement = $db->prepare("
            SELECT ID_OSEBA 
            FROM oseba 
            WHERE resetPwToken = :token AND resetPwExpiration > :expiration AND resetPwUsed = 0
        ");
        $statement->bindParam(":token", $params["token"]);
        $statement->bindParam(":expiration", $params["expiration"]);
        $statement->execute();
        $user = $statement->fetch();
        return ($user != null);
    }
    
    public static function changePasswordUsingToken(array $params){
        $db = DBInit::getInstance();
        $statement = $db->prepare("
            UPDATE oseba 
            SET GESLO = :password, resetPwUsed = 1 
            WHERE resetPwToken = :token
        ");
        $statement->bindParam(":token", $params["token"]);
        // TODO: change if password hashing is added
        // $params["new-password"]=password_hash($params["new-password"], PASSWORD_BCRYPT);
        $statement->bindParam(":password", $params["new-password"]);
        $statement->execute();
    }
}