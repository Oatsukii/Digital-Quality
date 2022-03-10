<?php
require("../generales/Valida_Sesion.php");
$session = new ValidaSessionv2();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {

switch($datos->accion){
	case 'tabla': 
        ControladorRolInterfaz::listarRolInterfaz($datos);

	break;

	case 'agregar':
        ControladorRolInterfaz::agregarRolInterfaz($datos);

	break;

	case 'editar':
        ControladorRolInterfaz::editarRolInterfaz($datos);

	break;

	case 'eliminar': 
        ControladorRolInterfaz::eliminarRolInterfaz($datos);

	break;

	case 'busquedaCombo': 
        ControladorRolInterfaz::busquedaCombo($datos);

	break;

	case 'tablaInterfazEmpresa': 
        ControladorRolInterfaz::tablaInterfazRol($datos);

	break;	

	case 'tablaSincronizacion': 
        ControladorRolInterfaz::tablaSincronizacion($datos);

	break;

}

}else{
    $output = array('message' => 'Not authorizedv2'); 
    echo json_encode($output); 
} 

class ControladorRolInterfaz
{
    
	public static function listarRolInterfaz($datos)
	{
		require_once "../modelos/m_rol_interfaz.php";
		$r = ModeloInterfazRol::listarRolInterfazM($datos);
		echo json_encode($r);
	}

	public static function agregarRolInterfaz($datos)
	{
		require_once "../modelos/m_rol_interfaz.php";
		$r = ModeloInterfazRol::agregarRolInterfazM($datos);
		echo json_encode($r);
	}

	public static function editarRolInterfaz($datos)
	{
		require_once "../modelos/m_rol_interfaz.php";
		$r = ModeloInterfazRol::editarRolInterfazM($datos);
		echo json_encode($r);
	}	

	public static function eliminarRolInterfaz($datos)
	{
		require_once "../modelos/m_rol_interfaz.php";
		$r = ModeloInterfazRol::eliminarRolInterfazM($datos);
		echo json_encode($r);
	}

	public static function busquedaCombo($datos)
	{
		require_once "../modelos/m_rol_interfaz.php";
		$r = ModeloInterfazRol::busquedaComboM($datos);
		echo json_encode($r);
	}	

	public static function tablaInterfazRol($datos)
	{
		require_once "../modelos/m_rol_interfaz.php";
		$r = ModeloInterfazRol::tablaInterfazRolM($datos);
		echo json_encode($r);
	}

	public static function tablaSincronizacion($datos)
	{
		require_once "../modelos/m_rol_interfaz.php";
		$r = ModeloInterfazRol::tablaSincronizacionM($datos);
		echo json_encode($r);
	}


}

?>