<?php
    $formAction = "studenti";
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <?php include("view/includes/head.php"); ?>
    <script>
        $(document).ready( function () {

            // Override default sorta s custom sortom
            jQuery.fn.dataTableExt.oSort["slo-desc"] = function (x, y) {
                return sloCompare(y,x);
            };

            jQuery.fn.dataTableExt.oSort["slo-asc"] = function (x, y) {
                return sloCompare(x,y);
            };

            var oTable = $("#table-vpisaniStudenti").DataTable({
                // Custom definicije za vsak stolpec
                "aoColumns": [{
                    "sClass": "center",
                    "bSortable": false
                }, {
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
                    "bSortable": false
                }],
                // Ordering v prvem stolpcu
                "order": [[ 1, 'asc' ]]
            });

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

                <div class="col-md-12">
                    <div class="content-panel">

                        <h2><?= $pageTitle ?></h2>
                        <?php if(isset($status)): ?>
                            <div class="alert alert-<?= ($status === "Failure") ? "danger" : (($status === "Success") ? "success" : "info") ?> alert-dismissible" role="alert">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?= $message ?>
                            </div>
                        <?php endif; ?>

                        <table id="table-vpisaniStudenti" class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Ime</th>
                                <th>Priimek</th>
                                <th>Vpisna stevilka</th>
                                <th>Preglej vloga</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach($allData as $data): ?>
                                <tr>
                                    <td></td>
                                    <td><?php echo $data['ime']; ?></td>
                                    <td><?php echo $data['priimek']; ?></td>
                                    <td><?php echo $data['vpisna_stevilka']; ?></td>
                                    <td>
                                        <form action="<?= BASE_URL . "studenti/".$data['id_oseba']."/exportPDFTiskaj" ?>" method="post">
                                            <input class="btn btn-primary btn-sm" type="submit" value="Preglej" />
                                        </form>
                                    </td>
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
