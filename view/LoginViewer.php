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
                <form action="<?= BASE_URL . $formAction ?>" method="post" class="form-login">
                    <h2 class="form-login-heading">sign in now</h2>
                    <div class="login-wrap">
                        <input type="text" class="form-control" name="email" placeholder="Email" required autofocus>
                        <br>
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                        <br>
                        <button id="btn-login" class="btn btn-theme btn-block" type="submit"><i class="fa fa-lock"></i> SIGN IN</button>
                        <br>
                        <span class="psw"><h6><a href="#">Forgot password?</h6></a></span>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>