<?php

require "../lib/phpclient/autoload.php"; //local

use Jaspersoft\Client\Client; //Local
use Jaspersoft\Exception\RESTRequestException;

class ModeloJasperServer{

    public static $HOST;
    public static $USER;
    public static $PASSWORD;

    public static function init(){
        
        self::$HOST = "http://64.227.19.26:51541/jasperserver";;
        self::$USER = "DesarrolloAdmin";
        self::$PASSWORD = "Dev_JasperSoft#20";
    }

    public static function informeProduccionv2M($datos)
	{
        try {

            $tipo = $datos->tipo;
            $almacen =  (isset($datos->almacen)?$datos->almacen:'0');
            $producto =  (isset($datos->producto)?$datos->producto:'');

            $params = array(
                    'almacen' => $almacen,
                    'producto' => $producto
                );

            $c = new Client(self::$HOST,self::$USER,self::$PASSWORD);
            $c->setRequestTimeout(600);
            $report = $c->reportService()->runReport('/reports/DevTI/CofresAProducirv2',  $tipo, null, null, $params);

            header('Access-Control-Allow-Origin: *');
            header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
            header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');             
            // header('Content-Type: application/pdf');
            // header('Content-Disposition: attachment; filename=Informe.pdf');

            return $report;

            } catch (Throwable $th) {

                return $th;
            }
	}

	public static function informeExistenciaM($datos){

		try {

            $almacen =  (isset($datos->almacen)?$datos->almacen:'0');
            $producto =  (isset($datos->producto)?$datos->producto:'');

            $params = array(
                    'almacen' => $almacen,
                    'producto' => $producto
                );

            //$c = new Client(ModeloJasperServer::HOST,ModeloJasperServer::USER,ModeloJasperServer::PASSWORD);
            $c = new Client(self::$HOST,self::$USER,self::$PASSWORD);
            $report = $c->reportService()->runReport('/reports/DevTI/Existencias_CE', 'pdf', null, null, $params);

            header('Access-Control-Allow-Origin: *');
            header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
            header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE'); 
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename=Informe.pdf');

            return $report;
			
        } catch (\Throwable $th) {

            return $th;

        }
      

        }

        public static function informeExcelExitenciaM($datos)
        {
            try {
    
                $almacen =  (isset($datos->almacen)?$datos->almacen:'0');
                $producto =  (isset($datos->producto)?$datos->producto:'');
    
                $params = array(
                        'almacen' => $almacen,
                        'producto' => $producto
                    );
    
                //$c = new Client(ModeloJasperServer::HOST,ModeloJasperServer::USER,ModeloJasperServer::PASSWORD);
                $c = new Client(self::$HOST,self::$USER,self::$PASSWORD);
                $report = $c->reportService()->runReport('/reports/DevTI/Existencias_CE', 'xls', null, null, $params);
                
                 //header('Content-Type: application/xml');
                header('Access-Control-Allow-Origin: *');
                header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
                header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');                 
                header('Content-Disposition: attachment; filename=report.xls');
    
                return $report;
    
                } catch (Throwable $th) {
    
                    return $th;
                }   
    
        }



        public static function informeExistenciaMv2($datos){

            try {
    
                //$almacen =  (isset($datos->almacen)?$datos->almacen:'0');
                $producto =  (isset($datos->producto)?$datos->producto:null);
    
    
                $params = array(
                        'producto' => $producto
                    );
    
                //$c = new Client(ModeloJasperServer::HOST,ModeloJasperServer::USER,ModeloJasperServer::PASSWORD);
                $c = new Client(self::$HOST,self::$USER,self::$PASSWORD);
                $c->setRequestTimeout(300);  
                $report = $c->reportService()->runReport('/reports/DevTI/NuevoExistencias_CE', 'pdf', null, null, $params);

                header('Access-Control-Allow-Origin: *');
                header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
                header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE'); 
                header('Content-Type: application/pdf');
                header('Content-Disposition: attachment; filename=Informe.pdf');
    
                return $report;
                
            } catch (\Throwable $th) {
    
                return $th;
    
            }
          
    
            }

            public static function informeExcelExistenciaMv2($datos)
            {
                try {
        
                    //$almacen =  (isset($datos->almacen)?$datos->almacen:'0');
                    $producto =  (isset($datos->producto)?$datos->producto:null);
        
                    $params = array(
                            'producto' => $producto
                        );
        
                    //$c = new Client(ModeloJasperServer::HOST,ModeloJasperServer::USER,ModeloJasperServer::PASSWORD);
                    $c = new Client(self::$HOST,self::$USER,self::$PASSWORD);
                    $c->setRequestTimeout(300);
                    $report = $c->reportService()->runReport('/reports/DevTI/NuevoExistencias_CE', 'xls', null, null, $params);
                    
                     //header('Content-Type: application/xml');
                    header('Access-Control-Allow-Origin: *');
                    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
                    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');                     
                    header('Content-Disposition: attachment; filename=report.xls');
        
                    return $report;
        
                    } catch (Throwable $th) {
        
                        return $th;
                    }   
        
            }            


            public static function generarFirmaUsuariosM($datos)
            {

                try {
                    
                    //$almacen =  (isset($datos->almacen)?$datos->almacen:'0');
                    //$producto =  (isset($datos->producto)?$datos->producto:null);
                    $pEmpleado = (isset($datos->id)?$datos->id:0);
                    $archivo =  $pEmpleado.".pdf";
        
                    $params = array(
                            'vIdEmpleado' => $pEmpleado
                        );
        
                    //$c = new Client(ModeloJasperServer::HOST,ModeloJasperServer::USER,ModeloJasperServer::PASSWORD);
                    //$c->setRequestTimeout(300);  
                    $c = new Client(self::$HOST,self::$USER,self::$PASSWORD);
                    $report = $c->reportService()->runReport('/reports/Firma/Dev_Firma', 'pdf', null, null, $params);
        
                    header('Access-Control-Allow-Origin: *');
                    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
                    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
                    header('Content-Type: application/pdf');

                    $exist = file_exists($archivo);
                    if ($exist)
                    {
                        $borrado = unlink($archivo);
                        if ($borrado == True)
                        {
                            echo "Se borro exitosamente el pdf";
                        }
                    }else{

                        $directorio = "../PDF/";
                        // chmod( $archivo , 0777 );
                        // chmod( $directorio , 0777 );
                        // chmod( $report , 0777 );

                        file_put_contents($directorio . ($archivo),$report);
                    }


                    return $report;
                    
                } catch (\Throwable $th) {
        
                    return $th;
        
                }
              
        
            }


            public static function informeZBM($datos){

                try {
        
                    //$almacen =  (isset($datos->almacen)?$datos->almacen:'0');
                    // $producto =  (isset($datos->producto)?$datos->producto:null);
        
        
                    // $params = array(
                    //         'producto' => $producto
                    //     );
        
                    //$c = new Client(ModeloJasperServer::HOST,ModeloJasperServer::USER,ModeloJasperServer::PASSWORD);
                    $c = new Client(self::$HOST,self::$USER,self::$PASSWORD);
                    $c->setRequestTimeout(300);  
                    $report = $c->reportService()->runReport('/reports/DevTI/Dev_ZonaBajio', 'pdf', null, null, null);
    
                    header('Access-Control-Allow-Origin: *');
                    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
                    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE'); 
                    header('Content-Type: application/pdf');
                    header('Content-Disposition: attachment; filename=Informe.pdf');
        
                    return $report;
                    
                } catch (\Throwable $th) {
        
                    return $th;
        
                }
              
        
                }


                public static function informeCompraM($datos){

                    //print_r($datos);

                    try {

                        $emp =  (isset($datos->empresa)?$datos->empresa:'');
                        $soc =  (isset($datos->proveedor)?$datos->proveedor:'');
                        $alm1 =  (isset($datos->almacen1)?$datos->almacen1:'');
                        $alm2 =  (isset($datos->almacen2)?$datos->almacen2:'');
                        $producto =  (isset($datos->producto)?$datos->producto:null);

                        $params = array(
                            'Empresa' => $emp
                            ,'Proveedor' => $soc
                            ,'Almacen_maximo' => $alm1
                            ,'Almacen_Existencia_Ordenado' => $alm2
                            ,'Codigo' => $producto
                            );
            
                        //$c = new Client(ModeloJasperServer::HOST,ModeloJasperServer::USER,ModeloJasperServer::PASSWORD);
                        $c = new Client(self::$HOST,self::$USER,self::$PASSWORD);
                        $c->setRequestTimeout(300);  
                        $report = $c->reportService()->runReport('/reports/DevTI/CE_OrdenCompra', 'pdf', null, null, $params);
        
                        header('Access-Control-Allow-Origin: *');
                        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
                        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE'); 
                        header('Content-Type: application/pdf');
                        header('Content-Disposition: attachment; filename=Informe.pdf');
            
                        return $report;
                        
                    } catch (\Throwable $th) {
            
                        return $th;
            
                    }
                  
            
                    }

    public static function informeUSAM($datos)
    {
        try {

            $tipo = $datos->tipo;
            $producto =  (isset($datos->producto)?$datos->producto:'');

            $params = array(
                    'producto' => $producto
                );

            $c = new Client(self::$HOST,self::$USER,self::$PASSWORD);
            $c->setRequestTimeout(600);
            $report = $c->reportService()->runReport('/reports/DevTI/CE_InformeUSA',  $tipo, null, null, $params);

            header('Access-Control-Allow-Origin: *');
            header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
            header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

            return $report;

            } catch (Throwable $th) {

                return $th;
            }
    }



}

ModeloJasperServer::init();
