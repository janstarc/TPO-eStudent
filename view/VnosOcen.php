<?php

?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <?php include("view/includes/head.php"); ?>

        <script type="application/javascript">

            var izpitniRoki = <?php echo json_encode($izpitniRoki) ?>; // don't use quotes
            $(document).ready(function() {

                console.log(izpitniRoki);

                $("#id_predmet").change(function(e) {
                    e.preventDefault();
                    var id_predmet = $("#id_predmet").val();
                    console.log(izpitniRoki[id_predmet]);
                    fill_select_rok(id_predmet);
                });

                $.each(izpitniRoki, function(key, value) {
                    fill_select_rok(value);
                });

            });

            function fill_select_rok(id) {
                $('#id_rok').html('');

                $.each(izpitniRoki, function(key, value) {
                    var id_predmeta = value["ID_PREDMET"];
                    var datum_roka = value["DATUM_ROKA"];
                    if (id == id_predmeta) {
                        $('#id_rok').append('<option value="' + id_predmeta + '">' + datum_roka + '</option>');
                    }
                });
            }
        </script>
    </head>
    <body>
        <section id="container">
            <?php include("view/includes/menu-links-professor.php"); ?>
            <section id="main-content">
                <section class="wrapper">
                    <br>
                    <h3>Izberi predmet in rok izpita</h3>
                    <div class="form-group">
                        <label for="id_drzava">Predmet</label>
                        <select class="form-control" id="id_predmet" name="id_predmet" required>
                            <option selected disabled hidden></option>
                            <?php foreach ($predmeti as $key => $value): ?>
                                <option value="<?= $value["ID_PREDMET"] ?>"><?= $value["IME_PREDMET"]." (ID=".$value["ID_PREDMET"].")" ?></option>
                            <?php endforeach; ?>
                        </select>

                    </div>
                    <div class="form-group">
                        <label for="id_drzava">Izpitni rok</label>
                        <select class="form-control" id="id_rok" name="id_rok" required>
                            <!--<option selected disabled hidden></option>-->
                            <?php //foreach ($izpitniRoki as $key => $value): ?>

                            <?php //endforeach; ?>
                        </select>
                    </div>

                    <div class="row mt">
                        <div class="col-lg-12">
                            <div class="content-panel">
                                <section id="unseen">
                                    <table class="table table-bordered table-striped table-condensed">
                                        <!--
                                        <thead>
                                            <tr>
                                                <th>Šifra predmeta</th>
                                                <th>Predmet</th>
                                                <th>Vpisna številka študenta</th>
                                                <th>Letnik</th>
                                                <th>Datum</th>
                                                <th>Opravljanje</th>
                                                <th>KT</th>
                                                <th>Ocena</th>
                                            </tr>
                                        </thead>
                                        -->
                                        <!--
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td><textarea id="textAreaVpisna" rows="1" cols="10"></textarea></td>
                                                <td></td>
                                                <td><input style="height:28px" type="datetime-local" id="datumOcena" name="dateTime"></td>
                                                <td><textarea rows="1" cols="2" id="textAreaOpravljanje"></textarea></td>
                                                <td></td>
                                                <td><textarea rows="1" cols="1" id="textAreaOcena"></textarea></td>
                                                <td><button type="button" class="btn btn-info btn-sm" data-toggle="modal" id="vnesiOcena">Vnesi ocena</button></td>
                                            </tr>
                                        </tbody>
                                        -->
                                    </table>
                                </section>
                            </div>
                            <!-- /content-panel -->
                        </div>
                        <!-- /col-lg-4 -->
                    </div>
                    <!-- /row -->
                    <div class="row mt">
                        <div class="col-md-12 mt">
                            <h3>Seznam vseh ocen po predmetu</h3>
                            <div class="content-panel">
                                <h5>Izberi predmet:
                                    <input list="predmet" name="predmet">
                                    <datalist id="predmet">
                                        <option value=""></option>
                                    </datalist>
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" id="prikaz">Prikazi</button>
                                </h5>
                                <table id="tabelaOcen" class="table table-bordered table-striped table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Vpisna številka </th>
                                            <th>Datum izpita</th>
                                            <th>Opravljanje</th>
                                            <th>KT</th>
                                            <th>Ocena</th>
                                        </tr>
                                    </thead>
                                    <tbody>
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