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
                <div class="col-xs-12 col-md-8">
                    <br>
                    <h3>Dodajanje nove države</h3>
                    <br>
                    <form  action="<?= BASE_URL . "DrzavaAdd/dodaj" ?>" method="post" class="form-horizontal">
                        <div class="form-group">
                            <input type="text" class="form-control" name="dvomestnakoda" maxlength="2" placeholder="DVOMESTNA KODA" required autofocus>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="trimestnakoda" maxlength="3" placeholder="TRIMESTNA KODA" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="isonaziv" placeholder="ISONAZIV" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="slonaziv" placeholder="SLOVENSKI NAZIV" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="opomba" placeholder="Opomba">
                        </div>
                        <button id="btn" class="btn btn-theme btn-block"  type="submit">Ustvari</button>
                    </form>
                </div>
            </div>
            </div>
        </section>
    </section>
</section>
</body>
</html>
