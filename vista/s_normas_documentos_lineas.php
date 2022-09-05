<?php
  include 'header.php';
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Documento Certificaci&oacute;n</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active"></li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>Documento Certificaci&oacute;n
            </div>
            <div class="card-body">
    
                <div class="col-md-12"  id="normas_lineas">
                    <br>

                    <div class="row">
                        <div class="col-md-12 text-left">
                            <b-button pill variant="outline-secondary" onclick="history.back()">Regresar</b-button>
                        </div>

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
                                        <th scope="col">Nombre Documento</th>
                                        <th scope="col">Fecha Disponible</th>
                                        <th scope="col">Activo</th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="row in documentosColeccion">
                                        <td v-text="row.id_s_norma_documento_linea"></td>
                                        <td v-text="row.nombre_archivo"></td>
                                        <td v-text="row.fecha_disponible"></td>
                                        <td v-text="row.status_activo"></td>
                                        <td>
                                            <b-button  variant="primary" class="form-control" @click="obtenerArchivo(row.archivo, row.nombre_archivo);">Ver Archivo</b-button>
                                        </td>
                                        <td><button type="button" name="editar" class="btn btn-success edit"  @click="abrirModal('',row)">Editar</button></td>
                                        <td><button type="button" name="eliminar" class="btn btn-danger delete"  @click="eliminar(row.id_s_norma_documento_linea)">Eliminar</button></td>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!--inicio del modal-->
                    <b-modal v-model="modalCrud">

                        <template  slot="modal-header">
                            <h5>{{tituloModal}}</h5>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </template>

                        <b-container fluid>
                            <div>
                                <b-form>

                                    <b-form-group  class="mb-10 mt-10" label="Nombre Referencia Documento:">
                                        <b-form-input type="text" v-model="nombre_archivo" require></b-form-input>
                                    </b-form-group>

                                    <b-form-group  class="mb-10 mt-10" label="Fecha Disponible:">
                                        <b-form-input type="date" v-model="fecha_disponible" require></b-form-input>
                                    </b-form-group>

                                    <b-form-group  class="mb-10 mt-10">
                                        <input type="file" class="mmb-3 form-control"  id="file" accept="application/pdf">
                                    </b-form-group>

                                    <b-form-group class="mb-10 mt-10">
                                        <b-form-checkbox v-model="esactivo"><label>Activo</label></b-form-checkbox>
                                    </b-form-group>

                                </b-form>
                            </div>
                        </b-container>

                        <div slot="modal-footer" class="w-100">
                            <b-button v-if="modoAgregar" variant="primary" class="float-right ml-2" @click="cargar();">
                                Agregar<i class="fas fa-plus-circle"></i>
                            </b-button>

                            <b-button v-else variant="primary"class="float-right ml-2" @click="comprobar(2);">
                                Editar<i class="fas fa-pen"></i>
                            </b-button>

                            <b-button variant="danger" class="float-right" @click="cerrarModal()">
                                Cerrar <i class="fas fa-times-circle"></i>
                            </b-button>
                        </div>
                    </b-modal>

                </div>


            </div>
        </div>
      </div>

      
      <script type="text/javascript" src="../js/s_normas_documentos/s_normas_documentos_lineas.js"></script>

<?php
include 'footer.php';
?>