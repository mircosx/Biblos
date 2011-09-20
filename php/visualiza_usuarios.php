<?php
session_start();
include "funciones.php";
controlSesion();
conexion();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Biblos  - <?php echo $_SESSION['usuario']; ?></title>
        <?php eligeplantilla(); ?>
    </head>
    <body>

        <div id="menu">
            <?php include "menucss.php"; ?>
        </div>       

        <h1>Usuarios registrados en Biblos</h1>
        <?php
            layoutFormUsuario('#', 'sinboton');
        ?>
        <div id="pie">
            <?php include "pie_pagina.php"; ?>
        </div>
    </body>
</html>