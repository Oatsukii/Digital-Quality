<?php
require("../generales/Valida_Sesion.php");
$session = new ValidaSessionv2();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {

switch($datos->accion){
	case 'tabla': 
        ControladorInterfazPedimento::listarInterfazPedimento($datos);

	break;

	case 'ejecutar':
        ControladorInterfazPedimento::ejecutarInterfazPedimento($datos);

	break;

}

}else{
    $output = array('message' => 'Not authorizedv2'); 
    echo json_encode($output); 
} 


class ControladorInterfazPedimento
{
    
	public static function listarInterfazPedimento($datos)
	{
		require_once "../modelos/m_interfaz_petition.php";
		$r = ModeloInterfazPedimento::listarInterfazPedimentoM($datos);
		//print_r(json_encode($r));
		echo json_encode($r);
	}

	public static function ejecutarInterfazPedimento($datos)
	{
		require_once "../modelos/m_interfaz_petition.php";
		$r = ModeloInterfazPedimento::ejecutarInterfazPedimentoM($datos);
		echo json_encode($r);
	}

	public static function procesaInterfazPedimento($datos)
	{
		require_once "../modelos/m_interfaz_petition.php";
		$r = ModeloInterfazPedimento::procesaInterfazPedimentoM($datos);
		echo json_encode($r);
	}



}

?>