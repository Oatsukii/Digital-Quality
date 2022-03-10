<?php
require("../generales/Valida_Sesion.php");
$session = new ValidaSessionv2();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {

switch($datos->accion){
	case 'tabla': 
        ControladorInterfazProcesoLineas::listarDevAlmacenLinea($datos);

	break;

	case 'agregar':
        ControladorInterfazProcesoLineas::agregarDevAlmacenLinea($datos);

	break;

	case 'eliminar': 
        ControladorInterfazProcesoLineas::eliminarDevAlmacenLinea($datos);

	break;

}

}else{
    $output = array('message' => 'Not authorizedv2'); 
    echo json_encode($output); 
} 

class ControladorInterfazProcesoLineas
{
    
	public static function listarDevAlmacenLinea($datos)
	{
		require_once "../modelos/m_interfaz_proceso_relacion.php";
		$r = ModeloInterfazProcesoLinea::listarDevAlmacenLineaM($datos);
		echo json_encode($r);
	}

	public static function agregarDevAlmacenLinea($datos)
	{
		require_once "../modelos/m_interfaz_proceso_relacion.php";
		$r = ModeloInterfazProcesoLinea::agregarDevAlmacenLineaM($datos);
		echo json_encode($r);
	}

	public static function editarDevAlmacen($datos)
	{
		require_once "../modelos/m_interfaz_proceso_relacion.php";
		$r = ModeloInterfazProcesoLinea::editarDevAlmacenM($datos);
		echo json_encode($r);
	}

	public static function eliminarDevAlmacenLinea($datos)
	{
		require_once "../modelos/m_interfaz_proceso_relacion.php";
		$r = ModeloInterfazProcesoLinea::eliminarDevAlmacenLineaM($datos);
		echo json_encode($r);
	}


}

?>