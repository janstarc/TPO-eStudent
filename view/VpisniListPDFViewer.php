<!DOCTYPE html>

<html lang="en">
    <head>
        <?php include("view/includes/head.php"); ?>
        <script type="text/javascript" src="<?= JS_URL . "vpisScript.js" ?>"></script>
    </head>
    <body>
        <section id="container">
            <?php include("view/includes/menu-links-".$vloga.".php"); ?>
                <section id="main-content">
                    <section class="wrapper">
                    

                        <?php if(isset($status)): ?>
                            <div class="alert alert-<?= ($status === "Failure") ? "danger" : (($status === "Success") ? "success" : "info") ?> alert-dismissible" role="alert">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?= $message ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= BASE_URL . "studenti/".$id."/exportPDFTiskaj"  ?>" method="post" class="form-horizontal">


                                <div class="row">
                                    <div class="col-xs-12 col-md-6 offset-md-3">
                                        <button id="btn" class="btn btn-theme btn-block" type="submit">Tiskanje</button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </section>
            </section>
        </section>
    </body>
</html>
