var application_empresas = new Vue({

    el:'#normas',

    data(){
      return {

        modoAgregar : true,
        tituloModal : '',
        modalCrud:false,
        categoriaCollection:'',
        modoAgregar : true,

        hiddenId:null,
        id_s_norma:'',
        id_s_empresa: '',
        descripcion: '',
        esactivo:true,
        empresaColeccion:[],
        normasColeccion: [],
        url : 's_normas_documentos_lineas.php',
      
      }

    },
    methods:{
        buscarElementos(){
            let t = this;
            const params = {
                accion :'empresas',
            };
            axios.post('../controladores/c_s_normas_documentos.php',params).then(function (response){
            
                t.empresaColeccion=response.data ;
            
            }).catch(function (error) {
                console.log(error);
            });

            const params2 = {
                accion :'normas',
            };
            axios.post('../controladores/c_s_normas_documentos.php',params2).then(function (response){
            
                t.normasColeccion=response.data ;
            
            }).catch(function (error) {
                console.log(error);
            });
        },

        listar(){
            let t = this;
            const params = {
                accion :'tabla',
            };
            axios.post('../controladores/c_s_normas_documentos.php',params).then(function (response){
            
                t.categoriaCollection=response.data ;
            
            }).catch(function (error) {
                console.log(error);
            });
        },

        comprobar(id){

            if(this.id_s_norma != '' && this.id_s_empresa != ''){
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
                id_s_norma:this.id_s_norma,
                esactivo:this.esactivo,
                id_s_empresa:this.id_s_empresa,
                descripcion:this.descripcion,
                accion:'agregar',
            };
            axios.post('../controladores/c_s_normas_documentos.php',params)
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
                id_s_norma:this.id_s_norma,
                esactivo:this.esactivo,
                id_s_empresa:this.id_s_empresa,
                descripcion:this.descripcion,
                id: this.hiddenId,
                accion:'editar',
            };
        
            axios.post('../controladores/c_s_normas_documentos.php',params)
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
                        axios.post('../controladores/c_s_normas_documentos.php',params)
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
                this.id_s_norma = row.id_s_norma;
                this.id_s_empresa = row.id_s_empresa;
                this.descripcion = row.descripcion;
                this.esactivo = row.esactivo;
                this.hiddenId = row.id_s_norma_documento;
                
            }
        },

        cerrarModal(){
            this.modalCrud = false;
            this.id_s_norma = '';
            this.id_s_empresa = '';
            this.descripcion = '';
            this.esactivo = true;
            this.modoAgregar = true;

        },


    },

   mounted() {
    this.listar();
    this.buscarElementos();
  },   

 });

