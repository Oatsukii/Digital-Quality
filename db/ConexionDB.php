<?php

//require_once("../config/default.php");
if ($_SERVER['SERVER_ADDR'] == '127.0.0.1' || $_SERVER['SERVER_ADDR'] == '::1') {
	require_once("../config/default.php");

} else {
	require_once("../config/default_line.php");

}

class ConexionDB
{

	public static function conectar()
	{
		try
		{
            $config = new Datos();

            //$connect = new PDO("pgsql:host=".config::$SERVER;.";port=".config::$PORT;.";dbname=".config::$DB;."", config::$USER;, config::$PASS;);
            $connect = new PDO("pgsql:host=".Datos::SERVIDOR.";port=".Datos::PUERTO.";dbname=".Datos::BASEDATOS."", Datos::USUARIO, Datos::CONTRASENIA);

            //$connect = new PDO("pgsql:host=localhost;port=65432;dbname=DevTI_ADempiere","postgres", "DevTI20");
            $connect->exec('SET search_path TO '.Datos::ESQUEMA.'');
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $connect;
		}
		catch(PDOException $e) 
		{
    		echo 'Falló la conexión: ' . $e->getMessage();
            die();
		}
	
	}




}

?>
