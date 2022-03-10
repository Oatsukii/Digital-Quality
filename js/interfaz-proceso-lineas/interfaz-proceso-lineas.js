var IDEncabezado = document.getElementById("id_principal").value;

var application_dev_almacen_lineas = new Vue({

    el:'#DatosProcesoInterfazRelacion',

    data(){
      return {

        datosEncabezado:'',
        tablaLineas:'',

        empresa:0,
        comboEmpresa :'',

      }

    },
    methods:{

      listar(){
        let t = this;
        const params = {
          accion:'tabla',
          id:IDEncabezado,
        };
        axios.post('../controladores/interfaz_proceso_relacion.php',params).then(function (response){
          //console.log(response.data);
          t.tablaLineas=response.data ;

        })
        .catch(function (error) {
          console.log(error);
        });
      },

      listarDatosPantilla(){
        let t =  this;

        const params = {
          accion:'tablaPlantilla'
          ,id:IDEncabezado,
        };
        
        axios.post('../controladores/interfaz_proceso.php',params).then(function (response){
          //console.log(response.data);
          t.datosEncabezado=response.data ;

        })
        .catch(function (error) {
          console.log(error);
        });
      }, 


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

      comprobar(id){

        if(this.empresa != ''){
        
          if(id==1){
            this.agregar();
          }

        }else{
  
          Swal.fire(
            'Error',
            'Favor de indicar el almacén',
            'error'
          );
  
        }
  
      }, 

      agregar(){
        const params = {
          idtabla:IDEncabezado,
          empresa:this.empresa,
          accion:'agregar',
        };

        //console.log(params);

        axios.post('../controladores/interfaz_proceso_relacion.php',params)
        .then((response)=>{
          //console.log(response.data);
          if(response.data == true ){
            Swal.fire(
              'Exito!',
              'Registro Agregado.',
              'success'
            )
            this.listar();            
            this.empresa = 0;
            this.organizacion =0;
            this.almacen ='0';

                  
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
            axios.post('../controladores/interfaz_proceso_relacion.php',params)
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
  this.obtenerEmpresa();
  this.listarDatosPantilla();
},   

 });

