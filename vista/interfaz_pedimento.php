<?php
include 'header.php';
?>

<div class="card" id="Pedimento">

    <div class="card-header">
        <H4><strong>Pedimento</strong></H4>
    </div>


    <div class="col-md-12">
             <div class="col-sm-16 col-sm-offset-4">
             <br>

                            <!--<div v-for="row in opcionPedimento">
                                <input type="radio" v-model="picked" name="picked" v-bind:value='row.id_servidor_datos_orden'> 
                                <span>{{ row.nombre }}</span>
                            </div> -->
                            <label>Listado de Conexiones:</label>
                            <div v-for="row in opcionPedimento">
                                    <b-form-radio v-model="picked" :value="row.id_servidor_datos_orden"><span v-text="row.nombre"></span></b-form-radio>
                            </div>


                            <div class="card-body">
                                    <div class="form-group">
                                        <label>ID Orden</label>
                                        <input type="text" class="form-control" v-model="idorden"  placeholder="ID Orden" onkeypress="return isNumberKey(event);" maxlength="10"/>
                                    </div>

                                    <div class="form-group">
                                        <label>Pedimento</label>
                                        <input type="tel" class="form-control" v-model="pedimento"  placeholder="Nuevo Pedimento" onkeypress="return isNumberKey(event);" maxlength="15"/>
                                    </div> 

                                    <div class="form-group">
                                        <label>Fecha Pedimento</label>
                                        <input type="date" class="form-control" v-model="fechapedimento"/>
                                    </div> 
                            </div>

                            <div>
                                    <b-button block variant="primary" @click="validar();"><strong>Pedimento</strong></b-button>
                                    <br>
                            </div>



            </div> 
    </div>  

</div>   

<script type="text/javascript" src="../js/pedimento/pedimento.js"></script>
<script type="text/javascript" src="../js/pedimento/validacion.js"></script>

<?php
include 'footer.php';
?>

