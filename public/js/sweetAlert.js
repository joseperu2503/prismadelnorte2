(function () {
    'use strict'
    //debemos crear la clase formEliminar dentro del form del boton borrar
    //recordar que cada registro a eliminar esta contenido en un form  
    var forms = document.querySelectorAll('.formEliminar')
    Array.prototype.slice.call(forms)
    .forEach(function (form) {
        form.addEventListener('submit', function (event) {        
            event.preventDefault()
            event.stopPropagation()        
            Swal.fire({
                    title: '¿Confirma la eliminación del registro?',        
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#0bb58c',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Confirmar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                    Swal.fire('¡Eliminado!', 'El registro ha sido eliminado exitosamente.','success');
                }
            })                      
        }, false)
    })
})()