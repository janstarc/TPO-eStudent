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
            <ul class="sidebar-menu" id="nav-accordion">
                <h4 class="centered">IME STUDENTA</h4>

                <li class="mt">
                    <a href="LoginViewer.php">
                        <i class="fa fa-home"></i>
                        <span>Domov</span>
                    </a>
                </li>


                <li class="mt">
                    <a class="active" href="ElektronskiIndeks.php">
                        <i class="fa fa-book"></i>
                        <span>Elektronski indeks</span>
                    </a>
                </li>

                <li class="mt">
                    <a href="PregledIzpitovStudent.php">
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
                <i>Ime studenta (Vpisna stevilka)</i></h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="content-panel">
                        <h4>Elektronski indeks</h4>
                        <hr>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Šifra</th>
                                <th>Predmet</th>
                                <th>Ocenil</th>
                                <th>Letnik</th>
                                <th>Datum</th>
                                <th>Opravljanje</th>
                                <th>ECTS</th>
                                <th>Ocena</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>>
                    <p>
                    <h5>
                        <a href="PregledIzpitovStudent.php">&#8658 Prikaži vse izpitne roke</a>
                    </h5>
                </div>
        </section>
    </section>
</section>
</body>
</html>