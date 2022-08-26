<?php
include("../db/ConexionDB.php");

class ModeloProductoFlujo extends ConexionDB
{
    public static $vIdRol;
    public static $vIdUsuario;
    public static $vIdEmpresa;

    public static function inicializacion(){
        self::$vIdUsuario = (int) $_SESSION['usuario'][0]['id_s_usuario'];
        self::$vIdEmpresa = (int) $_SESSION['usuario'][0]['id_s_empresa'];
    }

    public static function agregarProductoFlujoM($datos)
    {
        try {
                $stmt = ConexionDB::conectar()->prepare("SELECT FROM s_producto_flujo(:empleados, :empresa, :usuario, :proceso)");
                $stmt->bindParam(":empresa", self::$vIdEmpresa, PDO::PARAM_INT);
                $stmt->bindParam(":empleados", $datos->empleados, PDO::PARAM_STR);
                $stmt->bindParam(":usuario", self::$vIdUsuario, PDO::PARAM_INT);
                $stmt->bindParam(":proceso", $datos->proceso, PDO::PARAM_INT);

                $stmt->execute();
                return true;
                
                
            } catch (Exception $exc) {
                return $exc;
            }
    }

    public static function listarProductoFlujoM($datos)
	{
		static $query = "SELECT

                            p.id_ad_producto_flujo, p.id_s_empresa, p.id_s_proceso_costo, p.creado, p.creado_por, p.actualizado, p.actualizado_por,
                            p.id_adempiere_producto, p.codigo, p.descripcion, p.activo,  CASE WHEN p.activo = TRUE THEN 'Activo' ELSE 'No Activo' END AS status_activo, p.s_contexto, 
                            p.gastos_generales, p.gastos_administrativos, p.gastos_operacion, p.gastos_ventas, p.utilidad, p.id_adempiere_organizacion, 
                            numero_segmento, id_adempiere_flujo,  em.nombre AS empresa
                        FROM ad_producto_flujo AS p
                        INNER JOIN s_empresa AS em ON em.id_s_empresa = p.id_s_empresa
                        ORDER BY id_ad_producto_flujo
                        ";
		$stmt = ConexionDB::conectar()->prepare($query);
        $stmt -> execute();
        
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        
	}

}

ModeloProductoFlujo::inicializacion();


?>