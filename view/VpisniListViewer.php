<!DOCTYPE html>

<html lang="en">
    <head>
        <?php include("view/includes/head.php"); ?>
        <script type="text/javascript" src="<?= JS_URL . "vpisScript.js" ?>"></script>
    </head>
    <body>
        <section id="container">
            <?php include("view/includes/menu-links-kandidat.php"); ?>
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
                                    <h3>Stalni Naslov</h3>
                                    <div class="form-group">
                                        <label for="ulica">Ulica</label>
                                        <input type="text" class="form-control" id="ulica" name="ulica" value="" required>
                                    </div>
                                    <!-- Hisna stevilka je lahko tudi 1a, zato ne more biti samo number -->
                                    <div class="form-group">
                                        <label for="hisna_stevilka">Hišna številka</label>
                                        <input type="number" class="form-control" id="hisna_stevilka" name="hisna_stevilka" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="id_posta">Kraj in poštna številka</label>
                                        <select class="form-control" id="id_posta" name="id_posta" required>
                                            <option selected disabled hidden></option>
                                            <?php foreach ($poste as $posta): ?>
                                                <option value="<?= $posta["ID_POSTA"] ?>"><?= $posta["KRAJ"]." (".$posta["ST_POSTA"].")" ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Ali je stalni naslov, tudi naslov za vročanje?</label>
                                        <label class="radio-inline">
                                            <input type="radio" name="optradio" id="je_zavrocanje" value="je_zavrocanje" required>Da
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="optradio" id="ni_zavrocanje" value="ni_zavrocanje" >Ne
                                        </label>
                                    </div>
                                    
                                    <div id="naslov2">
                                        <h3>Naslov za vročanje</h3>
                                        <div class="form-group">
                                            <label for="ulica2">Ulica</label>
                                            <input type="text" class="form-control" id="ulica2" name="ulica2" value="" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="hisna_stevilka2">Hišna številka</label>
                                            <input type="number" class="form-control" id="hisna_stevilka2" name="hisna_stevilka2" value="" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="id_posta2">Kraj in poštna številka</label>
                                            <select class="form-control" id="id_posta2" name="id_posta2" required>
                                                <option selected disabled hidden></option>
                                                <?php foreach ($poste as $posta): ?>
                                                    <option value="<?= $posta["ID_POSTA"] ?>"><?= $posta["KRAJ"]." (".$posta["ST_POSTA"].")" ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
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
                                        <?php
                                        foreach($predmeti as $predmet): ?>
                                            <tr>
                                                <td><?php echo $predmet['IME_PREDMET']; ?></td>
                                                <td><?php echo $predmet['ST_KREDITNIH_TOCK']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td>Skupno st. KKT</td>
                                            <td>60</td>
                                        </tr>
                                        </tbody>
                                    </table>
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
