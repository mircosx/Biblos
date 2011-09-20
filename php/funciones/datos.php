<?php
function rellenarCampos($ftabla, $orden) {
    $query = "SELECT * FROM $ftabla ORDER BY $orden";
    $result = mysql_query($query);
    $contcol = mysql_num_fields($result);
    echo "<SELECT NAME='$ftabla'>";
    while ($col = mysql_fetch_row($result)) {
        echo "<OPTION VALUE='$col[0]'>";
        for ($i = 1; $i < $contcol; $i++) {
            echo $col[$i] . " ";
        }
        echo "(" . $col[0] . ")</OPTION>\n";
    }
    echo "</SELECT>";
}

function calcularDewey($id_categoria, $id_autor, $titulo) {
    $q1 = "SELECT apellido1 FROM autor where id_autor=$id_autor";
    $rt1 = mysql_query($q1);
    $r1 = mysql_fetch_row($rt1);
    $rf1 = $r1[0];
    $rf1 = substr($rf1, 0, 3);
    $rf2 = substr($titulo, 0, 3);
    $dewey = strtoupper($id_categoria . $rf1 . $rf2);
    return $dewey;
}

function buscarCampo($nombre_campo, $tabla, $nombre_criterio, $criterio) {
    $query = "SELECT $nombre_campo FROM $tabla WHERE $nombre_criterio='$criterio'";
    $existe = mysql_query($query);
    $carga = mysql_fetch_row($existe);
    $campo = $carga[0];
    return $campo;
}

function extraeCampo2($scampo, $fcampo, $nombre_campo1, $criterio1, $nombre_campo2, $criterio2) {
    $query = "SELECT $scampo FROM $fcampo WHERE $nombre_campo1='$criterio1' and $nombre_campo2='$criterio2'";
    $existe = mysql_query($query);
    $carga = mysql_fetch_row($existe);
    $resultado = $carga[0];
    return $resultado;
}

function controlQuery($nombreVariable, $mensajeOK, $mensajeKO, $refresh, $paginaRetornoOK, $paginaRetornoKO) {
    if ($nombreVariable) {
        echo "$mensajeOK";
        echo "<br>Seras redireccionado en $refresh segundos...";
        header("refresh:$refresh; url=$paginaRetornoOK");
    } else {
        echo "$mensajeKO";
        echo "<br>Seras redireccionado en $refresh segundos...";
        header("refresh:$refresh; url=$paginaRetornoKO");
    }
}
?>
