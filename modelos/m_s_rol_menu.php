<?php
include("../db/ConexionDB.php");

class ModeloMenuRol extends ConexionDB
{

    public static $vIdRol;
    public static $vIdUsuario;

    public static function inicializacion(){
        self::$vIdUsuario = (int) $_SESSION['usuario'][0]['id_s_usuario'];
        self::$vIdRol = (int) $_SESSION['usuario'][0]['id_s_rol'];
    }

    public static function listarRolMenuM($datos)
	{
		$query = "SELECT rm.id_s_rol_menu, r.id_s_rol, m.id_s_menu, em.id_s_empresa, m.nombre AS menu, r.rol, em.nombre AS empresa
                    FROM s_rol_menu AS rm
                    INNER JOIN s_menu AS m 
                        ON m.id_s_menu = rm.id_s_menu
                    INNER JOIN s_rol AS r
                        ON r.id_s_rol = rm.id_s_rol
                    INNER JOIN s_empresa AS em
                        ON rm.id_s_empresa = em.id_s_empresa
                    WHERE r.activo = true AND m.activo = true
                            AND
                                r.id_s_rol = :id
        
        ORDER BY m.orden";



		$stmt = ConexionDB::conectar()->prepare($query);
        $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);
        $stmt -> execute();

        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        
	}

    public static function agregarRolMenuM($datos)
    {
        try {
                static $tabla = "s_rol_menu";
                $stmt = ConexionDB::conectar()->prepare("INSERT INTO $tabla (creado, creado_por, actualizado, actualizado_por, id_s_rol, id_s_menu, id_s_empresa)
                                                        VALUES (now(), :creado_por, now(), :actualizado_por, :id_s_rol, :id_s_menu, :id_s_empresa)");
    
                $stmt->bindParam(":creado_por", self::$vIdUsuario, PDO::PARAM_INT);
                $stmt->bindParam(":actualizado_por", self::$vIdUsuario, PDO::PARAM_INT);
                $stmt->bindParam(":id_s_menu", $datos->id_s_menu, PDO::PARAM_INT);
                $stmt->bindParam(":id_s_empresa", $datos->id_s_empresa, PDO::PARAM_INT);
                $stmt->bindParam(":id_s_rol", $datos->id_s_rol, PDO::PARAM_INT);
                if($stmt->execute())
                    return true;
                    
                
            } catch (Exception $exc) {
    
                return $exc;
            }
    
    }

	public static function eliminarRolMenuM($datos)
    {
         try {
                static $tabla = "s_rol_menu";
                $stmt = ConexionDB::conectar()->prepare("DELETE FROM $tabla WHERE id_s_rol_menu = :id");
                $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

                if($stmt->execute())
                    return true;
                    
            } catch (Exception $exc) {

                return $exc;
            }     
    }    


}

ModeloMenuRol::inicializacion();


?>