
// Selecciona todos los botones con la clase 'descargar-tabla-btn'
const descargarBotones = document.querySelectorAll('.descargar-tabla-btn');

// Itera sobre cada botón y añade el listener
descargarBotones.forEach(boton => {
    boton.addEventListener('click', function() {
        // Obtiene el ID de la tabla desde el atributo 'data-target-id'
        const tablaId = this.dataset.targetId;
        if (!tablaId) {
            console.error('El botón no tiene el atributo "data-target-id" para especificar la tabla.');
            return;
        }

        const tabla = document.getElementById(tablaId);
        if (!tabla) {
            console.error(`No se encontró la tabla con el ID: "${tablaId}"`);
            return;
        }

        // Obtiene el nombre del archivo desde 'data-filename', con un valor por defecto
        const filename = this.dataset.filename || 'tabla.png';

        html2canvas(tabla).then(canvas => {
            canvas.toBlob(function(blob) {
                const url = URL.createObjectURL(blob);
                const enlace = document.createElement("a");
                enlace.download = filename;
                enlace.href = url;
                document.body.appendChild(enlace);
                enlace.click();
                document.body.removeChild(enlace);
                URL.revokeObjectURL(url);
            }, 'image/png');
        });
    });
});