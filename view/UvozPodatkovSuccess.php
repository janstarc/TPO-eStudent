<?php
?>

<html>
    <h4>Pregled vseh študentov v bazi</h4>
    <table style="width:80%">
        <tr>
            <th>Ime</th>
            <th>Priimek</th>
            <th>Email</th>
            <th>Uporabniško ime</th>
            <th>Vpisna</th>
            <th>ID Program</th>
            <th>Naziv program</th>
            <th>Password</th>
        </tr>
        <?php
            foreach ($result as $key => $value){
                echo "<tr>".
                        "<td>".$value['ime']."</td>".
                        "<td>".$value['priimek']."</td>".
                        "<td>".$value['email']."</td>".
                        "<td>".$value['uporabnisko_ime']."</td>".
                        "<td>".$value['vpisna_stevilka']."</td>".
                        "<td>".$value['id_program']."</td>".
                        "<td>".$value['naziv_program']."</td>".
                        "<td> Generated </td>".
                    "</tr>";
            }
        ?>
    </table>

    <form action="<?= BASE_URL ?>" method="GET">
        <button type="submit">OK</button>
    </form>
</html>
