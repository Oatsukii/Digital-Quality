<?php
require("../generales/Valida_Sesion.php");
$session = new ValidaSessionv2();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {

switch($datos->accion){
	case 'rolusuario': 
        ControladorUsuarioRol::listarRolesUsuario($datos);
	break;

	case 'agregar': 
        ControladorUsuarioRol::agregarRolesUsuario($datos);
	break;

	case 'eliminar': 
        ControladorUsuarioRol::eliminarRolesUsuario($datos);
	break;

}

}else{
    $output = array('message' => 'Not authorizedv2'); 
    echo json_encode($output); 
} 

class ControladorUsuarioRol
{
    
	public static function listarRolesUsuario($datos)
	{
		require_once "../modelos/m_s_usuario_rol.php";
		$r = ModeloUsuarioRol::listarRolesUsuarioM($datos);
		echo json_encode($r);
	}

	public static function agregarRolesUsuario($datos)
	{
		require_once "../modelos/m_s_usuario_rol.php";
		$r = ModeloUsuarioRol::agregarRolesUsuarioM($datos);
		echo json_encode($r);
	}
	
	public static function eliminarRolesUsuario($datos)
	{
		require_once "../modelos/m_s_usuario_rol.php";
		$r = ModeloUsuarioRol::eliminarRolesUsuarioM($datos);
		echo json_encode($r);
	}	


}

?>