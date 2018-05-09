<?php
    echo $formAction = "studenti";
?>

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
                                <th>Preglej vloga</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach($allData as $data): ?>
                                <tr>
                                    <td><?php echo $data['ime']; ?></td>
                                    <td><?php echo $data['priimek']; ?></td>
                                    <td><?php echo $data['vpisna_stevilka']; ?></td>
                                    <td>
                                        <form action="<?= BASE_URL . $formAction . "/" . $data['id_oseba'] ?>" method="get">
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
