<?php
require("../generales/Valida_Sesion.php");
$session = new ValidaSessionv2();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {

    switch($datos->accion){
        case 'agregar': 
            ControladorGastos::agregarGastos($datos);
	    break;

		case 'tabla': 
            ControladorGastos::listarGastos($datos);
	    break;

    }

}else{
    $output = array('message' => 'Not authorizedv2'); 
    echo json_encode($output); 
}


class ControladorGastos
{

	public static function agregarGastos($datos)
	{
		require_once "../modelos/m_sinc_gastos.php";
		$r = ModeloGastos::agregarGastosM($datos);
		echo json_encode($r);
	}

	public static function listarGastos($datos)
	{
		require_once "../modelos/m_sinc_gastos.php";
		$r = ModeloGastos::listarGastosM($datos);
		echo json_encode($r);
	}



}

?>