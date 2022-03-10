///////////////////// REPORTE
var mostarModal = document.getElementById("modalPDFs").style.display = "block";
var mostarModalv2 = document.getElementById("modalInfomacion").style.display = "block";
// var mostarModalv3 = document.getElementById("modalExportarExcel").style.display = "block";

var application_report = new Vue({

  el: '#InformeProduccionUsa',
  data() {
    return {

      comboAlmacenGral: '',

      producto: '',
      almacen: '0',

      modalPDF: false,
      modalPDFv2: false,
      msgModalPDF: '',


      dinamicoTitulo: '',
      dinamicoTexto: '',
      urlPDFInfo: '',
      modalPDFInfo: false,

      /**MODAL EXCEL */
      generalModalExportarExcel: false,
      dynamicTitle: '',
      dynamicText: '',
      mensajeModalExportarExcel:'',

    }

  },
  methods: {

    listarAlmacenGeneral() {
      let t = this;
      const params = {
        accion: 'listado',
        activo: true,
      };
      axios.post('../controladores/dev_almacen.php', params).then(function (response) {
        //console.log(response.data);
        t.comboAlmacenGral = response.data;

      })
        .catch(function (error) {
          console.log(error);
        });
    },

    sincronizar(id) {
      const params = {
        id: 1,
        accion: 'sincronizar',
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
          axios.post('../controladores/sincronizacion.php', params)
            .then((response) => {
              //console.log(response.data);

              if (response.data == true) {
                Swal.fire(
                  'Correcto',
                  'Sincronización Correcta.',
                  'success'
                );

              } else {
                //console.log(response.data.errorInfo);
                Swal.fire(
                  'error',
                  'No se puede sincronizar.' + "<br/>" + response.data.errorInfo,
                  'error'
                );

              }

            });
        }

      })
    },

    generarInforme() {

      const params = {
        producto: this.producto,
        accion: 'informeUSA',
        tipo: 'pdf'

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

      axios.post('../controladores/jasper_server.php', params, { responseType: 'arraybuffer' })
        .then((response) => {

          var nombre = "my-download.pdf";

          //Create a Blob from the PDF Stream
          const file = new Blob([response.data], { type: 'application/pdf' });
          //Build a URL from the file
          const fileURL = URL.createObjectURL(file);
          //Open the URL on new Window
          //window.open(fileURL);

          //   console.log(a.href);
          this.msgModalPDF = fileURL;
          //this.mostarModal;
          this.modalPDFv2 = true;
          Swal.close()

        });

    },

    async generarListadov2() {

      // if (this.producto != '0') {

        const params = {
          producto: this.producto,
          accion: 'crearOrdenLocalUSA',
        };
        //console.log(params);

        this.dinamicoTitulo = 'Generando Listado';
        this.dinamicoTexto = 'Espere por favor';
        this.urlPDFInfo = '../image/loadv4.gif';
        this.modalPDFInfo = true;

        await
          axios.post('../controladores/orden_local.php', params)
            .then((response) => {

              console.log(response.data);
              if (response.data) {

                  if(response.data.errorInfo){
                    this.dinamicoTitulo = 'Error';
                    this.dinamicoTexto = response.data.errorInfo;
                    this.urlPDFInfo = '../image/error.png';

                  }else{
                    this.dinamicoTitulo = 'Listo';
                    this.dinamicoTexto = response.data[0].fn_crearorden;
                    this.urlPDFInfo = '../image/ok.gif';

                  }

              } else {

                this.dinamicoTitulo = 'Error';
                this.dinamicoTexto = response.data;
                this.urlPDFInfo = '../image/error.png';

              }

              //console.log(response.data);

            });

      // } else {

      //   this.dinamicoTitulo = 'Error';
      //   this.dinamicoTexto = 'No se puede generar el Listado.';
      //   this.urlPDFInfo = '../image/error.png';

      // }


    },

    async excelProduccion(){
      const params = {
        producto: this.producto,
        almacen: this.almacen,
        accion: 'produccionv2',
        tipo: 'xls'
      };
      
      this.dynamicTitle ='Exportando Datos';
      this.dynamicText = 'Espere por favor';
      this.mensajeModalExportarExcel = '../image/loadv4.gif';

      //this.mostarModalv3; 
      this.generalModalExportarExcel = true;

      await
      axios.post('../controladores/jasper_server.php',params,{responseType: 'arraybuffer'})
      .then((response)=>{

        if(response){

          this.dynamicText = 'Listo';
          this.mensajeModalExportarExcel = '../image/ok.gif';

        }else{

          this.dynamicText = 'Error';
          this.mensajeModalExportarExcel = '../image/error.png';

        }

         const a = document.createElement('a');
         //Create a Blob from the PDF Stream
         const file = new Blob([response.data],{type: 'application/xls'});
         //Build a URL from the file
         const url = window.URL.createObjectURL(file);
         a.href = url;
         a.download = "Informe.xls"; // you need to write the extension of file here
         a.click();
         window.URL.revokeObjectURL(url);

      });    

    },



    cerrarModalInformacion() {
      this.modalPDFInfo = false;
      this.urlPDFInfo = '';
      this.dinamicoTitulo = '';
      this.dinamicoTexto = '';

      this.generalModalExportarExcel = false;
      this.mensajeModalExportarExcel = ''; 
      this.dynamicTitle = '';
      this.dynamicText = '';

    },

  },


  mounted() {
    this.listarAlmacenGeneral();
  },

});