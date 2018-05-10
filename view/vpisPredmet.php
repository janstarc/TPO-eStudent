<!DOCTYPE html>

<html lang="en">
<head>
    <?php include("view/includes/head.php"); ?>
</head>
<body>
<section id="container">
    <?php include("view/includes/menu-links-professor.php");
    ?>
    <section id="main-content">
        <section class="wrapper">
            <div  <?php if ($leta == null){ echo 'style="display:none;"' ; } ?>  class="row">
                <div class="col-xs-12 col-md-6">

                    <h3>Izberite šolsko leto </h3>

                    <form class="example"  action="<?= BASE_URL . "vpisPredmet/predmeti" ?>" method="post">

                        <div >

                            <select name="leto">
                                <?php
                                echo "<option disabled selected value=''>"." Šolsko leto"."</option>";

                                foreach ($leta as $key => $value){
                                    echo "<option value=".$value['ID_STUD_LETO']."  >".$value['STUD_LETO']."</option>";

                                }
                                ?>
                            </select>
                        </div>
                        <div>


                            <button id="btn" class="btn btn-theme btn-block" type="submit">
                                Izberi </button>
                        </div>
                    </form>
                </div>

            </div>
            <div  <?php if ($predmeti == null){ echo 'style="display:none;"' ; } ?>  class="row">
                <div  class="col-xs-12 col-md-6">
                    <h3>Izberite predmet </h3>
                    <form class="example"  action="<?= BASE_URL . "vpisPredmet/vpisani" ?>" method="post">
                        <table id="table-izpitov" class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th>Ime predmeta</th>
                                <th>Izberi predmet</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <?php
                                foreach ($predmeti as $row) {

                                $izvedba = $row["IME_PREDMET"];
                                $id =$row["ID_PREDMET"];
                                ?>
                            <tr>
                                <td><?= $izvedba?></td>

                                <td>
                                    <form class=example  action="<?= BASE_URL . "vpisPredmet/vpisani" ?>" method='post'>
                                        <input type="hidden" name="idPredmet" value="<?= $id ?>" />
                                        <input type="hidden" name="leto" value="<?= $leto ?>" />
                                        <button type=submit >Izberi</button>
                                    </form>
                                </td>
                            </tr><?php
                            }
                            ?>



                            </tbody>
                        </table>
                        <div>


                            <button id="btn" class="btn btn-theme btn-block" type="submit">
                                Izberi </button>
                        </div>
                    </form>
                </div>
            </div>

            <div  <?php

            if ($vpisani == null){ echo 'style="display:none;"' ; } ?>  class="row">
                <div  class="col-xs-12 col-md-6">
                    <br>
                    <?php $data = [$predmet["ID_PREDMET"],$predmet["IME_PREDMET"],$leto,count($vpisani)]?>
                    <h2>Seznam vpisanih</h2>
                    <form  action="<?= BASE_URL . "vpisPredmet/exportCSV" ?>" method="post">
                        <input type="hidden" name="searchVpisna" value="<?= $data ?>"/>
                        <input id="csv" class="btn btn-primary btn-sm"  type="submit" value="Izvozi v CSV"/>
                    </form>
                    <form  action="<?= BASE_URL . "vpisPredmet/exportPDF" ?>" method="post">
                        <input type="hidden" name="searchVpisna" value="<?= $data ?>"/>
                        <input id="pdf" class="btn btn-primary btn-sm"  type="submit" value="Izvozi v PDF"/>
                    </form>

                    <table id="table-izpitov" class="table table-striped table-advance table-hover">
                        <thead>
                        <tr>

                            <th>Šifra predmeta</th>
                            <th>Ime predmeta</th>
                            <th>Študijsko leto</th>
                            <th>Število vpisanih</th>

                        </tr>
                        </thead>
                        <tbody>
                        <tr>

                            <td><?= $predmet["ID_PREDMET"] ?></td>
                            <td><?= $predmet["IME_PREDMET"] ?></td>
                            <th><?= $leto ?></th>
                            <th><?= count($vpisani) ?></th>


                        </tr>
                        </tbody>
                    </table>


                    <table id="table-izpitov" class="table table-striped table-advance table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Vpisna številka</th>
                            <th>Priimek in ime</th>
                            <th>Vrsta vpisa</th>

                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <?php
                            $count = 0;
                            foreach ($vpisani as $row) {
                            $count +=1;
                            $ime = $row["PRIIMEK"]." ". $row["IME"];
                            $arr = [$count,$row["VPISNA_STEVILKA"],$ime,$row["OPIS_VPISA"]];
                            array_push($data, $arr)
                            ?>
                        <tr>
                            <td><?= $count ?></td>
                            <td><?= $row["VPISNA_STEVILKA"]?></td>
                            <td><?= $ime ?></td>
                            <th><?= $row["OPIS_VPISA"] ?></th>


                        </tr><?php
                        }
                        ?>



                        </tbody>
                    </table>

                </div>

            </div>
        </section>
    </section>
</section>
</body>
</html>