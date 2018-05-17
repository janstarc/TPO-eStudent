<!DOCTYPE html>

<html lang="en">
<head>
    <?php include("view/includes/head.php"); ?>


    <script>
        $(document).ready( function () {

            // Override default sorta s custom sortom
            jQuery.fn.dataTableExt.oSort["slo-desc"] = function (x, y) {
                return sloCompare(y,x);
            };

            jQuery.fn.dataTableExt.oSort["slo-asc"] = function (x, y) {
                return sloCompare(x,y);
            };

            var oTable = $("#table-subject").DataTable({
                // Custom definicije za vsak stolpec
                "aoColumns": [
                    {
                        "sClass": "center",
                        "bSortable": false
                    },
                    {
                        "sClass": "center",
                        "bSortable": true,
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
    <?php include("view/includes/menu-links-student-officer.php"); ?>
    <section id="main-content">
        <section class="wrapper">
            <div class="row">
                <div  class="col-xs-12 col-md-6">
                    <br>
                    <?php $data = [$predmet["ID_PREDMET"],$predmet["IME_PREDMET"],$leto,count($vpisani)]?>
                    <h2>Seznam vpisanih</h2>
                    <form  action="<?= BASE_URL . "VpisaniPrikaz/exportCSV" ?>" method="post">
                        <input type="hidden" name="idLeto" value="<?= $idLeto ?>"/>
                        <input type="hidden" name="idPredmet" value="<?= $idPredmet ?>"/>
                        <input id="csv" class="btn btn-primary btn-sm"  type="submit" value="Izvozi v CSV"/>
                    </form>
                    <form  action="<?= BASE_URL . "VpisaniPrikaz/exportPDF" ?>" method="post">
                        <input type="hidden" name="idLeto" value="<?= $idLeto ?>"/>
                        <input type="hidden" name="idPredmet" value="<?= $idPredmet ?>"/>
                        <input id="pdf" class="btn btn-primary btn-sm"  type="submit" value="Izvozi v PDF"/>
                    </form>

                    <table id="table-izpitov" class="table table-striped table-advance table-hover">
                        <thead>
                        <tr>

                            <th>Šifra predmeta</th>
                            <th>Ime predmeta</th>
                            <th>Študijsko leto</th>
                            <th>Število vpisanih</th>

                        </tr>
                        </thead>
                        <tbody>
                        <tr>

                            <td><?= $predmet["ID_PREDMET"] ?></td>
                            <td><?= $predmet["IME_PREDMET"] ?></td>
                            <th><?= $leto ?></th>
                            <th><?= count($vpisani) ?></th>


                        </tr>
                        </tbody>
                    </table>


                    <table id="table-subject" class="table table-striped table-advance table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Vpisna številka</th>
                            <th>Priimek in ime</th>
                            <th>Vrsta vpisa</th>

                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <?php


                            $count = 0;
                            foreach ($vpisani as $row) {
                            $count +=1;
                            $ime = $row["PRIIMEK"]." ". $row["IME"];
                            $arr = [$count,$row["VPISNA_STEVILKA"],$ime,$row["OPIS_VPISA"]];
                            array_push($data, $arr)
                            ?>
                        <tr>
                            <td><?= $count ?></td>
                            <td><?= $row["VPISNA_STEVILKA"]?></td>
                            <td><?= $ime ?></td>
                            <th><?= $row["OPIS_VPISA"] ?></th>


                        </tr><?php
                        }
                        ?>



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
