<header class="header black-bg">
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
    </div>
    <a href="<?= BASE_URL ?>" class="logo">
        <b>eŠtudent</b>
    </a>
    <a href="<?= BASE_URL . "logout" ?>" class="logo float-right">
        <b>Logout</b>
    </a>
</header>

<aside>
    <div id="sidebar" class="nav-collapse ">
        <ul class="sidebar-menu" id="nav-accordion">
            <li class="mt">
                <a href="<?= BASE_URL . "PregledIzpitovProfesor" ?>">
                    <span>PregledIzpitovProfesor</span>
                </a>
            </li>
            <li class="mt">
                <a href="<?= BASE_URL . "VnosIzpitov" ?>">
                    <span>VnosIzpitov</span>
                </a>
            </li>
            <li class="mt">
                <a href="<?= BASE_URL . "vpisPredmetP" ?>">
                    <span>Seznam vpisanih v predmet</span>
                </a>
            </li>
            <li class="mt">
                <a href="<?= BASE_URL . "VnosOcen" ?>">
                    <span>VnosOcen</span>
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