<html>
    <head>
        <meta charset="UTF-8">
        <title>FastCheckScanner</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link data-require="bootstrap-css@3.1.1" data-semver="3.1.1" rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" />
        <script data-require="bootstrap@3.1.1" data-semver="3.1.1" src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
        <script src="http://code.jquery.com/jquery.js"></script>
        
    </head>
    <body>
       <style>
            .row2{
            border-color: skyblue;
            border-style: outset; 
            border-width: 4px;
            }
         </style>
         <div id="content">
            <?php
            include('controlador.php'); //y ahora mostramos la pagina llamada
            ?>
        </div>
        <div class="container">
            <?php
            //conexion con glpi real
            //include '../glpi/config/config_db.php';
            
            include 'config.php';
            
            //funciones
            function estado_averia($op){
                switch ($op){
                            case 1:
                                echo "<h4> Sin Asignar </h4>";
                                break;
                            case 2:
                                echo "<h4> Asignada </h4>";
                                break;
                            case 3:
                                echo "<h4> Planificada </h4>";
                                break;
                            case 4:
                                echo "<h4> En Espera </h4>";
                                break;
                            case 5:
                                echo "<h4> Resuelta </h4>";
                                break;
                            case 6:
                                echo "<h4> Cerrada!!!!! </h4>";
                                break;
                            default :
                                echo "<h5> Sin estado </h5>";
                        }
            }

            $codigo = $_GET['code'];

            $sqlram = <<<SQL
        SELECT ram.size 
            FROM glpi_items_devicememories ram 
            JOIN glpi_computers ON ram.items_id = glpi_computers.id
            WHERE glpi_computers.otherserial = $codigo
SQL;
            $sql = <<<SQL
        SELECT glpi_computers.name, glpi_computers.serial, glpi_computers.otherserial,glpi_locations.completename, glpi_computers.date_mod
            FROM glpi_computers
            LEFT JOIN glpi_locations ON glpi_computers.locations_id = glpi_locations.id
            LEFT JOIN glpi_computermodels ON glpi_computers.computermodels_id = glpi_computermodels.id
            WHERE otherserial = $codigo
SQL;
            $sqlinc = <<<SQL
        SELECT glpi_locations.completename, glpi_computers.name as pc, glpi_computers.otherserial, glpi_tickets.date, glpi_tickets.name as texto, glpi_tickets.content as problema, glpi_tickets.status as estado
            FROM glpi_computers
            LEFT JOIN glpi_locations ON glpi_computers.locations_id = glpi_locations.id
            LEFT JOIN glpi_computermodels ON glpi_computers.computermodels_id = glpi_computermodels.id
            LEFT JOIN glpi_items_tickets ON glpi_computers.id = glpi_items_tickets.items_id
            LEFT JOIN glpi_tickets ON glpi_tickets.id = glpi_items_tickets.tickets_id
            WHERE 1 
            ORDER BY glpi_tickets.date DESC 
            LIMIT 10
SQL;
            $sqlpcinc = <<<SQL
        SELECT glpi_tickets.date as fecha, glpi_tickets.name as texto, glpi_tickets.content as problema, glpi_tickets.status as estado
            FROM glpi_computers
            LEFT JOIN glpi_locations ON glpi_computers.locations_id = glpi_locations.id
            LEFT JOIN glpi_computermodels ON glpi_computers.computermodels_id = glpi_computermodels.id
            LEFT JOIN glpi_items_tickets ON glpi_computers.id = glpi_items_tickets.items_id
            LEFT JOIN glpi_tickets ON glpi_tickets.id = glpi_items_tickets.tickets_id
            WHERE glpi_computers.otherserial = $codigo
SQL;

            if (empty($codigo)) {
                echo "<h1>Ultimas incidencias</h1>";
                //if ($stmt = $con->prepare($sqlinc)) {
                //    $stmt->bind_result($completename, $name, $otherserial, $date, $texto);
                $result = $conexion->query($sqlinc);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()){
                   // while ($stmt->fetch()) {
                        echo <<< EOF
                        <div class='row'>
                        <div class='col-md-3'> 
EOF;
                        echo "<h3 class='bg-primary'>" .$row['completename']. "</h3>";
                        //echo "<h2 class=\"bg-primary\">&nbsp;" .$completename. "</h2>";
                        echo "<h3 class='bg-success'>PC:" .$row['pc']. "</h3>";
                        echo "<h3 class='bg-info'>Serial:" .$row['otherserial']. "</h3>";
                        echo <<< EOF
                        </div>
                        <div class='col-md-3'>
EOF;
                        
                         echo "<h5>Fecha:" .$row['date']. "</h5>";
                         estado_averia($row['estado']);
                        echo "<h5>Incidencia:" .$row['texto']."</h5>";
                        echo <<< EOF
                        </div>
EOF;
                        echo "<div class='col-md-4'>";
                        echo "<h5>" .$row['problema']. "</h5>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "error consulta";
                    die('Imposible preparar la consulta. ' . $conexion->error);
                }
                $conexion->close();
            } else {
                if ($stmt = $conexion->prepare($sql)) {
                    $stmt->bind_param('s', $codigo);
                    if (!$stmt->execute()) {
                        die('Error de ejecución de la consulta. ' . $conexion->error);
                    }

                    $stmt->bind_result($name, $serial, $otherserial, $completename, $date_mod);
                    while ($stmt->fetch()) {
                        echo "<div class='row'>";
                        echo "<div class='col-md-3'> <h2 class=\"bg-primary\">&nbsp;" . $name . "</h2></div>";
                        echo "<div class='col-md-4'>";
                        echo "<h4>Serial:" . $serial . "</h4>";
                        echo "<h4>Código:" . $otherserial . "</h4>";
                        echo "<h4>Aula:" . $completename . "</h4>";
                        echo "<div class='col-md-4'>";
                        echo "<h5>Fecha_mod:" . $date_mod . "</h4>";
                        echo "</div>";
                    }
                } else {
                    die('Imposible preparar la consulta. ' . $conexion->error);
                }
                $stmt->close();
                $count = 0;

                if ($stmt = $conexion->prepare($sqlram)) {
                    $stmt->bind_param('s', $codigo);
                    if (!$stmt->execute()) {
                        die('Error de ejecución de la consulta. ' . $conexion->error);
                    }

                    $stmt->bind_result($size);
                    while ($stmt->fetch()) {
                        $count = $count + 1;
                        echo "<div class='col-md-4'>";
                        echo "<h4>Ram slot " . $count . "</h4>";
                        echo "<h4>" . $size . "</h4>";
                        echo "</div>";
                    }
                } else {
                    die('Imposible preparar la consulta. ' . $conexion->error);
                    echo "<div class='col-md-4'>Ram:</div>";
                    echo "<div class='col-md-4'>No tiene RAM</div>";
                }
                echo "</div>";
                echo "</div>";
                $stmt->close();
                
                $count = 0;

                $result = $conexion->query($sqlpcinc);
                if ($result->num_rows > 0) {
                    echo "<h2> Incidencias</H2>";
                    while ($row = $result->fetch_assoc()){
                        if($row['fecha']=="" && $row['texto']=="" && $row['estado']=="" && $row['problema']==""){
                           echo "<h4>No se han encontrado incidencias de este equipo</H4>"; 
                        }else{
                    echo <<< EOF
                        <div class='row2'>
                        <div class='col-md-4'> 
EOF;
                    echo "<h5>Fecha:" .$row['fecha']. "</h5>";
                    estado_averia($row['estado']);
                        echo "<h5>Incidencia:" .$row['texto']."</h5>";

                        echo "</div>";
                        echo "<div class='col-md-4'>";
                        echo "<h5>" .$row['problema']. "</h5>";
                        echo "</div>";
                        echo "</div>";
                        }

                        }
                    }
                
                $stmt->close();
            }
            ?>
        </div>
    </body>
</html>
