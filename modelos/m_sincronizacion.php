<?php
include("../db/ConexionDB.php");
include("../generales/Seguridad.php");

class ModeloSincronizacion extends ConexionDB
{
    public const LLAVE = 'DevTI';

	public static function ModeloSincronizacionM($datos)
    {
         try {
                $stmt = ConexionDB::conectar()->prepare("SELECT * FROM erp.fn_sincronizatodotemporal()");
                //$stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

                if($stmt->execute())
                    return true;
                    $stmt->close();
            } catch (Exception $exc) {

                return $exc;
            }     
    }    
    
	public static function ventasZBM($datos)
    {
        try {


            $databasedestino = "SELECT * FROM servidor_origen WHERE id_servidor_origen = :picked";
            $stmt = ConexionDB::conectar()->prepare($databasedestino);
            $stmt->bindParam(":picked", $datos->conexion, PDO::PARAM_INT);
            $stmt -> execute();
            $result = $stmt -> fetchAll();

            $Seguridad = new Seguridad();

            $servidor_destino = '';
            $base_destino = '';
            $usuario_destino = '';
            $contrasenia_destino = '';
            $puerto_destino = '';
            $esquema_destino = '';
            $empresa_destino = '';

            foreach ($result as $d) {

                $servidor_destino =  $d['servidor'] ;
                $base_destino = $Seguridad->decrypt($d['base'],ModeloSincronizacion::LLAVE);
                $usuario_destino = $Seguridad->decrypt($d['usuario'],ModeloSincronizacion::LLAVE);
                $contrasenia_destino = $Seguridad->decrypt($d['contrasenia'],ModeloSincronizacion::LLAVE);
                $puerto_destino = $d['puerto'];
                $esquema_destino = $d['esquema'];
                $empresa_destino = $d['nombre'];
            }
            
                 $sql = "SELECT * FROM erp.fn_ventaszb_ad('". $empresa_destino ."', '". $servidor_destino ."', '". $usuario_destino ."', '". $contrasenia_destino ."', '". $base_destino ."', '". $puerto_destino ."', '". $esquema_destino ."')";

                $dblink = ConexionDB::conectar()->prepare($sql);

                if($dblink->execute()){
                   
                    return true;

                }else{

                    return false;

                }
                

            } catch (Exception $exc) {

                return $exc;
            }

    }    

	public static function facturaActualZBM($datos)
    {
        try {


            $databasedestino = "SELECT * FROM servidor_origen WHERE id_servidor_origen = :picked";
            $stmt = ConexionDB::conectar()->prepare($databasedestino);
            $stmt->bindParam(":picked", $datos->conexion, PDO::PARAM_INT);
            $stmt -> execute();
            $result = $stmt -> fetchAll();

            $Seguridad = new Seguridad();

            $servidor_destino = '';
            $base_destino = '';
            $usuario_destino = '';
            $contrasenia_destino = '';
            $puerto_destino = '';
            $esquema_destino = '';
            $empresa_destino = '';

            foreach ($result as $d) {

                $servidor_destino =  $d['servidor'] ;
                $base_destino = $Seguridad->decrypt($d['base'],ModeloSincronizacion::LLAVE);
                $usuario_destino = $Seguridad->decrypt($d['usuario'],ModeloSincronizacion::LLAVE);
                $contrasenia_destino = $Seguridad->decrypt($d['contrasenia'],ModeloSincronizacion::LLAVE);
                $puerto_destino = $d['puerto'];
                $esquema_destino = $d['esquema'];
                $empresa_destino = $d['nombre'];
            }
            
                $dblink = ConexionDB::conectar()->prepare("SELECT * FROM erp.fn_ventaszb_deuda_ad('". $empresa_destino ."', '". $servidor_destino ."', '". $usuario_destino ."', '". $contrasenia_destino ."', '". $base_destino ."', '". $puerto_destino ."', '". $esquema_destino ."')");

                if($dblink->execute()){
                   
                    return true;

                }else{

                    return false;

                }
                

            } catch (Exception $exc) {

                return $exc;
            }

    } 

	public static function trapasosZBM($datos)
    {
        try {


            $databasedestino = "SELECT * FROM servidor_origen WHERE id_servidor_origen = :picked";
            $stmt = ConexionDB::conectar()->prepare($databasedestino);
            $stmt->bindParam(":picked", $datos->conexion, PDO::PARAM_INT);
            $stmt -> execute();
            $result = $stmt -> fetchAll();

            $Seguridad = new Seguridad();

            $servidor_destino = '';
            $base_destino = '';
            $usuario_destino = '';
            $contrasenia_destino = '';
            $puerto_destino = '';
            $esquema_destino = '';
            $empresa_destino = '';

            foreach ($result as $d) {

                $servidor_destino =  $d['servidor'] ;
                $base_destino = $Seguridad->decrypt($d['base'],ModeloSincronizacion::LLAVE);
                $usuario_destino = $Seguridad->decrypt($d['usuario'],ModeloSincronizacion::LLAVE);
                $contrasenia_destino = $Seguridad->decrypt($d['contrasenia'],ModeloSincronizacion::LLAVE);
                $puerto_destino = $d['puerto'];
                $esquema_destino = $d['esquema'];
                $empresa_destino = $d['nombre'];
            }
            
                $sql = "SELECT * FROM erp.fn_traspasozb_ad('". $empresa_destino ."', '". $servidor_destino ."', '". $usuario_destino ."', '". $contrasenia_destino ."', '". $base_destino ."', '". $puerto_destino ."', '". $esquema_destino ."')";
                $dblink = ConexionDB::conectar()->prepare($sql);

                if($dblink->execute()){
                   
                    return true;

                }else{

                    return false;

                }
                

            } catch (Exception $exc) {

                return $exc;
            }  
    }

	public static function trapasoActualZBM($datos)
    {
        try {


            $databasedestino = "SELECT * FROM servidor_origen WHERE id_servidor_origen = :picked";
            $stmt = ConexionDB::conectar()->prepare($databasedestino);
            $stmt->bindParam(":picked", $datos->conexion, PDO::PARAM_INT);
            $stmt -> execute();
            $result = $stmt -> fetchAll();

            $Seguridad = new Seguridad();

            $servidor_destino = '';
            $base_destino = '';
            $usuario_destino = '';
            $contrasenia_destino = '';
            $puerto_destino = '';
            $esquema_destino = '';
            $empresa_destino = '';

            foreach ($result as $d) {

                $servidor_destino =  $d['servidor'] ;
                $base_destino = $Seguridad->decrypt($d['base'],ModeloSincronizacion::LLAVE);
                $usuario_destino = $Seguridad->decrypt($d['usuario'],ModeloSincronizacion::LLAVE);
                $contrasenia_destino = $Seguridad->decrypt($d['contrasenia'],ModeloSincronizacion::LLAVE);
                $puerto_destino = $d['puerto'];
                $esquema_destino = $d['esquema'];
                $empresa_destino = $d['nombre'];
            }
            
                $dblink = ConexionDB::conectar()->prepare("SELECT * FROM erp.fn_traspasozb_deuda_ad('". $empresa_destino ."', '". $servidor_destino ."', '". $usuario_destino ."', '". $contrasenia_destino ."', '". $base_destino ."', '". $puerto_destino ."', '". $esquema_destino ."')");

                if($dblink->execute()){
                   
                    return true;

                }else{

                    return false;

                }
                

            } catch (Exception $exc) {

                return $exc;
            }  
    }

	public static function socioNegocioM($datos)
    {
         try {


            $databasedestino = "SELECT * FROM servidor_origen WHERE id_servidor_origen = :picked";
            $stmt = ConexionDB::conectar()->prepare($databasedestino);
            $stmt->bindParam(":picked", $datos->conexion, PDO::PARAM_INT);
            $stmt -> execute();
            $result = $stmt -> fetchAll();

            $Seguridad = new Seguridad();

            $servidor_destino = '';
            $base_destino = '';
            $usuario_destino = '';
            $contrasenia_destino = '';
            $puerto_destino = '';
            $esquema_destino = '';
            $empresa_destino = '';

            foreach ($result as $d) {

                $servidor_destino =  $d['servidor'] ;
                $base_destino = $Seguridad->decrypt($d['base'],ModeloSincronizacion::LLAVE);
                $usuario_destino = $Seguridad->decrypt($d['usuario'],ModeloSincronizacion::LLAVE);
                $contrasenia_destino = $Seguridad->decrypt($d['contrasenia'],ModeloSincronizacion::LLAVE);
                $puerto_destino = $d['puerto'];
                $esquema_destino = $d['esquema'];
                $empresa_destino = $d['nombre'];

            }

            
                $dblink = ConexionDB::conectar()->prepare("SELECT * FROM erp.fn_sincronizasocio_ad('". $empresa_destino ."', '". $servidor_destino ."', '". $usuario_destino ."', '". $contrasenia_destino ."', '". $base_destino ."', '". $puerto_destino ."', '". $esquema_destino ."')");

                if($dblink->execute()){
                   
                    return true;

                }else{

                    return false;

                }
                

            } catch (Exception $exc) {

                return $exc;
            }
            
    } 


	public static function productoM($datos)
    {
         try {
            
            $databasedestino = "SELECT * FROM servidor_origen WHERE id_servidor_origen = :picked";
            $stmt = ConexionDB::conectar()->prepare($databasedestino);
            $stmt->bindParam(":picked", $datos->conexion, PDO::PARAM_INT);
            $stmt -> execute();
            $result = $stmt -> fetchAll();

            $Seguridad = new Seguridad();

            $servidor_destino = '';
            $base_destino = '';
            $usuario_destino = '';
            $contrasenia_destino = '';
            $puerto_destino = '';
            $esquema_destino = '';
            $empresa_destino = '';

            foreach ($result as $d) {

                $servidor_destino =  $d['servidor'] ;
                $base_destino = $Seguridad->decrypt($d['base'],ModeloSincronizacion::LLAVE);
                $usuario_destino = $Seguridad->decrypt($d['usuario'],ModeloSincronizacion::LLAVE);
                $contrasenia_destino = $Seguridad->decrypt($d['contrasenia'],ModeloSincronizacion::LLAVE);
                $puerto_destino = $d['puerto'];
                $esquema_destino = $d['esquema'];
                $empresa_destino = $d['nombre'];

            }

                $dblink = ConexionDB::conectar()->prepare("SELECT * FROM erp.fn_sincronizaproducto_ad('". $empresa_destino ."', '". $servidor_destino ."', '". $usuario_destino ."', '". $contrasenia_destino ."', '". $base_destino ."', '". $puerto_destino ."', '". $esquema_destino ."')");

                if($dblink->execute()){
                   
                    return true;

                }else{

                    return false;

                }
                

            } catch (Exception $exc) {

                return $exc;
            }
            
    }

	public static function sucursalM($datos)
    {
         try {
            
            $databasedestino = "SELECT * FROM servidor_origen WHERE id_servidor_origen = :picked";
            $stmt = ConexionDB::conectar()->prepare($databasedestino);
            $stmt->bindParam(":picked", $datos->conexion, PDO::PARAM_INT);
            $stmt -> execute();
            $result = $stmt -> fetchAll();

            $Seguridad = new Seguridad();

            $servidor_destino = '';
            $base_destino = '';
            $usuario_destino = '';
            $contrasenia_destino = '';
            $puerto_destino = '';
            $esquema_destino = '';
            $empresa_destino = '';

            foreach ($result as $d) {

                $servidor_destino =  $d['servidor'] ;
                $base_destino = $Seguridad->decrypt($d['base'],ModeloSincronizacion::LLAVE);
                $usuario_destino = $Seguridad->decrypt($d['usuario'],ModeloSincronizacion::LLAVE);
                $contrasenia_destino = $Seguridad->decrypt($d['contrasenia'],ModeloSincronizacion::LLAVE);
                $puerto_destino = $d['puerto'];
                $esquema_destino = $d['esquema'];
                $empresa_destino = $d['nombre'];

            }
            
                $dblink = ConexionDB::conectar()->prepare("SELECT * FROM erp.fn_sincronizasucursal_ad('". $empresa_destino ."', '". $servidor_destino ."', '". $usuario_destino ."', '". $contrasenia_destino ."', '". $base_destino ."', '". $puerto_destino ."', '". $esquema_destino ."')");

                if($dblink->execute()){
                    return true;

                }else{
                    return false;

                }

            } catch (Exception $exc) {

                return $exc;
            }
    }     
       

	public static function almacenM($datos)
    {
         try {
            
            $databasedestino = "SELECT * FROM servidor_origen WHERE id_servidor_origen = :picked";
            $stmt = ConexionDB::conectar()->prepare($databasedestino);
            $stmt->bindParam(":picked", $datos->conexion, PDO::PARAM_INT);
            $stmt -> execute();
            $result = $stmt -> fetchAll();

            $Seguridad = new Seguridad();

            $servidor_destino = '';
            $base_destino = '';
            $usuario_destino = '';
            $contrasenia_destino = '';
            $puerto_destino = '';
            $esquema_destino = '';
            $empresa_destino = '';

            foreach ($result as $d) {

                $servidor_destino =  $d['servidor'] ;
                $base_destino = $Seguridad->decrypt($d['base'],ModeloSincronizacion::LLAVE);
                $usuario_destino = $Seguridad->decrypt($d['usuario'],ModeloSincronizacion::LLAVE);
                $contrasenia_destino = $Seguridad->decrypt($d['contrasenia'],ModeloSincronizacion::LLAVE);
                $puerto_destino = $d['puerto'];
                $esquema_destino = $d['esquema'];
                $empresa_destino = $d['nombre'];

            }
            
                $dblink = ConexionDB::conectar()->prepare("SELECT * FROM erp.fn_sincronizaalmacen_ad('". $empresa_destino ."', '". $servidor_destino ."', '". $usuario_destino ."', '". $contrasenia_destino ."', '". $base_destino ."', '". $puerto_destino ."', '". $esquema_destino ."')");

                if($dblink->execute()){
                    return true;

                }else{
                    return false;

                }

            } catch (Exception $exc) {

                return $exc;
            }
    }


	public static function existenciaM($datos)
    {
         try {
            
            $databasedestino = "SELECT * FROM servidor_origen WHERE id_servidor_origen = :picked";
            $stmt = ConexionDB::conectar()->prepare($databasedestino);
            $stmt->bindParam(":picked", $datos->conexion, PDO::PARAM_INT);
            $stmt -> execute();
            $result = $stmt -> fetchAll();

            $Seguridad = new Seguridad();

            $servidor_destino = '';
            $base_destino = '';
            $usuario_destino = '';
            $contrasenia_destino = '';
            $puerto_destino = '';
            $esquema_destino = '';
            $empresa_destino = '';

            foreach ($result as $d) {

                $servidor_destino =  $d['servidor'] ;
                $base_destino = $Seguridad->decrypt($d['base'],ModeloSincronizacion::LLAVE);
                $usuario_destino = $Seguridad->decrypt($d['usuario'],ModeloSincronizacion::LLAVE);
                $contrasenia_destino = $Seguridad->decrypt($d['contrasenia'],ModeloSincronizacion::LLAVE);
                $puerto_destino = $d['puerto'];
                $esquema_destino = $d['esquema'];
                $empresa_destino = $d['nombre'];

            }
            
                $dblink = ConexionDB::conectar()->prepare("SELECT * FROM erp.fn_sincronizaproductoexistencia('". $empresa_destino ."', '". $servidor_destino ."', '". $usuario_destino ."', '". $contrasenia_destino ."', '". $base_destino ."', '". $puerto_destino ."', '". $esquema_destino ."')");

                if($dblink->execute()){
                    return true;

                }else{
                    return false;

                }

            } catch (Exception $exc) {

                return $exc;
            }
    }      


	public static function MinimoMaximoM($datos)
    {
         try {
            
            $databasedestino = "SELECT * FROM servidor_origen WHERE id_servidor_origen = :picked";
            $stmt = ConexionDB::conectar()->prepare($databasedestino);
            $stmt->bindParam(":picked", $datos->conexion, PDO::PARAM_INT);
            $stmt -> execute();
            $result = $stmt -> fetchAll();

            $Seguridad = new Seguridad();

            $servidor_destino = '';
            $base_destino = '';
            $usuario_destino = '';
            $contrasenia_destino = '';
            $puerto_destino = '';
            $esquema_destino = '';
            $empresa_destino = '';

            foreach ($result as $d) {

                $servidor_destino =  $d['servidor'] ;
                $base_destino = $Seguridad->decrypt($d['base'],ModeloSincronizacion::LLAVE);
                $usuario_destino = $Seguridad->decrypt($d['usuario'],ModeloSincronizacion::LLAVE);
                $contrasenia_destino = $Seguridad->decrypt($d['contrasenia'],ModeloSincronizacion::LLAVE);
                $puerto_destino = $d['puerto'];
                $esquema_destino = $d['esquema'];
                $empresa_destino = $d['nombre'];

            }
            
                $dblink = ConexionDB::conectar()->prepare("SELECT * FROM erp.fn_sincronizaproductominmax_ad('". $empresa_destino ."', '". $servidor_destino ."', '". $usuario_destino ."', '". $contrasenia_destino ."', '". $base_destino ."', '". $puerto_destino ."', '". $esquema_destino ."')");

                if($dblink->execute()){
                    return true;

                }else{
                    return false;

                }

            } catch (Exception $exc) {

                return $exc;
            }
    }  

    public static function ProductoProduccionM($datos)
    {
         try {
            
            $databasedestino = "SELECT * FROM servidor_origen WHERE id_servidor_origen = :picked";
            $stmt = ConexionDB::conectar()->prepare($databasedestino);
            $stmt->bindParam(":picked", $datos->conexion, PDO::PARAM_INT);
            $stmt -> execute();
            $result = $stmt -> fetchAll();

            $Seguridad = new Seguridad();

            $servidor_destino = '';
            $base_destino = '';
            $usuario_destino = '';
            $contrasenia_destino = '';
            $puerto_destino = '';
            $esquema_destino = '';
            $empresa_destino = '';

            foreach ($result as $d) {

                $servidor_destino =  $d['servidor'] ;
                $base_destino = $Seguridad->decrypt($d['base'],ModeloSincronizacion::LLAVE);
                $usuario_destino = $Seguridad->decrypt($d['usuario'],ModeloSincronizacion::LLAVE);
                $contrasenia_destino = $Seguridad->decrypt($d['contrasenia'],ModeloSincronizacion::LLAVE);
                $puerto_destino = $d['puerto'];
                $esquema_destino = $d['esquema'];
                $empresa_destino = $d['nombre'];

            }
            
                $dblink = ConexionDB::conectar()->prepare("SELECT * FROM erp.fn_sincronizaproductoproduccion_ad('". $empresa_destino ."', '". $servidor_destino ."', '". $usuario_destino ."', '". $contrasenia_destino ."', '". $base_destino ."', '". $puerto_destino ."', '". $esquema_destino ."')");

                if($dblink->execute()){
                    return true;

                }else{
                    return false;

                }

            } catch (Exception $exc) {

                return $exc;
            }
    }  

	public static function procesarInformacionZBM($datos)
    {
         try {

                $dblink = ConexionDB::conectar()->prepare("SELECT * FROM erp.fn_procesa_ventas_zb()");

                if($dblink->execute()){
                   
                    return true;

                }else{

                    return false;

                }
                

            } catch (Exception $exc) {

                return $exc;
            }
            
    } 

	public static function listaPrecioM($datos)
    {
         try {

            $databasedestino = "SELECT * FROM servidor_origen WHERE id_servidor_origen = :picked";
            $stmt = ConexionDB::conectar()->prepare($databasedestino);
            $stmt->bindParam(":picked", $datos->conexion, PDO::PARAM_INT);
            $stmt -> execute();
            $result = $stmt -> fetchAll();

            $Seguridad = new Seguridad();

            $servidor_destino = '';
            $base_destino = '';
            $usuario_destino = '';
            $contrasenia_destino = '';
            $puerto_destino = '';
            $esquema_destino = '';
            $empresa_destino = '';

            foreach ($result as $d) {

                $servidor_destino =  $d['servidor'] ;
                $base_destino = $Seguridad->decrypt($d['base'],ModeloSincronizacion::LLAVE);
                $usuario_destino = $Seguridad->decrypt($d['usuario'],ModeloSincronizacion::LLAVE);
                $contrasenia_destino = $Seguridad->decrypt($d['contrasenia'],ModeloSincronizacion::LLAVE);
                $puerto_destino = $d['puerto'];
                $esquema_destino = $d['esquema'];
                $empresa_destino = $d['nombre'];

            }

                $dblink = ConexionDB::conectar()->prepare("SELECT * FROM erp.fn_sincronizalistaprecio_ad('". $empresa_destino ."', '". $servidor_destino ."', '". $usuario_destino ."', '". $contrasenia_destino ."', '". $base_destino ."', '". $puerto_destino ."', '". $esquema_destino ."')");

                if($dblink->execute()){
                   
                    return true;

                }else{

                    return false;

                }

            } catch (Exception $exc) {

                return $exc;
            }     
    }

	public static function productoCompraM($datos)
    {
         try {

            $databasedestino = "SELECT * FROM servidor_origen WHERE id_servidor_origen = :picked";
            $stmt = ConexionDB::conectar()->prepare($databasedestino);
            $stmt->bindParam(":picked", $datos->conexion, PDO::PARAM_INT);
            $stmt -> execute();
            $result = $stmt -> fetchAll();

            $Seguridad = new Seguridad();

            $servidor_destino = '';
            $base_destino = '';
            $usuario_destino = '';
            $contrasenia_destino = '';
            $puerto_destino = '';
            $esquema_destino = '';
            $empresa_destino = '';

            foreach ($result as $d) {

                $servidor_destino =  $d['servidor'] ;
                $base_destino = $Seguridad->decrypt($d['base'],ModeloSincronizacion::LLAVE);
                $usuario_destino = $Seguridad->decrypt($d['usuario'],ModeloSincronizacion::LLAVE);
                $contrasenia_destino = $Seguridad->decrypt($d['contrasenia'],ModeloSincronizacion::LLAVE);
                $puerto_destino = $d['puerto'];
                $esquema_destino = $d['esquema'];
                $empresa_destino = $d['nombre'];

            }

                $dblink = ConexionDB::conectar()->prepare("SELECT * FROM erp.fn_sincronizaproductocompra_ad('". $empresa_destino ."', '". $servidor_destino ."', '". $usuario_destino ."', '". $contrasenia_destino ."', '". $base_destino ."', '". $puerto_destino ."', '". $esquema_destino ."')");

                if($dblink->execute()){
                   
                    return true;

                }else{

                    return false;

                }

            } catch (Exception $exc) {

                return $exc;
            }     
    }


	public static function tipoDocumentoM($datos)
    {
         try {

            $databasedestino = "SELECT * FROM servidor_origen WHERE id_servidor_origen = :picked";
            $stmt = ConexionDB::conectar()->prepare($databasedestino);
            $stmt->bindParam(":picked", $datos->conexion, PDO::PARAM_INT);
            $stmt -> execute();
            $result = $stmt -> fetchAll();

            $Seguridad = new Seguridad();

            $servidor_destino = '';
            $base_destino = '';
            $usuario_destino = '';
            $contrasenia_destino = '';
            $puerto_destino = '';
            $esquema_destino = '';
            $empresa_destino = '';

            foreach ($result as $d) {

                $servidor_destino =  $d['servidor'] ;
                $base_destino = $Seguridad->decrypt($d['base'],ModeloSincronizacion::LLAVE);
                $usuario_destino = $Seguridad->decrypt($d['usuario'],ModeloSincronizacion::LLAVE);
                $contrasenia_destino = $Seguridad->decrypt($d['contrasenia'],ModeloSincronizacion::LLAVE);
                $puerto_destino = $d['puerto'];
                $esquema_destino = $d['esquema'];
                $empresa_destino = $d['nombre'];

            }

                $dblink = ConexionDB::conectar()->prepare("SELECT * FROM erp.fn_sincronizatipodocumento_ad('". $empresa_destino ."', '". $servidor_destino ."', '". $usuario_destino ."', '". $contrasenia_destino ."', '". $base_destino ."', '". $puerto_destino ."', '". $esquema_destino ."')");

                if($dblink->execute()){
                   
                    return true;

                }else{

                    return false;

                }

            } catch (Exception $exc) {

                return $exc;
            }     
    }

}

?>