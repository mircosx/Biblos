<?php
session_start();
include "../php/funciones/mini.php";
include "../php /funciones/datos.php";
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
            <?php include "../php/menucss.php"; ?>
        </div>
<?php
$usuario=$_SESSION['usuario'];
$query="SELECT * FROM mensajes where para='$usuario'";
$tengocorreo=mysql_query($query);
$cuantotengo=mysql_num_rows($tengocorreo);
$mipagina=$_SERVER['PHP_SELF']; 

if (isset($_GET['pagina']))
            $pagina = $_GET['pagina'];

        if (!isset($pagina)) {
            $pagina = "1";
        }

        $sql = "SELECT * FROM mensajes where para='$usuario' order by leido";
        $tengocorreo=mysql_query($query);
        $cuantotengo=mysql_num_rows($tengocorreo);
        
        $limite = "1";
        $total_libros = ceil($cuantotengo / $limite);
        $offset = ($pagina - 1) * $limite;

        $query = "SELECT * FROM mensajes where para='$usuario' order by leido LIMIT $offset, $limite";
        $result = mysql_query($query);



echo "<div id='formulario_libro'>\n";
echo "<form action='leer.php' method='post' name='datos_libro'>\n";
echo "<table>";
while ($row = mysql_fetch_array($result)) {
    echo "<tr><td>De:</td><td><input type='text' name='desde' title='$row[0]' value='$row[0]'></td></tr>\n";
    echo "<tr><td>Mensaje:</td><td><textarea name='mensaje'>$row[2]</textarea></td></tr>\n";
    if ($row['leido']==0)
        echo "<tr><td colspan='2'>Este mensaje esta marcado como <b>sin leer</b></td></tr>";
    else echo "<tr><td colspan='2'>Este mensaje esta marcado como <b>leido</b></td></tr>";
}

echo "<tr><td colspan='2'>";
        if ($pagina != 1) {
            echo "<a href=$mipagina?pagina=1><< Primera</a>&nbsp;&nbsp;&nbsp;";
            $ant_pagina = $pagina - 1;
            echo "&nbsp;<a href=$mipagina?pagina=$ant_pagina><<</a>&nbsp;";
        }
        if ($pagina == $total_libros) {
            $to = $total_libros;
        } elseif ($pagina == $total_libros - 1) {
            $to = $pagina + 1;
        } elseif ($pagina == $total_libros - 2) {
            $to = $pagina + 2;
        } else {
            $to = $pagina + 3;
        }
        if ($pagina == 1 || $pagina == 2 || $pagina == 3) {
            $from = 1;
        } else {
            $from = $pagina - 3;
        }

        for ($i = $from; $i <= $to; $i++) {
            if ($i == $cuantotengo)
                $to = $cuantotengo;
            if ($i != $pagina) {
                echo "<a href=$mipagina?pagina=$i>$i</a>";
            } else {
                echo "<b>[$i]</b>";
            }
            if ($i != $total_libros)
                echo "&nbsp;";
        }
        if ($pagina != $total_libros) {
            $sig_pagina = $pagina + 1;
            echo "&nbsp;<a href=$mipagina?pagina=$sig_pagina>>></a>&nbsp;";
            echo "&nbsp;&nbsp;&nbsp;<a href=$mipagina?pagina=$total_libros>ultima >></a>";
        }
        echo "</td></tr>\n";
        echo "<tr><td colspan='2'><input type='submit' value='Leido'></td></tr>";
echo "</table>";
echo "</form>";
    ?>

        <h1>Mensajes personales</h1>
        
        <div id="pie">
            <?php include "../pie_pagina.php"; ?>
        </div>
    </body>
</html>
