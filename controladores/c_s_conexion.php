<?php
require("../generales/Valida_Sesion.php");
$session = new ValidaSessionv2();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {

switch($datos->accion){

    case 'tabla': 
        ControladorServicios::listarConexion($datos);

	break;

	case 'agregar':
        ControladorServicios::agregarConexion($datos);

	break;

	case 'editar':
        ControladorServicios::editarConexion($datos);

	break;

	case 'eliminar': 
        ControladorServicios::eliminarConexion($datos);

	break;

}

}else{
    $output = array('message' => 'Not authorizedv2'); 
    echo json_encode($output); 
}


class ControladorServicios
{

	public static function listarConexion($datos)
	{
		require_once "../modelos/m_s_conexion.php";
		$r = ModeloConexion::listarConexionM($datos);
		echo json_encode($r);
	}

	public static function agregarConexion($datos)
	{
		require_once "../modelos/m_s_conexion.php";
		$r = ModeloConexion::agregarConexionM($datos);
		echo json_encode($r);
	}

	public static function editarConexion($datos)
	{
		require_once "../modelos/m_s_conexion.php";
		$r = ModeloConexion::editarConexionM($datos);
		echo json_encode($r);
	}	

	public static function eliminarConexion($datos)
	{
		require_once "../modelos/m_s_conexion.php";
		$r = ModeloConexion::eliminarConexionM($datos);
		echo json_encode($r);
	}

}

?>