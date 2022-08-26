<?php
include("../db/ConexionDB.php");

class ModeloGastos extends ConexionDB
{
    public static $vIdRol;
    public static $vIdUsuario;
    public static $vIdEmpresa;

    public static function inicializacion(){
        self::$vIdUsuario = (int) $_SESSION['usuario'][0]['id_s_usuario'];
        self::$vIdEmpresa = (int) $_SESSION['usuario'][0]['id_s_empresa'];
    }

    public static function agregarGastosM($datos)
    {
        try {
                $stmt = ConexionDB::conectar()->prepare("SELECT FROM s_gastos(:empleados, :empresa, :usuario, :proceso)");
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

    public static function listarGastosM($datos)
	{
		static $query = "SELECT
                            a.id_ad_gasto, a.id_s_empresa, a.id_s_proceso_costo, a.creado, a.creado_por, a.actualizado, a.actualizado_por, a.id_adempiere_organizacion, a.numero_segmento, a.cargo, a.periodo, a.fecha_movimiento, a.subtotal, a.total
	                        , em.nombre AS empresa, o.nombre AS organizacion
                        FROM ad_gasto AS a
                        INNER JOIN s_empresa AS em ON em.id_s_empresa = a.id_s_empresa
                        INNER JOIN s_organizacion AS o ON o.id_adempiere_organizacion = a.id_adempiere_organizacion
                        ORDER BY id_ad_gasto
                        ";
		$stmt = ConexionDB::conectar()->prepare($query);
        $stmt -> execute();
        
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        
	}


}

ModeloGastos::inicializacion();


?>