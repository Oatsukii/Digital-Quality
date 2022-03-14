var application_empresas = new Vue({

    el:'#s-empresa',

    data(){
      return {

        modoAgregar : true,
        tituloModal : '',
        modalProceso:false,
        EstadosCollection:'',
        modoAgregar : true,

        hiddenId:null,
        estado:'',
        abreviatura: '',
        activo:true,
      }

    },
    methods:{

        listar(){
            let t = this;
            const params = {
                accion :'tabla',
            };
            axios.post('../controladores/c_s_estados.php',params).then(function (response){
            
                t.EstadosCollection=response.data ;
            }).catch(function (error) {
                console.log(error);
            });

        },

        comprobar(id){

            if(this.estado != ''){
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
                estado:this.estado,
                abreviatura:this.abreviatura,
                activo:this.activo,
                accion:'agregar',
            };
            axios.post('../controladores/c_s_estados.php',params)
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
               
            });
        },     

        editar(){
            const params = {
                id : this.hiddenId,
                estado:this.estado,
                abreviatura:this.abreviatura,
                activo:this.activo,
                accion:'editar',
            };
        
            axios.post('../controladores/c_s_estados.php',params)
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
                        axios.post('../controladores/c_s_estados.php',params)
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
            this.modalProceso = true;
            if(modo == 'agregar'){
                this.tituloModal = 'Agregar';
            } else {
                this.modoAgregar = false;
                this.tituloModal= 'Editar';
                this.estado = row.estado;
                this.abreviatura = row.abreviatura;
                this.activo = row.activo;
                this.hiddenId = row.id_s_estado;
                
            }
        },

        cerrarModal(){
            this.modalProceso = false;
            this.estado = '';
            this.abreviatura = '';
            this.activo = true;
            this.modoAgregar = true;

        },


    },

   mounted() {
    this.listar();
  },   

 });

