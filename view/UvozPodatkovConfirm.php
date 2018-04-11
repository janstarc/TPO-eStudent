<?php
    var_dump($mainArray);
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
</html>
