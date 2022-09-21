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

                                    <b-form-group  class="mb-10 mt-10" v-if="hiddenId == null">
                                        <label>Cargar Archivo</label>
                                        <input type="file" class="mmb-3 form-control"  id="file" accept="application/pdf">
                                    </b-form-group>

                                    <b-form-group  class="mb-10 mt-10" v-else>
                                        <!-- <input type="file" class="mmb-3 form-control"  id="file" accept="application/pdf"> -->

                                        <b-form-checkbox v-model="actualizarArchivo" name= "ce" id="archivo"><label for="archivo">Cambiar Archivo</label></b-form-checkbox>
                                        <button v-if="actualizarArchivo == false" type="button" class="btn-link btn" @click= "obtenerArchivo(archivo_bytea, nombre_archivo);" >
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-file-earmark-pdf-fill" viewBox="0 0 24 16">
                                                <path d="M5.523 12.424c.14-.082.293-.162.459-.238a7.878 7.878 0 0 1-.45.606c-.28.337-.498.516-.635.572a.266.266 0 0 1-.035.012.282.282 0 0 1-.026-.044c-.056-.11-.054-.216.04-.36.106-.165.319-.354.647-.548zm2.455-1.647c-.119.025-.237.05-.356.078a21.148 21.148 0 0 0 .5-1.05 12.045 12.045 0 0 0 .51.858c-.217.032-.436.07-.654.114zm2.525.939a3.881 3.881 0 0 1-.435-.41c.228.005.434.022.612.054.317.057.466.147.518.209a.095.095 0 0 1 .026.064.436.436 0 0 1-.06.2.307.307 0 0 1-.094.124.107.107 0 0 1-.069.015c-.09-.003-.258-.066-.498-.256zM8.278 6.97c-.04.244-.108.524-.2.829a4.86 4.86 0 0 1-.089-.346c-.076-.353-.087-.63-.046-.822.038-.177.11-.248.196-.283a.517.517 0 0 1 .145-.04c.013.03.028.092.032.198.005.122-.007.277-.038.465z"/>
                                                <path fill-rule="evenodd" d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2zm5.5 1.5v2a1 1 0 0 0 1 1h2l-3-3zM4.165 13.668c.09.18.23.343.438.419.207.075.412.04.58-.03.318-.13.635-.436.926-.786.333-.401.683-.927 1.021-1.51a11.651 11.651 0 0 1 1.997-.406c.3.383.61.713.91.95.28.22.603.403.934.417a.856.856 0 0 0 .51-.138c.155-.101.27-.247.354-.416.09-.181.145-.37.138-.563a.844.844 0 0 0-.2-.518c-.226-.27-.596-.4-.96-.465a5.76 5.76 0 0 0-1.335-.05 10.954 10.954 0 0 1-.98-1.686c.25-.66.437-1.284.52-1.794.036-.218.055-.426.048-.614a1.238 1.238 0 0 0-.127-.538.7.7 0 0 0-.477-.365c-.202-.043-.41 0-.601.077-.377.15-.576.47-.651.823-.073.34-.04.736.046 1.136.088.406.238.848.43 1.295a19.697 19.697 0 0 1-1.062 2.227 7.662 7.662 0 0 0-1.482.645c-.37.22-.699.48-.897.787-.21.326-.275.714-.08 1.103z"/>
                                            </svg>Ver archivo: {{ nombre_archivo }}
                                        </button>
                                        <input type="file" v-else class="mmb-3 form-control"  id="file" accept="application/pdf">


                                    </b-form-group>

                                    <b-form-group class="mb-10 mt-10">
                                        <b-form-checkbox v-model="esactivo"><label>Activo</label></b-form-checkbox>
                                    </b-form-group>

                                </b-form>
                            </div>
                        </b-container>

                        <div slot="modal-footer" class="w-100">
                            <b-button v-if="modoAgregar" variant="primary" class="float-right ml-2" @click="comprobar(1);">
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