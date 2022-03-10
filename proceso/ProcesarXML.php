<?php
//include("../db/ConexionDB.php");
//include("../generales/Seguridad.php");

class Procesar_XML
{

    private $directorio = '../XML/';
    private $arc = null;

    public static function obtenerComprobante($datos)
    {
        $archivoXML = (isset($datos->archivo)?$datos->archivo:0);

        // COMPROBANTE
        $lugar_expedicion = null;
        $metodo_pago = null;
        $tipo_comprobante = null;
        $total = null;
        $tipo_cambio = null;
        $moneda = null;
        $descuento = null;
        $subtotal = null;
        $condicciones_pago = null;
        $certificado = null;
        $no_certificado = null;
        $forma_pago = null;
        $sello = null;
        $fecha_xml = null;
        $folio = null;
        $serie = null;
        $version = null;
        $archivo = null;

        //EMISOR
        $regimen_fiscal = null;
        $nombre_emisor = null;
        $rfc_emisor = null;

        //RECEPTOR
        $nombre_receptor = null;
        $rfc_receptor = null;
        $uso_cfdi= null;


        //TIMBRE FISCAL DIGITAL TimbreFiscalDigital
        $version_xml = null;
        $sello_sat = null;
        $no_certificado_sat = null;
        $sello_cfd = null;
        $rfc_prov_certif = null;
        $fecha_timbrado = null;
        $uuid = null;


        //CONCEPTOS
        $concepto_importe = null;
        $concepto_valor_unitario = null;
        $concepto_descripcion = null;
        $concepto_unidad = null;
        $concepto_clave_unidad = null;
        $concepto_cantidad = null;
        $concepto_clave_prod_serv = null;
        $concepto_descuento = null;
        $concepto_no_identificacion = null;

        //TRASLADO
        $traslado_importe = null;
        $traslado_tasa_cuota = null;
        $traslado_tipo_factor = null;
        $traslado_impuesto = null;
        $traslado_base = null;



        //ARCHIVO XML UBICACION 
        $directorio = "../XML/";
        $ruta = $directorio . $archivoXML;

        $xml = simplexml_load_file($ruta);
        $ns = $xml->getNamespaces(true);
        $xml->registerXPathNamespace('c', $ns['cfdi']);
        $xml->registerXPathNamespace('t', $ns['tfd']);

        try {

            //EMPIEZO A LEER LA INFORMACION DEL CFDI E IMPRIMIRLA COMPROBANTE
            foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante){

                $lugar_expedicion = $cfdiComprobante['LugarExpedicion'];
                $metodo_pago = $cfdiComprobante['MetodoPago'];
                $tipo_comprobante = $cfdiComprobante['TipoDeComprobante'];
                $total = $cfdiComprobante['Total'];
                $tipo_cambio = $cfdiComprobante['TipoCambio'];
                $moneda = $cfdiComprobante['Moneda'];
                $descuento = $cfdiComprobante['Descuento'];
                $subtotal = $cfdiComprobante['SubTotal'];
                $condicciones_pago = $cfdiComprobante['CondicionesDePago'];
                $certificado =$cfdiComprobante['Certificado'];
                $no_certificado = $cfdiComprobante['NoCertificado'];
                $forma_pago = $cfdiComprobante['FormaDePago'];
                $sello = $cfdiComprobante['Sello'];
                $fecha_xml = $cfdiComprobante['Fecha'];
                $folio = $cfdiComprobante['Folio'];
                $serie = $cfdiComprobante['Serie'];
                $version = $cfdiComprobante['Version'];
                $archivo = $archivoXML;
                
            }


            //EMPIEZO A LEER LA INFORMACION DEL CFDI E IMPRIMIRLA EMISOR
            foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Emisor') as $Emisor){ 

                $regimen_fiscal = $Emisor['RegimenFiscal'];
                $nombre_emisor = $Emisor['Nombre'];
                $rfc_emisor = $Emisor['Rfc'];

             }


            //EMPIEZO A LEER LA INFORMACION DEL CFDI E IMPRIMIRLA RECEPTOR
            foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor){ 

                $nombre_receptor = $Receptor['Nombre'];;
                $rfc_receptor = $Receptor['Rfc'];;
                $uso_cfdi= $Receptor['UsoCFDI'];;

             }          
             

            //EMPIEZO A LEER LA INFORMACION DEL CFDI E IMPRIMIRLA TIMBRE FISCAL
            foreach ($xml->xpath('//t:TimbreFiscalDigital') as $tfd) {
                
                $version_xml = $tfd['Version'];
                $sello_sat = $tfd['SelloSAT'];
                $no_certificado_sat = $tfd['NoCertificadoSAT'];
                $sello_cfd = $tfd['SelloCFD'];
                $rfc_prov_certif =$tfd['RfcProvCertif'];
                $fecha_timbrado = $tfd['FechaTimbrado'];
                $uuid = $tfd['UUID'];
  
            }


            //EMPIEZO A LEER LA INFORMACION DEL CFDI E IMPRIMIRLA CONCEPTO
            $dataConcept = array(); 
            $contador = 0;

            foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto') as $Concepto){ 

                // echo "<br />"; 
                // echo $concepto_unidad; 
                // echo "<br />"; 
                // echo $concepto_importe; 
                // echo "<br />"; 
                // echo $concepto_cantidad; 
                // echo "<br />"; 
                // echo $Concepto['Descripcion']; 
                // echo "<br />"; 
                // echo $Concepto['ValorUnitario']; 
                // echo "<br />";   
                // echo "<br />"; 

                // $concepto_importe = $Concepto['Importe'];
                // $concepto_valor_unitario = $Concepto['ValorUnitario'];
                // $concepto_descripcion = $Concepto['Descripcion'];
                // $concepto_unidad = $Concepto['Unidad'];
                // $concepto_clave_unidad = $Concepto['ClaveUnidad'];
                // $concepto_cantidad = $Concepto['Cantidad'];
                // $concepto_clave_prod_serv = $Concepto['ClaveProdServ'];
                // $concepto_descuento = $Concepto['Descuento'];
                // $concepto_no_identificacion = $Concepto['NoIdentificacion'];

                $dataConcept[$contador] = array(
                    "concepto_importe" =>  $Concepto['Importe'],
                    "concepto_valor_unitario" => $Concepto['ValorUnitario'],
                    "concepto_descripcion" => $Concepto['Descripcion'],
                    "concepto_unidad" => $Concepto['Unidad'],
                    "concepto_clave_unidad" => $Concepto['ClaveUnidad'],
                    "concepto_cantidad" => $Concepto['Cantidad'],
                    "concepto_clave_prod_serv" => $Concepto['ClaveProdServ'],
                    "concepto_descuento" => $Concepto['Descuento'],
                    "concepto_no_identificacion" => $Concepto['NoIdentificacion'],

                    "contador" => $contador
                );

                $contador++;

             } 


            //EMPIEZO A LEER LA INFORMACION DEL CFDI E IMPRIMIRLA TRASLADO
            foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Impuestos//cfdi:Traslados//cfdi:Traslado') as $Traslado){ 

                $traslado_importe = $Traslado['Importe']; ;
                $traslado_tasa_cuota = $Traslado['TasaOCuota']; ;
                $traslado_tipo_factor = $Traslado['TipoFactor']; ;
                $traslado_impuesto = $Traslado['Impuesto']; ;
                $traslado_base = $Traslado['Base']; ;
        
             } 

             $array = array(
                "lugar_expedicion" =>  $lugar_expedicion,
                "metodo_pago" => $metodo_pago,
                "tipo_comprobante" => $tipo_comprobante,
                "total" => $total,
                "tipo_cambio" => $tipo_cambio,
                "moneda" => $moneda,
                "descuento" => $descuento,
                "subtotal" => $subtotal,
                "condicciones_pago" => $condicciones_pago,
                "certificado" =>  $certificado,
                "no_certificado" =>  $no_certificado,
                "forma_pago" =>  $forma_pago,
                "sello" =>  $sello,
                "fecha_xml" =>  $fecha_xml,
                "folio" =>  $folio,
                "serie" => $serie,
                "version" => $version,
                "archivo" => $archivo,

                "regimen_fiscal" => $regimen_fiscal,
                "nombre_emisor" => $nombre_emisor,
                "rfc_emisor" => $rfc_emisor,

                "nombre_receptor" => $nombre_receptor,
                "rfc_receptor" => $rfc_receptor,
                "uso_cfdi" => $uso_cfdi,                        

                "version_xml" => $version_xml,
                "sello_sat" => $sello_sat,
                "no_certificado_sat" => $no_certificado_sat,
                "sello_cfd" => $sello_cfd,
                "rfc_prov_certif" => $rfc_prov_certif,
                "fecha_timbrado" => $fecha_timbrado,
                "uuid" => $uuid,

                );


                // $arrayConceptos= array(
                //     "concepto_importe" => $concepto_importe,
                //     "concepto_valor_unitario" => $concepto_valor_unitario,
                //     "concepto_descripcion" => $concepto_descripcion,
                //     "concepto_unidad" => $concepto_unidad,
                //     "concepto_clave_unidad" => $concepto_clave_unidad,
                //     "concepto_cantidad" => $concepto_cantidad,
                //     "concepto_clave_prod_serv" => $concepto_clave_prod_serv,
                //     "concepto_descuento" => $concepto_descuento,
                //     "concepto_no_identificacion" => $concepto_no_identificacion,
                //     );


                $arrayConceptos= $dataConcept;
    

                $arrayTraslados = array(
                    "traslado_importe" => $traslado_importe,
                    "traslado_tasa_cuota" => $traslado_tasa_cuota,
                    "traslado_tipo_factor" => $traslado_tipo_factor,
                    "traslado_impuesto" => $traslado_impuesto,
                    "traslado_base" => $traslado_base,
                    );

                $listado = array($array, $arrayConceptos, $arrayTraslados);

                return $listado;
                    
            } catch (Exception $exc) {
    
                return $exc;
            }

    }


}
?>