<?php
include("../db/ConexionDB.php");

class ModeloMenuRol extends ConexionDB
{
    public static function listarRolMenuM($datos)
	{
		$query = "SELECT
        rol_menu.id_rol_menu
        ,menu.nombre AS NombreMenu
        ,CASE WHEN rol_menu.activo  = true THEN 'Activo' ELSE 'No Activo' END AS ActivoRolMenu
        ,menu.orden
        FROM rol_menu AS rol_menu
            INNER JOIN menu AS menu
                ON menu.id_menu = rol_menu.id_menu
        WHERE
        rol_menu.id_rol=:id
        
        ORDER BY menu.orden";
		$stmt = ConexionDB::conectar()->prepare($query);
        $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);
        $stmt -> execute();

        return $stmt -> fetchAll(PDO::FETCH_ASSOC);

	}

    public static function agregarRolMenuM($datos)
    {
        try {
                static $tabla = "rol_menu";
                $stmt = ConexionDB::conectar()->prepare("INSERT INTO $tabla (id_menu,id_rol,activo)
                                                        VALUES (:menu,:rol,true)");    
    
                $stmt->bindParam(":rol", $datos->rol, PDO::PARAM_STR);
                $stmt->bindParam(":menu", $datos->menu, PDO::PARAM_STR);
    
                if($stmt->execute())
                    return true;
                    
        
            } catch (Exception $exc) {
    
                return $exc;
            }
    
    }

	public static function eliminarRolMenuM($datos)
    {
         try {
                static $tabla = "rol_menu";
                $stmt = ConexionDB::conectar()->prepare("DELETE FROM $tabla WHERE id_rol_menu = :id");
                $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

                if($stmt->execute())
                    return true;
            
            } catch (Exception $exc) {

                return $exc;
            }     
    }    


}

?>