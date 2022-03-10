<?php
  include 'header.php';
?>

<div class="card" id="DatosRolInterfaz">

        <div class="card-header" >

              <div v-for="rol in datosEncabezado" :key="rol.id"  >
                  <H2>Rol: <strong v-text="rol.nombre"></strong></H2>
              </div>

        </div>
  
        <div class="col-md-12">

                    <br>

                    <div class="form-group">
                        <label>Empresa:</label>
                            <select class='form-control' v-model="empresa" @change='comboListadoInterfazEmpresa();'>
                            <option value='0' >Selecciona Empresa</option>
                            <option v-for="rows in comboEmpresa" v-bind:value='rows.id_servidor_origen'>{{ rows.nombre }}</option>
                            </select>
                    </div>

                    <div class="form-group">
                          <label>Interfaz</label>
                            <select class='form-control' v-model="interfaz">
                            <option value='0'>Selecciona una Opci&oacute;n</option>
                            <option v-for="rows in comboInterfaz" v-bind:value='rows.id_dev_interfaz_origen'>{{ rows.proceso }}</option>
                            </select>
                    </div>


                    <div class="row">


                            <div class="col-md-10">
                                    <div class="col-md-12 text-right">
                                        <button @click="agregar" class="btn btn-primary">Agregar</button>
                                    </div>
                            </div>

                            <div class="col-md-2">
                                    <div class="col-md-12 text-right">
                                        <b-button pill variant="outline-secondary" onclick="history.back()">Regresar</b-button>
                                    </div>
                            </div>

                    </div>

                    <br>
        </div>

      <div class="col-md-12">
                <div class="col-sm-16 col-sm-offset-4">
                      <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Empresa</th>
                                        <th scope="col">Proceso</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Orden</th>
                                        <th scope="col"></th>
                                </thead>
                                    <tbody>
                                    <tr v-for="row in tablaProcesoInterfaz">
                                        <td>{{ row.empresa}}</td>
                                        <td>{{ row.proceso}}</td>
                                        <td>{{ row.activorolmenu}}</td>
                                        <td>{{ row.orden}}</td>
                                        <td><button type="button" name="eliminar" class="btn btn-danger delete"  @click="eliminar(row.id_dev_interfaz_rol)">Eliminar</button></td>
                                    </tbody>
                              </table>  
                        </div>
                  </div>

            <br>
      </div>

</div>

<script type="text/javascript" src="../js/rol-interfaz/rol-interfaz.js"></script>

<?php
include 'footer.php';
?>

