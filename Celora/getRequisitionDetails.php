<?php
// Conexión a la base de datos
include 'conexion_bd.php';

// Verificar si se recibió el parámetro ID
if (isset($_GET['id'])) {
    $requisitionId = intval($_GET['id']);

    // Consultar los productos relacionados con la requisición
    $query = "
        SELECT p.name AS product_name, pr.quantity AS product_quantity
        FROM product_requisition pr
        INNER JOIN product p ON pr.productCode = p.code
        WHERE pr.requisitionId = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $requisitionId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Generar tabla HTML
    echo "<table class='table table-bordered'>";
    echo "<thead><tr><th>Producto</th><th>Cantidad</th></tr></thead>";
    echo "<tbody>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['product_quantity']) . "</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";

    $stmt->close();
} else {
    echo "ID de requisición no proporcionado.";
}

$conexion->close();
?>
