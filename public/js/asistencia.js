
var btnAbrirPopup_nuevo = document.getElementById('btn-abrir-popup-nuevo');
var camera = 0;
let scanner = new Instascan.Scanner({ video : document.getElementById('preview'), mirror: false});
var numCams =0;
Instascan.Camera.getCameras().then(function(cameras) {								  
    if(cameras.length > 0){
        scanner.start(cameras[camera]);
    }
    else {
        alert('No cameras found');
    }

    numCams = cameras.length;
})

btnAbrirPopup_nuevo.addEventListener('click', function(){

    if(camera==numCams-1){
        camera=0;
    }
    else {
        camera=camera+1;
    }

  
    Instascan.Camera.getCameras().then(function(cameras) {
                        
        if(cameras.length > 0){
            scanner.start(cameras[camera]);
        }
        else {
            alert('No cameras found');
        }
    }).catch(function(e){
        console.error(e);
    });
});

const sonido = new Audio();
sonido.src = "audios/bip2.mp3"

var miFuncion = function(){

    var data = new FormData(document.getElementById('form'))
    fetch('/agregando_asistencia',{
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method:'POST',
        body: data

    }).then(response => response.json())
    .then(data => {
        console.log(data.tipo)
        if(data.tipo == 'success'){
            console.log('success')
            let mensaje = document.getElementById('mensaje');
            let ultimosRegistros = document.getElementById('ultimos-registros');
            mensaje.classList.remove('alert-danger');
            mensaje.classList.add('alert-success');
            mensaje.style.display = 'block';
            mensaje.innerHTML=data.mensaje;
            ultimosRegistros.innerHTML=data.html;
            
        }else if(data.tipo == 'error'){
            console.log('error')
            console.log(data.mensaje)
            let mensaje = document.getElementById('mensaje');
            mensaje.classList.remove('alert-success');
            mensaje.classList.add('alert-danger');
            mensaje.style.display = 'block';
            mensaje.innerHTML=data.mensaje;
        }
        document.getElementById('form').reset();
        sonido.play();
    });
    
    // $.ajax({
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     },
    //     url:'/agregando_asistencia',
    //     type:'POST',
    //     datatype:'dataString',
    //     data:$('#form').serialize(),
       
    // }).done(function(response){
    //     if(response.tipo == 'success'){
    //         $('#mensaje').removeClass('alert alert-danger');
    //         $('#mensaje').addClass('alert alert-success');
    //         $('#mensaje').show(250);
    //         $('#mensaje').html(response.mensaje);
    //         $('#ultimos-registros').html(response.html);
    //     }else if(response.tipo == 'error'){
    //         $('#mensaje').removeClass('alert alert-success');
    //         $('#mensaje').addClass('alert alert-danger');
    //         $('#mensaje').show(250);
    //         $('#mensaje').html(response.mensaje);
    //     }
        
    // }) 
   // $("#form")[0].reset();          
};

document.getElementById('registrar').addEventListener('click', miFuncion);
// document.getElementById('texto').addEventListener('change', miFuncion);

// $('#registrar').click(miFuncion);
// $('#texto').change(miFuncion);


scanner.addListener('scan', function(c){
    document.getElementById('text').value=c;
    miFuncion();
    
    sonido.play();
});

$(window).ready(function() {
    $("#form").on("keypress", function (event) {
        var keyPressed = event.keyCode || event.which;
        if (keyPressed === 13) {
            event.preventDefault();
            miFuncion();
            
        }
    });
});