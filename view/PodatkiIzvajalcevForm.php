<?php
//echo $predmetId;

$ime='';
$priimek='';
$email='';
$telefon='';
foreach ($profData as $key=>$value) {
   // var_dump($value);

    $ime.=$value['IME'].',';
    $priimek.=$value['PRIIMEK'].',';
    $email.=$value['EMAIL'].',';
    $telefon.=$value['TELEFONSKA_STEVILKA'].',';
}


?>

<!DOCTYPE html>

<html lang="en">
<head>
    <?php include("view/includes/head.php"); ?>
    <script type="text/javascript">

        $(document).ready(function() {
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
        });

    </script>

</head>
<body>
<section id="container">
    <?php include("view/includes/menu-links-admin.php"); ?>
    <section id="main-content">
        <section class="wrapper">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <h4>Prikaz vseh izvajalcev</h4>
                    <br>
                    <br>
                    <br>
                    <table id="table-subject" class="table table-striped table-advance table-hover">
                        <thead>
                        <tr>
                            <th>Ime in priimek izvajalca</th>
                            <th>Email</th>
                            <th>Telefonska stevilka</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($professors as $key=>$value): ?>
                            <tr>
                                <td><?php echo $value['IME'] . ' ' . $value['PRIIMEK'] ; ?></td>
                                <td><?php echo $value['EMAIL']; ?></td>
                                <td><?php echo $value['TELEFONSKA_STEVILKA']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <br>
                    <br>
                    <hr>
                    <h4>Spremeni izvajalec</h4>
                    <br>
                    <br>
                    <br>
                    <h6>Podatki o posameznih izvajalcev so loceni z vejico!</h6>
                    <br>





                    <form action="<?= BASE_URL . "PodatkiIzvajalcev/edit" ?>" method="post"  class="form-horizontal">
                        <input type="hidden" name="predmetId" value="<?= $predmetId ?>"  />
                        <label>Imena vseh izvajalcev:
                        <div class="form-group">
                            <input id="ime" type="text" class="form-control" name="ime" value="<?= $ime?>" required autofocus>
                        </div>
                        </label>
                        <br>
                        <label>Primki vseh izvajalcev:
                        <div class="form-group">
                            <input id="priimek" type="text" class="form-control" name="priimek" value="<?= $priimek?>" required >
                        </div>
                        </label>
                        <br>
                        <label>Email vseh izvajalcev:
                        <div class="form-group">
                            <input id="email" type="text" class="form-control" name="email" value="<?= $email?>" >
                        </div>
                        </label>
                       <br>
                        <label>Telefonskih stevil vseh izvajalcev:
                        <div class="form-group">
                            <input id="tel" type="text" class="form-control" name="telefon" value="<?= $telefon?>" >
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
