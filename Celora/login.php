

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Login</title>
    <link rel="stylesheet" href="css/estilosLogin.css">
</head>
<body>

    <!-- Barra de navegación -->
    <div class="navbar">
        <a href="http://localhost/Proyecto/php/CelorA.php">
        <img src="logoNoL.png" alt="Logo">
        </a>
        <h1>CelorA</h1>
    </div>

    <!-- Contenedor del login -->
    <div class="login-container">
        <div class="login-box">
            <form method="post" action="">
            <h2>Iniciar Sesión</h2>
            
            <?php
            include "conexion_bd.php";
            include "controladorL.php";
            ?>
            
            <label for="usuario">Usuario</label>
            <input type="text" name="usuario" placeholder="Ingresa tu usuario">

            <label for="password">Contraseña</label>
            <input type="password" name="password" placeholder="Ingresa tu contraseña">

            <input name="btnIniciar" id="log" type="submit" value="INICIAR SESION">
        </form>
        </div>
    </div>

</body>
</html>
