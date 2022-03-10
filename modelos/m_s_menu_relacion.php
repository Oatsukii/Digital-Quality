<?php

include("../db/ConexionDB.php");

class ModeloMenuRelacion extends ConexionDB
{

    public static $vIdRol;
    public static $vIdUsuario;

    public static function inicializacion(){
        self::$vIdUsuario = (int) $_SESSION['usuario'][0]['id_s_usuario'];
        self::$vIdRol = (int) $_SESSION['usuario'][0]['id_s_rol'];
    }

    public static function listarMenuM($datos)
	{
		static $tabla = "s_menu_relacion";
		$stmt = ConexionDB::conectar()->prepare("SELECT CASE WHEN  m.activo = true THEN 'Activo' ELSE 'No Activo' END EstadoActivo, mr.id_s_menu_relacion, m.nombre AS nombre_menu, em.nombre AS nombre_empresa 
                                                FROM $tabla AS mr
                                                INNER JOIN s_empresa AS em
                                                    ON em.id_s_empresa = mr.id_s_empresa
                                                INNER JOIN s_menu AS m 
	                                                ON m.id_s_menu = mr.id_s_menu
                                                  WHERE m.id_s_menu = :id_s_menu
                                                    ORDER BY orden ASC");
        $stmt->bindParam(":id_s_menu", $datos->id_s_menu, PDO::PARAM_INT);
        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        $stmt->close();
	}

    public static function agregarMenuM($datos)
    {
        try {

                static $tabla = "s_menu_relacion";
                $stmt = ConexionDB::conectar()->prepare("INSERT INTO $tabla (creado, creado_por, actualizado, actualizado_por, id_s_empresa, id_s_menu)
                                                        VALUES (now(), :creado_por, now() ,:actualizado_por, :id_s_empresa, :id_s_menu)");
    
                $stmt->bindParam(":creado_por", self::$vIdUsuario, PDO::PARAM_INT);
                $stmt->bindParam(":actualizado_por", self::$vIdUsuario, PDO::PARAM_INT);
                $stmt->bindParam(":id_s_menu", $datos->id_s_menu, PDO::PARAM_INT);
                $stmt->bindParam(":id_s_empresa", $datos->id_s_empresa, PDO::PARAM_INT);

    
                if($stmt->execute())
                    return true;
                    
                $stmt->close();
            } catch (Exception $exc) {
    
                return $exc;
            }
    
    }

	public static function eliminarMenuM($datos)
    {
         try {
                static $tabla = "s_menu_relacion";
                $stmt = ConexionDB::conectar()->prepare("DELETE FROM $tabla WHERE id_s_menu_relacion = :id");
                $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

                if($stmt->execute())
                    return true;
                    $stmt->close();
            } catch (Exception $exc) {

                return $exc;
            }     
    }


}

ModeloMenuRelacion::inicializacion();
?>