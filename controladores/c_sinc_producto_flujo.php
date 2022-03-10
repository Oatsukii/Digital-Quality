<?php
require("../generales/Valida_Sesion.php");
$session = new ValidaSessionv2();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {

    switch($datos->accion){
        case 'agregar': 
            ControladorProductoFlujo::agregarProductoFlujo($datos);
	    break;

		case 'tabla': 
            ControladorProductoFlujo::listarProductoFlujo($datos);
	    break;

    }

}else{
    $output = array('message' => 'Not authorizedv2'); 
    echo json_encode($output); 
}


class ControladorProductoFlujo
{

	public static function agregarProductoFlujo($datos)
	{
		require_once "../modelos/m_sinc_producto_flujo.php";
		$r = ModeloProductoFlujo::agregarProductoFlujoM($datos);
		echo json_encode($r);
	}

	public static function listarProductoFlujo($datos)
	{
		require_once "../modelos/m_sinc_producto_flujo.php";
		$r = ModeloProductoFlujo::listarProductoFlujoM($datos);
		echo json_encode($r);
	}

}

?>