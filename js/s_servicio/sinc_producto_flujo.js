var application_productos = new Vue({

    el:'#s-producto-flujo',

    data(){
      return {
          parametro:null,
          parametro2:null,
          api: '',
          key: '[SVR_D3$@rr0ll0_@3d524a53c110e4c22463b10ed32cef9d]',
          productoCollection: '',

          numByPag : 30, 
          paginas : [],
          paginaCollection : [],
          paginaActual : 1,
          ServicioCollection: '',
      }

    },
    methods:{

        obtenerParametros(){
            const valores = window.location.search;
            const urlParams = new URLSearchParams(valores);
            var parametro = urlParams.get('action');
            var parametro2 = urlParams.get('proceso');
            this.parametro = parametro;
            this.parametro2 = parametro2;
            this.listarUrlApi();

        },



        listarUrlApi(){
            let t = this;
            const params = {
                accion :'ServicioSeleccioando',
                servicio : this.parametro,
            };
            axios.post('../controladores/c_s_servicios.php',params).then((response) => {
            
                t.ServicioCollection=response.data ;

                for (let index = 0; index < t.ServicioCollection.length; index++) {
                    const element = t.ServicioCollection[index];
                    this.api = element.url;
                    
                }
                if(this.api != ''){
                    this.apiProducto();

                }
            
            }).catch(function (error) {
                console.log(error);
            });

        },



        listar(){
            let t = this;
            const params = {
                accion :'tabla',
            };
            axios.post('../controladores/c_sinc_producto_flujo.php',params).then((response) => {
            
                t.productoCollection=response.data ;
                t.paginaCollection=response.data;
                this.paginador(1);  
            
            }).catch(function (error) {
                console.log(error);
            });
            

        },



        apiProducto(){

            let productos= {};
            const response =  axios.post(this.api + this.parametro ,{ 
            }, { headers:{
                    "Api-Key" : this.key
                }
            }).then( (response) => {

                if(response.data.status == "success"){
                    productos = response.data.data;
                    let array = JSON.stringify(productos);

                    this.agregar(array);

                }
                return response.data;
            }).catch(function (response) {
                console.log("Error al intentar recuperar...");
                return response;
            });
        },



        agregar(array){

            const params = {
                        empleados : array,
                        accion:'agregar',
                        proceso: this.parametro2
            };

            Swal.fire({
                title: "Procesando...",
                text: "Espere por favor",
                imageUrl: "../image/cloud_load.gif",
                allowEscapeKey: false,
                allowOutsideClick: false,
                showConfirmButton: false,
            });

            axios.post('../controladores/c_sinc_producto_flujo.php',params).then((response)=>{
                console.log(response);
                if(response.data == true ){
                    Swal.fire(
                        'Exito!',
                        'Productos Sincronizados.',
                        'success'
                    );
                    this.listar();
                    this.paginador(1);
                } else {
                    Swal.fire(
                        'Error!',
                        'Ocurrio un Error',
                        'error'
                    )
                }
            });
        },


        paginador(i){ 
            let cantidad_pages = Math.ceil(this.productoCollection.length / this.numByPag);
            this.paginas = []; 
            if (i === 'Ant' ) {
                if (this.paginaActual == 1) {  
                    i = 1;  
                }else{  
                    i = this.paginaActual -1; 
                } 
            }else if (i === 'Sig') { 
                if (this.paginaActual == cantidad_pages) {
                    i = cantidad_pages; 
                } else { 
                    i = this.paginaActual + 1;
                } 
            }else{ this.paginaActual = i; } 
            this.paginaActual = i; 
            this.paginas.push({'element':'Ant'}); 
            for (let indexI = 0; indexI < cantidad_pages; indexI++) {
                this.paginas.push({'element':(indexI + 1)});
                if (indexI == (i - 1) ) { 
                    this.paginaCollection = [];  
                    let inicio = ( i == 1 ? 0 : ((i-1) *  parseInt(this.numByPag)));
                    inicio = parseInt(inicio);
                    let fin = (cantidad_pages == i ? this.productoCollection.length : (parseInt(inicio) + parseInt(this.numByPag)));  
                    for (let index = inicio; index < fin; index++) {
                        const element = this.productoCollection[index];
                        this.paginaCollection.push(element); 
                    }  
                }  
            }  
            this.paginas.push({'element':'Sig'});
        }
    },

   mounted() {
    this.obtenerParametros();

    
  },

 });

