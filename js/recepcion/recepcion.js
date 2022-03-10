////////////////////////////////////////////// RECEPCION
var application_ADRecepcion = new Vue({

  el:'#Recepcion',
  data(){
    return {
      opcionRecepcion:'',
      idorden:'',
      pedimento:'',
      fechapedimento:'',
      picked:''  
    }

  },
  methods:{

  listar(){
      let t = this;
      const params = {
        accion:'tabla',
        activo:true,
      };
      axios.post('../controladores/interfaz_recepcion.php',params).then(function (response){
        //console.log(response.data);
        t.opcionRecepcion=response.data ;

      })
      .catch(function (error) {
        console.log(error);
      });
    },

    validar(){

      if(this.idorden != '' && this.pedimento != ''  && this.picked != '' && this.fechapedimento != ''){
      
        this.ejecutar();

      }else{

        Swal.fire(
          'Error',
          'Favor de completar el formulario',
          'error'
        );

      }

    },

    ejecutar(){
      const params = {
        idorden:this.idorden, 
        pedimento:this.pedimento, 
        picked:this.picked,
        fechapedimento:this.fechapedimento,
        accion:'ejecutar',
      };
      //console.log(params);

      axios.post('../controladores/interfaz_recepcion.php',params)
      .then((response)=>{
        //console.log(response.data);

        if(response.data.errorInfo){

          Swal.fire({
            title: 'Error',
            type: 'error',
            //text: 'No se puede realizar la interfaz.',
            //content: response.data.errorInfo,
            html:
            '<b>No se puede realizar la interfaz.</b> ' +
            '<br>' +
            '<p>'+response.data.errorInfo+'</p> ',
            //showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false
          });

        }else{

          Swal.fire({
            title: 'Proceso Interfaz',
            type: 'info',
            text: response.data[0].ad_recepcion,
            //showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false
          });

          this.listar();
          this.idorden = '';
          this.pedimento = '';
          this.fechapedimento = '';
          this.picked = '';

        }
      });
      
    },      

  },

  mounted() {
    this.listar();
  },

});