<?php
session_start();
include "../php/funciones/mini.php";
include "../php /funciones/datos.php";
controlSesion();
conexion();

$desde=trim($_POST['desde']);
$para=trim($_POST['para']);
$mensaje=trim($_POST['mensaje']);

$query="INSERT INTO mensajes 
    (desde,para,mensaje)
    VALUES
    ('$desde', '$para', '$mensaje')";
$result=mysql_query($query);

header('Location: mp.php');
?>
