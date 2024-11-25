<?php
// Datos de conexión
$host = "localhost"; // Cambia si usas un host distinto
$usuario = "root";   // Usuario de MySQL
$contrasena = "root"; // Contraseña de MySQL
$base_datos = "celora3"; // Nombre de la base de datos
// Crear la conexión




$conexion = new mysqli($host, $usuario, $contrasena, $base_datos, "3306");

?>