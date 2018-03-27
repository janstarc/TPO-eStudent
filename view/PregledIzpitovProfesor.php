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
            <b>eŠtudent</b>
        </a>

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
            <!-- sidebar menu start-->
            <ul class="sidebar-menu" id="nav-accordion">

                <h5 class="centered">Ime studenta</h5>

                <li class="mt">
                    <a href="LoginViewer.php">
                        <i class="fa fa-home"></i>
                        <span>Domov</span>
                    </a>
                </li>



                <li class="mt">
                    <a class="active" href="PregledIzpitovProfesor.php">
                        <i class="fa fa-folder-open-o"></i>
                        <span>Pregled izpitov</span>
                    </a>
                </li>

            </ul>
        </div>
    </aside>

    <section id="main-content">
        <section class="wrapper">
            <h3>
                Ime studenta (Vpisna stevilka)</h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="content-panel">
                        <h4>Študijski smer: Napisi smer</h4>
                        <hr>
                        <p><label><strong>Išči izpit po predmetu</strong>:
                                <input id="isci-predmet-input" type="search" /></label>   <button id="isci-predmet-gumb" class="btn btn-default btn-xs" type="button"><span class="glyphicon glyphicon-search"></span> Išči</button></p>
                        <hr>
                        <table id="table-izpitov" class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Letnik</th>
                                <th>Predmet</th>
                                <th>Izvajalec</th>
                                <th>Datum</th>
                                <th>Prijava/Odjava</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td></td>
                                <td><td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <button class="btn btn-primary btn-xs">Prijavi se
                                    </button>
                                </td>
                            </tr>


                            </tbody>
                        </table>
                    </div>

                </div>

        </section>

    </section>

</section>




</body>

</html>