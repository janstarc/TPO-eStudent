<?php
?>
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

            var oTable = $("#table-success").DataTable({
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
                    "bSortable": true,
                    "sType":"slo"
                }, {
                    "sClass": "center",
                    "bSortable": true,
                    "sType":"slo"
                }, {
                    "sClass": "center",
                    "bSortable": true,
                    "sType":"slo"
                }, {
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
                },{
                    "sClass": "center",
                    "bSortable": true,
                    "sType":"slo"
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
                        <hr>
                        <h5>Vnos uspešen!</h5>
                        <h4>Pregled vseh kandidatov za vpis</h4>
                        <br>
                        <br>
                        <br>
                        <table id="table-success" class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Ime</th>
                                <th>Priimek</th>
                                <th>Email</th>
                                <th>Uporabniško ime</th>
                                <th>Vpisna</th>
                                <th>Izkoriscen</th>
                                <th>ID Program</th>
                                <th>Naziv program</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($result as $key => $value){
                                echo "<tr>".
                                    "<td></td>".
                                    "<td>".$value['ime']."</td>".
                                    "<td>".$value['priimek']."</td>".
                                    "<td>".$value['email']."</td>".
                                    "<td>".$value['uporabnisko_ime']."</td>".
                                    "<td>".$value['vpisna_stevilka']."</td>".
                                    "<td>".$value['izkoriscen']."</td>".
                                    "<td>".$value['id_program']."</td>".
                                    "<td>".$value['naziv_program']."</td>".
                                    "</tr>";
                            }
                            ?>
                            </tbody>

                        </table>
                        <form action="<?= BASE_URL . "OsebniPodatkiStudenta"?>" method="GET">
                            <button type="submit">OK</button>
                        </form>

                    </div>
                </div>

            </div>
        </section>
    </section>
</section>
</body>
>>>>>>> Stashed changes
</html>
