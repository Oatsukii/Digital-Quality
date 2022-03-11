<?php
include("../db/ConexionDB.php");

class ModeloMaquila extends ConexionDB
{
    public static $vIdRol;
    public static $vIdUsuario;
    public static $vIdEmpresa;

    public static function inicializacion(){
        self::$vIdUsuario = (int) $_SESSION['usuario'][0]['id_s_usuario'];
        self::$vIdEmpresa = (int) $_SESSION['usuario'][0]['id_s_empresa'];
    }

    public static function agregarMaquilaM($datos)
    {
        try {
                $stmt = ConexionDB::conectar()->prepare("SELECT FROM s_maquila(:empleados, :empresa, :usuario, :proceso)");
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

    public static function listarMaquilaM($datos)
	{
		static $query = "SELECT
                             m.id_ad_maquila, m.id_s_empresa, m.id_s_proceso_costo, m.creado, m.creado_por, m.actualizado_por, m.id_adempiere_organizacion, m.numero_segmento, m.rfc, m.socio_negocio, m.periodo, m.fecha_movimiento, m.subtotal, m.total, em.nombre AS empresa, o.nombre AS organizacion
                        FROM ad_maquila AS m
                        INNER JOIN s_empresa AS em ON em.id_s_empresa = m.id_s_empresa
                        INNER JOIN s_organizacion AS o ON o.id_adempiere_organizacion = m.id_adempiere_organizacion
                        ORDER BY id_ad_maquila
                        ";
		$stmt = ConexionDB::conectar()->prepare($query);
        $stmt -> execute();
        
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        $stmt->close();
	}


}

ModeloMaquila::inicializacion();


?>