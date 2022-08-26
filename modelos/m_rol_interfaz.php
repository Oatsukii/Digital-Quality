<?php
include("../db/ConexionDB.php");

class ModeloInterfazRol extends ConexionDB
{
    public static $vIdRol;
    public static $vIdUsuario;

    public static function inicializacion(){
        
        self::$vIdUsuario = (int) $_SESSION['usuario'][0]['id_usuario'];
        self::$vIdRol = (int) $_SESSION['usuario'][0]['id_rol'];
    }    

    public static function listarRolMenuM($datos)
	{
		// $query = "SELECT
        // rol_menu.id_rol_menu
        // ,menu.nombre AS NombreMenu
        // ,CASE WHEN rol_menu.activo  = true THEN 'Activo' ELSE 'No Activo' END AS ActivoRolMenu
        // ,menu.orden
        // FROM rol_menu AS rol_menu
        //     INNER JOIN menu AS menu
        //         ON menu.id_menu = rol_menu.id_menu
        // WHERE
        // rol_menu.id_rol=:id
        
        // ORDER BY menu.orden";

		// $stmt = ConexionDB::conectar()->prepare($query);
        // $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);
        // $stmt -> execute();

        // return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        // 
	}

    public static function agregarRolInterfazM($datos)
    {
        try {
                static $tabla = "dev_interfaz_rol";
                $stmt = ConexionDB::conectar()->prepare("INSERT INTO $tabla (id_rol,id_dev_interfaz_origen,activo,creado,actualizado,creadopor,actualizadopor)
                                                        VALUES (:rol,:interfaz,true,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,:creadopor,:actualizadopor)");    
    
                $stmt->bindParam(":rol", $datos->rol, PDO::PARAM_STR);
                $stmt->bindParam(":interfaz", $datos->interfaz, PDO::PARAM_STR);
                $stmt->bindParam(":creadopor", self::$vIdUsuario, PDO::PARAM_INT);
                $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);

                if($stmt->execute())
                    return true;
                    

            } catch (Exception $exc) {
    
                return $exc;
            }
    
    }

	public static function eliminarRolInterfazM($datos)
    {
         try {
                static $tabla = "dev_interfaz_rol";
                $stmt = ConexionDB::conectar()->prepare("DELETE FROM $tabla WHERE id_dev_interfaz_rol = :id");
                $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

                if($stmt->execute())
                    return true;
    
            } catch (Exception $exc) {

                return $exc;
            }     
    }
    

    public static function busquedaComboM($datos)
	{
		static $query = "SELECT 
                            ori.nombre AS Empresa
                            ,di.nombre AS Proceso
                            ,di.orden AS Orden
                            ,di.metodo AS Metodo
                            ,ori.id_servidor_origen AS Conexion
                            ,dio.id_dev_interfaz_origen
                        FROM dev_interfaz AS di
                            INNER JOIN dev_interfaz_origen AS dio
                                ON dio.id_dev_interfaz = di.id_dev_interfaz
                            INNER JOIN servidor_origen AS ori
                                On ori.id_servidor_origen = dio.id_servidor_origen		
                        WHERE
                            ori.id_servidor_origen = :empresa
                            AND di.activo = :activo
                            AND dio.id_dev_interfaz_origen NOT IN (SELECT id_dev_interfaz_origen FROM dev_interfaz_rol WHERE id_rol = :rol  )
                        ORDER BY Orden 
                        ";


		$stmt = ConexionDB::conectar()->prepare($query);

        $stmt->bindParam(":activo", $datos->activo, PDO::PARAM_BOOL);
        $stmt->bindParam(":empresa", $datos->empresa, PDO::PARAM_INT);
        $stmt->bindParam(":rol", $datos->rol, PDO::PARAM_INT);

        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
	}    


    public static function tablaInterfazRolM($datos)
	{
		static $query = "SELECT 
                            ori.nombre AS Empresa
                            ,di.nombre AS Proceso
                            ,di.orden AS Orden
                            ,di.metodo AS Metodo
                            ,ori.id_servidor_origen AS Conexion
                            ,dio.id_dev_interfaz_origen
                            ,ir.id_rol
                            ,ir.id_dev_interfaz_rol

                        FROM dev_interfaz AS di
                            INNER JOIN dev_interfaz_origen AS dio
                                ON dio.id_dev_interfaz = di.id_dev_interfaz
                            INNER JOIN servidor_origen AS ori
                                ON ori.id_servidor_origen = dio.id_servidor_origen
                            INNER JOIN dev_interfaz_rol AS ir
		                        ON ir.id_dev_interfaz_origen = dio.id_dev_interfaz_origen        	
                        WHERE
                            di.activo = :activo
                            AND ir.id_rol = :rol

                        ORDER BY Orden 
                        ";


		$stmt = ConexionDB::conectar()->prepare($query);

        $stmt->bindParam(":activo", $datos->activo, PDO::PARAM_BOOL);
        $stmt->bindParam(":rol", $datos->rol, PDO::PARAM_INT);
        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
	}


	public static function tablaSincronizacionM($datos)
    {
         try {

        static $query = "SELECT 
                    ori.nombre AS Empresa
                    ,di.nombre AS Proceso
                    ,di.orden AS Orden
                    ,di.metodo AS Metodo
                    ,ori.id_servidor_origen AS Conexion
                    ,dio.id_dev_interfaz_origen
                FROM dev_interfaz AS di
                    INNER JOIN dev_interfaz_origen AS dio
                        ON dio.id_dev_interfaz = di.id_dev_interfaz
                    INNER JOIN servidor_origen AS ori
                        ON ori.id_servidor_origen = dio.id_servidor_origen
                    INNER JOIN dev_interfaz_rol AS ir
                        ON ir.id_dev_interfaz_origen = dio.id_dev_interfaz_origen
                WHERE
                    ori.id_servidor_origen = :idempresa
                    AND di.activo = :activo
                    AND ir.id_rol = :rol

                ORDER BY Orden 
                ";

                    $stmt = ConexionDB::conectar()->prepare($query);

                    $stmt->bindParam(":activo", $datos->activo, PDO::PARAM_BOOL);
                    $stmt->bindParam(":idempresa", $datos->idempresa, PDO::PARAM_INT);
                    $stmt->bindParam(":rol", self::$vIdRol , PDO::PARAM_INT);

                    $stmt -> execute();
                    return $stmt -> fetchAll(PDO::FETCH_ASSOC);

                } catch (Exception $exc) {

                return $exc;
            }     
    }     


}

ModeloInterfazRol::inicializacion();

?>