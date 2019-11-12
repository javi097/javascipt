<!DOCTYPE html>

<?php

session_start();

//Hacemos autoload de las clases
spl_autoload_register(
    function ($nombre) {
        require "./class/". $nombre .".php"; //Cuando llamo a una clase, automaticament ebusca el nombre de la clase .php
    }
);

$conexion = new Conexion();
$miLlave = $conexion->getConector();
$alumnos = new Alumnos($miLlave); //Le paso solo el CONECTOR
$todosLosAlumnnos = $alumnos->read();
?>

<html lang='en'>

<head>
    <title>Pagina</title>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' integrity='sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T' crossorigin='anonymous'>
</head>

<body style='background-color:aqua'>
    <div class='container mt-5'>
    <div class="container mt-3">
            <a href="Calumno.php" class="bnt btn-success mb-3">Nuevo Alumno</a>
        </div>
    <?php
            if (isset($_SESSION['mensaje'])) {
                echo "<p class='mt-3 mb-3 text-center text-success'>";
                echo $_SESSION['mensaje'];
                echo "</p>";
                unset($_SESSION['mensaje']);
            }
        ?>
        <table class="table table-dark">
            <thead>
                <tr>
                    <th scope="col">ID Alumno</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Mail</th>
                    <th scope="col">Fecha Creacion</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($todosLosAlumnnos as $alumnos) {
                    echo "<tr>
                    <th scope='row'>{$alumnos->idAl}</th>
                    <td>{$alumnos->apeAl}</td>
                    <td>{$alumnos->nomAl}</td>
                    <td>{$alumnos->mail}</td>
                    <td>{$alumnos->created_at}</td>
                    <td>
                    <form name='as' action='balumno.php' method='post' style='display:inline'>
                    <input type='hidden' name='id' value='{$alumnos->idAl}'>
                    <a href='ealumnos.php?id={$alumnos->idAl}' class='btn btn-info'>Editar</a>&nbsp;
                    <input type='submit' value='Borrar' class='btn btn-danger'>
                    </form>
                    </td>
                </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>