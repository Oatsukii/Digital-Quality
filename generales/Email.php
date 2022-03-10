<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require "../lib/PHPMailer/src/Exception.php";
require "../lib/PHPMailer/src/PHPMailer.php";
require "../lib/PHPMailer/src/SMTP.php";
require "FormatoHTML.php";

class Email{

    public function enviarNotificacionCorreo($encabezado,$asunto,$destinatarios,$mensaje){

		$datosJSON = json_encode($mensaje);
		$datos = json_decode($datosJSON);

        $ContadorTextoCambio=0;
        $ContadorTextoNingunCambio=0;

		 foreach ($datos as $valor) {       
            $tipoMovimiento = $valor->tipo;

            if($tipoMovimiento == "RESULTADOS" || $tipoMovimiento == "RESULTADOS REGLAS"){
                $ContadorTextoCambio += 1;

            }else{
                $ContadorTextoNingunCambio +=1;

            }


          }
          

          if($ContadorTextoCambio >= 1){

          $Mail = new PHPMailer();	 

          $FormatoHMTL = new FormatoHTML();
          $HTML = $FormatoHMTL->notificacionesCorreo($mensaje);
            
            try {
                    // Ajustes del Servidor
                    //$Mail->SMTPDebug = 0; // Comenta esto antes de producción
                    $Mail->CharSet = 'UTF-8';
                    $Mail->isSMTP();
                    $Mail->Host="mail.refividrio.com.mx";
                    $Mail->SMTPAuth = true;
                    $Mail->Username="desarrollo@refividrio.com.mx";
                    $Mail->Password="D3$@rr0ll0$#20";
                    $Mail->SMTPSecure = "ssl";
                    $Mail->Port = 465;
                
                    // Destinatario
                    $Mail->setFrom('desarrollo@refividrio.com.mx', $encabezado);
                    //$Mail->addAddress('soporte4@refividrio.com.mx','Vic');
        
                    //Recorrer array
                    foreach ($destinatarios as $valor) {       
                      $email = $valor["email"];
                      $nombre = $valor["nombre"];
    
                      $Mail->AddAddress($email, $nombre);
                      //$Mail->addAddress($destinatarios);
        
                    }
        
                    // Mensaje
                    $Mail->isHTML(true);
                    //$Mail->addAttachment($archivo);
        
                    $Mail->Subject = $asunto;
    
                    $Mail ->MsgHTML($HTML);
        
                    $Mail->send();
                
                    //echo 'Se envio el mensaje';
                    /*
                    $output = array(
                        'message' => 'Se Envío El Mensaje por Correo.'
                    );
                    echo json_encode($output);
                     */
                    return $mensaje = 'Se Envío El Mensaje por Correo';
    
                } catch (Exception $e) {
                    //echo "Algo salio mal al intentar enviar: {$Mail->ErrorInfo}";
                    /*
                    $output = array(
                        'message' => $Mail->ErrorInfo
                    );
                    echo json_encode($output);
                    */
                    return $mensaje = $Mail->ErrorInfo;
                }


            }else{
                /*
                $output = array(
                    'message' => 'No Mostrar'
                );
                echo json_encode($output);
                */  
                return $mensaje =  'No Mostrar';
              }


    
        }




}

?>
