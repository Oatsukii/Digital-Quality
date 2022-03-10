///////////////////// REPORTE
var mostarModal = document.getElementById("modalPDFs").style.display = "block";
var mostarModalv2 = document.getElementById("modalInfomacion").style.display = "block";

Vue.component('v-select', VueSelect.VueSelect)

var application_report = new Vue({

  el:'#reporteProduccion',
  data(){
   return {

    empresa:0,
    comboEmpresa :'',

    proveedor:0,
    comboSocio:'',  

    organizacion:0,
    comboOrganizacion:'',    

    almacen_eo:0,
    almacen_m:0,
    almacen:'0',
    comboAlmacen:'',

    producto:'',

    modalPDF: false,
    modalPDFv2: false,
    msgModalPDF:'',

    dinamicoTitulo:'',
    dinamicoTexto:'',
    urlPDFInfo:'',
    modalPDFInfo:false,

    proveedor2: null,
    options:[],

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

    async obtenerSegmento(){   
      let l = this;

      await 
      axios.post("../controladores/consulta_adempiere.php", {   
        accion:'AD_Segmento',
        idempresa: this.empresa,
        activo: 'SI',
      }).then(function (response) {
        l.comboOrganizacion = response.data;
        
      }).catch(function (response) { 
        l.comboOrganizacion = response.data;  
      
      });

    },

    async obtenerProveedor(){
      let l = this;
      let l2 = this;
      
      await 
      axios.post("../controladores/consulta_adempiere.php", {   
        accion:'AD_Producto_Compra',
        idempresa: this.empresa,
        activo: 'SI',
      }).then(function (response) {
        l.comboSocio = response.data;
        l2.options = response.data;
        
      }).catch(function (response) { 
        l.comboSocio = response.data;  
      
      });

    },


    async obtenerAlmacen(){   
      await 
      axios.post("../controladores/consulta_adempiere.php", {   
        accion:'AD_Almacen',
        idempresa: this.empresa,
        organizacion: this.organizacion,
        activo: 'SI',
      }).then(function (response) {
        application_report.comboAlmacen = response.data;
        
      }).catch(function (response) { 
        application_report.comboAlmacen = response.data;  
      
      });

    },


    generarInforme(){

      if(this.empresa != 0 && this.proveedor2 != null && this.almacen_eo != 0 && this.almacen_m != 0 ){
      
      const params = {
        empresa:this.empresa,
        //proveedor:this.proveedor,
        proveedor:this.proveedor2,
        almacen1:this.almacen_m,
        almacen2:this.almacen_eo,
        producto:this.producto,
        accion:'compra',

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

    }else{

      // Swal.fire(
      //   'Error',
      //   'Favor de completar el formulario',
      //   'error'
      // );
      Swal.fire({
        title: 'Completa el Formulario',
        type: 'error',
        html: `<h4>contemplar lo siguiente:</h4>
        <p>Indicar la <strong>Conexión</strong></p>
        <p>Selecciona <strong>Socio Negocio</strong></p>
        <p>Selecciona <strong>Organización</strong></p>
        <p>Selecciona Almacén para<strong>Máximo</strong></p>
        <p>Selecciona Almacén para<strong> Existencia y Ordenado</strong></p>
        <p>Artículo<strong>(Opcional)</strong></p>
        <br>
        `,
        });



    }


    },

    async generarListado(){

      if(this.empresa != 0 && this.proveedor2 != null && this.almacen_eo != 0 && this.almacen_m != 0 ){
  
      const params = {
        empresa:this.empresa,
        //proveedor:this.proveedor,
        organizacion:this.organizacion,
        proveedor:this.proveedor2,
        almacen1:this.almacen_m,
        almacen2:this.almacen_eo,
        producto:this.producto,
        accion:'crearOrdenLocalv2',
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
          this.dinamicoTexto = response.data[0].fn_crearordenv2;
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
   this.obtenerEmpresa();

 }, 

});