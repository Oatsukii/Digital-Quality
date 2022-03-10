
 var application_usuario = new Vue({

    el:'#DatosUsuarios',
    data(){
      return {

      pass_new:'',
      pass_new_repeat:'',
      pass_old:'',
          
      arrayUsuarios:[],
      hiddenId:null,
      first_name:'',
      paternal_name:'',
      maternal_name:'',
      user:'',
      ad_user:'',
      checked:true,
      accion:'',

      tituloModalRol:'',
      rol:false,
      empleadoSeleccionado : null,
      rols:[],

      modoAgregar : true,
      tituloModal : '',
      show : false,

      busqueda: '',
      combo:true,
      optionsv2: [
        { value: true, text: "Activo" },
        { value: false, text: "No Activo" },
      ],      


      }
      
    },
    methods:{

    listar(){
          let t = this;
          const params = {
            accion:'tabla'
          };
          axios.post('../controladores/usuario.php',params).then(function (response){

            t.arrayUsuarios= response.data ;
            //console.log(this.arrayUsuarios);

          })
          .catch(function (error) {
            console.log(error);
          });
        },

      comprobar(id){

        if(this.first_name != '' && this.paternal_name != '' && this.maternal_name != '' && this.user != ''){
        
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
				first_name: this.first_name,
				paternal_name : this.paternal_name,
        maternal_name : this.maternal_name,
				user : this.user,
        ad_user: this.ad_user,
        checked : this.checked,
        accion:'agregar',
			};
			
			axios.post('../controladores/usuario.php',params)
			.then((response)=>{
        //console.log(response.data);
				if(response.data){
					Swal.fire(
						'Exito!',
						'Registro agregado.',
						'success'
					);
					this.listar();
          this.cerrarModal();
				}
				else{

          Swal.fire(
            'Error',
            'No se puede agregar el registro.'+ "<br/>" + response.data.errorInfo,
            'error'
          );


        }
			});		
		},

		editar(){
			const params = {
        id : this.hiddenId,
				first_name: this.first_name,
				paternal_name : this.paternal_name,
        maternal_name : this.maternal_name,
				user : this.user,
        ad_user : this.ad_user,
        checked : this.checked,
        accion:'editar',
			};
			
			axios.post('../controladores/usuario.php',params)
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
        this.listar();

			});
		},

		cambiarcontrasenia(id){
			const params = {
        id:id,
        accion:'cambiarcontrasenia',
			};
			
      Swal.fire({
        title: 'Reiniciar Contraseña',
        text: "Se va a restablecer su contraseña",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si'
      }).then((result) => {

        if (result.value) {
          axios.post('../controladores/usuario.php',params)
          .then((response)=>{ 
            //console.log(response.data);

            if(response.data == true){
                Swal.fire(
                'Correcto',
                'Contraseña Restablecida.',
                'success'
              );
              this.listar();

            }else{
              //console.log(response.data.errorInfo);
              Swal.fire(
                'error',
                'No se puede restablecer la contraseña.'+ "<br/>" + response.data.errorInfo,
                'error'
              );

              
            }
            this.listar();

          });  
        }

      })
		},


     obtenerDato(id){
			const params = {
        id:id,
        accion:'obtenerDato',
			};
			
			axios.post('../controladores/usuario.php',params)
			.then((response)=>{
        //console.log(response.data);
        this.first_name = response.data.first_name;
        this.paternal_name = response.data.paternal_name;
        this.maternal_name = response.data.maternal_name;
        this.user = response.data.user;
        this.ad_user = response.data.ad_user_id;
        this.checked = response.data.checked
        this.hiddenId = response.data.id;
			});		
		},


		abrirModal(modo, row = []){
        //console.log(row);
        this.show = true;
        if(modo == 'agregar')
        {
          this.tituloModal = 'AGREGAR';
        }
        else
        {
          this.modoAgregar = false;
          this.tituloModal= 'EDITAR';
          this.obtenerDato(row)
        }
    },

    cerrarModal(){
        this.show = false;
        this.first_name = '';
        this.paternal_name = '';
        this.maternal_name = '';
        this.user = '';
        this.ad_user = '',
        this.checked = true;
        this.modoAgregar = true;
    },     
  
		abrirModalRol(row){
      //console.log(row);
      this.rol = true;
      this.asignaRol(row);
  },
 
  cerrarModalRol(){
    this.rol = false;
  },    

  async asignaRol(employee){ 
    //console.log(employee.idusuario);

    this.isDisabledSC = false;
    this.empleadoSeleccionado = employee;

    const params = {
      idusuario:this.empleadoSeleccionado.id_usuario,
      accion:'rolusuario',
    };

    const response = await axios.post('../controladores/usuario_rol.php',params)
    .then(function(response){ 
      //console.log(response.data);
      return response.data;
    });

    this.rols = response; 
    this.tituloModalRol = this.empleadoSeleccionado.nombre +" "+ this.empleadoSeleccionado.paterno;

  },


  async guardarRol(){ 
    //this.isDisabledSC = true;

    const params = {
      idusuario:this.empleadoSeleccionado.id_usuario,
      accion:'eliminar',
    };

  
      Swal.fire(
      'Correcto',
      'Contraseña Restablecida.',
      'success'
    );

    const response = await axios.post('../controladores/usuario_rol.php', params).then(function(response){ return response.data });
    //console.log(response);

    for (let index = 0; index < this.rols.length; index++) {
      const element = this.rols[index];
      if (element.selected) {
        const response2 = await axios.post('../controladores/usuario_rol.php', {  
          accion:'agregar'
          ,id_usuario: this.empleadoSeleccionado.id_usuario
          ,id_rol: element.id_rol }).then(function(response)
          { 
     
            return response.data

           });
        console.log(response2);

                    if(response2){

              Swal.fire(
                'Correcto',
                'Se ha asignado los roles correctamente',
                'success'
              );

            }
      } 



    } 

    this.empleadoSeleccionado = null;

  },

  filtroUsuario(){
    let t = this;
    const params = {
      accion:'busquedaUsuario',
      busqueda:this.busqueda,
      combo:this.combo
            //activo:true
    };
    axios.post('../controladores/usuario.php',params).then(function (response){
      //console.log(response.data);
      t.arrayUsuarios=response.data;


    })
    .catch(function (error) {
      console.log(error);
    });
  },






/*
         async asingRols(employee){ 
          this.isDisabledSC = false;
          this.employeeSelected = employee;
          const response = await axios.post('../php/bd_usuario_rol.php', {  action:'fetchall',id_usuario:this.employeeSelected.idusuario }).then(function(response){ return  response.data });
          this.rols = response; 
          //console.log(this.rols);
          this.dynamicTitle = this.employeeSelected.nombre;
          this.myModelRol = true;   
        },
 */       

 /*
        async saveRols(){ 
          this.isDisabledSC = true; 
          const response = await axios.post('../php/bd_usuario_rol.php', {  action:'delete',id_usuario: this.employeeSelected.idusuario }).then(function(response){ return  response.data });
          // console.log(response);
          for (let index = 0; index < this.rols.length; index++) {
            const element = this.rols[index];
            if (element.selected) { 
              const response2 = await axios.post('../php/bd_usuario_rol.php', {  action:'insert',id_usuario: this.employeeSelected.idusuario,id_rol: element.id_rol }).then(function(response){ return  response.data });
              //  console.log(response2);
            } 
          } 
          this.employeeSelected = null;
          this.myModelRol = false;   
        }
*/

           
    },
    
    mounted() {
      this.listar();
    },
    
 });

