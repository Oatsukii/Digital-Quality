<?php

include("../db/ConexionDB.php");

class ModeloInterfazGeneral extends ConexionDB
{

    public static function tablaProcesoM($datos)
	{
		static $query = "SELECT 
                            ori.nombre AS Empresa
                            ,di.nombre AS Proceso
                            ,di.orden AS Orden
                            ,di.metodo AS Metodo
                            ,ori.id_servidor_origen AS Conexion
                            ,id_dev_interfaz_origen
                        FROM dev_interfaz AS di
                            INNER JOIN dev_interfaz_origen AS dio
                                ON dio.id_dev_interfaz = di.id_dev_interfaz
                            INNER JOIN servidor_origen AS ori
                                On ori.id_servidor_origen = dio.id_servidor_origen		
                        WHERE
                            ori.id_servidor_origen = :idempresa
                            AND di.activo = :activo

                        ORDER BY Orden 
                        ";


		$stmt = ConexionDB::conectar()->prepare($query);

        $stmt->bindParam(":activo", $datos->activo, PDO::PARAM_BOOL);
        $stmt->bindParam(":idempresa", $datos->idempresa, PDO::PARAM_INT);
        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
	}



    

}

?>