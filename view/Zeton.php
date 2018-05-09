<?php
$resultFound = false;
if(!empty($zetoni)) $resultFound = true;
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <?php include("view/includes/head.php");


    ?>
</head>
<body>
<section id="container">
    <?php include("view/includes/menu-links-student-officer.php"); ?>
    <section id="main-content">
        <section class="wrapper">
            <div class="row">
                <div class="col-md-12">
                    <div class="content-panel">
                        <h3>Iskanje osebe za urejanje žetona</h3>
                        <br>
                        <form class="subject" action="<?= BASE_URL . "zeton/EMSOSearch" ?>" method="post">
                            <input type="hidden" name="tip" value="n" />
                            <input type="text" placeholder="IŠČI OSEBO PO VPISNI ŠTEVILKI" name="searchEMSO">
                            <button type="submit">Išči</button>
                        </form>
                        <br>
                        <br>
                        <hr>
                        <h4>Prikaz žetonov: </h4>
                        <br>
                        <br>
                        <br>
                        <table id="table-subject" class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th>Ime</th>
                                <th>Priimek</th>
                                <th>Vpisna številka</th>
                                <th>Letnik</th>
                                <th>Študijsko leto</th>
                                <th>Način študija</th>
                                <th>Oblika študija</th>
                                <th>Vrsta vpisa</th>
                                <th>Program</th>
                                <th>Izkoriščen</th>
                                <th>Veljavnost</th>
                                <th>Spremeni veljavnost</th>

                                <th>Dodaj žeton za naslednje leto</th>
                                <th>Uredi</th>

                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            $n =0;
                            foreach($zetoni as $key=>$value):

                                $n+=1;
                                $aktivnost =  $value["ACT"];
                                if($aktivnost == 1) $aktivnost = "Aktiven" ; else $aktivnost = "Neaktiven" ;
                                $izkoriscen = $value["IZKORISCEN"];
                                if ($izkoriscen == 1) $izkoriscen = "Da"; else $izkoriscen = "Ne";
                                ?>

                                <tr>
                                    <td><?php echo $value['IME'] ; ?></td>
                                    <td><?php echo $value['PRIIMEK'] ; ?></td>
                                    <td><?php echo $value['VPISNA_STEVILKA']; ?></td>
                                    <td><?php echo $value['LETNIK']; ?></td>
                                    <td><?php echo $value['STUD_LETO']; ?></td>
                                    <td><?php echo $value['OPIS_NACIN']; ?></td>
                                    <td><?php echo $value['NAZIV_OBLIKA'] ; ?></td>
                                    <td><?php echo $value['OPIS_VPISA']; ?></td>
                                    <td><?php echo $value['SIFRA_EVS']; ?></td>
                                    <td><?php echo $izkoriscen; ?></td>

                                    <td><?php echo $aktivnost; ?></td>

                                    <td>
                                        <form  action="<?= BASE_URL . "zeton/EMSOSearch" ?>" method="post">
                                            <input type="hidden" name="searchEMSO" value="<?= $value["VPISNA_STEVILKA"] ?>" />
                                            <input type="hidden" name="idZeton" value="<?= $value["ID_ZETON"] ?>" />
                                            <input type="hidden" name="Aktivnost" value="<?= $value["ACT"] ?>" />
                                            <input type="hidden" name="tip" value="d" />
                                            <?php if($izkoriscen == "Ne") : ?>
                                            <?php if($value["ACT"] == 0) : ?>
                                                <input class="btn btn-success btn-sm" type="submit" value="Activate" />
                                            <?php else : ?>
                                                <input class="btn btn-danger btn-sm" type="submit" value="Deactivate" />
                                            <?php endif; ?>
                                            <?php endif; ?>
                                        </form>
                                    </td>
                                    <td>
                                        <?php if($n==1) : ?>
                                        <form action="<?= BASE_URL . "zeton/dodaj" ?>" method="post">
                                             <input type="hidden" name="idZeton" value=<?=  $value["ID_ZETON"] ?> />
                                             <input class="btn btn-primary btn-sm" type="submit" value="Dodaj" />
                                        </form>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <form action="<?= BASE_URL . "zeton/uredi" ?>" method="post">
                                            <input type="hidden" name="idZeton" value=<?=  $value["ID_ZETON"] ?> />
                                            <input class="btn btn-primary btn-sm" type="submit" value="Uredi" />
                                        </form>
                                    </td>

                                </tr>

                            <?php endforeach; ?>

                            </tbody>
                            <div  <?php if ($resultFound){ echo 'style="display:none;"'; } ?>>
                                <p></p>
                            </div>
                            <div  <?php if (!$resultFound){ echo 'style="display:none;"'; } ?>>
                                <form  action="<?= BASE_URL . "zeton/povprecje" ?>" method="post">
                                    <input type="hidden" name="searchVpisna" value="<?= $zetoni['0']['VPISNA_STEVILKA'] ?>"/>
                                    <input id="povprecje" class="btn btn-primary btn-sm"  type="submit" value="Prikazi povprecje"/>
                                </form>
                            </div>
                        </table>


                    </div>
                </div>
            </div>


        </section>
    </section>
</section>
</body>
</html>