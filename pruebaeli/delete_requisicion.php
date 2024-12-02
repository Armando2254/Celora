<?php
include '../conexion_bd.php';

$id = $_GET['id'];



// Actualizar la tabla report para desvincular la requisición




// Verificar si la requisición tiene productos asociados
$query = "SELECT productCode FROM product_requisition WHERE requisitionId = $id";
$result = mysqli_query($conexion, $query);

if (mysqli_num_rows($result) > 0) {
    // Eliminar cada asociación de productos con la requisición
    while ($row = mysqli_fetch_assoc($result)) {
        $productCode = $row['productCode'];
        $deleteProductQuery = "DELETE FROM product_requisition WHERE requisitionId = $id AND productCode = $productCode";
        mysqli_query($conexion, $deleteProductQuery);
    }
}

// Después de eliminar las asociaciones, eliminar la requisición
$deleteRequisitionQuery = "DELETE FROM requisition WHERE id = $id";
if (mysqli_query($conexion, $deleteRequisitionQuery)) {
    echo "Requisición y sus asociaciones eliminadas exitosamente.";
} else {
    echo "Error al eliminar la requisición: " . mysqli_error($conexion);
}




?>
