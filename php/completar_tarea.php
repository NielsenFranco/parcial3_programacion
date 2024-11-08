<?php
$id = $_GET['id'];

session_start();
include("../includes/conexion.php");
conectar();

// Marcar tarea como completada
$stmt = $conn->prepare("UPDATE tareas SET completada = TRUE WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

// Insertar en tareas completadas
$stmt2 = $conn->prepare("INSERT INTO tareas_completadas (id, nombre) SELECT id, nombre FROM tareas WHERE id = ?");
$stmt2->bind_param("i", $id);
$stmt2->execute();

$conn->close();
?>
