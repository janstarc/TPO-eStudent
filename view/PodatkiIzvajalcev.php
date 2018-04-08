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
                        <h3>Iskanje predmeta</h3>
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
                                <th>Studijsko leto</th>
                                <th>Izvajalec</th>
                                <th>Operacije</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($subjects as $key=>$value): ?>
                                <tr>
                                    <td><?php echo $value['IME_PREDMET']; ?></td>
                                    <td><?php echo $value['STUD_LETO']; ?></td>
                                    <td><?php echo $value['IME'] . ' ' . $value['PRIIMEK']; ?></td>
                                    <td></td>
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