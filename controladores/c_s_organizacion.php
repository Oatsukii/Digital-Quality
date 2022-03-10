<?php
require("../generales/Valida_Sesion.php");
$session = new ValidaSessionv2();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {

switch($datos->accion){
	case 'tabla': 
        ControladorEmpresa::listarOrganizacion($datos);

	break;

	case 'agregar':
        ControladorEmpresa::agregarOrganizacion($datos);

	break;

	case 'editar':
        ControladorEmpresa::editarOrganizacion($datos);

	break;

	case 'eliminar': 
        ControladorEmpresa::eliminarOrganizacion($datos);

	break;

	case 'empresas': 
        ControladorEmpresa::Empresas($datos);

	break;
}

}else{
    $output = array('message' => 'Not authorizedv2'); 
    echo json_encode($output); 
}


class ControladorEmpresa
{
    
	public static function listarOrganizacion($datos)
	{
		require_once "../modelos/m_s_organizacion.php";
		$r = ModeloOrganizacion::listarOrganizacionM($datos);
		echo json_encode($r);
	}


	public static function eliminarOrganizacion($datos)
	{
		require_once "../modelos/m_s_organizacion.php";
		$r = ModeloOrganizacion::eliminarOrganizacionM($datos);
		echo json_encode($r);
	}


	public static function agregarOrganizacion($datos)
	{
		require_once "../modelos/m_s_organizacion.php";
		$r = ModeloOrganizacion::agregarOrganizacionM($datos);
		echo json_encode($r);
	}

	public static function editarOrganizacion($datos)
	{
		require_once "../modelos/m_s_organizacion.php";
		$r = ModeloOrganizacion::editarOrganizacionM($datos);
		echo json_encode($r);
	}	

	public static function Empresas($datos)
	{
		require_once "../modelos/m_s_organizacion.php";
		$r = ModeloOrganizacion::EmpresasM($datos);
		echo json_encode($r);
	}

}

?>