<?php

require_once("model/UserModel.php");
require_once("model/DataForExportModel.php");
require_once("model/User.php");
require_once("ViewHelper.php");

class StudentController {
    public static function elektronskiIndeksForm() {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsStudent()){
                ViewHelper::render("view/ElektronskiIndeks.php", []);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }
    
    public static function PregledIzpitovStudentForm() {
        if (User::isLoggedIn()){
            if (User::isLoggedInAsStudent()){
                ViewHelper::render("view/PregledIzpitovStudent.php", []);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function exportPDF($id){
        $studentId = KandidatModel::getKandidatIdWithUserId($id);
        $studData = KandidatModel::getKandidatPodatki($studentId);
        $emso=DataForExportModel::getEmso($studentId);

        $header = array('Ime', 'Priimek', 'Email', 'EMSO','Telefon','Drzavljanstvo');
        $lineData = array($studData['ime'], $studData['priimek'], $studData['email'], $emso, $studData['telefonska_stevilka'],"Slovenija");




      /*  foreach ($studData as $key => $value) {
            if($value['je_stalni'] == 1 ){
                $naslovStalnegaBivalisca= $value['ulica']." ".$value['hisna_stevilka'].", ".$value['st_posta']." ".$value['kraj'];
            }

            if($value['je_zavrocanje'] == 1 ){
                $naslovPrejemanje= $value['ulica']." ".$value['hisna_stevilka'].", ".$value['st_posta']." ".$value['kraj'];
            }
        }

        $lineData = array($value['vpisna_stevilka'], $value['ime'], $value['priimek'], $naslovStalnegaBivalisca,$naslovPrejemanje, $value['telefonska_stevilka'], $value['email']);

        $header2 = array('Letnik','NazivProgram', 'SifraPrograma', 'VrstaVpisa', 'NacinStudija');

        $lineData2=null;
        foreach ($vpisData as $key => $value){
            $lineData2 = array($value['letnik'], $value['naziv_program'], $value['sifra_evs'], $value['opis_vpisa'],$value['opis_nacin']);
        }
*/
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(40,10,'Izpis osebnih podatkov studenta');
        $pdf->Ln();
        $pdf->BasicTable($header,$lineData);
        $pdf->Ln();
        $pdf->Output('I','data.pdf');

        $filename="data.pdf";
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
    }


}