<?php
include("../db/ConexionDB.php");

class ModeloEstado extends ConexionDB
{
    public static $vIdEmpresa;
    public static $vIdUsuario;

    public static function inicializacion(){
        self::$vIdUsuario = (int) $_SESSION['usuario'][0]['id_s_usuario'];
        self::$vIdEmpresa = (int) $_SESSION['usuario'][0]['id_s_empresa'];
    }   


    public static function listarEstadoM($datos)
	{
		static $query = "SELECT
                            id_s_estado, creado, creado_por, actualizado, actualizado_por, estado, abreviatura, activo, CASE WHEN activo = TRUE THEN 'Activo' ELSE 'No Activo' END AS status_activo
                        FROM s_estado
                        ORDER BY id_s_estado";
		$stmt = ConexionDB::conectar()->prepare($query);
        $stmt -> execute();
        
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        
	}

    public static function agregarEstadoM($datos)
    {
        try {
                static $tabla = "s_estado";
                $stmt = ConexionDB::conectar()->prepare("INSERT INTO $tabla (creado, creado_por, actualizado, actualizado_por, estado, abreviatura, activo)
                                                        VALUES ( CURRENT_TIMESTAMP,:creadopor, CURRENT_TIMESTAMP,:actualizadopor, :estado, :abreviatura, :activo)");
                $stmt->bindParam(":creadopor", self::$vIdUsuario, PDO::PARAM_INT);
                $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);
                $stmt->bindParam(":estado", $datos->estado, PDO::PARAM_STR );
                $stmt->bindParam(":abreviatura", $datos->abreviatura, PDO::PARAM_STR );
                $stmt->bindParam(":activo", $datos->activo, PDO::PARAM_BOOL);

                if ($stmt->execute()) {
                    return true;
                }
                
            } catch (Exception $exc) {
                return $exc;
            }
    }

    public static function editarEstadoM($datos)
	{
            try {
                    static $tabla = "s_estado";
                    $stmt = ConexionDB::conectar()->prepare("UPDATE $tabla SET activo =:activo, actualizado = CURRENT_TIMESTAMP, actualizado_por=:actualizadopor, estado = :estado, abreviatura = :abreviatura
                                                            WHERE id_s_estado= :id");

                    $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);
                    $stmt->bindParam(":estado", $datos->estado, PDO::PARAM_STR );
                    $stmt->bindParam(":abreviatura", $datos->abreviatura, PDO::PARAM_STR );
                    $stmt->bindParam(":activo", $datos->activo, PDO::PARAM_BOOL);
                    $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);


                    if ($stmt->execute()) {
                        return true;
                    }
                    

            } catch (Exception $exc) {

                return $exc;
            } 
	}

	public static function eliminarEstadoM($datos)
    {
         try {
                static $tabla = "s_estado";
                $stmt = ConexionDB::conectar()->prepare("DELETE FROM $tabla WHERE id_s_estado = :id");
                $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

                if($stmt->execute())
                    return true;
                    
            } catch (Exception $exc) {

                return $exc;
            }
    }

    public static function EstadosListarM($datos)
    {
        static $query = "SELECT
                            id_s_estado, creado, creado_por, actualizado, actualizado_por, estado, abreviatura, activo
                        FROM s_estado
                        WHERE activo = true
                        ORDER BY id_s_estado";
		$stmt = ConexionDB::conectar()->prepare($query);
        $stmt -> execute();
        
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        
    }

}

ModeloEstado::inicializacion();


?>