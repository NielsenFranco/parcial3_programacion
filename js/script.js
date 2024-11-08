// Función para completar tarea usando AJAX
function completarTarea(id) {
    fetch(`completar_tarea.php?id=${id}`)
        .then(response => response.text())
        .then(data => {
            if (data === "success") {
                alert("Tarea completada!");
                location.reload();  // Recarga la página para mostrar los cambios
            } else {
                alert(data);  // Mostrar el mensaje de error devuelto por PHP
            }
        })
        .catch(error => {
            console.error('Error en la solicitud:', error);
            alert("Hubo un problema al completar la tarea.");
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
                alert(data);  // Mostrar el mensaje de error devuelto por PHP
            }
        })
        .catch(error => {
            console.error('Error en la solicitud:', error);
            alert("Hubo un problema al eliminar la tarea.");
        });
}
