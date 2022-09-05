<?php
require("../generales/Valida_Sesion.php");
$session = new ValidaSessionv2();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {

switch($datos->accion){
	case 'tabla': 
        ControladorNormasDocumentos::listarNormasDocumentos($datos);

	break;

	case 'agregar':
        ControladorNormasDocumentos::agregarNormasDocumentos($datos);

	break;

	case 'editar':
        ControladorNormasDocumentos::editarNormasDocumentos($datos);

	break;

	case 'eliminar': 
        ControladorNormasDocumentos::eliminarNormasDocumentos($datos);

	break;

    case 'empresas': 
        ControladorNormasDocumentos::listarEmpresas($datos);

	break;
    case 'normas': 
        ControladorNormasDocumentos::listarNormas($datos);

	break;
}

}else{
    $output = array('message' => 'Not authorizedv2'); 
    echo json_encode($output); 
}


class ControladorNormasDocumentos
{
    
	public static function listarNormasDocumentos($datos)
	{
		require_once "../modelos/m_s_normas_documentos.php";
		$r = ModeloNormasDocumentos::listarNormasDocumentosM($datos);
		echo json_encode($r);
	}

	public static function agregarNormasDocumentos($datos)
	{
		require_once "../modelos/m_s_normas_documentos.php";
		$r = ModeloNormasDocumentos::agregarNormasDocumentosM($datos);
		echo json_encode($r);
	}

	public static function editarNormasDocumentos($datos)
	{
		require_once "../modelos/m_s_normas_documentos.php";
		$r = ModeloNormasDocumentos::editarNormasDocumentosM($datos);
		echo json_encode($r);
	}	

	public static function eliminarNormasDocumentos($datos)
	{
		require_once "../modelos/m_s_normas_documentos.php";
		$r = ModeloNormasDocumentos::eliminarNormasDocumentosM($datos);
		echo json_encode($r);
	}

    public static function listarEmpresas($datos)
	{
		require_once "../modelos/m_s_normas_documentos.php";
		$r = ModeloNormasDocumentos::listarEmpresasM($datos);
		echo json_encode($r);
	}

    public static function listarNormas($datos)
	{
		require_once "../modelos/m_s_normas_documentos.php";
		$r = ModeloNormasDocumentos::listarNormasM($datos);
		echo json_encode($r);
	}

}

?>