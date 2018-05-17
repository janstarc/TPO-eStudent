<!DOCTYPE html>

<html lang="en">
<head>
    <?php include("view/includes/head.php");
    ?>
</head>
<body>
<section id="container">
    <?php include("view/includes/menu-links-professor.php"); ?>
    <section id="main-content">
        <section class="wrapper">
            <div class="row">
                <div  class="col-xs-12 col-md-6">
                    <h3>Izberite predmet </h3>
                    <table id="table-izpitov" class="table table-striped table-advance table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Šifra predmeta</th>
                            <th>Šifra izvajanja</th>
                            <th>Ime predmeta</th>
                            <th>Ime glavnega predavatelja</th>
                            <th>Izberi predmet</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <?php
                            $n = 0;
                            foreach ($predmeti as $row) {
                            $n += 1 ;
                            $izvedba = $row["IME_PREDMET"];
                            $id =$row["ID_PREDMET"];
                            $profesor = $row['IME'] . $row['PRIIMEK']
                            ?>
                        <tr>
                            <td><?= $n       ?></td>
                            <td><?= $row['ID_PREDMET'] ?></td>
                            <td><?= $row['ID_IZVEDBA'] ?></td>
                            <td><?= $izvedba?></td>
                            <td><?= $profesor ?></td>

                            <td>
                                <form action="<?= BASE_URL . $formAction . "/" . $idLeto .  "/" . $id ?>" method="get">
                                    <input class="btn btn-primary btn-sm" type="submit" value="Poglej" />
                                </form>

                            </td>
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



