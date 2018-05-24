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
    $datum->setDate(2017,12,27);

    $datumString="2017-12-27";

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
                            //var_dump($roki);
                            // echo "<br>";
                            $nacinStudij=StudentController::getNacinStudija();
                            var_dump($nacinStudij);
                            foreach($roki as $i=>$rok):

                                if(isset($rok["OCENA_IZPITA"])){
                                    continue;
                                }

                                $stejPrijavLetos=StudentController::zapSteviloPrijavLetos($rok["ID_ROK"]);
                                $stejPrijavSkupno=StudentController::zapSteviloPrijavSkupno($rok["ID_ROK"]);
                                //var_dump($stejPrijavSkupno);
                                if(new DateTime($rok["DATUM_ROKA"]) <= $datum && !isset($rok["ID_PRIJAVA"])){
                                    continue;
                                }

                                $vsePrijavljenihRokeLetos=StudentController::vsehprijavljenihRokovLetos($rok["ID_ROK"]);
                                $dozvoliPrijava=StudentController::dozvoliPrijava2($roki,$rok["ID_ROK"]);
                                //var_dump($stejPrijavSkupno);
                               // var_dump($rok["VSOTA_OPRAVLJENIH_KREDITNIH_TOCK"]);
                                if($rok["VSOTA_OPRAVLJENIH_KREDITNIH_TOCK"] >= 54 && $rok["VSOTA_OPRAVLJENIH_KREDITNIH_TOCK"]<60){
                                    if(StudentController::postoiPrijavaVoBazata($rok["ID_PREDMET"])){
                                        $stejPrijavLetos=$stejPrijavSkupno;
                                        if($stejPrijavSkupno>=6){
                                            $dozvoliPrijava=-4;
                                        }
                                    }

                                }else if($vsePrijavljenihRokeLetos>=3 || $stejPrijavSkupno>=6){
                                    $dozvoliPrijava=-4;
                                }
                                //var_dump($dozvoliPrijava);
                                $date1=date_create($rok["DATUM_ROKA"]);
                                $date2=date_create($datumString);
                                $diff=date_diff($date2,$date1);
                                //echo $diff->format("%R%a days");
                                //var_dump($diff);
                                $diff = $diff->format("%R%a");
                                if( $diff <= 2 ){
                                    // -3 pomeni id_rok!=return hide prijava hide odjava
                                    $dozvoliPrijava=-3;
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
                                                <?php if($dozvoliPrijava==-4): ?>
                                                <p>Preseženo št. prijav</p>
                                                <?php else: ?>
                                                <input id="prijava-<?= $rok["ID_ROK"] ?>" class="btn btn-primary btn-sm prijava <?= ($dozvoliPrijava!=$id_rok && $dozvoliPrijava!=0) ? "d-none" : ""?>" <?= $dozvoliPrijava==$id_rok ? "disabled" : ""?>  type="submit"  value="Prijavi se"  />
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
                                            <input type="hidden" name="rokId" value="<?= $rok["ID_ROK"] ?>" />
                                            <input id="odjava-<?= $rok["ID_ROK"] ?>" class="btn btn-primary btn-sm <?= $dozvoliPrijava==$id_rok ? "" : "d-none" ?>" type="submit" value="Odjavi se" />
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