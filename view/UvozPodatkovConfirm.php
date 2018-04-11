<?php

    $_SESSION['mainArray'] = $mainArray;
?>

<html>

    <table style="width:50%">
        <tr>
            <th>Ime</th>
            <th>Priimek</th>
            <th>Program</th>
            <th>Email</th>
            <th>Vpisna</th>
            <th>Username</th>
            <th>Password</th>
        </tr>
        <?php
            foreach ($mainArray as $key => $value){
                echo "<tr>".
                        "<td>".$value['ime']."</td>".
                        "<td>".$value['priimek']."</td>".
                        "<td>".$value['program']."</td>".
                        "<td>".$value['email']."</td>".
                        "<td>".$value['vpisna']."</td>".
                        "<td>".$value['username']."</td>".
                        "<td>".$value['password']."</td>".
                    "</tr>";
            }
        ?>
    </table>

    <form action="<?= BASE_URL . "UvozPodatkov" ?>" method="GET">
        <button type="submit">Nazaj</button>
    </form>

    <form action="<?= BASE_URL . "UvozPodatkov/submit" ?>" method="POST">
        <!--
        <input type="hidden" name="mainArray[]" value="<?= $mainArray ?>"/> -->
        <button type="submit">Potrdi vnos - INSERT</button>
    </form>
</html>
