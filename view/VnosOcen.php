<!DOCTYPE html>

<html lang="en">
    <head>
        <?php include("view/includes/head.php"); ?>
    </head>
    <body>
        <section id="container">
            <?php include("view/includes/menu-links-professor.php"); ?>
            <section id="main-content">
                <section class="wrapper">
                    <h3>Seznam mojih predmetov</h3>
                    <div class="row mt">
                        <div class="col-lg-12">
                            <div class="content-panel">
                                <section id="unseen">
                                    <table class="table table-bordered table-striped table-condensed">
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
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td><textarea id="textAreaVpisna"rows="1" cols="10"></textarea></td>
                                                <td></td>
                                                <td><input style="height:28px" type="datetime-local" id="datumOcena" name="dateTime"></td>
                                                <td><textarea rows="1" cols="2" id="textAreaOpravljanje"></textarea></td>
                                                <td></td>
                                                <td><textarea rows="1" cols="1" id="textAreaOcena"></textarea></td>
                                                <td><button type="button" class="btn btn-info btn-sm" data-toggle="modal" id="vnesiOcena">Vnesi ocena</button></td>
                                            </tr>
                                        </tbody>
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