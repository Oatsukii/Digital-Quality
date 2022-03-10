<?php
include 'header.php';
?>

    <div class="container-fluid px-4"  id="DatosPerfil">
        <h1 class="mt-4">Perfil</h1>
        <ol class="breadcrumb mb-4">
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Datos Usuario
            </div>
            <div class="card-body">

            <div class="col-md-12">
                <div class="col-sm-16 col-sm-offset-4">
                  <template>
                    <div>
                      <b-table stacked :items="items" :fields="fields"></b-table>
                    </div>
                  </template>
                </div>
            </div>

            <div class="col-md-12">
              <div class="col-sm-16 col-sm-offset-4">
                    <div>
                            <b-button block variant="primary" @click="abrirModal();">
                            <p class="my-1"><strong>Cambiar Contraseña</strong></p>
                            </b-button>
                            <br>
                    </div>

              </div>
            </div>


            <b-modal v-model="modal">

              <template  slot="modal-header">
                <h5>Actualiza tu Contrase&ntilde;a</h5>
                <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </template>

              <b-container fluid>
                <div>
                  <b-form>

                    <b-form-group  class="mb-10 mt-10" label="Contrase&ntilde;a Anterior:">
                      <b-form-input type="text" v-model="pass_old" require></b-form-input>
                    </b-form-group>

                    <b-form-group  class="mb-10 mt-10" label="Contrase&ntilde;a Nueva">
                      <b-form-input  class="mb-10 mt-10" v-model="pass_new" rows="5" no-resize></b-form-input>
                    </b-form-group>

                    <b-form-group  class="mb-10 mt-10" label="Verifica Contrase&ntilde;a Nueva ">
                      <b-form-input  class="mb-10 mt-10" v-model="pass_new_repeat" rows="5" no-resize></b-form-input>
                    </b-form-group>

                  </b-form>
                </div>
              </b-container>

              <div slot="modal-footer" class="w-100">
                <b-button variant="primary" class="float-right ml-2" @click="cambiarContrasenia();">Agregar <i class="fas fa-plus-circle"></i></b-button>
              </div>

            </b-modal>
        </div>
      </div>
    </div>


      <script type="text/javascript" src="../js/perfil/perfil.js"></script>

<?php
include 'footer.php';
?>

