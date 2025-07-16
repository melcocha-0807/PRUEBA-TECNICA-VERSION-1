// Archivo principal JS para la aplicación POS
// Puedes agregar aquí lógica de AJAX, manejo de formularios, etc.

// Ejemplo: Mostrar mensaje de éxito si existe
$(document).ready(function() {
    if ($('.alert-success').length) {
        setTimeout(function() {
            $('.alert-success').fadeOut();
        }, 3000);
    }
});

// Ejemplo de función para enviar un formulario por AJAX usando fetch
// function enviarVentaPorAjax(data) {
//     fetch('/api/sales', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json',
//             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
//         },
//         body: JSON.stringify(data)
//     })
//     .then(response => response.json())
//     .then(data => {
//         // Manejar respuesta
//     });
// }
