<!DOCTYPE html>

<html lang="en">
<head>
    <?php include("view/includes/head.php");    ?>

    <script>
        $(document).ready( function () {


            var oTable = $("#table-subject").DataTable({
                // Custom definicije za vsak stolpec
                "aoColumns": [ {
                        "sClass": "center",
                        "bSortable": false
                    }, {
                        "sClass": "center",
                        "bSortable": true,
                        "sType":"slo"
                    },{
                        "sClass": "center",
                        "bSortable": true,
                        "sType":"slo"
                    }, {
                        "sClass": "center",
                        "bSortable": true,
                        "sType":"slo"
                    },{
                        "sClass": "center",
                        "bSortable": true,
                        "sType":"slo"
                    },{
                        "sClass": "center",
                        "bSortable": false,
                        "sType":"slo"
                    } ],
                // Ordering v prvem stolpcu
                "order": [[ 1, 'asc' ]]
            });

            // Override default sorta s custom sortom
            jQuery.fn.dataTableExt.oSort["slo-desc"] = function (x, y) {
                return sloCompare(y,x);
            };

            jQuery.fn.dataTableExt.oSort["slo-asc"] = function (x, y) {
                return sloCompare(x,y);
            };

            // Dinamicni ordering, ko se spremeni sort parameter
            oTable.on( 'order.dt search.dt', function () {
                oTable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();
        } );
    </script>
</head>
<body>
<section id="container">
    <?php include("view/includes/menu-links-student-officer.php"); ?>
    <section id="main-content">
        <section class="wrapper">
            <div class="row">

                <div  class="col-xs-12 col-md-12">
                    <h3>Seznam predmetov s številom vpisanih študentov </h3>

                        <table id="table-subject" class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Šifra predmeta</th>
                                <th>Ime predmeta</th>
                                <th>Ime glavnega predavatelja</th>
                                <th>Izberi predmet</th>
                            </tr>
                            </thead>
                            <tbody>

                                <?php
                                $n = 0;
                                foreach ($predmeti as $row) {
                                $n += 1 ;
                                $izvedba = $row["IME_PREDMET"];
                                $id =$row["ID_PREDMET"];
                                $profesor = $row['IME'] . $row['PRIIMEK']
                                ?>
                            <tr>
                                <td></td>
                                <td><?= $row['ID_PREDMET'] ?></td>
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



