<?php
require("../generales/Valida_Sesion.php");
$session = new ValidaSessionv2();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {

switch($datos->accion){
	case 'tablaProceso': 
        ControladorInterfazGeneral::tablaProceso($datos);

	break;

}

}else{
    $output = array('message' => 'Not authorizedv2'); 
    echo json_encode($output); 
} 


class ControladorInterfazGeneral
{
    
	public static function tablaProceso($datos)
	{
		require_once "../modelos/m_interfaz_general.php";
		$r = ModeloInterfazGeneral::tablaProcesoM($datos);
		//print_r(json_encode($r));
		echo json_encode($r);
	}




}

?>