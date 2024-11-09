<?php
session_start();
include("../includes/conexion.php");
conectar();

$response = [];

if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
    $archivo = $_FILES['archivo'];
    $custom_name = isset($_POST['custom_name']) ? trim($_POST['custom_name']) : '';

    if (!empty($archivo['name'])) {
        $fileTmpPath = $archivo['tmp_name'];
        $fileName = $archivo['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        $fileName = !empty($custom_name) ? preg_replace('/[^a-zA-Z0-9_-]/', '_', $custom_name) . ".pdf" : md5(time() . $fileName) . ".pdf";
        $uploadFileDir = '../tareas/';
        $dest_path = $uploadFileDir . $fileName;

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $stmt = $con->prepare("INSERT INTO tareas (nombre, archivo) VALUES (?, ?)");
            $stmt->bind_param("ss", $nombre, $fileName);
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = "Tarea agregada con archivo.";
            } else {
                $response['success'] = false;
                $response['message'] = "Error al guardar la tarea.";
            }
            $stmt->close();
        } else {
            $response['success'] = false;
            $response['message'] = "Error al mover el archivo al servidor.";
        }
    } else {
        $stmt = $con->prepare("INSERT INTO tareas (nombre) VALUES (?)");
        $stmt->bind_param("s", $nombre);
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = "Tarea agregada sin archivo.";
        } else {
            $response['success'] = false;
            $response['message'] = "Error al guardar la tarea.";
        }
        $stmt->close();
    }

    $con->close();
} else {
    $response['success'] = false;
    $response['message'] = "Nombre de tarea no proporcionado.";
}

// Devuelve la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
