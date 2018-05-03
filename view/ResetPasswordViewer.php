<!DOCTYPE html>

<html lang="en">
    <head>
        <?php include("view/includes/head.php"); ?>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="card card-login">
                        <div class="card-header">
                            <form action="<?= BASE_URL . "login" ?>" method="get">
                                Reset password
                                <button class="btn-xs btn-primary float-sm-right" type="submit">Log in</button>
                            </form>
                        </div>
                        <div class="card-body">
                            <?php if(isset($status)): ?>
                                <div class="alert alert-<?= ($status === "Failure") ? "danger" : (($status === "Success") ? "success" : "info") ?> alert-dismissible" role="alert">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <?= $message ?>
                                </div>
                            <?php endif; ?>
                            <form action="<?= BASE_URL . $formAction ?>" method="post">
                                <input type="hidden" name="token" value="<?= $_GET["token"] ?>" />
                                <div class="form-group">
                                    <label for="new-password">Vnesi novo geslo</label>
                                    <input type="password" class="form-control" id="new-password" name="new-password" placeholder="Novo geslo" required autofocus>
                                </div>
                                <div class="form-group">
                                    <label for="retype-password">Potrdi novo geslo se enkrat</label>
                                    <input type="password" class="form-control" id="retype-password" name="retype-password" placeholder="Novo geslo se enkrat" required>
                                </div>
                                <button id="btn" class="btn btn-primary btn-block" type="submit">Reset</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>