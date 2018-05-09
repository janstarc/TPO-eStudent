<!DOCTYPE html>

<html lang="en">
    <head>
        <?php include("view/includes/head.php"); ?>
        <script type="text/javascript" src="<?= JS_URL . "vpisScript.js" ?>"></script>
    </head>
    <body>
        <section id="container">
            <?php include("view/includes/menu-links-student-officer.php"); ?>
                <section id="main-content">
                    <section class="wrapper">
                    
                        <h2 class="text-center"><?= $pageTitle ?></h2>
                        <?php if(isset($status)): ?>
                            <div class="alert alert-<?= ($status === "Failure") ? "danger" : (($status === "Success") ? "success" : "info") ?> alert-dismissible" role="alert">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?= $message ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= BASE_URL . $formAction . "/" . $id ?>" method="post" class="form-horizontal">
                            <div class="row">
                                <div class="col-xs-12 col-md-4">
                                    <h3>Osebni podatki</h3>
                                    <div class="form-group">
                                        <label for="Ime">Ime</label>
                                        <input type="text" class="form-control" id="Ime" name="Ime" value="<?= $KandidatPodatki["ime"] ?>" required  autofocus>
                                    </div>
                                    <div class="form-group">
                                        <label for="Priimek">Priimek</label>
                                        <input type="text" class="form-control" id="Priimek" name="Priimek" value="<?= $KandidatPodatki["priimek"] ?>" required >
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
                                            <?php foreach ($drzave as $drzava):
                                                if ($naslove[0]["ID_DRZAVA"] == $drzava["ID_DRZAVA"]): ?>
                                                    <option selected value="<?= $drzava["ID_DRZAVA"] ?>"><?= $drzava["SLOVENSKINAZIV"] ?></option>
                                                <?php else: ?>
                                                    <option value="<?= $drzava["ID_DRZAVA"] ?>"><?= $drzava["SLOVENSKINAZIV"] ?></option>
                                                <?php endif;
                                            endforeach; ?>
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
                                            <h3>Naslov za vrocanje</h3>
                                        <?php else: ?>
                                            <h3>Zacasni naslov</h3>
                                        <?php endif; ?>
                                        
                                        <div class="form-group">
                                            <label for="ulica<?= $i ?>">Ulica</label>
                                            <input type="text" class="form-control" id="ulica<?= $i ?>" name="ulica<?= $i ?>" value="<?= $naslov["ULICA"] ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="hisna_stevilka<?= $i ?>">Hišna številka</label>
                                            <input type="number" class="form-control" id="hisna_stevilka<?= $i ?>" name="hisna_stevilka<?= $i ?>" value="<?= $naslov["HISNA_STEVILKA"] ?>" required>
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
                                    <?php
                                        $i=$i+1;
                                        endforeach;
                                    ?>
                                </div>
                                <div class="col-xs-12 col-md-4">
                                    <h3>Podatki o vpisu</h3>
                                    <div class="form-group">
                                        <label for="id_naziv_program">Študijski program</label>
                                        <select class="form-control" id="ID_STUD_LETO" name="ID_STUD_LETO" required>
                                            <?php foreach ($StudijskiProgrami as $StudijskiProgram):
                                                if ($KandidatPodatki["id_program"] == $StudijskiProgram["ID_PROGRAM"]): ?>
                                                    <option disabled selected value="<?= $StudijskiProgram["ID_PROGRAM"] ?>"><?= $StudijskiProgram["NAZIV_PROGRAM"] ?></option>
                                                <?php else: ?>
                                                    <option disabled value="<?= $StudijskiProgram["ID_PROGRAM"] ?>"><?= $StudijskiProgram["NAZIV_PROGRAM"] ?></option>
                                                <?php endif;
                                            endforeach; ?>
                                        </select>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="ID_STUD_LETO">Študijsko leto</label>
                                        <select class="form-control" id="ID_STUD_LETO" name="ID_STUD_LETO" required>
                                            <?php foreach ($StudijskaLeta as $StudijskoLeto):
                                                if ($stud_leto['ID_STUD_LETO'] == $StudijskoLeto["ID_STUD_LETO"]): ?>
                                                    <option disabled selected value="<?= $StudijskoLeto["ID_STUD_LETO"] ?>"><?= $StudijskoLeto["STUD_LETO"] ?></option>
                                                <?php else: ?>
                                                    <option disabled value="<?= $StudijskoLeto["ID_STUD_LETO"] ?>"><?= $StudijskoLeto["STUD_LETO"] ?></option>
                                                <?php endif;
                                            endforeach; ?>
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
                                        <h3>Predmetnik študenta</h3>
                                        <table id="table-subject" class="table table-striped table-advance table-hover">
                                            <thead>
                                            <tr>
                                                <th>Ime predmeta</th>
                                                <th>St. KT</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach($predmeti as $predmet): ?>
                                                <tr>
                                                    <td><?php echo $predmet['IME_PREDMET']; ?></td>
                                                    <td><?php echo $predmet['ST_KREDITNIH_TOCK']; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td><b>Skupno st. KKT</b></td>
                                                <td><b>60</b></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12 col-md-6 offset-md-3">
                                        <button id="btn" class="btn btn-theme btn-block" type="submit">Potrdi</button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </section>
            </section>
        </section>
    </body>
</html>
