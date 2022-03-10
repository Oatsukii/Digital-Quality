<?php

include("../db/ConexionDB.php");

class ModeloUsuarioRol extends ConexionDB
{

    public static $vIdUsuario;

    public static function inicializacion(){
        self::$vIdUsuario = (int) $_SESSION['usuario'][0]['id_s_usuario'];
    }

    public static function listarRolesUsuarioM($datos)
	{
		static $query = "SELECT r.*
                                ,CASE WHEN ur.id_s_usuario IS NOT NULL THEN true ELSE false END AS selected
                        FROM s_rol AS r
                        LEFT JOIN s_usuario_rol AS ur
                            ON r.id_s_rol = ur.id_s_rol
                                AND ur.id_s_usuario = :id
                
        ORDER BY r.id_s_rol ASC
                            ";
                            

                        //print_r($query);

		$stmt = ConexionDB::conectar()->prepare($query);
        $stmt->bindParam(":id", $datos->idusuario, PDO::PARAM_INT);

        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        $stmt->close();
	}

    public static function agregarRolesUsuarioM($datos)
	{
        try {

           static $query = "INSERT INTO s_usuario_rol (creado, creado_por, actualizado, actualizado_por, id_s_rol, id_s_usuario, activo) VALUES (now(), :creado_por, now(), :actualizado_por, :id_s_rol,:id_s_usuario,true)";

            $stmt = ConexionDB::conectar()->prepare($query);
            $stmt->bindParam(":creado_por", self::$vIdUsuario, PDO::PARAM_INT);
            $stmt->bindParam(":actualizado_por", self::$vIdUsuario, PDO::PARAM_INT);
            $stmt->bindParam(":id_s_rol", $datos->id_s_rol, PDO::PARAM_INT);
            $stmt->bindParam(":id_s_usuario", $datos->id_s_usuario, PDO::PARAM_INT);
            $stmt -> execute();
            return $stmt -> fetchAll(PDO::FETCH_ASSOC);
            $stmt->close();

        } catch (Exception $exc) {

            return $exc;
        }

	}

    public static function eliminarRolesUsuarioM($datos)
	{
        try {
            static $query = "DELETE FROM s_usuario_rol WHERE id_s_usuario = :id ";

            $stmt = ConexionDB::conectar()->prepare($query);
            $stmt->bindParam(":id", $datos->idusuario, PDO::PARAM_INT);

             if($stmt->execute())
                return true;
                $stmt->close();

        } catch (Exception $exc) {

            return $exc;
        }
            
	}

}

ModeloUsuarioRol::inicializacion();


?>