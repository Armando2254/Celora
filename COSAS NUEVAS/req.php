<?php
session_start();

if (empty($_SESSION["employeeNumber"])) {
    header("Location: login.php");
}

$hola = $_SESSION["employeeNumber"];
$adios = $_SESSION["departmentCode"];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Título de tu página</title>
    

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
   
    <link href="css/estilosReq.css" rel="stylesheet" >
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
<!--AQUI EMPIEZA LO DEL BODY QUE NO ES UN NAVBAR-->




<div class="container my-5">
    <div class="row">
        <?php
        include "conexion_bd.php";
        // Suponiendo que tienes una conexión a la base de datos
        $query = "SELECT id, description, status, requester FROM requisition";
        $result = $conexion->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if($row['requester'] == $hola || $adios == 'COMPR'){
                echo '
                <div class="col-md-4 mb-3">
                    <div class="card ola" data-id="' . $row['id'] . '" style="cursor: pointer;">
                        <div class="card-body">
                            <h5 class="card-title">Requisición #' . $row['id'] . '</h5>
                            <p class="card-text">' . $row['description'] . '</p>
                                            
<p class="card-text" style="color: ' . (($row['status'] == 'Reject' || $row['status'] == 'Pending') ? 'red' : '#50C878') . ';">' . $row['status'] . '</p>





                            </div>
                    </div>
                </div>';
                }
            }
        }
        ?>
        <!--Este es la parte de la creacion de una nueva requisicion-->
        <div class="col-md-4">
                    <div class="card mb-4 shadow-sm" onclick="mostrarModal()">
                        <div class="card-body">
                            <h5 class="card-title">AGREGAR UNA NUEVA REQUISICION</h5>
                            <p class="card-text">Pulse para crear una nueva requisicion</p>
                            <p class="card-text text-muted"></p>
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
                <div id="requisitionDetails"></div>

                <!-- Botón para eliminar requisición -->
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Eliminar Requisición</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label for="requisicionId" class="form-label">Número de requisición a eliminar</label>
            <input type="number" id="requisicionId" class="form-control" placeholder="Escriba el número de requisición" required>
          </div>
          <button type="button" id="eliminarBtn" class="btn btn-danger">Eliminar</button>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Modal (ventana emergente) -->
<div id="myModal" class="molde">
    <div class="molde-content">
        <span class="close" onclick="cerrarModal()">&times;</span>
        
        

        
        <?php
// Incluir conexión a la base de datos
include 'conexion_bd.php';

// Funciones para obtener datos dinámicos
function obtenerFolio($conexion) {
    $query = "SELECT MAX(id) + 1 AS nuevoFolio FROM requisition";
    $result = $conexion->query($query);
    if ($row = $result->fetch_assoc()) {
        return $row['nuevoFolio'] ?? 1; // Si no hay registros, empezar en 1
    }
    return 1;
}

function obtenerProductos($conexion) {
    $query = "SELECT code, name FROM product";
    $result = $conexion->query($query);
    $options = "";
    while ($row = $result->fetch_assoc()) {
        $options .= "<option value=\"{$row['code']}\">{$row['name']}</option>";
    }
    return $options;
}

// Ahora puedes usar obtenerFolio() y obtenerProductos() en el HTML
?>









        
        <h1>Crear Requisición</h1>
        <form id="requisitionForm" method="POST" action="procesar_requisicion.php">
            <!-- Campo de folio -->
            <div class="mb-3">
                <label for="folio" class="form-label">Folio</label>
                <input type="text" id="folio" name="folio" class="form-control" value="<?php echo obtenerFolio($conexion); ?>" readonly>
            </div>

            <!-- Lista de productos -->
            <div id="productos-container">
                <div class="producto-item row g-3 align-items-center">
                    <div class="col-md-6">
                        <label for="producto-1" class="form-label">Producto</label>
                        <select name="productos[]" id="producto-1" class="form-select">
                            <?php echo obtenerProductos($conexion); ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="cantidad-1" class="form-label">Cantidad</label>
                        <input type="number" name="cantidades[]" id="cantidad-1" class="form-control" min="1" value="1" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-sm eliminar-producto" disabled>Eliminar</button>
                    </div>
                </div>
            </div>

            <!-- Botón para añadir otro producto -->
            <div class="mb-3">
                <button type="button" id="agregarProducto" class="btn btn-primary btn-sm">Añadir otro producto</button>
            </div>

            <!-- Descripción -->
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea name="descripcion" id="descripcion" class="form-control" rows="3" required></textarea>
            </div>

            <!-- Fecha actual -->
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="text" id="fecha" name="fecha" class="form-control" value="<?php echo date('Y-m-d'); ?>" readonly>
            </div>

            <!-- Botón de enviar -->
            <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success">Crear Requisición</button>
                    </div>
        </form>
    

 



        














        
    </div>
</div>




























    <!-- Footer -->
    <footer class="text-center py-3 border-top">
        <small>&copy; 2024 Empresa. Todos los derechos reservados.</small>
    </footer>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
<script src="js/funcReq.js"></script>
<script>
        document.addEventListener("DOMContentLoaded", function () {
            const productosContainer = document.getElementById("productos-container");
            const agregarProductoBtn = document.getElementById("agregarProducto");

            agregarProductoBtn.addEventListener("click", () => {
                const productoCount = productosContainer.children.length + 1;

                // Crear nuevo grupo de campos
                const newProductoItem = document.createElement("div");
                newProductoItem.classList.add("producto-item", "row", "g-3", "align-items-center");
                newProductoItem.innerHTML = `
                    <div class="col-md-6">
                        <label for="producto-${productoCount}" class="form-label">Producto</label>
                        <select name="productos[]" id="producto-${productoCount}" class="form-select">
                            <?php echo obtenerProductos($conexion); ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="cantidad-${productoCount}" class="form-label">Cantidad</label>
                        <input type="number" name="cantidades[]" id="cantidad-${productoCount}" class="form-control" min="1" value="1" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-sm eliminar-producto">Eliminar</button>
                    </div>
                `;

                productosContainer.appendChild(newProductoItem);
                actualizarBotonesEliminar();
            });

            productosContainer.addEventListener("click", (event) => {
                if (event.target.classList.contains("eliminar-producto")) {
                    const productoItem = event.target.closest(".producto-item");
                    if (productosContainer.children.length > 1) {
                        productoItem.remove();
                        actualizarBotonesEliminar();
                    }
                }
            });

            function actualizarBotonesEliminar() {
                const botonesEliminar = document.querySelectorAll(".eliminar-producto");
                botonesEliminar.forEach((btn) => {
                    btn.disabled = productosContainer.children.length <= 1;
                });
            }
        });




    




// Abre el modal al hacer clic en el botón
const eliminarBtn = document.getElementById('eliminarBtn');
    const modalEliminar = new bootstrap.Modal(document.getElementById('modalEliminar'));
    const requisicionSelect = document.getElementById('requisicionSelect');

    eliminarBtn.onclick = function() {
      modalEliminar.show(); // Usamos .show() para abrir el modal
      cargarRequisiciones(); // Cargar requisiciones al abrir el modal
    }

    // Función para cargar las requisiciones en el select
// Función para abrir el modal
function abrirModal() {
  // Reseteamos el campo de número de requisición
  document.getElementById('requisicionId').value = '';
  
  // Mostramos el modal
  $('#modal').modal('show');
}

// Evento cuando se hace clic en el botón "Eliminar"
// Función para abrir el modal
function abrirModal() {
  // Reseteamos el campo de número de requisición
  document.getElementById('requisicionId').value = '';
  
  // Mostramos el modal
  $('#modal').modal('show');
}

// Evento cuando se hace clic en el botón "Eliminar"
document.getElementById('eliminarBtn').addEventListener('click', function () {
  const requisicionId = document.getElementById('requisicionId').value;

  if (requisicionId) {
    // Confirmar si realmente se desea eliminar la requisición
    const confirmacion = confirm(`¿Está seguro que desea eliminar la requisición con el número ${requisicionId}?`);

    if (confirmacion) {
      // Aquí va la lógica para eliminar la requisición
      eliminarRequisicion(requisicionId);
    }
  } else {
    alert('Por favor, ingrese el número de requisición.');
  }
});

// Función que simula la eliminación de la requisición
function eliminarRequisicion(requisicionId) {
  // Enviar la solicitud al servidor para eliminar la requisición
  fetch(`/eliminar_requisicion.php?id=${requisicionId}`, {
    method: 'DELETE',
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      alert(`Requisición ${requisicionId} eliminada correctamente.`);
      $('#modal').modal('hide'); // Cerrar el modal después de eliminar
    } else {
      alert('Hubo un error al eliminar la requisición.');
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('Hubo un error en la solicitud.');
  });
}


    </script>


</body> 
</html>
