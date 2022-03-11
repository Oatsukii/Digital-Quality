<?php
require("../generales/Valida_Sesion.php");
$session = new ValidaSessionv2();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {

switch($datos->accion){
	case 'tabla': 
        ControladorProcesoCosto::listarProceso($datos);

	break;

	case 'agregar':
        ControladorProcesoCosto::agregarProceso($datos);

	break;

	case 'editar':
        ControladorProcesoCosto::editarProceso($datos);

	break;

	case 'eliminar': 
        ControladorProcesoCosto::eliminarProceso($datos);

	break;

    case 'procesoMuestra': 
        ControladorProcesoCosto::MostrarProceso($datos);

	break;

}

}else{
    $output = array('message' => 'Not authorizedv2'); 
    echo json_encode($output); 
}


class ControladorProcesoCosto
{
    
	public static function listarProceso($datos)
	{
		require_once "../modelos/m_s_proceso_costo.php";
		$r = ModeloProcesoCosto::listarProcesoM($datos);
		echo json_encode($r);
	}

	public static function agregarProceso($datos)
	{
		require_once "../modelos/m_s_proceso_costo.php";
		$r = ModeloProcesoCosto::agregarProcesoM($datos);
		echo json_encode($r);
	}

	public static function editarProceso($datos)
	{
		require_once "../modelos/m_s_proceso_costo.php";
		$r = ModeloProcesoCosto::editarProcesoM($datos);
		echo json_encode($r);
	}	

	public static function eliminarProceso($datos)
	{
		require_once "../modelos/m_s_proceso_costo.php";
		$r = ModeloProcesoCosto::eliminarProcesoM($datos);
		echo json_encode($r);
	}

    public static function MostrarProceso($datos)
	{
		require_once "../modelos/m_s_proceso_costo.php";
		$r = ModeloProcesoCosto::MostrarProcesoM($datos);
		echo json_encode($r);
	}

}

?>