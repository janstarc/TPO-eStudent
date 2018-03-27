<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eŠtudent</title>

    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "bootstrap.css" ?>">
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
    <script type="text/javascript" src="<?= JS_URL . "jquery.js" ?>"></script>
    <script type="text/javascript" src="<?= JS_URL . "bootstrap.min.js" ?>"></script>
    <script type="text/javascript" src="<?= JS_URL . "jquery.backstretch.min.js" ?>"></script>
</head>

<body>

<section id="container">

    <header class="header black-bg">
        <div class="sidebar-toggle-box">
            <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
        </div>
        <!--logo start-->
        <a href="LoginViewer.php" class="logo">
            <b>EŠTUDENT</b>
        </a>
        <!--logo end-->
        <div class="nav notify-row" id="top_menu">

        </div>
        <div class="top-menu">
            <ul class="nav pull-right top-menu">
                <li>
                    <a class="logout" href="LoginViewer.php">Logout</a>
                </li>
            </ul>
        </div>
    </header>

    <aside>
        <div id="sidebar" class="nav-collapse ">

            <ul class="sidebar-menu" id="nav-accordion">


                <h5 class="centered">Ime profesorja/Studentski referat</h5>

                <li class="mt">
                    <a href="LoginViewer.php">
                        <i class="fa fa-home"></i>
                        <span>Domov</span>
                    </a>
                </li>

                <li class="mt">
                    <a href="VnosIzpitov.php">
                        <i class="fa fa-calendar"></i>
                        <span>Razpisovanje izpitnih rokov</span>
                    </a>
                </li>

                <li class="mt">
                    <a class="active" href="VnosOcen.php">
                        <i class="fa fa-keyboard-o"></i>
                        <span>Vnos ocen</span>
                    </a>
                </li>


                <li class="mt">
                    <a href="PregledIzpitovProfesor.php">
                        <i class="fa fa-folder-open-o"></i>
                        <span>Pregled izpitov</span>
                    </a>
                </li>

            </ul>

        </div>
    </aside>

    <section id="main-content">
        <section class="wrapper">
            <h3>Seznam mojih predmetov</h3>
            <div class="row mt">
                <div class="col-lg-12">
                    <div class="content-panel">
                        <section id="unseen">
                            <table class="table table-bordered table-striped table-condensed">
                                <thead>
                                <tr>
                                    <th>Šifra predmeta</th>
                                    <th>Predmet</th>
                                    <th>Vpisna številka študenta</th>
                                    <th>Letnik</th>
                                    <th>Datum</th>
                                    <th>Opravljanje</th>
                                    <th>KT</th>
                                    <th>Ocena</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <textarea id="textAreaVpisna"rows="1" cols="10"></textarea>
                                    </td>
                                    <td></td>
                                    <td><input style="height:28px" type="datetime-local" id="datumOcena" name="dateTime"></td>
                                    <td><textarea rows="1" cols="2" id="textAreaOpravljanje"></textarea></td>
                                    <td></td>
                                    <td><textarea rows="1" cols="1" id="textAreaOcena"></textarea></td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" id="vnesiOcena">Vnesi ocena</button>

                                    </td>

                                </tr>

                                </tbody>
                            </table>
                        </section>
                    </div>
                    <!-- /content-panel -->
                </div>
                <!-- /col-lg-4 -->
            </div>
            <!-- /row -->
            <div class="row mt">
                <div class="col-md-12 mt">
                    <h3>Seznam vseh ocen po predmetu</h3>
                    <div class="content-panel">
                        <h5>Izberi predmet:
                            <input list="predmet" name="predmet">
                            <datalist id="predmet">
                                <option value=""></option>
                            </datalist>
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" id="prikaz">Prikazi</button>
                        </h5>
                        <table id="tabelaOcen" class="table table-bordered table-striped table-condensed">
                            <thead>
                            <tr>
                                <th>Vpisna številka </th>
                                <th>Datum izpita</th>
                                <th>Opravljanje</th>
                                <th>KT</th>
                                <th>Ocena</th>
                            </tr>
                            </thead>
                            <tbody>

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