<?php

$usuario = $_SESSION['usuario'];
conexion();
$query0="SELECT * FROM mensajes where para='$usuario' AND leido=0";
$tengocorreo=mysql_query($query0);

if ($tengocorreo) $cuantotengo=mysql_num_rows($tengocorreo);
else $cuantotengo=0;

echo "Estas logeado como <b>$usuario</b>\n, tienes <b>$cuantotengo</b> <a href='../mensajes/mp.php'>mensaje(s) personal(es)</a> sin leer ||\n <a href='../mensajes/envia_mp.php'>Envia</a> mensaje personal ||\n Gestiona tu <a href='../mensajes/perfil.php'>perfil</a> ||\n <a href='salida.php'>Logout</a>\n";

?>