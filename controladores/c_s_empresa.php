<?php
require("../generales/Valida_Sesion.php");
$session = new ValidaSessionv2();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {

switch($datos->accion){
	case 'tabla': 
        ControladorEmpresa::listarEmpresa($datos);

	break;

	case 'agregar':
        ControladorEmpresa::agregarEmpresa($datos);

	break;

	case 'editar':
        ControladorEmpresa::editarEmpresa($datos);

	break;

	case 'eliminar': 
        ControladorEmpresa::eliminarEmpresa($datos);

	break;

}

}else{
    $output = array('message' => 'Not authorizedv2'); 
    echo json_encode($output); 
}


class ControladorEmpresa
{
    
	public static function listarEmpresa($datos)
	{
		require_once "../modelos/m_s_empresa.php";
		$r = ModeloEmpresa::listarEmpresaM($datos);
		echo json_encode($r);
	}

	public static function agregarEmpresa($datos)
	{
		require_once "../modelos/m_s_empresa.php";
		$r = ModeloEmpresa::agregarEmpresaM($datos);
		echo json_encode($r);
	}

	public static function editarEmpresa($datos)
	{
		require_once "../modelos/m_s_empresa.php";
		$r = ModeloEmpresa::editarEmpresaM($datos);
		echo json_encode($r);
	}	

	public static function eliminarEmpresa($datos)
	{
		require_once "../modelos/m_s_empresa.php";
		$r = ModeloEmpresa::eliminarEmpresaM($datos);
		echo json_encode($r);
	}

}

?>