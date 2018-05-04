<?php
    $_SESSION['mainArray'] = $mainArray;
    $duplikati = 0;
    $display = "visible";
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
                                <th>#</th>
                                <th>Ime</th>
                                <th>Priimek</th>
                                <th>Program</th>
                                <th>Email</th>
                                <th>Vpisna</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Že v bazi</th>
                                <th>Posodobitev</th>
                                <th>Tip duplikata</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($mainArray as $key => $value){

                                if($value['duplikat'] == "NE" || $value['update'] == "DA"){
                                    echo "<tr>".
                                        "<td>".$key."</td>".
                                        "<td>".$value['ime']."</td>".
                                        "<td>".$value['priimek']."</td>".
                                        "<td>".$value['program']."</td>".
                                        "<td>".$value['email']."</td>".
                                        "<td>".$value['vpisna']."</td>".
                                        "<td>".$value['username']."</td>".
                                        "<td>".$value['password']."</td>".
                                        "<td>".$value['duplikat']."</td>".
                                        "<td>".$value['update']."</td>".
                                        "<td>".$value['tipDuplikata']."</td>".
                                        "</tr>";
                                } else {
                                    $duplikati++;       // Counting nr. of duplicates - if all are duplicates, then disable insert button
                                    echo "<tr>".
                                        "<td>".$key."</td>".
                                        "<td><del>".$value['ime']."</del></td>".
                                        "<td><del>".$value['priimek']."</del></td>".
                                        "<td><del>".$value['program']."</del></td>".
                                        "<td><del>".$value['email']."</del></td>".
                                        "<td><del>".$value['vpisna']."</del></td>".
                                        "<td><del>".$value['username']."</del></td>".
                                        "<td><del>".$value['password']."</del></td>".
                                        "<td><strong>".$value['duplikat']."</strong></td>".
                                        "<td><strong>".$value['update']."</strong></td>".
                                        "<td><strong>".$value['tipDuplikata']."</strong></td>".
                                        "</tr>";
                                }
                            }
                                if($duplikati == count($mainArray)){
                                    echo "<br><br><strong>   Vnos vsebuje samo duplikate brez posodobitev. Vnos v bazo ni možen.</strong>";
                                    $display = "hidden";
                                }
                                elseif($duplikati > 0) {
                                    echo "<br><br><strong>   Vnos vsebuje duplikate. Če izberete INSERT, bodo vstavljeni le podatki, ki niso duplikati.</strong>";
                                }
                            ?>
                            </tbody>
                        </table>
                        <form action="<?= BASE_URL . "UvozPodatkov" ?>" method="GET">
                        <button type="submit">Nazaj</button>
                        </form>

                        <form action="<?= BASE_URL . "UvozPodatkov/insert" ?>" style="visibility:<?= $display ?>" method="POST">
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

