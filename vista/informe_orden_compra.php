<?php
include 'header.php';
?>

<div class="card" id="reporteProduccion">

    <div class="card-header">
        <H4><strong>Informe Cofres a Producir</strong></H4>
    </div>

    <div class="col-md-12">
            <div class="col-sm-16 col-sm-offset-4">
                      <br>

                        <div class="card-body">

                            <div class="form-group">
                                <label>Conexi&oacute;n</label>
                                    <select class='form-control' v-model="empresa" @change='obtenerSegmento(),obtenerProveedor()'>
                                    <option value='0' >Selecciona Empresa</option>
                                    <option v-for="rows in comboEmpresa" v-bind:value='rows.nombre'>{{ rows.nombre }}</option>
                                    </select>
                            </div>

                            <!-- <div class="form-group">
                                <label>Socio Negocio</label>
                                    <select class='form-control' v-model="proveedor">
                                    <option value='0' >Selecciona Socio Negocio</option>
                                    <option v-for="rows in comboSocio" v-bind:value='rows.idadempiere_socio'>{{ rows.codigo }} - {{ rows.socionegocio }}</option>
                                    </select>
                            </div> -->


                            <div class="form-group">
                                <label>Socio Negocio</label>
                                <v-select :options="options" label="socionegocio" :reduce="socionegocio => socionegocio.idadempiere_socio" v-model="proveedor2">  </v-select>
                                <!-- <div class="mt-3">Seleccionado: <strong>{{ proveedor2 }}</strong></div> -->
                            </div>


                            <div class="form-group">
                                <label>Organizaci&oacute;n</label>
                                    <select class='form-control' v-model="organizacion" @change='obtenerAlmacen()'>
                                    <option value='0'>Selecciona Organizaci&oacute;n</option>
                                    <option v-for="rows in comboOrganizacion" v-bind:value='rows.idadempiere_org'>{{ rows.segmento }} - {{ rows.nombre }}</option>
                                    </select>
                            </div>       
                                               
                            <div class="form-group">
                                <label>Almac&eacute;n para M&aacute;ximo</label>
                                    <select class='form-control' v-model="almacen_m">
                                    <option value='0'>Selecciona Almac&eacute;n</option>
                                    <option v-for="rows in comboAlmacen" v-bind:value='rows.idadempiere_alm'>{{ rows.nombre }} - {{ rows.descripcion }} </option>
                                    </select>
                            </div>

                            <div class="form-group">
                                <label>Almac&eacute;n para Existencia y Ordenado</label>
                                    <select class='form-control' v-model="almacen_eo">
                                    <option value='0'>Selecciona Almac&eacute;n</option>
                                    <option v-for="rows in comboAlmacen" v-bind:value='rows.idadempiere_alm'>{{ rows.nombre }} - {{ rows.descripcion }} </option>
                                    </select>
                            </div>

                            <div class="form-group">
                                <label>Artículo</label>
                                <input type="text" class="form-control" v-model="producto"/>
                            </div>

                            <b-container>
                            <b-row class="text-center" align-v="center">
                                <!-- <b-col><b-button block class="btn-lg" variant="primary" @click="sincronizar">Sincronizar Informaci&oacute;n</b-button></b-col> -->
                                <b-col><b-button block class="btn-lg" variant="primary" @click="generarInforme">Generar Informe</b-button></b-col>
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
                                        <button type="button" class="btn btn-success" @click="generarListado">Generar Listado Productos</button>

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

 </div>

<script type="text/javascript" src="../js/informe-compra/informe-compra.js"></script>

<?php
include 'footer.php';
?>