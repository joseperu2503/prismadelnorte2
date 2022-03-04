
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


scanner.addListener('scan', function(c){
    document.getElementById('text').value=c;
    document.forms[0].submit();
});