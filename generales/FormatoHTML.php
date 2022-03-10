<?php 

class FormatoHTML{
	 	
	public function notificacionesCorreo($mensaje){

		$datosJSON = json_encode($mensaje);
		$datos = json_decode($datosJSON);
  
$mensajeHTML ='
		<!DOCTYPE html>
		<html lang="es">
		<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>Grupo Refividrio</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="robots" content="noindex">
		<meta name="googlebot" content="noindex">
	
		<!-- CSS only -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	
		<!-- JS, Popper.js, and jQuery -->
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	
		</head>
		<body style=" background-color:#eeeeee;">
		<br>
		
		<div class="container">
		
		<div class="card mb-3">
		  <div class="card-body" style="text-align:center">
		  
		  </div>
		

		<div class="card-body" style="text-align:center">
			<h1 style="color:#263238;text-align:center;"><strong>Notificación de Movimiento (Requisión)</strong></h1>';

			foreach ($datos as $valor) {       
				$tipoDato = $valor->tipo;
				$descripcion = $valor->documento;

					if($tipoDato == "ENCABEZADO"){
						$mensajeHTML .='<h1 style="color:#263238;text-align:center;"><strong>'.$descripcion.'</strong></h1>';

					}else{
						$mensajeHTML .='';

					}
	
			  }	  

			
$mensajeHTML .='
		</div>

		  <p>A continuaci&oacute;n se muestra la siguientes actualizaciones en la requisiciones:</p>';

			foreach ($datos as $valor) {       
				$tipoDato = $valor->tipo;
				$descripcion = $valor->documento;

					if($tipoDato == "REGLAS" || $tipoDato == "RESULTADOS" || $tipoDato == "RESULTADOS REGLAS"){
						$mensajeHTML .='<li class="list-group-item"><strong>'.$descripcion.'</strong></li>';

					}else{
						$mensajeHTML .='';

					}

			}


$mensajeHTML .='		  

		  <br>
				
		</div>
		
		<div class="card">
		  <div class="card-body" style="text-align:center">
		  
			<img src="https://dev.refividrio.com.mx/complemento/develop.png" width="150" height="150">
		  </div>
		</div>
		
		</div>
		</body>
		</html>			
		';

		return $mensajeHTML;
		
        }
        

}

        //$enviarCorreo = new FormatoHTML();
        //$enviarCorreo->mensajeCorreoGeneral();