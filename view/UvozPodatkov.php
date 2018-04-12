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
                    <form action="<?= BASE_URL . "UvozPodatkov/parse" ?>" method="post">
                        Vnesi podatke:<br>
                        <textarea rows="20" cols="50" type="text" name="podatkiInput"></textarea><br>
                        <input type="submit" value="Submit">
                    </form>
                </div>
            </div>
            </div>
        </section>
    </section>
</section>
</body>
</html>



