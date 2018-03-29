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
            <div class="row">
                <div class="col-md-12">
                    <div class="content-panel">
                        <h2>Iskanje studenta</h2>
                        <br>
                        <form class="example">
                            <input type="text" placeholder="ISCI PO VPISNO STEVILKO..." name="search">
                            <button type="submit">Isci</button>
                        </form>
                        <br>
                        <br>
                        <p>
                            <form class="example2">
                                <input type="text" placeholder="ISCI PO PRIIMEK IN IME..." name="search">
                                <button type="submit">Isci</button>
                            </form>
                        </p>
                        <br>
                        <br>
                        <hr>
                        <h2>Prikaz studenta</h2>
                        <table id="table-izpitov" class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Podatek o studentu</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Vpisna stevilka</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Priimek in ime</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Naslov stalnega bivalisca</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Naslov za prejemanje pošte</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Telefonsko stevilko</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Naslov elektronske poste</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Studijsko leto</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Letnik</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Studijski program</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Vrsta vpisa</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Nacin studija</td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </section>
</section>
</body>
</html>