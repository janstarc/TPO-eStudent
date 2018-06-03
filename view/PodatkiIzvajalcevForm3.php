<!DOCTYPE html>

<html lang="en">
<head>
    <?php include("view/includes/head.php"); ?>
    <script type="text/javascript">

        /*$(document).ready(function() {
            $( "#gumb" ).click(function() {
                var imena=$("#ime").val();
                imena=imena.split(",");

                var priimkov=$("#priimek").val();
                priimkov=priimkov.split(",");

                var emailov=$("#email").val();
                emailov=emailov.split(",");

                var telefoni=$("#tel").val();
                telefoni=telefoni.split(",");

                if(imena.length>3){
                    alert("NE MORETE VNESITI VEC KOT TREH IZVAJALCEV");
                    $("#ime").val("");
                }
                if(priimkov.length>3){
                    alert("NE MORETE VNESITI VEC KOT TREH IZVAJALCEV");
                    $("#priimek").val("");
                }
                if(emailov.length>3){
                    alert("NE MORETE VNESITI VEC KOT TREH IZVAJALCEV");
                    $("#email").val("");
                }
                if(telefoni.length>3){
                    alert("NE MORETE VNESITI VEC KOT TREH IZVAJALCEV");
                    $("#tel").val("");
                }
            });
        });*/

    </script>

</head>
<body>
<section id="container">
    <?php include("view/includes/menu-links-admin.php"); ?>
    <section id="main-content">
        <section class="wrapper">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <br>
                    <h4>Spremeni podatki o izvajalec</h4>
                    <br>
                    <br>
                    <br>
                    <form action="<?= BASE_URL . "PodatkiIzvajalcev/editThird/".$id_leto."/".$id_predmet."/edit"?>" method="post"  class="form-horizontal">

                        <label>Vseh izvajalcev:
                            <div class="form-group">
                                <select class="form-control" name="imePriimek">
                                    <option selected disabled hidden></option>
                                    <?php foreach ($profesori as $i=>$data): ?>
                                        <option value="<?= $data["IME"] .' '.$data["PRIIMEK"] .' '.$data["ID_OSEBA"]?>"><?= $data["IME"] .' '.$data["PRIIMEK"] .'('.$data["SIFRA_IZVAJALCA"].')'?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </label>

                        <button id="gumb" class="btn btn-theme btn-block" type="submit">Spremeni</button>
                    </form>
                </div>
            </div>
            </div>
        </section>
    </section>
</section>
</body>
</html>
