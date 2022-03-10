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
                <i class="fas fa-table me-1"></i>
                Men&uacute;
            </div>
            <div class="card-body">

            <!-- Proceso Programacion -->
            <div class="col-md-12"  id="DatosMenu">
                <br>

                <div class="row">
                    <div class="col-md-12 text-right">
                        <button @click="abrirModal('agregar')" class="btn btn-primary">Nuevo</button>
                    </div>
                </div>

                <div class="col-md-12">
                    <br>
                    <div class="col-sm-16 col-sm-offset-4">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Orden</th>
                                        <th scope="col">Relaci&oacute;n</th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                             
                                <tbody>
                                    <tr v-for="row in tablaMenu" :key="row.id_s_menu">
                                        <td v-text="row.nombre"></td>
                                        <td v-text="row.estadoactivo"></td>
                                        <td v-text="row.orden"></td>
                                        <td><a v-bind:href="`${menuRelacion +`?action=`+row.id_s_menu}`">Relaci&oacute;n</a></td>
                                        <td><button type="button" name="editar" class="btn btn-success edit"  @click="abrirModal('',row)">Editar</button></td>
                                        <td><button type="button" name="eliminar" class="btn btn-danger delete"  @click="eliminar(row.id_s_menu)">Eliminar</button></td>
                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <!--inicio del modal-->
                <b-modal v-model="show">
                    <template  slot="modal-header">
                        <!-- Emulate built in modal header close button action -->
                        <h5>{{tituloModal}}</h5>
                       <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                           <span aria-hidden="true">×</span>
                        </button>
                    </template>
            
                    <b-container fluid>
                        <div>
                            <b-form>
              
                                <b-form-group  class="mb-10 mt-10" label="Nombre:">
                                     <b-form-input type="text" v-model="nombre" require></b-form-input>
                                </b-form-group>

                                <b-form-group  class="mb-10 mt-10" label="URL">
                                     <b-form-input type="text" v-model="url"></b-form-input>
                                </b-form-group>

                                <b-form-textarea  class="mb-10 mt-10" label="SVG:" v-model="svg" rows="5" no-resize></b-form-textarea>

                                <b-form-group  class="mb-10 mt-10" label="Orden:">
                                     <b-form-input type="text" v-model="orden" placeholder="0.01" step="0.01"></b-form-input>
                                </b-form-group>
                                <!-- 
                                <b-form-group  class="mb-10 mt-10" label="Empresas:">
                                    <b-form-select v-model="id_s_empresa" class="mb-3" >
                                        <option :value="null">Selecciona una opci&oacute;n</option>
                                        <option v-for="rows in EmpresaCollection" :value="rows.id_s_empresa">
                                            {{ rows.nombre }}
                                        </option>
                                    </b-form-select form-select>
                                </b-form-group> -->

                                <b-form-group class="mb-10 mt-10">
                                    <b-form-checkbox v-model="checked">
                                        <label>Activo</label>
                                    </b-form-checkbox>
                                </b-form-group>

                                <b-form-group class="mb-10 mt-10">
                                    <b-form-checkbox v-model="principal">
                                        <label>Principal</label>
                                    </b-form-checkbox>
                                </b-form-group>
                            </b-form>
                        </div>
                    </b-container>

                    <div slot="modal-footer" class="w-100">
                        <b-button v-if="modoAgregar" variant="primary" class="float-right ml-2" @click="comprobar(1);">Agregar
                            <i class="fas fa-plus-circle"></i>
                        </b-button>

                        <b-button v-else variant="primary" class="float-right ml-2" @click="comprobar(2);"> Editar
                            <i class="fas fa-pen"></i>
                        </b-button>

                        <b-button variant="danger" class="float-right" @click="cerrarModal()">Cerrar
                            <i class="fas fa-times-circle"></i>
                        </b-button>
                    </div>
                </b-modal>
                
            <div>
        </div>
    </div>

    <script type="text/javascript" src="../js/s_menu/s_menu.js"></script>

<?php
include 'footer.php';
?>

