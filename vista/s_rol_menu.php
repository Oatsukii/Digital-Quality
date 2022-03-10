<?php
include 'header.php';
?>

    <div class="container-fluid px-4" id="DatosRolMenu">


        <div v-for="rol in datosEncabezado">
            <h2 class="mt-4">Rol: <strong v-text="rol.nombre"></strong></h2>
        </div>

        
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active"></li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">

                <div class="float-left ml-2">
                    <i class="fas fa-table me-1"></i>
                    Rol Men&uacute;
                </div>
                <div class="float-right ml-2">
                    <b-button class="btn btn-info" onclick="history.back()">Regresar</b-button>
                </div>
            </div>

            <div class="card-body">

            <!-- Proceso Programacion -->
            <div class="col-md-12"  >
                <br>

                <div class="row">
                    <div class="col-md-4">
                        <b-form-group  class="mb-10 mt-10" label="Empresas:">
                            <b-form-select v-model="id_s_empresa" class="mb-3" >
                                <option :value="null">Selecciona una opci&oacute;n</option>
                                <option v-for="rows in EmpresaCollection" :value="rows.id_s_empresa">
                                    {{ rows.nombre }}
                                </option>
                            </b-form-select >
                        </b-form-group>
                    </div>
                    <div class="col-md-4">
                        <b-form-group  class="mb-10 mt-10" label="Menu:">
                            <b-form-select v-model="id_s_menu" class="mb-3" >
                                <option :value="null">Selecciona una opci&oacute;n</option>
                                <option v-for="rows in MenuCollection" :value="rows.id_s_menu">
                                    {{ rows.nombre }}
                                </option>
                            </b-form-select >
                        </b-form-group>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 text-right">
                        <button @click="comprobar(1);" class="btn btn-primary">Agregar</button>
                    </div>
                </div>

                <div class="col-md-12">
                    <br>
                    <div class="col-sm-16 col-sm-offset-4">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Men&uacute;</th>
                                        <th scope="col">Rol</th>
                                        <th scope="col">Empresa</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                             
                                <tbody>
                                    <tr v-for="row in tablaRolMenu" :key="row.id_s_rol_menu">
                                        <td v-text="row.menu"></td>
                                        <td v-text="row.rol"></td>
                                        <td v-text="row.empresa"></td>
                                        <td><button type="button" name="eliminar" class="btn btn-danger delete"  @click="eliminar(row.id_s_rol_menu)">Eliminar</button></td>
                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="../js/s_rol_menu/s_rol_menu.js"></script>

<?php
include 'footer.php';
?>

