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
                        <h3>Iskanje predmeta za trenutno studijsko leto</h3>
                        <br>
                        <form class="subject" action="<?= BASE_URL . "PodatkiIzvajalcev/subjectSearch" ?>" method="post">
                            <input type="text" placeholder="IŠČI PO PREDMETU..." name="searchSubject">
                            <button type="submit">Išči</button>
                        </form>
                        <br>
                        <br>
                        <hr>
                        <h4>Prikaz predmeta</h4>
                        <br>
                        <br>
                        <br>
                        <table id="table-subject" class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th>Predmet</th>
                                <th>Ime izvajalca</th>
                                <th>Priimek izvajalca</th>
                                <th>Email</th>
                                <th>Telefon</th>
                                <th>Uredi</th>

                            </tr>
                            </thead>
                            <tbody>

                            <?php
                          //  var_dump($subjects);
                            foreach($subjects as $key=>$value): ?>

                                <tr>
                                    <td><?php echo $value['IME_PREDMET']; ?></td>
                                    <td><?php echo $value['IME'] ; ?></td>
                                    <td><?php echo $value['PRIIMEK'] ; ?></td>
                                    <td><?php echo $value['EMAIL']; ?></td>
                                    <td><?php echo $value['TELEFONSKA_STEVILKA']; ?></td>
                                    <td>
                                        <form action="<?= BASE_URL . "PodatkiIzvajalcev/editForm" ?>" method="post">
                                            <input type="hidden" name="urediId" value="<?= $value['ID_OSEBA'] ?>" />
                                            <input type="hidden" name="predmetId" value="<?= $value['ID_PREDMET'] ?>" />
                                            <input class="btn btn-primary btn-sm" type="submit" value="Uredi" />
                                        </form>
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