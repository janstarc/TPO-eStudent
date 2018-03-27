<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Študij</title>
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "bootstrap.css" ?>">
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">

    <script type="text/javascript" src="<?= JS_URL . "jquery.js" ?>"></script>
    <script type="text/javascript" src="<?= JS_URL . "bootstrap.min.js" ?>"></script>
    <script type="text/javascript" src="<?= JS_URL . "jquery.backstretch.min.js" ?>"></script>

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
        <form class="form-login" id="okno">
            <h2 class="form-login-heading">sign in now</h2>
            <div class="login-wrap">
                <input type="text" class="form-control" id="login-username" placeholder="Email" autofocus>
                <br>
                <input type="password" class="form-control" id="login-password" placeholder="Password">
                <br>
                <button id="btn-login" class="btn btn-theme btn-block" type="submit">
                    <i class="fa fa-lock"></i> SIGN IN</button>
                <br>
                <div class="container">
                            <span>
                                <label>
                                    <input type="checkbox" checked="checked" name="remember"> Remember me
                                </label>
                            </span>
                    <span class="psw" align="right "><h6><a href="#">Forgot password?</h6></a></span>
                </div>
                <hr>

            </div>
        </form>
    </div>
</div>
</body>
</html>