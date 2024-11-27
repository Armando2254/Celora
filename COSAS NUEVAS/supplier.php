<?php




session_start();

if (empty($_SESSION["employeeNumber"])) {
    header("Location: login.php");
}





include 'config.php';

// Manejar filtro
$searchQuery = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $searchQuery = "WHERE legalName LIKE :search OR firstName LIKE :search OR id = :exactSearch";
}

// Consulta
$query = "SELECT id, firstName, lastName, secondLastName, legalName FROM supplier $searchQuery";
$stmt = $pdo->prepare($query);

if ($searchQuery) {
    $searchTerm = "%$search%";
    $stmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
    $stmt->bindValue(':exactSearch', $search, PDO::PARAM_INT);
}

$stmt->execute();
$suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Manejar nuevo proveedor
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_supplier'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $secondLastName = $_POST['secondLastName'] ?: null;
    $legalName = $_POST['legalName'];

    $addQuery = "INSERT INTO supplier (firstName, lastName, secondLastName, legalName) 
                 VALUES (:firstName, :lastName, :secondLastName, :legalName)";
    $addStmt = $pdo->prepare($addQuery);
    $addStmt->bindParam(':firstName', $firstName);
    $addStmt->bindParam(':lastName', $lastName);
    $addStmt->bindParam(':secondLastName', $secondLastName);
    $addStmt->bindParam(':legalName', $legalName);

    $addStmt->execute();

    // Redireccionar para evitar reenvío de formulario
    header("Location: supplier.php");
    exit;
}
?>








<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Título de tu página</title>
    

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
   
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
     <style>
        /* Estilo personalizado para el botón */
        .btn-custom {
            background-color: #50C878;
            color: white; /* Texto blanco para contraste */
        }

        .btn-custom:hover {
            background-color: #45b568; /* Color ligeramente más oscuro al pasar el mouse */
        }

        /* Asegúrate de que el modal se apile sobre otros elementos */
.modal-backdrop {
    z-index: 1040 !important; /* Esto asegura que el fondo del modal tenga un alto z-index */
}

.modal {
    z-index: 1050 !important; /* Esto asegura que el modal tenga el mayor z-index */
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














<div class="container mt-4">
    <h1 class="mb-4">Proveedores</h1>

    <!-- Botón para agregar nuevo proveedor -->
    <div class="mb-4">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addSupplierModal">Agregar Proveedor</button>
    </div>

    <!-- Formulario de búsqueda -->
    <form method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Buscar por ID o Nombre" value="<?= isset($search) ? htmlspecialchars($search) : '' ?>">
            <button class="btn btn-primary" type="submit">Buscar</button>
        </div>
    </form>

    <!-- Tabla de proveedores -->
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Nombre Fiscal</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($suppliers): ?>
            <?php foreach ($suppliers as $supplier): ?>
                <tr>
                    <td><?= htmlspecialchars($supplier['id']) ?></td>
                    <td><?= htmlspecialchars($supplier['firstName']) ?></td>
                    <td><?= htmlspecialchars($supplier['lastName']) ?></td>
                    <td><?= htmlspecialchars($supplier['secondLastName'] ?: '-') ?></td>
                    <td><?= htmlspecialchars($supplier['legalName']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="text-center">No se encontraron resultados</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal para agregar proveedor -->
<div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" onsubmit="return validateForm()">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSupplierModalLabel">Agregar Proveedor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="firstName" class="form-label">Nombre</label>
                        <input type="text" name="firstName" id="firstName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="lastName" class="form-label">Apellido Paterno</label>
                        <input type="text" name="lastName" id="lastName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="secondLastName" class="form-label">Apellido Materno</label>
                        <input type="text" name="secondLastName" id="secondLastName" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="legalName" class="form-label">Nombre Fiscal</label>
                        <input type="text" name="legalName" id="legalName" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" name="add_supplier" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function validateForm() {
    const firstName = document.getElementById('firstName').value.trim();
    const lastName = document.getElementById('lastName').value.trim();
    const legalName = document.getElementById('legalName').value.trim();

    if (!firstName || !lastName || !legalName) {
        alert('Por favor, completa todos los campos requeridos.');
        return false;
    }
    return true;
}
</script>








<footer class="text-center py-3 border-top">
        <small>&copy; 2024 Empresa. Todos los derechos reservados.</small>
    </footer>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body> 
</html>