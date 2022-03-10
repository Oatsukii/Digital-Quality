var application_usuario = new Vue({

    el:'#DatosInterfazGeneral',
    data(){
      return {

      busqueda: '',
      //tablaUsuario:'',
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



      // listadoProceso(){
      //   let t = this;
      //   const params = {
      //     accion:'tabla',
      //     activo:true
      //   };
      //   axios.post('../controladores/interfaz_proceso.php',params).then(function (response){

      //     t.tablaProcesoInterfaz= response.data ;
      //     //console.log(this.arrayUsuarios);

      //   })
      //   .catch(function (error) {
      //     console.log(error);
      //   });
      // },


      // async listadoProcesov2(){ 

      //   let t = this;
      //   const params = {
      //     accion:'tablaProceso',
      //     idempresa: this.empresa,
      //     activo: true,
      //   };

      //   await 
      //   axios.post("../controladores/interfaz_general.php",params).then(function (response) {

      //     t.tablaProcesoInterfaz= response.data ;
          
      //   }).catch(function (response) { 
      //     t.tablaProcesoInterfaz= response.data ;
        
      //   });
  
      // },


       listadoProceso(){
        let t = this;
        const params = {
          accion:'tablaProceso',
          idempresa: this.empresa,
          activo: true,
        };
        
        axios.post('../controladores/interfaz_general.php',params).then(function (response){
          //console.log(response.data);
          t.tablaProcesoInterfaz=response.data ;

        })
        .catch(function (error) {
          console.log(error);
        });
      },

      async ejecutarProceso(row = []){ 

        //console.log(row)

        let t = this;
        const params = {
          accion: row.metodo,
          conexion: row.conexion,
        };

        await 
        axios.post("../controladores/sincronizacion.php",params).then(function (response) {

          //console.log(response.data);

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


      // ejecutarProceso(row = []){

      //   const params = {
      //     accion: row.metodo,
      //     conexion: row.conexion,
      //   };
        
      //   Swal.fire({
      //     title: 'Sincronización',
      //     text: "¿Estas seguro de sincronizar?",
      //     type: 'warning',
      //     showCancelButton: true,
      //     confirmButtonColor: '#3085d6',
      //     cancelButtonColor: '#d33',
      //     confirmButtonText: 'Si',
      //     allowEscapeKey: false,
      //     allowOutsideClick: false,
      //     showConfirmButton: false,
          
          
      //   }).then((result) => {
  
      //      Swal.fire({
      //         title: "Sincronizando...",
      //         text: "Espere por favor",
      //         imageUrl: "../image/cloud_load.gif",
      //         allowEscapeKey: false,
      //         allowOutsideClick: false,
      //         showConfirmButton: false,
  
      //       });
  
  
      //     if (result.value) {
      //       axios.post('../controladores/sincronizacion.php',params)
      //       .then((response)=>{ 
      //         //console.log(response.data);
  
      //         if(response.data == true){
      //             Swal.fire(
      //             'Correcto',
      //             'Sincronización Correcta.',
      //             'success'
      //           );
  
      //         }else{
      //           //console.log(response.data.errorInfo);
      //           Swal.fire(
      //             'error',
      //             'No se puede sincronizar.'+ "<br/>" + response.data.errorInfo,
      //             'error'
      //           );
                
      //         }
  
      //       });  
      //     }
  
      //   })
      // },
           
    },
    
    mounted() {
      this.obtenerEmpresa();
      //this.listadoProceso();
    },


 });

