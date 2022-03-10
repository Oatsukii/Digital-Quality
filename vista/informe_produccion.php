<?php
include 'header.php';
?>

<div class="card" id="reporteProduccionv2">

    <div class="card-header">
        <H4><strong>Informe Cofres a Producir</strong></H4>
    </div>

    <div class="col-md-12">
            <div class="col-sm-16 col-sm-offset-4">
                      <br>

                        <div class="card-body">

                            <div class="form-group">
                                <label>Almac&eacute;n</label>
                                    <select class='form-control' v-model="almacen">
                                    <option value='0' >Selecciona Almac&eacute;n</option>
                                    <option v-for="rows in comboAlmacenGral" v-bind:value='rows.id_dev_almacen'>{{ rows.nombre }}</option>
                                    </select>
                            </div>

                            <div class="form-group">
                                <label>Artículo</label>
                                <input type="text" class="form-control" v-model="producto"/>
                            </div>

                            <b-container>
                            <b-row class="text-center" align-v="center">
                                <b-col><b-button block class="btn-lg" variant="primary" @click="sincronizar">Sincronizar Informaci&oacute;n</b-button></b-col>
                                <b-col><b-button block class="btn-lg" variant="primary" @click="generarInforme">Reporte General</b-button></b-col>
                            </b-row>
                            </b-container>

                        </div>
            </div>       
    </div>

    <div id="modalPDFs" v-if="modalPDFv2" style="display:none">  
        <transition name="model" >
            <div class="modal-mask" > 
                    <div class="modal-dialog" style="max-width: 90%;" role="document">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h4 class="modal-title">Archivo</h4>
                                        <button type="button" class="close" @click="modalPDFv2=false"><span aria-hidden="true">&times;</span></button>
                                    </div>  

                                    <div class="modal-body"> 
                                            <div class="card-body">
                                                    <div style="text-align: center;">
                                                    <iframe v-bind:src="`${ msgModalPDF }`" style="width:100%;height:700px;" frameborder="0"></iframe> 
                                                    </div> 
                                            </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-warning" @click="excelProduccion">Exportar Excel</button>

                                        <button type="button" class="btn btn-success" @click="generarListadov2">Generar Listado Productos</button>

                                        <button type="button" class="btn btn-danger" @click="modalPDFv2=false">Cerrar</button>

                                    </div>
                            </div> 
                    </div>
             </div>
        </transition>
    </div>



    <div id="modalInfomacion" v-if="modalPDFInfo" style="display:none">  
        <transition name="model" >
            <div class="modal-mask" > 
                    <div class="modal-dialog">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h4 class="modal-title">{{ dinamicoTitulo }}</h4>
                                        <button type="button" class="close" @click="cerrarModalInformacion"><span>&times;</span></button>
                                    </div>  

                                    <div class="modal-body"> 
                                            <div class="card-body">
                                                    <div style="text-align: center;">
                                                    <img v-bind:src="`${ urlPDFInfo }`" style="width:200px;height:200px;"  /> 
                                                    <p>{{ dinamicoTexto }}</p>
                                                    </div> 
                                            </div>
                                    </div>

                                    <div class="modal-footer">

                                        <button type="button" class="btn btn-danger" @click="cerrarModalInformacion">Cerrar</button>

                                    </div>
                            </div> 
                    </div>
             </div>
        </transition>
    </div>

    <div id="modalExportarExcel" v-if="generalModalExportarExcel" style="display:none">  
        <transition name="model" >
            <div class="modal-mask" > 
                    <div class="modal-dialog">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h4 class="modal-title">{{ dynamicTitle }}</h4>
                                        <button type="button" class="close" @click="cerrarModalInformacion"><span>&times;</span></button>
                                    </div>  

                                    <div class="modal-body"> 
                                            <div class="card-body">
                                                    <div style="text-align: center;">
                                                    <img v-bind:src="`${ mensajeModalExportarExcel }`" style="width:200px;height:200px;"  /> 
                                                    <p>{{ dynamicText }}</p>
                                                    </div> 
                                            </div>
                                    </div>

                                    <div class="modal-footer">

                                        <button type="button" class="btn btn-danger" @click="cerrarModalInformacion">Cerrar</button>

                                    </div>
                            </div> 
                    </div>
             </div>
        </transition>
    </div>

 </div>

<script type="text/javascript" src="../js/informe-produccionv2/informe-produccionv2.js"></script>

<?php
include 'footer.php';
?>