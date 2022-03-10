///////////////////// REPORTE
var mostarModal = document.getElementById("modalPDFs").style.display = "block";
var mostarModalv2 = document.getElementById("modalInfomacion").style.display = "block";
var application_report = new Vue({

  el:'#reporteExistencia',
  data(){
    return {
    comboAlmacenGral:'',

    producto:'',
    almacen:'0',

    modalPDFv2: false,
    modalPDFv3: false,

    msgModalPDF:'',
    msgModalPDFv2:'',

    dynamicTitle:'',
    dynamicText:''

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
        accion:'existencia',

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

      axios.post('../controladores/jasper_server.php',params,{responseType: 'arraybuffer'})
      .then((response)=>{

         //console.log(response.data);

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
    
    async excelexistencia(){

      const params = {
        producto:this.producto,
        almacen:this.almacen,
        accion:'excelexistencia',

      };
      
      this.dynamicTitle ='Exportando Datos';
      this.dynamicText = 'Espere por favor';
      this.msgModalPDFv2 = '../image/loadv4.gif';

      this.mostarModalv2; 
      this.modalPDFv3 = true;

      //console.log(params);

      await
      axios.post('../controladores/jasper_server.php',params,{responseType: 'arraybuffer'})
      .then((response)=>{

        if(response){

          this.dynamicText = 'Listo';
          this.msgModalPDFv2 = '../image/ok.gif';

        }else{

          this.dynamicText = 'Error';
          this.msgModalPDFv2 = '../image/error.png';

        }

         //console.log(response.data);
         //let blob = new Blob([base64toBlob(blobContent, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')], {});
         //FileSaver.saveAs(blob, 'report.xlsx');

         const a = document.createElement('a');

         //Create a Blob from the PDF Stream
            const file = new Blob([response.data],{type: 'application/xls'});
         //Build a URL from the file
            //const fileURL = window.URL.createObjectURL(file);
         //Open the URL on new Window
         //window.open(fileURL);
         const url = window.URL.createObjectURL(file);
         a.href = url;
         a.download = "Informe.xls"; // you need to write the extension of file here
         a.click();
         window.URL.revokeObjectURL(url);

         //this.modalInfomacion = true;
         //Swal.close()

      });    

    },

    cerrarModalInformacion(){
      this.dynamicTitle = '';
      this.dynamicText = '';
      this.modalPDFv3 = false;
      this.msgModalPDFv2 ='';
  },     

  },

  mounted() {
    this.listarAlmacenGeneral();
  }, 
 
});