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
                                        <th>#</th>
                                        <th>Predmet</th>
                                        <th>Datum</th>
                                        <th>Cas</th>
                                        <th>Stevilo prijavljenih</th>
                                        <th>Uredi</th>
                                        <th>Deaktiviraj</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1; foreach($roki as $rok): ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $rok['IME_PREDMET']; ?></td>
                                            <td>
                                                <?php
                                                list($y, $m, $d) = explode('-', $rok["DATUM_ROKA"]);
                                                echo $d."-".$m."-".$y;
                                                ?>
                                            </td>
                                            <td><?php echo $rok['CAS_ROKA']; ?></td>
                                            <td><?php echo $rok['StevlioPrijavljenih']; ?></td>
                                            <td>
                                                <form action="<?= BASE_URL . $formAction .  "/edit/" . $rok["ID_ROK"] ?>" method="get">
                                                    <input class="btn btn-primary btn-sm" type="submit" value="Uredi" />
                                                </form>
                                            </td>
                                            <td>
                                                <form  action="<?= BASE_URL . $formAction .  "/toogleActivated" ?>" method="post">
                                                    <input type="hidden" name="activateId" value="<?= $rok["ID_ROK"] ?>" />
                                                    <?php if(!$rok["AKTIVNOST"]) : ?>
                                                        <input class="btn btn-success btn-sm" type="submit" value="Activate" />
                                                    <?php else : ?>
                                                        <input onclick="return confirm('Pozor! S klikom na \'OK\' boste odjavili vse prijavljene študente!');" class="btn btn-danger btn-sm" type="submit" value="Deactivate" />
                                                    <?php endif; ?>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php $i = $i + 1; endforeach; ?>
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
