<?php
require("../generales/Valida_Sesion.php");
$session = new ValidaSessionv2();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {

switch($datos->accion){
	case 'tabla': 
        ControladorNormas::listarNormas($datos);

	break;

	case 'agregar':
        ControladorNormas::agregarNormas($datos);

	break;

	case 'editar':
        ControladorNormas::editarNormas($datos);

	break;

	case 'eliminar': 
        ControladorNormas::eliminarNormas($datos);

	break;
}

}else{
    $output = array('message' => 'Not authorizedv2'); 
    echo json_encode($output); 
}


class ControladorNormas
{
    
	public static function listarNormas($datos)
	{
		require_once "../modelos/m_s_normas.php";
		$r = ModeloNormas::listarNormasM($datos);
		echo json_encode($r);
	}

	public static function agregarNormas($datos)
	{
		require_once "../modelos/m_s_normas.php";
		$r = ModeloNormas::agregarNormasM($datos);
		echo json_encode($r);
	}

	public static function editarNormas($datos)
	{
		require_once "../modelos/m_s_normas.php";
		$r = ModeloNormas::editarNormasM($datos);
		echo json_encode($r);
	}	

	public static function eliminarNormas($datos)
	{
		require_once "../modelos/m_s_normas.php";
		$r = ModeloNormas::eliminarNormasM($datos);
		echo json_encode($r);
	}

}

?>