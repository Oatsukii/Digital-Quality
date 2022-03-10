var application_s_rol_menu = new Vue({

    el:'#DatosRolMenu',

    data(){
      return {

      datosEncabezado:'',
      comboMenu:'',
      tablaRolMenu:'',
      id_s_rol:null,
      id_s_empresa:'',
      id_s_menu:'',
      id_s_rol_menu: '',
      EmpresaCollection:'',
      MenuCollection: '',

      }

    },
    methods:{

        obtenerParametros(){
            const valores = window.location.search;
            const urlParams = new URLSearchParams(valores);
            var parametro = urlParams.get('action');
            this.id_s_rol = parametro;
        },

        BuscaEmpresas(){
          let t = this;
          const params = {
              accion:'empresas',
          };
          axios.post('../controladores/c_s_usuario.php',params).then(function (response){
              t.EmpresaCollection=response.data ;
          }).catch(function (error) {
              console.log(error);
          });
        },

        BuscaMenus(){
            let t = this;
            const params = {
                accion:'tablaMenu',
            };
            axios.post('../controladores/c_s_menu.php',params).then(function (response){
                t.MenuCollection=response.data ;
            }).catch(function (error) {
                console.log(error);
            });
        },

        listarDatosRol(){
            let t =  this;
            const params = {
              accion:'tablaRol'
              ,id_s_rol : this.id_s_rol,
            };
            
            axios.post('../controladores/c_s_rol.php',params).then(function (response){
              //console.log(response.data);
              t.datosEncabezado=response.data ;
    
            })
            .catch(function (error) {
              console.log(error);
            });
        },

        listar(){
            let t =  this;
    
            const params = {
              accion:'tabla'
              ,id:this.id_s_rol,
            };
    
            axios.post('../controladores/c_s_rol_menu.php',params).then(function (response){
              t.tablaRolMenu=response.data ;
    
            })
            .catch(function (error) {
              console.log(error);
            });
        },
    
        comprobar(id){

            if(this.id_s_empresa != '', this.id_s_menu != ''){
            
              if(id==1){
                this.agregar();
              }
    
            }else{
      
              Swal.fire(
                'Error',
                'Favor de seleccionar la empresa',
                'error'
              );
            }
        },

        agregar(){
            const params = {
              id_s_rol : this.id_s_rol,
              id_s_menu: this.id_s_menu,
              id_s_empresa: this.id_s_empresa,
              accion:'agregar',
            };
    
            console.log(params);
            axios.post('../controladores/c_s_rol_menu.php',params)
            .then((response)=>{
              //console.log(response.data);
              if(response.data == true ){
                Swal.fire(
                  'Exito!',
                  'Registro Agregado.',
                  'success'
                )
                this.listar();
                this.menu = '';
    
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
                axios.post('../controladores/c_s_rol_menu.php',params)
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
        this.obtenerParametros();
        this.listarDatosRol();
        this.BuscaEmpresas();
        this.BuscaMenus();
    this.listar();

    },

 });

