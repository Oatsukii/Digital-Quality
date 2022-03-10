///////////////////// REPORTE
var mostarModal = document.getElementById("modalPDFs").style.display = "block";
var mostarModalv2 = document.getElementById("modalInfomacion").style.display = "block";

var application_report = new Vue({

  el:'#reporteProduccion',
  data(){
   return {

      comboAlmacenGral:'',

      producto:'',
      almacen:'0',

      modalPDF: false,
      modalPDFv2: false,
      msgModalPDF:'',

      dinamicoTitulo:'',
      dinamicoTexto:'',
      urlPDFInfo:'',
      modalPDFInfo:false

   }

  },
  methods:{

   listarAlmacenGeneral(){
      let t = this;
      const params = {
        accion:'listado',
        activo:true,
      };
      axios.post('../controladores/dev_almacen.php',params).then(function (response){
        //console.log(response.data);
        t.comboAlmacenGral=response.data ;

      })
      .catch(function (error) {
        console.log(error);
      });
    },

    sincronizar(id){
      const params = {
        id:1,
        accion:'sincronizar',
      };
      
      Swal.fire({
        title: 'Sincronización',
        text: "¿Estas seguro de sincronizar?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si'
        
        
      }).then((result) => {

         Swal.fire({
            title: "Sincronizando...",
            text: "Espere por favor",
            imageUrl: "../image/cloud_load.gif",
            allowEscapeKey: false,
            allowOutsideClick: false,
            showConfirmButton: false,

          });


        if (result.value) {
          axios.post('../controladores/sincronizacion.php',params)
          .then((response)=>{ 
            //console.log(response.data);

            if(response.data == true){
                Swal.fire(
                'Correcto',
                'Sincronización Correcta.',
                'success'
              );

            }else{
              //console.log(response.data.errorInfo);
              Swal.fire(
                'error',
                'No se puede sincronizar.'+ "<br/>" + response.data.errorInfo,
                'error'
              );
              
            }

          });  
        }

      })
    }, 

    generarInforme(){

      const params = {
        producto:this.producto,
        almacen:this.almacen,
        accion:'produccion',

      };
      //console.log(params);

      Swal.fire({
        title: "Generando Informe",
        text: "Espere por favor",
        imageUrl: "../image/loadv4.gif",
        animation: "slide-from-top",
        allowEscapeKey: false,
        allowOutsideClick: false,
        showConfirmButton: false,

      });

      axios.post('../controladores/jasper_server.php',params,{responseType: 'arraybuffer'})
      .then((response)=>{

         console.log(response.data);

         //Create a Blob from the PDF Stream
            const file = new Blob([response.data],{type: 'application/pdf'});
         //Build a URL from the file
            const fileURL = URL.createObjectURL(file);
         //Open the URL on new Window
         //window.open(fileURL);

          this.msgModalPDF = fileURL;
          this.mostarModal; 
          this.modalPDFv2 = true;
          Swal.close()

      });

    },

    async generarListado(){

      if(this.almacen !='0' ){
  
      const params = {
        producto:this.producto,
        almacen:this.almacen,
        accion:'crearOrdenLocal',
      };
         //console.log(params);
      
      this.dinamicoTitulo ='Generando Listado';
      this.dinamicoTexto = 'Espere por favor';
      this.urlPDFInfo = '../image/loadv4.gif';
      this.modalPDFInfo = true;
      this.mostarModalv2; 

      await
      axios.post('../controladores/orden_local.php',params)
      .then((response)=>{

        if(response.data){

          this.dinamicoTitulo = 'Listo';
          this.dinamicoTexto = response.data[0].fn_crearorden;
          this.urlPDFInfo = '../image/ok.gif';

        }else{

          this.dinamicoTitulo = 'Error';
          this.dinamicoTexto = response.data;
          this.urlPDFInfo = '../image/error.png';

        }

         //console.log(response.data);

      });

    }else{

      this.dinamicoTitulo = 'Error';
      this.dinamicoTexto = 'No se puede generar el Listado.';
      this.urlPDFInfo = '../image/error.png';

    }


    },

    cerrarModalInformacion(){
      this.dinamicoTitulo = '';
      this.dinamicoTexto = '';
      this.urlPDFInfo ='';
      this.modalPDFInfo = false;
  },  

  },


mounted() {
   this.listarAlmacenGeneral();
 }, 

});