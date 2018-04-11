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
                    <form  action="<?= BASE_URL . "StudijskoLetoAdd/dodaj" ?>" method="post" class="form-horizontal">
                        <div class="form-group">
                            <input type="text" class="form-control" name="stud_leto" placeholder="Studijsko leto" required autofocus>
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
