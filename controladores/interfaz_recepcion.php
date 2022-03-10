<?php
require("../generales/Valida_Sesion.php");
$session = new ValidaSessionv2();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {

switch($datos->accion){
	case 'tabla': 
        ControladorInterfazRecepcion::listarInterfazRecepcion($datos);

	break;

	case 'ejecutar':
        ControladorInterfazRecepcion::ejecutarInterfazRecepcion($datos);

	break;

}

}else{
    $output = array('message' => 'Not authorizedv2'); 
    echo json_encode($output); 
} 


class ControladorInterfazRecepcion
{
    
	public static function listarInterfazRecepcion($datos)
	{
		require_once "../modelos/m_interfaz_reception.php";
		$r = ModeloInterfazRecepcion::listarInterfazRecepcionM($datos);
		//print_r(json_encode($r));
		echo json_encode($r);
	}

	public static function ejecutarInterfazRecepcion($datos)
	{
		require_once "../modelos/m_interfaz_reception.php";
		$r = ModeloInterfazRecepcion::ejecutarInterfazRecepcionM($datos);
		echo json_encode($r);

	}


}

?>