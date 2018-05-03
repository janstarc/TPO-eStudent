<!DOCTYPE html>

<html lang="en">
    <head>
        <?php include("view/includes/head.php"); ?>
        <style>
            body {
                background-image: url("<?= IMAGES_URL. "login-bg.jpg" ?>");
                background-repeat: no-repeat;
                background-size: cover;
            }
        </style>
    </head>
    <body>
        <div id="login-page">
            <div class="container">
                <div class="form-login">
                    <form action="<?= BASE_URL . $formAction ?>" method="post" class="">
                        <h2 class="form-login-heading">sign in now</h2>
                        <div class="login-wrap">
                            <input type="text" class="form-control" name="email" placeholder="Email" required autofocus>
                            <br>
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                            <br>
                            <button id="btn-login" class="btn btn-theme btn-block" type="submit"><i class="fa fa-lock"></i> SIGN IN</button>
                        </div>
                    </form>
                    <?php if(isset($status)): ?>
                        <div class="alert alert-<?= ($status === "Failure") ? "danger" : (($status === "Success") ? "success" : "info") ?> alert-dismissible" role="alert">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?= $message ?>
                        </div>
                    <?php endif; ?>
                    <form action="<?= BASE_URL . "forgottenPassword" ?>" method="get" class="">
                        <button class="btn-xs btn-block btn-danger" type="submit">Forgotten password?</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>