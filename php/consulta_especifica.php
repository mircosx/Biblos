<?php
session_start();
include "funciones.php";
controlSesion();
conexion();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Biblos - <?php echo $_SESSION['usuario']; ?></title>
        <?php eligeplantilla(); ?>
        <script type='text/javascript'> 
            window.onload=esconde_div;
        </script>
    </head>
    <body>
        <div id="menu">
            <?php include "menucss.php"; ?>
        </div> 
        <?php

        if (isset($_POST['filtracion'])) {
            $filtracion = trim($_POST['filtracion']);
            $_SESSION['filtracion'] = trim($_POST['filtracion']);
        }
        else
            $filtracion = $_SESSION['filtracion'];

        if (isset($_POST['quebuscas'])) {
            $quebuscas = trim($_POST['quebuscas']);
            $_SESSION['quebuscas'] = trim($_POST['quebuscas']);
        }
        else
            $quebuscas = $_SESSION['quebuscas'];

        switch ($filtracion) {
            case 1:
                $_SESSION['filtro']="autor";
                layoutFormLibro($filtracion,'#','sinboton');
                break;
            case 2:
                $_SESSION['filtro']="titulo";
                layoutFormLibro($filtracion,'#','sinboton');
                break;
            case 3:
                $_SESSION['filtro']="categoria";
                layoutFormLibro($filtracion,'#','sinboton');
                break;
        }
        ?>

        <div class="filtros">
            <input type="radio" name="visualizacion" value="Filtrar" onClick="grafica_filtro('block');" />Campos<br />
            <input type="radio" name="visualizacion" value="Listado general" onClick="window.location='consulta_general.php'" />Consulta general
        </div>
        <div id="oculto">
            <?php include "consulta_criterios.php" ?>
        </div>

        <div id="oculto2"></div>

        <h1>Consulta filtrada por <?php echo $_SESSION['filtro'];?></h1>
        
        <div id="pie">
            <?php include "pie_pagina.php"; ?>
        </div>
    </body>
</html>