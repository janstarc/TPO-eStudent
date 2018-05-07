<header class="header black-bg">
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
    </div>
    <a href="/" class="logo">
        <b>eStudent</b>
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
                <a href="<?= BASE_URL . "kandidati" ?>">
                    <span>Pregled kandidatov</span>
                </a>
            </li>
            <li class="mt">
                <a href="<?= BASE_URL . "izpitniRok/referent" ?>">
                    <span>Izpitni Rok</span>
                </a>
            </li>
            <li class="mt">
                <a href="<?= BASE_URL . "zeton" ?>">
                    <span>Žeton</span>
                </a>
            </li>
        </ul>
    </div>
</aside>