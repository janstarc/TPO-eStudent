<header class="header black-bg">
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
    </div>
    <a href="<?= BASE_URL ?>" class="logo">
        <b>eStudent</b>
    </a>
    <a href="<?= BASE_URL . "logout" ?>" class="logo float-right">
        <b>Logout</b>
    </a>
</header>

<aside>
    <div id="sidebar" class="nav-collapse ">
        <ul class="sidebar-menu" id="nav-accordion">
            <li class="mt">
                <a href="<?= BASE_URL . "kandidati" ?>">
                    <span>Pregled kandidatov</span>
                </a>
            </li>
            <li class="mt">
                <a href="<?= BASE_URL . "kandidatiZaVisjiLetnik" ?>">
                    <span>Pregled kandidatov za visji letnik</span>
                </a>
            </li>
            <li class="mt">
                <a href="<?= BASE_URL . "vpisaniStudenti" ?>">
                    <span>Pregled vpisanih študentov</span>
                </a>
            </li>
            <li class="mt">
                <a href="<?= BASE_URL . "steviloVpisanih" ?>">
                    <span>Število vpisanih</span>
                </a>
            </li>
            <li class="mt">
                <a href="<?= BASE_URL . "vpisPredmet/" ?>">
                    <span>Seznam vpisanih v predmet</span>
                </a>
            </li>
            <li class="mt">
                <a href="<?= BASE_URL . "izpitniRok/referent/chooseProfesor" ?>">
                    <span>Izpitni Rok</span>
                </a>
            </li>
            <li class="mt">
                <a href="<?= BASE_URL . "zetoni" ?>">
                    <span>Žeton</span>
                </a>
            </li>
        </ul>
    </div>
</aside>