<?php

session_start();

require_once("controller/LoginController.php");
require_once("controller/AdminController.php");
require_once("controller/StudentOfficerController.php");
require_once("controller/ProfessorController.php");
require_once("controller/StudentController.php");
require_once("controller/KandidatController.php");
require_once("controller/SifrantController.php");
require_once("model/User.php");

define("APP_NAME", "STUDIS");
define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");
define("PROJECT_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php"));
define("IMAGES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/images/");
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/css/");
define("JS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/js/");
define("DATATABLES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/dataTables/");
define("JSHINT_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/JSHint/dist/");

define("CURRENT_YEAR", "2017/18");

$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";
// ROUTER: defines mapping between URLS and controllers
$urls = [
    "/^$/" => function ($method) {
        if (User::isLoggedIn()){
            if ($method == "GET") LoginController::dashboardForm();
            else ViewHelper::error405();
        }else{
            if ($method == "GET") ViewHelper::redirect(BASE_URL . "login");
            else ViewHelper::error405();
        }
    }, "/^login$/" => function ($method) {
        if ($method == "POST") LoginController::login();
        else if ($method == "GET") LoginController::loginForm();
        else ViewHelper::error405();
    }, "/^logout$/" => function ($method) {
        if ($method == "GET") LoginController::logout();
        else ViewHelper::error405();
    }, "/^forgottenPassword$/" => function ($method) {
        if ($method == "POST") LoginController::forgottenPassword();
        else if ($method == "GET") LoginController::forgottenPasswordForm();
        else ViewHelper::error405();
    }, "/^resetPassword$/" => function ($method) {
        if ($method == "POST") LoginController::resetPassword();
        else if ($method == "GET") LoginController::resetPasswordForm();
        else ViewHelper::error405();
    },
    
    "/^vpis$/" => function ($method) {
        if ($method == "GET") KandidatController::vpisForm();
        else if ($method == "POST") KandidatController::vpis();
        else ViewHelper::error405();
    }, "/^vpisNasledniLetnik$/" => function ($method) {
        if ($method == "GET") StudentController::vpisForm();
        else if ($method == "POST") StudentController::vpis();
        else ViewHelper::error405();
    }, "/^vpis2L$/" => function ($method) {
        if ($method == "GET") StudentController::vpis2LForm();
        else if ($method == "POST") StudentController::vpis2L();
        else ViewHelper::error405();
    }, "/^vpis3L1$/" => function ($method) {
        if ($method == "GET") StudentController::vpis3L1Form();
        else if ($method == "POST") StudentController::vpis3L1();
        else ViewHelper::error405();
    }, "/^vpis3L2$/" => function ($method) {
        if ($method == "GET") StudentController::vpis3L2Form();
        else if ($method == "POST") StudentController::vpis3L2();
        else ViewHelper::error405();
    }, "/^kandidati$/" => function ($method) {
        if ($method == "GET") StudentOfficerController::kandidatiList();
        else ViewHelper::error405();
    }, "/^kandidati\/(\d+)$/" => function ($method, $id) {
        if ($method == "GET") StudentOfficerController::kandidatPreglejVpisForm($id);
        else if ($method == "POST") StudentOfficerController::kandidatiPotrdiVpisForm($id);
        else ViewHelper::error405();
    }, "/^kandidatiZaVisjiLetnik$/" => function ($method) {
        if ($method == "GET") StudentOfficerController::kandidatiZaVisjiLetnikList();
        else ViewHelper::error405();
    }, "/^kandidatiZaVisjiLetnik\/(\d+)$/" => function ($method, $id) {
        if ($method == "GET") StudentOfficerController::studentPreglejVpisForm($id);
        else if ($method == "POST") StudentOfficerController::studentPotrdiVpisForm($id);
        else ViewHelper::error405();
    }, 
    
    "/^vpisaniStudenti$/" => function ($method) {
        if ($method == "GET") StudentOfficerController::vpisaniStudentiList();
        else ViewHelper::error405();
    },"/^studenti\/(\d+)$/" => function ($method, $id) {
        if ($method == "GET") StudentOfficerController::studentVpisPreglejForm($id);
        //else if ($method == "POST") StudentOfficerController::kandidatiPotrdiVpisForm($id);
        else ViewHelper::error405();
    },"/^studenti\/(\d+)\/exportPDF$/" => function($method,$id) {
        if ($method == "POST") StudentController::exportPDF($id);
    },
    "/^studenti\/(\d+)\/exportPDF6$/" => function($method,$id) {
        if ($method == "POST") StudentController::exportPDF6($id);
    },

    "/^ElektronskiIndeks$/" => function ($method) {
        if ($method == "GET") StudentController::elektronskiIndeksForm();
        else ViewHelper::error405();
    }, "/^PregledIzpitovStudent$/" => function ($method) {
        if ($method == "GET") StudentController::PregledIzpitovStudentForm();
        else ViewHelper::error405();
    }, "/^PregledIzpitovProfesor$/" => function ($method) {
        if ($method == "GET") ProfesorController::PregledIzpitovProfesorForm();
        else ViewHelper::error405();
    }, "/^VnosIzpitov$/" => function ($method) {
        if ($method == "GET") ProfesorController::VnosIzpitovForm();
        else ViewHelper::error405();
    }, "/^VnosOcen$/" => function ($method) {
        if ($method == "GET") ProfesorController::vnosOcenForm();
        //else if ($method == "POST") ProfesorController::vnosOcenPoStudentih();
        else ViewHelper::error405();
    }, "/^VnosOcenDve$/" => function ($method) {
        if ($method == "POST") ProfesorController::vnosOcenPoStudentih();
        //else if ($method == "POST")
        else ViewHelper::error405();
    }, "/^OsebniPodatkiStudenta$/" => function ($method) {
        if ($method == "GET") AdminController::pregledOsebnihPodatkovStudenta();
        else ViewHelper::error405();
    }, "/^OsebniPodatkiStudenta\/vpisnaSearch$/" => function ($method) {
        if ($method == "POST") AdminController::searchByVpisna();
        else ViewHelper::error405();
    }, "/^PodatkiIzvajalcev$/" => function ($method) {
        if ($method == "GET") AdminController::PregledPodatkovOIzvajalcih();
        else ViewHelper::error405();
    }, "/^PodatkiIzvajalcev\/subjectSearch$/" => function ($method) {
        if ($method == "POST") AdminController::searchBySubject();
        else ViewHelper::error405();
    }, "/^PodatkiIzvajalcev\/edit$/" => function ($method) {
        if ($method == "POST") AdminController::editIzvajalec();
        else ViewHelper::error405();
    },"/^PodatkiIzvajalcev\/editForm$/" => function ($method) {
        if ($method == "POST") AdminController::editFormIzvajalec();
        else ViewHelper::error405();
    },"/^PodatkiIzvajalcevAdd$/" => function ($method) {
        if ($method == "GET") AdminController::getFormIzvajalec();
        else ViewHelper::error405();
    },"/^PodatkiIzvajalcev\/dodaj$/" => function ($method) {
        if ($method == "POST") AdminController::addIzvajalec();
        else ViewHelper::error405();
    },

    "/^izpitniRok\/profesor$/" => function ($method) {
        if ($method == "GET") ProfesorController::izpitniRokAllForm();
        else ViewHelper::error405();
    }, "/^izpitniRok\/profesor\/add$/" => function ($method) {
        if ($method == "GET") ProfesorController::izpitniRokForm();
        else if ($method == "POST") ProfesorController::VnosIzpitnegaRoka();
        else ViewHelper::error405();
    }, "/^izpitniRok\/profesor\/edit\/(\d+)$/" => function ($method, $id) {
        if ($method == "GET") ProfesorController::izpitniRokEditForm($id);
        else if ($method == "POST") ProfesorController::SpremembaIzpitnegaRoka($id);
        else ViewHelper::error405();
    }, "/^izpitniRok\/profesor\/toogleActivated$/" => function ($method) {
        if ($method == "POST") ProfesorController::toggleizpitniRokActivated();
        else if ($method == "GET") ViewHelper::redirect(BASE_URL . "izpitniRok/profesor");
        else ViewHelper::error405();
    },

    "/^izpitniRok\/referent\/chooseProfesor$/" => function ($method) {
        if ($method == "GET") StudentOfficerController::chooseProfesor();
        else ViewHelper::error405();
    }, "/^izpitniRok\/referent\/chooseProfesor\/(\d+)$/" => function ($method, $id) {
        if ($method == "GET") StudentOfficerController::izpitniRokAllForm($id);
        else ViewHelper::error405();
    }, "/^izpitniRok\/referent\/chooseProfesor\/(\d+)\/add$/" => function ($method, $id) {
        if ($method == "GET") StudentOfficerController::izpitniRokForm($id);
        else if ($method == "POST") StudentOfficerController::VnosIzpitnegaRoka($id);
        else ViewHelper::error405();
    }, "/^izpitniRok\/referent\/chooseProfesor\/(\d+)\/edit\/(\d+)$/" => function ($method, $id1, $id2) {
        if ($method == "GET") StudentOfficerController::izpitniRokEditForm($id1, $id2);
        else if ($method == "POST") StudentOfficerController::SpremembaIzpitnegaRoka($id1, $id2);
        else ViewHelper::error405();
    }, "/^izpitniRok\/referent\/chooseProfesor\/(\d+)\/toogleActivated$/" => function ($method, $id) {
        if ($method == "POST") StudentOfficerController::toggleizpitniRokActivated($id);
        else if ($method == "GET") ViewHelper::redirect(BASE_URL . "izpitniRok/referent/chooseProfesor/" . $id);
        else ViewHelper::error405();
    },

    "/^izpitniRok\/student$/" => function ($method) {
        if ($method == "GET") StudentController::izpitniRokForm();
        else ViewHelper::error405();
    },

    "/^dodajPredmet$/" => function ($method) {
        if ($method == "POST") AdminController::addInPredmetnik();
        else ViewHelper::error405();
    },"/^spremeniPredmetnik$/" => function ($method) {
        if ($method == "POST") AdminController::spremeniPredmetnik();
        else ViewHelper::error405();
    }, "/^predmet$/" => function ($method) {
        if ($method == "POST") AdminController::Predmet();
        else ViewHelper::error405();
    },"/^Vzdrzevanjepredmetnika$/" => function ($method) {
        if ($method == "GET") AdminController::VzdrzevanjePredmetnika();
        else ViewHelper::error405();
    }, "/^dodajPredmet\/toogleActivated$/" => function ($method) {
        if ($method == "POST") AdminController::toogleActivated();
        else ViewHelper::error405();
    },"/^DelPredmetnikaAdd$/" => function ($method) {
        if ($method == "GET") SifrantController::getAddDelPredmetnika();
        else ViewHelper::error405();
    },"/^DelPredmetnikaAll$/" => function ($method) {
        if ($method == "GET") SifrantController::getDelPredmetnika();
        else ViewHelper::error405();
    },"/^DelPredmetnikaAdd\/dodaj$/" => function ($method) {
        if ($method == "POST") SifrantController::addDelPredmetnika();
        else ViewHelper::error405();
    },"/^DelPredmetnikaAll\/editForm$/" => function ($method) {
        if ($method == "POST") SifrantController::editFormDelPredmetnika();
        else ViewHelper::error405();
    },"/^DelPredmetnikaAll\/edit$/" => function ($method) {
        if ($method == "POST") SifrantController::editDelPredmetnika();
        else ViewHelper::error405();
    }, "/^DelPredmetnikaAll\/toogleActivated$/" => function ($method) {
        if ($method == "POST") SifrantController::toogleActivatedDelPredmetnika();
        else ViewHelper::error405();
    },

    "/^UvozPodatkov$/" => function($method){
        if ($method == "GET") AdminController::uvozPodatkov();
        else ViewHelper::error405();
    }, "/^UvozPodatkov\/parse$/" => function($method) {
        if ($method == "POST") AdminController::parseInput();
        else ViewHelper::error405();
    }, "/^UvozPodatkov\/insert$/" => function($method) {
        if ($method == "POST") AdminController::insertParsedData();
        else ViewHelper::error405();
    },

    "/^zetoni$/" => function ($method) {
        if ($method == "GET") StudentOfficerController::zetonForm1();
        else ViewHelper::error405();
    }, "/^zetoni\/(\d+)$/" => function ($method, $id) {
        if ($method == "GET") StudentOfficerController::ZetonForm2($id);
        else ViewHelper::error405();
    }, "/^zetoni\/prikaz\/(\d+)$/" => function ($method, $id) {
        if ($method == "GET") StudentOfficerController::ZetonForm3($id);
        else ViewHelper::error405();
    }, "/^zetoni\/toogleActivated$/" => function ($method) {
        if ($method == "POST") StudentOfficerController::toogleActivated();
        else ViewHelper::error405();
    }, "/^zetoni\/uredi\/(\d+)$/" => function ($method, $id) {
        if ($method == "GET") StudentOfficerController::ZetonForm4($id);
        else ViewHelper::error405();
    }, "/^zetoni\/spremeni$/" => function ($method) {
        if ($method == "POST") StudentOfficerController::ZetonForm5();
        else ViewHelper::error405();
    }, "/^zetoni\/add$/" => function ($method) {
        if ($method == "POST") StudentOfficerController::ZetonForm6();
        else ViewHelper::error405();
    }, "/^zetoni\/renew$/" => function ($method) {
        if ($method == "POST") StudentOfficerController::ZetonForm7();
        else ViewHelper::error405();

    //vpisani v predmet - referent
    },"/^vpisPredmet$/" => function($method) {
        if ($method == "GET") StudentOfficerController::VpisaniForm1();
        else ViewHelper::error405();
    }, "/^vpisPredmet\/leto\/(\d+)$/" => function ($method, $id) {
        if ($method == "GET") StudentOfficerController::VpisaniForm2($id);
        else ViewHelper::error405();
    }, "/^vpisPredmet\/predmet\/(\d+)\/(\d+)$/" => function ($method, $id, $id2) {
        if ($method == "GET") StudentOfficerController::VpisaniForm3($id, $id2);
        else ViewHelper::error405();
    },"/^VpisaniPrikaz\/exportCSV$/" => function($method) {
        if ($method == "POST") StudentOfficerController::exportCSV();
        else ViewHelper::error405();
    }, "/^VpisaniPrikaz\/exportPDF$/" => function($method) {
        if ($method == "POST") StudentOfficerController::exportPDF();
        else ViewHelper::error405();
    }
//vpisani v predmet - profesor
    ,"/^vpisPredmetP$/" => function($method) {
        if ($method == "GET") ProfesorController::VpisaniForm1();
        else ViewHelper::error405();
    }, "/^vpisPredmetP\/leto\/(\d+)$/" => function ($method, $id) {
        if ($method == "GET") ProfesorController::VpisaniForm2($id);
        else ViewHelper::error405();
    }, "/^vpisPredmetP\/predmet\/(\d+)\/(\d+)$/" => function ($method, $id, $id2) {
        if ($method == "GET") ProfesorController::VpisaniForm3($id, $id2);
        else ViewHelper::error405();
    },"/^VpisaniPrikazP\/exportCSV$/" => function($method) {
        if ($method == "POST") ProfesorController::exportCSV();
        else ViewHelper::error405();
    }, "/^VpisaniPrikazP\/exportPDF$/" => function($method) {
        if ($method == "POST") ProfesorController::exportPDF();
        else ViewHelper::error405();
    },

    //stevilo vpisanih steviloVpisanih
    "/^steviloVpisanih$/" => function($method) {
        if ($method == "GET") StudentOfficerController::SteviloVpisanihForm1();
        else ViewHelper::error405();
    }, "/^steviloVpisanih\/params\/(\d+)$/" => function ($method, $id) {
        if ($method == "GET") StudentOfficerController::SteviloVpisanihForm2($id);
        else ViewHelper::error405();
    }, "/^steviloVpisanih\/params\/(\d+)\/(\d+)$/" => function ($method, $id1, $id2) {
        if ($method == "GET") StudentOfficerController::SteviloVpisanihForm3($id1, $id2);
        else ViewHelper::error405();
    }, "/^steviloVpisanih\/params\/(\d+)\/(\d+)\/(\d+)$/" => function ($method, $id1, $id2,$id3) {
        if ($method == "GET") StudentOfficerController::SteviloVpisanihForm4($id1, $id2, $id3);
        else ViewHelper::error405();
    },"/^steviloVpisanih\/exportCSV$/" => function($method) {
        if ($method == "POST") StudentOfficerController::exportCSV2();
        else ViewHelper::error405();
    }, "/^steviloVpisanih\/exportPDF$/" => function($method) {
        if ($method == "POST") StudentOfficerController::exportPDF2();
        else ViewHelper::error405();
    },

    "/^zeton\/EMSOSearch$/" => function ($method) {
    if ($method == "POST") StudentOfficerController::searchByEMSO();
    else ViewHelper::error405();
    }, "/^Zetoni\/spremeni$/" => function ($method) {
        if ($method == "POST") StudentOfficerController::spremeni();
        else ViewHelper::error405();
    }, "/^zeton\/uredi$/" => function ($method) {
        if ($method == "POST") StudentOfficerController::uredi();
        else ViewHelper::error405();
    }, "/^zeton\/dodaj$/" => function ($method) {
        if ($method == "POST") StudentOfficerController::dodaj();
        else ViewHelper::error405();
    }, "/^zeton\/povprecje$/" => function($method) {
        if ($method == "POST") StudentOfficerController::povprecje();
        else ViewHelper::error405();
    },

    "/^OsebniPodatkiStudenta\/exportCSV$/" => function($method) {
        if ($method == "POST") AdminController::exportCSV();
        else ViewHelper::error405();
    }, "/^OsebniPodatkiStudenta\/exportPDF$/" => function($method) {
        if ($method == "POST") AdminController::exportPDF();
        else ViewHelper::error405();
    }, "/^VnosOceneProf$/" => function($method) {
        if($method == "GET") ProfesorController::vnosOcenProf();
        else ViewHelper::error405();
    },
    


    // SIFRANTI, add code above
    "/^DrzavaAdd$/" => function ($method) {
        if ($method == "GET") SifrantController::getAddDrzava();
        else ViewHelper::error405();
    },"/^DrzavaAll$/" => function ($method) {
        if ($method == "GET") SifrantController::getDrzava();
        else ViewHelper::error405();
    },"/^DrzavaAdd\/dodaj$/" => function ($method) {
        if ($method == "POST") SifrantController::addDrzava();
        else ViewHelper::error405();
    }, "/^DrzavaAll\/editForm$/" => function ($method) {
        if ($method == "POST") SifrantController::editFormDrzava();
        else ViewHelper::error405();
    }   ,"/^DrzavaAll\/edit$/" => function ($method) {
        if ($method == "POST") SifrantController::editDrzava();
        else ViewHelper::error405();
    }, "/^DrzavaAll\/toogleActivated$/" => function ($method) {
        if ($method == "POST") SifrantController::toogleActivatedDrzava();
        else ViewHelper::error405();
    },

    "/^LetnikAdd$/" => function ($method) {
        if ($method == "GET") SifrantController::getAddLetnik();
        else ViewHelper::error405();
    },"/^LetnikAll$/" => function ($method) {
        if ($method == "GET") SifrantController::getLetnik();
        else ViewHelper::error405();
    },"/^LetnikAdd\/dodaj$/" => function ($method) {
        if ($method == "POST") SifrantController::addLetnik();
        else ViewHelper::error405();
    }, "/^LetnikAll\/editForm$/" => function ($method) {
        if ($method == "POST") SifrantController::editFormLetnik();
        else ViewHelper::error405();
    }   ,"/^LetnikAll\/edit$/" => function ($method) {
        if ($method == "POST") SifrantController::editLetnik();
        else ViewHelper::error405();
    },

    "/^NacinStudijaAdd$/" => function ($method) {
        if ($method == "GET") SifrantController::getAddNacinStudija();
        else ViewHelper::error405();
    },"/^NacinStudijaAll$/" => function ($method) {
        if ($method == "GET") SifrantController::getNacinStudija();
        else ViewHelper::error405();
    },"/^NacinStudijaAdd\/dodaj$/" => function ($method) {
        if ($method == "POST") SifrantController::addNacinStudija();
        else ViewHelper::error405();
    },"/^NacinStudijaAll\/editForm$/" => function ($method) {
        if ($method == "POST") SifrantController::editFormNacinStudija();
        else ViewHelper::error405();
    }   ,"/^NacinStudijaAll\/edit$/" => function ($method) {
        if ($method == "POST") SifrantController::editNacinStudija();
        else ViewHelper::error405();
    }, "/^NacinStudijaAll\/toogleActivated$/" => function ($method) {
        if ($method == "POST") SifrantController::toogleActivatedNacinStudija();
        else ViewHelper::error405();
    },

    "/^ObcinaAdd$/" => function ($method) {
        if ($method == "GET") SifrantController::getAddObcina();
        else ViewHelper::error405();
    },"/^ObcinaAll$/" => function ($method) {
        if ($method == "GET") SifrantController::getObcina();
        else ViewHelper::error405();
    },"/^ObcinaAdd\/dodaj$/" => function ($method) {
        if ($method == "POST") SifrantController::addObcina();
        else ViewHelper::error405();
    },"/^ObcinaAll\/editForm$/" => function ($method) {
        if ($method == "POST") SifrantController::editFormObcina();
        else ViewHelper::error405();
    }   ,"/^ObcinaAll\/edit$/" => function ($method) {
        if ($method == "POST") SifrantController::editObcina();
        else ViewHelper::error405();
    }, "/^ObcinaAll\/toogleActivated$/" => function ($method) {
        if ($method == "POST") SifrantController::toogleActivatedObcina();
        else ViewHelper::error405();
    },

    "/^OblikaStudijaAdd$/" => function ($method) {
        if ($method == "GET") SifrantController::getAddOblikaStudija();
        else ViewHelper::error405();
    },"/^OblikaStudijaAll$/" => function ($method) {
        if ($method == "GET") SifrantController::getOblikaStudija();
        else ViewHelper::error405();
    },"/^OblikaStudijaAdd\/dodaj$/" => function ($method) {
        if ($method == "POST") SifrantController::addOblikaStudija();
        else ViewHelper::error405();
    },"/^OblikaStudijaAll\/editForm$/" => function ($method) {
        if ($method == "POST") SifrantController::editFormOblikaStudija();
        else ViewHelper::error405();
    }   ,"/^OblikaStudijaAll\/edit$/" => function ($method) {
        if ($method == "POST") SifrantController::editOblikaStudija();
        else ViewHelper::error405();
    }, "/^OblikaStudijaAll\/toogleActivated$/" => function ($method) {
        if ($method == "POST") SifrantController::toogleActivatedOblikaStudija();
        else ViewHelper::error405();
    },

    "/^PostaAdd$/" => function ($method) {
        if ($method == "GET") SifrantController::getAddPosta();
        else ViewHelper::error405();
    },"/^PostaAll$/" => function ($method) {
        if ($method == "GET") SifrantController::getPosta();
        else ViewHelper::error405();
    },"/^PostaAdd\/dodaj$/" => function ($method) {
        if ($method == "POST") SifrantController::addPosta();
        else ViewHelper::error405();
    },"/^PostaAll\/editForm$/" => function ($method) {
        if ($method == "POST") SifrantController::editFormPosta();
        else ViewHelper::error405();
    }   ,"/^PostaAll\/edit$/" => function ($method) {
        if ($method == "POST") SifrantController::editPosta();
        else ViewHelper::error405();
    }, "/^PostaAll\/toogleActivated$/" => function ($method) {
        if ($method == "POST") SifrantController::toogleActivatedPosta();
        else ViewHelper::error405();
    },

    "/^PredmetAdd$/" => function ($method) {
        if ($method == "GET") SifrantController::getAddPredmet();
        else ViewHelper::error405();
    },"/^PredmetAll$/" => function ($method) {
        if ($method == "GET") SifrantController::getPredmet();
        else ViewHelper::error405();
    },"/^PredmetAdd\/dodaj$/" => function ($method) {
        if ($method == "POST") SifrantController::addPredmet();
        else ViewHelper::error405();
    }, "/^PredmetAll\/editForm$/" => function ($method) {
        if ($method == "POST") SifrantController::editFormPredmet();
        else ViewHelper::error405();
    }   ,"/^PredmetAll\/edit$/" => function ($method) {
        if ($method == "POST") SifrantController::editPredmet();
        else ViewHelper::error405();
    },"/^PredmetAll\/toogleActivated$/" => function ($method) {
        if ($method == "POST") SifrantController::toogleActivatedPredmet();
        else ViewHelper::error405();
    },

    "/^StudijskoLetoAdd$/" => function ($method) {
        if ($method == "GET") SifrantController::getAddStudijskoLeto();
        else ViewHelper::error405();
    },"/^StudijskoLetoAll$/" => function ($method) {
        if ($method == "GET") SifrantController::getStudijskoLeto();
        else ViewHelper::error405();
    },"/^StudijskoLetoAdd\/dodaj$/" => function ($method) {
        if ($method == "POST") SifrantController::addStudijskoLeto();
        else ViewHelper::error405();
    }, "/^StudijskoLetoAll\/editForm$/" => function ($method) {
        if ($method == "POST") SifrantController::editFormStudijskoLeto();
        else ViewHelper::error405();
    }   ,"/^StudijskoLetoAll\/edit$/" => function ($method) {
        if ($method == "POST") SifrantController::editStudijskoLeto();
        else ViewHelper::error405();
    },

    "/^VrstaVpisaAdd$/" => function ($method) {
        if ($method == "GET") SifrantController::getAddVrstaVpisa();
        else ViewHelper::error405();
    },"/^VrstaVpisaAll$/" => function ($method) {
        if ($method == "GET") SifrantController::getVrstaVpisa();
        else ViewHelper::error405();
    },"/^VrstaVpisaAdd\/dodaj$/" => function ($method) {
        if ($method == "POST") SifrantController::addVrstaVpisa();
        else ViewHelper::error405();
    }, "/^VrstaVpisaAll\/editForm$/" => function ($method) {
        if ($method == "POST") SifrantController::editFormVrstaVpisa();
        else ViewHelper::error405();
    }   ,"/^VrstaVpisaAll\/edit$/" => function ($method) {
        if ($method == "POST") SifrantController::editVrstaVpisa();
        else ViewHelper::error405();
    },"/^VrstaVpisaAll\/toogleActivated$/" => function ($method) {
        if ($method == "POST") SifrantController::toogleActivatedVrstaVpisa();
        else ViewHelper::error405();
    }
    // add code above Sifranti
];

foreach ($urls as $pattern => $controller) {
    if (preg_match($pattern, $path, $params)) {
        try {
            $params[0] = $_SERVER["REQUEST_METHOD"];
            $controller(...$params);
        } catch (InvalidArgumentException $e) {
            //ViewHelper::error404();
            echo $e;
        } catch (Exception $e){
            echo $e;
        }
        exit();
    }
}

ViewHelper::error404();
/*"/^vpisVPredmet\/exportCSV$/" => function($method) {
        if ($method == "POST") StudentOfficerController::exportCSV();
        else ViewHelper::error405();
    },"/^vpisVPredmet\/exportPDF$/" => function($method) {
        if ($method == "POST") StudentOfficerController::exportPDF();
       else ViewHelper::error405();
    },"/^vpisVPRedmet$/" => function($method) {
        if ($method == "GET") StudentOfficerController::VpisaniForm1();
        else ViewHelper::error405();
    },"/^vpisVPredmet\/predmeti$/" => function($method) {
        if ($method == "POST") StudentOfficerController::vpisVPredmetPredmeti();
        else ViewHelper::error405();
    },"/^vpisVPredmet\/vpisani$/" => function($method) {
        if ($method == "POST") StudentOfficerController::vpisVPredmetVpisani();
        else ViewHelper::error405();
    },*/