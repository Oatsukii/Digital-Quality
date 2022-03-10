var application_rol = new Vue({

    el:'#MenuRelacion',
    data(){
      return {
        hiddenId:null,
        id_s_empresa: '',
        id_s_menu: null,
        id_s_rol: null, 
        tablaMenuRelacion: '',
        EmpresaCollection: ''
      }
      
    },
    methods:{

      obtenerParametros(){
        const valores = window.location.search;
        const urlParams = new URLSearchParams(valores);
        var parametro = urlParams.get('action');
        this.id_s_menu = parametro;
      },

      listar(){
        let t = this;
        const params = {
          id_s_menu: this.id_s_menu,
          accion:'tabla'
        };
        axios.post('../controladores/c_s_menu_relacion.php',params).then(function (response){
          //console.log(response.data);
          t.tablaMenuRelacion=response.data ;

        })
        .catch(function (error) {
          console.log(error);
        });
      },

      comprobar(id){

        if(this.id_s_empresa != ''  ){
        
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
          id_s_empresa : this.id_s_empresa,
          id_s_menu : this.id_s_menu,
          accion:'agregar',
        };

        console.log(params);

        axios.post('../controladores/c_s_menu_relacion.php',params)
        .then((response)=>{
          //console.log(response.data);
          if(response.data == true ){
            this.id_s_empresa = '';
            Swal.fire(
              'Exito!',
              'Registro Agregado.',
              'success'
            )
            this.listar();
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
        console.log(params);
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
            axios.post('../controladores/c_s_menu_relacion.php',params)
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

    },

    mounted() {
      this.obtenerParametros();
      this.BuscaEmpresas();
      this.listar();
    },

 });

