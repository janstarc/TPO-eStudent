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
                <div class="col-xs-12 col-md-6 offset-md-3">
                    <br><br>
                    <h2><?= $pageTitle ?></h2>
                    <p>Izberi predmet</p>
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
                                <option value="<?= $id_leto . "/". $data["ID_PREDMET"]  ?>"><?= $data["IME_PREDMET"] ."(".$data["SIFRA_PREDMET"].")" ?></option>
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
