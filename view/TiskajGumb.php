<!DOCTYPE html>

<html lang="en">
<head>
    <?php include("view/includes/head.php"); ?>
    <script type="text/javascript" src="<?= JS_URL . "vpisScript.js" ?>"></script>
</head>
<body>
<section id="container">
    <?php if(User::isLoggedInAsStudent())
        include("view/includes/menu-links-student.php");
        else  include("view/includes/menu-links-kandidat.php");
    ?>
    <section id="main-content">
        <section class="wrapper">

            <?php if($jeIzkoriscen==0): ?>
            <form action="<?= BASE_URL . "studenti/".$id."/exportPDFTiskaj"  ?>" method="post" class="form-horizontal">
                <div class="row">
                    <div class="col-xs-12 col-md-6 offset-md-3">
                        <button id="btn" class="btn btn-theme btn-block" type="submit" style="display: none">Tiskanje</button>
                    </div>
                </div>
            </form>
            <?php else:?>
                <form action="<?= BASE_URL . "studenti/".$id."/exportPDFTiskaj"  ?>" method="post" class="form-horizontal">
                    <div class="row">
                        <div class="col-xs-12 col-md-6 offset-md-3">
                            <button id="btn" class="btn btn-theme btn-block" type="submit" style="display: inline">Tiskanje</button>
                        </div>
                    </div>
                </form>
            <?php endif; ?>
            </div>
        </section>
    </section>
</section>
</body>
</html>
