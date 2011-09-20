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
    <body oncontextmenu="return false;">
        <div id="menu">
            <?php include "menucss.php"; ?>
        </div>

        <h1>Mensajes personales</h1>
            
        <form name="form_mp" action="enviar.php" method="POST">
        <table>
            <tr><td><input type="hidden" name="desde" value="<?php echo $_SESSION['usuario']; ?>" /></td></tr>
            <?php  
                $query = "SELECT nombre_usuario FROM usuario ORDER BY nombre_usuario";
                $result = mysql_query($query);
                echo "<tr><td>Para:</td><td><SELECT NAME='para'>";
                    while ($col = mysql_fetch_row($result)) {
                        echo "<OPTION VALUE='$col[0]'>$col[0]</OPTION>\n";
                    }
                echo "</SELECT></td></tr>";
            ?>
            <tr><td>Mensaje</td><td><textarea name="mensaje" rows="4" cols="20"></textarea></td></tr>
            <tr><td colspan="2"><input type="submit" value="Enviar" /></td></tr>
        </table>
        </form>  
        
        <div id="pie">
            <?php include "pie_pagina.php"; ?>
        </div>
    </body>
</html>
