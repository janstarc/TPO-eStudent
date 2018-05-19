<header class="header black-bg">
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
    </div>
    <!--logo start-->
    <a href="/" class="logo">
        <b>eŠtudent</b>
    </a>

    <div class="nav notify-row" id="top_menu">
    </div>
    
    <div class="top-menu">
        <ul class="top-menu">
            <li>
                <a class="logout" href="<?= BASE_URL . "logout" ?>">Logout</a>
            </li>
        </ul>
    </div>
</header>

<aside>
    <div id="sidebar" class="nav-collapse ">
        <ul class="sidebar-menu" id="nav-accordion">
            <li class="mt">
                <a href="<?= BASE_URL . "PregledIzpitovProfesor" ?>">
                    <span>Pregled Izpitov Profesor</span>
                </a>
            </li>
            <li class="mt">
                <a href="<?= BASE_URL . "VnosIzpitov" ?>">
                    <span>Vnos Izpitov</span>
                </a>
            </li>
            <li class="mt">
                <a href="<?= BASE_URL . "vpisPredmetP" ?>">
                    <span>Seznam vpisanih v predmet</span>
                </a>
            </li>
            <li class="mt">
                <a href="<?= BASE_URL . "VnosOcenIzpitaP" ?>">
                    <span>Vnos Ocen Izpita</span>
                </a>
            </li>
            <li class="mt">
                <a href="<?= BASE_URL . "VnosKoncnihOcenP" ?>">
                    <span>Končne Ocene</span>
                </a>
            </li>
            <li class="mt">
                <a href="<?= BASE_URL . "izpitniRok/profesor" ?>">
                    <span>Izpitni Rok</span>
                </a>
            </li>
            <li class="mt">
                <a href="<?= BASE_URL . "izpitniRok/profesor/add" ?>">
                    <span>Dodaj Izpitni Rok</span>
                </a>
            </li>
        </ul>
    </div>
</aside>