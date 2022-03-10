<?php
include 'header.php';
$ID = $_GET['action'];

?>

<div class="card" id="DatosProcesoInterfazRelacion">

        <input type="hidden" id="id_principal" value="<?php echo $ID ?> " />

        <div class="card-header" >
              <div v-for="alm in datosEncabezado">
                            <div class="col-md-12">
                                    <div class="row">
                                            <div class="col-md-0">
                                                    <b-button pill variant="outline-secondary" onclick="history.back()">Regresar</b-button>
                                            </div>
                    
                                            <div class="col-md-6">
                                                    <H4><strong v-text="alm.nombre"></strong></H4>
                                            </div>
                                    </div>
                            </div>
              </div>
              
        </div>
  
        <div class="col-md-12">

                      <div class="form-group">
                      <br>
                          <label>Conexi&oacute;n</label>
                              <select class='form-control' v-model="empresa">
                              <option value='0' >Selecciona Empresa</option>
                              <option v-for="rows in comboEmpresa" v-bind:value='rows.id_servidor_origen'>{{ rows.nombre }}</option>
                              </select>
                      </div>

                        <div>
                                <b-button block variant="primary" @click="comprobar(1);">
                                    <p class="my-1"><strong>Agregar</strong></p>
                                    </b-button>
                                <br>
                        </div>

        </div>

      <div class="col-md-12">
                <div class="col-sm-16 col-sm-offset-4">
                      <div class="table-responsive">
                            <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Empresa</th>
                                            <th scope="col"></th>
                                    </thead>
                                    <tbody>
                                    <tr v-for="row in tablaLineas">
                                        <td v-text="row.empresa"></td>
                                        <td><button type="button" name="eliminar" class="btn btn-danger delete"  @click="eliminar(row.id_dev_interfaz_origen)">Eliminar</button></td>
                                    </tbody>
                              </table>  
                        </div>
                  </div>

            <br>
      </div>




</div>

<script type="text/javascript" src="../js/interfaz-proceso-lineas/interfaz-proceso-lineas.js"></script>
<script type="text/javascript" src="../js/interfaz-proceso-lineas/validacion.js"></script>

<?php
include 'footer.php';
?>