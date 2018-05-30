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
                    <h3>Dodajanje novega izvajalca</h3>
                    <br>
                    <form  action="<?= BASE_URL . "PodatkiIzvajalcev/dodaj" ?>" method="post" class="form-horizontal">
                        <div class="form-group">
                            <input type="text" class="form-control" name="ime" placeholder="Ime izvajalca" required autofocus>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="priimek" placeholder="Priimek izvajalca" required >
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="email" placeholder="Email izvajalca" >
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="username" placeholder="Uporabniško ime izvajalca" >
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="telefon" placeholder="Telefonska stevilka izvajalca" >
                        </div>
                        <button id="btn" class="btn btn-theme btn-block" type="submit">Dodaj</button>
                    </form>
                </div>
            </div>
            </div>
        </section>
    </section>
</section>
</body>
</html>
