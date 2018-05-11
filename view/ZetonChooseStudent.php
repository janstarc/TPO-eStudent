<!DOCTYPE html>

<html lang="en">
    <head>
        <?php include("view/includes/head.php"); ?>
    </head>
    <body>
        <section id="container">
            <?php include("view/includes/menu-links-student-officer.php"); ?>
            <section id="main-content">
                <section class="wrapper">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="content-panel">
                                
                                <h2><?= $pageTitle ?></h2>
                                <?php if(isset($status)): ?>
                                    <div class="alert alert-<?= ($status === "Failure") ? "danger" : (($status === "Success") ? "success" : "info") ?> alert-dismissible" role="alert">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <?= $message ?>
                                    </div>
                                <?php endif; ?>
                                
                                <table id="table-subject" class="table table-striped table-advance table-hover">
                                    <thead>
                                    <tr>
                                        <th>Ime</th>
                                        <th>Priimek</th>
                                        <th>Vpisna stevilka</th>
                                        <th>Letnik</th>
                                        <th>Vsota Opravljenih KT</th>
                                        <th>Izkoriščen</th>
                                        <th>Aktivnost</th>
                                        <th>Pogoje za vpis</th>
                                        <th>Pogoje za ponavljanje</th>
                                        <th>Poglej vse žetone</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach($allData as $data): ?>
                                        <tr>
                                            <td><?php echo $data['IME']; ?></td>
                                            <td><?php echo $data['PRIIMEK']; ?></td>
                                            <td><?php echo $data['VPISNA_STEVILKA']; ?></td>
                                            <td><?php echo $data['ID_LETNIK']; ?></td>
                                            <td><?php echo $data['VSOTA_OPRAVLJENIH_KREDITNIH_TOCK']; ?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <form action="<?= BASE_URL . $formAction . "/" . $data['ID_OSEBA'] ?>" method="get">
                                                    <input class="btn btn-primary btn-sm" type="submit" value="Preglej" />
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
