<?php
session_start();
include("../includes/conexion.php");
conectar();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $archivo = $_FILES['archivo'];


    // Subir archivo si existe
    $archivo_pdf = null;
    if ($archivo['error'] == 0) {
        $archivo_pdf = file_get_contents($archivo['tmp_name']);
    }

    // Insertar tarea en la base de datos
    $stmt = $con->prepare("INSERT INTO tareas (nombre, archivo) VALUES (?, ?)");

    $stmt->bind_param("sb", $nombre, $archivo_pdf);

    if ($stmt->execute()) {
        // Redirigir al index.php después de agregar la tarea
        header('Location: ../index.php');
        exit();
    } else {
        echo "Error al agregar tarea.";
    }

    $stmt->close();
    $con->close();
}
?>
