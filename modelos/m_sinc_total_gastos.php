<?php
include("../db/ConexionDB.php");

class ModeloTotalGastos extends ConexionDB
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
                $stmt = ConexionDB::conectar()->prepare("SELECT FROM s_empleadoImss(:coleccion, :empresa, :usuario, :proceso)");
                $stmt->bindParam(":empresa", self::$vIdEmpresa, PDO::PARAM_INT);
                $stmt->bindParam(":coleccion", $datos->coleccion, PDO::PARAM_STR);
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
                            e.id_c_empleado, e.id_s_empresa, e.id_s_proceso_costo, e.creado, e.creado_por, e.actualizado, e.actualizado_por, e.id_cerberus_sucursal, e.numero_segmento, e.cargo, e.periodo::date AS periodo, e.fecha_movimiento, e.subtotal
                             ,em.nombre AS empresa, o.nombre AS organizacion, pc.periodo_inicio, pc.periodo_fin
                             FROM c_empleado AS e
                        INNER JOIN s_empresa AS em ON em.id_s_empresa = e.id_s_empresa
                        INNER JOIN s_organizacion AS o ON o.id_adempiere_organizacion = e.id_cerberus_sucursal
                        INNER JOIN s_proceso_costo AS pc ON pc.id_s_proceso_costo= e.id_s_proceso_costo
                        ORDER BY id_c_empleado
                        ";
		$stmt = ConexionDB::conectar()->prepare($query);
        $stmt -> execute();

        
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        
	}

    public function generarTokenM($datos){
        try { 
            $url = 'https://surver.code-byte.com.mx:5858/api/loginKosten';
            // $url = 'http://localhost:5860/api/login';
            $ch = curl_init($url);

                $jsonData = array(
                    'API_KEY'=>'surver_$MGsecretkey$Surver$NodeJS&ApiCerberus',
                    'id_empleado' => 1,
                    'rol' =>  'KOSTEN'
                ); 
           
            $jsonDataEncoded = json_encode($jsonData);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5); 
            $result = curl_exec($ch); 
            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);  
            if ( $status !== 201 && $status !== 200 ) { 
                return  ("Error: call to URL $url failed with status $status, response $result, curl_error " . curl_error($ch) . ", curl_errno " . curl_errno($ch));
            }
            curl_close($ch);
            return  json_decode($result);
        } catch (\Throwable $th) {
            echo $th;
            return false;
        }   
    }
}

ModeloTotalGastos::inicializacion();


?>