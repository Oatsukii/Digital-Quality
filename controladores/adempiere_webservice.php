<?php
require("../generales/Valida_Sesion.php");
$session = new ValidaSessionv2();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {

switch($datos->accion){

	case 'ordenCompraAD': 
        ControladorWebServiceADempiere::ordenCompraAD($datos);

	break;


}

}else{
    $output = array('message' => 'Not authorizedv2'); 
    echo json_encode($output); 
} 


class ControladorWebServiceADempiere
{
    
	public static function ordenCompraAD($datos)
	{
		require_once "../modelos/m_adempiere_webservice.php";
		$r = ModeloWebServiceADempiere::ordenCompraADM($datos);
		//print_r(json_encode($r));
		echo json_encode($r);
	}
}

?>