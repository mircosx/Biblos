<?php
include "funciones.php";
conexion();
$nombre=$_POST['nombre'];
$apellido1=$_POST['apellido1'];
$apellido1=$_POST['apellido1'];
$nacionalidad=$_POST['nacionalidad'];
$query="INSERT INTO autor
        (nombre, apellido1, apellido2,nacionalidad)
        VALUES
        ($nombre, $apellido1, $apellido2,$nacionalidad)";

$result=  mysql_query($query);




?>
