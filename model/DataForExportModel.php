<?php

class DataForExportModel
{
    public static function getEmso($id_kandidat){
        $db = DBInit::getInstance();

        $statement = $db -> prepare("
            SELECT s.EMSO
            FROM student AS s 
            WHERE s.id_kandidat = :id_kandidat
        ");

        $statement->bindValue(":id_kandidat", $id_kandidat);
        $statement->execute();
        $result = $statement->fetch();
        return $result;
    }
}