
<?php


session_start();

if (empty($_SESSION["employeeNumber"])) {
    header("Location: login.php");
}

// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "root", "celora3");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Manejo del buscador
$search = isset($_GET['search']) ? $_GET['search'] : '';
$query = "SELECT * FROM employee WHERE 
            firstName LIKE '%$search%' OR 
            lastName LIKE '%$search%' OR 
            secondLastName LIKE '%$search%' OR 
            departmentCode LIKE '%$search%' OR 
            userType LIKE '%$search%'";

$result = $conn->query($query);
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


<div class="container my-5">
    <h1 class="mb-4 text-center">Employee Management</h1>

    <!-- Barra de búsqueda y botón -->
    <div class="d-flex mb-3">
        <form class="flex-grow-1 me-2" method="GET" action="">
            <input type="text" name="search" class="form-control" placeholder="Search employees..." value="<?= htmlspecialchars($search) ?>">
        </form>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">Add Employee</button>
    </div>

    <!-- Tabla de empleados -->
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Second Last Name</th>
                <th>Department</th>
                <th>User Type</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['employeeNumber'] ?></td>
                    <td><?= htmlspecialchars($row['firstName']) ?></td>
                    <td><?= htmlspecialchars($row['lastName']) ?></td>
                    <td><?= htmlspecialchars($row['secondLastName']) ?></td>
                    <td><?= htmlspecialchars($row['departmentCode']) ?></td>
                    <td><?= htmlspecialchars($row['userType']) ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center">No employees found.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal para agregar empleado -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="add_employee.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEmployeeModalLabel">Add Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" name="firstName" required>
                    </div>
                    <div class="mb-3">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="lastName" required>
                    </div>
                    <div class="mb-3">
                        <label for="secondLastName" class="form-label">Second Last Name</label>
                        <input type="text" class="form-control" name="secondLastName">
                    </div>
                    <div class="mb-3">
                        <label for="departmentCode" class="form-label">Department Code</label>


                        <select class="form-control" name="departmentCode" required>
        <option value="" disabled selected>Seleccione un departamento</option>
        <?php
        include 'conexion_bd.php';
        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }
        
        // Obtener los departamentos
        $sql = "SELECT code, name FROM department";
        $result = $conexion->query($sql);
        
        
        if ($result->num_rows > 0) {
            // Recorrer los resultados y crear opciones
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . htmlspecialchars($row['code']) . "'>" . htmlspecialchars($row['name']) . "</option>";
            }
        } else {
            echo "<option value='' disabled>No hay departamentos disponibles</option>";
        }
        ?>
    </select>
                        
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Employee</button>
                </div>
            </form>
        </div>
    </div>
</div>


    <!-- Footer -->
    <footer class="text-center py-3 border-top">
        <small>&copy; 2024 Empresa. Todos los derechos reservados.</small>
    </footer>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body> 
</html>

