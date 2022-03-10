<?php
require("../generales/Valida_Sesion.php");
$session = new ValidaSessionv2();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {

switch($datos->accion){
	case 'sincronizar': 
        ControladorSincronizacion::ModeloSincronizacion($datos);

	break;

	case 'ventasZB':
        ControladorSincronizacion::ventasZB($datos);

	break;

	case 'facturaActualZB':
        ControladorSincronizacion::facturaActualZB($datos);

	break;

	case 'trapasosZB':
        ControladorSincronizacion::trapasosZB($datos);

	break;

	case 'trapasoActualZB':
        ControladorSincronizacion::trapasoActualZB($datos);

	break;	

	case 'socioNegocio': 
        ControladorSincronizacion::socioNegocio($datos);

	break;

	case 'producto': 
        ControladorSincronizacion::producto($datos);

	break;	

	case 'sucursal': 
        ControladorSincronizacion::sucursal($datos);

	break;

	case 'almacen': 
        ControladorSincronizacion::almacen($datos);

	break;

	case 'existencia': 
        ControladorSincronizacion::existencia($datos);

	break;
	
	case 'minmax': 
        ControladorSincronizacion::MinimoMaximo($datos);

	break;

	case 'productoproduccion': 
        ControladorSincronizacion::ProductoProduccion($datos);

	break;

	case 'procesarInformacionZB': 
        ControladorSincronizacion::procesarInformacionZB($datos);

	break;	

	case 'listaprecio': 
        ControladorSincronizacion::listaPrecio($datos);

	break;

	case 'productoCompra': 
        ControladorSincronizacion::productoCompra($datos);

	break;

	case 'tipoDocumento': 
        ControladorSincronizacion::tipoDocumento($datos);

	break;	

}

}else{
    $output = array('message' => 'Not authorizedv2'); 
    echo json_encode($output); 
} 

class ControladorSincronizacion
{
    
	public static function ModeloSincronizacion($datos)
	{
		require_once "../modelos/m_sincronizacion.php";
		$r = ModeloSincronizacion::ModeloSincronizacionM($datos);
		echo json_encode($r);
	}

	public static function ventasZB($datos)
	{
		require_once "../modelos/m_sincronizacion.php";
		$r = ModeloSincronizacion::ventasZBM($datos);
		echo json_encode($r);
	}

	public static function facturaActualZB($datos)
	{
		require_once "../modelos/m_sincronizacion.php";
		$r = ModeloSincronizacion::facturaActualZBM($datos);
		echo json_encode($r);
	}

	public static function trapasosZB($datos)
	{
		require_once "../modelos/m_sincronizacion.php";
		$r = ModeloSincronizacion::trapasosZBM($datos);
		echo json_encode($r);
	}	

	public static function trapasoActualZB($datos)
	{
		require_once "../modelos/m_sincronizacion.php";
		$r = ModeloSincronizacion::trapasoActualZBM($datos);
		echo json_encode($r);
	}	

	public static function socioNegocio($datos)
	{
		require_once "../modelos/m_sincronizacion.php";
		$r = ModeloSincronizacion::socioNegocioM($datos);
		echo json_encode($r);
	}	

	public static function producto($datos)
	{
		require_once "../modelos/m_sincronizacion.php";
		$r = ModeloSincronizacion::productoM($datos);
		echo json_encode($r);
	}

	public static function sucursal($datos)
	{
		require_once "../modelos/m_sincronizacion.php";
		$r = ModeloSincronizacion::sucursalM($datos);
		echo json_encode($r);
	}

	public static function almacen($datos)
	{
		require_once "../modelos/m_sincronizacion.php";
		$r = ModeloSincronizacion::almacenM($datos);
		echo json_encode($r);
	}

	public static function existencia($datos)
	{
		require_once "../modelos/m_sincronizacion.php";
		$r = ModeloSincronizacion::existenciaM($datos);
		echo json_encode($r);
	}

	public static function MinimoMaximo($datos)
	{
		require_once "../modelos/m_sincronizacion.php";
		$r = ModeloSincronizacion::MinimoMaximoM($datos);
		echo json_encode($r);
	}

	public static function ProductoProduccion($datos)
	{
		require_once "../modelos/m_sincronizacion.php";
		$r = ModeloSincronizacion::ProductoProduccionM($datos);
		echo json_encode($r);
	}
	
	public static function procesarInformacionZB($datos)
	{
		require_once "../modelos/m_sincronizacion.php";
		$r = ModeloSincronizacion::procesarInformacionZBM($datos);
		echo json_encode($r);
	}
	
	public static function listaPrecio($datos)
	{
		require_once "../modelos/m_sincronizacion.php";
		$r = ModeloSincronizacion::listaPrecioM($datos);
		echo json_encode($r);
	}

	public static function productoCompra($datos)
	{
		require_once "../modelos/m_sincronizacion.php";
		$r = ModeloSincronizacion::productoCompraM($datos);
		echo json_encode($r);
	}

	public static function tipoDocumento($datos)
	{
		require_once "../modelos/m_sincronizacion.php";
		$r = ModeloSincronizacion::tipoDocumentoM($datos);
		echo json_encode($r);
	}		

}


?>