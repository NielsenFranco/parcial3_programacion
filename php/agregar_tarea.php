<?php
session_start();
include("../includes/conexion.php");
conectar();

$response = [];

if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
    $nombre_archivo = null;

    // Verificar si hay un archivo adjunto
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == 0) {
        $fileTmpPath = $_FILES['archivo']['tmp_name'];
        $fileName = $_FILES['archivo']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Validar que el archivo sea un PDF
        if ($fileExtension == 'pdf') {
            $nombre_archivo = uniqid() . '.pdf';
            $destino = "../tareas/" . $nombre_archivo;

            if (move_uploaded_file($fileTmpPath, $destino)) {
                $response['archivo_exito'] = true;
                $response['archivo_mensaje'] = "Archivo PDF cargado exitosamente.";
            } else {
                $response['archivo_exito'] = false;
                $response['archivo_mensaje'] = "Error al mover el archivo al servidor.";
            }
        } else {
            $response['archivo_exito'] = false;
            $response['archivo_mensaje'] = "Solo se permiten archivos PDF.";
        }
    }

    // Insertar la tarea en la base de datos con fecha actual
    $stmt = $con->prepare("INSERT INTO tareas (nombre, archivo, fecha) VALUES (?, ?, NOW())");
    $stmt->bind_param("ss", $nombre, $nombre_archivo);
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = "Tarea agregada correctamente.";
    } else {
        $response['success'] = false;
        $response['message'] = "Error al guardar la tarea.";
    }

    $stmt->close();
    $con->close();

    // Redireccionar a index.php si la tarea fue agregada exitosamente
    if ($response['success']) {
        echo "<script>alert('{$response['message']}'); window.location.href = '../index.php';</script>";
    } else {
        echo "<script>alert('{$response['message']}'); window.location.href = '../index.php';</script>";
    }
} else {
    $response['success'] = false;
    $response['message'] = "Nombre de tarea no proporcionado.";
    echo "<script>alert('{$response['message']}'); window.location.href = '../index.php';</script>";
}
?>
