<!DOCTYPE html>

<html lang="en">
<head>
    <?php include("view/includes/head.php"); ?>
</head>
<body>
<section id="container">
    <?php include("view/includes/menu-links-admin.php"); ?>
    <section id="main-content">
        <section class="wrapper">
            <div class="row">
                <div class="col-md-12">
                    <div class="content-panel">
                        <h3>Iskanje predmeta</h3>
                        <br>
                        <form class="subject">
                            <input type="text" placeholder="IŠČI PO PREDMETU..." name="searchSubject">
                            <button type="submit">Išči</button>
                        </form>
                        <br>
                        <br>
                        <hr>
                        <h4>Prikaz predmeta</h4>
<!--                        <button class="btn btn-info btn-xs" id="add" data-toggle="modal" data-target="#myModal">Dodaj izvajalec</button>-->
<!--                        <button class="btn btn-info btn-xs" id="delete" data-toggle="modal" data-target="#myModal2">Izbrisi izvajalca</button>-->
<!--                        <button class="btn btn-info btn-xs" id="edit" data-toggle="modal" data-target="#myModal3">Spremeni izvajalca</button>-->
                        <br>
                        <br>
                        <br>
                        <table id="table-subject" class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th>Letnik</th>
                                <th>Predmet</th>
                                <th>Izvajalec</th>
                                <th>Studijsko leto</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>

                        <form action="<?= BASE_URL . $formAction ?>" method="post">
                            <select name="professor_id">
                                <?php foreach($professors as $professor): ?>
                                    <option value="<?php echo $professor['ID_UCITELJ']?>"><?php echo $professor['IME'] . " " . $professor['PRIIMEK']?></option>
                                <?php endforeach; ?>
                            </select>
                            <select name="semester_id">
                                <?php foreach($semesters as $semester): ?>
                                    <option value="<?php echo $semester['ID_STUD_LETO']?>"><?php echo $semester['STUD_LETO']?></option>
                                <?php endforeach; ?>
                            </select>
                            <select name="subject_id">
                                <?php foreach($subjects as $subject): ?>
                                    <option value="<?php echo $subject['ID_PREDMET']?>"><?php echo $subject['IME_PREDMET']?></option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit">Store professor</button>
                        </form>

<!--                        <div class="modal fade" id="myModal" role="dialog">-->
<!--                            <div class="modal-dialog">-->
<!--                                <div class="modal-content">-->
<!--                                    <div class="modal-header">-->
<!--                                        <button type="button" class="close" data-dismiss="modal">&times;</button>-->
<!--                                    </div>-->
<!--                                    <div class="modal-body">-->
<!--                                        <form class="modalWindow">-->
<!--                                            <input type="text" placeholder="IME">-->
<!--                                            <input type="text" placeholder="PRIIMEK">-->
<!--                                            <input type="text" placeholder="PREDMET">-->
<!--                                            <input type="text" placeholder="STUDIJSKO LETO">-->
<!--                                        </form>-->
<!--                                    </div>-->
<!--                                    <div class="modal-footer">-->
<!--                                        <button type="button" class="btn btn-default" data-dismiss="modal">DODAJ</button>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!---->
<!--                        <div class="modal fade" id="myModal2" role="dialog">-->
<!--                            <div class="modal-dialog">-->
<!--                                <div class="modal-content">-->
<!--                                    <div class="modal-header">-->
<!--                                        <button type="button" class="close" data-dismiss="modal">&times;</button>-->
<!--                                    </div>-->
<!--                                    <div class="modal-body">-->
<!--                                        <form class="modalWindow">-->
<!--                                            <input type="text" placeholder="IME">-->
<!--                                            <input type="text" placeholder="PRIIMEK">-->
<!--                                            <input type="text" placeholder="PREDMET">-->
<!--                                            <input type="text" placeholder="STUDIJSKO LETO">-->
<!--                                        </form>-->
<!--                                    </div>-->
<!--                                    <div class="modal-footer">-->
<!--                                        <button type="button" class="btn btn-default" data-dismiss="modal">IZBRISI</button>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!---->
<!--                        <div class="modal fade" id="myModal3" role="dialog">-->
<!--                            <div class="modal-dialog">-->
<!--                                <div class="modal-content">-->
<!--                                    <div class="modal-header">-->
<!--                                        <button type="button" class="close" data-dismiss="modal">&times;</button>-->
<!--                                    </div>-->
<!--                                    <div class="modal-body">-->
<!--                                        <form class="modalWindow">-->
<!--                                            <input type="text" placeholder="IME">-->
<!--                                            <input type="text" placeholder="PRIIMEK">-->
<!--                                            <input type="text" placeholder="PREDMET">-->
<!--                                            <input type="text" placeholder="STUDIJSKO LETO">-->
<!--                                        </form>-->
<!--                                    </div>-->
<!--                                    <div class="modal-footer">-->
<!--                                        <button type="button" class="btn btn-default" data-dismiss="modal">SPREMENI</button>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->

                    </div>
                </div>
            </div>
        </section>
    </section>
</section>
</body>
</html>