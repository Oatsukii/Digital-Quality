var login = new Vue({
    el:'#login',

    data:{  
        roles: null,

        user:'',
        password:'',
        comboRol:'',
        rolusuario:null,
    },

    
    methods:{

		keymonitor: function(event) {
            if(event.key == "Enter"){
                login.buscarRoles();
         }
        },

    buscarUsuario(){
            
        let l = this;

            if (this.user != '' && this.password != '') { 
               //return axios.post("controladores/login.php", {user:this.user,password:this.password,accion:'buscarusuario'
               const r = axios.post("controladores/login.php", {user:this.user,password:this.password,accion:'buscarusuario'

                }).then(function (response) { 

                    if(response.data != null && response.data.length > 0){
                        //l.comboRol=response.data;
                        login.buscarRoles(); 

                    }else{
                        Swal.fire(
                            'Error!',
                            'El usuario no existe.',
                            'error'
                        );
                    }
                    
                })
                .catch(function (response) {  
                    console.log(response); 
                })

            } else {

                if(this.user == ''){
					Swal.fire(
						'Error!',
						'El campo usuario esta vacío.',
						'error'
					);
                }else if(this.password == ''){
					Swal.fire(
						'Error!',
						'El campo contraseña esta vacío.',
						'error'
					);
                }    

            } 
    },

    async buscarRoles(){
            let l = this;
            if (this.user != '' && this.password != '') { 
                await axios.post("controladores/login.php", {user:this.user,password:this.password,accion:'rolusuario'
                }).then(function (response) { 

                    if(response.data){
                        l.comboRol=response.data;
                        document.getElementById("comboRolUsuario").style.display = "block"; 
                        document.getElementById("btnbuscar").style.display = "none"; 
                        document.getElementById("btnacceder").style.display = "block"; 

                    }
                    return response.data;

                })
                .catch(function (response) {  
                    console.log(response); 
                })     
            } 
    },

    acceder(){
        let l = this;

        const params = {
            user:this.user
            ,password:this.password
            ,rol:this.rolusuario
            ,accion:'acceder'
        };

        //console.log(params);
            
            if (this.user  != '' && this.password != '' && this.rolusuario != null) {

                axios.post("controladores/login.php", params)
                .then(function (response) { 

                    if(response.status == 200){

                        window.location.href="vista/dash.php";

                    }else{

                        window.location.href="vista/logout.php";

                    }
                    
                })
                .catch(function (response) {  
                    console.log(response); 
                })

            } else {

                if(this.user == ''){
					Swal.fire(
						'Error!',
						'El campo usuario esta vacío.',
						'error'
					);
                }else if(this.password == ''){
					Swal.fire(
						'Error!',
						'El campo contraseña esta vacío.',
						'error'
					);
                }else if(this.rolusuario == null ){
					Swal.fire(
						'Error!',
						'Favor de seleccionar un rol',
						'error'
					);
                }

            } 
    },


    cancelar(){ 
        //location.href="vista/logout";
        window.location.href="vista/logout.php";

    },


    },
    //async mounted() {   this.roles= null   },
    // created:function(){  this.roles= null  }

   });  