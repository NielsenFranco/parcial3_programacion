<?php
session_start();
include("../includes/conexion.php");
conectar();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Verifica si la tarea existe y no está completada ni eliminada
    $stmt = $con->prepare("SELECT * FROM tareas WHERE id = ? AND completada = FALSE AND eliminado = FALSE");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Marcar tarea como completada
        $stmt = $con->prepare("UPDATE tareas SET completada = TRUE WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "success";  // Retorna success si la tarea fue completada
        } else {
            echo "Error al completar la tarea. Por favor, intente de nuevo.";  // Mensaje de error
        }
    } else {
        echo "La tarea no existe o ya está completada/eliminada.";  // Mensaje si la tarea no existe o ya fue completada o eliminada
    }

    $stmt->close();
    $con->close();
} else {
    echo "ID de tarea no proporcionado.";
}
?>
