<?php
require("../generales/Valida_Sesion.php");
$session = new ValidaSessionv2();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {

    switch($datos->accion){
        case 'agregar': 
            ControladorProductoLDM::agregarProducto($datos);
	    break;

		case 'tabla': 
            ControladorProductoLDM::listarProducto($datos);
	    break;

    }

}else{
    $output = array('message' => 'Not authorizedv2'); 
    echo json_encode($output); 
}


class ControladorProductoLDM
{

	public static function agregarProducto($datos)
	{
		require_once "../modelos/m_sinc_producto_ldm.php";
		$r = ModeloProductoLDM::agregarProductoM($datos);
		echo json_encode($r);
	}

	public static function listarProducto($datos)
	{
		require_once "../modelos/m_sinc_producto_ldm.php";
		$r = ModeloProductoLDM::listarProductoM($datos);
		echo json_encode($r);
	}



}

?>