<?php
session_start();

if (empty($_SESSION["employeeNumber"])) {
    header("Location: login.php");
}

// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "celora";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Manejo de búsqueda
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sql = "SELECT p.code, p.name, p.price, p.description, s.quantity 
        FROM product p
        LEFT JOIN stock s ON p.stockCode = s.code
        WHERE p.name LIKE '%$search%' OR p.code LIKE '%$search%'";
$result = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Inserta sin especificar el código (MySQL se encargará de asignarlo)
    $insert_sql = "INSERT INTO product (name, price, description, stockCode) 
                   VALUES ('$name', '$price', '$description', NULL)";
    $conn->query($insert_sql);
    header("Location: " . $_SERVER['PHP_SELF']);
}


// Manejo de actualización de producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $productCode = $_POST['productCode'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];

    // Actualizar producto
    $update_product_sql = "UPDATE product SET name='$name', price='$price', description='$description' WHERE code='$productCode'";
    $conn->query($update_product_sql);

    // Actualizar cantidad en stock
    $check_sql = "SELECT stockCode FROM product WHERE code = $productCode";
    $check_result = $conn->query($check_sql)->fetch_assoc();

    if (is_null($check_result['stockCode'])) {
        // Insertar en stock y actualizar stockCode en producto
        $conn->query("INSERT INTO stock (quantity) VALUES ($quantity)");
        $stock_id = $conn->insert_id;
        $conn->query("UPDATE product SET stockCode = $stock_id WHERE code = $productCode");
    } else {
        // Actualizar cantidad en stock
        $conn->query("UPDATE stock SET quantity = $quantity WHERE code = {$check_result['stockCode']}");
    }

    header("Location: " . $_SERVER['PHP_SELF']);
}

// Manejo de eliminación de producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $productCode = $_POST['productCode'];

    // Eliminar producto
    $delete_sql = "DELETE FROM product WHERE code = $productCode";
    $conn->query($delete_sql);

    // Eliminar stock relacionado
    $conn->query("DELETE FROM stock WHERE code = (SELECT stockCode FROM product WHERE code = $productCode)");

    header("Location: " . $_SERVER['PHP_SELF']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../images/logoCAB.png" type="images/png">
    <link href="css/estilosInicio.css" rel="stylesheet">
    <link href="css/btn.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="images/logoCAB.png" type="images/png">
    <style>
        body { background-color: #ffffff; }
        .navbar { background-color: #50C878; }
        .card { transition: transform 0.2s; }
        .card:hover { transform: scale(1.05); }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
  <div class="container-fluid d-flex align-items-center justify-content-between">
    <a class="navbar-brand d-flex align-items-center" href="http://localhost/Proyecto/php/inicio.php">
      <img src="../images/logoNoL.png" alt="Bootstrap" width="90" class="me-2 mt-n1 mb-n1"></a>
    <ul class="navbar-nav mx-auto">
      <li class="nav-item">
        <span class="navbar-text">
        <?php echo "Bienvenido " . $_SESSION["firstName"] . " " . $_SESSION["lastName"]; ?>
        </span>
      </li>
    </ul>
    <form class="d-flex" role="search">
      <a href="controladorCS.php" class="btn btn-outline-danger">Salir</a>
    </form>
  </div>
</nav>

<div class="container mt-5">
    <a href="inicio.php" class="btn btn-custom">Inicio</a>
</div>

<div class="container mt-5">
    <h1 class="mb-4">Gestión de Productos</h1>
    <form method="get" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Buscar por nombre o código..." value="<?= htmlspecialchars($search) ?>">
            <button class="btn btn-primary">Buscar</button>
        </div>
    </form>
    <table class="table table-bordered">
    <thead>
        <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Descripción</th>
            <th>Cantidad</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['code'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= number_format($row['price'], 2) ?></td>
                <td><?= htmlspecialchars($row['description']) ?></td>
                <td><?= $row['quantity'] === null ? '---' : $row['quantity'] ?></td>
                <td>
                    <!-- Ícono de lápiz para modificar producto -->
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#updateModal" 
                            data-id="<?= $row['code'] ?>" 
                            data-name="<?= htmlspecialchars($row['name']) ?>" 
                            data-price="<?= $row['price'] ?>" 
                            data-description="<?= htmlspecialchars($row['description']) ?>" 
                            data-quantity="<?= $row['quantity'] ?>">
                        <i class="fas fa-pencil-alt"></i> <!-- Ícono de lápiz -->
                    </button>
                    <!-- Ícono de X para eliminar producto -->
                    <button class="btn btn-danger btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#deleteModal"
                            data-id="<?= $row['code'] ?>"> 
                        <i class="fas fa-times"></i> <!-- Ícono de X -->
                    </button>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">Agregar Producto</button>
</div>
<!-- Modal para modificar producto -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="productCode" id="updateProductCode">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Modificar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Precio</label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Descripción</label>
                        <input type="text" class="form-control" id="description" name="description" required>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Cantidad</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var updateModal = document.getElementById('updateModal');
        updateModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; // Botón que activó el modal
            var productCode = button.getAttribute('data-id');
            var productName = button.getAttribute('data-name');
            var productPrice = button.getAttribute('data-price');
            var productDescription = button.getAttribute('data-description');
            var productQuantity = button.getAttribute('data-quantity');

            // Poner los valores dentro de los campos del modal
            var modalProductCode = updateModal.querySelector('#updateProductCode');
            var modalName = updateModal.querySelector('#name');
            var modalPrice = updateModal.querySelector('#price');
            var modalDescription = updateModal.querySelector('#description');
            var modalQuantity = updateModal.querySelector('#quantity');

            modalProductCode.value = productCode;
            modalName.value = productName;
            modalPrice.value = productPrice;
            modalDescription.value = productDescription;
            modalQuantity.value = productQuantity;
        });
    });
</script>

<!-- Modal para agregar producto -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post">
            <input type="hidden" name="action" value="add">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Agregar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Precio</label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Descripción</label>
                        <input type="text" class="form-control" id="description" name="description" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal para confirmar eliminación -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="productCode" id="deleteProductCode">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Eliminar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Realmente quieres eliminar este producto?
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Configurar modal de eliminación
        var deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var productCode = button.getAttribute('data-id');
            var modalProductCode = deleteModal.querySelector('#deleteProductCode');
            modalProductCode.value = productCode;
        });
    });
</script>
</body>
</html>