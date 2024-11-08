<?php
$id = $_GET['id'];

session_start();
include("../includes/conexion.php");
conectar();

// Marcar tarea como eliminada
$stmt = $conn->prepare("UPDATE tareas SET eliminado = TRUE WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$conn->close();
?>