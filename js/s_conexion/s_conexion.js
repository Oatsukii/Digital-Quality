var application_conexion = new Vue({

    el:'#s-conexion',

    data(){
      return {

        modoAgregar : true,
        tituloModal : '',
        modalConexion:false,
        ConexionCollection:'',

        hiddenId:null,
        nombre_conexion:'',
        activo:true,
      
      }

    },
    methods:{

        listar(){
            let t = this;
            const params = {
                accion :'tabla',
            };
            axios.post('../controladores/c_s_conexion.php',params).then(function (response){
            
                t.ConexionCollection=response.data ;
            
            }).catch(function (error) {
                console.log(error);
            });

        },

        comprobar(id){

            if(this.nombre_conexion != '' ){
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
                nombre_conexion:this.nombre_conexion,
                activo:this.activo,
                accion:'agregar',
            };
            axios.post('../controladores/c_s_conexion.php',params)
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
                nombre_conexion:this.nombre_conexion,
                activo:this.activo,
                accion:'editar',
            };
        
            axios.post('../controladores/c_s_conexion.php',params)
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
                        axios.post('../controladores/c_s_conexion.php',params)
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
            this.modalConexion = true;
            if(modo == 'agregar'){
                this.tituloModal = 'Agregar';
            } else {
                this.modoAgregar = false;
                this.tituloModal= 'Editar';
                this.nombre_conexion = row.nombre_conexion;
                this.activo = row.activo;
                this.hiddenId = row.id_s_conexion;
                
            }
        },

        cerrarModal(){
            this.modalConexion = false;
            this.nombre_conexion = '';
            this.activo = true;
            this.modoAgregar = true;

        },


    },

   mounted() {
       this.listar();
  },   

 });

