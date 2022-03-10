<?php

include("../db/ConexionDB.php");

class ModeloMenu extends ConexionDB
{

    public static $vIdRol;
    public static $vIdUsuario;

    public static function inicializacion(){
        self::$vIdUsuario = (int) $_SESSION['usuario'][0]['id_s_usuario'];
        self::$vIdRol = (int) $_SESSION['usuario'][0]['id_s_rol'];
    }

    public static function listarMenuM()
	{
		static $tabla = "s_menu";
		$stmt = ConexionDB::conectar()->prepare("SELECT *,CASE WHEN  activo = true THEN 'Activo' ELSE 'No Activo' END EstadoActivo FROM $tabla ORDER BY orden ASC");
        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        $stmt->close();
	}

    public static function agregarMenuM($datos)
    {
        try {

                static $tabla = "s_menu";
                $stmt = ConexionDB::conectar()->prepare("INSERT INTO $tabla (creado, creado_por, actualizado, actualizado_por, nombre,url,svg,orden,activo,pagina_principal)
                                                        VALUES (now(), :creado_por, now() ,:actualizado_por, :nombre, :url,:svg,:orden,:checked,:principal)");    
    
                $stmt->bindParam(":creado_por", self::$vIdUsuario, PDO::PARAM_INT);
                $stmt->bindParam(":actualizado_por", self::$vIdUsuario, PDO::PARAM_INT);
                $stmt->bindParam(":nombre", $datos->nombre, PDO::PARAM_STR);
                $stmt->bindParam(":url", $datos->url, PDO::PARAM_STR);
                $stmt->bindParam(":svg", $datos->svg, PDO::PARAM_STR);
                $stmt->bindParam(":orden", $datos->orden, PDO::PARAM_INT);
                $stmt->bindParam(":checked", $datos->checked, PDO::PARAM_BOOL);
                $stmt->bindParam(":principal", $datos->principal, PDO::PARAM_BOOL);
                // $stmt->bindParam(":id_s_empresa", $datos->id_s_empresa, PDO::PARAM_INT);

    
                if($stmt->execute())
                    return true;
                    
                $stmt->close();
            } catch (Exception $exc) {
    
                return $exc;
            }
    
    }

	public static function editarMenuM($datos)
	{
            try {
                    static $tabla = "s_menu";
                    $stmt = ConexionDB::conectar()->prepare("UPDATE $tabla SET nombre=:nombre, url=:url, svg=:svg, orden=:orden, activo = :checked, pagina_principal=:principal, actualizado = now(), actualizado_por = :actualizado_por WHERE id_s_menu= :id");

                    $stmt->bindParam(":actualizado_por", self::$vIdUsuario, PDO::PARAM_INT);
                    $stmt->bindParam(":nombre", $datos->nombre, PDO::PARAM_STR);
                    $stmt->bindParam(":url", $datos->url, PDO::PARAM_STR);
                    $stmt->bindParam(":svg", $datos->svg, PDO::PARAM_STR);
                    $stmt->bindParam(":orden", $datos->orden, PDO::PARAM_INT);
                    $stmt->bindParam(":checked", $datos->checked, PDO::PARAM_BOOL);
                    $stmt->bindParam(":principal", $datos->principal, PDO::PARAM_BOOL);
                    $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);
                    // $stmt->bindParam(":id_s_empresa", $datos->id_s_empresa, PDO::PARAM_INT);


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
                static $tabla = "s_menu";
                $stmt = ConexionDB::conectar()->prepare("DELETE FROM $tabla WHERE id_s_menu = :id");
                $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

                if($stmt->execute())
                    return true;
                    $stmt->close();
            } catch (Exception $exc) {

                return $exc;
            }
    }

    public static function listarRolMenuM()
	{
		static $tabla = "s_menu";
		$stmt = ConexionDB::conectar()->prepare("SELECT *,CASE WHEN  activo = true THEN 'Activo' ELSE 'No Activo' END EstadoActivo FROM $tabla WHERE activo = true ORDER BY orden ASC");
        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        $stmt->close();
	}


}

ModeloMenu::inicializacion();
?>