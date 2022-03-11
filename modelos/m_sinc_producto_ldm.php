<?php
include("../db/ConexionDB.php");

class ModeloProductoLDM extends ConexionDB
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
                $stmt = ConexionDB::conectar()->prepare("SELECT FROM s_producto_ldm(:empleados, :empresa, :usuario, :proceso)");
                $stmt->bindParam(":empresa", self::$vIdEmpresa, PDO::PARAM_INT);
                $stmt->bindParam(":empleados", $datos->empleados, PDO::PARAM_STR);
                $stmt->bindParam(":usuario", self::$vIdUsuario, PDO::PARAM_INT);
                $stmt->bindParam(":proceso", $datos->proceso, PDO::PARAM_INT);
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
                            p.id_ad_producto_ldm ,em.id_s_empresa, p.id_s_proceso_costo, p.id_adempiere_producto, p.codigo, p.descripcion, p.activo
                            ,CASE WHEN p.activo = TRUE THEN 'Activo' ELSE 'No Activo' END AS status_activo , costo_ldm, p.s_contexto, em.nombre AS empresa
                        FROM ad_producto_ldm AS p
                        INNER JOIN s_empresa AS em ON em.id_s_empresa = p.id_s_empresa
                        ORDER BY id_ad_producto_ldm
                        ";
		$stmt = ConexionDB::conectar()->prepare($query);
        $stmt -> execute();
        
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        $stmt->close();
	}


}

ModeloProductoLDM::inicializacion();


?>