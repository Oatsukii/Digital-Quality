<?php
  include 'header.php';
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">SERVICIOS</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active"></li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <div class="float-left ml-2">
                    <h4><strong>Productos</strong></h4>
                </div>
                <div class="float-right ml-2">
                    <b-button class="btn btn-info" onclick="history.back()">Regresar</b-button>
                </div>
            </div>
            <div class="card-body">
    
                <div class="col-md-12"  id="s-productos">
                    <br>

                    <div class="col-sm-16 col-sm-offset-4">
                        <div class="table-responsive">
                            <nav>
                                <ul class="pagination justify-content-center" >  
                                    <li class="page-item disabled">
                                        <select class="custom-select mb-4 mr-sm-4 mb-sm-0" v-model="numByPag" @change="paginador(1)" > 
                                            <option value=5 >5</option>
                                            <option value=10 >10</option>
                                            <option value=15 >15</option>
                                            <option value=20 >20</option>
                                            <option value=30  >30</option>
                                        </select>
                                    </li>
                                    <li v-for="li in paginas" class="page-item">
                                        <a v-if="li.element == paginaActual || li.element == 'Sig' || li.element == 'Ant'" class="page-link actie" @click="paginador(li.element)" >
                                            {{ li.element }}
                                        </a> 
                                    </li>
                                </ul>
                            </nav>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Id Producto</th>
                                        <th scope="col">C&oacute;digo</th>
                                        <th scope="col">C&oacute;digo Corto</th>
                                        <th scope="col">Descripcion</th>
                                        <th scope="col">Empresa</th>
                                        <th scope="col">Activo</th>
                                        <!-- <th scope="col"></th> -->
                                        <!-- <th scope="col"></th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="row in paginaCollection">
                                        <td v-text="row.id_ad_producto"></td>
                                        <td v-text="row.id_adempiere_producto"></td>
                                        <td v-text="row.codigo"></td>
                                        <td v-text="row.codigo_corto"></td>
                                        <td v-text="row.descripcion"></td>
                                        <td v-text="row.empresa"></td>
                                        <td v-text="row.status_activo"></td>
                                        <!-- <td><button type="button" name="editar" class="btn btn-success edit"  @click="abrirModal('',row)">Editar</button></td> -->
                                        <!-- <td><button type="button" name="eliminar" class="btn btn-danger delete"  @click="eliminar(row.id_ad_producto)">Eliminar</button></td> -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                  
                </div>


            </div>
        </div>
      </div>

      
    <script type="text/javascript" src="../js/s_servicio/sinc_producto.js"></script>

<?php
include 'footer.php';
?>