var application_usuario = new Vue({

    el:'#DatosInterfazRol',
    data(){
      return {

      busqueda: '',
      tablaProcesoInterfaz:[],

      datosEncabezado:'',
      tablaLineas:'',

      empresa:0,
      comboEmpresa :'',

    }
      
    },
    methods:{

    async obtenerEmpresa(){
        let l = this;
        const params = {
          accion:'tabla',
          activo:true
        };
        await
        axios.post('../controladores/servidor_origen.php',params).then(function (response){
          //console.log(response.data);
          l.comboEmpresa=response.data ;

        })
        .catch(function (error) {
          console.log(error);
        });
      }, 

       listadoProceso(){
        let t = this;
        const params = {
          accion:'tablaSincronizacion',
          idempresa: this.empresa,
          activo: true,
        };
        
        axios.post('../controladores/rol_interfaz.php',params).then(function (response){
          //console.log(response.data);
          t.tablaProcesoInterfaz=response.data ;

        })
        .catch(function (error) {
          console.log(error);
        });
      },

      async ejecutarProceso(row = []){ 

        let t = this;
        const params = {
          accion: row.metodo,
          conexion: row.conexion,
        };

        await 
        axios.post("../controladores/sincronizacion.php",params).then(function (response) {

          console.log(response.data);

          if(response.data == true){
            Swal.fire(
            'Correcto',
            'Sincronización Completa de ' + row.proceso,
            'success'
          );

        }else{
          //console.log(response.data.errorInfo);
          Swal.fire(
            'error',
            'No se puedo realizar el proceso.'+ "<br/>" + response.data.errorInfo,
            'error'
          );
          
        }
          //t.tablaProcesoInterfaz= response.data ;
          
        }).catch(function (response) { 
          //t.tablaProcesoInterfaz= response.data ;
        
        });
  
      },

           
    },
    
    mounted() {
      this.obtenerEmpresa();
      //this.listadoProceso();
    },


 });

