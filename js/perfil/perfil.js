
//

var application_usuario = new Vue({

    el:'#DatosPerfil',
    data(){
      return {

        first_name:'',
        paternal_name:'',
        maternal_name:'',
        user:'',

        pass_new:'',
        pass_new_repeat:'',
        pass_old:'',
        modal : false,
        tituloModal : 'Actualizar Contraseña',
        id_s_usuario: '',

        items: [],

        fields: [
          'nombre',
          { key: 'paterno', label: 'Apellido Paterno:',sortable: true },
          { key: 'materno', label: 'Apellido Materno:',sortable: true },
          'usuario',

          // A virtual column made up from two fields
          //{ key: 'nameage', label: 'First name and age' }
        ],


      }
    },
    methods:{

      abrirModal(){
        this.modal = true;
      },

    cambiarContrasenia(){

      if (this.pass_new == '' || this.pass_new_repeat == '') {

        Swal.fire(
          'Exito!',
          'Los Campos estan vacíos.',
          'error'
        );

      }else if(this.pass_new  != this.pass_new_repeat){

        Swal.fire(
          'Exito!',
          'La Nueva contraseña No coincide.',
          'error'
        );

      }else if(this.pass_new  === this.pass_new_repeat && this.pass_new != '' ){

          axios.post('../controladores/perfil.php', {
            accion:'cambiarcontrasenia',
            pass_new:this.pass_new,
            }).then((response) => {

            if(response.data ==true){

              Swal.fire(
                'Exito!',
                'Se ha restablecido su contraseña favor de reiniciar sesión',
                'success'
              );

              this.cerrarModal();

            }else{

              Swal.fire(
                'Error',
                'Error ' + response.data ,
                'error'
              );

            }
        
             });

            this.pass_new = '';
            this.pass_new_repeat = '';
            this.pass_old = ''; 

      }else{

        Swal.fire(
          'Error',
          'Consulte con el Administrador ',
          'error'
        );

      }

    },

    obtenerDatos(){

      let t = this;

      const params = {
        accion:'datosPerfil',
      };

      axios.post('../controladores/perfil.php',params).then(function(response){
      t.items = response.data;
      // application_usuario.first_name = response.data.nombre;
      // paternal_name = response.data.paterno;
      // maternal_name = response.data.materno;
      // application_usuario.user = response.data.usuario;
    });
    },

    cerrarModal(){
      this.modal = false;
      this.pass_new = '';
      this.pass_new_repeat = '';
      this.pass_old = '';
    },

           
    },
    
      
    mounted(){
      this.obtenerDatos() //method1 will execute at pageload
    },


 });

