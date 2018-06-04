<!DOCTYPE html>

<html lang="en">
    <head>
        <?php include("view/includes/head.php"); ?>
    </head>
    <body>
        <section id="container">
            <?php if (User::isLoggedInAsAdmin()) include("view/includes/menu-links-admin.php");
            else if (User::isLoggedInAsProfessor()) include("view/includes/menu-links-professor.php");
            else if (User::isLoggedInAsStudent()) include("view/includes/menu-links-student.php");
            else if (User::isLoggedInAsStudentOfficer()) include("view/includes/menu-links-student-officer.php");
            else if (User::isLoggedInAsCandidate()) include("view/includes/menu-links-kandidat.php"); ?>

            <section id="main-content">
                <section class="wrapper">
                    <?php if(isset($status)): ?>
                        <div class="alert alert-<?= ($status === "Failure") ? "danger" : (($status === "Success") ? "success" : "info") ?> alert-dismissible" role="alert">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?= $message ?>
                        </div>
                    <?php endif; ?>
                </section>
            </section>
        </section>
    </body>
</html>