<?php

session_start();

if (empty($_SESSION["employeeNumber"])) {
    header("Location: login.php");
}
// Conexión a la base de datos
$mysqli = new mysqli("localhost", "root", "root", "celora3");

if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
}

// Obtener órdenes de compra
$result = $mysqli->query("SELECT * FROM purchaseOrder");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Título de tu página</title>
    

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/btn.css" rel="stylesheet" >
    <link href="css/estilosInicio.css" rel="stylesheet" >

    <style>
        body {
            background-color: #ffffff;
        }

        .navbar{
    background-color: #50C878;
}

        .card {
            
            transition: transform 0.2s;
        }
        .card:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>


<nav class="navbar navbar-expand-lg">
  <div class="container-fluid d-flex align-items-center justify-content-between">
    <!-- Logo -->
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="logoNoL.png" alt="Bootstrap" width="90" class="me-2 mt-n1 mb-n1"></a>

    <!-- Texto centrado -->
    <ul class="navbar-nav mx-auto">
      <li class="nav-item">
        <span class="navbar-text">
        <?php
        echo "Bienvenido " . $_SESSION["firstName"] . " " . $_SESSION["lastName"];
        ?>

        </span>
      </li>
    </ul>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>



    <!-- Botón "Salir" -->
    <form class="d-flex" role="search">
  <a href="controladorCS.php" class="btn btn-outline-danger">Salir</a>
</form>
  </div>
</nav>




<div class="container mt-5">
        <!-- Botón Inicio alineado a la izquierda -->
        <a href="inicio.php" class="btn btn-custom">Inicio</a>
      
    </div>






<div class="container mt-5">
    <h1 class="mb-4">Órdenes de Compra</h1>
    <div class="row">
        <?php while ($row = $result->fetch_assoc()) : ?>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Orden #<?php echo $row['id']; ?></h5>
                        <p class="card-text">Fecha requerida: <?php echo $row['requiredDate']; ?></p>
                        <p class="card-text">Total: $<?php echo $row['total']; ?></p>
                        <button class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#orderModal<?php echo $row['id']; ?>">Ver detalles</button>
                    </div>
                </div>
            </div>

            <!-- Modal Detalles -->
            <div class="modal fade" id="orderModal<?php echo $row['id']; ?>" tabindex="-1"
                 aria-labelledby="orderModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detalles de la Orden #<?php echo $row['id']; ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <?php
                            // Obtener información relacionada con la orden
                            $orderId = $row['id'];
                            $reportQuery = $mysqli->query("SELECT * FROM report WHERE purchaseOrderId = $orderId");
                            while ($report = $reportQuery->fetch_assoc()) {
                                $requisitionId = $report['requisitionId'];
                                $quotationId = $report['quotationId'];

                                // Obtener cotización
                                $quotationQuery = $mysqli->query("SELECT * FROM quotation WHERE id = '$quotationId'");
                                $quotation = $quotationQuery->fetch_assoc();

                                // Obtener productos
                                $productQuery = $mysqli->query("
                                    SELECT p.name, pr.quantity FROM product p 
                                    JOIN product_requisition pr ON p.code = pr.productCode 
                                    WHERE pr.requisitionId = $requisitionId");
                                ?>
                                <p><strong>Proveedor:</strong> <?php echo $quotation['supplierId']; ?></p>
                                <p><strong>Total:</strong> $<?php echo $quotation['total']; ?></p>
                                <p><strong>Subtotal:</strong> $<?php echo $quotation['subtotal']; ?></p>
                                <h6>Productos:</h6>
                                <ul>
                                    <?php while ($product = $productQuery->fetch_assoc()) : ?>
                                        <li><?php echo $product['name']; ?> - <?php echo $product['quantity']; ?></li>
                                    <?php endwhile; ?>
                                </ul>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <!-- Botón para nueva orden -->
    <button class="btn btn-success mt-4" data-bs-toggle="modal" data-bs-target="#newOrderModal">Nueva Orden de Compra</button>
</div>

<!-- Modal Nueva Orden -->
<div class="modal fade" id="newOrderModal" tabindex="-1" aria-labelledby="newOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" action="newOrder.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nueva Orden de Compra</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="requiredDate" class="form-label">Fecha requerida</label>
                        <input type="date" class="form-control" id="requiredDate" name="requiredDate" required>
                    </div>
                    <div class="mb-3">
                        <label for="requisitionId" class="form-label">Requisición</label>
                        <select class="form-select" id="requisitionId" name="requisitionId" required>
                            <?php
                            $requisitions = $mysqli->query("SELECT id FROM requisition");
                            while ($req = $requisitions->fetch_assoc()) : ?>
                                <option value="<?php echo $req['id']; ?>"><?php echo $req['id']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <!-- Footer -->
    <footer class="text-center py-3 border-top">
        <small>&copy; 2024 Empresa. Todos los derechos reservados.</small>
    </footer>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body> 
</html>
