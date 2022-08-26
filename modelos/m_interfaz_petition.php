<?php

include("../db/ConexionDB.php");
include("../generales/Seguridad.php");

class ModeloInterfazPedimento extends ConexionDB
{
    public const LLAVE = 'DevTI';

    public static function listarInterfazPedimentoM($datos)
	{
		static $query = "SELECT
                            pr.id_servidor_datos_orden
                            ,pr.nombre
                            ,pr.id_servidor_destino

                        FROM servidor_datos_orden AS pr

                        WHERE
                            pr.tipo = 'PEDIMENTO'
                            AND pr.Activo = :activo";

		$stmt = ConexionDB::conectar()->prepare($query);
        $stmt->bindParam(":activo", $datos->activo, PDO::PARAM_BOOL);
        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
	}

    public static function ejecutarInterfazPedimentoM($datos)
	{
        try {
                $data = array(); 
                $databasedestino = "SELECT * FROM servidor_datos_orden WHERE id_servidor_datos_orden = :picked";
                $stmt = ConexionDB::conectar()->prepare($databasedestino);
                $stmt->bindParam(":picked", $datos->picked, PDO::PARAM_INT);
                $stmt -> execute();
                $result = $stmt -> fetchAll();

                $IDOrden=$datos->idorden;
                $Pedimento=$datos->pedimento;
                $Fecha=$datos->fechapedimento;

                $id_servidor_origen = '';
                $id_servidor_destino = '';

                foreach ($result as $row) {

                    $id_servidor_origen = $row['id_servidor_origen'];
                    $id_servidor_destino = $row['id_servidor_destino'];

                    $data['nombre'] = $row['nombre'];
                    $data['id_servidor_origen'] = $row['id_servidor_origen'];
                    $data['id_servidor_destino'] = $row['id_servidor_destino'];
                    $data['id_servidor_organizacion_destino'] = $row['id_servidor_organizacion_destino'];
                    $data['id_servidor_socio_destino'] = $row['id_servidor_socio_destino'];
                    $data['id_direccion_destino'] = $row['id_direccion_destino'];
                    $data['prefijo_documento_destino'] = $row['prefijo_documento_destino'];
                    $data['consecutivo_documento_destino'] = $row['consecutivo_documento_destino'];
                    $data['tipo_documento_destino'] = $row['tipo_documento_destino'];
                    $data['id_iva_destino'] = $row['id_iva_destino'];

                } 

                $origen = new ModeloInterfazPedimento;
                $resultado_origen = $origen->obtenerDatosConexionOrigen($id_servidor_origen); 

                $destino = new ModeloInterfazPedimento;
                $resultado_destino = $destino->obtenerDatosConexionDestino($id_servidor_destino); 

                $ejecutar = new ModeloInterfazPedimento;
                $resultado = $ejecutar->procesaInterfazPedimentoM($IDOrden, $Pedimento, $Fecha, array($data), array($resultado_origen), array($resultado_destino));

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

    public static function procesaInterfazPedimentoM($id,$ped,$fecha,$array_datos,$array_origen,$array_destino)
	{
        try {

            /** ORIGEN */
            /*
            foreach ($array_origen as $o) {
                $email = $mailSend["email"];
                $nombre = $mailSend["nombre"];
                $mail->AddAddress($email, $nombre);
            }
            */

            /** DESTINO */
            $servidor_destino = '';
            $base_destino = '';
            $usuario_destino = '';
            $contrasenia_destino = '';
            $puerto_destino = '';
            $esquema_destino = '';

            $Seguridad = new Seguridad();

            foreach ($array_destino as $d) {

                $servidor_destino =  $d['servidor_destino'] ;
                $base_destino = $Seguridad->decrypt($d['base_destino'],ModeloInterfazPedimento::LLAVE);
                $usuario_destino = $Seguridad->decrypt($d['usuario_destino'],ModeloInterfazPedimento::LLAVE);
                $contrasenia_destino = $Seguridad->decrypt($d['contrasenia_destino'],ModeloInterfazPedimento::LLAVE);
                $puerto_destino = $d['puerto_destino'];
                $esquema_destino = $d['esquema_destino'];
            }

            /** DATOS */
            /*
            foreach ($array_datos as $t) {
                $email = $mailSend["email"];
                $nombre = $mailSend["nombre"];
                $mail->AddAddress($email, $nombre);
            } 
            */           

            //return $base_destino;

            $id_documento = $id;
            $fechapedimento = "'".$fecha."'::date";
            $str1 = substr($ped, 0, 2);
            $str2 = substr($ped, 2, 2);
            $str3 = substr($ped, 4, 4);
            $str4 = substr($ped, 8, 7);
            $nuevopedimento = "'".$str1 . '  ' . $str2 . '  ' . $str3 . '  ' . $str4."'";

            $query = "SELECT * FROM AD_Pedimento(".$id_documento .",". $nuevopedimento .",". $fechapedimento ."
                                                    ,'".$servidor_destino."','".$base_destino."', '".$usuario_destino."','".$contrasenia_destino."','".$puerto_destino."','".$esquema_destino."','1000000')";

           $stmt = ConexionDB::conectar()->prepare($query);
           $stmt -> execute();

           return $stmt -> fetchAll(PDO::FETCH_ASSOC);


        } catch (Exception $exc) {

            return $exc;
        }  

	}    


}

?>