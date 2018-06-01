<!DOCTYPE html>

<html lang="en">
<head>

    <?php
    require_once("view/includes/head.php");
    require_once("controller/ProfessorController.php")

    ?>

    <script>
        $(document).ready( function () {

            // Override default sorta s custom sortom
            jQuery.fn.dataTableExt.oSort["slo-desc"] = function (x, y) {
                return sloCompare(y,x);
            };

            jQuery.fn.dataTableExt.oSort["slo-asc"] = function (x, y) {
                return sloCompare(x,y);
            };

            var oTable = $("#table-izpitov").DataTable({
                // Custom definicije za vsak stolpec
                "aoColumns": [{
                    "sClass": "center",
                    "bSortable": false
                }, {
                    "sClass": "center",
                    "bSortable": true,
                    "sType":"slo"
                }, {
                    "sClass": "center",
                    "bSortable": false
                }],
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
    <?php include("view/includes/menu-links-admin.php"); ?>
    <section id="main-content">
        <section class="wrapper">
            <div class="row">
                <div class="col-md-12">
                    <div class="content-panel">
                        <br>
                        <br>
                        <div>
                            <h3>Izbira predmeta</h3></div>
                        <table id="table-izpitov" class="table table-striped table-advance table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ime predmeta</th>
                                    <th>Uredi</th>
                                </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <?php
                                    foreach ($data as $row):
                                ?>
                                <td></td>
                                <td><?= $row["IME_PREDMET"]." (".$row["ID_PREDMET"].")"?></td>
                                <td>
                                    <form class=example2  action="<?= BASE_URL . "predmet" ?>" method='post'>
                                        <input type="hidden" name="idPredmet" value="<?= $row["ID_PREDMET"] ?>" />
                                        <button type=submit >Uredi</button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                                endforeach;
                            ?>
                            </tbody>
                        </table>

                    </div>
                    <hr>
                    <form class=example2  action="<?= BASE_URL . "PredmetAdd" ?>" method='get'>
                        <input type="hidden" name="id" value="<?= $row["ID_PREDMET"] ?>" />
                        <button type=submit >Dodaj nov predmet</button>
                    </form>
                </div>
            </div>
            </div>
            </div>
        </section>
    </section>
</section>

</body>
</html>



