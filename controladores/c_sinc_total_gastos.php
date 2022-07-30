<?php
require("../generales/Valida_Sesion.php");
$session = new ValidaSessionv2();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {

    switch($datos->accion){
        case 'agregar': 
            ControladorTotalGastos::agregarGastos($datos);
	    break;

		case 'tabla': 
            ControladorTotalGastos::listarGastos($datos);
	    break;

        case 'tokenNuevo': 
            ControladorTotalGastos::generarToken($datos);
	    break;

    }

}else{
    $output = array('message' => 'Not authorizedv2'); 
    echo json_encode($output); 
}


class ControladorTotalGastos
{

	public static function agregarGastos($datos)
	{
		require_once "../modelos/m_sinc_total_gastos.php";
		$r = ModeloTotalGastos::agregarGastosM($datos);
		echo json_encode($r);
	}

	public static function listarGastos($datos)
	{
		require_once "../modelos/m_sinc_total_gastos.php";
		$r = ModeloTotalGastos::listarGastosM($datos);
		echo json_encode($r);
	}

    public static function generarToken($datos)
	{
		require_once "../modelos/m_sinc_total_gastos.php";
		$r = ModeloTotalGastos::generarTokenM($datos);
		echo json_encode($r);
	}



}

?>