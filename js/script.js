// Función para completar tarea usando AJAX
function completarTarea(id) {
    fetch(`completar_tarea.php?id=${id}`)
        .then(response => response.text())
        .then(data => {
            if (data === "success") {
                alert("Tarea completada!");
                location.reload();  // Recarga la página para mostrar los cambios
            } else {
                alert("Error al completar tarea.");
            }
        });
}

// Función para eliminar tarea usando AJAX (borrado lógico)
function eliminarTarea(id) {
    fetch(`eliminar_tarea.php?id=${id}`)
        .then(response => response.text())
        .then(data => {
            if (data === "success") {
                alert("Tarea eliminada!");
                location.reload();  // Recarga la página para mostrar los cambios
            } else {
                alert("Error al eliminar tarea.");
            }
        });
}

// Función para ver PDF (si la tarea tiene un archivo)
function verPDF(id) {
    window.open(`ver_pdf.php?id=${id}`, '_blank');
}
