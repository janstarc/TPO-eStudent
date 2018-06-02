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
                <div class="col-xs-12 col-md-8 offset-md-2">
                    <h2><?= $pageTitle ?></h2>
                    <?php if(isset($status)): ?>
                        <div class="alert alert-<?= ($status === "Failure") ? "danger" : (($status === "Success") ? "success" : "info") ?> alert-dismissible" role="alert">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?= $message ?>
                        </div>
                    <?php endif; ?>
                    
                    <form action="<?= BASE_URL . $formAction . "edit/" . $getId["ID_ROK"] ?>" method="post" class="form-horizontal">
                        <div class="form-group">
                            <input type="text" class="form-control" name="DATUM_ROKA"
                                value="<?php list($y, $m, $d) = explode('-', $getId["DATUM_ROKA"]); echo $d."-".$m."-".$y;?>"
                                placeholder="Datum: vnesi kot DD-MM-YYYY" pattern="[0-9]{2}-[0-9]{2}-[0-9]{4}" required autofocus>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="CAS_ROKA" value="<?= $getId['CAS_ROKA']?>" placeholder="Cas: vnesi kot HH:MM:SS" pattern="[0-2][0-9]:[0-5][0-9]:[0-5][0-9]" required>
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="ID_IZVEDBA" required>
                                <?php foreach ($IdIzvedbaPredmeta as $idIP):
                                    if ($getId['ID_IZVEDBA'] == $idIP["ID_IZVEDBA"]): ?>
                                        <option selected value="<?= $idIP["ID_IZVEDBA"] ?>"><?= $idIP["IME_PREDMET"] ?></option>
                                    <?php else: ?>
                                        <option value="<?= $idIP["ID_IZVEDBA"] ?>"><?= $idIP["IME_PREDMET"] ?></option>
                                    <?php endif;
                                endforeach; ?>
                            </select>
                        </div>
                        <button id="btn" class="btn btn-theme btn-block" type="submit">Spremeni</button>
                    </form>
                    
                </div>
            </div>
        </section>
    </section>
</section>
</body>
</html>
