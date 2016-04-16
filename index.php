<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>FastCheckScanner</title>
        <link href="css/bootstrap.css" rel="stylesheet">
        <script src="js/bootstrap.min.js"></script>
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    </head>
    <body>
        <?php
        include 'config.php';
        
        $sql = "SELECT name, serial, date_mod From glpi_computers ";
        $result = $con->query($sql);
        
        if ($result->num_rows > 0) {
                // Salidad de informacion de cada fila
                while($row = $result->fetch_assoc()) {
                    echo "<div class='tabla'><div class='titulo'>Nombre PC:</div> <div class='titulo2'>" . $row["name"]. "</div>  <div class='otros'>Serial:</div> <div class='otros2'>" . $row["serial"]. "</div> <div class='otros'>Ultima fecha_mod:</div> <div class='otros2'>" . $row["date_mod"]. "</div></div> <br>";
                }
        } else {
                echo "0 results";
        }
        $con->close();
        ?>
        
    </body>
</html>
