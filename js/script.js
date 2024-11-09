document.querySelector("form").addEventListener("submit", function (event) {
    event.preventDefault(); // Evita el envío normal del formulario

    const formData = new FormData(this);
    fetch("php/agregar_tarea.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message); // Muestra el mensaje de respuesta
        if (data.success) {
            location.reload(); // Recarga la página si la tarea se agrega exitosamente
        }
    })
    .catch(error => {
        alert("Error en la solicitud: " + error);
    });
});


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
function verPDF(id) {
    window.open("php/ver_pdf.php?id=" + id, "_blank");
}
