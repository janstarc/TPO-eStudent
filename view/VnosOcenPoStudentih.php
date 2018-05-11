<?php
    $prijavljeniStudenti = array();
    array_push($prijavljeniStudenti, array('ime' => 'Janez', 'priimek' => 'Novak', 'datumIzpita' => '2018-01-02', 'vpisna_stevilka' => '123456', 'opravljanje' => 2, 'ocena' => 8))
?>

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
            <br>
            <div class="row mt">
                <div class="col-md-12 mt">
                    <h3>Vnos ocen po za predmet </h3>
                    <div class="content-panel">
                        <table id="tabelaOcen" class="table table-bordered table-striped table-condensed">
                            <thead>
                            <tr>
                                <th>Ime</th>
                                <th>Priimek</th>
                                <th>Vpisna številka</th>
                                <th>Datum izpita</th>
                                <th>Opravljanje</th>
                                <th>Ocena</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($prijavljeniStudenti as $key => $value): ?>
                                    <td> <?= $value['ime'] ?></td>
                                    <td> <?= $value['priimek'] ?></td>
                                    <td> <?= $value['vpisna_stevilka'] ?></td>
                                    <td> <?= $value['datumIzpita'] ?></td>
                                    <td> <?= $value['opravljanje'] ?></td>
                                    <td> <?= $value['ocena'] ?></td>
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