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
                            s.id_s_servicio, s.creado, s.creado_por, s.actualizado, s.actualizado_por, s.url, s.ruta , s.nombre, s.activo, CASE WHEN s.activo = TRUE THEN 'Activo' ELSE 'No Activo' END AS status_activo, s.archivo, s.servicio, s.id_s_conexion, c.nombre_conexion
                        FROM s_servicio AS s
                        INNER JOIN s_conexion AS c
                            ON c.id_s_conexion = s.id_s_conexion
                        ORDER BY id_s_servicio
                        ";
		$stmt = ConexionDB::conectar()->prepare($query);
        $stmt -> execute();
        
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        $stmt->close();
	}

    public static function listarUrlsM($datos)
	{
		static $query = "SELECT DISTINCT s.url, s.ruta , s.id_s_conexion, c.nombre_conexion
                    FROM s_servicio AS s
                    INNER JOIN s_conexion AS c
                    ON c.id_s_conexion = s.id_s_conexion
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
                $stmt = ConexionDB::conectar()->prepare("INSERT INTO $tabla (creado, creado_por, actualizado, actualizado_por, url, nombre, activo,archivo, servicio, ruta, id_s_conexion)
                                                        VALUES (CURRENT_TIMESTAMP,:creadopor, CURRENT_TIMESTAMP,:actualizadopor, :url ,:nombre, :activo, :archivo, :servicio, :ruta, :id_s_conexion)");
                $stmt->bindParam(":creadopor", self::$vIdUsuario, PDO::PARAM_INT);
                $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);
                $stmt->bindParam(":nombre", $datos->nombre, PDO::PARAM_STR);
                $stmt->bindParam(":url", $datos->url, PDO::PARAM_STR );
                $stmt->bindParam(":archivo", $datos->archivo, PDO::PARAM_STR );
                $stmt->bindParam(":servicio", $datos->servicio, PDO::PARAM_STR );
                $stmt->bindParam(":activo", $datos->activo, PDO::PARAM_BOOL);
                $stmt->bindParam(":id_s_conexion", $datos->id_s_conexion, PDO::PARAM_INT);
                $stmt->bindParam(":ruta", $datos->ruta, PDO::PARAM_STR );
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
                    $stmt = ConexionDB::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, url =:url ,activo =:activo, actualizado = CURRENT_TIMESTAMP, actualizado_por=:actualizadopor, archivo = :archivo, servicio = :servicio, ruta= :ruta, id_s_conexion = :id_s_conexion
                                                            WHERE id_s_servicio= :id");

                    $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);
                    $stmt->bindParam(":nombre", $datos->nombre, PDO::PARAM_STR);
                    $stmt->bindParam(":url", $datos->url, PDO::PARAM_STR );
                    $stmt->bindParam(":ruta", $datos->ruta, PDO::PARAM_STR );
                    $stmt->bindParam(":activo", $datos->activo, PDO::PARAM_BOOL);
                    $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);
                    $stmt->bindParam(":archivo", $datos->archivo, PDO::PARAM_STR );
                    $stmt->bindParam(":servicio", $datos->servicio, PDO::PARAM_STR );
                    $stmt->bindParam(":id_s_conexion", $datos->id_s_conexion, PDO::PARAM_INT);


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
                            id_s_servicio, creado, creado_por, actualizado, actualizado_por, url, ruta, nombre, activo, CASE WHEN activo = TRUE THEN 'Activo' ELSE 'No Activo' END AS status_activo, archivo, servicio
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

    public static function listarConexionM($datos)
	{
		static $query = "SELECT
                            id_s_conexion, creado, creado_por, actualizado, actualizado_por, nombre_conexion, activo,  CASE WHEN activo = TRUE THEN 'Activo' ELSE 'No Activo' END AS status_activo
                        FROM s_conexion 
                        WHERE activo =true
                        ORDER BY id_s_conexion
                        ";
		$stmt = ConexionDB::conectar()->prepare($query);
        $stmt -> execute();
        
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        $stmt->close();
	}

    public static function editarUrlM($datos)
	{
            try {
                    static $tabla = "s_servicio";
                    $stmt = ConexionDB::conectar()->prepare("UPDATE $tabla SET url =:url , ruta= :ruta, actualizado = CURRENT_TIMESTAMP, actualizado_por = :actualizadopor WHERE id_s_conexion = :conexion");

                    $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);
                    $stmt->bindParam(":url", $datos->url, PDO::PARAM_STR );
                    $stmt->bindParam(":ruta", $datos->ruta, PDO::PARAM_STR );
                    $stmt->bindParam(":conexion", $datos->conexion, PDO::PARAM_INT );


                    if ($stmt->execute()) {
                        return true;
                    }
                    $stmt->close();

            } catch (Exception $exc) {

                return $exc;
            } 
	}

}

ModeloServicio::inicializacion();


?>