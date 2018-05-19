<?php

?>

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
            <br>
            <form action="<?= BASE_URL . "VnosKoncnihOcen/leto/".$id_stud_leto."/seznamStudentov" ?>" method="post" class="form-horizontal">
                <h3>Vnos končnih ocen</h3>
                <div class="form-group">
                    <label for="id_predmet">Izberi predmet</label>
                    <select class="form-control" id="id_predmet" name="id_predmet" required>
                        <option selected disabled hidden></option>
                        <?php foreach ($predmeti as $key => $value): ?>
                            <option value="<?= $value["ID_PREDMET"] ?>"><?= $value["IME_PREDMET"]." (".$value["SIFRA_PREDMET"].")" ?></option>
                        <?php endforeach; ?>
                    </select>

                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-6 offset-md-3">
                        <button id="btn" class="btn btn-theme btn-block" type="submit">Potrdi</button>
                    </div>
                </div>
            </form>
        </section>
    </section>
</section>
</body>
</html>