var application_empresas = new Vue({

    el:'#s-empresa',

    data(){
      return {

        modoAgregar : true,
        tituloModal : '',
        modalProceso:false,
        ProcesosCollection:'',
        modoAgregar : true,

        hiddenId:null,
        nombre:'',
        periodo_inicio: '',
        periodo_fin: '',
        status:'',
        activo:true,
        ventanaServicios: 's_servicio.php',
      }

    },
    methods:{

        listar(){
            let t = this;
            const params = {
                accion :'tabla',
            };
            axios.post('../controladores/c_s_proceso_costo.php',params).then(function (response){
            
                t.ProcesosCollection=response.data ;
            }).catch(function (error) {
                console.log(error);
            });

        },

        comprobar(id){

            if(this.nombre != ''){
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
                periodo_inicio:this.periodo_inicio,
                periodo_fin:this.periodo_fin,
                activo:this.activo,
                status:this.status,
                accion:'agregar',
            };
            axios.post('../controladores/c_s_proceso_costo.php',params)
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
                nombre:this.nombre,
                periodo_inicio:this.periodo_inicio,
                periodo_fin:this.periodo_fin,
                activo:this.activo,
                status:this.status,
                accion:'editar',
            };
        
            axios.post('../controladores/c_s_proceso_costo.php',params)
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
                        axios.post('../controladores/c_s_proceso_costo.php',params)
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
                this.nombre = row.nombre;
                this.periodo_inicio = row.periodo_inicio;
                this.periodo_fin = row.periodo_fin;
                this.status = row.status;
                this.activo = row.activo;
                this.hiddenId = row.id_s_proceso_costo;
                
            }
        },

        cerrarModal(){
            this.modalProceso = false;
            this.nombre = '';
            this.periodo_inicio = '';
            this.periodo_fin = '';
            this.activo = true;
            this.status = '';
            this.modoAgregar = true;

        },


    },

   mounted() {
    this.listar();
  },   

 });

