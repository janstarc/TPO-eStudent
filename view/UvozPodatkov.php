<!DOCTYPE html>

<html lang="en">
<head>
    <?php include("view/includes/head.php"); ?>
</head>
<body>
<section id="container">
    <?php include("view/includes/menu-links-admin.php"); ?>
    <section id="main-content">
        <section class="wrapper">
            <br>
            <h3>Uvoz sprejetih študentov prvega letnika</h3>
            <h5>Uvoz za študijsko leto: 2017/18</h5>
            <br>
            <form action="<?= BASE_URL . "UvozPodatkov/parse" ?>" method="post" enctype="multipart/form-data">
                Izberi datoteko:
                <input type="file" name="fileToUpload" id="fileToUpload">
                <input type="submit" value="Naloži datoteko" name="submit">
            </form>
        </section>
    </section>
</section>
</body>
</html>



