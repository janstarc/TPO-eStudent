<?php
    $resultFound = false;
    if(!empty($studData)) $resultFound = true;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("view/includes/head.php"); ?>

    <!-- BEGIN syntax highlighter -->
    <script type="text/javascript" src="../static/js/shCore.js"></script>
    <script type="text/javascript" src="../static/js/shBrushJScript.js"></script>
    <link type="text/css" rel="stylesheet" href="../static/css/shCore.css"/>
    <link type="text/css" rel="stylesheet" href="../static/css/shThemeDefault.css"/>
    <link type="text/css" rel="stylesheet" href="../static/css/custom.css">
    <script type="text/javascript">
        SyntaxHighlighter.all();
    </script>
    <!-- END syntax highlighter -->

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="../static/js/jquery.searchabledropdown-1.0.8.min.js"></script>


    <script type="text/javascript">
        $(document).ready(function() {
            $("select").searchable();
        });


        // demo functions
        $(document).ready(function() {
            $("#value").html($("#myselect :selected").text() + " (VALUE: " + $("#myselect").val() + ")");
            $("select").change(function(){
                $("#value").html(this.options[this.selectedIndex].text + " (VALUE: " + this.value + ")");
            });
        });

        function modifySelect() {
            $("select").get(0).selectedIndex = 5;
        }

        function appendSelectOption(str) {
            $("select").append("<option value=\"" + str + "\">" + str + "</option>");
        }

        function applyOptions() {
            $("select").searchable({
                maxListSize: $("#maxListSize").val(),
                maxMultiMatch: $("#maxMultiMatch").val(),
                latency: $("#latency").val(),
                exactMatch: $("#exactMatch").get(0).checked,
                wildcards: $("#wildcards").get(0).checked,
                ignoreCase: $("#ignoreCase").get(0).checked
            });

            alert(
                "OPTIONS\n---------------------------\n" +
                "maxListSize: " + $("#maxListSize").val() + "\n" +
                "maxMultiMatch: " + $("#maxMultiMatch").val() + "\n" +
                "exactMatch: " + $("#exactMatch").get(0).checked + "\n"+
                "wildcards: " + $("#wildcards").get(0).checked + "\n" +
                "ignoreCase: " + $("#ignoreCase").get(0).checked + "\n" +
                "latency: " + $("#latency").val()
            );
        }
    </script>
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
                            <input type="text" class="width-fix" placeholder="Išči po vpisni številki" name="searchVpisna">
                            <button type="submit" name="isciVpisnaBtn">Išči</button>
                        </form>
                        <br>
                        <br>
                        <p></p>
                        <form class="example"  action="<?= BASE_URL . "OsebniPodatkiStudenta/vpisnaSearch" ?>" method="post">
                            <select class="btn btn-secondary dropdown-toggle m-left" id="myselect" name="searchVpisna">
                                <?php
                                    echo "<option disabled selected value=''>"."Išči po imenu in priimku"."</option>";

                                    foreach ($namesAndSurnames as $key => $value){
                                        echo "<option value=".$value['vpisna_stevilka'].">".$value['ime']." ".$value['priimek']."</option>";
                                    }
                                ?>
                            </select>
                            <button type="submit">Išči</button>
                        </form>


                        <br>
                        <br>
                        <hr>
                            <div id="tables" <?php if ($resultFound){ echo 'style="display:none;"'; } ?>>
                                <p>Izbrani študent ne obstaja, ali pa so njegovi podatki nepopolni! (Manjkajo atributi iz queryjev)</p>
                            </div>
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