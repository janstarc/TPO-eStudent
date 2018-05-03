<!DOCTYPE html>

<html lang="en">
<head>
    <?php include("view/includes/head.php"); ?>
</head>
<body>
<section id="container">
    <?php include("view/includes/menu-links-student-officer.php");
    ?>
    <section id="main-content">
        <section class="wrapper">
            <div class="row">
                <div class="col-xs-12 col-md-6">

                    <h3>Urejanje žetona </h3>

                    <form class="example"  action="<?= BASE_URL . "Zeton/spremeni" ?>" method="post">
                        <input type="hidden" name="id_zeton" value="<?= $id_zeton ?>" />
                        <div >
                            <select name="leto">
                                <?php
                                echo "<option disabled selected value=''>"." študijsko leto"."</option>";

                                foreach ($all[0] as $key => $value){
                                    if($zeton['ID_STUD_LETO'] == $value['ID_STUD_LETO']){
                                        echo "<option value=".$value['ID_STUD_LETO']." selected >".$value['STUD_LETO']."</option>";
                                    }
                                    else{echo "<option value=".$value['ID_STUD_LETO']."  >".$value['STUD_LETO']."</option>";
                                        ;}

                                }
                                ?>

                            </select>
                            <select  name="letnik">
                                <?php
                                echo "<option disabled selected value=''>"." letnik"."</option>";

                                foreach ($all[1] as $key => $value){
                                    if($zeton['ID_LETNIK'] == $value['ID_LETNIK']){
                                        echo "<option value=".$value['ID_LETNIK']." selected >".$value['LETNIK']."</option>";
                                    }
                                    else{echo "<option value=".$value['ID_LETNIK']."  >".$value['LETNIK']."</option>";
                                        ;}


                                }
                                ?>

                            </select>
                            <select name="program">
                                <?php
                                echo "<option >"." program"."</option>";

                                foreach ($all[2] as $key => $value){

                                    if($zeton['ID_PROGRAM'] == $value['ID_PROGRAM']){
                                        echo "<option value=".$value['ID_PROGRAM']." selected >".$value['NAZIV_PROGRAM']."</option>";
                                    }
                                    else{echo "<option value=".$value['ID_PROGRAM']."  >".$value['NAZIV_PROGRAM']."</option>";
                                        ;}
                                }
                                ?>
                            </select>
                            <select name="Vrstavpisa">
                                <?php
                                echo "<option disabled selected value=''>"." vrsta vpisa"."</option>";

                                foreach ($all[3] as $key => $value){

                                    if($zeton['ID_VRSTAVPISA'] == $value['ID_VRSTAVPISA']){
                                        echo "<option value=".$value['ID_VRSTAVPISA']." selected >".$value['OPIS_VPISA']."</option>";
                                    }
                                    else{echo "<option value=".$value['ID_VRSTAVPISA']."  >".$value['OPIS_VPISA']."</option>";
                                        ;}
                                }
                                ?>
                            </select>
                            <select name="NacinStudija">
                                <?php
                                echo "<option disabled selected value=''>"." način študija"."</option>";

                                foreach ($all[4] as $key => $value){
                                    if($zeton['ID_NACIN'] == $value['ID_NACIN']){
                                        echo "<option value=".$value['ID_NACIN']." selected >".$value['OPIS_NACIN']."</option>";
                                    }
                                    else{echo "<option value=".$value['ID_NACIN']."  >".$value['OPIS_NACIN']."</option>";
                                        ;}
                                }
                                ?>
                            </select>
                            <select name="OblikaStudija">
                                <?php
                                echo "<option disabled selected value=''>"." oblika študija"."</option>";

                                foreach ($all[5] as $key => $value){
                                    if($zeton['ID_OBLIKA'] == $value['ID_OBLIKA']){
                                        echo "<option value=".$value['ID_OBLIKA']." selected >".$value['NAZIV_OBLIKA']."</option>";
                                    }
                                    else{echo "<option value=".$value['ID_OBLIKA']."  >".$value['NAZIV_OBLIKA']."</option>";
                                        ;}
                                }
                                ?>
                            </select>
                            <div>
                                <button id="btn" class="btn btn-theme btn-block" type="submit">
                                    Spremeni </button>
                            </div>
                    </form>
                </div>
            </div>
        </section>
    </section>
</section>
</body>
</html>