<!DOCTYPE html>

<html lang="en">
<head>
    <?php include("view/includes/head.php");
    ?>

</head>
<body>
<section id="container">
    <?php include("view/includes/menu-links-admin.php");


    ?>
    <section id="main-content">
        <section class="wrapper">
            <div class="row">
                <div class="col-xs-12 col-md-6">

                    <h3><?php if($data['tip'] == "a"){echo("Nov predmetnik");} else {echo ("Uredi predmetnik");} ?> </h3>

                    <form class="example"  action="<?= BASE_URL . "spremeniPredmetnik" ?>" method="post">
                        <input type="hidden" name="tip" value="<?= $data['tip'] ?>" />
                        <input type="hidden" name="idPredmet" value="<?= $data['idPredmet'] ?>" />
                        <input type="hidden" name="idPredmetnik" value="<?= $data['idPredmetnik'] ?>" />

                        <div >
                            <select name="leto">
                                <?php
                                echo "<option disabled selected value=''>"." študijsko leto"."</option>";

                                foreach ($all[0] as $key => $value){
                                    if(($data['tip']== "e")  and ($predmetnik['ID_STUD_LETO'] == $value['ID_STUD_LETO'])){
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
                                    if(($data['tip']== "e") and ($predmetnik['ID_LETNIK'] == $value['ID_LETNIK'])){
                                        echo "<option value=".$value['ID_LETNIK']." selected >".$value['LETNIK']."</option>";
                                    }
                                    else{echo "<option value=".$value['ID_LETNIK']."  >".$value['LETNIK']."</option>";
                                        ;}


                                }
                                ?>

                            </select>
                            <select name="program">
                                <?php
                                echo "<option disabled selected>"." program"."</option>";

                                foreach ($all[2] as $key => $value){
                                    if(($data['tip']== "e")and ($predmetnik['ID_PROGRAM'] == $value['ID_PROGRAM'])){
                                        echo "<option value=".$value['ID_PROGRAM']." selected >".$value['SIFRA_EVS'].": ".$value['NAZIV_PROGRAM']."</option>";
                                    }
                                    else{echo "<option value=".$value['ID_PROGRAM']."  >".$value['SIFRA_EVS'].": ".$value['NAZIV_PROGRAM']."</option>";
                                        ;}
                                }
                                ?>
                            </select>
                            <select name="delpredmetnika">
                                <?php
                                echo "<option disabled selected>"." del predmetnika"."</option>";

                                foreach ($all[3] as $key => $value){
                                    if(($data['tip']== "e")and ($predmetnik['ID_DELPREDMETNIKA'] == $value['ID_DELPREDMETNIKA'])){
                                        echo "<option value=".$value['ID_DELPREDMETNIKA']." selected >".$value['NAZIV_DELAPREDMETNIKA']."</option>";
                                    }
                                    else{echo "<option value=".$value['ID_DELPREDMETNIKA']."  >".$value['NAZIV_DELAPREDMETNIKA']."</option>";
                                        ;}
                                }
                                ?>
                            </select>
                            <div>
                                <button id="btn" class="btn btn-theme btn-block" type="submit">
                                    <?php if($data['tip'] == "a"){echo("Ustvari");} else {echo ("Spremeni");} ?> </button>
                            </div>
                    </form>
                </div>
            </div>
        </section>
    </section>
</section>
</body>
</html>
