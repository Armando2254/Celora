<?php
// Conexión a la base de datos
include 'conexion_bd.php';

// Verificar si se recibió el parámetro ID
if (isset($_POST['id'])) {
    $requisitionId = intval($_POST['id']);

    // Eliminar los productos relacionados con la requisición
    $deleteProductsQuery = "DELETE FROM product_requisition WHERE requisitionId = ?";
    $stmtProducts = $conexion->prepare($deleteProductsQuery);
    $stmtProducts->bind_param("i", $requisitionId);
    $stmtProducts->execute();

    // Eliminar la requisición
    $deleteQuery = "DELETE FROM requisition WHERE id = ?";
    $stmt = $conexion->prepare($deleteQuery);
    $stmt->bind_param("i", $requisitionId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>
