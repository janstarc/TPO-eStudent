<!DOCTYPE html>

<html lang="en">
<head>
    <?php include("view/includes/head.php"); ?>

    <script>
        $(document).ready( function () {


            var oTable = $("#table-subject").DataTable({
                // Custom definicije za vsak stolpec
                "aoColumns": [
                    {
                        "sClass": "center",
                        "bSortable": false
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
                        "bSortable": true,
                        "sType":"slo"
                    },{
                        "sClass": "center",
                        "bSortable": false
                    },{
                        "sClass": "center",
                        "bSortable": false
                    }
                ],
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
    <?php if($oseba ==1)
        include("view/includes/menu-links-student-officer.php");
    if($oseba ==2)
        include("view/includes/menu-links-student.php");
    if($oseba ==3)
        include("view/includes/menu-links-professor.php"); ?>
    <section id="main-content">
        <section class="wrapper">
            <div class="row">

                <div class="col-md-12">
                    <div class="content-panel">

                        <h2><?= $pageTitle ?></h2>
                        <?php if(isset($status)): ?>
                            <div class="alert alert-<?= ($status === "Failure") ? "danger" : (($status === "Success") ? "success" : "info") ?> alert-dismissible" role="alert">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?= $message ?>
                            </div>
                        <?php endif; ?>

                        <table id="table-subject" class="table table-striped table-advance table-hover">
                            <thead>
                            <tr><th>#</th>
                                <th>Ime</th>
                                <th>Priimek</th>
                                <th>Vpisna stevilka</th>
                                <th>Vsota Opravljenih KT</th>
                                <th>Vsa polaganja</th>
                                <th>Zadnje polaganje</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php $n = 0;
                            foreach($allData as $data):
                                $n+=1;?>
                                <tr>
                                    <td></td>
                                    <td><?php echo $data['IME']; ?></td>
                                    <td><?php echo $data['PRIIMEK']; ?></td>
                                    <td><?php echo $data['VPISNA_STEVILKA']; ?></td>
                                    <td><?php echo $data['VSOTA_OPRAVLJENIH_KREDITNIH_TOCK']; ?></td>
                                    <td><form action="<?= BASE_URL . $formAction . "/" . $data['ID_OSEBA'] ."/1"?>" method="get">
                                        <input class="btn btn-primary btn-sm" type="submit" value="Poglej" />
                                    </form></td>
                                    <td><form action="<?= BASE_URL . $formAction . "/" . $data['ID_OSEBA'] ."/2" ?>" method="get">
                                            <input class="btn btn-primary btn-sm" type="submit" value="Poglej" />
                                        </form></td>

                                </tr>
                            <?php endforeach; ?>
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
