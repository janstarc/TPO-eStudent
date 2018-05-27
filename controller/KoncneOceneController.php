<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 23.5.2018
 * Time: 19:54
 */

require_once ("view/includes/tfpdf.php");

class KoncneOceneController
{
    public static function exportCSV($id_stud_leto){
        $data = filter_input_array(INPUT_POST, [
            "id_predmet" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);

        $predmet=PredmetModel::getPredmetIme($data["id_predmet"])." (".PredmetModel::getPredmetSifra($data["id_predmet"]).")";
        $prijavljeniStudenti = ProfesorDB::getPrijavljeniNaPredmet($data["id_predmet"],$id_stud_leto);
        $stud_leto=StudijskoLetoModel::getIme($id_stud_leto);

        $izvajalciArray = PredmetModel::getPredmetIzvajalci($data["id_predmet"], $id_stud_leto);
        $izvajalciArray = $izvajalciArray[0];

        $izvajalci = "";
        if($izvajalciArray["ID_OSEBA1"] != null) $izvajalci .= $izvajalciArray["IME1"]." ".$izvajalciArray["PRIIMEK1"];
        if($izvajalciArray["ID_OSEBA2"] != null) $izvajalci .= ", ".$izvajalciArray["IME2"]." ".$izvajalciArray["PRIIMEK2"];
        if($izvajalciArray["ID_OSEBA3"] != null) $izvajalci .= ", ".$izvajalciArray["IME3"]." ".$izvajalciArray["PRIIMEK3"];

        $tockeIzpita = ProfesorDB::getTockeIzpita($data["id_predmet"], $id_stud_leto);
        $prijavljeniStudenti = ProfessorController::najdiZadnjoOceno($prijavljeniStudenti, $tockeIzpita);

        $delimiter = ",";
        $filename = "data.csv";
        $f = fopen('php://memory', 'w');


        $text = array("UNIVERZA V LJUBLJANI, FAKULTETA ZA RAČUNALNIŠTVO IN INFORMATIKO");
        fputcsv($f, $text, $delimiter);
        $text = array("Pregled seznama študentov s končnimi ocenami");
        fputcsv($f, $text, $delimiter);
        $text = array("Predmet",$predmet);
        fputcsv($f, $text, $delimiter);
        $text = array("Nosilec predmeta",$izvajalci);
        fputcsv($f, $text, $delimiter);
        $text = array("Študijsko leto",$stud_leto);
        fputcsv($f, $text, $delimiter);


        $fields=array("Vpisna številka","Ime","Priimek","Št. polaganj (skupno)","Št. polaganj (letos)","Točke izpita","Končna ocena");
        fputcsv($f, $fields, $delimiter);

        $zapPolaganj=0;
        $zapPolaganjLetos=0;
        $tocke=0;
        $ocena=0;
        foreach ($prijavljeniStudenti as $key => $value){
            if($value['ZAP_ST_POLAGANJ'] == null){
                $zapPolaganj="Ni vnosa";
            }else {
                $zapPolaganj=$value["ZAP_ST_POLAGANJ"];
            }
            if($value['ZAP_ST_POLAGANJ_LETOS'] == null){
                $zapPolaganjLetos="Ni vnosa";
            }else {
                $zapPolaganjLetos=$value["ZAP_ST_POLAGANJ_LETOS"];
            }
            if($value['TOCKE_IZPITA'] == null){
                $tocke="Ni vnosa";
            }else{
                $tocke=$value["TOCKE_IZPITA"];
            }
            if($value['OCENA'] == null){
                $ocena="Ni vnosa";
            }else{
                $ocena=$value["OCENA"];
            }
            $lineData=array($value["VPISNA_STEVILKA"],$value["IME"],$value["PRIIMEK"], $zapPolaganj,$zapPolaganjLetos, $tocke, $ocena);
            fputcsv($f, $lineData, $delimiter);
        }

        fseek($f, 0);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
        fpassthru($f);

    }

    public static function exportPDF($id_stud_leto){
        $data = filter_input_array(INPUT_POST, [
            "id_predmet" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);

        $predmet=PredmetModel::getPredmetIme($data["id_predmet"])." (".PredmetModel::getPredmetSifra($data["id_predmet"]).")";
        $prijavljeniStudenti = ProfesorDB::getPrijavljeniNaPredmet($data["id_predmet"],$id_stud_leto);
        $stud_leto=StudijskoLetoModel::getIme($id_stud_leto);

        $izvajalciArray = PredmetModel::getPredmetIzvajalci($data["id_predmet"], $id_stud_leto);
        $izvajalciArray = $izvajalciArray[0];

        $izvajalci = "";
        if($izvajalciArray["ID_OSEBA1"] != null) $izvajalci .= $izvajalciArray["IME1"]." ".$izvajalciArray["PRIIMEK1"];
        if($izvajalciArray["ID_OSEBA2"] != null) $izvajalci .= ", ".$izvajalciArray["IME2"]." ".$izvajalciArray["PRIIMEK2"];
        if($izvajalciArray["ID_OSEBA3"] != null) $izvajalci .= ", ".$izvajalciArray["IME3"]." ".$izvajalciArray["PRIIMEK3"];

        $tockeIzpita = ProfesorDB::getTockeIzpita($data["id_predmet"], $id_stud_leto);
        $prijavljeniStudenti = ProfessorController::najdiZadnjoOceno($prijavljeniStudenti, $tockeIzpita);

        $pdf= new tFPDF();
        $pdf->AddPage('L');
        $pdf->AddFont('DejaVu','','DejaVuSans.ttf',true);

        $pdf->SetFont('DejaVu','',15);
        $pdf->Image('./static/images/logo-ul.jpg', 8, 8, 20, 20, 'JPG');
        $pdf->SetFont('DejaVu','',15);
        $pdf->Cell(200,10,'Univerza v Ljubjani, Fakulteta za računalništvo in informatiko ',0,0,'C');
        $pdf->Ln();
        $tDate=date("Y-m-d");
        $sloDate=ProfessorController::formatDateSlo($tDate);
        $pdf->Cell(0, 10, 'Datum izdaje : '.$sloDate, 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $pdf->Ln();


        $pdf->SetFont('DejaVu','',25);
        $pdf->Cell(250,10,'Pregled seznama študentov s končnimi ocenami',0,0,'C');
        $pdf->Ln();
        $pdf->Ln();

        $pdf->SetFont('DejaVu','',14);
        $pdf->Cell(120,10,'Predmet: ' . $predmet,0);
        $pdf->Ln();
        $pdf->Cell(120,10,'Izvajalec/i: ' . $izvajalci,0);
        $pdf->Ln();
        $pdf->Cell(120,10,'Študijsko leto: ' . $stud_leto,0);
        $pdf->Ln();

        $pdf->SetFont('DejaVu','',8);
        $fields=array("Vpisna številka","Ime","Priimek","Št. polaganj (skupno)","Št. polaganj (letos)","Točke izpita","Končna ocena");

        $pdf->Cell(35, 7, "#", 1);
        foreach($fields as $col) {
            $pdf->Cell(35, 7, $col, 1);

        }
        $pdf->Ln();

        $zapPolaganj=0;
        $zapPolaganjLetos=0;
        $tocke=0;
        $ocena=0;
        foreach ($prijavljeniStudenti as $key => $value) {
            if ($value['ZAP_ST_POLAGANJ'] == null) {
                $zapPolaganj = "Ni vnosa";
            } else {
                $zapPolaganj = $value["ZAP_ST_POLAGANJ"];
            }
            if ($value['ZAP_ST_POLAGANJ_LETOS'] == null) {
                $zapPolaganjLetos = "Ni vnosa";
            } else {
                $zapPolaganjLetos = $value["ZAP_ST_POLAGANJ_LETOS"];
            }
            if ($value['TOCKE_IZPITA'] == null) {
                $tocke = "Ni vnosa";
            } else {
                $tocke = $value["TOCKE_IZPITA"];
            }
            if ($value['OCENA'] == null) {
                $ocena = "Ni vnosa";
            } else {
                $ocena = $value["OCENA"];
            }
            $lineData = array($value["VPISNA_STEVILKA"], $value["IME"], $value["PRIIMEK"], $zapPolaganj, $zapPolaganjLetos, $tocke, $ocena);
            $pdf->Cell(35, 7, $key+1, 1);
            foreach($lineData as $col) {
                $pdf->Cell(35, 7, $col, 1);

            }
            $pdf->Ln();
        }

        $pdf->Output();


        $filename="data.pdf";
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
    }


    public static function exportCSVR($id_stud_leto){
        $data = filter_input_array(INPUT_POST, [
            "id_predmet" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);

        $predmet=PredmetModel::getPredmetIme($data["id_predmet"])." (".PredmetModel::getPredmetSifra($data["id_predmet"]).")";
        $prijavljeniStudenti = ProfesorDB::getPrijavljeniNaPredmet($data["id_predmet"],$id_stud_leto);
        $stud_leto=StudijskoLetoModel::getIme($id_stud_leto);

        $izvajalciArray = PredmetModel::getPredmetIzvajalci($data["id_predmet"], $id_stud_leto);
        $izvajalciArray = $izvajalciArray[0];

        $izvajalci = "";
        if($izvajalciArray["ID_OSEBA1"] != null) $izvajalci .= $izvajalciArray["IME1"]." ".$izvajalciArray["PRIIMEK1"];
        if($izvajalciArray["ID_OSEBA2"] != null) $izvajalci .= ", ".$izvajalciArray["IME2"]." ".$izvajalciArray["PRIIMEK2"];
        if($izvajalciArray["ID_OSEBA3"] != null) $izvajalci .= ", ".$izvajalciArray["IME3"]." ".$izvajalciArray["PRIIMEK3"];

        $tockeIzpita = ProfesorDB::getTockeIzpita($data["id_predmet"], $id_stud_leto);
        $prijavljeniStudenti = ProfessorController::najdiZadnjoOceno($prijavljeniStudenti, $tockeIzpita);

        $delimiter = ",";
        $filename = "data.csv";
        $f = fopen('php://memory', 'w');


        $text = array("UNIVERZA V LJUBLJANI, FAKULTETA ZA RAČUNALNIŠTVO IN INFORMATIKO");
        fputcsv($f, $text, $delimiter);
        $text = array("Pregled seznama študentov s končnimi ocenami");
        fputcsv($f, $text, $delimiter);
        $text = array("Predmet",$predmet);
        fputcsv($f, $text, $delimiter);
        $text = array("Nosilec predmeta",$izvajalci);
        fputcsv($f, $text, $delimiter);
        $text = array("Študijsko leto",$stud_leto);
        fputcsv($f, $text, $delimiter);


        $fields=array("Vpisna številka","Ime","Priimek","Št. polaganj (skupno)","Št. polaganj (letos)","Točke izpita","Končna ocena");
        fputcsv($f, $fields, $delimiter);

        $zapPolaganj=0;
        $zapPolaganjLetos=0;
        $tocke=0;
        $ocena=0;
        foreach ($prijavljeniStudenti as $key => $value){
            if($value['ZAP_ST_POLAGANJ'] == null){
                $zapPolaganj="Ni vnosa";
            }else {
                $zapPolaganj=$value["ZAP_ST_POLAGANJ"];
            }
            if($value['ZAP_ST_POLAGANJ_LETOS'] == null){
                $zapPolaganjLetos="Ni vnosa";
            }else {
                $zapPolaganjLetos=$value["ZAP_ST_POLAGANJ_LETOS"];
            }
            if($value['TOCKE_IZPITA'] == null){
                $tocke="Ni vnosa";
            }else{
                $tocke=$value["TOCKE_IZPITA"];
            }
            if($value['OCENA'] == null){
                $ocena="Ni vnosa";
            }else{
                $ocena=$value["OCENA"];
            }
            $lineData=array($value["VPISNA_STEVILKA"],$value["IME"],$value["PRIIMEK"], $zapPolaganj,$zapPolaganjLetos, $tocke, $ocena);
            fputcsv($f, $lineData, $delimiter);
        }

        fseek($f, 0);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
        fpassthru($f);

    }

    public static function exportPDFR($id_stud_leto){
        $data = filter_input_array(INPUT_POST, [
            "id_predmet" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);

        $predmet=PredmetModel::getPredmetIme($data["id_predmet"])." (".PredmetModel::getPredmetSifra($data["id_predmet"]).")";
        $prijavljeniStudenti = ProfesorDB::getPrijavljeniNaPredmet($data["id_predmet"],$id_stud_leto);
        $stud_leto=StudijskoLetoModel::getIme($id_stud_leto);

        $izvajalciArray = PredmetModel::getPredmetIzvajalci($data["id_predmet"], $id_stud_leto);
        $izvajalciArray = $izvajalciArray[0];

        $izvajalci = "";
        if($izvajalciArray["ID_OSEBA1"] != null) $izvajalci .= $izvajalciArray["IME1"]." ".$izvajalciArray["PRIIMEK1"];
        if($izvajalciArray["ID_OSEBA2"] != null) $izvajalci .= ", ".$izvajalciArray["IME2"]." ".$izvajalciArray["PRIIMEK2"];
        if($izvajalciArray["ID_OSEBA3"] != null) $izvajalci .= ", ".$izvajalciArray["IME3"]." ".$izvajalciArray["PRIIMEK3"];

        $tockeIzpita = ProfesorDB::getTockeIzpita($data["id_predmet"], $id_stud_leto);
        $prijavljeniStudenti = ProfessorController::najdiZadnjoOceno($prijavljeniStudenti, $tockeIzpita);

        $pdf= new tFPDF();
        $pdf->AddPage('L');
        $pdf->AddFont('DejaVu','','DejaVuSans.ttf',true);

        $pdf->SetFont('DejaVu','',15);
        $pdf->Cell(200,10,'Univerza v Ljubjani, Fakulteta za računalništvo in informatiko ',0,0,'C');
        $pdf->Ln();
        $pdf->Ln();


        $pdf->SetFont('DejaVu','',25);
        $pdf->Cell(250,10,'Pregled seznama študentov s končnimi ocenami',0,0,'C');
        $pdf->Ln();
        $pdf->Ln();

        $pdf->SetFont('DejaVu','',14);
        $pdf->Cell(120,10,'Predmet: ' . $predmet,0);
        $pdf->Ln();
        $pdf->Cell(120,10,'Izvajalec/i: ' . $izvajalci,0);
        $pdf->Ln();
        $pdf->Cell(120,10,'Študijsko leto: ' . $stud_leto,0);
        $pdf->Ln();

        $pdf->SetFont('DejaVu','',8);
        $fields=array("Vpisna številka","Ime","Priimek","Št. polaganj (skupno)","Št. polaganj (letos)","Točke izpita","Končna ocena");
        foreach($fields as $col) {
            $pdf->Cell(35, 7, $col, 1);

        }
        $pdf->Ln();

        $zapPolaganj=0;
        $zapPolaganjLetos=0;
        $tocke=0;
        $ocena=0;
        foreach ($prijavljeniStudenti as $key => $value) {
            if ($value['ZAP_ST_POLAGANJ'] == null) {
                $zapPolaganj = "Ni vnosa";
            } else {
                $zapPolaganj = $value["ZAP_ST_POLAGANJ"];
            }
            if ($value['ZAP_ST_POLAGANJ_LETOS'] == null) {
                $zapPolaganjLetos = "Ni vnosa";
            } else {
                $zapPolaganjLetos = $value["ZAP_ST_POLAGANJ_LETOS"];
            }
            if ($value['TOCKE_IZPITA'] == null) {
                $tocke = "Ni vnosa";
            } else {
                $tocke = $value["TOCKE_IZPITA"];
            }
            if ($value['OCENA'] == null) {
                $ocena = "Ni vnosa";
            } else {
                $ocena = $value["OCENA"];
            }
            $lineData = array($value["VPISNA_STEVILKA"], $value["IME"], $value["PRIIMEK"], $zapPolaganj, $zapPolaganjLetos, $tocke, $ocena);
            foreach($lineData as $col) {
                $pdf->Cell(35, 7, $col, 1);

            }
            $pdf->Ln();
        }

        $pdf->Output();


        $filename="data.pdf";
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
    }

}