<?php

    $_SESSION['mainArray'] = $mainArray;
    //var_dump($mainArray);
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
                        <h4>Prikaz</h4>
                        <br>
                        <br>
                        <br>
                        <table id="table-subject" class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th>Ime</th>
                                <th>Priimek</th>
                                <th>Program</th>
                                <th>Email</th>
                                <th>Vpisna</th>
                                <th>Username</th>
                                <th>Password</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($mainArray as $key => $value){
                                echo "<tr>".
                                    "<td>".$value['ime']."</td>".
                                    "<td>".$value['priimek']."</td>".
                                    "<td>".$value['program']."</td>".
                                    "<td>".$value['email']."</td>".
                                    "<td>".$value['vpisna']."</td>".
                                    "<td>".$value['username']."</td>".
                                    "<td>".$value['password']."</td>".
                                    "</tr>";
                            }
                            ?>
                            </tbody>

                        </table>
                        <form action="<?= BASE_URL . "UvozPodatkov" ?>" method="GET">
                        <button type="submit">Nazaj</button>
                        </form>

                        <form action="<?= BASE_URL . "UvozPodatkov/insert" ?>" method="POST">
                            <button type="submit">Potrdi vnos - INSERT</button>
                        </form>
                    </div>
                </div>

            </div>
        </section>
    </section>
</section>
</body>
</html>

