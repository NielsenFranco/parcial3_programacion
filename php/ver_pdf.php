<?php
include("../includes/conexion.php");
conectar();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consultar la base de datos para obtener el archivo
    $stmt = $con->prepare("SELECT archivo FROM tareas WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $archivo = $row['archivo'];
        $filePath = "../tareas/" . $archivo;

        if (file_exists($filePath)) {
            // Forzar descarga del archivo
            header("Content-Type: application/pdf");
            header("Content-Disposition: inline; filename=" . basename($filePath));
            readfile($filePath);
            exit;
        } else {
            echo "Archivo no encontrado.";
        }
    } else {
        echo "ID de tarea no válida.";
    }

    $stmt->close();
} else {
    echo "ID de tarea no proporcionado.";
}
?>
