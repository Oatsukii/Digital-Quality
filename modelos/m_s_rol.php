<?php
include("../db/ConexionDB.php");

class ModeloRol extends ConexionDB
{

    public static $vIdRol;
    public static $vIdUsuario;

    public static function inicializacion(){
        self::$vIdUsuario = (int) $_SESSION['usuario'][0]['id_s_usuario'];
        self::$vIdRol = (int) $_SESSION['usuario'][0]['rol'];
    }

    public static function listarRolM()
	{
		static $tabla = "s_rol";
		$stmt = ConexionDB::conectar()->prepare("SELECT *,CASE WHEN  activo = true THEN 'Activo' ELSE 'No Activo' END EstadoActivo FROM $tabla ORDER BY id_s_rol ASC");
        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        $stmt->close();
	}
    
    public static function agregarRolM($datos)
    {
        try {
                static $tabla = "s_rol";
                $stmt = ConexionDB::conectar()->prepare("INSERT INTO $tabla (creado, creado_por, actualizado, actualizado_por, rol,nombre,activo)
                                                        VALUES (now(),:creado_por, now(), :actualizado_por, :rol,:alias,:checked)");

                $stmt->bindParam(":creado_por", self::$vIdUsuario, PDO::PARAM_INT);
                $stmt->bindParam(":actualizado_por", self::$vIdUsuario, PDO::PARAM_INT);
                $stmt->bindParam(":rol", $datos->rol, PDO::PARAM_STR);
                $stmt->bindParam(":alias", $datos->alias, PDO::PARAM_STR);
                $stmt->bindParam(":checked", $datos->checked, PDO::PARAM_BOOL);
    
                if($stmt->execute())
                    return true;
                    
                $stmt->close();
            } catch (Exception $exc) {
    
                return $exc;
            }
    
    }
    
	public static function editarRolM($datos)
	{
            try {
                    static $tabla = "s_rol";
                    $stmt = ConexionDB::conectar()->prepare("UPDATE $tabla SET rol = :rol ,nombre=:alias ,activo = :checked, actualizado = now(), actualizado_por = :actualizado_por WHERE id_s_rol= :id");

                    $stmt->bindParam(":actualizado_por", self::$vIdUsuario, PDO::PARAM_INT);
                    $stmt->bindParam(":rol", $datos->rol, PDO::PARAM_STR);
                    $stmt->bindParam(":alias", $datos->alias, PDO::PARAM_STR);
                    $stmt->bindParam(":checked", $datos->checked, PDO::PARAM_BOOL);
                    $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

                    if($stmt->execute())
                        return true;
                    //cerrar la conexion con la base de datos
                    $stmt->close();

            } catch (Exception $exc) {

                return $exc;
            }             
	}

	public static function eliminarRolM($datos)
    {
         try {
                static $tabla = "s_rol";
                $stmt = ConexionDB::conectar()->prepare("DELETE FROM $tabla WHERE id_s_rol = :id");
                $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

                if($stmt->execute())
                    return true;
                    $stmt->close();
            } catch (Exception $exc) {

                return $exc;
            }     
    }    
        
    public static function listarRolEspecificoM($datos)
	{
		static $tabla = "s_rol";
		$stmt = ConexionDB::conectar()->prepare("SELECT *,CASE WHEN  activo = true THEN 'Activo' ELSE 'No Activo' END EstadoActivo FROM $tabla WHERE id_s_rol = :id_s_rol");
        $stmt->bindParam(":id_s_rol", $datos->id_s_rol, PDO::PARAM_INT);
        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        $stmt->close();
	}

}

ModeloRol::inicializacion();
?>