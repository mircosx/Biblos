<?php 
session_start();

if (!isset($_SESSION['logeado'])
    || $_SESSION['logeado'] != true) {

    header('Location: loginG.php'); //Redirige al inicio de sesion en caso de que no tengas hecho el login

    exit;

}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
      <link rel="stylesheet" type="text/css" href="css/consulta.css">   
    </head>
    <body>
        
<?php

include "funciones.php";
conexion();


$mipagina = $_SERVER['PHP_SELF'];
$usuario = $_SESSION['usuario'];
$dni=$_SESSION['dni'];

if (isset($_GET['pagina'])) $pagina=$_GET['pagina'];

if (!isset($pagina)) {
    $pagina = "1";
}

$sql = "SELECT * FROM libro ORDER BY titulo";
$query = mysql_query($sql);
$total_results = mysql_num_rows($query);
$limite = "1";
$total_paginas = ceil($total_results / $limite);

$offset = ($pagina - 1) * $limite;

$query = "SELECT * FROM libro ORDER BY cod_titulo LIMIT $offset, $limite";
$result = mysql_query($query);

echo "<form action='alquila.php' method='post'>";
while ($row = mysql_fetch_array($result)) {
    echo "Titulo:<input type='text' name='titulo' value='$row[4]'><br>";
    echo "Autor:<input type='text' name='abc' value='".buscarCampo('nombre','autor','id_autor',$row[10])."&nbsp;".buscarCampo('apellido1','autor','id_autor',$row[10])."&nbsp;".buscarCampo('apellido2','autor','id_autor',$row[10])."'><br>";
    echo "Categoria: <input type='text' name='abc' value='".buscarCampo('nombre_categoria','categoria','id_categoria',$row[0])."'><br>";
    echo "Idioma: <input type='text' name='abc' value='".buscarCampo('idioma','idiomas_639_1','id_idioma_639_1',$row[12])."'><br>";
    echo "ISBN: <input type='text' name='abc' value='$row[3]'><br>";
    echo "Fecha pub: <input type='text' name='abc' value='$row[5]'><br>";
    echo "Fecha adq: <input type='text' name='abc' value='$row[6]'><br>";
    echo "Paginas: <input type='text' name='abc' value='$row[7]'><br>";
    echo "Sinopsis: <input type='textarea' name='abc' value='$row[8]'><br>";
    echo "Edicion: <input type='text' name='abc' value='$row[9]'><br>";
    echo "Editor: <input type='text' name='abc' value='".buscarCampo('nombre_editorial','editorial','id_editorial',$row[11])."'><br>";
    
    $fecha=date("Y/m/d-H:i:s");
    echo "<input type='hidden' name='usuario_dni' value='".buscarCampo('dni','usuario','nombre_usuario',$usuario)."'>"; //usuario ->dni
    echo "<input type='hidden' name='libro_categoria_id_categoria' value='$row[0]'>"; //categoria -> id_categoria 
    echo "<input type='hidden' name='libro_cod_apellido' value='$row[1]'>"; //libro -> cod_apellido
    echo "<input type='hidden' name='libro_cod_titulo' value='$row[2]'>"; //libro -> cod_titulo
    echo "<input type='hidden' name='fecha_hora_prestamo' value='$fecha'>"; //fecha y hora date("Ymd") date("H:i:s")
}

mysql_close();

echo "<br>Hay $total_paginas libros en la biblioteca<br>";
if ($pagina != 1) {
    echo "<br><a href=$mipagina?pagina=1><< Primera</a>&nbsp;&nbsp;&nbsp;";
    $ant_pagina = $pagina - 1;
    echo "&nbsp;<a href=$mipagina?pagina=$ant_pagina><<</a>&nbsp;";
}
if ($pagina == $total_paginas) {
    $to = $total_paginas;
} elseif ($pagina == $total_paginas - 1) {
    $to = $pagina + 1;
} elseif ($pagina == $total_paginas - 2) {
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
    if ($i == $total_results)
        $to = $total_results;
    if ($i != $pagina) {
        echo "<a href=$mipagina?pagina=$i>$i</a>";
    } else {
        echo "<b>[$i]</b>";
    }
    if ($i != $total_paginas)
        echo "&nbsp;";
}
if ($pagina != $total_paginas) {
    $sig_pagina = $pagina + 1;
    echo "&nbsp;<a href=$mipagina?pagina=$sig_pagina>>></a>&nbsp;";
    echo "&nbsp;&nbsp;&nbsp;<a href=$mipagina?pagina=$total_paginas>ultima >></a>";
}

$posible_alquiler = buscarCampo('fecha_hora_prestamo', 'usuario_has_libro', 'usuario_dni', $dni);

        echo "<br><br>";
        
        if (is_null($posible_alquiler))
        echo "<input type='submit' value='Alquila libro'/>";
        else echo "Ya has alquilado un libro (poner aqui cual libro y cuando tiene que devolverlo";
       
        
        echo "</form>";
        echo " tu dni es: $dni";
?>

    


        
</body>
</html>