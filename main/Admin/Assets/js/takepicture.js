var TakePicture =
{
    webcam: null,
    lastImage: null,
    file: null,
    fileInputId: null,
    init: function(webcam, canvas){
        webcamElement = document.getElementById(webcam);
        canvasElement = document.getElementById(canvas);
        this.webcam = new Webcam(webcamElement, 'user', canvasElement);
    },
    showForm: function(fileInputId){
        this.fileInputId = fileInputId;

        this.webcam.start()
        .then(result =>{
            $('#modal_take_picture').modal('show');
        })
        .catch(err => {
            console.log(err);
            swal({
                title: 'Error al iniciar la cámara',
                icon: 'error',
                text: 'Verifique que ha otorgado los permisos de acceso a la cámara y esta se encuentra correctamente conectada',
                buttons: {
                    confirm: "Cerrar",
                }
            });
        });
    },
    snap: function(){
        this.lastImage = this.webcam.snap();
        this.closeForm();
        setTimeout(function(){
            TakePicture.toFile().then(function(res){
                TakePicture.file = res;

                fileInput = document.getElementById(TakePicture.fileInputId);

                var dataTransfer = new DataTransfer();
                dataTransfer.items.add(TakePicture.file);
                fileInput.files = dataTransfer.files;
                setTimeout(function(){
                    $('#'+TakePicture.fileInputId).trigger("change");
                }, 500);
            });
        }, 500);
    },
    closeForm: function(){
        this.webcam.stop();
        $('#modal_take_picture').modal('hide');
    },
    toFile: function(){
        return (fetch(TakePicture.lastImage)
            .then(function(res){return res.arrayBuffer();})
            .then(function(buf){return new File([buf], 'photo', {type:'image/png'});})
        );
    }
}
