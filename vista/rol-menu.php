<?php

  include 'header.php';
  $IDRol = $_GET['action'];

?>

<div class="card" id="DatosRolMenu">

        <input type="hidden" id="id_rol" value="<?php echo $IDRol ?> " />

        <div class="card-header" >

              <div v-for="rol in datosEncabezado" :key="rol.id"  >
                  <H2>Rol: <strong v-text="rol.nombre"></strong></H2>
              </div>

        </div>
  
        <div class="col-md-12">
                      <div class="form-group">
                          <label>Men&uacute;</label>
                            <select class='form-control' v-model="menu">
                            <option value='0'>Selecciona Men&uacute;</option>
                            <option v-for="rows in comboMenu" v-bind:value='rows.id_menu'>{{ rows.nombre }}</option>
                            </select>
                      </div>

                    <div class="col-md-12 text-right">
                        <button @click="agregar" class="btn btn-primary">Agregar</button>
                    </div>
                    <br>
        </div>
                        <!-- <input type="button" class="btn btn-primary float-right" @click="agregarLineas" value="Agregar" /><br><br><br> -->

      <div class="col-md-12">
                <div class="col-sm-16 col-sm-offset-4">
                      <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Men&uacute;</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Orden</th>
                                        <th scope="col"></th>
                                </thead>
                                    <tbody>
                                    <tr v-for="row in tablaRolMenu">
                                        <td>{{ row.nombremenu}}</td>
                                        <td>{{ row.activorolmenu}}</td>
                                        <td>{{ row.orden}}</td>
                                        <td><button type="button" name="eliminar" class="btn btn-danger delete"  @click="eliminar(row.id_rol_menu)">Eliminar</button></td>
                                    </tbody>
                              </table>  
                        </div>
                  </div>

            <br>
      </div>

</div>

<script type="text/javascript" src="../js/rol-menu/rol-menu.js"></script>
<script type="text/javascript" src="../js/rol-menu/validacion.js"></script>

<?php
include 'footer.php';
?>

