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

            var oTable = $("#table-letnik").DataTable({
                // Custom definicije za vsak stolpec
                "aoColumns": [{
                    "sClass": "center",
                    "bSortable": false
                }, {
                    "sClass": "center",
                    "bSortable": false

                }, {
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
    <?php include("view/includes/menu-links-admin.php"); ?>
    <section id="main-content">
        <section class="wrapper">
            <div class="row">
                <div class="col-md-12">
                    <div class="content-panel">
                        <hr>
                        <h4>Seznam letnikov</h4>
                        <br>
                        <br>
                        <br>
                        <?php if(isset($status)): ?>
                            <div class="alert alert-<?= ($status === "Failure") ? "danger" : (($status === "Success") ? "success" : "info") ?> alert-dismissible" role="alert">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?= $message ?>
                            </div>
                        <?php endif; ?>
                        <table id="table-letnik" class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th>Šifra</th>
                                <th>Letnik</th>
                                <th>Uredi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            // var_dump($all);
                            foreach($all as $key=>$value): ?>
                                <tr>
                                    <td></td>
                                    <td><?php echo $value['LETNIK']; ?></td>
                                    <td>
                                        <form action="  <?= BASE_URL . "LetnikAll/editForm" ?>" method="post">
                                            <input type="hidden" name="urediId" value="<?= $value['ID_LETNIK'] ?>" />
                                            <input class="btn btn-primary btn-sm" type="submit" value="Uredi" />
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