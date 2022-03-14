<?php
include("../db/ConexionDB.php");

class ModeloProcesoCosto extends ConexionDB
{
    public static $vIdEmpresa;
    public static $vIdUsuario;

    public static function inicializacion(){
        self::$vIdUsuario = (int) $_SESSION['usuario'][0]['id_s_usuario'];
        self::$vIdEmpresa = (int) $_SESSION['usuario'][0]['id_s_empresa'];
    }   


    public static function listarProcesoM($datos)
	{
		static $query = "SELECT
                            p.id_s_proceso_costo, p.id_s_empresa, p.creado, p.creado_por, p.actualizado, p.actualizado_por, p.periodo_inicio, p.periodo_fin, p.nombre, p.id_s_estado, p.activo, CASE WHEN p.activo = TRUE THEN 'Activo' ELSE 'No Activo' END AS status_activo
                            ,es.estado, es.abreviatura
                        FROM s_proceso_costo AS p
                        INNER JOIN s_estado AS es ON es.id_s_estado = p.id_s_estado 
                        ORDER BY id_s_proceso_costo";
		$stmt = ConexionDB::conectar()->prepare($query);
        $stmt -> execute();
        
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        $stmt->close();
	}

    public static function agregarProcesoM($datos)
    {
        try {
                static $tabla = "s_proceso_costo";
                $stmt = ConexionDB::conectar()->prepare("INSERT INTO $tabla (id_s_empresa, creado, creado_por, actualizado, actualizado_por, periodo_inicio, periodo_fin, nombre, activo, id_s_estado)
                                                        VALUES (:empresa, CURRENT_TIMESTAMP,:creadopor, CURRENT_TIMESTAMP,:actualizadopor, :periodo_inicio, :periodo_fin,:nombre, :activo, :status)");
                $stmt->bindParam(":empresa", self::$vIdEmpresa, PDO::PARAM_INT);
                $stmt->bindParam(":creadopor", self::$vIdUsuario, PDO::PARAM_INT);
                $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);
                $stmt->bindParam(":periodo_inicio", $datos->periodo_inicio, PDO::PARAM_STR );
                $stmt->bindParam(":periodo_fin", $datos->periodo_fin, PDO::PARAM_STR );
                $stmt->bindParam(":nombre", $datos->nombre, PDO::PARAM_STR);
                $stmt->bindParam(":status", $datos->status, PDO::PARAM_INT);
                $stmt->bindParam(":activo", $datos->activo, PDO::PARAM_BOOL);

                if ($stmt->execute()) {
                    return true;
                }
                $stmt->close();
            } catch (Exception $exc) {
                return $exc;
            }
    }

    public static function editarProcesoM($datos)
	{
            try {
                    static $tabla = "s_proceso_costo";
                    $stmt = ConexionDB::conectar()->prepare("UPDATE $tabla SET nombre = :nombre ,activo =:activo, actualizado = CURRENT_TIMESTAMP, actualizado_por=:actualizadopor, periodo_inicio = :periodo_inicio, periodo_fin = :periodo_fin, id_s_estado = :status
                                                            WHERE id_s_proceso_costo= :id");

                    $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);
                    $stmt->bindParam(":periodo_inicio", $datos->periodo_inicio, PDO::PARAM_STR );
                    $stmt->bindParam(":periodo_fin", $datos->periodo_fin, PDO::PARAM_STR );
                    $stmt->bindParam(":nombre", $datos->nombre, PDO::PARAM_STR);
                    $stmt->bindParam(":status", $datos->status, PDO::PARAM_INT);
                    $stmt->bindParam(":activo", $datos->activo, PDO::PARAM_BOOL);

                    $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);


                    if ($stmt->execute()) {
                        return true;
                    }
                    $stmt->close();

            } catch (Exception $exc) {

                return $exc;
            } 
	}

	public static function eliminarProcesoM($datos)
    {
         try {
                static $tabla = "s_proceso_costo";
                $stmt = ConexionDB::conectar()->prepare("DELETE FROM $tabla WHERE id_s_proceso_costo = :id");
                $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

                if($stmt->execute())
                    return true;
                    $stmt->close();
            } catch (Exception $exc) {

                return $exc;
            }
    }

    public static function MostrarProcesoM($datos)
	{
		static $query = "SELECT
                            id_s_proceso_costo, id_s_empresa, creado, creado_por, actualizado, actualizado_por, periodo_inicio, periodo_fin, nombre, activo, CASE WHEN activo = TRUE THEN 'Activo' ELSE 'No Activo' END AS status_activo
                        FROM s_proceso_costo WHERE id_s_proceso_costo = :id_s_proceso
                        ORDER BY id_s_proceso_costo";
		$stmt = ConexionDB::conectar()->prepare($query);
        $stmt->bindParam(":id_s_proceso", $datos->id_s_proceso, PDO::PARAM_INT);
        $stmt -> execute();
        
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        $stmt->close();
	}

}

ModeloProcesoCosto::inicializacion();


?>