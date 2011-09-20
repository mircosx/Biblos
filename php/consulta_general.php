<?php session_start(); include "funciones.php"; controlSesion(); conexion(); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Biblos - <?php echo $_SESSION['usuario'];?></title>
        <?php eligeplantilla(); ?>
        <script type='text/javascript'> 
            window.onload=esconde_div; 
        </script>
    </head>
    <body>
        
        <?php 
            include "menucss.php";
            layoutFormLibro('#', 'post', 'sinboton');
        ?>
        
        <div class="filtros">
            <input type="radio" name="visualizacion" value="Filtrar" onClick="grafica_filtro('block');" />Campos<br />
            <input type="radio" name="visualizacion" value="Listado general" onClick="esconde_filtros('none');" />Consulta general
        </div>

        <div id='oculto'>";
          <?php include "consulta_criterios.php"; ?>
        </div>

        <div id='oculto2'></div>
        
        <h1>Consulta general</h1>

        <div id="pie">
            <?php include "pie_pagina.php"; ?>
        </div>
    </body>
</html>