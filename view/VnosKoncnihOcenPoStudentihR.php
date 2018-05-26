<!DOCTYPE html>

<html lang="en">
<head>
    <?php include("view/includes/head.php"); ?>


    <script>

        var mainInfo=function(id_prijava, ocena, ime, priimek){

            if(ocena <= 0){
                $("#alert").removeClass("alert-success").addClass("alert-danger").show();
                $("#alertContent").text("Napaka - Končna ocena mora biti večja od 0");
            } else if(ocena > 10) {
                $("#alert").removeClass("alert-success").addClass("alert-danger").show();
                $("#alertContent").text("Napaka - Končna ocena mora biti manjša ali enaka 10");
            } else {
                $.ajax({
                    type: "POST",
                    url:   "seznamStudentov/vnosEneKoncneOceneAjax",
                    data: { "id_prijava": id_prijava,  "ocena": ocena},           // { name: "John" }
                    success: function() {
                        $("#alert").removeClass("alert-danger").addClass("alert-success").show();
                        var message = "Vnos uspešen!   " + ime + " " + priimek + " (Končna ocena: " + ocena + ")";
                        $("#alertContent").text(message);
                    }
                });
            }
        };

        $(document).ready( function () {

            $('.cbox-prijava').on('change', function() {
                var checkbox = $(this);

                var id_prijava = $(this).data('id-prijava');
                var ime = $(this).data('ime');
                var priimek = $(this).data('priimek');

                if (checkbox.is(':checked')){
                    $.ajax({
                        type: "POST",
                        url:   "seznamStudentov/vrniPrijavoAjax",
                        data: { "id_prijava": id_prijava },           // { name: "John" }
                        success: function() {
                            $("#alert").removeClass("alert-danger").addClass("alert-success").show();
                            var message = "Vnos uspešen!   " + ime + " " + priimek + " uspešno odjavljen!";
                            $("#alertContent").text(message);
                            console.log(checkbox);
                            var input = checkbox.parent().parent().find('#tockeInput input');
                            input.val('');
                            input.attr('disabled', true);
                        }
                    });
                } else {
                    $.ajax({
                        type: "POST",
                        url:   "seznamStudentov/prekliciVrnjenoPrijavoAjax",
                        data: { "id_prijava": id_prijava },           // { name: "John" }
                        success: function() {
                            $("#alert").removeClass("alert-danger").addClass("alert-success").show();
                            var message = "Vnos uspešen! Odjava za " + ime + " " + priimek + " uspešno preklicana";
                            $("#alertContent").text(message);
                            console.log(checkbox);
                            var input = checkbox.parent().parent().find('#tockeInput input');
                            input.val('');
                            input.attr('disabled', false);
                        }
                    });
                }
            });

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
                }, {
                    "sClass": "center",
                    "bSortable": false
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
    <?php include("view/includes/menu-links-student-officer.php"); ?>
    <section id="main-content">
        <section class="wrapper">
            <br>
            <div class="row mt">
                <div class="col-md-12 mt">
                    <h3>Vnos končnih ocen predmeta</h3>

                    <p><big>Predmet: <b><?= PredmetModel::getPredmetIme($id_predmet)." (".PredmetModel::getPredmetSifra($id_predmet).")" ?></b></big></p>
                    <p><big>Nosilci predmeta: <b><?= $izvajalci ?></b></big></p>
                    <p><big>Izpraševalci: <b><?= $izvajalci ?></b></big></p>
                    <p><big>Datum roka: <b><?= ProfessorController::formatDateSlo($rok_data["DATUM_ROKA"])." ob ".$rok_data["CAS_ROKA"] ?></b></big></p>
                    <p><big>Študijsko leto: <b><?= StudijskoLetoModel::getIme($rok_data["ID_STUD_LETO"]) ?></b></big></p>

                    <br>
                    <div class="content-panel">

                        <div id="alert" class="alert alert-success alert-dismissible" role="alert" style="display: none">
                            <div id="alertContent"></div>
                        </div>
                        <table id="tabelaOcen" class="table table-bordered table-striped table-condensed">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Vpisna številka</th>
                                <th>Ime</th>
                                <th>Priimek</th>
                                <th>Št. polaganj (skupno)</th>
                                <th>Št. polaganj (letos)</th>
                                <th>Točke izpita</th>
                                <th>Končna ocena</th>
                                <th>Vrnjena prijava</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($prijavljeniStudenti as $key => $value): ?>
                                <tr>

                                    <td></td>
                                    <td><?= $value['VPISNA_STEVILKA'] ?></td>
                                    <td><?= $value['IME'] ?></td>
                                    <td><?= $value['PRIIMEK'] ?></td>
                                    <td><?php if($value['ZAP_ST_POLAGANJ'] == null) echo "Ni vnosa"; else echo $value['ZAP_ST_POLAGANJ'] ?></td>
                                    <td><?php if($value['ZAP_ST_POLAGANJ_LETOS'] == null) echo "Ni vnosa"; else echo $value['ZAP_ST_POLAGANJ_LETOS'] ?></td>
                                    <td><?php if($value['TOCKE_IZPITA'] == null) echo "Ni vnosa"; else echo $value['TOCKE_IZPITA'] ?></td>
                                    <td id="tockeInput"> <input id="test" type="number" name="tocke" onchange="mainInfo(<?= $value['ID_PRIJAVA'] ?>, this.value, '<?= $value['IME'] ?>', '<?= $value['PRIIMEK'] ?>')" value="<?= $value['OCENA_IZPITA'] ?>" /></td>
                                    <td id="me">
                                        <input type="checkbox" class="cbox-prijava" data-id-prijava="<?= $value['ID_PRIJAVA'] ?>" data-ime="<?= $value['IME'] ?>" data-priimek="<?= $value['PRIIMEK'] ?>">
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