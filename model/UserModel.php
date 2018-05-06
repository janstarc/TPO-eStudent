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

        if($password == $user["GESLO"]){
            unset($user["GESLO"]);
            return $user;
        } else {
            return false;
        }
    }
    
    public static function getUserName($idOseba) {
        $db = DBInit::getInstance();
        $statement = $db->prepare("
            SELECT UPORABNISKO_IME
            FROM OSEBA
            WHERE ID_OSEBA = :idOseba
        ");
        $statement->bindValue(":idOseba", $idOseba);
        $statement->execute();

        $user = $statement->fetch();

        if($user != null){
            return $user["UPORABNISKO_IME"];
        } else {
            return null;
        }
    }

    public static function insertNewCandidate($candidateArray){

        // TODO Fix hardcoded stud_leto!
        $id_stud_leto = 3;
        $db = DBInit::getInstance();

        foreach ($candidateArray as $key => $value){

            if($value['duplikat'] == "NE"){             // Vnasamo NOVEGA kandidata, ki ga se ni bilo v prejsnjih import datotekah

                $id_program = self::getIdProgram($db, $value);

                if($id_program != null){                // Preverimo, ce je program valid
                    $id_oseba = self::insertOseba($db, $value);         // V oseba vstavi --> Ime, Priimek, email, username, geslo, vrsta_vloge, tel
                    self::insertKandidat($db, $id_program, $id_oseba, $id_stud_leto, $value['vpisna']);   // V kandidat vstavi id_program, id_oseba, id_stud_leto, izkoriscen to 0
                }

            } else if ($value['duplikat'] == "DA" && $value['update'] == "DA"){         // Gre za posodobitev vnosa

                $id_program = self::getIdProgram($db, $value);

                if($id_program != null){                // Preverimo, ce je program valid
                    self::updateKandidatData($db, $value);
                }
            }
        }
    }

    public static function insertKandidat($db, $id_program, $id_oseba, $id_stud_leto, $vpisna_stevilka){

        $statement = $db->prepare("
            INSERT INTO `kandidat`(`id_program`, `id_oseba`, `id_stud_leto`, `izkoriscen`, `vpisna_stevilka`)
                VALUES (:id_program, :id_oseba, :id_stud_leto, 0, :vpisna_stevilka)
        ");

        $statement->bindValue(":id_program", $id_program);
        $statement->bindValue(":id_oseba", $id_oseba);
        $statement->bindValue(":id_stud_leto", $id_stud_leto);
        $statement->bindValue(":vpisna_stevilka", $vpisna_stevilka);

        $statement->execute();
    }

    public static function insertOseba($db, $value){

        $statement = $db->prepare("
           INSERT INTO `oseba`(`ime`, `priimek`, `email`, `uporabnisko_ime`, `geslo`, `vrsta_vloge`, `telefonska_stevilka`)
                VALUES (:ime, :priimek, :email, :uporabnisko_ime, :geslo, 'k', :telefonska_stevilka);
        ");

        $statement->bindValue(":ime", $value['ime']);
        $statement->bindValue(":priimek", $value['priimek']);
        $statement->bindValue(":email", $value['email']);
        $statement->bindValue(":uporabnisko_ime", $value['username']);
        $statement->bindValue(":geslo", $value['password']);
        $statement->bindValue(":telefonska_stevilka", "");
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

    public static function updateKandidatData($db, $value){

        // Update table oseba
        $statement = $db->prepare("
            UPDATE oseba
            SET ime = :ime,
                priimek = :priimek
            WHERE email = :email
        ");

        $statement->bindValue(":ime", $value['ime']);
        $statement->bindValue(":priimek", $value['priimek']);
        $statement->bindValue(":email", $value['email']);
        $statement->execute();


        // Get oseba id from email
        $statement = $db->prepare("
            SELECT id_oseba FROM oseba
            WHERE email = :email
        ");

        $statement->bindValue(":email", $value['email']);
        $statement->execute();
        $result = $statement->fetch();
        $id_oseba = $result['id_oseba'];

        // Get program id
        $id_program = self::getIdProgram($db, $value);

        // Update kandidat
        $statement = $db->prepare("
            UPDATE kandidat
            SET id_program = :id_program
            WHERE id_oseba = :id_oseba
        ");

        $statement->bindValue(":id_oseba", $id_oseba);
        $statement->bindValue(":id_program", $id_program);
        $statement->execute();
    }

    //  sifra_evs --> id_program
    public static function getIdProgram($db, $value){

        $statement = $db->prepare("
            SELECT id_program
            FROM program
            WHERE sifra_evs = :sifra1
        ");

        $statement->bindValue(":sifra1", $value['program']);
        $statement->execute();
        $result = $statement -> fetch();

        return $result['id_program'];
    }

    // null --> all_students
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

    // null --> all_candidates
    public static function getAllCandidates(){

        $db = DBInit::getInstance();

        $statement = $db->prepare(
            "SELECT o.ime, o.priimek, o.email, o.uporabnisko_ime, o.geslo, k.vpisna_stevilka, k.izkoriscen, p.naziv_program, p.id_program, p.sifra_evs, k.izkoriscen
                        FROM kandidat k, program p, oseba o 
                        WHERE k.id_program = p.id_program
                        AND o.id_oseba = k.id_oseba"
        );

        $statement->execute();
        $result = $statement->fetchAll();

        return $result;
    }

    // ime, priimek, email, program --> 0/1 is update?
    public static function isUpdate($value){

        $db = DBInit::getInstance();

        $statement = $db->prepare(
            "SELECT o.id_oseba
                        FROM oseba AS o
                        JOIN kandidat AS k ON k.id_oseba = o.id_oseba
                        JOIN program AS p on p.id_program = k.id_program
                        WHERE o.ime = :ime
                        AND o.priimek = :priimek
                        AND o.email = :email
                        AND p.sifra_evs = :sifra_evs"
        );

        $statement->bindValue(":ime", $value['ime']);
        $statement->bindValue(":priimek", $value['priimek']);
        $statement->bindValue(":email", $value['email']);
        $statement->bindValue(":sifra_evs", $value['program']);
        $statement->execute();

        $result = $statement->fetchAll();
        //var_dump($result);

        if(empty($result)) return 1;
        return 0;
    }

    // Check, if email exists in the DB
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



    //KODA: Pavlin -> dodajanje žetonov novim kandidatom
    // TODO --> Ta funkcija se nikoli ne kliče! --> DELETE???
    public static function insertZeton($id_oseba, $id_program){

        $db = DBInit::getInstance();
        $letnik = 1;
        $leto = 3;
        $nacin = 1;
        $oblika = 1;
        $vrsta = 1;


        $statement = $db->prepare("INSERT INTO `tpo`.`zeton`
            (`ID_OSEBA`,
            `ID_LETNIK`,
            `ID_STUD_LETO`,
            `ID_OBLIKA`,
            `ID_VRSTAVPISA`,
            `ID_NACIN`,
            `ID_PROGRAM`)
            VALUES
            (:oseba,
            :letnik,
            :leto,
            :oblika,
            :vrstaVpisa,
            :nacin,
            :program); ");

        $statement->bindParam(":oseba", $id_oseba);
        $statement->bindParam(":letnik", $letnik);
        $statement->bindParam(":leto", $leto);
        $statement->bindParam(":oblika", $oblika);
        $statement->bindParam(":vrstaVpisa", $vrsta);
        $statement->bindParam(":nacin", $nacin);
        $statement->bindParam(":program", $id_program);
        $statement->execute();
        return true;

    }

    /*
    public static function insertNewStudent($studentArray) {
        $db = DBInit::getInstance();

        foreach ($studentArray as $key => $value) {

            if($value['duplikat'] == "NE"){
                $id_program = self::getIdProgram($db, $value);

                if($id_program != null){
                    $id_oseba = self::insertOseba($db, $value);
                    self::insertStudent($db, $value, $id_oseba, $id_program);

                    //KODA: Pavlin -> dodajanje žetonov novim kandidatom
                    self::insertZeton( $id_oseba, $id_program);

                    //END: Pavlin
                } else {
                    echo "Program '".$value['program']."' ne obstaja. Vnos od studenta '".$value['ime']." ".$value['priimek']."' naprej je bil prekinjen";
                }
            }

            }

            $count = self::checkIfUserIsUnique($db, $value['username']);
            if ($count != 0) {
                echo "Duplikat vnosa! Uporabnik '" . $value['username'] . "' že obstaja!'";
                return;
            }

            $id_program = self::getIdProgram($db, $value);
            if($id_program == null){
                echo "Program '".$value['program']."' ne obstaja. Vnos od studenta '".$value['ime']." ".$value['priimek']."' naprej je bil prekinjen";
                return;
            }

            // Insert new oseba
            $id_oseba = self::insertOseba($db, $value);
            // Insert new student
            self::insertStudent($db, $value, $id_oseba, $id_program);
       }

    */

    /*
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
    */

    // Add attributes to student with oseba_ID
    // TODO Set ID_KANDIDAT, ID_VPIS and ID_PROGRAM back to NOT NULL!!!
    // TODO Remove randomly generated EMSO

    /*
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
    */
}