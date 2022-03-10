<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="bootstrap/loginNuevo.css">


    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
	  <script src="https://unpkg.com/axios@0.25.0/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script src="//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.min.js"></script>
    <link rel="icon" href="image/desarrollo_refividrio.ico">
    <title>KOSTEN</title>
</head>
<body>
    <div class="login" id="login">
      
        <div class="container">
            <div class="alert alert-danger" role="alert" id="msgErro" style="display:none"></div>
            <div class="alert alert-success" role="alert" id="msg" style="display:none"></div>
            <br>
            <h1>Iniciar sesión</h1>
                <input type="text" id="user" v-model="user" placeholder="USUARIO" required/>
                <input type="password" id="password" v-model="password" placeholder="CONTRASEÑA" required/>

                <select style="display:none" class="form-control" id="rol"></select><br/>

                <b-form-select v-model="rolusuario"  class="mb-4 mt-10" id="comboRolUsuario" style="display:none">
                  <option value="null">Selecciona una opci&oacute;n</option>
                  <option v-for="rows in comboRol" :value="rows.id_s_rol"><label v-text="rows.nombrerol"></label></option>
                </b-form-select>


                <button type="submit" id="btnbuscar" class="btn btn-block btn-large colorBoton"  @click="buscarUsuario">Entrar</button>
                <button type="submit" id="btnacceder" class="btn btn-block btn-large colorBoton" @click="acceder" style="display:none">Acceder</button>
                <br>
                <button type="submit" id="buttonCancel" class="btn btn-block btn-large colorBoton" @click="cancelar">Cancelar</button>
    
        </div>

    </div>
</body>
</html>

<script src="js/login.js"></script>
