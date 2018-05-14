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

                var oTable = $("#tabelaIzpitov").DataTable({
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
                    <h3>Razpisovanje izpitnih rokov</h3>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="content-panel">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Predmet</th>
                                            <th>Datum in ura</th>
                                            <th>Predavalnica</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input style="height:28px" type="text" id="dodajIspit" />
                                            </td>
                                            <td>
                                                <input style="height:28px" type="datetime-local" name="dateTime" id="publishDate" />
                                            </td>
                                            <td>
                                                <input style="height:28px" type="text" id="dodajPredavalnico" />
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Dodaj izpit</button>
                                                <div class="modal fade" id="myModal" role="dialog">
                                                    <div class="modal-dialog">

                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>
                                                                    <form>
                                                                        <p>
                                                                            <label>Ste prepričani da boste razpisali izpitni rok?</label>
                                                                        </p>
                                                                        <label>
                                                                            DA <input name="izpit" type="radio" value="izpit" required>
                                                                        </label>
                                                                        <p>
                                                                            <label>Komentarji:<br>
                                                                                <textarea name="komentarji" rows="4" cols="36">Vnesite dodatne komentarje</textarea>
                                                                            </label>
                                                                        </p>
                                                                    </form>
                                                                </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal" id="gumb">Dodaj</button>
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Zapri</button>
                                                            </div>
                                                        </div>
                                                        <!-- Modal content-->
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!--/content-panel -->
                        </div>
                        <!-- /col-md-12 -->

                        <div class="col-md-12 mt">
                            <h3>Seznam vseh razpisanih izpitnih rokov</h3>
                            <div class="content-panel">
                                <table id="tabelaIzpitov"class="table">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Premet</th>
                                            <th>Datum in ura</th>
                                            <th>Predavalnica</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><!--<button id="toDelete"type="button" class="btn btn-info">Izbriši izpit</button>--></td>
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