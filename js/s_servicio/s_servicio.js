var application_servicios = new Vue({

    el:'#s-servicio',

    data(){
      return {

        modoAgregar : true,
        tituloModal : '',
        modalServicios:false,
        modalUrl:false,
        ServicioCollection:'',
        ProcesosCollection: '',
        ConexionCollection: '',
        urlsCollection: '',
        modoAgregar : true,

        selectEmpresa: '',
        producto: 'sinc_producto.php' ,
        productoldm: 'sinc_producto_ldm.php' ,
        maquila: 'sinc_maquila.php' ,

        id_s_proceso : null,

        hiddenId:null,
        nombre:'',
        url:'',
        ruta:'',
        activo:true,
        archivo: '',
        servicio: '',
        id_s_conexion: '',
        nombreProceso: null,
        obtener_url: '',
        obtener_ruta: '',
        obtener_conexion: '',
      
      }

    },
    methods:{

        listar(){
            let t = this;

            const params = {
                accion :'tabla',
            };
            axios.post('../controladores/c_s_servicios.php',params).then( (response) =>{
            
                t.ServicioCollection=response.data ;
                this.listarUrls();
            }).catch(function (error) {
                console.log(error);
            });

        },

        listarUrls(){
            let t = this;

            const params = {
                accion :'listarUrls',
            };
            axios.post('../controladores/c_s_servicios.php',params).then( (response) =>{
            
                t.urlsCollection=response.data ;
            
            }).catch(function (error) {
                console.log(error);
            });

        },

        // ********************* ServicioUsuario *********************//

        obtenerParametros(){
            const valores = window.location.search;
            const urlParams = new URLSearchParams(valores);
            var parametro = urlParams.get('action');
            this.id_s_proceso = parametro;
            this.datosProceso();
        },

        datosProceso(){
            
            let t = this;
            const params = {
                accion :'procesoMuestra',
                id_s_proceso: this.id_s_proceso
            };
            axios.post('../controladores/c_s_proceso_costo.php',params).then(function (response){
            
                t.ProcesosCollection=response.data ;

                for (let index = 0; index < t.ProcesosCollection.length; index++) {
                    const element = t.ProcesosCollection[index];
                    this.nombreProceso = element.nombre;
                }
                
            }).catch(function (error) {
                console.log(error);
            });
        },

        // ********************* ServicioUsuario *********************//

        // ********************* ServicioGestion *********************//


        listarConexion(){
            let t = this;
            const params = {
                accion :'listarConexion',
            };
            axios.post('../controladores/c_s_servicios.php',params).then(function (response){
            
                t.ConexionCollection=response.data ;
            
            }).catch(function (error) {
                console.log(error);
            });
        },

        comprobar(id){

            if(this.nombre != '' || this.url !='' || this.ruta != '' || this.archivo != '' || this.id_s_conexion != ''){
                if(id==1){
                    this.agregar();
                }else if(id==2){
                    this.editar();
                }

            }else{
  
                Swal.fire(
                    'Error',
                    'Favor de completar el formulario',
                    'error'
                );
            }
        },  


        agregar(){
            const params = {
                nombre:this.nombre,
                url:this.url,
                ruta: this.ruta,
                activo:this.activo,
                archivo:this.archivo,
                servicio:this.servicio,
                id_s_conexion: this.id_s_conexion,
                accion:'agregar',
            };
            axios.post('../controladores/c_s_servicios.php',params)
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
                id : this.hiddenId,
                nombre:this.nombre,
                url:this.url,
                ruta: this.ruta,
                activo:this.activo,
                archivo: this.archivo,
                servicio:this.servicio,
                id_s_conexion: this.id_s_conexion,
                accion:'editar',
            };
        
            axios.post('../controladores/c_s_servicios.php',params)
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
                        axios.post('../controladores/c_s_servicios.php',params)
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
            this.modalServicios = true;
            if(modo == 'agregar'){
                this.tituloModal = 'Agregar';
            } else {
                this.modoAgregar = false;
                this.tituloModal= 'Editar';
                this.nombre = row.nombre;
                this.url = row.url;
                this.ruta = row.ruta;
                this.activo = row.activo;
                this.archivo = row.archivo;
                this.servicio = row.servicio;
                this.id_s_conexion = row.id_s_conexion;
                this.hiddenId = row.id_s_servicio;
            }
        },

        cerrarModal(){
            this.modalServicios = false;
            this.modalUrl = false;
            this.nombre = '';
            this.url = '';
            this.ruta = '';
            this.activo = true;
            this.archivo = '';
            this.servicio = '';
            this.id_s_conexion = '';
            this.modoAgregar = true;

        },


        abrirModalUrl(url = []) {
            this.modalUrl = true;
            this.modoAgregar = false;
            this.tituloModal= 'Editar';
            this.obtener_url = url.url;
            this.obtener_ruta = url.ruta;
            this.obtener_conexion = url.id_s_conexion;
        },

        editarUrl(){
            const params = {
                url:this.obtener_url,
                ruta: this.obtener_ruta,
                conexion: this.obtener_conexion,
                accion:'editarUrl',
            };

            axios.post('../controladores/c_s_servicios.php',params)
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


    },

   mounted() {
       this.listar();
       this.listarConexion();
       this.obtenerParametros();
  },   

 });

