<!DOCTYPE html>

<?php

    session_start();

    //Hacemos autoload de las clases
    spl_autoload_register(
        function ($nombre) {
            require "./class/". $nombre .".php"; //Cuando llamo a una clase, automaticament ebusca el nombre de la clase .php
        }
    );

    function error($texto){
        $_SESSION['error']=$texto;
        header('Location:Calumno.php');
        die();
    }

    function crearAlumno($n,$a,$c){
        $conexion=new Conexion();
        $miLlave=$conexion->getConector();
        $alumno=new Alumnos($miLlave,$n,$a,$c);
        if ($alumno->existeMail()) {
            error("Ese mail ya está registrado!!!!");
        }

        $alumno->create();
        $_SESSION['mensaje']='Alumno creado correctamente';
        header('Location: alumnos.php');




    }

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

<body>
    <div class='container mt-5'>
        <h3 class="text-center mt-4">Crud Alumnos</h3>
    <div class="container mt-3">
    <?php
        if (isset($_POST['enviar'])) {
            //Procesamos los datos
            $nombre=ucwords(trim($_POST['nombre']));
            $apellidos=ucwords(trim($_POST['apellidos']));
            $correo=(trim($_POST['email']));
            if (strlen($nombre)==0 || strlen($apellidos)==0) {
                error("Error. Los campos deben contener algún carácter!");
            }
            crearAlumno($nombre,$apellidos,$correo);
        }else{ 
    ?>
        <?php
            if (isset($_SESSION['error'])) {
                echo "<p class='mt-3 mb-3 text-danger'>";
                echo $_SESSION['error'];
                echo "</p>";
                unset($_SESSION['error']);
            }
        ?>
        <form name="as" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="form-group">
                <label for="nom">Nombre</label>
                <input type="text" class="form-control" id="nom" aria-describedby="emailHelp" placeholder="Tu Nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="ape">Apellidos</label>
                <input type="text" class="form-control" id="ape" placeholder="Tus Apellidos" name="apellidos" required>
            </div>
            <div class="form-group">
                <label for="email">Correo</label>
                <input type="email" class="form-control" id="email" placeholder="Correo electrónico" name="email" required>
            </div>
            <input type="submit" class="btn btn-primary" name="enviar" value="Crear">&nbsp;
            <input type="reset" class="btn btn-warning" value="Limpiar">&nbsp;
            <a href="alumnos.php" class="btn btn-info">Volver</a>
        </form>
    </div>
    <?php
        }
    ?>
</body>
</html>