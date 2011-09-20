<?php

function layoutFormLibro($Filtro, $accion, $nombreBoton) {
    $mipagina = $_SERVER['PHP_SELF'];
    $usuario = $_SESSION['usuario'];
    $dni = $_SESSION['dni'];
    
    if (isset($_GET['pagina']))
        $pagina = $_GET['pagina'];

    if (!isset($pagina)) {
        $pagina = "1";
    }

    switch ($Filtro) {
        case 0: //general
            $sql = "SELECT * FROM libro";
            $query = mysql_query($sql);
            $total_setup = mysql_num_rows($query);
            $limite = "1";
            $total_paginas = ceil($total_setup / $limite);
            $offset = ($pagina - 1) * $limite;
            $query = "SELECT * FROM libro ORDER BY titulo LIMIT $offset, $limite";
            $result = mysql_query($query);
            break;

        case 1://autor
            $quebuscas = $_SESSION['quebuscas'];
            $dondebuscas = $_SESSION['filtro'];
            $sql = "SELECT id_autor FROM autor WHERE nombre LIKE '%$quebuscas%' or apellido1 LIKE '%$quebuscas%' or apellido2 LIKE '%$quebuscas%' ORDER BY id_autor";
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
            $resultado_setup = mysql_query($query_setup);
            $total_setup = mysql_num_rows($resultado_setup);
            $limite = "1";
            $total_paginas = ceil($total_setup / $limite);
            $offset = ($pagina - 1) * $limite;
            $query = "SELECT * FROM libro WHERE $buscaesto ORDER BY titulo LIMIT $offset, $limite";
            $result = mysql_query($query);
            break;

        case 2://titulo
            $quebuscas = $_SESSION['quebuscas'];
            $dondebuscas = $_SESSION['filtro'];
            $sql = "SELECT * FROM libro WHERE titulo LIKE '%$quebuscas%'";
            $query = mysql_query($sql);
            $total_setup = mysql_num_rows($query);
            $limite = "1";
            $total_paginas = ceil($total_setup / $limite);
            $offset = ($pagina - 1) * $limite;
            $query = "SELECT * FROM libro WHERE titulo LIKE '%$quebuscas%' ORDER BY titulo LIMIT $offset, $limite";
            $result = mysql_query($query);
            break;

        case 3://categoria
            $quebuscas = $_SESSION['quebuscas'];
            $dondebuscas = $_SESSION['filtro'];
            $sql = "SELECT id_categoria FROM categoria WHERE nombre_categoria LIKE '%$quebuscas%'";
            $query = mysql_query($sql);
            $i = 0;
            while ($row = mysql_fetch_row($query)) {
                $array_id_categoria[$i] = $row[0];
                $i++;
            };
            $total_resultados = mysql_num_rows($query);
            $array_busqueda = "";
            for ($i = 1; $i < $total_resultados; $i++) {
                $array_busqueda = $array_busqueda . " OR categoria_id_categoria='" . $array_id_categoria[$i] . "'";
            }
            $primer_campo = $array_id_categoria[0];

            $buscaesto = "categoria_id_categoria='" . $primer_campo . "'" . $array_busqueda;
            $query_setup = "SELECT * FROM libro WHERE $buscaesto ORDER BY titulo";
            $resultado_setup = mysql_query($query_setup);
            $total_setup = mysql_num_rows($resultado_setup);
            $limite = "1";
            $total_paginas = ceil($total_setup / $limite);
            $offset = ($pagina - 1) * $limite;
            $query = "SELECT * FROM libro WHERE $buscaesto ORDER BY titulo LIMIT $offset, $limite";
            $result = mysql_query($query);
            break;
    }

    echo "<div id='formulario'>\n";
    echo "<form action='$accion' method='post' name='datos'>\n";
    echo "<table>";
    while ($row = mysql_fetch_array($result)) {
        echo "<tr><td>Titulo:</td><td><input type='text' name='titulo' title='$row[4]' value='$row[4]'></td></tr>\n";
        echo "<tr><td>Autor:</td><td><input type='text' name='id_autor' value='" . buscarCampo('nombre', 'autor', 'id_autor', $row[10]) . "&nbsp;" . buscarCampo('apellido1', 'autor', 'id_autor', $row[10]) . "&nbsp;" . buscarCampo('apellido2', 'autor', 'id_autor', $row[10]) . "'></td></tr>\n";
        echo "<tr><td>Categoria:</td><td><input type='text' name='id_categoria' value='" . buscarCampo('nombre_categoria', 'categoria', 'id_categoria', $row[0]) . "'></td></tr>\n";
        echo "<tr><td>Idioma:</td><td><input type='text' name='id_idioma_639_1' value='" . buscarCampo('idioma', 'idiomas_639_1', 'id_idioma_639_1', $row[12]) . "'></td></tr>\n";
        echo "<tr><td>ISBN:</td><td><input type='text' name='isbn' value='$row[3]'></td></tr>\n";
        echo "<tr><td>Fecha pub:</td><td><input type='text' name='fecha_publicacion' value='" . date("d/m/Y", strtotime($row[5])) . "'></td></tr>\n";
        echo "<tr><td>Fecha adq:</td><td><input type='text' name='fecha_adquisicion' value='" . date("d/m/Y", strtotime($row[6])) . "'></td></tr>\n";
        echo "<tr><td>Paginas:</td><td><input type='text' name='num_paginas' value='$row[7]'></td></tr>\n";
        echo "<tr><td>Sinopsis:</td><td><input type='textarea' name='sinopsis' title='$row[8]' value='$row[8]'></td></tr>\n";
        echo "<tr><td>Edicion:</td><td><input type='text' name='edicion' value='$row[9]'></td></tr>\n";
        echo "<tr><td>Editor:</td><td><input type='text' name='id_editorial' value='" . buscarCampo('nombre_editorial', 'editorial', 'id_editorial', $row[11]) . "'></td></tr>\n";
        $fecha = date("Y/m/d-H:i:s");
        echo "<tr><td colspan='2'><input type='hidden' name='usuario_dni' value='" . buscarCampo('dni', 'usuario', 'nombre_usuario', $usuario) . "'></td></tr>\n"; //usuario ->dni
        echo "<tr><td colspan='2'><input type='hidden' name='libro_categoria_id_categoria' value='$row[0]'></td></tr>\n"; //categoria -> id_categoria 
        echo "<tr><td colspan='2'><input type='hidden' name='libro_cod_apellido' value='$row[1]'></td></tr>\n"; //libro -> cod_apellido
        echo "<tr><td colspan='2'><input type='hidden' name='libro_cod_titulo' value='$row[2]'></td></tr>\n"; //libro -> cod_titulo
        echo "<tr><td colspan='2'><input type='hidden' name='fecha_hora_prestamo' value='$fecha'></td></tr>\n"; //fecha y hora date("Ymd") date("H:i:s")
        $_SESSION['nombrelibro'] = $row[3];
        $_SESSION['idioma'] = $row[12];
    }

    switch ($Filtro) {
        case 0://general
            echo "<tr><td colspan='2'>Hay <b>$total_setup</b> libros en la biblioteca</td></tr>\n";
            break;
        case 1://autor
            echo "<tr><td colspan='2'>Hay <b>$total_setup</b> libros en la biblioteca cuyo <b>$dondebuscas</b> contenga <b>$quebuscas</b></td></tr>\n";
            break;
        case 2://titulo
            echo "<tr><td colspan='2'>Hay <b>$total_setup</b> libros en la biblioteca cuyo <b>$dondebuscas</b> contenga <b>$quebuscas</b></td></tr>\n";
            break;
        case 3://categoria
            echo "<tr><td colspan='2'>Hay <b>$total_setup</b> libros en la biblioteca cuya <b>$dondebuscas</b> contenga <b>$quebuscas</b></td></tr>\n";
            break;
    }

    echo "<tr><td colspan='2'>";
    if ($pagina != 1) {
        echo "<a href=$mipagina?pagina=1><< Primera</a>&nbsp;&nbsp;&nbsp;";
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
    echo "</td></tr>";
    echo "</table>";
    if ($nombreBoton != "sinboton")
        echo "<input type='submit' value='$nombreBoton'>";
    echo "</form>\n";
    echo "</div>\n";
    ?>
        <div class="filtros">
            <input type="radio" name="visualizacion" value="Filtrar" onClick="grafica_filtro('block');" />Campos<br />
            <input type="radio" name="visualizacion" value="Listado general" onClick="esconde_filtros('none');" />Consulta general
        </div>

        <div id='oculto'>";
          <?php include "consulta_criterios.php"; ?>
        </div>

        <div id='oculto2'></div>
    <?php
}

function layoutFormUsuario($accion, $nombreBoton) {
    $mipagina = $_SERVER['PHP_SELF'];
    $usuario = $_SESSION['usuario'];
    $dni = $_SESSION['dni'];

    if (isset($_GET['pagina']))
        $pagina = $_GET['pagina'];

    if (!isset($pagina)) {
        $pagina = "1";
    }

    $sql = "SELECT * FROM usuario ORDER BY apellido1_usuario";
    $query = mysql_query($sql);
    $total_usuarios = mysql_num_rows($query);
    $limite = "1";
    $total_paginas = ceil($total_usuarios / $limite);
    $offset = ($pagina - 1) * $limite;

    $query = "SELECT * FROM usuario ORDER BY apellido1_usuario LIMIT $offset, $limite";
    $result = mysql_query($query);

    echo "<div id='formulario_libro'>\n";
    echo "<form action='$accion' method='post' name='datos_usuario'>\n";
    echo "<table>";
    while ($row = mysql_fetch_array($result)) {
        echo "<tr><td>DNI:</td><td><input type='text' name='dni' value='$row[0]'></td></tr>\n";
        echo "<tr><td>Clave:</td><td><input type='password' name='clave' value='$row[1]'></td></tr>\n";
        echo "<tr><td>Nombre usuario:</td><td><input type='text' name='nombre_usuario' value='$row[2]'></td></tr>\n";
        echo "<tr><td>Apellido 1:</td><td><input type='text' name='apellido1_usuario' value='$row[3]'></td></tr>\n";
        echo "<tr><td>Apellido 2:</td><td><input type='text' name='apellido2_usuario' value='$row[4]'></td></tr>\n";
        echo "<tr><td>E-Mail:</td><td><input type='text' name='email' value='$row[5]'></td></tr>\n";
        echo "<tr><td>Telefono:</td><td><input type='text' name='telefono' value='$row[6]'></td></tr>\n";
        echo "<tr><td>Direccion:</td><td><input type='text' name='Direccion' value='$row[7]'></td></tr>\n";
        echo "<tr><td>Plantilla:</td><td><input type='textarea' name='plantilla' value='$row[8]'></td></tr>\n";
        echo "<tr><td>Tipo usuario:</td><td><input type='text' name='tipo_usuario' value='" . buscarCampo('tipo_usuario', 'tipos_usuario', 'id_tipo_usuario', $row[9]) . "'></td></tr>\n";
    }

    echo "<tr><td colspan='2'>Hay $total_usuarios usuarios en la base de datos</td></tr>\n";
    echo "<tr><td colspan='2'>";
    if ($pagina != 1) {
        echo "<a href=$mipagina?pagina=1><< Primera</a>&nbsp;&nbsp;&nbsp;";
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
        if ($i == $total_paginas)
            $to = $total_paginas;
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
    echo "</td></tr>";
    echo "</table>";
    if ($nombreBoton != "sinboton")
        echo "<input type='submit' value='$nombreBoton'>";
    echo "</form>\n";
    echo "</div>\n";
}

;

function layoutAgregaUsuario() {
    echo "<div id='formulario_libro'>";
    echo "<form action='usuarioP.php' method='post' name='datos_usuario'>";
    echo "<table>";
    echo "<tr><td>DNI:</td><td><input type='text' name='dni'></td></tr>\n";
    echo "<tr><td>Clave:</td><td><input type='password' name='clave'></td></tr>\n";
    echo "<tr><td>Nombre usuario:</td><td> <input type='text' name='nombre_usuario'></td></tr>\n";
    echo "<tr><td>Apellido 1:</td><td> <input type='text' name='apellido1'></td></tr>\n";
    echo "<tr><td>Apellido 2:</td><td> <input type='text' name='apellido2'></td></tr>\n";
    echo "<tr><td>E-Mail:</td><td> <input type='text' name='email'></td></tr>\n";
    echo "<tr><td>Telefono:</td><td> <input type='text' name='telefono'></td></tr>\n";
    echo "<tr><td>Direccion:</td><td> <input type='text' name='direccion'></td></tr>\n";
    echo "<tr><td>Plantilla:</td><td> <input type='textarea' name='css'></td></tr>\n";
    echo "<tr><td>Tipo usuario:</td><td> <input type='text' name='tipo_usuario'></td></tr>\n";
    echo "<tr><td colspan='2'><input type='submit' value='Confirma'></td></tr>\n";
    echo "</table>";
    echo "</form>";
}

function layoutAgregaLibro() {
    ?>
    <FORM ACTION="libroP.php" METHOD="post" onSubmit="return validacampo(this);">
        <fieldset class="login">
            <legend>Datos nuevo libro</legend>
            Titulo:<br/>
            <INPUT TYPE=text NAME=titulo class="obligatorio" autocomplete="off" onKeyPress="return no_caracter_esp(this,event);"/>*
            <BR>
            Autor:<br>
            <?php
            rellenarCampos("autor", "apellido1");
            ?>
            <br>
            Categoria:<br> 
            <?php
            rellenarCampos("categoria", "nombre_categoria");
            ?>
            <br>
            Idioma:<br>
    <?php
    rellenarCampos("idiomas_639_1", "idioma");
    ?>
            <br>
            ISBN:<br>
            <INPUT TYPE="text" NAME="isbn" autocomplete="off" onKeyPress="return solonumero(this,event);"/>
            <br>
            Fecha de publicaci&oacute;n [aaaa/mm/dd]: <br>
            <INPUT TYPE="text" NAME="fecha_publicacion" autocomplete="off" onKeyPress="return solonumero(this,event);"/>
            <br>
            Fecha de adquisici&oacute;n [aaaa/mm/dd]: <br>
            <INPUT TYPE="text" NAME="fecha_adquisicion" autocomplete="off" onKeyPress="return solonumero(this,event);"/>
            <br>
            Numero de p&aacute;ginas: <br>
            <INPUT TYPE="text" NAME="num_paginas" autocomplete="off" onKeyPress="return solonumero(this,event);"/>
            <br>
            Sinopsis:<br>
            <TEXTAREA NAME="sinopsis" COLS=40 ROWS=6 autocomplete="off" onKeyPress="return no_caracter_esp(this,event);"></textarea>
                <br>
                Edici&oacute;n: <br>
                <INPUT TYPE="text" NAME="edicion" autocomplete="off" onKeyPress="return solonumero(this,event)"/>
                <br>
                Editorial:<br>
        <?php
        rellenarCampos("editorial", "nombre_editorial");
        ?>
                <br><br>
    </fieldset>
                <input type="submit" value="Guardar libro" />
                    <input type="reset" value="Limpiar campos" />
            </FORM>
    <?php
}

function layoutFormAutor($accion, $nombreBoton) {
    $mipagina = $_SERVER['PHP_SELF'];
    $usuario = $_SESSION['usuario'];
    $dni = $_SESSION['dni'];

    if (isset($_GET['pagina']))
        $pagina = $_GET['pagina'];

    if (!isset($pagina)) {
        $pagina = "1";
    }

    $sql = "SELECT * FROM autor ORDER BY apellido1";
    $query = mysql_query($sql);
    $total_resultados = mysql_num_rows($query);
    $limite = "1";
    $total_libros = ceil($total_resultados / $limite);
    $offset = ($pagina - 1) * $limite;

    $query = "SELECT * FROM autor ORDER BY apellido1 LIMIT $offset, $limite";
    $result = mysql_query($query);

    echo "<div id='formulario_libro'>";
    echo "<form action='$accion' method='post' name='datos_autor'>";
    echo "<table>";
    while ($row = mysql_fetch_array($result)) {
        echo "<input type='hidden' name='id_autor' value='$row[0]'><br>\n";
        echo "<tr><td>Nombre:</td><td><input type='text' name='nombre' value='$row[1]'></td></tr>";
        echo "<tr><td>Apellido 1:</td><td><input type='text' name='apellido1' value='$row[2]'></td></tr>\n";
        echo "<tr><td>Apellido 2:</td><td><input type='text' name='apellido2' value='$row[3]'></td></tr>\n";
        echo "<tr><td>Nacionalidad:</td><td><input type='text' name='nacionalidad' value='$row[4]'></td></tr>\n";
    }

    echo "<tr><td colspan='2'>Hay $total_libros autores en el catalogo</td></tr>";
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
        if ($i == $total_resultados)
            $to = $total_resultados;
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
    if ($nombreBoton != "sinboton")
        echo "<tr><td colspan='2'><input type='submit' value='$nombreBoton'/></td></tr>\n";
    echo "</table>";
    echo "</form>";
    echo "</div>";
}

function layoutAgregaAutor() {
    ?>
        <div id="formulario_libro">
                <FORM ACTION="autorP.php" METHOD="post" onSubmit="return validacampo(this);">
                    <table>
                        <tr><td>Nombre *:</td><td><INPUT TYPE="text" NAME="nombre" class="obligatorio" autocomplete="off" onKeyPress="return no_caracter_esp(this,event);"/></td></tr>
                        <tr><td>Primer apellido *:</td><td><INPUT TYPE="text" NAME="apellido1" class="obligatorio" autocomplete="off" onKeyPress="return no_caracter_esp(this,event);"/></td></tr>
                        <tr><td>Segundo apellido(s):</td><td><INPUT TYPE="text" NAME="apellido2" autocomplete="off" onKeyPress="return no_caracter_esp(this,event);"/></td></tr>
                        <tr><td>Nacionalidad:</td><td><INPUT TYPE="text" NAME="nacionalidad" autocomplete="off" onKeyPress="return no_caracter_esp(this,event);" /></td></tr>
                        <tr><td colspan="2"><INPUT TYPE="submit" CLASS="boton" VALUE="Registrar" /></td></tr>
                    </table>
                </FORM>

            </div>
    <?php
}

function layoutFormEditorial($accion, $nombreBoton) {
    $mipagina = $_SERVER['PHP_SELF'];
    $usuario = $_SESSION['usuario'];
    $dni = $_SESSION['dni'];

    if (isset($_GET['pagina']))
        $pagina = $_GET['pagina'];

    if (!isset($pagina)) {
        $pagina = "1";
    }

    $sql = "SELECT * FROM editorial ORDER BY id_editorial";
    $query = mysql_query($sql);
    $total_resultados = mysql_num_rows($query);
    $limite = "1";
    $total_libros = ceil($total_resultados / $limite);
    $offset = ($pagina - 1) * $limite;

    $query = "SELECT * FROM editorial ORDER BY id_editorial LIMIT $offset, $limite";
    $result = mysql_query($query);

    echo "<div id='formulario_libro'>";
    echo "<form action='$accion' method='post' name='datos_libro'>";
    while ($row = mysql_fetch_array($result)) {
        echo "Nombre editorial:<input type='text' name='nombre_editorial' value='$row[1]'><br>";
        echo "<input type='hidden' name='id_editorial' value='$row[0]'><br>";
    }

    echo "<br>Hay $total_libros editoriales en la biblioteca<br>";
    if ($pagina != 1) {
        echo "<br><a href=$mipagina?pagina=1><< Primera</a>&nbsp;&nbsp;&nbsp;";
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
        if ($i == $total_resultados)
            $to = $total_resultados;
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
    if ($nombreBoton != "sinboton")
        echo "<br><input type='submit' value='$nombreBoton'/>";
    echo "</form>";
}

function layoutAgregaEditorial() {
    ?>
        <FORM ACTION="editorialP.php" METHOD="post" onSubmit="return validacampo(this);">
            Editorial : <INPUT TYPE="text" NAME="nombre_editorial" SIZE=45 MAXLENGTH=45 class="obligatorio" autocomplete="off" onKeyPress="return no_caracter_esp(this,event);"/>*
            <br/>
            <input type="submit" value="Alta editorial" />
        </form>
    <?php
}

function qrlink($nombrelibro, $ididioma) {
    $nombrelibro = trim($nombrelibro);
    $nombrelibbus = str_replace(" ", "_", $nombrelibro);
    $linkdata = "http://" . $ididioma . ".wikipedia.org/wiki/" . $nombrelibbus;
    return $linkdata;
}

function qrgen($linkdata) {
    include "../phpqrcode/qrlib.php";
    $PNG_TEMP_DIR = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR;
    $PNG_WEB_DIR = 'png/';
    $errorCorrectionLevel = 'H';
    $matrixPointSize = '2';

    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    $filename = $PNG_TEMP_DIR . 'test.png';

    QRcode::png($linkdata, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
    echo "<a href='$linkdata'><img src='" . $PNG_WEB_DIR . basename($filename) . "' /></a>";
}

function GeneRandom($digitos=15, $letras=TRUE, $numeros=TRUE) {
    $pool = 'abcdefghijklmnopqrstuvwxyz';
    if ($letras == 1)
        $pool .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    if ($numeros == 1)
        $pool .= '1234567890';

    if ($digitos > 0) {
        $codigo = "";
        $pool = str_split($pool, 1);
        for ($i = 1; $i <= $digitos; $i++) {
            mt_srand((double) microtime() * 1000000);
            $num = mt_rand(1, count($pool));
            $codigo .= $pool[$num - 1];
        }
    }
    return $codigo;
}

function confirmaCorreo($email, $codigo) {

    $to = $email;
    $subject = "Confirma iscripcion a Biblos";
    $body = "El codigo de confirmacion es :$codigo\n Gracias por iscrivirte en Biblos\n BilosQR Team";

    $transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
            ->setUsername('applesoftmt@gmail.com')
            ->setPassword('aquilacontraseña');

    //Creamos el mailer pasándole el transport con la configuración de gmail
    $mailer = Swift_Mailer::newInstance($transport);

    //Creamos el mensaje
    $message = Swift_Message::newInstance($subject)
            ->setFrom(array('applesoft@gmail.com' => 'Administrador Biblos G2'))
            ->setTo($to)
            ->setBody($body);

    $message->setContentType("text/html");

    //Enviamos

    $result = $mailer->send($message);
}