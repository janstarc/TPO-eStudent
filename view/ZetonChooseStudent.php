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
                                    <tr><th>#</th>
                                        <th>Ime</th>
                                        <th>Priimek</th>
                                        <th>Vpisna stevilka</th>
                                        <th>Letnik</th>
                                        <th>Vsota Opravljenih KT</th>

                                        <th>Pogoji za vpis</th>
                                        <th>Pogoji za ponavljanje</th>
                                        <th>Poglej vse žetone</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $n = 0;
                                    foreach($allData as $data):
                                        $n+=1;?>
                                        <tr>
                                            <td><?php echo $n ?></td>
                                            <td><?php echo $data['IME']; ?></td>
                                            <td><?php echo $data['PRIIMEK']; ?></td>
                                            <td><?php echo $data['VPISNA_STEVILKA']; ?></td>
                                            <td><?php echo $data['ID_LETNIK']; ?></td>
                                            <td><?php echo $data['VSOTA_OPRAVLJENIH_KREDITNIH_TOCK']; ?></td>
                                            <td><form  <?php if ($data['pogoj1'] == 0){ echo 'style="display:none;"';} ?>  action="<?= BASE_URL . "zetoni/add" ?>" method="post">
                                                    <input type="hidden" name="IdOseba" value="<?= $data['ID_OSEBA'] ?>" />
                                                    <input type="hidden" name="Leto" value="<?= $id ?>" />
                                                    <input class="btn btn-primary btn-sm" type="submit" value="Naslednji letnik" />
                                                </form></td>
                                            <td><form  <?php if ($data['pogoj2'] == 0){ echo 'style="display:none;"';} ?>  action="<?= BASE_URL . "zetoni/renew" ?>" method="post">
                                                    <input type="hidden" name="IdOseba" value="<?= $data['ID_OSEBA'] ?>" />
                                                    <input type="hidden" name="Leto" value="<?= $id ?>" />
                                                    <input class="btn btn-primary btn-sm" type="submit" value="Ponavljanje letnika" />
                                                </form>
                                            <td>
                                                <form action="<?= BASE_URL . $formAction . "/" . $data['ID_OSEBA'] ?>" method="get">
                                                    <input class="btn btn-primary btn-sm" type="submit" value="Poglej" />
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
