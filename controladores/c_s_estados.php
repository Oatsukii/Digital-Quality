<?php
require("../generales/Valida_Sesion.php");
$session = new ValidaSessionv2();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {

switch($datos->accion){
	case 'tabla': 
        ControladorProcesoCosto::listarEstado($datos);

	break;

	case 'agregar':
        ControladorProcesoCosto::agregarEstado($datos);

	break;

	case 'editar':
        ControladorProcesoCosto::editarEstado($datos);

	break;

	case 'eliminar': 
        ControladorProcesoCosto::eliminarEstado($datos);

	break;

	case 'EstadosListar': 
        ControladorProcesoCosto::EstadosListar($datos);

	break;
}

}else{
    $output = array('message' => 'Not authorizedv2'); 
    echo json_encode($output); 
}


class ControladorProcesoCosto
{
    
	public static function listarEstado($datos)
	{
		require_once "../modelos/m_s_estados.php";
		$r = ModeloEstado::listarEstadoM($datos);
		echo json_encode($r);
	}

	public static function agregarEstado($datos)
	{
		require_once "../modelos/m_s_estados.php";
		$r = ModeloEstado::agregarEstadoM($datos);
		echo json_encode($r);
	}

	public static function editarEstado($datos)
	{
		require_once "../modelos/m_s_estados.php";
		$r = ModeloEstado::editarEstadoM($datos);
		echo json_encode($r);
	}	

	public static function eliminarEstado($datos)
	{
		require_once "../modelos/m_s_estados.php";
		$r = ModeloEstado::eliminarEstadoM($datos);
		echo json_encode($r);
	}

	public static function EstadosListar($datos)
	{
		require_once "../modelos/m_s_estados.php";
		$r = ModeloEstado::EstadosListarM($datos);
		echo json_encode($r);
	}

}

?>