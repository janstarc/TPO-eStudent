<header class="header black-bg">
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
    </div>
    <a href="<?= BASE_URL ?>" class="logo">
        <b>eŠtudent</b>
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
            echo " | Logout (".User::getNameAndSurname().")";
            ?>
        </b>
    </a>
</header>

<aside>
    <div id="sidebar" class="nav-collapse " style="overflow-y: auto;">
        <ul class="sidebar-menu" id="nav-accordion">
            <!--<li class="mt">
                <a href="<?= BASE_URL . "PregledIzpitovProfesor" ?>">
                    <span>Pregled Izpitov Profesor</span>
                </a>
            </li> ---->
            <li class="mt">
                <a href="<?= BASE_URL . "OsebniPodatkiStudenta" ?>">
                    <span>Osebni Podatki Študenta</span>
                </a>
            </li>
            <!---
            <li class="mt">
                <a href="<?= BASE_URL . "VnosIzpitov" ?>">
                    <span>Vnos Izpitov</span>
                </a>
            </li>
            --->
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
                <a href="<?= BASE_URL . "izpitniRok/chooseStudLeto" ?>">
                    <span>Izpitni Rok</span>
                </a>
            </li>
            <li class="mt">
                <a href="<?= BASE_URL . "kartotecniListP" ?>">
                    <span>Kartotečni list</span>
                </a>
            </li>
        </ul>
    </div>
</aside>