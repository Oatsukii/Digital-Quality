var application_empresas = new Vue({

    el:'#s-empresa',

    data(){
      return {

        modoAgregar : true,
        tituloModal : '',
        modalEmpresa:false,
        EmpresaCollection:'',
        modoAgregar : true,

        hiddenId:null,
        nombre:'',
        descripcion:'',
        activo:true,
        s_contexto:'',
        id_adempiere:'',
      
      }

    },
    methods:{

        listar(){
            let t = this;
            const params = {
                accion :'tabla',
            };
            axios.post('../controladores/c_s_empresa.php',params).then(function (response){
            
                t.EmpresaCollection=response.data ;
            
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
                descripcion:this.descripcion,
                activo:this.activo,
                s_contexto:this.s_contexto,
                id_adempiere:this.id_adempiere,
                accion:'agregar',
            };
            axios.post('../controladores/c_s_empresa.php',params)
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
                descripcion:this.descripcion,
                activo:this.activo,
                s_contexto:this.s_contexto,
                id_adempiere:this.id_adempiere,
                accion:'editar',
            };
        
            axios.post('../controladores/c_s_empresa.php',params)
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
                        axios.post('../controladores/c_s_empresa.php',params)
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
            this.modalEmpresa = true;
            if(modo == 'agregar'){
                this.tituloModal = 'Agregar';
            } else {
                this.modoAgregar = false;
                this.tituloModal= 'Editar';
                this.nombre = row.nombre;
                this.descripcion = row.descripcion;
                this.activo = row.activo;
                this.s_contexto = row.s_contexto;
                this.id_adempiere = row.id_adempiere_empresa;
                this.hiddenId = row.id_s_empresa;
                
            }
        },

        cerrarModal(){
            this.modalEmpresa = false;
            this.nombre = '';
            this.descripcion = '';
            this.activo = true;
            this.s_contexto = '';
            this.id_adempiere = '';
            this.modoAgregar = true;

        },


    },

   mounted() {
    this.listar();
  },   

 });

