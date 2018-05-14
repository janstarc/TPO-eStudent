<!DOCTYPE html>

<html lang="en">
<head>
    <?php include("view/includes/head.php");  ;?>
</head>
<body>
<section id="container">
    <?php include("view/includes/menu-links-student-officer.php"); ?>
    <section id="main-content">
        <section class="wrapper">
            <div class="row">

                <div class="col-md-12">
                    <div class="content-panel">

                        <h2><?= $pageTitle ?></h2>
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
                                <th>Ime</th>
                                <th>Priimek</th>
                                <th>Študijsko leto</th>
                                <th>Letnik</th>
                                <th>Način študija</th>
                                <th>Oblika študija</th>
                                <th>Vrsta vpisa</th>
                                <th>Program</th>
                                <th>Prosta izbirnost</th>
                                <th>Izkoriščen</th>
                                <th>Veljavnost</th>
                                <th>Spremeni veljavnost</th>
                                <th>Uredi</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            $n =0;

                            foreach($allData as $data):

                                $n+=1;
                                $aktivnost =  $data["ACT"];
                                if($aktivnost == 1) $aktivnost = "Aktiven" ; else $aktivnost = "Neaktiven" ;
                                $izkoriscen = $data["IZKORISCEN"];
                                if ($izkoriscen == 1) $izkoriscen = "Da"; else $izkoriscen = "Ne";

                                $izbirnost = $data['PROSTA_IZBIRNOST'];
                                if ($izbirnost == 1) $izbirnost = "Da"; else $izbirnost = "Ne";

                                ?>
                                <tr>
                                    <td><?php echo $n ; ?></td>
                                    <td><?php echo $data['IME'] ; ?></td>
                                    <td><?php echo $data['PRIIMEK'] ; ?></td>
                                    <td><?php echo $data['STUD_LETO']; ?></td>
                                    <td><?php echo $data['LETNIK']; ?></td>
                                    <td><?php echo $data['OPIS_NACIN']; ?></td>
                                    <td><?php echo $data['NAZIV_OBLIKA'] ; ?></td>
                                    <td><?php echo $data['OPIS_VPISA']; ?></td>
                                    <td><?php echo $data['SIFRA_EVS']; ?></td>
                                    <td><?php echo $izbirnost ?></td>
                                    <td><?php echo $izkoriscen; ?></td>

                                    <td><?php echo $aktivnost; ?></td>
                                    <td>
                                        <form  action="<?= BASE_URL . "zetoni/toogleActivated/" ?>"  method="post">
                                            <input type="hidden" name="IdZeton" value="<?= $data["ID_ZETON"] ?>" />
                                            <input type="hidden" name="IdOseba" value="<?= $id ?>" />

                                            <?php if($izkoriscen == "Ne") : ?>
                                                <?php if($data["ACT"] == 0) : ?>
                                                    <input class="btn btn-success btn-sm" type="submit" value="Activate" />
                                                <?php else : ?>
                                                    <input class="btn btn-danger btn-sm" type="submit" value="Deactivate" />
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </form>
                                    </td>


                                    <td>
                                        <form action="<?= BASE_URL . "zetoni/uredi/" .$data["ID_ZETON"] ?>"  method="get">
                                            <input class="btn btn-primary btn-sm" type="submit" value="Uredi" />
                                        </form>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
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
