<!DOCTYPE html>

<html lang="en">
<head>
    <?php include("view/includes/head.php");
    ?>
</head>
<body>
<section id="container">
    <?php include("view/includes/menu-links-student-officer.php"); ?>
    <section id="main-content">
        <section class="wrapper">
            <br>
            <br>  <br>
            <br>
            <div class="row"><form  action="<?= BASE_URL . "steviloVpisanih/exportCSV" ?>" method="post">
                    <input type="hidden" name="id1" value="<?= $id1 ?>"/>
                    <input type="hidden" name="id2" value="<?= $id2 ?>"/>
                    <input type="hidden" name="id3" value="<?= $id3 ?>"/>
                    <input id="csv" class="btn btn-primary btn-sm"  type="submit" value="Izvozi v CSV"/>
                </form>
                <form  action="<?= BASE_URL . "steviloVpisanih/exportPDF" ?>" method="post">
                    <input type="hidden" name="id1" value="<?= $id1 ?>"/>
                    <input type="hidden" name="id2" value="<?= $id2 ?>"/>
                    <input type="hidden" name="id3" value="<?= $id3 ?>"/>

                    <input id="pdf" class="btn btn-primary btn-sm"  type="submit" value="Izvozi v PDF"/>
                </form>
                <div  class="col-xs-12 col-md-6">

                    <table id="table-izpitov" class="table table-striped table-advance table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Šifra predmeta</th>
                            <th>Ime predmeta</th>
                            <th>Ime glavnega predavatelja</th>
                            <th>Stevilo Vpisanih</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <?php
                            $n = 0;
                            foreach ($allData as $row) {
                            $n += 1 ;
                            $izvedba = $row["IME_PREDMET"];
                            $id =$row["ID_PREDMET"];
                            $profesor = $row['IME'] . $row['PRIIMEK']
                            ?>
                        <tr>
                            <td><?= $n       ?></td>
                            <td><?= $row['ID_PREDMET'] ?></td>
                            <td><?= $izvedba?></td>
                            <td><?= $profesor ?></td>
                            <td><?= $row["COUNT"] ?></td>


                        </tr><?php
                        }
                        ?>



                        </tbody>
                    </table>

                </div>

            </div>

            </div>
        </section>
    </section>
</section>
</body>
</html>



