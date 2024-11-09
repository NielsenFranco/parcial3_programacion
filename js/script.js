function completarTarea(id) {
    fetch(`php/completar_tarea.php?id=${id}`)
        .then(response => response.text())
        .then(data => {
            if (data === 'success') {
                alert("Tarea completada");
                location.reload();
            } else {
                alert(data);  // Muestra el mensaje de error recibido desde PHP
            }
        })
        .catch(error => alert("Error en la solicitud: " + error));
}

function eliminarTarea(id) {
    fetch(`php/eliminar_tarea.php?id=${id}`)
        .then(response => response.text())
        .then(data => {
            if (data === 'success') {
                alert("Tarea eliminada");
                location.reload();
            } else {
                alert(data);  // Muestra el mensaje de error recibido desde PHP
            }
        })
        .catch(error => alert("Error en la solicitud: " + error));
}
