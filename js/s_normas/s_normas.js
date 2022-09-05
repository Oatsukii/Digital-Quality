var application_empresas = new Vue({

    el:'#normas',

    data(){
      return {

        modoAgregar : true,
        tituloModal : '',
        modalCrud:false,
        normaColecction:'',
        modoAgregar : true,

        hiddenId:null,
        nombre_norma:'',
        esactivo:true,
      
      }

    },
    methods:{

        listar(){
            let t = this;
            const params = {
                accion :'tabla',
            };
            axios.post('../controladores/c_s_normas.php',params).then(function (response){
            
                t.normaColecction=response.data ;
            
            }).catch(function (error) {
                console.log(error);
            });
        },

        comprobar(id){

            if(this.nombre_norma != ''){
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
                nombre_norma:this.nombre_norma,
                esactivo:this.esactivo,
                accion:'agregar',
            };
            axios.post('../controladores/c_s_normas.php',params)
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
                nombre_norma:this.nombre_norma,
                esactivo:this.esactivo,
                id: this.hiddenId,
                accion:'editar',
            };
        
            axios.post('../controladores/c_s_normas.php',params)
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
                        axios.post('../controladores/c_s_normas.php',params)
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
                this.nombre_norma = row.nombre_norma;
                this.esactivo = row.esactivo;
                this.hiddenId = row.id_s_norma;
                
            }
        },

        cerrarModal(){
            this.modalCrud = false;
            this.nombre_norma = '';
            this.esactivo = true;
            this.modoAgregar = true;

        },


    },

   mounted() {
    this.listar();
  },   

 });

