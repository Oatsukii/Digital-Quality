var app_Rol_Interfaz = new Vue({

    el:'#DatosRolInterfaz',
    data(){
      return {

      rol: null,
      tablaProcesoInterfaz:[],

      datosEncabezado:'',
      tablaLineas:'',

      comboEmpresa :'',
      empresa:0,

      comboInterfaz :'',
      interfaz:0,

    }
      
    },
    methods:{

      obtenerParametros(){
        const valores = window.location.search;
        const urlParams = new URLSearchParams(valores);
        var parametro = urlParams.get('action');
        this.rol = parametro;
        
      },

      listarDatosRol(){
        let t =  this;
        const params = {
          accion:'tablaRol'
          ,id:this.rol,
        };
        
        axios.post('../controladores/rol.php',params).then(function (response){
          t.datosEncabezado=response.data ;

        })
        .catch(function (error) {
          console.log(error);
        });
      },

      obtenerInterfazEmpresa(){
        let l = this;
        const params = {
          accion:'tabla',
          activo:true
        };
        
        axios.post('../controladores/servidor_origen.php',params).then(function (response){
          l.comboEmpresa=response.data ;

        })
        .catch(function (error) {
          console.log(error);
        });
      }, 

      comboListadoInterfazEmpresa(){
        let l = this;
        const params = {
          accion:'busquedaCombo',
          empresa:this.empresa,
          rol:this.rol,
          activo:true
        };
        
        axios.post('../controladores/rol_interfaz.php',params).then(function (response){
          l.comboInterfaz=response.data ;

        })
        .catch(function (error) {
          console.log(error);
        });
      }, 

      listadoInterfazEmpresa(){
        let t = this;
        const params = {
          accion:'tablaInterfazEmpresa',
          rol: this.rol,
          activo: true,
        };
        
        axios.post('../controladores/rol_interfaz.php',params).then(function (response){
          t.tablaProcesoInterfaz=response.data ;

        })
        .catch(function (error) {
          console.log(error);
        });
      },


      agregar(){

        const params = {
          rol : this.rol,
          interfaz : this.interfaz,
          accion:'agregar',
        };

        axios.post('../controladores/rol_interfaz.php',params)
        .then((response)=>{
          //console.log(response.data);
          if(response.data == true ){
            Swal.fire(
              'Exito!',
              'Registro Agregado.',
              'success'
            )
            this.listadoInterfazEmpresa();
            this.empresa = 0;
            this.interfaz = 0;

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
            axios.post('../controladores/rol_interfaz.php',params)
            .then((response)=>{ 
              //console.log(response.data);
  
              if(response.data == true){
                  Swal.fire(
                  'Correcto',
                  'Registro Eliminado.',
                  'success'
                );
                this.listadoInterfazEmpresa();
                this.empresa = 0;
                this.interfaz = 0;  
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
      this.obtenerParametros();
      this.listarDatosRol();
      this.obtenerInterfazEmpresa();
      this.listadoInterfazEmpresa();
      //this.listadoProceso();
    },


 });

