<!DOCTYPE html>

<html lang="en">
<head>
    <?php include("view/includes/head.php"); ?>

</head>
<body>
<section id="container">
    <?php include("view/includes/menu-links-admin.php"); ?>
    <section id="main-content">
        <section class="wrapper">
            <div class="row">
                <div class="col-md-12">
                    <div class="content-panel">
                        <h3>Kreiranje nova izvedba</h3>
                        <br>
                        <h5>Izvajalec 1</h5>
                        <table id="table-subject" class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th>Ime in priimek izvajalca</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <form action="<?= BASE_URL . "PodatkiIzvajalcev/leto/".$id_leto."/".$id_predmet. "/dodaj" ?>" method="post">
                                            <select class="form-control" name="imePriimek" onchange="this.form.submit()">
                                                <option selected disabled hidden></option>
                                                <?php foreach ($profesori as $i=>$data): ?>
                                                    <option value="<?= $data["IME"] .' '.$data["PRIIMEK"] .' '.$data["ID_OSEBA"]?>"><?= $data["PRIIMEK"] .' '.$data["IME"] .'('.$data["SIFRA_IZVAJALCA"].')'?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <!--<input class="btn btn-primary btn-sm" type="submit" value="Dodaj" />-->
                                        </form>

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