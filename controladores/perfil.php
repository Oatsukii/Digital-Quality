<?php
require("../generales/Valida_Sesion.php");
$session = new ValidaSessionv2();

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

if ($session->verifica_session()) {

switch($datos->accion){
	case 'datosPerfil': 
        ControladorPerfil::obtenerDatosUsuario($datos);

	break;

	case 'cambiarcontrasenia':
        ControladorPerfil::cambiarContraseniaUsuario($datos);		

	break;
}

}else{
    $output = array('message' => 'Not authorizedv2'); 
    echo json_encode($output); 
}

class ControladorPerfil
{
    
	public static function obtenerDatosUsuario($datos)
	{
		require_once "../modelos/m_perfil.php";
		$r = ModeloPerfil::obtenerDatosUsuarioM($datos);
		//print_r(json_encode($r));
		echo json_encode($r);
	}

	public static function cambiarContraseniaUsuario($datos)
	{
		require_once "../modelos/m_perfil.php";
		$r = ModeloPerfil::cambiarContraseniaUsuarioM($datos);
		echo json_encode($r);
	}

}

?>