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

        <a href="LoginViewer.php" class="logo">
            <b>EŠTUDENT</b>
        </a>

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
                    <a class="active" href="VnosIzpitov.php">
                        <i class="fa fa-calendar"></i>
                        <span>Razpisovanje izpitnih rokov</span>
                    </a>
                </li>

                <li class="mt">
                    <a href="VnosOcen.php">
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
            <h3>Razpisovanje izpitnih rokov</h3>
            <div class="row">

                <div class="col-md-12">
                    <div class="content-panel">

                        <table class="table">
                            <thead>
                            <tr>
                                <th>Predmet</th>
                                <th>Datum in ura</th>
                                <th>Predavalnica</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <input style="height:28px" type="text" id="dodajIspit" />

                                </td>

                                <td>
                                    <input style="height:28px" type="datetime-local" name="dateTime" id="publishDate" />                                            </td>
                                <td>
                                    <input style="height:28px" type="text" id="dodajPredavalnico" />
                                </td>

                                <td>
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Dodaj izpit</button>

                                    <div class="modal fade" id="myModal" role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><form>
                                                    <p><label>Ste prepričani da boste razpisali izpitni rok?</label></p>
                                                    <label>DA
                                                        <input name="izpit" type="radio" value="izpit" required></label>
                                                    <p><label>Komentarji:<br>
                                                            <textarea name="komentarji" rows="4" cols="36">Vnesite dodatne komentarje</textarea>
                                                        </label></p>
                                                    </form></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal" id="gumb">Dodaj</button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Zapri</button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </td>


                            </tr>
                            </tbody>
                        </table>

                    </div>
                    <!--/content-panel -->
                </div>
                <!-- /col-md-12 -->


                <div class="col-md-12 mt">
                    <h3>Seznam vseh razpisanih izpitnih rokov</h3>
                    <div class="content-panel">
                        <table id="tabelaIzpitov"class="table">
                            <thead>
                            <tr>
                                <th>Premet</th>
                                <th>Datum in ura</th>
                                <th>Predavalnica</th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><button id="toDelete"type="button" class="btn btn-info">Izbriši izpit</button></td>
                            </tr>
                            </tbody>
                        </table>

                    </div>

                </div>

            </div>

        </section>


</body>

</html>