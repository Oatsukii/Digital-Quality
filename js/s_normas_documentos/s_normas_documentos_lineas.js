var application_empresas = new Vue({

    el:'#normas_lineas',

    data(){
      return {

        modoAgregar : true,
        tituloModal : '',
        modalCrud:false,
        documentosColeccion:'',
        categoriaCollection: '',
        modoAgregar : true,

        hiddenId:null,
        id_s_norma_documento:'',
        nombre_archivo:'',
        archivo_bytea:'',
        fecha_disponible: '',
        esactivo: true,
        formato_archivo: 'application/pdf',
        actualizarArchivo: false, 

      }

    },
    methods:{
        obtenerParametros(){
            const valores = window.location.search;
            const urlParams = new URLSearchParams(valores);
            var parametro = urlParams.get('norm');
            this.id_s_norma_documento = parametro;
        },

        listar(){
            let t = this;
            const params = {
                accion:'tabla',
                id_s_norma_documento:this.id_s_norma_documento,
            };
            axios.post('../controladores/c_s_norma_documento_lineas.php',params).then(function (response){
                t.documentosColeccion=response.data ;

            }).catch(function (error) {
                console.log(error);
            });
        },

        async comprobar(id){

            if(this.nombre_archivo != ''){
                if(id==1){

                    var files = document.getElementById("file").files;
                    if (files.length < 1 || this.nombre_archivo == '' || this.fecha_disponible == '' ) { 
                        Swal.fire(
                            'error',
                            'Es obligatorio cargar un archivo y/o llenar el formulario',
                            'error'
                        );
                    } else {
                        this.cargar(files);
                        var res = await this.cargar(files);
                        this.agregar();

                    }

                }else if(id==2){
                    if(this.actualizarArchivo == true){

                        var files = document.getElementById("file").files;
                        if (files.length < 1 || this.nombre_archivo == '' || this.fecha_disponible == '') { 
                            Swal.fire(
                                'error',
                                'Es obligatorio cargar un archivo y/o  asignar un nombre',
                                'error'
                            );
                        } else {
                            await this.cargar(files);
                            this.editar();
                        }

                    } else {
                        
                        this.editar();
                    }
                }

            }else{
  
                Swal.fire(
                    'Error',
                    'Favor de completar el formulario',
                    'error'
                );
            }
        },

        async cargar(files){
            
                for (let index = 0; index < files.length; index++) {
                    const element = files[index];
                    let formData = new FormData();
                    formData.append('file', element); 
                    formData.append('type', 'file');  
                    formData.append('name', element.name);
                    const respuesta = await axios.post('../controladores/c_s_norma_documento_lineas.php',
                    formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then(function (response) {
                        return response.data;
                    }).catch(function (response) {
                        return response.data;
                    });
                    // this.nombre_archivo = respuesta.nombre_archivo;
                    return this.archivo_bytea = respuesta.archivo_bytea;
                    // this.agregar();
                }
           
        },

        agregar(){
            const params = {
                id_s_norma_documento:this.id_s_norma_documento,
                nombre_archivo:this.nombre_archivo,
                archivo_bytea:this.archivo_bytea,
                fecha_disponible:this.fecha_disponible,
                esactivo:this.esactivo,
                accion:'agregar',
            };
           
            axios.post('../controladores/c_s_norma_documento_lineas.php',params)
            .then((response)=>{
                if(response.data == true ){
                    Swal.fire(
                        'Exito!',
                        'Registro Agregado.',
                        'success'
                    )
                    this.listar();
                    this.cerrarModal();
                }
                else{

                    Swal.fire(
                        'error',
                        'No se puede agregar el registro.'+ "<br/>" + response.data.errorInfo,
                        'error'
                    );
                }
            });
        },

        editar(){
            const params = {
                id_s_norma_documento:this.id_s_norma_documento,
                nombre_archivo:this.nombre_archivo,
                archivo_bytea:this.archivo_bytea,
                fecha_disponible:this.fecha_disponible,
                esactivo:this.esactivo,
                id: this.hiddenId,
                documento : this.actualizarArchivo==false?0:1,
                accion:'editar',
            };
            console.log(params);
            axios.post('../controladores/c_s_norma_documento_lineas.php',params)
            .then((response)=>{
                if(response.data == true){
                    Swal.fire(
                        'Exito!',
                        'Registro Editado.',
                        'success'
                    );
                    this.listar();
                    this.cerrarModal();
                }else{
  
                    Swal.fire(
                        'error',
                        'No se puede editar el registro.'+ "<br/>" + response.data.errorInfo,
                        'error'
                    );
  
                }
            });		
        },

        eliminar(id){
            const params = {
                id:id,
                accion:'eliminar',
                };
        
                Swal.fire({
                    title: 'Eliminar Registro',
                    text: "¿Estas segura de eliminarlo?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si'
                }).then((result) => {
  
                    if (result.value) {
                        axios.post('../controladores/c_s_norma_documento_lineas.php',params)
                        .then((response)=>{ 
  
                        if(response.data == true){
                            Swal.fire(
                                'Correcto',
                                'Registro Eliminado.',
                                'success'
                            );
                            this.listar();

                        }else{
                            Swal.fire(
                                'error',
                                'No se puede eliminar el registro.'+ "<br/>" + response.data.errorInfo,
                                'error'
                            );
                        }
                        });  
                    }
                })
        },


        abrirModal(modo, row = []){
            this.modalCrud = true;
            if(modo == 'agregar'){
                this.tituloModal = 'Agregar';
            } else {
                this.modoAgregar = false;
                this.tituloModal= 'Editar';
                this.id_s_norma_documento = row.id_s_norma_documento;
                this.nombre_archivo = row.nombre_archivo;
                this.esactivo = row.esactivo;
                this.fecha_disponible = row.fecha_disponible;
                this.archivo_bytea = row.archivo;
                this.hiddenId = row.id_s_norma_documento_linea;
                console.log(this.archivo_bytea, this.nombre_archivo);
            }
        },

        cerrarModal(){
            this.modalCrud = false;
            input=document.getElementById("file");
            if(input != null){
                input.value = '';
            }
            this.formato_archivo = '';
            this.nombre_archivo = '';
            this.archivo_bytea = '';
            this.fecha_disponible = '';
            this.nombre_archivo ='';
            this.esactivo = true;
            this.modoAgregar = true;
            this.hiddenId = null;
            this.actualizarArchivo = false;

        },

        obtenerArchivo(encode, documento){

            const linkSource = `data:${this.formato_archivo};base64,${encode}`;
            window.open(linkSource, '_self');

           

        },

    },

    mounted() {
        this.obtenerParametros();
        this.listar();
    },   

 });

 