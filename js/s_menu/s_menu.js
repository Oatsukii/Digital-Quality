var application_menu = new Vue({

    el:'#DatosMenu',
    data(){
      return {

      tablaMenu:[],

      modoAgregar : true,
      tituloModal : '',
      show : false,

      hiddenId:null,
      nombre:'',
      url:'',
      svg:'',
      orden:'',
      checked:true,
    //   id_s_empresa:'',
      principal:true,
      accion:'',
      EmpresaCollection:'',
      menuRelacion: 's_menu_relacion.php',

      }
    },
    methods:{

         listar(){
          let t = this;
          const params = {
            accion:'tabla'
          };
          axios.post('../controladores/c_s_menu.php',params).then(function (response){
            //console.log(response.data);
            t.tablaMenu=response.data ;

          })
          .catch(function (error) {
            console.log(error);
          });
        },

        comprobar(id){

          if(this.nombre != '' && this.url != ''){
          
            if(id==1){
              this.agregar();
            }else if(id==2){
              this.editar();
            }
  
          }else{
    
            Swal.fire(
              'Error',
              'Favor de completar el formulario',
              'error'
            );
    
          }
    
        },  

        agregar(){
          const params = {
            nombre: this.nombre,
            url : this.url,
            svg : this.svg,
            orden : this.orden,
            checked : this.checked,
            principal : this.principal,
            // id_s_empresa : this.id_s_empresa,
            accion:'agregar',
          };

          axios.post('../controladores/c_s_menu.php',params)
          .then((response)=>{
            //console.log(response.data);
            if(response.data == true ){
              Swal.fire(
                'Exito!',
                'Registro Agregado.',
                'success'
              )
              this.listar();
              this.cerrarModal();
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

        editar(){
          const params = {
            id : this.hiddenId,
            nombre: this.nombre,
            url : this.url,
            svg : this.svg,
            orden : this.orden,
            checked : this.checked,
            principal : this.principal,
            // id_s_empresa : this.id_s_empresa,
            accion:'editar',
    
          };
          
          axios.post('../controladores/c_s_menu.php',params)
          .then((response)=>{
             //console.log(response.data);
     
            if(response.data == true){
              Swal.fire(
                'Exito!',
                'Registro Editado.',
                'success'
              );
              this.listar();
              this.cerrarModal();
            }else{
    
              Swal.fire(
                'error',
                'No se puede editar el registro.'+ "<br/>" + response.data.errorInfo,
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
              axios.post('../controladores/c_s_menu.php',params)
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

        abrirModal(modo, row = []){
          //console.log(row);
          this.show = true;
          if(modo == 'agregar')
          {
            this.tituloModal = 'Agregar';
          }
          else
          {
            this.modoAgregar = false;
            this.tituloModal= 'Editar';
            this.nombre = row.nombre;
            this.url = row.url;
            this.svg = row.svg;
            this.orden = row.orden;
            this.checked = row.activo;
            this.principal = row.pagina_principal;
            this.hiddenId = row.id_s_menu;
            // this.id_s_empresa = row.id_s_empresa;
          }
      },
  
      cerrarModal(){
          this.show = false;
          this.nombre = '';
          this.url = '';
          this.svg = '';
          this.orden = '';
          this.checked = true;
        //   this.id_s_empresa = '';
          this.principal = true;
          this.modoAgregar = true;
      },


    },

    mounted() {
      this.listar();
      this.BuscaEmpresas();
    },

 });

