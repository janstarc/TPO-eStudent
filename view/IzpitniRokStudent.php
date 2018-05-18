<!DOCTYPE html>

<html lang="en">
    <head>
        <?php include("view/includes/head.php"); ?>
        <?php
            $sitePrijaviNull=true;
            foreach ( $roki as $rok) {
                if($rok["ID_PRIJAVA"]!=NULL){
                    $sitePrijaviNull=false;
                    break;
                }
            }
        ?>
    </head>
    <body>
        <section id="container">
            <?php include("view/includes/menu-links-student.php"); ?>
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
                                        <th>Prijava</th>
                                        <th>Odjava</th>
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
                                            <td>
                                                <?php if($sitePrijaviNull) : ?>
                                                <form action="<?= BASE_URL . $formAction . "prijava" ?>" method="post">
                                                    <input type="hidden" name="rokId" value="<?= $rok["ID_ROK"] ?>" />
                                                    <input class="btn btn-primary btn-sm" type="submit" value="Prijavi se" />
                                                </form>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($rok["ID_PRIJAVA"]!=NULL) : ?>
                                                <form action="<?= BASE_URL . $formAction . "prijava" ?>" method="post">
                                                    <input type="hidden" name="rokId" value="<?= $rok["ID_ROK"] ?>" />
                                                    <input class="btn btn-primary btn-sm" type="submit" value="Odjavi se" />
                                                </form>
                                                <?php endif; ?>
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
