<?php

include("../db/ConexionDB.php");

class ModeloUsuarioRol extends ConexionDB
{

    public static function listarRolesUsuarioM($datos)
	{
		static $query = "SELECT 
                    r.*
                    ,CASE WHEN ur.id_usuario IS NOT NULL THEN true ELSE false END AS selected
                    FROM rol AS r
                        LEFT JOIN usuario_rol AS ur
                            ON r.id_rol = ur.id_rol
                            AND ur.id_usuario = :id 
                            
                    ORDER BY r.id_rol ASC    
                            ";
                            

                        //print_r($query);

		$stmt = ConexionDB::conectar()->prepare($query);
        $stmt->bindParam(":id", $datos->idusuario, PDO::PARAM_INT);

        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        
	}

    public static function agregarRolesUsuarioM($datos)
	{
        try {

           static $query = "INSERT INTO usuario_rol (id_rol,id_usuario,activo) VALUES (:id_rol,:id_usuario,true)";

            $stmt = ConexionDB::conectar()->prepare($query);
            $stmt->bindParam(":id_rol", $datos->id_rol, PDO::PARAM_INT);
            $stmt->bindParam(":id_usuario", $datos->id_usuario, PDO::PARAM_INT);

            $stmt -> execute();
            return $stmt -> fetchAll(PDO::FETCH_ASSOC);
            

        } catch (Exception $exc) {

            return $exc;
        }

	}

    public static function eliminarRolesUsuarioM($datos)
	{
        try {
            static $query = "DELETE FROM usuario_rol WHERE id_usuario = :id ";

            $stmt = ConexionDB::conectar()->prepare($query);
            $stmt->bindParam(":id", $datos->idusuario, PDO::PARAM_INT);

             if($stmt->execute())
                return true;
                

        } catch (Exception $exc) {

            return $exc;
        }
            
	}

}

?>