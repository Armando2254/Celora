<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "celora3";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener requisiciones
$requisitions = $conn->query("SELECT * FROM requisition");

// Funciones adicionales para el formulario
function obtenerFolio($conn) {
    $result = $conn->query("SELECT MAX(id) + 1 AS folio FROM requisition");
    $row = $result->fetch_assoc();
    return $row['folio'] ?: 1;
}

function obtenerProductos($conn) {
    $result = $conn->query("SELECT code, name FROM product");
    $options = '';
    while ($row = $result->fetch_assoc()) {
        $options .= "<option value='{$row['code']}'>{$row['name']}</option>";
    }
    return $options;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requisiciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="images/logoCAB.png" type="images/png">
    <style>
        .card {
            background-color: #F8F9FA; /* Color hueso o blanco */
            border: 1px solid #E0E0E0;
            cursor: pointer;
        }

        .card:hover {
            background-color: #ECECEC;
        }

        .btn-custom {
            background-color: #F8F9FA;
            color: black;
        }

        .btn-custom:hover {
            background-color: #ECECEC;
        }
    </style>
</head>
<body>
<div class="container my-5">
    <div class="row">
        <?php while ($row = $requisitions->fetch_assoc()): ?>
            <div class="col-md-4 my-2">
                <div class="card p-3" data-bs-toggle="modal" data-bs-target="#modal-<?= $row['id'] ?>">
                    <div class="card-body">
                        <h5 class="card-title">Requisición #<?= $row['id'] ?></h5>
                        <p class="card-text"><?= $row['description'] ?></p>
                        <span class="badge bg-secondary"><?= $row['status'] ?></span>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="modal-<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Productos de la Requisición #<?= $row['id'] ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $products = $conn->query("
                                        SELECT p.name, pr.quantity 
                                        FROM product_requisition pr
                                        JOIN product p ON pr.productCode = p.code
                                        WHERE pr.requisitionId = " . $row['id']);
                                    if ($products->num_rows > 0):
                                        while ($product = $products->fetch_assoc()): ?>
                                            <tr>
                                                <td><?= $product['name'] ?></td>
                                                <td><?= $product['quantity'] ?></td>
                                            </tr>
                                        <?php endwhile;
                                    else: ?>
                                        <tr>
                                            <td colspan="2">No hay productos asociados a esta requisición.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php if ($row['status'] == 'Pending'): ?>
                            <div class="modal-footer">
                                <button class="btn btn-success" onclick="updateStatus(<?= $row['id'] ?>, 'Pass')">Accept</button>
                                <button class="btn btn-danger" onclick="updateStatus(<?= $row['id'] ?>, 'Reject')">Reject</button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>

        <!-- Tarjeta para Ingresar Nueva Requisición -->
        <div class="col-md-4 my-2">
            <div class="card p-3" data-bs-toggle="modal" data-bs-target="#modalNuevaRequisicion">
                <div class="card-body text-center">
                    <h5 class="card-title">+ Ingresar Nueva Requisición</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nueva Requisición -->
<div class="modal fade" id="modalNuevaRequisicion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva Requisición</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="requisitionForm" method="POST" action="procesar_requisicion.php">
                    <!-- Campo de folio -->
                    <div class="mb-3">
                        <label for="folio" class="form-label">Folio</label>
                        <input type="text" id="folio" name="folio" class="form-control" value="<?= obtenerFolio($conn); ?>" readonly>
                    </div>

                    <!-- Lista de productos -->
                    <div id="productos-container">
                        <div class="producto-item row g-3 align-items-center">
                            <div class="col-md-6">
                                <label for="producto-1" class="form-label">Producto</label>
                                <select name="productos[]" id="producto-1" class="form-select">
                                    <?= obtenerProductos($conn); ?>
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
                        <input type="text" id="fecha" name="fecha" class="form-control" value="<?= date('Y-m-d'); ?>" readonly>
                    </div>

                    <!-- Botón de enviar -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success">Crear Requisición</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Footer -->
    <footer class="text-center py-3 border-top">
        <small>&copy; 2024 Empresa. Todos los derechos reservados.</small>
    </footer>



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
    </script>

</body>
</html>
