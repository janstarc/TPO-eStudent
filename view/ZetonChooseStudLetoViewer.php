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
                        <div class="col-xs-12 col-md-6 offset-md-3">
                            <h2><?= $pageTitle ?></h2>
                            <?php if(isset($status)): ?>
                                <div class="alert alert-<?= ($status === "Failure") ? "danger" : (($status === "Success") ? "success" : "info") ?> alert-dismissible" role="alert">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <?= $message ?>
                                </div>
                            <?php endif; ?>

                            <div class="form-group">
                                <select class="form-control" name="ID_STUD_LETO" onchange="location = this.value;">
                                    <option selected disabled hidden></option>
                                    <?php foreach ($allData as $data): ?>
                                        <option value="<?= $formAction . "/" . $data["ID_STUD_LETO"] ?>"><?= $data["STUD_LETO"] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </section>
            </section>
        </section>
    </body>
</html>
