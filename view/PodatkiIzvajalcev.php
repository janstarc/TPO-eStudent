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
                        <h3>Podatki o izvajalcih</h3>
                        <br>
                        <h5>Izvajalec 1</h5>
                        <table id="table-subject" class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th>Ime in priimek izvajalca</th>
                                <th>Spremeni izvajalca</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(count($first)==0): ?>
                                <tr>
                                    <td>
                                        <form action="<?= BASE_URL . "PodatkiIzvajalcev/leto/".$id_leto."/".$id_predmet. "/dodaj1" ?>" method="post">
                                            <select class="form-control" name="imePriimek" onchange="this.form.submit()">
                                                <option selected disabled hidden></option>
                                                <?php foreach ($profesori as $i=>$data): ?>
                                                    <option value="<?= $data["IME"] .' '.$data["PRIIMEK"] .' '.$data["ID_OSEBA"]?>"><?= $data["PRIIMEK"] .' '.$data["IME"] .' ('.$data["SIFRA_IZVAJALCA"].')'?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <!--<input class="btn btn-primary btn-sm" type="submit" value="Dodaj" />-->
                                        </form>

                                    </td>
                                    <td></td>
                                </tr>
                            <?php else:
                          //  var_dump($subjects);
                            foreach($first as $key=>$value): ?>

                                <tr>
                                    <td><?php echo $value['IME'] .' '.$value["PRIIMEK"] ; ?></td>
                                    <td>
                                        <form action="<?= BASE_URL . "PodatkiIzvajalcev/editFirst/".$id_leto."/".$id_predmet ?>" method="post">
                                            <input type="hidden" name="urediId" value="<?= $value['ID_OSEBA'] ?>" />
                                            <input class="btn btn-primary btn-sm" type="submit" value="Spremeni izvajalec" />
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                        </table>

                        <h5>Izvajalec 2</h5>
                        <table id="table-subject2" class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th>Ime in priimek izvajalca</th>
                                <th>Spremeni izvajalca</th>
                                <th>Izbriši izvajalca</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(count($second)==0): ?>
                                <tr>
                                    <td>
                                        <form action="<?= BASE_URL . "PodatkiIzvajalcev/leto/".$id_leto."/".$id_predmet. "/dodaj2" ?>" method="post">
                                            <select class="form-control" name="imePriimek2" onchange="this.form.submit()">
                                                <option selected disabled hidden></option>
                                                <?php foreach ($profesori as $i=>$data): ?>
                                                    <option value="<?= $data["IME"] .' '.$data["PRIIMEK"] .' '.$data["ID_OSEBA"]?>"><?= $data["PRIIMEK"] .' '.$data["IME"] .' ('.$data["SIFRA_IZVAJALCA"].')'?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <!--<input class="btn btn-primary btn-sm" type="submit" value="Dodaj" />-->
                                        </form>

                                    </td>
                                    <td></td>
                                    <td></td>

                                </tr>
                            <?php else:
                                //  var_dump($subjects);
                                foreach($second as $key=>$value): ?>

                                    <tr>
                                        <td><?php echo $value['IME'] .' '.$value["PRIIMEK"] ; ?></td>
                                        <td>
                                            <form action="<?= BASE_URL . "PodatkiIzvajalcev/editSecond/".$id_leto."/".$id_predmet ?>" method="post">
                                                <input type="hidden" name="urediId" value="<?= $value['ID_OSEBA'] ?>" />
                                                <input class="btn btn-primary btn-sm" type="submit" value="Spremeni izvajalca" />
                                            </form>
                                        </td>
                                        <td>
                                            <form action="<?= BASE_URL . "PodatkiIzvajalcev/deleteSecond/".$id_leto."/".$id_predmet ?>" method="post">
                                                <input type="hidden" name="urediId" value="<?= $value['ID_OSEBA'] ?>" />
                                                <input class="btn btn-primary btn-sm" type="submit" value="Izbriši izvajalca" />
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                        </table>

                        <h5>Izvajalec 3</h5>
                        <table id="table-subject3" class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th>Ime in priimek izvajalca</th>
                                <th>Spremeni izvajalca</th>
                                <th>Izbriši izvajalca</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(count($third)==0): ?>
                                <tr>
                                    <td>
                                        <form action="<?= BASE_URL . "PodatkiIzvajalcev/leto/".$id_leto."/".$id_predmet. "/dodaj3" ?>" method="post">
                                            <select class="form-control" name="imePriimek3" onchange="this.form.submit()">
                                                <option selected disabled hidden></option>
                                                <?php foreach ($profesori as $i=>$data): ?>
                                                    <option value="<?= $data["IME"] .' '.$data["PRIIMEK"] .' '.$data["ID_OSEBA"]?>"><?= $data["PRIIMEK"] .' '.$data["IME"] .' ('.$data["SIFRA_IZVAJALCA"].')'?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <!--<input class="btn btn-primary btn-sm" type="submit" value="Dodaj" />-->
                                        </form>

                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            <?php else:
                                //  var_dump($subjects);
                                foreach($third as $key=>$value): ?>

                                    <tr>
                                        <td><?php echo $value['IME'] .' '.$value["PRIIMEK"] ; ?></td>
                                        <td>
                                            <form action="<?= BASE_URL . "PodatkiIzvajalcev/editThird/".$id_leto."/".$id_predmet ?>" method="post">
                                                <input type="hidden" name="urediId" value="<?= $value['ID_OSEBA'] ?>" />
                                                <input class="btn btn-primary btn-sm" type="submit" value="Spremeni izvajalec" />
                                            </form>
                                        </td>
                                        <td>
                                            <form action="<?= BASE_URL . "PodatkiIzvajalcev/deleteThird/".$id_leto."/".$id_predmet ?>" method="post">
                                                <input type="hidden" name="urediId" value="<?= $value['ID_OSEBA'] ?>" />
                                                <input class="btn btn-primary btn-sm" type="submit" value="Izbriši izvajalca" />
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
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