<!DOCTYPE html>

<html lang="en">
<head>
    <?php include("view/includes/head.php"); ?>
    <?php
    $sitePrijaviNull=true;
    foreach ( $roki as $rok) {
        if($rok["ID_PRIJAVA"]!=NULL){
            $sitePrijaviNull=false;
            break;
        }
    }
    //TODO : HARD-CODED!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    $datum=new DateTime();
    $datum->setDate(2018,05,27);

    $datumString="2018-05-27";

    ?>

    <script>
        //NE BRISI TALE KOD CEPRAV JE ZAKOMENTIRAN !!!
        /*var prijava=function(rokId,zapPolaganje,imePredmet){
            $.ajax({
                type: "POST",
                url:   "student/prijava",
                data: { "rokId": rokId },
                success: function() {
                    $("#alert").removeClass("alert-danger").addClass("alert-success").show();
                    var message = "Prijava uspešna! To bo vaše polaganje številka: "+zapPolaganje+", pri predmetu "+imePredmet;
                    $("#alertContent").text(message);
                    //$("#prijava").removeClass("btn-primary").addClass("btn-default");
                    $("#prijava-"+rokId).prop("disabled",true);
                    $(".prijava:not([disabled])").addClass("d-none");
                    $("#odjava-"+rokId).removeClass("d-none");
                }
            });
        };*/

        var jeDisabled=function(id){
            if(document.getElementById("id")==true){
                return 1;
            }
        }
    </script>

</head>
<body>
<section id="container">
    <?php include("view/includes/menu-links-student.php"); ?>
    <section id="main-content">
        <section class="wrapper">
            <div class="row">

                <div class="col-md-12">
                    <div class="content-panel">
                        <h2><?= $pageTitle ?></h2>
                        <?php if(isset($status)): ?>
                            <div class="alert alert-<?= ($status === "Failure") ? "danger" : (($status === "Success") ? "success" : "info") ?> alert-dismissible" role="alert">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?= $message ?>
                            </div>
                        <?php endif; ?>

                        <div id="alert" class="alert alert-success alert-dismissible" role="alert" style="display: none">
                            <div id="alertContent"></div>
                        </div>

                        <table id="table-subject" class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Predmet</th>
                                <th>Datum</th>
                                <th>Cas</th>
                                <th>Prijava</th>
                                <th>Odjava</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $zapIdx=1;
                            $now=new DateTime();

                            $nacinStudij=StudentController::getNacinStudija();
                            foreach($roki as $i=>$rok):
                                $odjava=0;
                                if(isset($rok["DATUM_ODJAVE"])){
                                   $odjava=$rok["ID_ROK"];

                                }
                                //var_dump($odjava);
                                if(isset($rok["OCENA_IZPITA"])){
                                    continue;
                                }

                                if(new DateTime($rok["DATUM_ROKA"]) <= $datum && !isset($rok["ID_PRIJAVA"])){

                                    continue;
                                }

                                $stejPrijavLetos=StudentController::zapSteviloPrijavLetos($rok["ID_ROK"]);
                                $stejPrijavSkupno=StudentController::zapSteviloPrijavSkupno($rok["ID_ROK"]);


                               // var_dump($rok["IME_PREDMET"].' '. $odjava);

                                $dozvoliPrijava=StudentController::dozvoliPrijava2($roki,$rok["ID_ROK"]);

                                if($rok["VSOTA_OPRAVLJENIH_KREDITNIH_TOCK"] ==60 ){
                                    if(StudentController::postoiPrijavaVoBazata($rok["ID_PREDMET"])==3){
                                        $dozvoliPrijava=-5;
                                    }
                                }
                                else if($rok["VSOTA_OPRAVLJENIH_KREDITNIH_TOCK"] >= 54 && $rok["VSOTA_OPRAVLJENIH_KREDITNIH_TOCK"]<60){
                                    if(StudentController::postoiPrijavaVoBazata($rok["ID_PREDMET"])>0){
                                        if(StudentController::postoiPrijavaVoBazata($rok["ID_PREDMET"])==6){
                                            $dozvoliPrijava=-4;
                                        }
                                        $stejPrijavLetos=$stejPrijavSkupno;
                                    }

                                }else if($rok["VSOTA_OPRAVLJENIH_KREDITNIH_TOCK"] < 54){
                                    if(StudentController::postoiPrijavaVoBazata($rok["ID_PREDMET"])>0){
                                        /*if(StudentController::postoiPrijavaVoBazata($rok["ID_PREDMET"])==3){
                                            $dozvoliPrijava=-5;
                                        }*/
                                        $stejPrijavLetos=$stejPrijavSkupno-3;
                                    }
                                }



                                $date1=date_create($rok["DATUM_ROKA"]);
                                $date2=date_create($datumString);
                                $diff=date_diff($date2,$date1);
                                $diff = $diff->format("%R%a");
                                //var_dump($diff);
                                if( $diff <= 1 ){
                                    // -3 pomeni id_rok!=return hide prijava hide odjava
                                    $dozvoliPrijava=-3;
                                }


                                if($i>0){
                                   $datumPrejsnega=StudentController::findDatumPrejnegaRoka($roki,$rok["ID_ROK"],$rok["ID_PREDMET"]);
                                   $datumPrejsnega=date_create($datumPrejsnega);
                                   $dateTrenutnega=date_create($roki[$i]["DATUM_ROKA"]);


                                   $dateCmp=date_diff($datumPrejsnega,$dateTrenutnega);
                                    $dateCmp = $dateCmp->format("%R%a");

                                   if($dateCmp>=0 && $dateCmp<11){
                                       $dozvoliPrijava=-10;

                                   }
                                }


                                $id_rok=$rok["ID_ROK"];
                                if($dozvoliPrijava==-1){
                                    continue;
                                }
                                ?>
                                <tr>
                                    <td><?=  $zapIdx++ ?></td>
                                    <td><?= $rok['IME_PREDMET'] ?></td>
                                    <td>
                                        <?php
                                        list($y, $m, $d) = explode('-', $rok["DATUM_ROKA"]);
                                        echo $d."-".$m."-".$y;
                                        ?>
                                    </td>
                                    <td><?= $rok['CAS_ROKA'] ?></td>
                                    <td>
                                        <form action="<?= BASE_URL . $formAction . "prijava" ?>" method="post">
                                            <input type="hidden" name="rokId" value="<?= $rok["ID_ROK"] ?>" />
                                            <div class="prijava1">
                                                <?php if($dozvoliPrijava==-10): ?>
                                                    <p>Ni poteklo dovolj časa <br> od prejsnega roka.</p>
                                                <?php endif;?>
                                                <?php if($dozvoliPrijava==-3): ?>
                                                    <p>Potekal je rok za prijavo</p>
                                                <?php endif;?>
                                                <?php if($dozvoliPrijava==-4): ?>
                                                <p>Preseženo skupno <br> št. prijav</p>
                                                <?php endif;?>
                                                <?php
                                                if($dozvoliPrijava==-5): ?>
                                                    <p>Preseženo št. prijav <br> v trenutnem letu</p>
                                                <?php else:
                                                    var_dump($rok["ID_ROK"].' '.$odjava.' '.$dozvoliPrijava);
                                                    ?>
                                                <input id="prijava-<?= $rok["ID_ROK"] ?>" class="btn btn-primary btn-sm prijava <?= ($dozvoliPrijava!=$id_rok && $dozvoliPrijava!=0) ? "d-none" : ""?> " <?= ($dozvoliPrijava==$id_rok && $odjava!=$id_rok) ? "disabled" : ""?> type="submit"  value="Prijavi se"  />
                                                <?php if(($nacinStudij==2) || ($stejPrijavSkupno==$stejPrijavLetos && $stejPrijavSkupno>=3)):?>
                                                        <span class="tooltiptext">PLAČLIV IZPIT <br> LETOS: To je vaše polaganje število: <?= $stejPrijavLetos+1 ?>  in SKUPNO polaganje število <?= $stejPrijavSkupno+ 1?></span>
                                                <?php else: ?>
                                                        <span class="tooltiptext">LETOS: To je vaše polaganje število: <?= $stejPrijavLetos+1 ?>  in SKUPNO polaganje število <?= $stejPrijavSkupno+ 1?></span>
                                                    <?php endif;?>

                                                <?php endif;?>
                                            </div>

                                        </form>

                                    </td>
                                    <td>
                                        <form action="<?= BASE_URL . $formAction . "odjava" ?>" method="post">
                                            <input type="hidden" name="odjava" value="<?= $rok["ID_ROK"] ?>" />
                                            <input id="odjava-<?= $rok["ID_ROK"] ?>" class="btn btn-primary btn-sm <?= $dozvoliPrijava==$id_rok ? "" : "d-none" ?> <?= $odjava==$id_rok ? "d-none" : ""?>" type="submit" value="Odjavi se" />
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </section>
    </section>
</section>
</body>
</html>