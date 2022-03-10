<?php
require("../generales/Valida_Sesion.php");
$session = new ValidaSessionv2();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {

switch($datos->accion){
	case 'tabla': 
        ControladorRolMenu::listarRolMenu($datos);

	break;

	case 'agregar':
        ControladorRolMenu::agregarRolMenu($datos);

	break;

	case 'editar':
        ControladorRolMenu::editarRolMenu($datos);

	break;

	case 'eliminar': 
        ControladorRolMenu::eliminarRolMenu($datos);

	break;

}

}else{
    $output = array('message' => 'Not authorizedv2'); 
    echo json_encode($output); 
} 

class ControladorRolMenu
{
    
	public static function listarRolMenu($datos)
	{
		require_once "../modelos/m_rol_menu.php";
		$r = ModeloMenuRol::listarRolMenuM($datos);
		echo json_encode($r);
	}

	public static function agregarRolMenu($datos)
	{
		require_once "../modelos/m_rol_menu.php";
		$r = ModeloMenuRol::agregarRolMenuM($datos);
		echo json_encode($r);
	}

	public static function editarRolMenu($datos)
	{
		require_once "../modelos/m_rol_menu.php";
		$r = ModeloMenuRol::editarRolMenuM($datos);
		echo json_encode($r);
	}	

	public static function eliminarRolMenu($datos)
	{
		require_once "../modelos/m_rol_menu.php";
		$r = ModeloMenuRol::eliminarRolMenuM($datos);
		echo json_encode($r);
	}	

}

?>