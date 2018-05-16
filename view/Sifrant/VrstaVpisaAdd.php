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
                    <h3>Vnos novo vrsto vpisa</h3>
                    <br>
                    <form  action="<?= BASE_URL . "VrstaVpisaAdd/dodaj" ?>" method="post" class="form-horizontal">
                        <div class="form-group">
                            <input type="text" class="form-control" name="opis" placeholder="Opis vrste" required autofocus>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="id" placeholder="Šifra" required autofocus>
                        </div>

                        <button id="btn" class="btn btn-theme btn-block" type="submit">Ustvari</button>
                    </form>
                </div>
            </div>
            </div>
        </section>
    </section>
</section>
</body>
</html>
