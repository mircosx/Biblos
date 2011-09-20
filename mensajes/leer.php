<?php
session_start();
include "../php/funciones/mini.php";
include "../php /funciones/datos.php";
controlSesion();
conexion();

$desde=trim($_POST['desde']);
$mensaje=trim($_POST['mensaje']);

$query="UPDATE mensajes SET 
    leido=1 
    where desde='".$desde."' and mensaje='".$mensaje."'";
$result=mysql_query($query);

echo "desde:$desde<br>";
echo "mensaje:$mensaje<br>";
echo mysql_error();

header('Location: mp.php');
?>
