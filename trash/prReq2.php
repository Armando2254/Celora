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



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Requisición</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
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
            <div class="mb-3">
                <button type="submit" class="btn btn-success">Crear Requisición</button>
            </div>
        </form>
    </div>

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
