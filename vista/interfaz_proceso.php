<?php
include 'header.php';
?>

<div class="card"  id="DatosProcesoInterfaz">

      <div class="card-header">
        <H4><strong>Proceso</strong></H4>
      </div>

  <div class="col-md-12">
      <br>
          <div class="row">
              <div class="col-md-6">
                    <input type="text" class="form-control" v-model="busqueda"  @keyup.enter="filtroEmpleado()"/>
              </div>

              <div class="col-md-3">
                <b-form-select v-model="combo" class="mb-3" :options="optionsv2"></b-form-select>
              </div>

              <div class="col-md-3">
                    <button type="button" name="filter" class="btn btn-info btn-xs" @click="filtroEmpleado">B&uacute;squeda</button>
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
                                        <th scope="col">M&eacute;todo</th>
                                        <th scope="col">Orden</th>
                                        <th scope="col">Relaci&oacute;n</th>
                                        <th scope="col">Editar</th>
                                    </tr>
                                </thead>
                                  <tbody>
                                      <tr v-for="interfaz in tablaProcesoInterfaz"  :key="interfaz.id_dev_interfaz">
                                      <td v-text="interfaz.id_dev_interfaz"></td>
                                      <td v-text="interfaz.nombre"></td>
                                      <td v-text="interfaz.metodo"></td>
                                      <td v-text="interfaz.orden"></td>
                                      <td><a v-bind:href="`${url +`?action=`+interfaz.id_dev_interfaz}`">Relaci&oacute;n</a></td>
                                      <td><button type="button" name="editar" class="btn btn-success edit"  @click="abrirModal('',interfaz)">Editar</button></td>
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
                  <b-form-input type="text" v-model="nombre" require></b-form-input>
                </b-form-group>

                <b-form-group  class="mb-0 mt-0" label="Descripci&oacute;n:">
                  <b-form-input type="text" v-model="descripcion" require></b-form-input>
                </b-form-group>


                <b-form-group  class="mb-0 mt-0" label="M&eacute;todo:">
                  <b-form-input type="text" v-model="metodo"></b-form-input>
                </b-form-group>

                <b-form-group  class="mb-10 mt-10" label="Orden:">
                  <b-form-input type="text" v-model="orden" placeholder="0.01" step="0.01"></b-form-input>
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

    </div>



</div>

<script type="text/javascript" src="../js/interfaz-proceso/interfaz-proceso.js"></script>


<?php
include 'footer.php';
?>

