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
                    <h3>Urejanje predemta</h3>
                    <br>
                    <form  action="<?= BASE_URL . "PredmetAll/edit" ?>" method="post" class="form-horizontal">
                        <input type="hidden" name="urediId" value="<?= $getId["ID_PREDMET"] ?>"  />
                        <div class="form-group">
                            <input type="text" class="form-control" name="predmet" value="<?= $getId['IME_PREDMET']?>" required autofocus>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="id" value="<?= $getId['SIFRA_PREDMET']?>" required autofocus>
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
