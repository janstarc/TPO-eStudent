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
                    <h3>Urejanje načina študija</h3>
                    <br>
                    <form  action="<?= BASE_URL . "NacinStudijaAll/edit" ?>" method="post" class="form-horizontal">
                        <input type="hidden" name="urediId" value="<?= $getId["ID_NACIN"] ?>"  />
                        Opis
                        <div class="form-group">
                            <input type="text" class="form-control" name="opis" value="<?= $getId['OPIS_NACIN']?>" required autofocus>
                        </div>
                        Šifra
                        <div class="form-group">
                            <input type="text" class="form-control" name="id" value="<?= $getId['ID_NACIN']?>" required autofocus>
                        </div>
                        Angleški opis načina
                        <div class="form-group">
                            <input type="text" class="form-control" name="angopis" value="<?= $getId['ANG_OPIS_NACIN']?>" required>
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
