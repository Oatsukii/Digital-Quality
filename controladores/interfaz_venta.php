<?php
require("../generales/Valida_Sesion.php");
$session = new ValidaSessionv2();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {

switch($datos->accion){
	case 'tabla': 
        ControladorInterfazVenta::listarInterfazVenta($datos);

	break;

	case 'ejecutar':
        ControladorInterfazVenta::ejecutarInterfazVenta($datos);

	break;

}

}else{
    $output = array('message' => 'Not authorizedv2'); 
    echo json_encode($output); 
} 

class ControladorInterfazVenta
{

	public static function listarInterfazVenta($datos)
	{
		require_once "../modelos/m_interfaz_sales.php";
		$r = ModeloInterfazVenta::listarInterfazVentaM($datos);
		echo json_encode($r);
	}

	public static function ejecutarInterfazVenta($datos)
	{
		require_once "../modelos/m_interfaz_sales.php";
		$r = ModeloInterfazVenta::ejecutarInterfazVentaM($datos);
		echo json_encode($r);
	}

}

?>