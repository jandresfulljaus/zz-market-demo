const filePondStructure={refreshImages:null,container:document.getElementById("images"),instance:{},getDataImages:function(){let e=[];try{return $.each(this.instance.getFiles(),function(i,n){e.push(filePondStructure.instance.getFile(i).getFileEncodeDataURL())}),e}catch(e){return!1}},setImages:function(e,i=!1){$.each(e,function(e,i){filePondStructure.instance.addFile(i)})},setEvents:function(){this.instance.on("addfile",(e,i)=>{e?(console.error("Problema al cargar la imagen"),setTimeout(()=>{this.instance.removeFile(i.id)},2e3)):(console.log("Imagen cargada correctamente"),this.refreshImages())}),this.instance.on("removefile",(e,i)=>{e?console.error("Problema al remover la imagen"):(console.log("Imagen removida correctamente"),this.refreshImages())})},initialize:function(){FilePond.registerPlugin(FilePondPluginImagePreview,FilePondPluginImageExifOrientation,FilePondPluginFileValidateSize,FilePondPluginFileValidateType,FilePondPluginFileEncode),this.instance=FilePond.create(this.container,{labelIdle:'Arrastra y suelte la imagen o <span class="filepond--label-action">haga click aquí </span>',acceptedFileTypes:["image/jpg","image/jpeg","image/png","image/gif","image/webp","image/bmp"],multiple:!0,allowFileEncode:!0,itemInsertLocation:"after",imagePreviewHeight:135}),this.setEvents()}};