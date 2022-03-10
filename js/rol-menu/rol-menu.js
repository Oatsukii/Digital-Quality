var application_rol_menu = new Vue({

    el:'#DatosRolMenu',

    data(){
      return {

      datosEncabezado:'',
      comboMenu:'',
      tablaRolMenu:'',
      menu:'',

      }

    },
    methods:{

      listar(){
        let t =  this;
        let idrol =  document.getElementById("id_rol").value;

        const params = {
          accion:'tabla'
          ,id:idrol,
        };

        axios.post('../controladores/rol_menu.php',params).then(function (response){
          //console.log(response.data);
          t.tablaRolMenu=response.data ;

        })
        .catch(function (error) {
          console.log(error);
        });
      },

      listarDatosRol(){
        let t =  this;
        let idrol = document.getElementById("id_rol").value;

        const params = {
          accion:'tablaRol'
          ,id:idrol,
        };
        
        axios.post('../controladores/rol.php',params).then(function (response){
          //console.log(response.data);
          t.datosEncabezado=response.data ;

        })
        .catch(function (error) {
          console.log(error);
        });
      },

      obtenerListadoMenu(){
        let t =  this;
        const params = {
          accion:'listadoMenu'
          ,activo:true,
        };
        
        axios.post('../controladores/menu.php',params).then(function (response){
          //console.log(response.data);
          t.comboMenu=response.data ;

        })
        .catch(function (error) {
          console.log(error);
        });
      },       


      agregar(){
        let idrol = document.getElementById("id_rol").value;

        const params = {
          rol : idrol,
          menu:application_rol_menu.menu,
          accion:'agregar',
        };

        //console.log(params);

        axios.post('../controladores/rol_menu.php',params)
        .then((response)=>{
          //console.log(response.data);
          if(response.data == true ){
            Swal.fire(
              'Exito!',
              'Registro Agregado.',
              'success'
            )
            this.listar();
            this.menu = '';

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
            axios.post('../controladores/rol_menu.php',params)
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

    },

    mounted() {
      this.listar();
      this.listarDatosRol();
      this.obtenerListadoMenu();
    },

 });

