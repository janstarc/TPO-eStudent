<?php

?>

<!DOCTYPE html>

<html lang="en">
<head>
    <?php include("view/includes/head.php"); ?>
    <script type="text/javascript">
        function submitForm(action) {
            var form = document.getElementById('form1');
            form.action = action;
            form.submit();
        }
    </script>
</head>
<body>
<section id="container">
    <?php include("view/includes/menu-links-student-officer.php"); ?>
    <section id="main-content">
        <section class="wrapper">
            <br>
            <form id="form1" action="<?= BASE_URL . "VnosKoncnihOcenR/leto/".$id_stud_leto."/seznamStudentov" ?>" method="post" class="form-horizontal">
                <h3>Končne ocene</h3>
                <div class="form-group">
                    <label for="id_predmet">Izberi predmet</label>
                    <select class="form-control" id="id_predmet" name="id_predmet" required>
                        <?php foreach ($predmeti as $key => $value): ?>
                            <option value="<?= $value["ID_PREDMET"] ?>">
                                <?php echo "(".$value["SIFRA_PREDMET"].") ".$value["IME_PREDMET"];
                                        if($value["IME1"] != null) echo " (".$value["IME1"]." ".$value["PRIIMEK1"];
                                        if($value["IME2"] != null) echo ", ".$value["IME2"]." ".$value["PRIIMEK2"];
                                        if($value["IME3"] != null) echo ", ".$value["IME3"]." ".$value["PRIIMEK3"];
                                        echo ")";
                                ?></option>
                        <?php endforeach; ?>
                    </select>

                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-6 offset-md-3">
                        <input type="button" onclick="submitForm('<?= BASE_URL . "VnosKoncnihOcenR/leto/".$id_stud_leto."/seznamStudentov" ?>')" id="btn" class="btn btn-theme btn-block"  value="Vnesi končne ocene">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-xs-12 col-md-6 offset-md-3">
                        <input type="button" onclick="submitForm('<?= BASE_URL . "IzpisKoncnihOcenR/leto/".$id_stud_leto."/seznamStudentov" ?>')" id="btn" class="btn btn-theme btn-block" value="Izpis seznama študentov s končnimi ocenami">
                    </div>
                </div>
            </form>
        </section>
    </section>
</section>
</body>
</html>