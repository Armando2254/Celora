<?php
session_start();

if (!empty($_POST["btnIniciar"])) {
    if (!empty($_POST["usuario"]) and !empty($_POST["password"])) {
        $usuario = $_POST["usuario"];
        $password = $_POST["password"];

        $sql=$conexion->query(" select * from employee where employeeNumber='$usuario' and password='$password' ");
        if ($datos=$sql->fetch_object()) {
            $_SESSION["employeeNumber"] = $datos->employeeNumber;
            $_SESSION["firstName"] = $datos->firstName;
            $_SESSION["lastName"] = $datos->lastName;
            header("Location: inicio.php");
        } else {
            echo "<div>Acceso Denegado</div>";
        }
        

    } else {
        echo "LOS CAMPOS ESTAN VACIOS";
    }
    
   
    

}

?>