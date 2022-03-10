////////////////////////////////////////////// VENTA
var application_ADVenta = new Vue({

    el:'#OrdenVenta',
    data(){
      return{
         opcionVenta:'',
         comboAlmacen:'',

         idorden:'',
         idlista:'',
         idalmacen:'0',
         picked:'',
         selected: '0'
      }

    },
    methods:{

      listar(){
         let t = this;
         const params = {
           accion:'tabla',
           activo:true,
         };
         axios.post('../controladores/interfaz_venta.php',params).then(function (response){
           //console.log(response.data);
           t.opcionVenta=response.data ;
   
         })
         .catch(function (error) {
           console.log(error);
         });
       },      

       async comboServidorAlmacen(){
         let l = this;
         this.comboAlmacen = [];
         const params = {
           accion:'almacenEmpresa',
           id:this.picked,
         };
         this.comboAlmacen = await axios.post('../controladores/servidor_almacen.php',params).then(function (response){
          return response.data;
         /*   console.log(response.data);
           //
           console.log(response.data[0].id_servidor_almacen_destino);
           this.selected = response.data[0].id_servidor_almacen_destino;
           l.comboAlmacen=response.data; */
           
         })
         .catch(function (error) {
           //console.log(error);
           return [];
         });
         
         
         let conx= {};
         this.opcionVenta.forEach(element => {
           if (element.id_servidor_datos_orden == this.picked) {
             conx=element;
             return;
           }
         });

          //console.log(conx);

          this.idalmacen = "0";
            for (let index = 0; index < this.comboAlmacen.length; index++) {
              const element = this.comboAlmacen[index];
              if (element.id_servidor_almacen == conx.id_servidor_almacen_destino) {
               this.idalmacen = element.m_warehouse_id;
              }
              
            }


       },
       

       validar(){

         if(this.idorden != '' && this.idlista != '' && this.picked != '' && this.idalmacen != ''){
         
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
           idlista:this.idlista, 
           picked:this.picked,
           idalmacen:this.idalmacen,
           accion:'ejecutar',
         };
         //console.log(params);
   
         axios.post('../controladores/interfaz_venta.php',params)
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
               type: 'success',
               width: '60%',
               //text: response.data[0].ad_crearordenventa,
               html: response.data
               .map(data => `<div>${data.documento}</div>` + "<br/>")
               .join(""),
               //showConfirmButton: false,
               allowOutsideClick: false,
               allowEscapeKey: false
             });
   
             this.listar();
             this.idorden = '';
             this.idlista = '';
             this.idalmacen = '';
             this.picked = '';
   
           }
         });
         
       },  

       /*
     async getWarehouse(){ 

      const r = await axios.post("../php/bd_interfaz_sales.php", {
            action:'WareHouse',   
            id: this.picked  
         })
      .then(function (response) {  
         //console.log(response.data);  
         return response.data;   
      })
      .catch(function (response) { 
            return response.data;  
         });

      application_ADVenta.organization = r;
      },
   */
    },

    mounted() {
      this.listar();

    },

 });