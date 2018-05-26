<!DOCTYPE html>

<html lang="en">
    <head>
        <?php include("view/includes/head.php"); ?>
        <script type="text/javascript" src="<?= JS_URL . "vpisScript.js" ?>"></script>
    </head>
    <body>
        <section id="container">
            <?php include("view/includes/menu-links-student.php"); ?>
                <section id="main-content">
                    <section class="wrapper">
                    
                        <h2 class="text-center"><?= $pageTitle ?></h2>
                        <?php if(isset($status)): ?>
                            <div class="alert alert-<?= ($status === "Failure") ? "danger" : (($status === "Success") ? "success" : "info") ?> alert-dismissible" role="alert">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?= $message ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= BASE_URL . $formAction ?>" method="post" class="form-horizontal">
                            <input type="hidden" name="email" value="<?= $KandidatPodatki["email"] ?>" />
                            <div class="row">
                                <div class="col-xs-12 col-md-4">
                                    <h3>Osebni podatki</h3>
                                    <div class="form-group">
                                        <label for="Ime">Ime</label>
                                        <input type="text" class="form-control" id="Ime" name="Ime" value="<?= $KandidatPodatki["ime"] ?>" required disabled autofocus>
                                    </div>
                                    <div class="form-group">
                                        <label for="Priimek">Priimek</label>
                                        <input type="text" class="form-control" id="Priimek" name="Priimek" value="<?= $KandidatPodatki["priimek"] ?>" required disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="Email">Email</label>
                                        <input type="text" class="form-control" id="Email" name="Email" value="<?= $KandidatPodatki["email"] ?>" required disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="emso">EMŠO</label>
                                        <input type="number" class="form-control" id="emso" name="emso" value="<?= $KandidatPodatki["emso"] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="telefonska_stevilka">Telefon</label>
                                        <input type="number" class="form-control" id="telefonska_stevilka" name="telefonska_stevilka" value="<?= $KandidatPodatki["telefonska_stevilka"] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="id_drzava">Državljanstvo</label>
                                        <select class="form-control" id="id_drzava" name="id_drzava" required>
                                            <option selected disabled hidden></option>
                                            <?php foreach ($drzave as $drzava): ?>
                                                <option value="<?= $drzava["ID_DRZAVA"] ?>"><?= $drzava["SLOVENSKINAZIV"] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-4">
                                    <?php
                                    $i = 1;
                                    foreach ($naslove as $naslov): ?>
                                        <input type="hidden" value="<?= $naslov["ID_NASLOV"] ?>" name="id_naslov<?= $i ?>">
                                        <?php if ($naslov["JE_ZAVROCANJE"]==1 && $naslov["JE_STALNI"]==1): ?>
                                            <h3>Stalni in tudi naslov za vrocanje</h3>
                                        <?php elseif ($naslov["JE_STALNI"]==1): ?>
                                            <h3>Stalni naslov</h3>
                                        <?php elseif ($naslov["JE_ZAVROCANJE"]==1): ?>
                                            <h3>(Zacasni) Naslov za vrocanje</h3>
                                        <?php endif; ?>

                                        <div class="form-group">
                                            <label for="id_drzava<?= $i ?>">Država</label>
                                            <select class="form-control" id="id_drzava<?= $i ?>" name="id_drzava<?= $i ?>" required>
                                                <?php foreach ($drzave as $drzava):
                                                    if ($naslov["ID_DRZAVA"] == $drzava["ID_DRZAVA"]): ?>
                                                        <option selected value="<?= $drzava["ID_DRZAVA"] ?>"><?= $drzava["SLOVENSKINAZIV"] ?></option>
                                                    <?php else: ?>
                                                        <option value="<?= $drzava["ID_DRZAVA"] ?>"><?= $drzava["SLOVENSKINAZIV"] ?></option>
                                                    <?php endif;
                                                endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="ulica<?= $i ?>">Ulica</label>
                                            <input type="text" class="form-control" id="ulica<?= $i ?>" name="ulica<?= $i ?>" value="<?= $naslov["ULICA"] ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="id_posta<?= $i ?>">Kraj in poštna številka</label>
                                            <select class="form-control" id="id_posta<?= $i ?>" name="id_posta<?= $i ?>" required>
                                                <?php foreach ($poste as $posta):
                                                    if ($naslov["ID_POSTA"] == $posta["ID_POSTA"]): ?>
                                                        <option selected value="<?= $posta["ID_POSTA"] ?>"><?= $posta["KRAJ"]." (".$posta["ST_POSTA"].")" ?></option>
                                                    <?php else: ?>
                                                        <option value="<?= $posta["ID_POSTA"] ?>"><?= $posta["KRAJ"]." (".$posta["ST_POSTA"].")" ?></option>
                                                    <?php endif;
                                                endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="id_obcina<?= $i ?>">Občina</label>
                                            <select class="form-control" id="id_obcina<?= $i ?>" name="id_obcina<?= $i ?>" required>
                                                <?php foreach ($obcine as $obcina):
                                                    if ($naslov["ID_OBCINA"] == $obcina["ID_OBCINA"]): ?>
                                                        <option selected value="<?= $obcina["ID_OBCINA"] ?>"><?= $obcina["IME_OBCINA"] ?></option>
                                                    <?php else: ?>
                                                        <option value="<?= $obcina["ID_OBCINA"] ?>"><?= $obcina["IME_OBCINA"] ?></option>
                                                    <?php endif;
                                                endforeach; ?>
                                            </select>
                                        </div>
                                        <?php
                                        $i=$i+1;
                                    endforeach;
                                    ?>
                                </div>
                                <div class="col-xs-12 col-md-4">
                                    <h3>Podatki o vpisu</h3>
                                    <div class="form-group">
                                        <label for="id_naziv_program">Študijski program</label>
                                        <select class="form-control" id="id_naziv_program" name="id_naziv_program" required disabled>
                                            <option value=""><?= $KandidatPodatki["naziv_program"] ?></option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="ID_STUD_LETO">Študijsko leto</label>
                                        <select class="form-control" id="ID_STUD_LETO" name="ID_STUD_LETO" required disabled>
                                            <option value=""><?= $stud_leto["STUD_LETO"] ?></option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="vpisna_stevilka">Vpisna številka</label>
                                        <input type="text" class="form-control" id="vpisna_stevilka" name="vpisna_stevilka" value="<?= $KandidatPodatki["vpisna_stevilka"] ?>" required disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="UPORABNISKO_IME">Uporabniško Ime</label>
                                        <input type="text" class="form-control" id="word" name="UPORABNISKO_IME" value="<?= $userName ?>" required disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-md-6 offset-md-3">
                                    <h3>Tvoji predmetnik</h3>
                                    <table id="table-subject" class="table table-striped table-advance table-hover">
                                        <thead>
                                        <tr>
                                            <th>Ime predmeta</th>
                                            <th>St. KKT</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $vsota=0;
                                        foreach($predmeti as $predmet):
                                            $vsota+=$predmet['ST_KREDITNIH_TOCK']; ?>
                                            <tr>
                                                <td><?php echo $predmet['IME_PREDMET']; ?></td>
                                                <td><?php echo $predmet['ST_KREDITNIH_TOCK']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td>Skupno st. KKT</td>
                                            <td><?php echo $vsota; ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-md-6 offset-md-3">
                                    <div class="form-group">
                                        <label for="StrIzbPredmeti">StrIzbPredmeti</label>
                                        <select class="form-control selectpicker" multiple id="StrIzbPredmeti" name="StrIzbPredmeti[]">
                                            <?php foreach ($StrIzbPredmeti as $StrIzbPredmet): ?>
                                                <option value="<?= $StrIzbPredmet["ID_PREDMET"] ?>"><?= $StrIzbPredmet["IME_PREDMET"]." (".$StrIzbPredmet["ST_KREDITNIH_TOCK"].")" ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="SplIzbPredmeti">SplIzbPredmeti</label>
                                        <select class="form-control selectpicker" multiple id="SplIzbPredmeti" name="SplIzbPredmeti[]">
                                            <?php foreach ($SplIzbPredmeti as $SplIzbPredmet): ?>
                                                <option value="<?= $SplIzbPredmet["ID_PREDMET"] ?>"><?= $SplIzbPredmet["IME_PREDMET"]." (".$SplIzbPredmet["ST_KREDITNIH_TOCK"].")" ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-md-6 offset-md-3">
                                    <button id="btn" class="btn btn-theme btn-block" type="submit">Oddaj</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
            </section>
        </section>
    </body>
</html>
