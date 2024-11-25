<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requisiciones</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>













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
                    <div class="card" data-id="' . $row['id'] . '" style="cursor: pointer;">
                        <div class="card-body">
                            <h5 class="card-title">Requisición #' . $row['id'] . '</h5>
                            <p class="card-text">' . $row['description'] . '</p>
                        </div>
                    </div>
                </div>';
            }
        }
        ?>
    </div>
</div>

<!-- Modal Bootstrap -->
<div class="modal fade" id="requisitionModal" tabindex="-1" aria-labelledby="requisitionModalLabel" aria-hidden="true">
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











<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Manejar clic en las tarjetas
    document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('click', function () {
            const requisitionId = this.getAttribute('data-id'); // Obtener el ID de la tarjeta
            fetch(`getRequisitionDetails.php?id=${requisitionId}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('modal-content').innerHTML = data; // Cargar datos dinámicos
                    const modal = new bootstrap.Modal(document.getElementById('requisitionModal'));
                    modal.show(); // Mostrar el modal
                })
                .catch(error => console.error('Error:', error));
        });
    });
</script>











</body>
</html>
