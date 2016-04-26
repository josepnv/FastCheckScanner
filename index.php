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
        
        /*
         SELECT glpi_computers.name as NombrePC, glpi_computers.serial as NumeroSerie, glpi_items_devicememories.size as TamanhoRAM
FROM glpi_computers, glpi_items_devicememories
WHERE glpi_computers.id = glpi_items_devicememories.items_id AND
glpi_items_devicememories.items_id = '812'
group by TamanhoRAM
         */
        
        $sql = "SELECT name, serial, date_mod From glpi_computers where serial = 'CZC44833NS' ";
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
