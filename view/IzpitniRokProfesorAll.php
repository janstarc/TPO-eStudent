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
                                <hr>
                                <h4>Vnos izpitnega roka</h4>
                                <br>
                                <br>
                                <br>
                                <table id="table-subject" class="table table-striped table-advance table-hover">
                                    <thead>
                                    <tr>
                                        <th>Predmet</th>
                                        <th>Datum</th>
                                        <th>Cas</th>
                                        <th>Uredi</th>
                                        <th>Deaktiviraj</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach($roki as $rok): ?>
                                        <tr>
                                            <td><?php echo $rok['IME_PREDMET']; ?></td>
                                            <td><?php echo $rok['DATUM_ROKA']; ?></td>
                                            <td><?php echo $rok['CAS_ROKA']; ?></td>
                                            <td>
                                                <form action="<?= BASE_URL . $formAction . "edit" ?>" method="post">
                                                    <input type="hidden" name="urediId" value="<?= $rok['ID_ROK'] ?>" />
                                                    <input class="btn btn-primary btn-sm" type="submit" value="Uredi" />
                                                </form>
                                            </td>
                                            <td>
                                                <form  action="<?= BASE_URL . $formAction . "toogleActivated" ?>" method="post">
                                                    <input type="hidden" name="activateId" value="<?= $rok["ID_ROK"] ?>" />
                                                    <?php if(!$rok["AKTIVNOST"]) : ?>
                                                        <input class="btn btn-success btn-sm" type="submit" value="Activate" />
                                                    <?php else : ?>
                                                        <input class="btn btn-danger btn-sm" type="submit" value="Deactivate" />
                                                    <?php endif; ?>
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
