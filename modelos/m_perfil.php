<?php

include("../db/ConexionDB.php");

class ModeloPerfil extends ConexionDB
{
    public static $vIdUsuario;

    public static function inicializacion(){
        self::$vIdUsuario = (int) $_SESSION['usuario'][0]['id_s_usuario'];
    }

    public static function obtenerDatosUsuarioM($datos)
	{
        try {

            $data = array(); 
            static $tabla = "s_usuario";
            $stmt = ConexionDB::conectar()->prepare("SELECT * FROM $tabla WHERE id_s_usuario = :id");
            $stmt->bindParam(":id", self::$vIdUsuario, PDO::PARAM_INT);
            $stmt -> execute();
            return $stmt -> fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $exc) {

            return $exc;
        }  

	}  
    
	public static function cambiarContraseniaUsuarioM($datos)
	{
        try { 

            static $tabla = "s_usuario";
            $stmt = ConexionDB::conectar()->prepare("UPDATE $tabla SET contrasena =  md5(:nueva), actualizado = now(), actualizado_por = :id WHERE id_s_usuario = :id");
            $stmt->bindParam(":id", self::$vIdUsuario, PDO::PARAM_INT);
            $stmt->bindParam(":nueva", $datos->pass_new, PDO::PARAM_STR);

            if($stmt->execute())
                return true;


        } catch (Exception $exc) {

            return $exc;
        }  

	}

}

ModeloPerfil::inicializacion();

?>