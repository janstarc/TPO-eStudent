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
                        <hr>
                        <h4>Prikaz vrste vpise</h4>
                        <br>
                        <br>
                        <br>
                        <table id="table-subject" class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th>Opis vrste</th>
                                <th>Uredi</th>
                                <th>Deaktiviraj</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            // var_dump($all);
                            foreach($all as $key=>$value): ?>
                                <tr>
                                    <td><?php echo $value['OPIS_VPISA']; ?></td>
                                    <td>
                                        <form action="<?= BASE_URL . "VrstaVpisaAll/editForm" ?>" method="post">
                                            <input type="hidden" name="urediId" value="<?= $value['ID_VRSTAVPISA'] ?>" />
                                            <input class="btn btn-primary btn-sm" type="submit" value="Uredi" />
                                        </form>
                                    </td>
                                    <td>
                                        <form  action="<?= BASE_URL . "VrstaVpisaAll/toogleActivated" ?>" method="post">
                                            <input type="hidden" name="activateId" value="<?= $value["ID_VRSTAVPISA"] ?>" />
                                            <?php if(!$value["AKTIVNOST"]) : ?>
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