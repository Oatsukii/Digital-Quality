<?php
include 'header.php';
?>

<div class="card" id="OrdenVenta">

    <div class="card-header">
        <H4><strong>Orden de Venta</strong></H4>
    </div>

    <div class="col-md-12">
        <div class="col-sm-16 col-sm-offset-4">
         <br>

         

                <label>Listado de Conexiones:</label>
                <div v-for="row in opcionVenta">
                        <b-form-radio v-model="picked" :value="row.id_servidor_datos_orden" v-on:change="comboServidorAlmacen"><span v-text="row.nombre"></span></b-form-radio>
                </div>

                <div class="card-body">

                <b-container fluid>
                
                        <div class="form-group">
                            <label>ID Orden</label>
                                <input type="text" class="form-control" v-model="idorden" placeholder="ID Orden Compra"  onkeypress="return isNumberKey(event);" maxlength="10"/>
                        </div>

                        <div class="form-group">
                            <label>Lista de Precio</label>
                                <input type="tel" class="form-control" v-model="idlista" placeholder="ID Lista de Precio Destino"  onkeypress="return isNumberKey(event);" maxlength="10"/>
                        </div>

                        <b-form-group label="Almac&eacute;n:">
                            <b-form-select v-model="idalmacen" class="mb-4 mt-10">
                                <option value="0">Selecciona una opci&oacute;n</option>
                                <option v-for="rows in comboAlmacen" v-bind:value="rows.m_warehouse_id"><label v-text="rows.nombre"></label></option>
                            </b-form-select>
                        </b-form-group>
                    </b-container>


                    <div>
                            <b-button block variant="primary" @click="validar"><strong>Generar Orden de Venta</strong></b-button>
                    </div>  


                </div>


        </div>
    </div>

</div>

<script type="text/javascript" src="../js/orden-venta/orden_venta.js"></script>
<script type="text/javascript" src="../js/orden-venta/validacion.js"></script>

<?php
include 'footer.php';
?>

