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
                        "bSortable": true,
                        "sType":"slo"
                    }, {
                        "sClass": "center",
                        "bSortable": true,
                        "sType": "slo"
                    }, {
                        "sClass": "center",
                        "bSortable": true,
                        "sType":"slo"
                    },{
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
            <?php include("view/includes/menu-links-professor.php"); ?>
            <section id="main-content">
                <section class="wrapper">
                    <h3>
                        Ime studenta (Vpisna stevilka)
                    </h3>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="content-panel">
                                <hr>
                                <table id="table-izpitov" class="table table-striped table-advance table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Letnik</th>
                                            <th>Predmet</th>
                                            <th>Izvajalec</th>
                                            <th>Datum</th>
                                            <th>Prijava/Odjava</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                                <!--<button class="btn btn-primary btn-xs">Prijavi se</button>-->
                                        </tr>
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