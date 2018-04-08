<!DOCTYPE html>

<html lang="en">
    <head>
        <?php include("view/includes/head.php"); ?>
    </head>
    <body>
        <form action="<?= BASE_URL . $formAction ?>" method="post" class="form-login">
            <input type="text" class="form-control" name="email" placeholder="Email" required autofocus>
            <input type="password" class="form-control" name="password" placeholder="Password" required>
            <button id="btn-login" class="btn btn-theme btn-block" type="submit"><i class="fa fa-lock"></i> SIGN IN</button>
        </form>
    </body>
</html>
