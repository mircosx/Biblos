<?php
controlSesion();

if (isset($_GET['pagina']))
    $pagina = $_GET['pagina'];

if (!isset($pagina)) {
    $pagina = "1";
}
$tipousuario = $_SESSION['tipousuario'];
$quebuscas = $_SESSION['quebuscas'];
$dondebuscas = $_SESSION['filtro'];

$sql = "SELECT id_autor FROM autor WHERE nombre LIKE '%$quebuscas%' or apellido1 LIKE '%$quebuscas%' or apellido2 LIKE '%$quebuscas%' ORDER BY apellido1";
$query = mysql_query($sql);

$i = 0;
while ($row = mysql_fetch_row($query)) {
    $array_id_autores[$i] = $row[0];
    $i++;
};
$total_resultados = mysql_num_rows($query);
$array_busqueda = "";
for ($i = 1; $i < $total_resultados; $i++) {
    $array_busqueda = $array_busqueda . " OR autor_id_autor='" . $array_id_autores[$i] . "'";
}
$primer_campo = $array_id_autores[0];

$buscaesto = "autor_id_autor='" . $primer_campo . "'" . $array_busqueda;
$query_setup = "SELECT * FROM libro WHERE $buscaesto ORDER BY titulo";
$resultado_setup =mysql_query($query_setup);
$total_setup = mysql_num_rows($resultado_setup);
$limite = "1";
$total_paginas = ceil($total_setup / $limite);
$offset = ($pagina - 1) * $limite;
$query = "SELECT * FROM libro WHERE $buscaesto ORDER BY titulo LIMIT $offset, $limite";
$result = mysql_query($query);


echo "<div id='formulario_libro'>";
if ($tipousuario == 0)
    echo "<form action='modifica.php' method='post' name='datos_libro'>\n";
else
    echo "<form action='alquila.php' method='post' name='datos_libro'>\n";
while ($row = mysql_fetch_array($result)) {
    echo "Titulo:<input type='text' name='titulo' value='$row[4]'><br>\n";
    echo "Autor:<input type='text' name='abc' value='" . buscarCampo('nombre', 'autor', 'id_autor', $row[10]) . "&nbsp;" . buscarCampo('apellido1', 'autor', 'id_autor', $row[10]) . "&nbsp;" . buscarCampo('apellido2', 'autor', 'id_autor', $row[10]) . "'><br>\n";
    echo "Categoria: <input type='text' name='abc' value='" . buscarCampo('nombre_categoria', 'categoria', 'id_categoria', $row[0]) . "'><br>\n";
    echo "Idioma: <input type='text' name='abc' value='" . buscarCampo('idioma', 'idiomas_639_1', 'id_idioma_639_1', $row[12]) . "'><br>\n";
    echo "ISBN: <input type='text' name='abc' value='$row[3]'><br>\n";
    echo "Fecha pub: <input type='text' name='abc' value='$row[5]'><br>\n";
    echo "Fecha adq: <input type='text' name='abc' value='$row[6]'><br>\n";
    echo "Paginas: <input type='text' name='abc' value='$row[7]'><br>\n";
    echo "Sinopsis: <input type='textarea' name='abc' value='$row[8]'><br>\n";
    echo "Edicion: <input type='text' name='abc' value='$row[9]'><br>\n";
    echo "Editor: <input type='text' name='abc' value='" . buscarCampo('nombre_editorial', 'editorial', 'id_editorial', $row[11]) . "'><br>\n";
    echo "<input type='hidden' name='usuario_dni' value='" . buscarCampo('dni', 'usuario', 'nombre_usuario', $usuario) . "'>\n"; //usuario ->dni
    echo "<input type='hidden' name='libro_categoria_id_categoria' value='$row[0]'>\n"; //categoria -> id_categoria 
    echo "<input type='hidden' name='libro_cod_apellido' value='$row[1]'>\n"; //libro -> cod_apellido
    echo "<input type='hidden' name='libro_cod_titulo' value='$row[2]'>\n"; //libro -> cod_titulo
    $fecha = date("Y/m/d-H:i:s");
    echo "<input type='hidden' name='fecha_hora_prestamo' value='$fecha'>\n"; //fecha y hora date("Ymd") date("H:i:s")
    echo "<div id='qr'>\n";
    $data = qrlink($row[4], $row[12]);
    qrgen($data);
    echo "</div>\n";
}
echo "<br>Se han encontrado <b>$total_setup</b> libro(s) con tu criterio de busqueda<br>\n";
echo "(Libro cuyo <b>$dondebuscas</b> contenga <b>$quebuscas</b>)<br>\n";
if ($total_setup > 0) {
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
        if ($i == $total_setup)
            $to = $total_setup;
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
}

if ($tipousuario == 0)
    echo "<br><br><input type='submit' value='Modifica libro'/>\n";
else
    echo "<br><br><input type='submit' value='Alquila libro'/>\n";
echo "</form>\n";
echo "</div>\n";
?>
