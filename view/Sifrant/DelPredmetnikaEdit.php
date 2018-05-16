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
                <div class="col-xs-12 col-md-6">
                    <br>
                        <h3>Urejanje dela predmetnika</h3>
                    <br>
                    <?php if(isset($status)): ?>
                        <div class="alert alert-<?= ($status === "Failure") ? "danger" : (($status === "Success") ? "success" : "info") ?> alert-dismissible" role="alert">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?= $message ?>
                        </div>
                    <?php endif; ?>
                    <form  action="<?= BASE_URL . "DelPredmetnikaAll/edit" ?>" method="post" class="form-horizontal">
                        <input type="hidden" name="urediId" value="<?= $getId["ID_DELPREDMETNIKA"] ?>"  />
                        <div class="form-group">
                            Naziv
                            <input type="text" class="form-control" name="naziv_delpredmetnika" value="<?= $getId['NAZIV_DELAPREDMETNIKA']?>" required autofocus>
                        </div>
                        <div class="form-group">
                            Šifra
                            <input type="text" class="form-control" name="noviId" value="<?= $getId['ID_DELPREDMETNIKA']?>" required autofocus>
                        </div>
                        <div class="form-group">
                            Skupno število KT
                            <input type="text" class="form-control" name="st_Kt" value="<?= $getId["SKUPNOSTEVILOKT"]?>" required>
                        </div>
                        <div class="form-group">
                            Tip
                            <input type="text" class="form-control" name="tip" value="<?= $getId["TIP"]?>" required>
                        </div>
                        <button id="btn" class="btn btn-theme btn-block"  type="submit">Spremeni</button>
                    </form>
                </div>
            </div>
            </div>
        </section>
    </section>
</section>
</body>
</html>
