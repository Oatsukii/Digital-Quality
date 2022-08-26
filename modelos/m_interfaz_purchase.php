<?php
include("../db/ConexionDB.php");
include("../generales/Seguridad.php");

class ModeloInterfazCompra extends ConexionDB
{
    public const LLAVE = 'DevTI';

    public static function listarInterfazCompraM($datos)
	{
        static $query = "SELECT
                            pr.id_servidor_datos_orden
                            ,pr.nombre
                            ,pr.id_servidor_origen
                            ,pr.id_servidor_destino
                            ,pr.informacionremota

                        FROM servidor_datos_orden AS pr
                            INNER JOIN servidor_organizacion AS org
                                ON org.id_servidor_organizacion = pr.id_servidor_organizacion_destino
                            INNER JOIN servidor_socio AS soc
                                ON soc.id_servidor_socio = pr.id_servidor_socio_destino
                        
                        WHERE
                        pr.tipo = 'COMPRA'
                        AND pr.activo = :activo";

		$stmt = ConexionDB::conectar()->prepare($query);
        $stmt->bindParam(":activo", $datos->activo, PDO::PARAM_BOOL);
        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
	}

    public static function ejecutarInterfazCompraM($datos)
	{
        try {

                $data = array(); 
                $databasedestino = "SELECT 
                                    
                                    pr.id_servidor_origen
                                    ,pr.id_servidor_destino
                                    ,org.ad_org_id
                                    ,soc.c_bpartner_id
                                    ,pr.id_direccion_destino
                                    ,pr.prefijo_documento_destino
                                    ,pr.consecutivo_documento_destino
                                    ,pr.tipo_documento_destino
                                    ,pr.validar_pedimento_destino
                                    ,pr.invertir_codigo_origen
                                    ,pr.id_iva_destino
                                    ,CASE WHEN pr.inversa_informacion THEN 'SI' ELSE 'NO' END AS inversa_informacion

                                    FROM servidor_datos_orden AS pr
                                        INNER JOIN servidor_organizacion AS org
                                            ON org.id_servidor_organizacion = pr.id_servidor_organizacion_destino
                                        INNER JOIN servidor_socio AS soc
                                            ON soc.id_servidor_socio = pr.id_servidor_socio_destino                                   
                                    WHERE 
                                    pr.id_servidor_datos_orden = :picked";

                $stmt = ConexionDB::conectar()->prepare($databasedestino);
                $stmt->bindParam(":picked", $datos->picked, PDO::PARAM_INT);
                $stmt -> execute();
                $result = $stmt -> fetchAll();

                $IDOrden=$datos->idorden;
                $ListaPrecio=$datos->idlista;
                $IDAlmacen=$datos->idalmacen;
                $InformacionRemota=$datos->remoto;

                //echo ($Movimiento);

                $id_servidor_origen = '';
                $id_servidor_destino = '';

                foreach ($result as $row) {

                    $id_servidor_origen = $row['id_servidor_origen'];
                    $id_servidor_destino = $row['id_servidor_destino'];

                    $data['id_servidor_origen'] = $row['id_servidor_origen'];
                    $data['id_servidor_destino'] = $row['id_servidor_destino'];
                    $data['id_servidor_organizacion_destino'] = $row['ad_org_id'];
                    $data['id_servidor_socio_destino'] = $row['c_bpartner_id'];
                    $data['id_direccion_destino'] = $row['id_direccion_destino'];
                    $data['prefijo_documento_destino'] = $row['prefijo_documento_destino'];
                    $data['consecutivo_documento_destino'] = $row['consecutivo_documento_destino'];
                    $data['tipo_documento_destino'] = $row['tipo_documento_destino'];
                    $data['validar_pedimento_destino'] = $row['validar_pedimento_destino'];
                    $data['invertir_codigo_origen'] = $row['invertir_codigo_origen'];
                    $data['id_iva_destino'] = $row['id_iva_destino'];
                    $data['inversa_informacion'] = $row['inversa_informacion'];
                } 

                $origen = new ModeloInterfazCompra;
                $resultado_origen = $origen->obtenerDatosConexionOrigen($id_servidor_origen); 

                $destino = new ModeloInterfazCompra;
                $resultado_destino = $destino->obtenerDatosConexionDestino($id_servidor_destino); 

                $ejecutar = new ModeloInterfazCompra;
                $resultado = $ejecutar->procesaInterfazCompraM($IDOrden, $ListaPrecio, $IDAlmacen, $InformacionRemota, array($data), array($resultado_origen), array($resultado_destino));

                //return $data;
                //return array($data,$resultado_origen,$resultado_destino);
                return $resultado;


            } catch (Exception $exc) {

                return $exc;
            }
    }

    public static function obtenerDatosConexionOrigen($id)
	{
        try {
                $data = array(); 
                $databasedestino = "SELECT * FROM servidor_origen WHERE id_servidor_origen = :picked";
                $stmt = ConexionDB::conectar()->prepare($databasedestino);
                $stmt->bindParam(":picked", $id, PDO::PARAM_INT);
                $stmt -> execute();
                $result = $stmt -> fetchAll();

                foreach ($result as $row) {
                    $data['servidor_origen'] = $row['servidor'];
                    $data['base_origen'] = $row['base'];
                    $data['usuario_origen'] = $row['usuario'];
                    $data['contrasenia_origen'] = $row['contrasenia'];
                    $data['puerto_origen'] = $row['puerto'];
                    $data['esquema_origen'] = $row['esquema'];
                }

                return $data;

            } catch (Exception $exc) {

                return $exc;
            }
    }

    public static function obtenerDatosConexionDestino($id)
	{
        try {
                $data = array(); 
                $databasedestino = "SELECT * FROM servidor_origen WHERE id_servidor_origen = :picked";
                $stmt = ConexionDB::conectar()->prepare($databasedestino);
                $stmt->bindParam(":picked", $id, PDO::PARAM_INT);
                $stmt -> execute();
                $result = $stmt -> fetchAll();

                foreach ($result as $row) {
                    $data['servidor_destino'] = $row['servidor'];
                    $data['base_destino'] = $row['base'];
                    $data['usuario_destino'] = $row['usuario'];
                    $data['contrasenia_destino'] = $row['contrasenia'];
                    $data['puerto_destino'] = $row['puerto'];
                    $data['esquema_destino'] = $row['esquema'];
                }

                return $data;

            } catch (Exception $exc) {

                return $exc;
            }          
    }
    
    public static function procesaInterfazCompraM($orden,$lista,$almacen,$remoto,$array_datos,$array_origen,$array_destino)
	{
        try {

            $id_documento = $orden;
            $id_lista = $lista;
            $id_almacen = $almacen;
            $es_remoto = $remoto;

            /** ORIGEN */
            $servidor_origen = '';
            $base_origen = '';
            $usuario_origen = '';
            $contrasenia_origen = '';
            $puerto_origen = '';
            $esquema_origen = '';

            $Seguridad = new Seguridad();

            if($es_remoto == true){

                foreach ($array_origen as $o) {

                    $servidor_origen =  $o['servidor_origen'] ;
                    $base_origen = $Seguridad->decrypt($o['base_origen'],ModeloInterfazCompra::LLAVE);
                    $usuario_origen = $Seguridad->decrypt($o['usuario_origen'],ModeloInterfazCompra::LLAVE);
                    $contrasenia_origen = $Seguridad->decrypt($o['contrasenia_origen'],ModeloInterfazCompra::LLAVE);
                    $puerto_origen = $o['puerto_origen'];
                    $esquema_origen = $o['esquema_origen'];
                }

            }

            /** DESTINO */
            $servidor_destino = '';
            $base_destino = '';
            $usuario_destino = '';
            $contrasenia_destino = '';
            $puerto_destino = '';
            $esquema_destino = '';


            foreach ($array_destino as $d) {

                $servidor_destino =  $d['servidor_destino'] ;
                $base_destino = $Seguridad->decrypt($d['base_destino'],ModeloInterfazCompra::LLAVE);
                $usuario_destino = $Seguridad->decrypt($d['usuario_destino'],ModeloInterfazCompra::LLAVE);
                $contrasenia_destino = $Seguridad->decrypt($d['contrasenia_destino'],ModeloInterfazCompra::LLAVE);
                $puerto_destino = $d['puerto_destino'];
                $esquema_destino = $d['esquema_destino'];
            }

            /** DATOS */
            $ad_org_id = '';
            $c_bpartner_id = '';
            $id_direccion_destino = '';
            $prefijo_documento_destino = '';
            $consecutivo_documento_destino = '';
            $tipo_documento_destino = '';
            $inventir_codigo = '';
            $validar_pedimento = '';
            $id_iva_destino = '';
            $inversa = '';
            
            foreach ($array_datos as $t) {
                $ad_org_id = $t["id_servidor_organizacion_destino"];
                $c_bpartner_id = $t["id_servidor_socio_destino"];
                $id_direccion_destino = $t["id_direccion_destino"];
                $prefijo_documento_destino = $t["prefijo_documento_destino"];
                $consecutivo_documento_destino = $t["consecutivo_documento_destino"];
                $tipo_documento_destino = $t["tipo_documento_destino"];
                $inventir_codigo = $t["invertir_codigo_origen"];
                $validar_pedimento = $t["validar_pedimento_destino"];
                $id_iva_destino = $t["id_iva_destino"];
                $inversa = $t["inversa_informacion"];

            }

             if($es_remoto == true){
                 
                $query = "SELECT * FROM AD_CrearOrdenCompra(".$id_documento .",".$ad_org_id.",". $id_lista ."
                                                            ,".$c_bpartner_id.",".$id_direccion_destino.",'".$prefijo_documento_destino."',".$consecutivo_documento_destino.",".$tipo_documento_destino.",". $id_almacen .",'".$inventir_codigo."','".$validar_pedimento."',".$id_iva_destino.",'".$inversa."'
                                                            ,'".$servidor_origen."','".$base_origen."', '".$usuario_origen."','".$contrasenia_origen."','".$puerto_origen."','".$esquema_origen."','1000000'
                                                            ,'".$servidor_destino."','".$base_destino."', '".$usuario_destino."','".$contrasenia_destino."','".$puerto_destino."','".$esquema_destino."','1000000')";
                //print_r($query);

             }else if($es_remoto == false){

                $query = "SELECT * FROM AD_CrearOrdenCompra_Dev(".$id_documento .",".$ad_org_id.",". $id_lista ."
                                                                ,".$c_bpartner_id.",".$id_direccion_destino.",'".$prefijo_documento_destino."',".$consecutivo_documento_destino.",".$tipo_documento_destino.",". $id_almacen .",'".$inventir_codigo."','".$validar_pedimento."',".$id_iva_destino."
                                                                ,'".$servidor_destino."','".$base_destino."', '".$usuario_destino."','".$contrasenia_destino."','".$puerto_destino."','".$esquema_destino."','1000000') AS AD_CrearOrdenCompra";

                //print_r($query);
             }

             
           $stmt = ConexionDB::conectar()->prepare($query);
           $stmt -> execute();

           return $stmt -> fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $exc) {

            return $exc;
        }  
	}     



}

?>