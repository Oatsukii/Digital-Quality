<?php
require("../generales/Valida_Sesion.php");
$session = new ValidaSessionv2();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {

switch($datos->accion){
	case 'tabla': 
        ControladorInterfazCompra::listarInterfazCompra($datos);

	break;

	case 'ejecutar':
        ControladorInterfazCompra::ejecutarInterfazCompra($datos);

	break;

}

}else{
    $output = array('message' => 'Not authorizedv2'); 
    echo json_encode($output); 
} 

class ControladorInterfazCompra
{

	public static function listarInterfazCompra($datos)
	{
		require_once "../modelos/m_interfaz_purchase.php";
		$r = ModeloInterfazCompra::listarInterfazCompraM($datos);
		echo json_encode($r);
	}

	public static function ejecutarInterfazCompra($datos)
	{
		require_once "../modelos/m_interfaz_purchase.php";
		$r = ModeloInterfazCompra::ejecutarInterfazCompraM($datos);
		echo json_encode($r);
	}

}

?>