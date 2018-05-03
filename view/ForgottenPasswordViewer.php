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
                                Forgotten password
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
                                <div class="form-group">
                                    <label for="email">Enter your email address and we will send you a link to reset your password</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                                </div>
                                <button id="btn" class="btn btn-primary btn-block" type="submit">Send email to reset password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>