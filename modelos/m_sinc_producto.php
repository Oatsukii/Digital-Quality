<?php
include("../db/ConexionDB.php");

class ModeloProducto extends ConexionDB
{
    public static $vIdRol;
    public static $vIdUsuario;
    public static $vIdEmpresa;

    public static function inicializacion(){
        self::$vIdUsuario = (int) $_SESSION['usuario'][0]['id_s_usuario'];
        self::$vIdEmpresa = (int) $_SESSION['usuario'][0]['id_s_empresa'];
    }

    public static function agregarProductoM($datos)
    {
        try {
                $stmt = ConexionDB::conectar()->prepare("SELECT FROM s_producto(:empleados, :empresa, :usuario)");
                $stmt->bindParam(":empresa", self::$vIdEmpresa, PDO::PARAM_INT);
                $stmt->bindParam(":empleados", $datos->empleados, PDO::PARAM_STR);
                $stmt->bindParam(":usuario", self::$vIdUsuario, PDO::PARAM_INT);
                $stmt->execute();
                return true;
                
                $stmt->close();
            } catch (Exception $exc) {
                return $exc;
            }
    }

    public static function listarProductoM($datos)
	{
		static $query = "SELECT
                            p.id_ad_producto, p.id_adempiere_producto, p.codigo, p.codigo_corto, p.descripcion, p.activo
                            ,  CASE WHEN p.activo = TRUE THEN 'Activo' ELSE 'No Activo' END AS status_activo ,em.id_s_empresa, em.nombre AS empresa
                        FROM ad_producto AS p
                        INNER JOIN s_empresa AS em ON em.id_s_empresa = p.id_s_empresa
                        ORDER BY id_ad_producto
                        ";
		$stmt = ConexionDB::conectar()->prepare($query);
        $stmt -> execute();
        
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        $stmt->close();
	}

    public static function listarServicioM($datos){
        static $query = "SELECT
                            id_s_servicio, creado, creado_por, actualizado, actualizado_por, url, nombre, activo, CASE WHEN activo = TRUE THEN 'Activo' ELSE 'No Activo' END AS status_activo
                        FROM s_servicio
                        WHERE nombre = :nombre
                        ORDER BY id_s_servicio
                        ";
		$stmt = ConexionDB::conectar()->prepare($query);
        $stmt->bindParam(":nombre", $datos->nombre, PDO::PARAM_STR);

        $stmt -> execute();
        
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        $stmt->close();
    }

}

ModeloProducto::inicializacion();


?>