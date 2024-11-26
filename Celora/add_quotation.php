<?php
include 'conexion_bd.php';

// Recibir los datos del formulario
$issueDate = $_POST['issueDate'];
$total = $_POST['total'];
$subtotal = $_POST['subtotal'];
$supplierId = $_POST['supplierId'];
$requisitionId = $_POST['requisitionId'];

// Insertar en la tabla cotización, el ID será autoincremental
$insertQuotation = "INSERT INTO quotation (issueDate, total, subtotal, supplierId) 
                    VALUES ('$issueDate', '$total', '$subtotal', '$supplierId')";

if ($conexion->query($insertQuotation) === TRUE) {
    // Obtener el ID de la cotización recién insertada
    $quotationId = $conexion->insert_id;

    // Verificar que los datos de requisición y cotización están disponibles
    if ($requisitionId) {
        // Actualizar la tabla report con la nueva cotización
        $updateReport = "UPDATE report SET quotationId = '$quotationId' WHERE requisitionId = '$requisitionId'";

        if ($conexion->query($updateReport) === TRUE) {
            echo "La cotización se ha guardado y la tabla report ha sido actualizada.";
        } else {
            echo "Error al actualizar la tabla report: " . $conexion->error;
        }
    } else {
        echo "No se seleccionó una requisición válida.";
    }
} else {
    echo "Error al insertar la cotización: " . $conexion->error;
}

header("Location: quotation.php");  // Redirigir a la página de cotizaciones
exit();
?>
