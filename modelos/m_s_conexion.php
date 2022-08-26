<?php
include("../db/ConexionDB.php");

class ModeloConexion extends ConexionDB
{
    public static $vIdUsuario;

    public static function inicializacion(){
        self::$vIdUsuario = (int) $_SESSION['usuario'][0]['id_s_usuario'];
    }

    public static function listarConexionM($datos)
	{
		static $query = "SELECT
                            id_s_conexion, creado, creado_por, actualizado, actualizado_por, nombre_conexion, activo,  CASE WHEN activo = TRUE THEN 'Activo' ELSE 'No Activo' END AS status_activo
                        FROM s_conexion
                        ORDER BY id_s_conexion
                        ";
		$stmt = ConexionDB::conectar()->prepare($query);
        $stmt -> execute();
        
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        
	}

    public static function agregarConexionM($datos)
    {
        try {
                static $tabla = "s_conexion";
                $stmt = ConexionDB::conectar()->prepare("INSERT INTO $tabla (creado, creado_por, actualizado, actualizado_por, nombre_conexion, activo)
                                                        VALUES (CURRENT_TIMESTAMP,:creadopor, CURRENT_TIMESTAMP,:actualizadopor, :nombre_conexion, :activo)");
                $stmt->bindParam(":creadopor", self::$vIdUsuario, PDO::PARAM_INT);
                $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);
                $stmt->bindParam(":nombre_conexion", $datos->nombre_conexion, PDO::PARAM_STR);
                $stmt->bindParam(":activo", $datos->activo, PDO::PARAM_BOOL);

                if ($stmt->execute()) {
                    return true;
                }
                
            } catch (Exception $exc) {
                return $exc;
            }
    }

    public static function editarConexionM($datos)
	{
        
            try {
                    static $tabla = "s_conexion";
                    $stmt = ConexionDB::conectar()->prepare("UPDATE $tabla SET nombre_conexion = :nombre_conexion ,activo =:activo, actualizado = CURRENT_TIMESTAMP, actualizado_por=:actualizadopor
                                                            WHERE id_s_conexion= :id");

                    $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);
                    $stmt->bindParam(":nombre_conexion", $datos->nombre_conexion, PDO::PARAM_STR);
                    $stmt->bindParam(":activo", $datos->activo, PDO::PARAM_BOOL);
                    $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

                    if ($stmt->execute()) {
                        return true;
                    }
                    

            } catch (Exception $exc) {

                return $exc;
            } 
	}

	public static function eliminarConexionM($datos)
    {
         try {
                static $tabla = "s_conexion";
                $stmt = ConexionDB::conectar()->prepare("DELETE FROM $tabla WHERE id_s_conexion = :id");
                $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

                if($stmt->execute())
                    return true;
                    
            } catch (Exception $exc) {

                return $exc;
            }
    }

}

ModeloConexion::inicializacion();


?>