var application_rol = new Vue({

    el:'#DatosRol',
    data(){
      return {

      tablaRol:'',
      modoAgregar : true,
      tituloModal : '',
      modalRol : false,
      
      hiddenId:null,
      rol:'',
      alias:'',
      checked:true,
      accion:'',

      url: 's_rol_menu.php',
      }
      
    },
    methods:{

      listar(){
        let t = this;
        const params = {
          accion:'tabla'
        };
        axios.post('../controladores/c_s_rol.php',params).then(function (response){
          //console.log(response.data);
          t.tablaRol=response.data ;

        })
        .catch(function (error) {
          console.log(error);
        });
      },

      comprobar(id){

        if(this.rol != '' && this.alias != ''){
        
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
          rol : this.rol,
          alias : this.alias,
          checked : this.checked,
          accion:'agregar',
        };

        axios.post('../controladores/c_s_rol.php',params)
        .then((response)=>{
          //console.log(response.data);
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
          rol: this.rol,
          alias : this.alias,
          checked : this.checked,
          accion:'editar',
  
        };
        
        axios.post('../controladores/c_s_rol.php',params)
        .then((response)=>{
           //console.log(response.data);
   
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
            axios.post('../controladores/c_s_rol.php',params)
            .then((response)=>{ 
              //console.log(response.data);
  
              if(response.data == true){
                  Swal.fire(
                  'Correcto',
                  'Registro Eliminado.',
                  'success'
                );
                this.listar();
  
              }else{
                //console.log(response.data.errorInfo);
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
        //console.log(row);
        this.modalRol = true;
        if(modo == 'agregar')
        {
          this.tituloModal = 'Agregar';
        }
        else
        {
          this.modoAgregar = false;
          this.tituloModal= 'Editar';
          this.rol = row.rol;
          this.alias = row.nombre;
          this.checked = row.activo;
          this.hiddenId = row.id_s_rol;
        }
    },

    cerrarModal(){
          this.modalRol = false;
          this.rol = '';
          this.alias = '';
          this.checked = true;
          this.modoAgregar = true;
    },

    },

    mounted() {
      this.listar();
    },

 });

