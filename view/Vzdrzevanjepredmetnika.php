<!DOCTYPE html>

<html lang="en">
<head>

    <?php
    require_once("view/includes/head.php");
    require_once("controller/ProfessorController.php")

    ?>
</head>
<body>
<section id="container">
    <?php include("view/includes/menu-links-professor.php"); ?>
    <section id="main-content">
        <section class="wrapper">
            <div class="row">
                <div class="col-md-12">
                    <div class="content-panel">
                        <br>
                        <form class="example">
                            <button type="submit" name="dodajnp" value="1">Dodaj nov predmet</button>
                        </form>


                        <div id="tables" <?php if(!isset($_GET['dodajnp'])/* or (isset($_GET['dodaj']))*/){  echo 'style="display:none;"'; } ?>>

                            <table id="table-izpitov" class="table table-striped table-advance table-hover">
                                <thead>
                                <tr>
                                    <th>Dodajanje Novega predmeta</th>
                                </tr>
                                </thead>
                                <tbody>
                                <form class="example" action="<?= BASE_URL . "Vzdrzevanjepredmetnika/dodaj"/*Vzdrzevanjepredmetnika/Add"*/ ?>" method="post">

                                <tr>

                                    <td>Ime Predmeta</td>
                                    <td><input name="ime" type="text" /></td>
                                </tr>
                                <tr>
                                    <td>Študijsko leto</td>
                                    <td><select  name="leto"  >
                                            <option value="2017">2017/2018</option>
                                            <option value="2018">2018/2019</option>
                                    </td>


                                </tr>
                                <tr>
                                    <td>Glavni Profesor ime</td>
                                    <td><input input name="GlavniIme" type="text" /></td>
                                    <td>Glavni Profesor priimek</td>
                                    <td><input input name="GlavniPriimek" type="text" /></td>
                                </tr>
                                <tr>
                                    <td>Profesor 2 ime</td>
                                    <td><input input name="2Ime" type="text" /></td>
                                    <td>Profesor 2 priimek</td>
                                    <td><input input name="2Priimek" type="text" /></td>
                                </tr>'+'<tr>
                                    <td>Profesor 3 ime</td>
                                    <td><input input name="3Ime" type="text" /></td>
                                    <td>Profesor 3 priimek</td>
                                    <td><input input name="3Priimek" type="text" /></td>
                                </tr>
                                <tr>
                                    <td>

                                            <button type="submit">Dodaj</button>
                                        </form>
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                            <hr>


                        </div><br><br><br>
                        <div>
                            <h3>Prikaz predmetov</h3></div>
                        <table id="table-izpitov" class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th>Ime predmeta</th>
                                <th>Učitelj1</th>
                                <th>Učitelj2</th>
                                <th>Učitelj3</th>
                                <th>uredi predmet</th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <?php
                                $data = ProfesorController::getPredmeti();

                                echo("<script>console.log('PHP: ', ".$data[0].");</script>");
                                echo("<script>console.log('PHP: ', ".$data[0]['ID_UCITELJ1'].");</script>");
                                $c=0;
                                foreach ($data as $row) {
                                    echo("<script>console.log('forloop: ', ".$c.");</script>");
                                    $izvedba = ProfesorController::getPredmetIme($data[$c]['ID_PREDMET']);
                                    $ucitelj1=ProfesorController::getUcitelj($data[$c]["ID_UCITELJ1"],1);
                                    $ucitelj2=ProfesorController::getUcitelj($data[$c]["ID_UCITELJ2"],2);
                                    $ucitelj3=ProfesorController::getUcitelj($data[$c]["ID_UCITELJ3"],3);
                                   echo ("<tr>
                                <td>$izvedba</td>
                                <td>$ucitelj1</td>
                                <td>$ucitelj2</td>
                                <td>$ucitelj3</td>
                                <td></td></tr>");
                                    $c++;}
                                ?>


                            </tr>
                            </tbody>
                        </table>
                        </div>
                        <hr>

                    </div>
                </div>
                </div>
            </div>
        </section>
    </section>
</section>

</body>
</html>



