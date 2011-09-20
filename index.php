<!DOCTYPE html>
<html>
    <head>
        <title>Bienvenid@ a Biblos - Login</title>
        <link rel="stylesheet" type="text/css" href="css/login.css" /> 
        <link rel="shortcut icon" type="image/x-icon" href="imgs/favicon.ico"  />
        <script src="js/funciones.js" type="text/javascript"></script>
    </head>
    <body>
        <div id="form_general">
            <form action="php/loginP.php" method="POST" onSubmit="return validacampo(this);" >
                <div id="cabecera">
                    <strong>Biblos</strong> Login </div>
                <div id="user">
                    <input class="input" name="nombre_usuario" onblur="if (value =='') {value = 'Usuario'}" onfocus="if (value == 'Usuario') {value =''}" type="text" value="Usuario" onKeyPress="return solonumero(this,event);"  maxlength="8"/></div>
                <div id="pw">
                    <input class="input" name="password" onblur="if (value =='') {value = '123456'}" onfocus="if (value == '123456') {value =''}" type="password" value="123456" maxlength="8" /></div>
                <div id="alinea">
                    <div id="enviar">
                        <input class="login" name="Submit1" type="submit" value="" /></div>
                </div>
                <div id="gest_usuario">
                    <div id="olvidada">
                        <span>*</span> <a href="recupera_passwordG.php">Recupera password</a></div>
                    <div id="new">
                        <span>*</span> <a href="registroG.php">Nuevo usuario</a></div>
                </div>

                <div id="error">
                    <?php
                    if (isset($_GET['error']))
                        echo $_GET['error'];
                    ?>
                </div>
            </form>
        </div>

    </body>

</html>
