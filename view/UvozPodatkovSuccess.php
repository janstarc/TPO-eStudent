<?php
?>
<!DOCTYPE html>

<html lang="en">
<head>
    <?php include("view/includes/head.php"); ?>
</head>
<body>
<section id="container">
    <?php include("view/includes/menu-links-admin.php"); ?>
    <section id="main-content">
        <section class="wrapper">
            <div class="row">
                <div class="col-md-12">
                    <div class="content-panel">
                        <hr>
                        <h5>Vnos uspešen!</h5>
                        <h4>Pregled študentov</h4>
                        <br>
                        <br>
                        <br>
                        <table id="table-subject" class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th>Ime</th>
                                <th>Priimek</th>
                                <th>Email</th>
                                <th>Uporabniško ime</th>
                                <th>Vpisna</th>
                                <th>ID Program</th>
                                <th>Naziv program</th>
                                <th>Password</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($result as $key => $value){
                                echo "<tr>".
                                    "<td>".$value['ime']."</td>".
                                    "<td>".$value['priimek']."</td>".
                                    "<td>".$value['email']."</td>".
                                    "<td>".$value['uporabnisko_ime']."</td>".
                                    "<td>".$value['vpisna_stevilka']."</td>".
                                    "<td>".$value['id_program']."</td>".
                                    "<td>".$value['naziv_program']."</td>".
                                    "<td> Generated </td>".
                                    "</tr>";
                            }
                            ?>
                            </tbody>

                        </table>
                        <form action="<?= BASE_URL . "OsebniPodatkiStudenta"?>" method="GET">
                            <button type="submit">OK</button>
                        </form>

                    </div>
                </div>

            </div>
        </section>
    </section>
</section>
</body>
>>>>>>> Stashed changes
</html>
