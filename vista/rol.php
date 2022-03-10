<?php
include 'header.php';
?>

<div class="card" id="DatosRol">

      <div class="card-header">
        <H4><strong>Rol</strong></H4>
      </div>

      <div class="col-md-12">
      <br>
          <div class="row">
              <div class="col-md-12 text-right">
              <button @click="abrirModal('agregar')" class="btn btn-primary">Nuevo</button>
              </div>
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
                                  <th scope="col">Relaci&oacute;n Men&uacute;</th>
                                  <th scope="col">Relaci&oacute;n Interfaz</th>
                                  <th scope="col"></th>
                                  <th scope="col"></th>
                              </tr>
                          </thead>
                              <tbody>
                                  <tr v-for="row in tablaRol">
                                  <td v-text="row.nombre"></td>
                                  <td v-text="row.estadoactivo"></td>
                                  <td><a v-bind:href="`${url +`?action=`+row.id_rol}`">Relaci&oacute;n</a></td>
                                  <td><a v-bind:href="`${url2 +`?action=`+row.id_rol}`">Relaci&oacute;n</a></td>
                                  <td><button type="button" name="editar" class="btn btn-success edit"  @click="abrirModal('',row)">Editar</button></td>
                                  <td><button type="button" name="eliminar" class="btn btn-danger delete"  @click="eliminar(row.id_rol)">Eliminar</button></td>
                              </tbody>
                            </table>  
                </div>
            </div>
    </div>

 <!--inicio del modal-->
 <b-modal v-model="modalRol">
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
              
                <b-form-group  class="mb-10 mt-10" label="Rol:">
                  <b-form-input type="text" v-model="rol" require></b-form-input>
                </b-form-group>

                <b-form-group  class="mb-10 mt-10" label="Al&iacute;as">
                  <b-form-input type="text" v-model="alias"></b-form-input>
                </b-form-group>

                <b-form-group class="mb-10 mt-10">
                        <b-form-checkbox
                          v-model="checked"
                        ><label>Activo</label>
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

</div>

<script type="text/javascript" src="../js/rol/rol.js"></script>

<?php
include 'footer.php';
?>

