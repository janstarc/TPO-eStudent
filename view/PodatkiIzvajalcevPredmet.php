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
                            <?php foreach ($allData as $key => $value): ?>
                                <option value="<?=$id_leto."/". $value["ID_PREDMET"]?>">
                                    <?php echo "(".$value["SIFRA_PREDMET"].") ".$value["IME_PREDMET"];
                                    if($value["IME1"] != null) echo " (".$value["IME1"]." ".$value["PRIIMEK1"];
                                    if($value["IME2"] != null) echo ", ".$value["IME2"]." ".$value["PRIIMEK2"];
                                    if($value["IME3"] != null) echo ", ".$value["IME3"]." ".$value["PRIIMEK3"];
                                    echo ")";
                                    ?></option>
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
