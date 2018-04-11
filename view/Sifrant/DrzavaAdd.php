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
                    <form  action="<?= BASE_URL . "DrzavaAdd/dodaj" ?>" method="post" class="form-horizontal">
                        <div class="form-group">
                            <input type="text" class="form-control" name="dvomestnakoda" placeholder="DVOMESTNA KODA" required autofocus>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="trimestnakoda" placeholder="TRIMESTNA KODA" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="isonaziv" placeholder="ISONAZIV" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="slonaziv" placeholder="SLOVENSKI NAZIV" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="opomba" placeholder="Opomba" required>
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
