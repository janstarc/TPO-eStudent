<!DOCTYPE html>

<html lang="en">
<head>

    <?php
    require_once("view/includes/head.php");
    require_once("controller/ProfessorController.php")

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
                            <h3>Izbira predmeta</h3></div>
                        <table id="table-izpitov" class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th>Ime predmeta</th>
                                <th>Uredi</th>


                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <?php



                                foreach ($data as $row) {

                                $izvedba = $row["IME_PREDMET"];
                                $id =$row["ID_PREDMET"];
                                ?>
                            <tr>
                                <td><?= $izvedba?></td>

                                <td>
                                    <form class=example2  action="<?= BASE_URL . "predmet" ?>" method='post'>
                                        <input type="hidden" name="idPredmet" value="<?= $id ?>" />
                                        <button type=submit >Uredi</button>
                                    </form>
                                </td>
                            </tr><?php
                            }
                            ?>


                            </tr>
                            </tbody>
                        </table>

                    </div>
                    <hr>
                    <form class=example2  action="<?= BASE_URL . "PredmetAdd" ?>" method='post'>
                        <input type="hidden" name="id" value="<?= $id ?>" />
                        <button type=submit >Dodaj nov predmet</button>
                    </form>
                </div>
            </div>
            </div>
            </div>
        </section>
    </section>
</section>

</body>
</html>



