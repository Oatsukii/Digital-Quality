<?php
require("../generales/Valida_Sesion.php");
$session = new ValidaSessionv2();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {

switch($datos->accion){
	case 'empresas': 
        ControladorServicios::BuscaEmpresas($datos);
	break;

    case 'tabla': 
        ControladorServicios::listarServicio($datos);

	break;

	case 'agregar':
        ControladorServicios::agregarServicio($datos);

	break;

	case 'editar':
        ControladorServicios::editarServicio($datos);

	break;

	case 'eliminar': 
        ControladorServicios::eliminarServicio($datos);

	break;
	case 'ServicioSeleccioando': 
        ControladorServicios::ServicioUnico($datos);

	break;
	case 'listarConexion': 
        ControladorServicios::listarConexion($datos);

	break;
	case 'editarUrl': 
        ControladorServicios::editarUrl($datos);

	break;

}

}else{
    $output = array('message' => 'Not authorizedv2'); 
    echo json_encode($output); 
}


class ControladorServicios
{

    public static function BuscaEmpresas($datos)
	{
		require_once "../modelos/m_s_servicio.php";
		$r = ModeloServicio::buscaEmpresasM($datos);
		echo json_encode($r);
	}

	public static function listarServicio($datos)
	{
		require_once "../modelos/m_s_servicio.php";
		$r = ModeloServicio::listarServicioM($datos);
		echo json_encode($r);
	}

	public static function agregarServicio($datos)
	{
		require_once "../modelos/m_s_servicio.php";
		$r = ModeloServicio::agregarServicioM($datos);
		echo json_encode($r);
	}

	public static function editarServicio($datos)
	{
		require_once "../modelos/m_s_servicio.php";
		$r = ModeloServicio::editarServicioM($datos);
		echo json_encode($r);
	}	

	public static function eliminarServicio($datos)
	{
		require_once "../modelos/m_s_servicio.php";
		$r = ModeloServicio::eliminarServicioM($datos);
		echo json_encode($r);
	}

	public static function ServicioUnico($datos)
	{
		require_once "../modelos/m_s_servicio.php";
		$r = ModeloServicio::ServicioUnicoM($datos);
		echo json_encode($r);
	}

	public static function listarConexion($datos)
	{
		require_once "../modelos/m_s_servicio.php";
		$r = ModeloServicio::listarConexionM($datos);
		echo json_encode($r);
	}

	public static function editarUrl($datos)
	{
		require_once "../modelos/m_s_servicio.php";
		$r = ModeloServicio::editarUrlM($datos);
		echo json_encode($r);
	}


}

?>