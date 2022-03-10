////////////////////////////////////////////// COMPRA
var application_ADCompra = new Vue({

   el:'#OrdenCompra',
   data(){
      return{
         opcionCompra:'',
         comboAlmacen:'',

         idorden:'',
         idlista:'',
         idalmacen:'0',
         picked:[],
         remoto:'',
      }

   },
   methods:{
  
      listar(){
         let t = this;
         const params = {
           accion:'tabla',
           activo:true,
         };
         axios.post('../controladores/interfaz_compra.php',params).then(function (response){
           //console.log(response.data);
           t.opcionCompra=response.data ;
   
         })
         .catch(function (error) {
           console.log(error);
         });
       },      

       comboServidorAlmacen(){
         let l = this;
         const params = {
           accion:'almacenEmpresa',
           id:this.picked.id_servidor_datos_orden,
         };
         //console.log(params);

         axios.post('../controladores/servidor_almacen.php',params).then(function (response){
           //console.log(response.data);
           l.comboAlmacen=response.data ;
 
         })
         .catch(function (error) {
           console.log(error);
         });
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
           picked:this.picked.id_servidor_datos_orden,
           idalmacen:this.idalmacen,
           remoto:this.picked.informacionremota,
           accion:'ejecutar',
         };
         //console.log(params);
   
         axios.post('../controladores/interfaz_compra.php',params)
         .then((response)=>{
           //console.log(response.data);
   
           if(response.data.errorInfo){
   
             Swal.fire({
               title: 'Error',
               type: 'error',
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

   },

    mounted() {
      this.listar();
    },


});