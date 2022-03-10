<?php
require("../generales/Valida_Sesion.php");
$session = new ValidaSessionv2();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {

switch($datos->accion){
	case 'produccionv2': 
        ControladorJasperServer::informeProduccionv2($datos);

	break;

	case 'existencia':
        ControladorJasperServer::informeExistencia($datos);

	break;

	case 'excelexistencia':
        ControladorJasperServer::informeExcelExitencia($datos);

	break;

	case 'existenciav2':
        ControladorJasperServer::informeExistenciav2($datos);

	break;

	case 'excelexistenciav2':
        ControladorJasperServer::informeExcelExistenciav2($datos);

	break;
	
	
	case 'generarFirma':
        ControladorJasperServer::generarFirmaUsuarios($datos);		

	break;

	case 'crearFirma':
        ControladorJasperServer::crearFirmaUsuarios($datos);		

	break;

	case 'informeZB':
        ControladorJasperServer::informeZB($datos);

	break;	

	case 'compra':
        ControladorJasperServer::informeCompra($datos);

	break;
	
	case 'informeUSA':
        ControladorJasperServer::informeUSA($datos);

	break;	
	
}

}else{
    $output = array('message' => 'Not authorizedv2'); 
    echo json_encode($output); 
} 


class ControladorJasperServer
{
	
	public static function informeProduccionv2($datos)
	{
		require_once "../modelos/m_jasper_server.php";
		$r = ModeloJasperServer::informeProduccionv2M($datos);
		echo ($r);
	}

	public static function informeExistencia($datos)
	{
		require_once "../modelos/m_jasper_server.php";
		$r = ModeloJasperServer::informeExistenciaM($datos);
		echo ($r);
	}

	public static function informeExcelExitencia($datos)
	{
		require_once "../modelos/m_jasper_server.php";
		$r = ModeloJasperServer::informeExcelExitenciaM($datos);
		echo ($r);
	}

	public static function informeExistenciav2($datos)
	{
		require_once "../modelos/m_jasper_server.php";
		$r = ModeloJasperServer::informeExistenciaMv2($datos);
		echo ($r);
	}

	public static function informeExcelExistenciav2($datos)
	{
		require_once "../modelos/m_jasper_server.php";
		$r = ModeloJasperServer::informeExcelExistenciaMv2($datos);
		echo ($r);
	}	

	public static function generarFirmaUsuarios($datos)
	{
		require_once "../modelos/m_jasper_server.php";
		$r = ModeloJasperServer::generarFirmaUsuariosM($datos);
		echo ($r);
	}	

	public static function crearFirmaUsuarios($datos)
	{
		require_once "../modelos/m_jasper_server.php";
		$r = ModeloJasperServer::crearFirmaUsuariosM($datos);
		echo ($r);
	}

	public static function informeZB($datos)
	{
		require_once "../modelos/m_jasper_server.php";
		$r = ModeloJasperServer::informeZBM($datos);
		echo ($r);
	}

	public static function informeCompra($datos)
	{
		require_once "../modelos/m_jasper_server.php";
		$r = ModeloJasperServer::informeCompraM($datos);
		echo ($r);
	}

	public static function informeUSA($datos)
	{
		require_once "../modelos/m_jasper_server.php";
		$r = ModeloJasperServer::informeUSAM($datos);
		echo ($r);
	}		
	

}

?>