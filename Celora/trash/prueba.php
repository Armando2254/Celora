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
    

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
   
    <link href="css/estilosReq.css" rel="stylesheet" >

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


<!--AQUI EMPIEZA LO DEL BODY QUE NO ES UN NAVBAR-->




<div class="container my-5">
    <div class="row">
        <?php
        include "conexion_bd.php";
        // Suponiendo que tienes una conexión a la base de datos
        $query = "SELECT id, description FROM requisition";
        $result = $conexion->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '
                <div class="col-md-4 mb-3">
                    <div class="card ola" data-id="' . $row['id'] . '" style="cursor: pointer;">
                        <div class="card-body">
                            <h5 class="card-title">Requisición #' . $row['id'] . '</h5>
                            <p class="card-text">' . $row['description'] . '</p>
                        </div>
                    </div>
                </div>';
            }
        }
        ?>
        <!--Este es la parte de la creacion de una nueva requisicion-->
        <div class="col-md-4">
                    <div class="card mb-4 shadow-sm" onclick="mostrarModal()">
                        <div class="card-body">
                            <h5 class="card-title">AGREGAR UNA NUEVA REQUISICION</h5>
                            <p class="card-text">aVER SI JALA</p>
                            <p class="card-text text-muted">ajskkajskja</p>
                        </div>
                    </div>
                </div>
    </div>






    
</div>

<!-- Modal Bootstrap -->
<div class="modal fade" id="requisitionModal" tabindex="-1" aria-labelledby="requisitionModalLabel" aria-hidden="true"  data-bs-backdrop="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="requisitionModalLabel">Detalle de Requisición</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-content">
                <!-- Aquí se cargará el contenido dinámico -->
            </div>
        </div>
    </div>
</div>




            

<!-- Modal (ventana emergente) -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="cerrarModal()">&times;</span>
        
        
auisuasi


        
    </div>
</div>




























    <!-- Footer -->
    <footer class="text-center py-3 border-top">
        <small>&copy; 2024 Empresa. Todos los derechos reservados.</small>
    </footer>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
<script src="js/funcReq.js"></script>


</body> 
</html>
