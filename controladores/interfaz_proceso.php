<?php
require("../generales/Valida_Sesion.php");
$session = new ValidaSessionv2();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {

switch($datos->accion){
	case 'tabla': 
        ControladorInterfazProceso::listarInterfazProceso($datos);

	break;

	case 'agregar':
        ControladorInterfazProceso::agregarInterfazProceso($datos);

	break;

	case 'editar':
        ControladorInterfazProceso::editarInterfazProceso($datos);

	break;

	case 'eliminar': 
        ControladorInterfazProceso::eliminarInterfazProceso($datos);		

	break;


	case 'busquedaGeneral':
        ControladorInterfazProceso::busquedaInterfazProceso($datos);		

	break;

	case 'tablaPlantilla':
        ControladorInterfazProceso::tablaPlantilla($datos);		

	break;	

}

}else{
    $output = array('message' => 'Not authorizedv2'); 
    echo json_encode($output); 
} 


class ControladorInterfazProceso
{
    
	public static function listarInterfazProceso($datos)
	{
		require_once "../modelos/m_interfaz_proceso.php";
		$r = ModeloInterfazProceso::listarInterfazProcesoM($datos);
		//print_r(json_encode($r));
		echo json_encode($r);
	}

	public static function agregarInterfazProceso($datos)
	{
		require_once "../modelos/m_interfaz_proceso.php";
		$r = ModeloInterfazProceso::agregarInterfazProcesoM($datos);
		echo json_encode($r);
	}

	public static function editarInterfazProceso($datos)
	{
		require_once "../modelos/m_interfaz_proceso.php";
		$r = ModeloInterfazProceso::editarInterfazProcesoM($datos);
		echo json_encode($r);
	}

	public static function eliminarInterfazProceso($datos)
	{
		require_once "../modelos/m_interfaz_proceso.php";
		$r = ModeloInterfazProceso::eliminarInterfazProcesoM($datos);
		echo json_encode($r);
	}
	
	public static function busquedaInterfazProceso($datos)
	{
		require_once "../modelos/m_interfaz_proceso.php";
		$r = ModeloInterfazProceso::busquedaInterfazProcesoM($datos);
		echo json_encode($r);
	}

	public static function tablaPlantilla($datos)
	{
		require_once "../modelos/m_interfaz_proceso.php";
		$r = ModeloInterfazProceso::tablaPlantillaM($datos);
		//print_r(json_encode($r));
		echo json_encode($r);
	}


}

?>