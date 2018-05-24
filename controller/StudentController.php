<?php

require_once("model/UserModel.php");
require_once("model/DataForExportModel.php");
require_once("model/PrijavaModel.php");
require_once("model/User.php");
require_once("ViewHelper.php");
require_once ("view/includes/tfpdf.php");


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
        //Osebni podatki
        $header = array('Ime', 'Priimek', 'Email', 'EMŠO','Telefon','Državljanstvo');
        $lineData = array($studData['ime'], $studData['priimek'], $studData['email'], $emso['EMSO'], $studData['telefonska_stevilka'],"Slovenija");

        //Naslov za vrocanje in stalni naslov
        $naslove=KandidatModel::getOsebaVseNaslove($studentId);
        $header1 = array('Ulica', 'Hišna številka', 'Kraj','Poštna številka');
        foreach ($naslove as $key => $value) {
            if ($value['JE_STALNI'] == 1) {
                $naslovStalnegaBivalisca=array($value['ULICA'],$value['HISNA_STEVILKA'],$value['KRAJ'],$value['ST_POSTA']);
            }

            if ($value['JE_ZAVROCANJE'] == 1) {
                $naslovPrejemanje=array($value['ULICA'],$value['HISNA_STEVILKA'],$value['KRAJ'],$value['ST_POSTA']);
            }
        }



        //Podatki o vpisu
        $vpisData=DataForExportModel::getVpisPodatki($studentId);
        $studLetoVpisna=DataForExportModel::getStudijskoLetoAndVpisna($studentId);
        $username=$studData['uporabnisko_ime'];
        $header2=array('Štidijski program','Študijsko leto','Vpisna Številka','Uporabniško ime');
        $lineData2=array($vpisData['NAZIV_PROGRAM'],$studLetoVpisna['STUD_LETO'],$studLetoVpisna['VPISNA_STEVILKA'],$username);

        //Predmetnik
        $header3=array('Ime predmeta','Šifra predmeta','KT','Izvajalec');
        $imena=array();
        $lineData3=array();
        $sifre=array();
        $izvajalec=array();

        $predmete=DataForExportModel::getPredmete($studLetoVpisna['STUD_LETO'],$vpisData['ID_PROGRAM'],$studLetoVpisna['ID_LETNIK']);

        for($i=0; $i<count($predmete);$i++){
            $imena[$i]=$predmete[$i]['IME_PREDMET'];
            $sifre[$i]=$predmete[$i]['ID_PREDMET'];
            $lineData3[$i]=$predmete[$i]['ST_KREDITNIH_TOCK'];
            $getIzvajalec=DataForExportModel::getIzvajalec($sifre[$i],$studLetoVpisna['STUD_LETO']);

            $izvajalec[$i]=$getIzvajalec["IME"] . " " . $getIzvajalec["PRIIMEK"];
        }

        $pdf= new tFPDF();
        $pdf->AddPage();
        $pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);


        $pdf->SetFont('DejaVu','',30);
        $pdf->Cell(200,50,'VPISNI LIST ',0,0,'C');
        $pdf->Ln();

        $pdf->SetFont('DejaVu','',15);
        $pdf->Cell(80,10,'Osebni podatki študenta',0,0,'C');
        $pdf->Cell(100,10,'Naslov za vročanje',0,0,'C');
        $pdf->Ln();
        $pdf->SetFont('DejaVu','',8);
        $pdf->BasicTable3($header,$lineData,$header1,$naslovPrejemanje);
        $pdf->Ln();

        $pdf->SetFont('DejaVu','',15);
        $pdf->Cell(80,10,'Podatki o vpisu',0,0,'C');
        $pdf->Cell(100,10,'Stalni naslov',0,0,'C');
        $pdf->Ln();
        $pdf->SetFont('DejaVu','',8);
        $pdf->BasicTable3($header2,$lineData2,$header1,$naslovStalnegaBivalisca);
        $pdf->Ln();
        $pdf->Ln();

        $pdf->SetFont('DejaVu','',15);
        $pdf->Cell(180,10,'Predmetnik študenta',0,0,'C');
        $pdf->Ln();
        $pdf->SetFont('DejaVu','',8);
        $pdf->BasicTable2($header3,$imena,$lineData3,$sifre,$izvajalec);

        $pdf->Output();

        $filename="data.pdf";
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
    }

    public static function exportPDF6($id){
        $studentId = KandidatModel::getKandidatIdWithUserId($id);
        $studData = KandidatModel::getKandidatPodatki($studentId);
        $emso=DataForExportModel::getEmso($studentId);
        //Osebni podatki
        $header = array('Ime', 'Priimek', 'Email', 'EMŠO','Telefon','Državljanstvo');
        $lineData = array($studData['ime'], $studData['priimek'], $studData['email'], $emso['EMSO'], $studData['telefonska_stevilka'],"Slovenija");

        //Naslov za vrocanje in stalni naslov
        $naslove=KandidatModel::getOsebaVseNaslove($studentId);
        $header1 = array('Ulica', 'Hišna številka', 'Kraj','Poštna številka');
        foreach ($naslove as $key => $value) {
            if ($value['JE_STALNI'] == 1) {
                $naslovStalnegaBivalisca=array($value['ULICA'],$value['HISNA_STEVILKA'],$value['KRAJ'],$value['ST_POSTA']);
            }

            if ($value['JE_ZAVROCANJE'] == 1) {
                $naslovPrejemanje=array($value['ULICA'],$value['HISNA_STEVILKA'],$value['KRAJ'],$value['ST_POSTA']);
            }
        }



        //Podatki o vpisu
        $vpisData=DataForExportModel::getVpisPodatki($studentId);
        $studLetoVpisna=DataForExportModel::getStudijskoLetoAndVpisna($studentId);
        $username=$studData['uporabnisko_ime'];
        $header2=array('Štidijski program','Študijsko leto','Vpisna Številka','Uporabniško ime');
        $lineData2=array($vpisData['NAZIV_PROGRAM'],$studLetoVpisna['STUD_LETO'],$studLetoVpisna['VPISNA_STEVILKA'],$username);

        //Predmetnik
        $header3=array('Ime predmeta','Šifra predmeta','KT','Izvajalec');
        $imena=array();
        $lineData3=array();
        $sifre=array();
        $izvajalec=array();

        $predmete=DataForExportModel::getPredmete($studLetoVpisna['STUD_LETO'],$vpisData['ID_PROGRAM'],$studLetoVpisna['ID_LETNIK']);

        for($i=0; $i<count($predmete);$i++){
            $imena[$i]=$predmete[$i]['IME_PREDMET'];
            $sifre[$i]=$predmete[$i]['ID_PREDMET'];
            $lineData3[$i]=$predmete[$i]['ST_KREDITNIH_TOCK'];
            $getIzvajalec=DataForExportModel::getIzvajalec($sifre[$i],$studLetoVpisna['STUD_LETO']);

            $izvajalec[$i]=$getIzvajalec["IME"] . " " . $getIzvajalec["PRIIMEK"];
        }

        $pdf= new tFPDF();
        for($i=0;$i<6;$i++){
            $pdf->AddPage();
            $pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);


            $pdf->SetFont('DejaVu','',30);
            $pdf->Cell(200,50,'VPISNI LIST ',0,0,'C');
            $pdf->Ln();

            $pdf->SetFont('DejaVu','',15);
            $pdf->Cell(80,10,'Osebni podatki študenta',0,0,'C');
            $pdf->Cell(100,10,'Naslov za vročanje',0,0,'C');
            $pdf->Ln();
            $pdf->SetFont('DejaVu','',8);
            $pdf->BasicTable3($header,$lineData,$header1,$naslovPrejemanje);
            $pdf->Ln();

            $pdf->SetFont('DejaVu','',15);
            $pdf->Cell(80,10,'Podatki o vpisu',0,0,'C');
            $pdf->Cell(100,10,'Stalni naslov',0,0,'C');
            $pdf->Ln();
            $pdf->SetFont('DejaVu','',8);
            $pdf->BasicTable3($header2,$lineData2,$header1,$naslovStalnegaBivalisca);
            $pdf->Ln();
            $pdf->Ln();

            $pdf->SetFont('DejaVu','',15);
            $pdf->Cell(180,10,'Predmetnik študenta',0,0,'C');
            $pdf->Ln();
            $pdf->SetFont('DejaVu','',8);
            $pdf->BasicTable2($header3,$imena,$lineData3,$sifre,$izvajalec);



        }


        $pdf->Output();

        $filename="data.pdf";
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
    }

    public static function izpitniRokForm($status = null, $message = null) {



        $IdYear = StudijskoLetoModel::getIdOfYear(CURRENT_YEAR);
        if (User::isLoggedIn()){
            if (User::isLoggedInAsStudent()){
                $IdYear = StudijskoLetoModel::getIdOfYear(CURRENT_YEAR);
                $roki = RokModel::getAllByEnrolledStudent(User::getId(), $IdYear["ID_STUD_LETO"]);
                $vpisna=PrijavaModel::getVpisna(User::getId1());
                $zapPolaganj=PrijavaModel::getZapStPolaganj($vpisna["VPISNA_STEVILKA"]);
                //var_dump($roki);
                if (empty($roki)) {
                    $status = "Info";
                    $message = "Trenutno ni razpisanih izpitne roke.";
                }
                ViewHelper::render("view/IzpitniRokStudent.php", [
                    "pageTitle" => "Seznam vse roke",
                    "roki" => $roki,
                    "formAction" => "izpitniRok/student/",
                    "status" => $status,
                    "message" => $message,
                    "zapPolaganj" => $zapPolaganj
                ]);
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function prijavaNaIzpitu(){
        $data1 = filter_input_array(INPUT_POST, [
            "rokId" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ]);

        if (User::isLoggedIn()){
            if (User::isLoggedInAsStudent()){
                $IdYear = StudijskoLetoModel::getIdOfYear(CURRENT_YEAR);
                $id_predmet = PrijavaModel::getIzpitniRok($IdYear["ID_STUD_LETO"],$data1["rokId"]);
                $vpisna=PrijavaModel::getVpisna(User::getId1());
                $data=PrijavaModel::prijavaAdd($vpisna["VPISNA_STEVILKA"], $data1["rokId"],$id_predmet["ID_PREDMET"]);

                ViewHelper::redirect(BASE_URL . "izpitniRok/student");
            }else{
                ViewHelper::error403();
            }
        }else{
            ViewHelper::error401();
        }
    }

    public static function dozvoliPrijava($roki, $id_rok){

        $trenutniRok = null;

        // Najdi trenutni rok, in ga shrani
        foreach ($roki as $key => $value){
            if($value["ID_ROK"] === $id_rok) {
                $trenutniRok = $value;
                break;
            }
        }


        // Obstaja prijava na trenutni rok, ni se ocene ali je ocena negativna
        if(isset($trenutniRok["ID_PRIJAVA"]) && $trenutniRok["OCENA_IZPITA"] < 6){
            return $trenutniRok["ID_ROK"];
        }

        // Ni prijave na trenutni rok
            // --> Sploh ni prijav na ta predmet
            // --> Obstaja kasnejsa prijava brez ocene
            // --> Obstaja prijava z oceno
        if(!isset($trenutniRok["ID_PRIJAVA"]) && $trenutniRok["OCENA_IZPITA"] < 6){

            if(self::obstajajoPrijave($roki, $trenutniRok["ID_ROK"], $trenutniRok["ID_PREDMET"])){

                if(isset($trenutniRok["OCENA_IZPITA"]) && $trenutniRok["OCENA_IZPITA"] < 6) return 0;
                elseif(!isset($trenutniRok["OCENA_IZPITA"])) return self::najdiIdRoka($roki, $trenutniRok["ID_ROK"], $trenutniRok["ID_PREDMET"]);     // Fail - SHOW ALL
                else return -1;                             // Pass - HIDE ALL
            } else {
                return 0;
            }
        }
        if($trenutniRok["OCENA_IZPITA"] > 5) return -1;

        return -2;          // ERROR
    }

    // Returns ID_ROK, ce obstaja prijava brez ocene
    // Returns -1, ce ne obstaja prijave brez ocene
    public static function najdiIdRoka($rokiTab, $id_rok, $id_predmet){

        foreach($rokiTab as $key => $value){
            if($value["ID_PREDMET"] == $id_predmet && $value["ID_ROK"] != $id_rok){     // Najdi rok tega predmeta
                if(isset($value["ID_PRIJAVA"])){            // Ali obstaja prijava?
                    return $value["ID_ROK"];
                }
            }
        }
        return 0;
    }



    public static function dozvoliPrijava2($roki, $id_rok){
        //var_dump($id_rok);
        //var_dump($roki);

        $trenutniRok = null;

        // Najdi trenutni rok, in ga shrani
        foreach ($roki as $key => $value){
            if($value["ID_ROK"] === $id_rok) {
                $trenutniRok = $value;
                break;
            }
        }

        //var_dump($trenutniRok);
        // Obstaja prijava na trenutni rok, ni se ocene
        if(isset($trenutniRok["ID_PRIJAVA"]) && (!isset($trenutniRok["OCENA_IZPITA"]) || $trenutniRok["OCENA_IZPITA"] < 6)){
            return $trenutniRok["ID_ROK"];
        }

        // Ni prijave na trenutni rok
            // --> Sploh ni prijav na ta predmet
            // --> Obstaja kasnejsa prijava brez ocene
            // --> Obstaja prijava z oceno
        if(!isset($trenutniRok["ID_PRIJAVA"]) && (!isset($trenutniRok["OCENA_IZPITA"]) || $trenutniRok["OCENA_IZPITA"] < 6)){

            if(self::obstajajoPrijave($roki, $trenutniRok["ID_ROK"], $trenutniRok["ID_PREDMET"])){

                $prijavaBrezOcene = self::findPrijavaBrezOcene($roki, $trenutniRok["ID_ROK"], $trenutniRok["ID_PREDMET"]);
                if($prijavaBrezOcene > 0){
                    return $prijavaBrezOcene;           // ID_ROKA je shranjen v $prijavaBrezOcene
                }

                // Prijava brez ocene NE obstaja --> Mora obstajati prijava z oceno
                $ocenaPrijaveZOceno = self::findPrijavaZOceno($roki, $trenutniRok["ID_ROK"], $trenutniRok["ID_PREDMET"]);
                if($ocenaPrijaveZOceno > 5) return -1;
                if($ocenaPrijaveZOceno < 6) return 0;
            } else {
                return 0;           // Sploh ni prijav na ta predmet
            }
        }

        if($trenutniRok["OCENA_IZPITA"] > 5) return -1;
        if($trenutniRok["OCENA_IZPITA"] < 6) return 0;
        return -2;          // ERROR
    }

    // Returns ID_ROK, ce obstaja prijava brez ocene
    // Returns -1, ce ne obstaja prijave brez ocene
    public static function findPrijavaZOceno($rokiTab, $id_rok, $id_predmet){

        foreach($rokiTab as $key => $value){
            if($value["ID_PREDMET"] == $id_predmet && $value["ID_ROK"] != $id_rok){     // Najdi rok tega predmeta
                if(isset($value["ID_PRIJAVA"]) && isset($value["OCENA_IZPITA"])){            // Ali obstaja prijava?
                    return $value["OCENA_IZPITA"];
                }
            }
        }
        return 0;
    }

    // Returns ID_ROK, ce obstaja prijava brez ocene
    // Returns -1, ce ne obstaja prijave brez ocene
    public static function findPrijavaBrezOcene($rokiTab, $id_rok, $id_predmet){

        foreach($rokiTab as $key => $value){
            if($value["ID_PREDMET"] == $id_predmet && $value["ID_ROK"] != $id_rok){     // Najdi rok tega predmeta
                if(isset($value["ID_PRIJAVA"]) && !isset($value["OCENA_IZPITA"])){            // Ali obstaja prijava?
                    return $value["ID_ROK"];
                }
            }
        }
        return 0;
    }

    public static function obstajajoPrijave($rokiTab, $id_rok, $id_predmet){

        foreach($rokiTab as $key => $value){
            if($value["ID_PREDMET"] == $id_predmet && $value["ID_ROK"] != $id_rok){     // Najdi rok tega predmeta
                if(isset($value["ID_PRIJAVA"])){            // Ali obstaja prijava?
                    return true;
                }
            }
        }
        return false;
    }


    public static function zapSteviloPrijavLetos($id_rok){
        $vpisna=PrijavaModel::getVpisna(User::getId1());
        $studLetoPredmet=PrijavaModel::getStudLetoPredmetRok($id_rok);

        $vpisnaSt=$vpisna["VPISNA_STEVILKA"];
        $leto=$studLetoPredmet["ID_STUD_LETO"];
        $predmet=$studLetoPredmet["ID_PREDMET"];

        $countPrijav=PrijavaModel::countZapPrijavLetos($vpisnaSt,$leto,$predmet);
        return $countPrijav;
    }

    public static function zapSteviloPrijavSkupno($id_rok){
        $vpisna=PrijavaModel::getVpisna(User::getId1());
        $studLetoPredmet=PrijavaModel::getStudLetoPredmetRok($id_rok);

        $vpisnaSt=$vpisna["VPISNA_STEVILKA"];
        $predmet=$studLetoPredmet["ID_PREDMET"];

        $countPrijav=PrijavaModel::countZapPrijavSkupno($vpisnaSt,$predmet);
        return $countPrijav;
    }









        /*
        $prijavenIdx=NULL;
        $padnatIdx=NULL;
        $imaPolozen=false;
       // var_dump($tekoven);echo "<br>";
        foreach ($roki as $i=>$rok ){
            var_dump($rok["ID_PREDMET"],$tekoven["ID_PREDMET"]);
            echo "<br>";
            if(($rok["ID_PREDMET"]!=$tekoven["ID_PREDMET"])){
                continue;
            }
            if($rok["ID_PRIJAVA"]!=NULL){
                if($rok["OCENA_IZPITA"] > 5){
                    $imaPolozen=true;
                }else if($rok["OCENA_IZPITA"] <= 5){
                    $padnatIdx=$i;
                }else{
                    $prijavenIdx=$i;
                }

            }

        }
        // var_dump($idx,$prijavenIdx,$padnatIdx,$imaPolozen);echo "<br>";
        if($prijavenIdx!=NULL ){
            if($idx==$prijavenIdx){
                return 2;
            }else{
                return 3;
            }
        }
        if($idx<=$padnatIdx) return 4;
        if($imaPolozen) return 4;

        return 1;
        */

}