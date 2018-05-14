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

                var oTable = $("#table-predmeti").DataTable({
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
            <?php include("view/includes/menu-links-student.php"); ?>
            <section id="main-content">
                <section class="wrapper">
                    <br>
                    <h3>
                        <i>Testni Študent (123456)</i>
                    </h3>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="content-panel">
                                <h4>Elektronski indeks</h4>
                                <hr>
                                <table id="table-predmeti" class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Šifra</th>
                                            <th>Predmet</th>
                                            <th>Ocenil</th>
                                            <th>Letnik</th>
                                            <th>Datum</th>
                                            <th>Opravljanje</th>
                                            <th>ECTS</th>
                                            <th>Ocena</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>>
                    </div>
                </section>
            </section>
        </section>
    </body>
</html>