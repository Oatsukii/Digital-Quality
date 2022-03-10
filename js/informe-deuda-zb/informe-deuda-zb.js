///////////////////// REPORTE
var mostarModal = document.getElementById("modalPDFs").style.display = "block";
var mostarModalv2 = document.getElementById("modalInfomacion").style.display = "block";
var application_report = new Vue({

  el:'#reporteExistencia',
  data(){
    return {
    comboAlmacenGral:'',

    producto:'',
    //almacen:'0',

    modalPDFv2: false,
    modalPDFv3: false,

    msgModalPDF:'',
    msgModalPDFv2:'',

    dynamicTitle:'',
    dynamicText:''

    }

  },
  methods:{

    procesarInformacion(){
      const params = {
        accion:'procesarInformacionZB',
      };
      
      Swal.fire({
        title: 'Procesar Información',
        text: "¿Estas seguro de procesar?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si'
        
        
      }).then((result) => {

         Swal.fire({
            title: "Procesando...",
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
                'La información se proceso correctamente.',
                'success'
              );

            }else{
              //console.log(response.data.errorInfo);
              Swal.fire(
                'error',
                'No se puede procesar.'+ "<br/>" + response.data.errorInfo,
                'error'
              );
              
            }

          });  
        }

      })
    }, 

    async generarInforme(){

      const params = {
        producto:this.producto,
        //almacen:this.almacen,
        accion:'informeZB',

      };
      //console.log(params);

      Swal.fire({
        title: "Generando Informe",
        text: "Espere por favor",
        imageUrl: "../image/loadv4.gif",
        allowEscapeKey: false,
        allowOutsideClick: false,
        showConfirmButton: false,

      });

      await
      axios.post('../controladores/jasper_server.php',params,{responseType: 'arraybuffer'})
      .then((response)=>{

         console.log(response);

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
    


  },

  mounted() {
  }, 
 
});