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
                        <h3>Urejanje države</h3>
                    <br>
                    <form  action="<?= BASE_URL . "DrzavaAll/edit" ?>" method="post" class="form-horizontal">
                        <input type="hidden" name="urediId" value="<?= $getId["ID_DRZAVA"] ?>"  />
                        <div class="form-group">
                            <input type="text" class="form-control" name="dvomestnakoda" maxlength="2" value="<?= $getId['DVOMESTNAKODA']?>" required autofocus>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="trimestnakoda" maxlength="3" value="<?= $getId['TRIMESTNAKODA']?>" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="isonaziv" value="<?= $getId['ISONAZIV']?>" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="slonaziv" value="<?= $getId['SLOVENSKINAZIV']?>" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="opomba" value="<?= $getId['OPOMBA']?>">
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
