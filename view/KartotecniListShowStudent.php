<!DOCTYPE html>

<html lang="en">
<head>
    <?php include("view/includes/head.php"); ?>

    <script>
        <?php $c = -1;
        foreach ($allData as $neki):
        $c+= 1;
        ?>
        $(document).ready( function () {

            // Override default sorta s custom sortom
            jQuery.fn.dataTableExt.oSort["slo-desc"] = function (x, y) {
                return sloCompare(y,x);
            };

            jQuery.fn.dataTableExt.oSort["slo-asc"] = function (x, y) {
                return sloCompare(x,y);
            };

            var oTable = $("#table-subject<?php echo $c; ?>").DataTable({
                // Custom definicije za vsak stolpec
                "aoColumns": [
                    {
                        "sClass": "center",
                        "bSortable": false
                    },{
                        "sClass": "center",
                        "bSortable": true,
                        "sType":"slo"
                    },{
                        "sClass": "center",
                        "bSortable": true,
                        "sType":"slo"
                    },{
                        "sClass": "center",
                        "bSortable": true,
                        "sType":"slo"
                    },{
                        "sClass": "center",
                        "bSortable": true,
                        "sType":"slo"
                    },{
                        "sClass": "center",
                        "bSortable": true,
                        "sType":"slo"
                    },{
                        "sClass": "center",
                        "bSortable": true,
                        "sType":"slo"
                    }, {
                        "sClass": "center",
                        "bSortable": true,
                        "sType":"slo"
                    }
                ],
                // Ordering v prvem stolpcu
                "order": [[ 1, 'asc' ]]
            });

            // Dinamicni ordering, ko se spremeni sort parameter
            oTable.on( 'order.dt search.dt', function () {
                oTable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();
        } );
        <?php endforeach; ?>

        $(document).ready( function () {

            // Override default sorta s custom sortom
            jQuery.fn.dataTableExt.oSort["slo-desc"] = function (x, y) {
                return sloCompare(y,x);
            };

            jQuery.fn.dataTableExt.oSort["slo-asc"] = function (x, y) {
                return sloCompare(x,y);
            };

            var oTable = $("#table-b").DataTable({
                // Custom definicije za vsak stolpec
                "aoColumns": [
                    {
                        "sClass": "center",
                        "bSortable": false
                    },{
                        "sClass": "center",
                        "bSortable": true,
                        "sType":"slo"
                    },{
                        "sClass": "center",
                        "bSortable": true,
                        "sType":"slo"
                    }, {
                        "sClass": "center",
                        "bSortable": true,
                        "sType":"slo"
                    },{
                        "sClass": "center",
                        "bSortable": true,
                        "sType":"slo"
                    }
                ],
                // Ordering v prvem stolpcu
                "order": [[ 1, 'asc' ]]
            });

            // Dinamicni ordering, ko se spremeni sort parameter
            oTable.on( 'order.dt search.dt', function () {
                oTable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();
        } );
    </script>
</head>
<body>
<section id="container">
    <?php
    if($oseba ==1) {
        include("view/includes/menu-links-student-officer.php");
        $pdf = "kartotecniList";
    }
    if($oseba ==2){
        include("view/includes/menu-links-student.php");
        $pdf = "kartotecniList";}
    if($oseba ==3){
        include("view/includes/menu-links-professor.php");
        $pdf = "kartotecniListP";}?>
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
                        <form  action="<?= BASE_URL . "kartotecniList/exportCSV" ?>" method="post">
                            <input type="hidden" name="student" value="<?= $student ?>"/>
                            <input type="hidden" name="pogled" value="<?= $pogled ?>"/>
                            <input type="hidden" name="program" value="<?= $program ?>"/>
                            <input id="csv" class="btn btn-primary btn-sm"  type="submit" value="Izvozi v CSV"/>
                        </form>
                        <form  action="<?= BASE_URL . $pdf ."/exportPDF" ?>" method="post">
                            <input type="hidden" name="student" value="<?= $student ?>"/>
                            <input type="hidden" name="pogled" value="<?= $pogled ?>"/>
                            <input type="hidden" name="program" value="<?= $program ?>"/>
                            <input id="pdf" class="btn btn-primary btn-sm"  type="submit" value="Izvozi v PDF"/>
                        </form>

                        <?php $n = -1;
                        foreach ($allData as $dataGroup):
                            $n += 1; ?>
                        <br>
                        <br>
                        <br>

                            <table id="table-a" class="table table-striped table-advance table-hover">
                                <thead>
                                <tr>
                                    <th>študijsko leto</th>
                                    <th>študijski program</th>
                                    <th>letnik</th>
                                    <th>vrsta vpisa</th>
                                    <th>način študija</th>

                                </tr>
                                </thead>
                                <tbody>

                                <tr>

                                    <td><?php echo $studData[$n]['STUD_LETO']; ?></td>
                                    <td><?php echo $studData[$n]['NAZIV_PROGRAM']; ?></td>
                                    <td><?php echo $studData[$n]['ID_LETNIK']; ?></td>
                                    <td><?php echo $studData[$n]['OPIS_VPISA']; ?></td>
                                    <td><?php echo $studData[$n]['OPIS_NACIN']; ?></td>


                                </tr>

                                </tbody>
                            </table>


                        <table id="table-subject<?php echo $n; ?>" class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Šifra predmeta</th>
                                <th>Ime predmeta</th>
                                <th>st. kreditnih točk</th>
                                <th>Izpraševalec/ci</th>
                                <th>Datum opravljanja izpita</th>
                                <th>št. polaganja</th>
                                <th>Ocena predmeta</th>


                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            foreach($dataGroup as $data):
                                if($data['DATUM_ROKA'] != "/") {
                                    list($d, $m, $y) = explode('-', $data['DATUM_ROKA']);
                                    $datum = $y . "." . $m . "." . $d;
                                }
                                else $datum = "";
                                ?>
                                <tr>
                                    <td></td>
                                    <td><?php echo $data['SIFRA_PREDMET']; ?></td>
                                    <td><?php echo $data['IME_PREDMET']; ?></td>
                                    <td><?php echo $data['ST_KREDITNIH_TOCK']; ?></td>
                                    <td><?php if($datum != "")echo $data['izvajalci']; ?></td>
                                    <td><?php if($datum != "")echo $datum ?></td>
                                    <td><?php if($datum != "")echo $data['ZAP_ST_POLAGANJ']."/".$data['ZAP_ST_POLAGANJ_LETOS']; ?></td>
                                    <td><?php if($datum != "")echo $data['OCENA_IZPITA']; ?></td>



                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php endforeach; ?>
                        <table id="table-b" class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>študijsko leto</th>
                                <th>letnik</th>
                                <th>število doseženih kreditnih točk</th>
                                <th>ocena</th>


                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach($ocene as $data):

                            ?>
                            <tr>
                                <td></td>
                                <td><?php echo $data['STUD_LETO']; ?></td>
                                <td><?php echo $data['ID_LETNIK']; ?></td>
                                <td><?php echo $data['SUM']; ?></td>
                                <td><?php echo $data['AVG']; ?></td>

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
