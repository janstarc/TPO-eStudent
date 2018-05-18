<!DOCTYPE html>

<html lang="en">
<head>
    <?php include("view/includes/head.php"); ?>
    <script>

        var mainInfo=function(id_prijava, tocke, ime, priimek, datumRoka){
            var datumRokaTab = datumRoka.split("-");
            var datumRokaDate = new Date(datumRokaTab[0], datumRokaTab[1], datumRokaTab[2]);
            var today = new Date();

            if(today < datumRokaDate) console.log("Ocen ni mogoče vnašati, datum roka je večji od današnjega dne");

            if(tocke < 0){

                $("#alert").removeClass("alert-success").addClass("alert-danger").show();
                $("#alertContent").text("Napaka - Vnešene točke morajo biti večje od 0");
            } else if(tocke > 100) {
                $("#alert").removeClass("alert-success").addClass("alert-danger").show();
                $("#alertContent").text("Napaka - Vnešene točke morajo biti manjše od 100");
            } else if(today < datumRokaDate) {
                $("#alert").removeClass("alert-success").addClass("alert-danger").show();
                $("#alertContent").text("Napaka - Ocen ni mogoče vnašati, datum roka je večji od današnjega dne");
            } else {
                $.ajax({
                    type: "POST",
                    url:   "vnosEneOceneAjax",
                    data: { "id_prijava": id_prijava,  "tocke": tocke},           // { name: "John" }
                    success: function() {
                        $("#alert").removeClass("alert-danger").addClass("alert-success").show();
                        var message = "Vnos uspešen!   " + ime + " " + priimek + " (" + tocke + " točk)";
                        $("#alertContent").text(message);
                    }
                });
            }
        };

        var vrnjenaPrijava=function(id_prijava, ime, priimek){

            $.ajax({
                type: "POST",
                url:   "vrniPrijavoAjax",
                data: { "id_prijava": id_prijava },           // { name: "John" }
                success: function() {
                    $("#alert").removeClass("alert-danger").addClass("alert-success").show();
                    var message = "Vnos uspešen!   " + ime + " " + priimek + " uspešno odjavljen!";
                    $("#alertContent").text(message);
                }
            });
        };

        $(document).ready( function () {

            // Override default sorta s custom sortom
            jQuery.fn.dataTableExt.oSort["slo-desc"] = function (x, y) {
                return sloCompare(y,x);
            };

            jQuery.fn.dataTableExt.oSort["slo-asc"] = function (x, y) {
                return sloCompare(x,y);
            };

            var oTable = $("#tabelaOcen").DataTable({
                // Custom definicije za vsak stolpec
                "aoColumns": [{
                    "sClass": "center",
                    "bSortable": false
                }, {
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
                    "bSortable": false
                }, {
                    "sClass": "center",
                    "bSortable": false
                } ],
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
            <br>
            <div class="row mt">
                <div class="col-md-12 mt">
                    <h3>Seznam prijavljenih študentov na izpitni rok</h3>
                    <p><big>Predmet: <b><?= PredmetModel::getPredmetIme($id_predmet) ?></b></big></p>
                    <p><big>Izpraševalci: <b><?= $izvajalci ?></b></big></p>
                    <p><big>Datum roka: <b><?= ProfesorController::formatDateSlo($rok_data["DATUM_ROKA"])." ob ".$rok_data["CAS_ROKA"] ?></b></big></p>
                    <div class="content-panel">

                        <div id="alert" class="alert alert-success alert-dismissible" role="alert" style="display: none">
                            <div id="alertContent"></div>
                        </div>
                        <table id="tabelaOcen" class="table table-bordered table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>ID Prijava</th>
                                    <th>Ime</th>
                                    <th>Priimek</th>
                                    <th>Vpisna številka</th>
                                    <th>Datum prijave</th>
                                    <th>Zap. št. polaganja (skupno)</th>
                                    <th>Zap. št. polaganja (letos)</th>
                                    <th>Točke</th>
                                    <th>Vrnjena prijava</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($prijavljeniStudenti as $key => $value): ?>
                                    <tr>
                                        <td></td>
                                        <td> <?= $value['ID_PRIJAVA'] ?></td>
                                        <td> <?= $value['IME'] ?></td>
                                        <td> <?= $value['PRIIMEK'] ?></td>
                                        <td> <?= $value['VPISNA_STEVILKA'] ?></td>
                                        <td> <?= ProfesorController::formatDateSlo($value['DATUM_PRIJAVE']) ?></td>
                                        <td> <?= $value['ZAP_ST_POLAGANJ'] ?></td>
                                        <td> <?= $value['ZAP_ST_POLAGANJ_LETOS'] ?></td>
                                        <td id="tockeInput"> <input id="test" type="number" name="tocke" onchange="mainInfo(<?= $value['ID_PRIJAVA'] ?>, this.value, '<?= $value['IME'] ?>', '<?= $value['PRIIMEK'] ?>', '<?= $rok_data["DATUM_ROKA"] ?>')" value="<?= $value['TOCKE_IZPITA'] ?>" /></td>
                                        <td id="me"> <input type="checkbox" onchange="vrnjenaPrijava(<?= $value['ID_PRIJAVA'] ?>, '<?= $value['IME'] ?>', '<?= $value['PRIIMEK'] ?>')"></td>
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