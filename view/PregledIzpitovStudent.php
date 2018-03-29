<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("view/includes/head.php"); ?>
    </head>
    <body>
        <section id="container">
            <?php include("view/includes/menu-links-student.php"); ?>
            <section id="main-content">
                <section class="wrapper">
                    <h3>
                        Ime studenta (Vpisna stevilka)
                    </h3>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="content-panel">
                                <h4>Študijski smer: Napisi smer</h4>
                                <hr>
                                <p>
                                    <label><strong>Išči izpit po predmetu</strong>:<input id="isci-predmet-input" type="search" /></label>
                                    <button id="isci-predmet-gumb" class="btn btn-default btn-xs" type="button"><span class="glyphicon glyphicon-search"></span> Išči</button>
                                </p>
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
                                            <td>
                                                <button class="btn btn-primary btn-xs">Prijavi se</button>
                                            </td>
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