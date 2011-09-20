<?php
function conexion() {
    $server = "localhost";
    $usr = "phpusr";
    $pwd = "phppwd";
    $db = "biblos_g2";

    $conecta = mysql_connect($server, $usr, $pwd);
    if (!$conecta)
        echo "Error conectando a la base de datos.";
    $datos = mysql_select_db($db, $conecta);
    if (!$datos)
        echo "Error seleccionando la base de datos.";
}

function controlSesion() {
    if (!isset($_SESSION['logeado'])
            || $_SESSION['logeado'] != true) {
        header('Location: ../index.php');
        exit;
    } else {
        
    }
}

function controlAdmin() {
    $tipousuario = $_SESSION['tipousuario'];
    if ($tipousuario != 0) {
        echo "<script type='text/javascript'>
        window.alert('ahi listillo! tienes que ser administrador para poder modificar la base de datos!')
        </script>";
        header("Refresh: 2; URL=menuG.php");
        exit;
    }
}

function eligeplantilla() {
    $css = trim($_SESSION['css']);
    echo "<link rel='shortcut icon' type='image/x-icon' href='../imgs/favicon.ico'  />";
    echo "<link rel='stylesheet' type='text/css' href='../css/consulta" . $css . ".css' />";
    echo "<script src='../js/funciones.js' type='text/javascript'></script>";
}
?>
