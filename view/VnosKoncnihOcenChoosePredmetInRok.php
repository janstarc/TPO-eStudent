<!DOCTYPE html>

<html lang="en">
<head>
    <?php include("view/includes/head.php"); ?>

    <script type="application/javascript">

        function submitForm(action) {
            console.log(action);
            var form = document.getElementById('form1');
            console.log(form);
            form.action = action;
            form.submit();
        }

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
                    $('#id_rok').append('<option value="' + id_roka + '">' + datum_roka + ' ob ' + cas_roka + ' (' + izvajalec + ') [id_rok=' + id_roka + ']</option>');
                }
            });
        }
    </script>
</head>
<body>
<section id="container">
    <?php include("view/includes/menu-links-professor.php"); ?>
    <section id="main-content">
        <section class="wrapper">
            <br>
            <form id="form1" action="<?= BASE_URL . "VnosKoncnihOcenP/leto/".$id_stud_leto."/seznamStudentov" ?>" method="post" class="form-horizontal">
                <h3>Končne ocene</h3>
                <div class="form-group">
                    <label for="id_predmet">Izberi predmet</label>
                    <select class="form-control" id="id_predmet" name="id_predmet" required>
                        <option selected disabled hidden></option>
                        <?php foreach ($predmeti as $key => $value): ?>
                            <option value="<?= $value["ID_PREDMET"] ?>"><?= $value["IME_PREDMET"]." (".$value["SIFRA_PREDMET"].")" ?></option>
                        <?php endforeach; ?>
                    </select>

                </div>
                <div class="form-group">
                    <label for="id_rok">Izberi izpitni rok</label>
                    <select class="form-control" id="id_rok" name="id_rok" required></select>
                </div>
                <!--
                <div class="row">
                    <div class="col-xs-12 col-md-6 offset-md-3">
                        <button id="btn" class="btn btn-theme btn-block" type="submit">Potrdi</button>
                    </div>
                </div>
                -->
                <div class="row">
                    <div class="col-xs-12 col-md-6 offset-md-3">
                        <input type="button" onclick="submitForm('<?= BASE_URL . "VnosKoncnihOcenP/leto/".$id_stud_leto."/seznamStudentov" ?>')" id="btn" class="btn btn-theme btn-block"  value="Vnesi končne ocene">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-xs-12 col-md-6 offset-md-3">
                        <input type="button" onclick="submitForm('<?= BASE_URL . "IzpisKoncnihOcenP/leto/".$id_stud_leto."/seznamStudentov" ?>')" id="btn" class="btn btn-theme btn-block" value="Izpis seznama študentov s končnimi ocenami">
                    </div>
                </div>
            </form>
        </section>
    </section>
</section>
</body>
</html>