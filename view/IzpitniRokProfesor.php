<!DOCTYPE html>

<html lang="en">
    <head>
        <?php include("view/includes/head.php"); ?>
    </head>
    <body>
        <section id="container">
            <?php include("view/includes/menu-links-professor.php"); ?>
                <section id="main-content">
                    <section class="wrapper">
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <form action="<?= BASE_URL . $formAction ?>" method="post" class="form-horizontal">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="DATUM_ROKA" placeholder="Datum" required autofocus>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="CAS_ROKA" placeholder="Cas" required>
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control" name="ID_IZVEDBA" required>
                                            <option selected disabled hidden></option>
                                            <?php foreach ($IdIzvedbaPredmeta as $idIP): ?>
                                                <option value="<?= $idIP["ID_IZVEDBA"] ?>"><?= $idIP["IME_PREDMET"] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <button id="btn" class="btn btn-theme btn-block" type="submit">Ustvari</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </section>
        </section>
    </body>
</html>
