<?php
include("../db/ConexionDB.php");

class ModeloServicio extends ConexionDB
{
    public static $vIdUsuario;

    public static function inicializacion(){
        self::$vIdUsuario = (int) $_SESSION['usuario'][0]['id_s_usuario'];
    }

    public static function listarServicioM($datos)
	{
		static $query = "SELECT
                            id_s_servicio, creado, creado_por, actualizado, actualizado_por, url, nombre, activo, CASE WHEN activo = TRUE THEN 'Activo' ELSE 'No Activo' END AS status_activo, archivo, servicio
                        FROM s_servicio
                        ORDER BY id_s_servicio
                        ";
		$stmt = ConexionDB::conectar()->prepare($query);
        $stmt -> execute();
        
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        $stmt->close();
	}

    public static function agregarServicioM($datos)
    {
        try {
                static $tabla = "s_servicio";
                $stmt = ConexionDB::conectar()->prepare("INSERT INTO $tabla (creado, creado_por, actualizado, actualizado_por, url, nombre, activo,archivo, servicio)
                                                        VALUES (CURRENT_TIMESTAMP,:creadopor, CURRENT_TIMESTAMP,:actualizadopor, :url ,:nombre, :activo, :archivo, :servicio)");
                $stmt->bindParam(":creadopor", self::$vIdUsuario, PDO::PARAM_INT);
                $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);
                $stmt->bindParam(":nombre", $datos->nombre, PDO::PARAM_STR);
                $stmt->bindParam(":url", $datos->url, PDO::PARAM_STR );
                $stmt->bindParam(":archivo", $datos->archivo, PDO::PARAM_STR );
                $stmt->bindParam(":servicio", $datos->servicio, PDO::PARAM_STR );
                $stmt->bindParam(":activo", $datos->activo, PDO::PARAM_BOOL);

                if ($stmt->execute()) {
                    return true;
                }
                $stmt->close();
            } catch (Exception $exc) {
                return $exc;
            }
    }

    public static function editarServicioM($datos)
	{
            try {
                    static $tabla = "s_servicio";
                    $stmt = ConexionDB::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, url =:url ,activo =:activo, actualizado = CURRENT_TIMESTAMP, actualizado_por=:actualizadopor, archivo = :archivo, servicio = :servicio
                                                            WHERE id_s_servicio= :id");

                    $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);
                    $stmt->bindParam(":nombre", $datos->nombre, PDO::PARAM_STR);
                    $stmt->bindParam(":url", $datos->url, PDO::PARAM_STR );
                    $stmt->bindParam(":activo", $datos->activo, PDO::PARAM_BOOL);
                    $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);
                    $stmt->bindParam(":archivo", $datos->archivo, PDO::PARAM_STR );
                    $stmt->bindParam(":servicio", $datos->servicio, PDO::PARAM_STR );

                    if ($stmt->execute()) {
                        return true;
                    }
                    $stmt->close();

            } catch (Exception $exc) {

                return $exc;
            } 
	}

	public static function eliminarServicioM($datos)
    {
         try {
                static $tabla = "s_servicio";
                $stmt = ConexionDB::conectar()->prepare("DELETE FROM $tabla WHERE id_s_servicio = :id");
                $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

                if($stmt->execute())
                    return true;
                    $stmt->close();
            } catch (Exception $exc) {

                return $exc;
            }
    }

    public static function ServicioUnicoM($datos){
        static $query = "SELECT
                            id_s_servicio, creado, creado_por, actualizado, actualizado_por, url, nombre, activo, CASE WHEN activo = TRUE THEN 'Activo' ELSE 'No Activo' END AS status_activo, archivo, servicio
                        FROM s_servicio
                        WHERE servicio = :servicio
                        ORDER BY id_s_servicio
                        ";
		$stmt = ConexionDB::conectar()->prepare($query);
        $stmt->bindParam(":servicio", $datos->servicio, PDO::PARAM_STR);
        $stmt -> execute();
        
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        $stmt->close();
    }

}

ModeloServicio::inicializacion();


?>