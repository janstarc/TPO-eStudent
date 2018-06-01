<!DOCTYPE html>

<html lang="en">
    <head>
        <?php include("view/includes/head.php"); ?>
        <script>
            function myFunction() {
                var txt;
                if (confirm("Pozor! S klikom na 'ok' boste odjavili tudi vse prijavljene študente!")) {
                    txt = "You pressed OK!";
                } else {
                    window.refresh()
                }
                document.getElementById("demo").innerHTML = txt;
            }
        </script>
    </head>
    <body>
        <section id="container">
            <?php include("view/includes/menu-links-student-officer.php"); ?>
            <section id="main-content">
                <section class="wrapper">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="content-panel">
                                <div class="row">
                                    <h2><?= $pageTitle ?></h2>
                                    <form action="<?= BASE_URL . $formAction . $idOseba . "/add/" ?>" method="get">
                                        <div class="col-xs-12 col-md-6">
                                            <input class="btn btn-primary btn-sm" type="submit" value="Ustvari nov" />
                                        </div>
                                    </form>
                                </div>
                                <?php if(isset($status)): ?>
                                    <div class="alert alert-<?= ($status === "Failure") ? "danger" : (($status === "Success") ? "success" : "info") ?> alert-dismissible" role="alert">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <?= $message ?>
                                    </div>
                                <?php endif; ?>
                                <table id="table-subject" class="table table-striped table-advance table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Predmet</th>
                                        <th>Datum</th>
                                        <th>Cas</th>
                                        <th>Stevilo prijavljenih</th>
                                        <th>Uredi</th>
                                        <th>Deaktiviraj</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1; foreach($roki as $rok): ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $rok['IME_PREDMET']; ?></td>
                                            <td>
                                                <?php
                                                    list($y, $m, $d) = explode('-', $rok["DATUM_ROKA"]);
                                                    echo $d."-".$m."-".$y;
                                                ?>
                                            </td>
                                            <td><?php echo $rok['CAS_ROKA']; ?></td>
                                            <td><?php echo $rok['StevlioPrijavljenih']; ?></td>
                                            <td>
                                                <form action="<?= BASE_URL . $formAction . $idOseba . "/edit/" . $rok["ID_ROK"] ?>" method="get">
                                                    <input class="btn btn-primary btn-sm" type="submit" value="Uredi" />
                                                </form>
                                            </td>
                                            <td>
                                                <form  action="<?= BASE_URL . $formAction . $idOseba . "/toogleActivated" ?>" method="post">
                                                    <input type="hidden" name="activateId" value="<?= $rok["ID_ROK"] ?>" />
                                                    <?php if(!$rok["AKTIVNOST"]) : ?>
                                                        <input class="btn btn-success btn-sm" type="submit" value="Activate" />
                                                    <?php else : ?>
                                                        <input onclick="return confirm('Pozor! S klikom na \'OK\' boste odjavili vse prijavljene študente!');" class="btn btn-danger btn-sm" type="submit" value="Deactivate" />
                                                    <?php endif; ?>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php $i = $i + 1; endforeach; ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    
                    </div>
                </section>
            </section>
        </section>
    </body>
</html>
