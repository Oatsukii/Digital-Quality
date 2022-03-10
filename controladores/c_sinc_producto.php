<?php
require("../generales/Valida_Sesion.php");
$session = new ValidaSessionv2();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {

    switch($datos->accion){
        case 'agregar': 
            ControladorProducto::agregarProducto($datos);
	    break;

		case 'tabla': 
            ControladorProducto::listarProducto($datos);
	    break;

		case 'tablaServicio': 
            ControladorProducto::listarServicio($datos);
	    break;

    }

}else{
    $output = array('message' => 'Not authorizedv2'); 
    echo json_encode($output); 
}


class ControladorProducto
{

	public static function agregarProducto($datos)
	{
		require_once "../modelos/m_sinc_producto.php";
		$r = ModeloProducto::agregarProductoM($datos);
		echo json_encode($r);
	}

	public static function listarProducto($datos)
	{
		require_once "../modelos/m_sinc_producto.php";
		$r = ModeloProducto::listarProductoM($datos);
		echo json_encode($r);
	}

	public static function listarServicio($datos)
	{
		require_once "../modelos/m_sinc_producto.php";
		$r = ModeloProducto::listarServicioM($datos);
		echo json_encode($r);
	}


}

?>