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
        if ($method == "GET") ProfesorController::VnosOcenForm();
        else ViewHelper::error405();
    }, "/^OsebniPodatkiStudenta$/" => function ($method) {
        if ($method == "GET") AdminController::pregledOsebnihPodatkovStudenta();
        else ViewHelper::error405();
    }, "/^OsebniPodatkiStudenta\/vpisnaSearch$/" => function ($method) {
        if ($method == "POST") AdminController::searchByVpisna();
        else ViewHelper::error405();

    },
    "/^PodatkiIzvajalcev$/" => function ($method) {
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
    }, "/^izpitniRok\/profesor\/edit$/" => function ($method) {
        if ($method == "POST") ProfesorController::izpitniRokEditForm();
        else ViewHelper::error405();
    }, "/^izpitniRok\/profesor\/edit2$/" => function ($method) {
        if ($method == "POST") ProfesorController::SpremembaIzpitnegaRoka();
        else ViewHelper::error405();
    }, "/^izpitniRok\/profesor\/toogleActivated$/" => function ($method) {
        if ($method == "POST") ProfesorController::toggleizpitniRokActivated();
        else ViewHelper::error405();
    }, "/^izpitniRok\/referent\/add$/" => function ($method) {
        if ($method == "GET") StudentOfficerController::izpitniRokForm();
        else ViewHelper::error405();
    },
    
    "/^dodajPredmet$/" => function ($method) {
        if ($method == "POST") AdminController::addInPredmetnik();
        else ViewHelper::error405();
    },"/^spremeniPredmetnik/" => function ($method) {
        if ($method == "POST") AdminController::spremeniPredmetnik();
        else ViewHelper::error405();
    }, "/^predmet$/" => function ($method) {
        if ($method == "POST") AdminController::Predmet();
        else ViewHelper::error405();
    },"/^Vzdrzevanjepredmetnika$/" => function ($method) {
        if ($method == "GET") AdminController::VzdrzevanjePredmetnika();
        else ViewHelper::error405();
    }, "/^dodajPredmet\/toogleActivated/" => function ($method) {
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
    },"/^zeton\/EMSOSearch$/" => function ($method) {
        if ($method == "POST") StudentOfficerController::searchByEMSO();
        else ViewHelper::error405();
    },"/^Zeton\/spremeni$/" => function ($method) {
        if ($method == "POST") StudentOfficerController::spremeni();
        else ViewHelper::error405();
    },"/^zeton\/uredi$/" => function ($method) {
        if ($method == "POST") StudentOfficerController::uredi();
        else ViewHelper::error405();
    },"/^zeton\/dodaj$/" => function ($method) {
        if ($method == "POST") StudentOfficerController::dodaj();
        else ViewHelper::error405();
    },"/^zeton$/" => function ($method) {
        if ($method == "GET") StudentOfficerController::zeton();
        else ViewHelper::error405();
    },"/^OsebniPodatkiStudenta\/exportCSV$/" => function($method) {
        if ($method == "POST") AdminController::exportCSV();
        else ViewHelper::error405();
    },"/^OsebniPodatkiStudenta\/exportPDF$/" => function($method) {
        if ($method == "POST") AdminController::exportPDF();
        else ViewHelper::error405();
    }
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
