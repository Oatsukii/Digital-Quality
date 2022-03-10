<?php
require("../generales/Valida_Sesion.php");
$session = new ValidaSessionv2();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {

switch($datos->accion){
	case 'tabla': 
        ControladorMenuRelacion::listarMenu($datos);

	break;

	case 'agregar':
        ControladorMenuRelacion::agregarMenu($datos);

	break;

	case 'eliminar': 
        ControladorMenuRelacion::eliminarMenu($datos);

	break;

}

}else{
    $output = array('message' => 'Not authorizedv2'); 
    echo json_encode($output); 
} 

class ControladorMenuRelacion
{
    
	public static function listarMenu($datos)
	{
		require_once "../modelos/m_s_menu_relacion.php";
		$r = ModeloMenuRelacion::listarMenuM($datos);
		//print_r(json_encode($r));
		echo json_encode($r);
	}

	public static function agregarMenu($datos)
	{
		require_once "../modelos/m_s_menu_relacion.php";
		$r = ModeloMenuRelacion::agregarMenuM($datos);
		echo json_encode($r);
	}

	public static function eliminarMenu($datos)
	{
		require_once "../modelos/m_s_menu_relacion.php";
		$r = ModeloMenuRelacion::eliminarMenuM($datos);
		echo json_encode($r);
	}	

}

?>