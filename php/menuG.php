<?php
session_start();
include "funciones/mini.php";
include "funciones/datos.php";
include "funciones/grafica.php";

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
        $menu=$_SESSION['menu'];
        
        switch ($menu) {
            case "GEN"://general
                echo "<h1>Bienvenid@ a Biblos, tu biblioteca digital</h1>";
                break;
            
            case "GL1"://Gestion LIBROS: consulta
                echo "<h1>Consulta general</h1>";
                layoutFormLibro(0, '#', 'sinboton');
                break;
            case "GL2"://agregar
                echo "<h1>Insertar libro en el catalogo</h1>";
                layoutAgregaLibro();
                break;
            case "GL3"://modificar
                echo "<h1>Modifica libros del catalogo</h1>";
                layoutFormLibro(0, 'modificaLibroP.php', 'Modificar');
                break;
            case "GL4"://borrar
                echo "<h1>Borrar libros del catalogo</h1>";
                layoutFormLibro(0, 'borraLibroP.php', 'Borrar');
                break;
            
            case "GA1"://Gestion AUTORES: consulta
                echo "<h1>Consulta general</h1>";
                layoutFormAutor('#', 'sinboton');
                break;
            case "GA2"://agregar
                echo "<h1>Insertar autores en el catalogo</h1>";
                layoutAgregaAutor();
                break;
            case "GA3"://modificar
                echo "<h1>Modifica autores del catalogo</h1>";
                layoutFormAutor('modificaAutorP.php', 'Modificar');
                break;
            case "GA4"://borrar
                echo "<h1>Borrar autores del catalogo</h1>";
                layoutFormAutor('borraAutorP.php', 'Borrar');
                break;
            
            case "GA1"://Gestion EDITORIALES: consulta
                echo "<h1>Consulta general</h1>";
                layoutFormEditorial('#', 'sinboton');
                break;
            case "GA2"://agregar
                echo "<h1>Insertar editoriales en el catalogo</h1>";
                layoutAgregaEditorial();
                break;
            case "GA3"://modificar
                echo "<h1>Modifica editoriales del catalogo</h1>";
                layoutFormEditorial('modificaEditorialP.php', 'Modificar');
                break;
            case "GA4"://borrar
                echo "<h1>Borrar editoriales del catalogo</h1>";
                layoutFormEditorial('borraEditorialP.php', 'Borrar');
                break;
            
            case "GU1"://Gestion USUARIOS: consulta
                echo "<h1>Consulta general</h1>";
                layoutFormUsuario('#', 'sinboton');
                break;
            case "GU2"://agregar
                echo "<h1>Insertar usuarios en el catalogo</h1>";
                layoutAgregaUsuario();
                break;
            case "GU3"://modificar
                echo "<h1>Modifica usuarios del catalogo</h1>";
                layoutFormUsuario('modificaUsuarioP.php', 'Modificar');
                break;
            case "GU4"://borrar
                echo "<h1>Borrar usuarios del catalogo</h1>";
                layoutFormUsuario('borrarUsuarioP.php', 'Borrar');
                break;
            
            default:
                echo "<h1>Bienvenid@ a Biblos, tu biblioteca digital</h1>";
        }
        ?>

        <div id="pie">
            <?php include "pie_pagina.php"; ?>
        </div>
    </body>
</html>