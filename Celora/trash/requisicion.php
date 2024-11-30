<?php
session_start();

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Requisición</title>
    <style>
        /* Estilos globales */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        /* Barra de navegación */
        .navbar {
            background-color: #50C878; /* Verde esmeralda */
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .navbar img {
            height: 40px; /* Ajusta el tamaño de la imagen */
            margin-right: 20px;
        }

        .navbar ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .navbar ul li {
            margin-right: 20px;
        }

        .navbar ul li a {
            text-decoration: none;
            color: white;
            font-size: 16px;
        }

        .navbar ul li a:hover {
            text-decoration: underline;
        }

        /* Contenedor del formulario */
        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding-top: 100px; /* Espacio para que el formulario no cubra la barra */
        }

        .form-box {
            background-color: #f5f5dc; /* Color hueso */
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: left;
        }

        .form-box h2 {
            margin-bottom: 20px;
            font-size: 22px;
            color: #333;
        }

        .form-box label {
            display: block;
            margin-bottom: 10px;
            font-size: 16px;
            color: #333;
        }

        .form-box select,
        .form-box input[type="date"],
        .form-box input[type="text"],
        .form-box input[type="number"],
        .form-box textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 14px;
        }

        .form-box button {
            background-color: #50C878; /* Verde esmeralda */
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        .form-box button:hover {
            background-color: #45b96d; /* Un poco más oscuro en hover */
        }
    </style>
</head>
<body>

    <!-- Barra de navegación -->
    <div class="navbar">
        <img src="tu-imagen.png" alt="Logo">
        <ul>
            <li><a href="requisicion.php">Crear una Requisición</a></li>
            <li><a href="coti.php">Crear una Cotización</a></li>
            <li><a href="proces.html">Ver Estatus de Requisición</a></li>
            <li><a href="proces.html">Ver Productos</a></li>
            <li><a href="proces.html">Ver Proveedores</a></li>
        </ul>
    </div>

    <!-- Contenedor del formulario -->
    <div class="form-container">
        <div class="form-box">
            <h2>Formulario de Requisición</h2>

            <!-- Formulario -->
            <form method="POST" action="">
                <!-- Campo de Folio -->
                <label for="folio">Folio</label>
                <input type="text" id="folio" name="folio" value="<?php 
                    $conexion = new mysqli("localhost", "root", "nueva_contraseña", "CelorA");
                    if ($conexion->connect_error) {
                        die("Error de conexión: " . $conexion->connect_error);
                    }
                    $consulta_folio = "SELECT count(*) AS max_folio FROM requisicion";
                    $result = $conexion->query($consulta_folio);
                    $row = $result->fetch_assoc();
                    $nuevo_folio = $row['max_folio'] + 1;
                    echo $nuevo_folio;
                    $conexion->close();
                ?>" readonly>

                <!-- Campo para Cantidad -->
                <label for="cantidad">Cantidad</label>
                <input type="number" id="cantidad" name="cantidad" placeholder="Ingresa la cantidad" required>

                <!-- Menú desplegable para Número de Producto -->
                <label for="numero-producto">Número de Producto</label>
                <select id="numero-producto" name="numero_producto">
                    <?php
                    $conexion = new mysqli("localhost", "root", "", "celora");
                    if ($conexion->connect_error) {
                        die("Error de conexión: " . $conexion->connect_error);
                    }
                    $consulta_productos = "SELECT codigo, nombre FROM producto";
                    $result = $conexion->query($consulta_productos);
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['codigo'] . "'>" . $row['nombre'] . "</option>";
                    }
                    $conexion->close();
                    ?>
                </select>

                <!-- Menú desplegable para Nombre del Solicitante -->
                <label for="nombre-solicitante">Nombre del Solicitante</label>
                <select id="nombre-solicitante" name="nombre_solicitante">
                    <?php
                    $conexion = new mysqli("localhost", "root", "", "celora");
                    if ($conexion->connect_error) {
                        die("Error de conexión: " . $conexion->connect_error);
                    }
                    $consulta_empleados = "SELECT numEmpleado, nombrePila FROM empleado";
                    $result = $conexion->query($consulta_empleados);
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['numEmpleado'] . "'>" . $row['nombrePila'] . "</option>";
                    }
                    $conexion->close();
                    ?>
                </select>

                <!-- Campo de fecha que muestra solo la fecha de hoy y no permite cambios -->
                <label for="fecha">Fecha</label>
                <input type="date" id="fecha" name="fecha" value="<?php echo date('Y-m-d'); ?>" readonly>

                <!-- Campo de descripción -->
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="4" placeholder="Describe la requisición..."></textarea>

                <!-- Botón de envío -->
                <button type="submit">Enviar</button>
            </form>

            <?php
            // Lógica de inserción
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $folio = $_POST['folio'];
                $cantidad = $_POST['cantidad'];
                $numero_producto = $_POST['numero_producto'];
                $fecha = $_POST['fecha'];
                $descripcion = $_POST['descripcion'];
                $nombre_solicitante = $_POST['nombre_solicitante'];

                // Conexión a la base de datos
                $conexion = new mysqli("localhost", "root", "", "celora");
                if ($conexion->connect_error) {
                    die("Error de conexión: " . $conexion->connect_error);
                }

                // Insertar en la tabla requisicion
                $insert_requisicion = "INSERT INTO requisicion (folio, cantidadRequerida, fecha, descripcion, solicitante, autorizante) VALUES ('$folio', '$cantidad', '$fecha', '$descripcion', '$nombre_solicitante', 3)";
                
                if ($conexion->query($insert_requisicion) === TRUE) {
                    // Insertar en la tabla producto_requisicion
                    $insert_producto_requisicion = "INSERT INTO producto_requisicion (requisicion, producto) VALUES ('$folio', '$numero_producto')";
                    if ($conexion->query($insert_producto_requisicion) === TRUE) {
                        echo "Requisición creada exitosamente.";
                    } else {
                        echo "Error al insertar en producto_requisicion: " . $conexion->error;
                    }
                } else {
                    echo "Error al insertar en requisicion: " . $conexion->error;
                }

                $conexion->close();
            }
            ?>
        </div>
    </div>

</body>
</html>
