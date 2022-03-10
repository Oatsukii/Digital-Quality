<?php

require_once("../generales/Session.php");

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"));

//$nombre = $_SESSION['nombre']; 
//$id =  $_SESSION['idusuario'];
//$rol = $_SESSION['rol'];
/*
$user = $datos->user;
$password = $datos->password; 
//$rol =  $datos->rolusuario;

$session = new Session();
$session->init();
$session->add('idusuario', $user);
*/
switch($datos->accion)
{
	case 'buscarusuario': 
        Login::buscarUsuario($datos);

	break;

	case 'rolusuario': 
        Login::obtenerRolesUsuario($datos);

	break;

	case 'acceder': 
        Login::validaracceso($datos);

	break;		

}

class Login
{
	public static function buscarUsuario($datos)
	{
		require_once "../modelos/m_login.php";
		$r = LoginModelo::buscarUsuarioM($datos);
		echo json_encode($r);
	}

	public static function obtenerRolesUsuario($datos)
	{
		require_once "../modelos/m_login.php";
		$r = LoginModelo::obtenerRolesUsuarioM($datos);
		echo json_encode($r);
	}

	public static function validaracceso($datos)
	{
		require_once "../modelos/m_login.php";
		$r = LoginModelo::validaraccesoM($datos);
		echo json_encode($r);
	}

}   

?>