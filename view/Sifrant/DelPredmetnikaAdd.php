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
                    <h3>Dodajanje dela predmetnika</h3>
                    <br>
                    <?php if(isset($status)): ?>
                        <div class="alert alert-<?= ($status === "Failure") ? "danger" : (($status === "Success") ? "success" : "info") ?> alert-dismissible" role="alert">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?= $message ?>
                        </div>
                    <?php endif; ?>
                    <form  action="<?= BASE_URL . "DelPredmetnikaAdd/dodaj" ?>" method="post" class="form-horizontal">
                        <div class="form-group">
                            <input type="text" class="form-control" name="naziv_delpredmetnika" placeholder="NAZIV DELA PREDMETNIKA" required autofocus>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="st_Kt" placeholder="Stevilo kreditov" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="tip" placeholder="Tip" required>
                        </div>
                        <button id="btn" class="btn btn-theme btn-block" data-toggle="modal" data-target="#myModal" type="submit">Ustvari</button>
                    </form>
                </div>
            </div>
            </div>
        </section>
    </section>
</section>
</body>
</html>
