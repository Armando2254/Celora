
<?php
session_start();

if (empty($_SESSION["employeeNumber"])) {
    header("Location: login.php");
}

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Título de tu página</title>
    <link href="css/btn.css" rel="stylesheet" >

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
   
    <link href="css/estilosInicio.css" rel="stylesheet" >
    <link href="css/btn.css" rel="stylesheet" >

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





<div class="container my-4">
    <h1 class="text-center">Gestión de Pagos</h1>
    <div class="row">
        <?php
        include 'conexion_bd.php';
        $query = "SELECT * FROM payment";
        $result = $conexion->query($query);

        while ($row = $result->fetch_assoc()) {
            echo '
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pago #' . $row['id'] . '</h5>
                        <p class="card-text">Referencia: ' . $row['reference'] . '</p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#paymentModal' . $row['id'] . '">
                            Ver Detalles
                        </button>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="paymentModal' . $row['id'] . '" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="paymentModalLabel">Detalles del Pago #' . $row['id'] . '</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">';
                            $orderQuery = "SELECT * FROM purchaseOrder WHERE id = " . $row['purchaseOrderId'];
                            $orderResult = $conexion->query($orderQuery);
                            $order = $orderResult->fetch_assoc();

                            if ($order) {
                                echo '
                                <p><strong>Orden de Compra:</strong> #' . $order['id'] . '</p>
                                <p><strong>Cantidad Requerida:</strong> ' . $order['requiredQuantity'] . '</p>
                                <p><strong>Total:</strong> $' . $order['total'] . '</p>
                                <p><strong>Subtotal:</strong> $' . $order['subtotal'] . '</p>';
                            } else {
                                echo '<p>No hay información de la orden de compra asociada.</p>';
                            }
            echo '      </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>';
        }
        ?>
    </div>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPaymentModal">Agregar Pago</button>
</div>

<!-- Modal para agregar nuevo pago -->
<div class="modal fade" id="addPaymentModal" tabindex="-1" aria-labelledby="addPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="add_payment.php" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPaymentModalLabel">Agregar Nuevo Pago</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="reference" class="form-label">Referencia</label>
                        <input type="text" class="form-control" name="reference" required>
                    </div>
                    <div class="mb-3">
                        <label for="concept" class="form-label">Concepto</label>
                        <input type="text" class="form-control" name="concept" required>
                    </div>
                    <div class="mb-3">
                        <label for="paymentType" class="form-label">Tipo de Pago</label>
                        <input type="text" class="form-control" name="paymentType" required>
                    </div>
                    <div class="mb-3">
                        <label for="purchaseOrder" class="form-label">Orden de Compra</label>
                        <select class="form-select" name="purchaseOrderId" required>
                            <?php
                            $ordersQuery = "SELECT * FROM purchaseOrder";
                            $ordersResult = $conexion->query($ordersQuery);

                            while ($order = $ordersResult->fetch_assoc()) {
                                echo '<option value="' . $order['id'] . '">#' . $order['id'] . ' - Total: $' . $order['total'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>




   <!-- Footer -->
   <footer class="text-center py-3 border-top">
        <small>&copy; 2024 Empresa. Todos los derechos reservados.</small>
    </footer>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body> 
</html>
