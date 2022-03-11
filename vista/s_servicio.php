<?php
  include 'header.php';
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">SERVICIOS</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active"></li>
        </ol>

        <div class="card mb-4"  id="s-servicio">
            <div class="card-header">
                <div class="float-left ml-2" v-for="pro in ProcesosCollection">
                    <i class="fas fa-table me-1"></i>
                    Servicios a Sincronizar del proceso:<strong> {{ pro.nombre }} </strong>
                </div>
                <div class="float-right ml-2">
                    <b-button class="btn btn-info" onclick="history.back()">Regresar</b-button>
                </div>
            </div>
            <div class="card-body">
    
                <div class="col-md-12" >

                    <div v-for="row in ServicioCollection">
                        <div class="list-group" >
                            <a v-bind:href="`${row.archivo +`?action=`+ row.servicio +  `&proceso=` + id_s_proceso}`" class="list-group-item list-group-item-action">
                                <div class="float-left ml-2">
                                    Nombre: <strong>{{ row.nombre }}</strong> 
                                </div>
                                <div class="float-right ml-2">
                                    Servicio: <strong>{{ row.servicio }}</strong>
                                </div>
                            </a>
                        </div><br>
                    </div>

                </div>

            </div>
        </div>
</div>

    <script type="text/javascript" src="../js/s_servicio/s_servicio.js"></script>

<?php
include 'footer.php';
?>