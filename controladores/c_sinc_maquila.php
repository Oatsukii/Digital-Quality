<?php
require("../generales/Valida_Sesion.php");
$session = new ValidaSessionv2();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {

    switch($datos->accion){
        case 'agregar': 
            ControladorMaquila::agregarMaquila($datos);
	    break;

		case 'tabla': 
            ControladorMaquila::listarMaquila($datos);
	    break;

    }

}else{
    $output = array('message' => 'Not authorizedv2'); 
    echo json_encode($output); 
}


class ControladorMaquila
{

	public static function agregarMaquila($datos)
	{
		require_once "../modelos/m_sinc_maquila.php";
		$r = ModeloMaquila::agregarMaquilaM($datos);
		echo json_encode($r);
	}

	public static function listarMaquila($datos)
	{
		require_once "../modelos/m_sinc_maquila.php";
		$r = ModeloMaquila::listarMaquilaM($datos);
		echo json_encode($r);
	}



}

?>