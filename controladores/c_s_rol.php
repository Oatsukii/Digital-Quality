<?php
require("../generales/Valida_Sesion.php");
$session = new ValidaSessionv2();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {

switch($datos->accion){
	case 'tabla': 
        ControladorRol::listarRol($datos);

	break;

	case 'agregar':
        ControladorRol::agregarRol($datos);

	break;

	case 'editar':
        ControladorRol::editarRol($datos);

	break;

	case 'eliminar': 
        ControladorRol::eliminarRol($datos);

	break;

	case 'tablaRol': 
        ControladorRol::listarRolEspecifico($datos);

	break;	

}

}else{
    $output = array('message' => 'Not authorizedv2'); 
    echo json_encode($output); 
} 

class ControladorRol
{
    
	public static function listarRol($datos)
	{
		require_once "../modelos/m_s_rol.php";
		$r = ModeloRol::listarRolM($datos);
		//print_r(json_encode($r));
		echo json_encode($r);
	}

	public static function agregarRol($datos)
	{
		require_once "../modelos/m_s_rol.php";
		$r = ModeloRol::agregarRolM($datos);
		echo json_encode($r);
	}

	public static function editarRol($datos)
	{
		require_once "../modelos/m_s_rol.php";
		$r = ModeloRol::editarRolM($datos);
		echo json_encode($r);
	}	

	public static function eliminarRol($datos)
	{
		require_once "../modelos/m_s_rol.php";
		$r = ModeloRol::eliminarRolM($datos);
		echo json_encode($r);
	}	

	public static function listarRolEspecifico($datos)
	{
		require_once "../modelos/m_s_rol.php";
		$r = ModeloRol::listarRolEspecificoM($datos);
		echo json_encode($r);
	}	

}

?>