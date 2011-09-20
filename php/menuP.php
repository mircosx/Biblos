<?php
session_start();
include "funciones/mini.php";
controlSesion();
conexion();

$menu=$_GET['menu'];
$_SESSION['menu']=$menu;

?>
<SCRIPT LANGUAGE="javascript"> 
    window.opener.location.reload();
    self.close();    
</SCRIPT>

