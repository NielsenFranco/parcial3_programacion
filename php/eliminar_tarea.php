<?php
session_start();
include("../includes/conexion.php");
conectar();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Verifica si la tarea existe y no está eliminada ni completada
    $stmt = $con->prepare("SELECT * FROM tareas WHERE id = ? AND eliminado = FALSE");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Marcar tarea como eliminada
        $stmt = $con->prepare("UPDATE tareas SET eliminado = TRUE WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "success";  // Retorna success si la tarea fue eliminada
        } else {
            echo "Error al eliminar la tarea. Por favor, intente de nuevo.";  // Mensaje de error
        }
    } else {
        echo "La tarea no existe o ya está eliminada.";  // Mensaje si la tarea ya está eliminada
    }

    $stmt->close();
    $con->close();
} else {
    echo "ID de tarea no proporcionado.";
}
?>
