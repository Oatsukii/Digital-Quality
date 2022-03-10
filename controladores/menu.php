<?php
require("../generales/Valida_Sesion.php");
$session = new ValidaSessionv2();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {

switch($datos->accion){
	case 'tabla': 
        ControladorMenu::listarMenu($datos);

	break;

	case 'agregar':
        ControladorMenu::agregarMenu($datos);

	break;

	case 'editar':
        ControladorMenu::editarMenu($datos);

	break;

	case 'eliminar': 
        ControladorMenu::eliminarMenu($datos);

	break;

	case 'listadoMenu': 
        ControladorMenu::listadoMenu($datos);

	break;

}

}else{
    $output = array('message' => 'Not authorizedv2'); 
    echo json_encode($output); 
} 

class ControladorMenu
{
    
	public static function listarMenu($datos)
	{
		require_once "../modelos/m_menu.php";
		$r = ModeloMenu::listarMenuM($datos);
		//print_r(json_encode($r));
		echo json_encode($r);
	}

	public static function agregarMenu($datos)
	{
		require_once "../modelos/m_menu.php";
		$r = ModeloMenu::agregarMenuM($datos);
		echo json_encode($r);
	}

	public static function editarMenu($datos)
	{
		require_once "../modelos/m_menu.php";
		$r = ModeloMenu::editarMenuM($datos);
		echo json_encode($r);
	}	

	public static function eliminarMenu($datos)
	{
		require_once "../modelos/m_menu.php";
		$r = ModeloMenu::eliminarMenuM($datos);
		echo json_encode($r);
	}	

	public static function listadoMenu($datos)
	{
		require_once "../modelos/m_menu.php";
		$r = ModeloMenu::listadoMenuM($datos);
		echo json_encode($r);
	}	

}

?>