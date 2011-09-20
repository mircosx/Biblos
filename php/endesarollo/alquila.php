<!DOCTYPE html>
<html>
    <head>
        <title>Biblos</title>
        <?php eligeplantilla(); ?>
    </head>
    <body>
        <?php
        include "funciones.php";
        conexion();

        $usuario_dni = $_POST['usuario_dni'];
        $libro_categoria_id_categoria = $_POST['libro_categoria_id_categoria'];
        $libro_cod_apellido = $_POST['libro_cod_apellido'];
        $libro_cod_titulo = $_POST['libro_cod_titulo'];
        $fecha_hora_prestamo = $_POST['fecha_hora_prestamo'];

        echo "<br>dni:" . $usuario_dni;
        echo "<br>id cat:" . $libro_categoria_id_categoria;
        echo "<br>cod libro:" . $libro_cod_apellido;
        echo "<br>cod titulo:" . $libro_cod_titulo;
        echo "<br>fecha:" . $fecha_hora_prestamo;

        $query = "INSERT INTO usuario_has_libro ( 
            usuario_dni, libro_categoria_id_categoria, libro_cod_apellido, libro_cod_titulo,fecha_hora_prestamo)
        VALUES (
        '$usuario_dni', '$libro_categoria_id_categoria', '$libro_cod_apellido', '$libro_cod_titulo','$fecha_hora_prestamo')";
        mysql_query($query) or die(mysql_error());

        echo "<br>Has alquilado <b>" . $_POST['titulo'] . "</b>, recuerda que tienes que devolverlo en 3 dias!";
        ?>
    </body>
</html>
