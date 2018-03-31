<?php
    //include("model/AdminDB.php");         // Aleksandar, ce to odkomentiras se pojavi tisti error

    $resultFound = false;
    if(!empty($studData)) $resultFound = true;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("view/includes/head.php"); ?>
</head>
<body>
<section id="container">
    <?php
        include("view/includes/menu-links-admin.php");
    ?>
    <section id="main-content">
        <section class="wrapper">
            <div class="row">
                <div class="col-md-12">
                    <div class="content-panel">
                        <h2>Iskanje študenta</h2>
                        <br>
                        <form class="example" action="<?= BASE_URL . "OsebniPodatkiStudenta/vpisnaSearch" ?>" method="post">
                            <input type="text" placeholder="IŠČI PO VPISNI STEVILKI..." name="searchVpisna">
                            <button type="submit" name="isciVpisnaBtn">Isci</button>
                        </form>
                        <br>
                        <br>
                        <p>
                            <form class="example2">
                                <input type="text" placeholder="IŠČI PO IMENU IN PRIIMKU..." name="searchIme">
                                <button type="submit">Isci</button>
                            </form>
                        </p>
                        <br>
                        <br>
                        <hr>
                            <div id="tables" <?php if (!$resultFound){ echo 'style="display:none;"'; } ?>>
                                <h2>Podatki študenta</h2>
                                <table id="table-student" class="table table-striped table-advance table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Podatek o studentu</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Vpisna številka</td>
                                        <td><?= $studData['0']['vpisna_stevilka'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Ime in priimek</td>
                                        <td><?= $studData['0']['ime']." ".$studData['0']['priimek'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Naslov stalnega bivališča</td>
                                        <td>
                                            <?php
                                                foreach ($studData as $key => $value) {
                                                    if($value['stalni'] == 1){
                                                        echo $value['ulica']." ".$value['hisna_stevilka'].", ".$value['st_posta']." ".$value['kraj']."</br>";
                                                    }
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Naslov za prejemanje pošte</td>
                                        <td>
                                            <?php
                                                foreach ($studData as $key => $value) {
                                                    if($value['zavrocanje'] == 1){
                                                        echo $value['ulica']." ".$value['hisna_stevilka'].", ".$value['st_posta']." ".$value['kraj']."</br>";
                                                    }
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Telefonska številka</td>
                                        <td><?= $studData['0']['telefonska_steviklka'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Naslov elektronske poste</td>
                                        <td><?= $studData['0']['email'] ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <br/><br/>
                                <h2>Podatki o vpisih</h2>
                                <table id="table-vpisi" class="table table-striped table-advance table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Letnik</th>
                                    <th>Študijski program</th>
                                    <th>Vrsta vpisa</th>
                                    <th>Način študija</th>
                                </tr>
                                </thead>
                                    <tbody>
                                        <?php
                                            foreach ($vpisData as $key => $value){
                                                echo "<tr>"
                                                        ."<td>".$key."</td>"
                                                        ."<td>".$value['letnik']."</td>"
                                                        ."<td>".$value['naziv_program']." (".$value['sifra_program'].")</td>"
                                                        ."<td>".$value['opis_vpisa']."</td>"
                                                        ."<td>".$value['opis_nacin']."</td>"
                                                      ."</tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
</section>
</body>
</html>