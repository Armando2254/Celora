<?php
include "conexion_bd.php";

if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $numero_solicitante = $_POST['numero_solicitante'];
    $folio = $_POST['folio'];
    $descripcion = $_POST['descripcion'];
    $fecha = $_POST['fecha'];
    $cantidades = $_POST['cantidad'];
    $productos = $_POST['numero_producto'];
    $suma_cantidades = array_sum($cantidades);



    

    // Insertar en tabla de empleados (asegurarte de que sea solo una vez)
    $insert_empleado = $conexion->prepare("INSERT INTO requisition (requiredQuantity, date, description, requester, authorizer) VALUES (?, ?, ?, ?, ?)");
    $insert_empleado->bind_param("issii", $suma_cantidades, $fecha, $descripcion, $numero_solicitante, $numero_solicitante);
    $insert_empleado->execute();

    // Insertar productos
    $insert_producto = $conexion->prepare("INSERT INTO product_requisition (productCode, requisitionId, quantity) VALUES (?, ?, ?)");
    foreach ($productos as $index => $producto) {
        $cantidad = $cantidades[$index];
        $insert_producto->bind_param("iii", $producto, $folio, $cantidad);
        $insert_producto->execute();
    }

    echo "Datos insertados correctamente.";
} else {
    echo "Método no válido o solicitud incompleta.";
}
?>
