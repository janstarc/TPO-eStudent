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
                        <h4>Prikaz studijskih let</h4>
                        <br>
                        <br>
                        <br>
                        <table id="table-subject" class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th>Studijsko leto</th>
                                <th>Uredi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            // var_dump($all);
                            foreach($all as $key=>$value): ?>
                                <tr>
                                    <td><?php echo $value['STUD_LETO']; ?></td>
                                    <td>
                                        <form action="<?= BASE_URL . "StudijskoLetoAll/editForm" ?>" method="post">
                                            <input type="hidden" name="urediId" value="<?= $value['ID_STUD_LETO'] ?>" />
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