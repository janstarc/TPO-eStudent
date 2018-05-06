<!DOCTYPE html>

<html lang="en">
    <head>
        <?php include("view/includes/head.php"); ?>
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
                                        <input type="text" class="form-control" id="emso" name="emso" value="<?= $KandidatPodatki["emso"] ?>" required>
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
                                        <label for="telefonska_stevilka">Telefon</label>
                                        <input type="text" class="form-control" id="telefonska_stevilka" name="telefonska_stevilka" value="<?= $KandidatPodatki["telefonska_stevilka"] ?>" required>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-4">
                                    <h3>Naslov</h3>
                                    <div class="form-group">
                                        <label for="ulica">Ulica</label>
                                        <input type="text" class="form-control" id="ulica" name="ulica" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="hisna_stevilka">Hišna številka</label>
                                        <input type="text" class="form-control" id="hisna_stevilka" name="hisna_stevilka" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="idSubcategory">Občina</label>
                                        <select class="form-control" id="idSubcategory" name="idSubcategory" required>
                                            <option selected disabled hidden></option>
                                            <?php foreach ($obcine as $obcina): ?>
                                                <option value="<?= $obcina["ID_OBCINA"] ?>"><?= $obcina["IME_OBCINA"] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="idSubcategory">Poštna številka</label>
                                        <select class="form-control" id="idSubcategory" name="idSubcategory" required>
                                            <option selected disabled hidden></option>
                                            <?php foreach ($poste as $posta): ?>
                                                <option value="<?= $posta["ID_POSTA"] ?>"><?= $posta["ST_POSTA"] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="idSubcategory">Kraj</label>
                                        <select class="form-control" id="idSubcategory" name="idSubcategory" required>
                                            <option selected disabled hidden></option>
                                            <?php foreach ($poste as $posta): ?>
                                                <option value="<?= $posta["ID_POSTA"] ?>"><?= $posta["KRAJ"] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="idSubcategory">Država</label>
                                        <select class="form-control" id="idSubcategory" name="idSubcategory" required>
                                            <option selected disabled hidden></option>
                                            <?php foreach ($drzave as $drzava): ?>
                                                <option value="<?= $drzava["ID_DRZAVA"] ?>"><?= $drzava["SLOVENSKINAZIV"] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5 offset-md-1">
                                            <div class="form-group">
                                                <input type="checkbox" class="form-check-input" id="je_stalni">
                                                <label class="form-check-label" for="je_stalni">Ali je stalni?</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="checkbox" class="form-check-input" id="je_zavrocanje">
                                                <label class="form-check-label" for="je_zavrocanje">Ali je za vrocanje?</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-4">
                                    <h3>Podatki o vpisu</h3>
                                    <div class="form-group">
                                        <label for="id_naziv_program">Študijski program</label>
                                        <select class="form-control" id="idSubcategory" name="idSubcategory" required disabled>
                                            <option value=""><?= $KandidatPodatki["naziv_program"] ?></option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="idSubcategory">Študijsko leto</label>
                                        <select class="form-control" id="idSubcategory" name="idSubcategory" required disabled>
                                            <option value=""><?= $stud_leto["STUD_LETO"] ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 offset-md-3">
                                    <button id="btn" class="btn btn-theme btn-block" type="submit">Ustvari</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
            </section>
        </section>
    </body>
</html>
