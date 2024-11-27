<?php
session_start(); // Inicia la sesión

// Verificar si hay una sesión activa
if (!isset($_SESSION['employeeNumber'])) {
    header("Location: login.php"); // Redirigir al login si no está autenticado
    exit();
}

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "celora3";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener datos del empleado
$employeeNumber = $_SESSION['employeeNumber'];
$sql = "SELECT e.firstName, e.lastName, e.secondLastName, d.name AS department, e.userType 
        FROM employee e
        LEFT JOIN department d ON e.departmentCode = d.code
        WHERE e.employeeNumber = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $employeeNumber);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $employee = $result->fetch_assoc();
} else {
    echo "No employee found.";
    exit();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Profile</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="css/btn.css" rel="stylesheet" >
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f8f9fa;
    color: #333;
}

header {
    background-color: #007bff;
    color: white;
    padding: 20px;
    text-align: center;
}

.profile-container {
    margin: 20px auto;
    padding: 20px;
    background-color: white;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    max-width: 600px;
    border-radius: 8px;
}

.profile-container h2 {
    margin-bottom: 20px;
    color: #007bff;
}

.profile-container p {
    margin: 10px 0;
    font-size: 1.2rem;
}

footer {
    text-align: center;
    margin-top: 20px;
    padding: 10px;
    background-color: #f1f1f1;
}

footer a {
    color: #007bff;
    text-decoration: none;
}

footer a:hover {
    text-decoration: underline;
}



    </style>
</head>
<body>
    <header>
        <h1>Welcome to Your Profile</h1>
    </header>


    <div class="container mt-5">
        <!-- Botón Inicio alineado a la izquierda -->
        <a href="inicio.php" class="btn btn-custom">Inicio</a>
      
    </div>
    <main>
        <div class="profile-container">
            <h2>Employee Information</h2>
            <p><strong>Name:</strong> <?php echo $employee['firstName'] . " " . $employee['lastName'] . " " . $employee['secondLastName']; ?></p>
            <p><strong>Department:</strong> <?php echo $employee['department']; ?></p>
            <p><strong>User Type:</strong> <?php echo $employee['userType']; ?></p>
        </div>
    </main>
    <footer>
        <a href="logout.php">Logout</a>
    </footer>
</body>
</html>
