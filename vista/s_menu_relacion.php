<?php
include 'header.php';
?>

    <div class="container-fluid px-4">
        <h1 class="mt-4">Men&uacute;</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active"></li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">

                <div class="float-left ml-2">
                    <i class="fas fa-table me-1"></i>
                    Men&uacute; Relaci&oacute;n
                </div>
                <div class="float-right ml-2">
                    <b-button class="btn btn-info" onclick="history.back()">Regresar</b-button>
                </div>
            </div>

            <div class="card-body">

            <!-- Proceso Programacion -->
            <div class="col-md-12"  id="MenuRelacion">
                <br>

                <div class="row">
                    <div class="col-md-6">
                        <b-form-group  class="mb-10 mt-10" label="Empresas:">
                            <b-form-select v-model="id_s_empresa" class="mb-3" >
                                <option :value="null">Selecciona una opci&oacute;n</option>
                                <option v-for="rows in EmpresaCollection" :value="rows.id_s_empresa">
                                    {{ rows.nombre }}
                                </option>
                            </b-form-select >
                        </b-form-group>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 text-right">
                        <button @click="comprobar(1);" class="btn btn-primary">Nuevo</button>
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
                                        <th scope="col">Empresa</th>
                                        <th scope="col">Activo</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                             
                                <tbody>
                                    <tr v-for="row in tablaMenuRelacion" :key="row.id_s_menu_relacion">
                                        <td v-text="row.nombre_menu"></td>
                                        <td v-text="row.nombre_empresa"></td>
                                        <td v-text="row.estadoactivo"></td>
                                        <td><button type="button" name="eliminar" class="btn btn-danger delete"  @click="eliminar(row.id_s_menu_relacion)">Eliminar</button></td>
                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            <div>
        </div>
    </div>

    <script type="text/javascript" src="../js/s_menu_relacion/s_menu_relacion.js"></script>

<?php
include 'footer.php';
?>

