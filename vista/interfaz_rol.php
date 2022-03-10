<?php
include 'header.php';
?>

<div class="card"  id="DatosInterfazRol">

      <div class="card-header">
        <H4><strong>Interfaz</strong></H4>
      </div>

  <div class="col-md-12">
         <br>

         <div class="form-group">
                          <label>Empresa:</label>
                              <select class='form-control' v-model="empresa" @change='listadoProceso()'>
                              <option value='0' >Selecciona Empresa</option>
                              <option v-for="rows in comboEmpresa" v-bind:value='rows.id_servidor_origen'>{{ rows.nombre }}</option>
                              </select>
          </div>

         <br>      
        
        <div class="col-sm-16 col-sm-offset-4">
              <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Empresa</th>
                                        <th scope="col">Proceso</th>
                                        <th scope="col">Orden</th>
                                        <th scope="col">Sincronizar</th>
                                    </tr>
                                </thead>
                                  <tbody>
                                      <tr v-for="interfaz in tablaProcesoInterfaz"  :key="interfaz.id_dev_interfaz_origen">
                                      <td v-text="interfaz.id_dev_interfaz_origen"></td>
                                      <td v-text="interfaz.empresa"></td>
                                      <td v-text="interfaz.proceso"></td>
                                      <td v-text="interfaz.orden"></td>
                                      <td><button type="button" name="ejecutar" class="btn btn-info"  @click="ejecutarProceso(interfaz)">Sincronizar</button></td>
                                  </tbody>
                            </table>  
               </div>
         </div>
    </div>

</div>

<script type="text/javascript" src="../js/interfaz-rol/interfaz-rol.js"></script>


<?php
include 'footer.php';
?>

