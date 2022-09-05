<?php
require("../generales/Valida_Sesion.php");
$session = new ValidaSessionv2();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {

    if (isset($_POST['type'])) { 
        ControladorNormasDocumentos::obtenerArchivoCargado($_POST,$_FILES);
        return;
    }
    switch($datos->accion){
        case 'tabla': 
            ControladorNormasDocumentos::listarNormaDocumentoLinea($datos);

        break;

        case 'agregar':
            ControladorNormasDocumentos::agregarNormaDocumentoLinea($datos);

        break;

        case 'editar':
            ControladorNormasDocumentos::editarNormaDocumentoLinea($datos);

        break;

        case 'eliminar': 
            ControladorNormasDocumentos::eliminarNormaDocumentoLinea($datos);

        break;
    }

}else{
    $output = array('message' => 'Not authorizedv2'); 
    echo json_encode($output); 
}


class ControladorNormasDocumentos
{
    public static function obtenerArchivoCargado($_POST_var,$_FILES_var){
		$data_file = file_get_contents($_FILES_var["file"]["tmp_name"]);
		$valor = bin2hex( $data_file );
		$nuevosDatos = array(
			'formato_archivo' => $_FILES_var['file']['type'],
			'nombre_archivo' => $_POST_var['name'],
			'archivo_bytea' => $valor
		);
		$nuevosDatos =  json_encode($nuevosDatos) ;
		echo $nuevosDatos;
	}

	public static function listarNormaDocumentoLinea($datos)
	{
		require_once "../modelos/m_s_normas_documentos_lineas.php";
		$r = ModeloNormasDocumentos::listarNormaDocumentoLineaM($datos);
		echo json_encode($r);
	}

	public static function agregarNormaDocumentoLinea($datos)
	{
		require_once "../modelos/m_s_normas_documentos_lineas.php";
		$r = ModeloNormasDocumentos::agregarNormaDocumentoLineaM($datos);
		echo json_encode($r);
	}

	public static function editarNormaDocumentoLinea($datos)
	{
		require_once "../modelos/m_s_normas_documentos_lineas.php";
		$r = ModeloNormasDocumentos::editarNormaDocumentoLineaM($datos);
		echo json_encode($r);
	}	

	public static function eliminarNormaDocumentoLinea($datos)
	{
		require_once "../modelos/m_s_normas_documentos_lineas.php";
		$r = ModeloNormasDocumentos::eliminarNormaDocumentoLineaM($datos);
		echo json_encode($r);
		
	}

}

?>