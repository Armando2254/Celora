<?php
// Datos de conexión
$host = "localhost"; // Cambia si usas un host distinto
$usuario = "root";   // Usuario de MySQL
$contrasena = "root"; // Contraseña de MySQL
$base_datos = "celora"; // Nombre de la base de datos
// Crear la conexión









$conexion = new mysqli($host, $usuario, $contrasena, $base_datos, "3306");
// Verificar si la conexión fue exitosa
if ($conexion->connect_error) {
    echo "Error de conexión: " . $conexion->connect_error;
} else {
    echo "Conexión exitosa a la base de datos '$base_datos'";
}

// Cerrar la conexió
$conexion->close();
?>
