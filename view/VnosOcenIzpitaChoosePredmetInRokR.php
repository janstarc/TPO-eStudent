<?php

?>

<!DOCTYPE html>

<html lang="en">
<head>
    <?php include("view/includes/head.php"); ?>

    <script type="application/javascript">

        var izpitniRoki = <?php echo json_encode($izpitniRoki) ?>; // don't use quotes
        $(document).ready(function() {

            console.log(izpitniRoki);

            $("#id_predmet").change(function(e) {
                e.preventDefault();
                var id_predmet = $("#id_predmet").val();
                console.log(izpitniRoki[id_predmet]);
                fill_select_rok(id_predmet);
            });

            $.each(izpitniRoki, function(key, value) {
                fill_select_rok(value);
            });

        });

        function fill_select_rok(id) {
            $('#id_rok').html('');

            $.each(izpitniRoki, function(key, value) {
                var id_predmeta = value["ID_PREDMET"];
                var datum_roka = value["DATUM_ROKA"];
                var cas_roka = value["CAS_ROKA"];
                var id_roka = value["ID_ROK"];
                var izvajalec = value["IZVAJALEC"];
                if (id == id_predmeta) {
                    $('#id_rok').append('<option value="' + id_roka + '">' + datum_roka + ' ob ' + cas_roka + ' (' + izvajalec + ')</option>');
                }
            });
        }
    </script>
</head>
<body>
<section id="container">
    <?php include("view/includes/menu-links-student-officer.php"); ?>
    <section id="main-content">
        <section class="wrapper">
            <br>
            <form action="<?= BASE_URL . "VnosOcenIzpitaR/leto/".$id_stud_leto."/seznamStudentov" ?>" method="post" class="form-horizontal">
                <h3>Vnos ocen izpitnega roka</h3>
                <div class="form-group">
                    <label for="id_predmet">Izberi predmet</label>
                    <select class="form-control" id="id_predmet" name="id_predmet" required>
                        <option selected disabled hidden></option>
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
                <div class="form-group">
                    <label for="id_rok">Izberi izpitni rok</label>
                    <select class="form-control" id="id_rok" name="id_rok" required></select>
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