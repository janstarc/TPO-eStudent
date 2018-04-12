<!DOCTYPE html>

<html lang="en">
<head>

    <?php
    require_once("view/includes/head.php");
    require_once("controller/ProfessorController.php");


    ?>
</head>
<body>
<section id="container">
    <?php include("view/includes/menu-links-admin.php"); ?>
    <section id="main-content">
        <section class="wrapper">
            <div class="row">
                <div class="col-md-12">
                    <div class="content-panel">
                        <br>
                        <br>
                        <div>
                            <h3> Urejanje predmeta: <?= $predmet ?></h3></div>
                        <form class=example2  action="<?= BASE_URL . "dodajPredmet" ?>" method='post'>
                            <input type="hidden" name="idPredmet" value="<?= $data['idPredmet'] ?>" />
                            <input type="hidden" name="idPredmetnik" value="0" />
                            <input type="hidden" name="tip" value="a" />
                            <button type=submit >Dodaj v nov predmetnik</button>
                        </form>
                        <table id="table-izpitov" class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th>Študijsko leto</th>
                                <th>Program</th>
                                <th>Letnik</th>
                                <th>Del predmetnika</th>
                                <th>Aktivnost</th>
                                <th>Uredi</th>
                                <th>Spremeni aktivnost</th>

                            </tr>
                            </thead>
                            <tbody>


                            <?php
                            foreach ($predmetniki as $row) {

                                $leto = $row["stud_leto"];
                                $program =$row["Naziv_program"];
                                $letnik = $row["letnik"];
                                $del = $row["NAZIV_DELAPREDMETNIKA"];
                                $aktivnost =  $row["aktivnost"];
                                if($aktivnost == 1) $aktivnost = "Aktiven" ; else $aktivnost = "Neaktiven" ;
                                ?>
                                <tr>
                                <td><?= $leto?></td>
                                <td><?= $program?></td>
                                <td><?= $letnik?></td>
                                <td><?= $del?></td>
                                <td><?= $aktivnost?></td>

                                <td>
                                    <form class=example3  action="<?= BASE_URL . "dodajPredmet"  ?>" method='post'>
                                        <input type="hidden" name="idPredmetnik" value="<?= $row['id_predmetnik'] ?>" />
                                        <input type="hidden" name="idPredmet" value="<?= $data['idPredmet'] ?>" />
                                        <input type="hidden" name="tip" value="e" />
                                        <button type=submit >Edit</button>
                                    </form>
                                </td>
                                <td>
                                    <form  action="<?= BASE_URL . "dodajPredmet" ?>" method="post">
                                        <input type="hidden" name="idPredmetnik" value="<?= $row['id_predmetnik'] ?>" />
                                        <input type="hidden" name="idPredmet" value="<?= $data["idPredmet"] ?>" />
                                        <input type="hidden" name="aktivnost" value="<?= $value["AKTIVNOST"] ?>" />
                                        <input type="hidden" name="tip" value="d" />
                                        <?php if($row["aktivnost"] == 0) : ?>
                                            <input class="btn btn-success btn-sm" type="submit" value="Activate" />
                                        <?php else : ?>
                                            <input class="btn btn-danger btn-sm" type="submit" value="Deactivate" />
                                        <?php endif; ?>
                                    </form>
                                </td>
                                </tr><?php
                            }
                            ?>
                            </tbody>
                        </table>


                    </div>
                    <hr>

                </div>
            </div>
            </div>
            </div>
        </section>
    </section>
</section>

</body>
</html>



