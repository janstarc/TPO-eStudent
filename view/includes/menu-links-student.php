<header class="header black-bg">
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
    </div>
    <a href="<?= BASE_URL ?>" class="logo">
        <b>eStudent</b>
    </a>

    <a href="<?= BASE_URL . "logout" ?>" class="logo float-right">
        <b>
            Vloga:
            <?php
            if (User::isLoggedInAsAdmin()) echo "admin";
            else if (User::isLoggedInAsProfessor()) echo "profesor";
            else if (User::isLoggedInAsStudent()) echo "student";
            else if (User::isLoggedInAsStudentOfficer()) echo "referent";
            else if (User::isLoggedInAsCandidate()) echo "kandidat";
            echo " | Logout (".User::getEmail().")";
            ?>
        </b>
    </a>
</header>

<aside>
    <div id="sidebar" class="nav-collapse " style="overflow-y: auto;">
        <ul class="sidebar-menu" id="nav-accordion">
            <!---<li class="mt">
                <a href="<?= BASE_URL . "ElektronskiIndeks" ?>">
                    <span>Elektronski Indeks</span>
                </a>
            </li>
            <li class="mt">
                <a href="<?= BASE_URL . "PregledIzpitovStudent" ?>">
                    <span>Pregled Izpitov Študent</span>
                </a>
            </li>--->
            <li class="mt">

                <a href="<?= BASE_URL . "izpitniRok/student" ?>">
                    <span>Prijava na izpit</span>
                <a href="<?= BASE_URL . "kartotecniListS" ?>">
                    <span>Kartotečni list</span>
                </a>
            </li>
            <li class="mt">
                <a href="<?= BASE_URL . "vpisNasledniLetnik" ?>">
                    <span>Vpis v naslednji letnik</span>
                </a>
            </li>
            <li class="mt">
                <a href="<?= BASE_URL . "tiskajVpisniList" ?>">
                    <span>Natisni vpisni list</span>
                </a>
            </li>
        </ul>
    </div>
</aside>