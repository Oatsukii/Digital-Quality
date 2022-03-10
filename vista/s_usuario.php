<?php
include 'header.php';
?>

    <div class="container-fluid px-4">
        <h1 class="mt-4">Usuarios</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active"></li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Datos de Usuario
            </div>
            <div class="card-body">

            <!-- Proceso Programacion -->
            <div class="col-md-12"  id="DatosUsuarios">
                <br>

                  <div class="row">
                        <div class="col-md-6">
                              <input type="text" class="form-control" v-model="busqueda"  @keyup.enter="filtroUsuario()"/>
                        </div>

                        <div class="col-md-3">
                          <b-form-select v-model="combo" class="mb-3" :options="optionsv2"></b-form-select>
                        </div>

                        <div class="col-md-3">
                              <button type="button" name="filter" class="btn btn-info btn-xs" @click="filtroUsuario()">B&uacute;squeda</button>
                        </div>
                  </div>

                  <div class="row">
                        <div class="col-md-12 text-right">
                        <button @click="abrirModal('agregar')" class="btn btn-primary">Nuevo</button>
                        </div>
                  </div>
                  <br>      
                  
                  <div class="col-sm-16 col-sm-offset-4">
                        <div class="table-responsive">
                                      <table class="table table-bordered">
                                          <thead>
                                              <tr>
                                                  <th scope="col">ID</th>
                                                  <th scope="col">Nombre</th>
                                                  <th scope="col">Usuario</th>
                                                  <th scope="col">Rol</th>
                                                  <th scope="col">Editar</th>
                                                  <th scope="col">Password</th>
                                              </tr>
                                          </thead>
                                            <tbody>
                                                <tr v-for="usuario in arrayUsuarios"  :key="usuario.id_s_usuario">
                                                <td v-text="usuario.id_s_usuario"></td>
                                                <td v-text="usuario.nombre"></td>
                                                <td v-text="usuario.usuario"></td>
                                                <td><button type="button" name="rol" class="btn btn-secondary btn-xs edit" @click="abrirModalRol(usuario)">Rol</button></td>
                                                <td><button type="button" name="editar" class="btn btn-success edit"  @click="abrirModal('',usuario.id_s_usuario)">Editar</button></td>
                                                <td><button type="button" name="reiniciar" class="btn btn-info reset"  @click="cambiarcontrasenia(usuario.id_s_usuario)">Reiniciar</button></td>
                                            </tbody>
                                      </table>  
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
                        
                          <b-form-group  class="mb-0 mt-0" label="Nombre:">
                            <b-form-input type="text" v-model="first_name" require></b-form-input>
                          </b-form-group>

                          <b-form-group  class="mb-0 mt-0" label="Apellido Paterno:">
                            <b-form-input type="text" v-model="paternal_name"></b-form-input>
                          </b-form-group>

                          <b-form-group  class="mb-0 mt-0" label="Apellido Materno:">
                            <b-form-input type="text" v-model="maternal_name"></b-form-input>
                          </b-form-group>

                          <b-form-group  class="mb-0 mt-0" label="Usuario:">
                            <b-form-input type="text" v-model="user"></b-form-input>
                          </b-form-group>

                          <b-form-group  class="mb-0 mt-0" label="ID ADempiere Usuario:">
                            <b-form-input type="text" v-model="ad_user"></b-form-input>
                          </b-form-group>

                          <b-form-group  class="mb-10 mt-10" label="Empresas:">
                                    <b-form-select v-model="id_s_empresa" class="mb-3" >
                                        <option :value="null">Selecciona una opci&oacute;n</option>
                                        <option v-for="rows in EmpresaCollection" :value="rows.id_s_empresa">
                                            {{ rows.nombre }}
                                        </option>
                                    </b-form-select>
                          </b-form-group>

                          <b-form-group class="mb-0 mt-0" label="Activo:">
                                  <b-form-checkbox
                                    v-model="checked"
                                    name="flavour-3a"
                                  >
                                  </b-form-checkbox>
                          </b-form-group>
                                
                        </b-form>
                      </div>
                    </b-container>

                      <div slot="modal-footer" class="w-100">
                        <b-button v-if="modoAgregar"
                          variant="primary"
                          class="float-right ml-2"
                          @click="comprobar(1);"
                        >Agregar
                        <i class="fas fa-plus-circle"></i>
                        </b-button>

                        <b-button v-else
                          variant="primary"
                          class="float-right ml-2"
                          @click="comprobar(2);"
                        >Editar
                        <i class="fas fa-pen"></i>
                        </b-button>

                        <b-button
                          variant="danger"
                          class="float-right"
                          @click="cerrarModal()"
                        >
                        Cerrar
                        <i class="fas fa-times-circle"></i>
                        </b-button>
                      </div>

                    </b-modal>


              <!--inicio del modal roles-->
              <b-modal v-model="rol">
                      <template  slot="modal-header">
                        <!-- Emulate built in modal header close button action -->
                        
                        <h5>{{tituloModalRol}}</h5>
                        <button type="button" class="close" @click="cerrarModalRol()" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                          </button>
                          
                      </template>
                      
                    <b-container fluid>
                      <div v-for="r in rols">
                        <b-form>
                          <b-form-group class="mb-0 mt-0">
                                  <b-form-checkbox v-model="r.selected" v-bind:id="'check_' + r.id_s_rol">{{ r.nombre }}</b-form-checkbox>
                          </b-form-group>
                        </b-form>
                      </div>
                    </b-container>

                      <div slot="modal-footer" class="w-100">
                        <b-button variant="primary" class="float-right ml-2" @click="guardarRol">Guardar</b-button>

          
                        <b-button
                          variant="danger"
                          class="float-right"
                          @click="cerrarModalRol()"
                        >
                        Cerrar
                        <i class="fas fa-times-circle"></i>
                        </b-button>
                      </div>

                    </b-modal>

              </div>
            <!-- Proceso Programacion -->
            </div>
        </div>
      </div>

      
    <script type="text/javascript" src="../js/s_usuario/s_usuario.js"></script>

<?php
include 'footer.php';
?>

