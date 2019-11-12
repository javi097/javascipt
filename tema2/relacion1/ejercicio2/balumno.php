<?php

session_start();

//Hacemos autoload de las clases
spl_autoload_register(
    function ($nombre) {
        require "./class/". $nombre .".php"; //Cuando llamo a una clase, automaticament ebusca el nombre de la clase .php
    }
);
$conex=new Conexion();
$llave=$conex->getConector();
$alumno=new Alumnos($llave);
$id=$_POST['id'];
$alumno->setIdAl($id);
$alumno->delete();
$_SESSION['mensaje']="Alumno borrado correctamente.";
header('Location:alumnos.php');