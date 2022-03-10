<?php
require("../generales/Valida_Sesion.php");
$session = new ValidaSessionv2();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {

switch($datos->accion){
	case 'tabla': 
        ControladorUsuario::listarUsuarios($datos);

	break;

	case 'agregar':
        ControladorUsuario::agregarUsuarios($datos);

	break;

	case 'editar':
        ControladorUsuario::editarUsuarios($datos);

	break;

	case 'eliminar': 

	break;

	case 'obtenerDato':
        ControladorUsuario::obtenerDatosUsuarios($datos);		

	break;

	case 'cambiarcontrasenia':
        ControladorUsuario::cambiarContraseniaUsuarios($datos);		

	break;

	case 'busquedaUsuario':
        ControladorUsuario::busquedaUsuario($datos);		

	break;

}

}else{
    $output = array('message' => 'Not authorizedv2'); 
    echo json_encode($output); 
} 


class ControladorUsuario
{
    
	public static function listarUsuarios($datos)
	{
		require_once "../modelos/m_usuario.php";
		$r = ModeloUsuario::listarUsuariosM($datos);
		//print_r(json_encode($r));
		echo json_encode($r);
	}

	public static function agregarUsuarios($datos)
	{
		require_once "../modelos/m_usuario.php";
		$r = ModeloUsuario::agregarUsuariosM($datos);
		echo json_encode($r);
	}

	public static function editarUsuarios($datos)
	{
		require_once "../modelos/m_usuario.php";
		$r = ModeloUsuario::editarUsuariosM($datos);
		echo json_encode($r);
	}

	public static function obtenerDatosUsuarios($datos)
	{
		require_once "../modelos/m_usuario.php";
		$r = ModeloUsuario::obtenerDatosUsuariosM($datos);
		echo json_encode($r);
	}		

	public static function cambiarContraseniaUsuarios($datos)
	{
		require_once "../modelos/m_usuario.php";
		$r = ModeloUsuario::cambiarContraseniaUsuariosM($datos);
		echo json_encode($r);
	}

	public static function busquedaUsuario($datos)
	{
		require_once "../modelos/m_usuario.php";
		$r = ModeloUsuario::busquedaUsuarioM($datos);
		echo json_encode($r);
	}	


}

?>