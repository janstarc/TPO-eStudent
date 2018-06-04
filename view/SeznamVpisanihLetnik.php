<!DOCTYPE html>

<html lang="en">
<head>
    <?php include("view/includes/head.php"); ?>


    <script>
        $(document).ready( function () {



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

            // Override default sorta s custom sortom
            jQuery.fn.dataTableExt.oSort["slo-desc"] = function (x, y) {
                return sloCompare(y,x);
            };

            jQuery.fn.dataTableExt.oSort["slo-asc"] = function (x, y) {
                return sloCompare(x,y);
            };

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
                <div  class="col-xs-12 col-md-12">

                    <br>
                    <h2>Seznam vpisanih</h2>
                    <form  action="<?= BASE_URL . "steviloVpisanihLetniki/exportCSV" ?>" method="post">
                        <input type="hidden" name="id1" value="<?= $input[0] ?>"/>
                        <input type="hidden" name="id2" value="<?= $input[1] ?>"/>
                        <input type="hidden" name="id3" value="<?= $input[2] ?>"/>

                        <input id="csv" class="btn btn-primary btn-sm"  type="submit" value="Izvozi v CSV"/>
                    </form>
                    <form  action="<?= BASE_URL . "steviloVpisanihLetniki/exportPDF" ?>" method="post">
                        <input type="hidden" name="id1" value="<?= $input[0] ?>"/>
                        <input type="hidden" name="id2" value="<?= $input[1] ?>"/>
                        <input type="hidden" name="id3" value="<?= $input[2] ?>"/>
                        <input id="pdf" class="btn btn-primary btn-sm"  type="submit" value="Izvozi v PDF"/>
                    </form>
                    <br>
                    <p>Študijsko leto: <?= $leto ?></p>
                    <p>Program: <?= $program ?></p>
                    <p>Seznam vpisanih v <?= $letnik ?>. letnik </p>
                    <br>



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
                        <?php
                        $count = 0;
                        foreach ($allData as $row) {
                            $count +=1;
                            $ime = $row["PRIIMEK"]." ". $row["IME"];
                            $arr = [$count,$row["VPISNA_STEVILKA"],$ime,$row["OPIS_VPISA"]];

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
