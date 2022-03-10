var application_usuario = new Vue({

    el:'#DatosProcesoInterfaz',
    data(){
      return {

      busqueda: '',
      //tablaUsuario:'',
      tablaProcesoInterfaz:[],
      hiddenId:null,
    
      combo:true,
      optionsv2: [
        { value: true, text: "Activo" },
        { value: false, text: "No Activo" },
      ],

      nombre:'',
      descripcion:'',
      metodo:'',
      orden:'',
      checked:true,
      accion:'',

      url: 'interfaz_proceso_relacion.php',

      modoAgregar : true,
      tituloModal : '',
      show : false,

    }
      
    },
    methods:{

    listar(){
          let t = this;
          const params = {
            accion:'tabla',
            activo:true
          };
          axios.post('../controladores/interfaz_proceso.php',params).then(function (response){

            t.tablaProcesoInterfaz= response.data ;
            //console.log(this.arrayUsuarios);

          })
          .catch(function (error) {
            console.log(error);
          });
        },

      comprobar(id){

        if(this.nombre != '' && this.descripcion != '' && this.metodo != ''){
        
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
        descripcion : this.descripcion,
				metodo : this.metodo,
        orden : this.orden,
        checked : this.checked,
        accion:'agregar',
			};
			
			axios.post('../controladores/interfaz_proceso.php',params)
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
				nombre: this.nombre,
        descripcion : this.descripcion,
				metodo : this.metodo,
        orden : this.orden,
        checked : this.checked,
        accion:'editar',
			};
			
			axios.post('../controladores/interfaz_proceso.php',params)
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

          this.nombre = row.nombre;
          this.descripcion = row.descripcion;
          this.metodo = row.metodo;
          this.orden = row.orden;
          this.checked = row.activo;
          this.hiddenId = row.id_dev_interfaz;


        }
    },

    cerrarModal(){
        this.show = false;
				this.nombre = '';
        this.descripcion = '';
				this.metodo = '';
        this.orden = '';
        this.checked = true;
        this.modoAgregar = true;
    },   

    filtroEmpleado(){
      let t = this;
      const params = {
        accion:'busquedaGeneral',
        busqueda:this.busqueda,
        combo:this.combo
              //activo:true
      };
      axios.post('../controladores/interfaz_proceso.php',params).then(function (response){
        //console.log(response.data);
        t.tablaProcesoInterfaz=response.data;
  
  
      })
      .catch(function (error) {
        console.log(error);
      });
    },



           
    },
    
    mounted() {
      this.listar();
    },
    
 });

