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
                            <div class="row">
                                <div class="col-xs-12 col-md-4">
                                    <h3>Osebni podatki</h3>
                                    <div class="form-group">
                                        <label for="Ime">Ime</label>
                                        <input type="text" class="form-control" id="Ime" name="Ime" value="<?= $KandidatPodatki["ime"] ?>" required  autofocus disabled>
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
                                        <input type="number" class="form-control" id="emso" name="emso" value="<?= $KandidatPodatki["emso"] ?>" maxlength="13" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="telefonska_stevilka">Telefon</label>
                                        <input type="number" class="form-control" id="telefonska_stevilka" name="telefonska_stevilka" value="<?= $KandidatPodatki["telefonska_stevilka"] ?>" required>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-4">
                                    <h3>Stalni Naslov</h3>
                                    <input type="hidden" name="ID_NASLOV1" value="<?= $naslov[0]["ID_NASLOV"] ?>" />
                                    <div class="form-group">
                                        <label for="id_drzava">Država</label>
                                        <select class="form-control" id="id_drzava" name="id_drzava" onchange="toggleDrzava();" required>
                                            <?php foreach ($drzave as $drzava):
                                                if ($naslov[0]["ID_DRZAVA"] == $drzava["ID_DRZAVA"]): ?>
                                                    <option selected value="<?= $drzava["ID_DRZAVA"] ?>"><?= $drzava["SLOVENSKINAZIV"] ?></option>
                                                <?php else: ?>
                                                    <option value="<?= $drzava["ID_DRZAVA"] ?>"><?= $drzava["SLOVENSKINAZIV"] ?></option>
                                                <?php endif;
                                            endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="ulica">Ulica</label>
                                        <input type="text" class="form-control" id="ulica" name="ulica" value="<?= $naslov[0]["ULICA"] ?>" required>
                                    </div>
                                    <div class="form-group postaINobcina">
                                        <label for="id_posta">Kraj in poštna številka</label>
                                        <select class="form-control" id="id_posta" name="id_posta" required>
                                            <?php if (isset($naslov[0]["ID_POSTA"])):
                                                foreach ($poste as $posta):
                                                    if ($naslov[0]["ID_POSTA"] == $posta["ID_POSTA"]): ?>
                                                        <option selected value="<?= $posta["ID_POSTA"] ?>"><?= $posta["KRAJ"]." (".$posta["ST_POSTA"].")" ?></option>
                                                    <?php else: ?>
                                                        <option value="<?= $posta["ID_POSTA"] ?>"><?= $posta["KRAJ"]." (".$posta["ST_POSTA"].")" ?></option>
                                                    <?php endif;
                                                endforeach;
                                            else: ?>
                                                <option selected disabled hidden></option>
                                                <?php foreach ($poste as $posta): ?>
                                                    <option value="<?= $posta["ID_POSTA"] ?>"><?= $posta["KRAJ"]." (".$posta["ST_POSTA"].")" ?></option>
                                                <?php endforeach;
                                            endif; ?>
                                        </select>
                                    </div>
                                    <div class="form-group postaINobcina">
                                        <label for="id_obcina">Občina</label>
                                        <select class="form-control" id="id_obcina" name="id_obcina" required>
                                            <?php if (isset($naslov[0]["ID_OBCINA"])):
                                                foreach ($obcine as $obcina):
                                                    if ($naslov[0]["ID_OBCINA"] == $obcina["ID_OBCINA"]): ?>
                                                        <option selected value="<?= $obcina["ID_OBCINA"] ?>"><?= $obcina["IME_OBCINA"] ?></option>
                                                    <?php else: ?>
                                                        <option value="<?= $obcina["ID_OBCINA"] ?>"><?= $obcina["IME_OBCINA"] ?></option>
                                                    <?php endif;
                                                endforeach;
                                            else: ?>
                                                <option selected disabled hidden></option>
                                                <?php foreach ($obcine as $obcina): ?>
                                                    <option value="<?= $obcina["ID_OBCINA"] ?>"><?= $obcina["IME_OBCINA"] ?></option>
                                                <?php endforeach;
                                            endif; ?>
                                        </select>
                                    </div>
                                    
                                    <h3>Začasni naslov</h3>
                                    <input type="hidden" name="ID_NASLOV2" value="<?= $naslov[1]["ID_NASLOV"] ?>" />
                                    <div class="form-group">
                                        <label for="id_drzava2">Država</label>
                                        <select class="form-control" id="id_drzava2" name="id_drzava2" onchange="toggleDrzava2();">
                                            <?php if (isset($naslov[1]["ID_DRZAVA"])):
                                                foreach ($drzave as $drzava):
                                                    if ($naslov[1]["ID_DRZAVA"] == $drzava["ID_DRZAVA"]): ?>
                                                        <option selected value="<?= $drzava["ID_DRZAVA"] ?>"><?= $drzava["SLOVENSKINAZIV"] ?></option>
                                                    <?php else: ?>
                                                        <option value="<?= $drzava["ID_DRZAVA"] ?>"><?= $drzava["SLOVENSKINAZIV"] ?></option>
                                                    <?php endif;
                                                endforeach;
                                            else: ?>
                                                <option selected disabled hidden></option>
                                                <?php foreach ($drzave as $drzava): ?>
                                                    <option value="<?= $drzava["ID_DRZAVA"] ?>"><?= $drzava["SLOVENSKINAZIV"] ?></option>
                                                <?php endforeach;
                                            endif; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="ulica2">Ulica</label>
                                        <input type="text" class="form-control" id="ulica2" name="ulica2" value="<?= isset($naslov[1]["ULICA"]) ? $naslov[1]["ULICA"] : "" ?>">
                                    </div>
                                    <div class="form-group postaINobcina2">
                                        <label for="id_posta2">Kraj in poštna številka</label>
                                        <select class="form-control" id="id_posta2" name="id_posta2">
                                            <?php if (isset($naslov[1]["ID_POSTA"])):
                                                foreach ($poste as $posta):
                                                    if ($naslov[1]["ID_POSTA"] == $posta["ID_POSTA"]): ?>
                                                        <option selected value="<?= $posta["ID_POSTA"] ?>"><?= $posta["KRAJ"]." (".$posta["ST_POSTA"].")" ?></option>
                                                    <?php else: ?>
                                                        <option value="<?= $posta["ID_POSTA"] ?>"><?= $posta["KRAJ"]." (".$posta["ST_POSTA"].")" ?></option>
                                                    <?php endif;
                                                endforeach;
                                            else: ?>
                                                <option selected disabled hidden></option>
                                                <?php foreach ($poste as $posta): ?>
                                                    <option value="<?= $posta["ID_POSTA"] ?>"><?= $posta["KRAJ"]." (".$posta["ST_POSTA"].")" ?></option>
                                                <?php endforeach;
                                            endif; ?>
                                        </select>
                                    </div>
                                    <div class="form-group postaINobcina2">
                                        <label for="id_obcina2">Občina</label>
                                        <select class="form-control" id="id_obcina2" name="id_obcina2">
                                            <?php if (isset($naslov[1]["ID_OBCINA"])):
                                                foreach ($obcine as $obcina):
                                                    if ($naslov[1]["ID_OBCINA"] == $obcina["ID_OBCINA"]): ?>
                                                        <option selected value="<?= $obcina["ID_OBCINA"] ?>"><?= $obcina["IME_OBCINA"] ?></option>
                                                    <?php else: ?>
                                                        <option value="<?= $obcina["ID_OBCINA"] ?>"><?= $obcina["IME_OBCINA"] ?></option>
                                                    <?php endif;
                                                endforeach;
                                            else: ?>
                                                <option selected disabled hidden></option>
                                                <?php foreach ($obcine as $obcina): ?>
                                                    <option value="<?= $obcina["ID_OBCINA"] ?>"><?= $obcina["IME_OBCINA"] ?></option>
                                                <?php endforeach;
                                            endif; ?>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Kateri naslov zelite uporabiti za vročanje poste?</label>
                                        <label class="radio-inline">
                                            <?php if ($naslov[0]["JE_ZAVROCANJE"] == 1): ?>
                                                <input type="radio" name="naslovZaVrocanje" id="stalni" value="stalni" required checked>Stalni
                                            <?php else: ?>
                                                <input type="radio" name="naslovZaVrocanje" id="stalni" value="stalni" required>Stalni
                                            <?php endif; ?>
                                        </label>
                                        <label class="radio-inline">
                                            <?php if (isset($naslov[1]["JE_ZAVROCANJE"]) && $naslov[1]["JE_ZAVROCANJE"] == 1): ?>
                                                <input type="radio" name="naslovZaVrocanje" id="zacasni" value="zacasni" checked>Zacasni
                                            <?php else: ?>
                                                <input type="radio" name="naslovZaVrocanje" id="zacasni" value="zacasni" >Zacasni
                                            <?php endif; ?>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-4">
                                    <h3>Podatki o vpisu</h3>
                                    <div class="form-group">
                                        <label for="ID_PROGRAM">Študijski program</label>
                                        <select class="form-control" id="ID_PROGRAM" name="ID_PROGRAM" required disabled>
                                            <?php foreach ($StudijskiProgrami as $StudijskiProgram):
                                                if ($KandidatPodatki["id_program"] == $StudijskiProgram["ID_PROGRAM"]): ?>
                                                    <option selected value="<?= $StudijskiProgram["ID_PROGRAM"] ?>"><?= $StudijskiProgram["NAZIV_PROGRAM"] ?></option>
                                                <?php else: ?>
                                                    <option value="<?= $StudijskiProgram["ID_PROGRAM"] ?>"><?= $StudijskiProgram["NAZIV_PROGRAM"] ?></option>
                                                <?php endif;
                                            endforeach; ?>
                                        </select>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="ID_STUD_LETO">Študijsko leto</label>
                                        <select class="form-control" id="ID_STUD_LETO" name="ID_STUD_LETO" required disabled>
                                            <?php foreach ($StudijskaLeta as $StudijskoLeto):
                                                if ($stud_leto['ID_STUD_LETO'] == $StudijskoLeto["ID_STUD_LETO"]): ?>
                                                    <option selected value="<?= $StudijskoLeto["ID_STUD_LETO"] ?>"><?= $StudijskoLeto["STUD_LETO"] ?></option>
                                                <?php else: ?>
                                                    <option value="<?= $StudijskoLeto["ID_STUD_LETO"] ?>"><?= $StudijskoLeto["STUD_LETO"] ?></option>
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
                                    <div class="form-group">
                                        <label for="VRSTA_VPISA">Vrsta vpisa</label>
                                        <input type="text" class="form-control" id="word" name="VRSTA_VPISA" value="<?= $KandidatPodatki["OPIS_VPISA"] ?>" required disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="NACIN_STUDIJA">Način študija</label>
                                        <input type="text" class="form-control" id="word" name="NACIN_STUDIJA" value="<?= $KandidatPodatki["OPIS_NACIN"] ?>" required disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="LETNIK">Letnik</label>
                                        <input type="text" class="form-control" id="word" name="LETNIK" value="<?= $KandidatPodatki["LETNIK"] ?>" required disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="OBLIKA_STUDIJA">Oblika študija</label>
                                        <input type="text" class="form-control" id="word" name="OBLIKA_STUDIJA" value="<?= $KandidatPodatki["NAZIV_OBLIKA"] ?>" required disabled>
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
                                        <label for="IzbModulov"><b><big>Moduli</big></b> (izberite 2 oz. skupno 36KT)</label>
                                        <select class="form-control selectpicker" multiple id="IzbModulov" name="IzbModulov[]">
                                            <?php foreach ($IzbModulov as $IzbModul): ?>
                                                <option value="<?= $IzbModul["ID_DELPREDMETNIKA"] ?>"><?= $IzbModul["NAZIV_DELAPREDMETNIKA"]." (".$IzbModul["SKUPNOSTEVILOKT"].")" ?></option>
                                                
                                                <?php foreach ($ModulPredmeti as $ModulPredmet):
                                                    if ($IzbModul["ID_DELPREDMETNIKA"] == $ModulPredmet["ID_DELPREDMETNIKA"]): ?>    
                                                        <option disabled><?= "- ".$ModulPredmet["SIFRA_PREDMET"].": ".$ModulPredmet["IME_PREDMET"]." (".$ModulPredmet["ST_KREDITNIH_TOCK"].")" ?></option>
                                                    <?php endif;
                                                endforeach; ?>
                                                
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="SplIzbPredmeti"><b><big>Splošni izbirni predmeti</big></b> (izberite skupno 6KT)</label>
                                        <select class="form-control selectpicker" multiple id="SplIzbPredmeti" name="SplIzbPredmeti[]">
                                            <?php foreach ($SplIzbPredmeti as $SplIzbPredmet): ?>
                                                <option value="<?= $SplIzbPredmet["ID_PREDMET"] ?>"><?= $SplIzbPredmet["SIFRA_PREDMET"].": ".$SplIzbPredmet["IME_PREDMET"]." (".$SplIzbPredmet["ST_KREDITNIH_TOCK"].")" ?></option>
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
