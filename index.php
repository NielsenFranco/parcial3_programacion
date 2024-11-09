<?php
session_start();
include("includes/conexion.php");
conectar();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Tareas</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
    <h1>Gestión de Tareas</h1>
    </header>
    <section class="main-content">
        <!-- Formulario para agregar tareas -->
        <form action="php/agregar_tarea.php" method="POST" enctype="multipart/form-data">
            <label for="nombre">Nombre de la tarea:</label>
            <input type="text" id="nombre" name="nombre" required>
            <label for="archivo">Adjuntar PDF (opcional):</label>
            <input type="file" id="archivo" name="archivo" accept="application/pdf">
            <button type="submit">Agregar Tarea</button>
        </form>

        
        <?php
            // Obtener tareas pendientes
            echo "<h2>Tareas Pendientes</h2>";
            $tareas_pendientes = $con->query("SELECT * FROM tareas WHERE completada = FALSE AND eliminado = FALSE ORDER BY fecha DESC");
            if ($tareas_pendientes->num_rows > 0) {  
                while ($tarea = $tareas_pendientes->fetch_assoc()) {
                    echo "<div class='tarea' id='tarea_".$tarea['id']."'>";
                    echo "<p><strong>" . $tarea['nombre'] . "</strong> - " . $tarea['fecha'] . "</p>";
                    if ($tarea['archivo']) {
                        echo "<button onclick='verPDF(" . $tarea['id'] . ")'>Ver PDF</button>";
                    }
                    echo "<button onclick='completarTarea(" . $tarea['id'] . ")'>Completar</button>";
                    echo "<button onclick='eliminarTarea(" . $tarea['id'] . ")'>Eliminar</button>";
                    echo "</div>";
                }
            } else {
                echo "<p>No hay tareas pendientes.</p>";
            }
        ?>
        <?php
            // Obtener tareas completadas
            echo "<h2>Tareas Completadas</h2>";
            $tareas_completadas = $con->query("SELECT nombre, fecha FROM tareas WHERE completada = TRUE AND eliminado = FALSE ORDER BY fecha DESC");
            if ($tareas_completadas->num_rows > 0) {
                while ($tarea = $tareas_completadas->fetch_assoc()) {
                    echo "<div class='tarea-completada'>";
                    echo "<p><strong>" . $tarea['nombre'] . "</strong> - " . $tarea['fecha'] . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No hay tareas completadas.</p>";
            }
        ?>
    </section>
    <script src="js/script.js"></script>
</body>
</html>
