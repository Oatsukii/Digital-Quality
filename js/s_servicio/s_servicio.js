var application_servicios = new Vue({

    el:'#s-servicio',

    data(){
      return {

        modoAgregar : true,
        tituloModal : '',
        modalServicios:false,
        ServicioCollection:'',
        modoAgregar : true,

        selectEmpresa: '',
        producto: 'sinc_producto.php' ,
        productoldm: 'sinc_producto_ldm.php' ,
        maquila: 'sinc_maquila.php' ,


        hiddenId:null,
        nombre:'',
        url:'',
        activo:true,
        archivo: '',
        servicio: '',
      
      }

    },
    methods:{

        listar(){
            let t = this;
            const params = {
                accion :'tabla',
            };
            axios.post('../controladores/c_s_servicios.php',params).then(function (response){
            
                t.ServicioCollection=response.data ;
            
            }).catch(function (error) {
                console.log(error);
            });

        },

        comprobar(id){

            if(this.nombre != '' || this.url !='' || this.archivo != ''){
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
                activo:this.activo,
                archivo:this.archivo,
                servicio:this.servicio,
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
                activo:this.activo,
                archivo: this.archivo,
                servicio:this.servicio,
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
                this.activo = row.activo;
                this.archivo = row.archivo;
                this.servicio = row.servicio;
                this.hiddenId = row.id_s_servicio;
                
            }
        },

        cerrarModal(){
            this.modalServicios = false;
            this.nombre = '';
            this.url = '';
            this.activo = true;
            this.archivo = '';
            this.servicio = '';
            this.modoAgregar = true;

        },


    },

   mounted() {
       this.listar();
  },   

 });

