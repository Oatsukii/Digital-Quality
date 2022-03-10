<?php

class ModeloWebServiceADempiere {

  public static function ordenCompraADM($datos){

      $data = json_encode($datos->datos);
      $array = json_decode($data, true);

      $dataw = array();
      $dataw = (array) $datos->datos;

      //var_dump($dataw);
      //echo($dataw["id_dev_orden"]);

      $IdOrden = null;

      $AD_Client_ID = $dataw["ws_client"];
      $AD_Org_ID = $dataw["ad_org_id"];
      $C_BPartner_ID = $dataw["c_bpartner_id"];
      $M_Warehouse_ID = $dataw["m_warehouse_id"];
      $IsSOTrx = 'N';
      $C_ConversionType_ID = 114;
      $C_DocTypeTarget_ID = $dataw["c_doctype_id"];
      $Description = 'Orden Generada Automáticamente DevTI';

      $WS_URL = $dataw["ws_url"];
      $WS_User = $dataw["ws_user"];
      $WS_Password = $dataw["ws_password"];
      $WS_Lang = $dataw["ws_lang"];
      $WS_ClientID = $dataw["ws_client"];
      $WS_RoleID = $dataw["ws_role"];
      $WS_Stage = 0;


      // foreach ($array['datos'] as $key => $value) {
      //     echo "$key => $value", PHP_EOL;
      //     //echo $ws['id_dev_orden'];
      //     //echo $ws->ws_client;
      //     //echo $key->ws_client; // Esto devuelve las variables por separado
      //     //echo $value;
      // }


            $XML = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:adin="http://3e.pl/ADInterface">
            <soapenv:Header/>
            <soapenv:Body>
               <adin:createData>
                  <adin:ModelCRUDRequest>
                     <adin:ModelCRUD>
                        <adin:serviceType>RF_Create_C_Order</adin:serviceType>
                        <adin:TableName>C_Order</adin:TableName>
                        <adin:RecordID>0</adin:RecordID>
                        <adin:Action>Create</adin:Action>
                        <adin:DataRow>
                           <adin:field column="AD_Client_ID" >
                              <adin:val>'.$WS_ClientID.'</adin:val>
                           </adin:field>
                            <adin:field column="AD_Org_ID" >
                              <adin:val>'.$AD_Org_ID.'</adin:val>
                           </adin:field>                 
                            <adin:field column="C_BPartner_ID" >
                              <adin:val>'.$C_BPartner_ID.'</adin:val>
                           </adin:field>                          
                            <adin:field column="M_Warehouse_ID" >
                              <adin:val>'.$M_Warehouse_ID.'</adin:val>
                           </adin:field>
                            <adin:field column="IsSOTrx" >
                              <adin:val>'.$IsSOTrx.'</adin:val>
                           </adin:field> 
                           <adin:field column="C_ConversionType_ID" >
                              <adin:val>'.$C_ConversionType_ID.'</adin:val>
                           </adin:field>
                           <adin:field column="C_DocTypeTarget_ID" >
                              <adin:val>'.$C_DocTypeTarget_ID.'</adin:val>
                           </adin:field>
                           <adin:field column="Description" >
                              <adin:val>'.$Description.'</adin:val>
                           </adin:field>                  	               	               	               	               
                        </adin:DataRow>
                     </adin:ModelCRUD>
                     <adin:ADLoginRequest>
                      <adin:user>'.$WS_User.'</adin:user>
                      <adin:pass>'.$WS_Password.'</adin:pass>
                      <adin:lang>'.$WS_Lang.'</adin:lang>
                      <adin:ClientID>'.$WS_ClientID.'</adin:ClientID>
                      <adin:RoleID>'.$WS_RoleID.'</adin:RoleID>
                      <adin:OrgID>0</adin:OrgID>
                      <adin:WarehouseID>0</adin:WarehouseID>
                      <adin:stage>0</adin:stage>
                     </adin:ADLoginRequest>
                  </adin:ModelCRUDRequest>
               </adin:createData>
            </soapenv:Body>
         </soapenv:Envelope>';


        //$Url = "https://pruebas.refividrio.com.mx:4848/ADInterface/services/ModelADService";
        $Url = $WS_URL;

                            
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $Url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $XML);
        $resultado = curl_exec($ch);
        //echo $resultado ."<br />" ;
        curl_close($ch);
        //echo $ch;
        
        $datoXML = simplexml_load_string($resultado);
        $datoXML->registerXPathNamespace("ns1", "http://3e.pl/ADInterface");
        
        $response = $datoXML->xpath("//ns1:StandardResponse")[0];
        //$dataArray['detalleFraccion'] = (string) $response['RecordID'];
        //echo  $response . "<br>";
        //echo "ID Orden " . $response[0]['RecordID'] . "<br>";

        $IdOrden = (int) $response['RecordID'];

        //echo $IdOrden;

        $output = array('message' => $IdOrden); 

        $OrderLinea = new ModeloWebServiceADempiere;
        $ejecutar = $OrderLinea->C_OrdenLine($IdOrden,$datos);

        return $IdOrden;
    
  }

  public static function C_OrdenLine($IdOrden,$datos){

    $data = array();
    $data = (array) $datos->datos;

    $AD_Client_ID = $data["ws_client"];
    $AD_Org_ID = $data["ad_org_id"];
    $C_BPartner_ID = $data["c_bpartner_id"];
    $M_Warehouse_ID = $data["m_warehouse_id"];
    $IsSOTrx = 'N';
    $C_ConversionType_ID = 114;
    $C_DocTypeTarget_ID = $data["c_doctype_id"];
    $Description = 'Orden Generada Automáticamente DevTI';

    $WS_URL = $data["ws_url"];
    $WS_User = $data["ws_user"];
    $WS_Password = $data["ws_password"];
    $WS_Lang = $data["ws_lang"];
    $WS_ClientID = $data["ws_client"];
    $WS_RoleID = $data["ws_role"];
    $WS_Stage = 0;

    //var_dump($data);
    $vIdOrdenLine = null;
    $vProducto =  null;
    $vM_Product_ID = null;
    $vCantidad = null;



    $Lineas = (array) $data["detallesorden"];
    //$Lineas = $data["detallesorden"];

    //echo $data["detallesorden"];

    $array = json_decode($data["detallesorden"], true);

    foreach ($array as $value) {
      //$cadena = "El nombre de la provincia es: '". $value['name'] ."', y su puntuación es: ". $value['y'] ."},";
      //echo ($value['producto']);
      $vIdOrdenLine = $value['id_dev_orden_lineas'];
      $vProducto =  $value['producto'];
      $vM_Product_ID = $value['m_product_id'];
      $vCantidad = $value['cantidad'];


      // echo $vIdOrdenLine ." ";
      // echo $vProducto." ";
      // echo $vM_Product_ID ." ";
      // echo $vCantidad ."</br> ";


          $XML = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:adin="http://3e.pl/ADInterface">
                  <soapenv:Header/>
                  <soapenv:Body>
                      <adin:createData>
                        <adin:ModelCRUDRequest>
                            <adin:ModelCRUD>
                              <adin:serviceType>RF_Create_C_OrderLine</adin:serviceType>
                              <adin:TableName>C_OrderLine</adin:TableName>
                              <adin:RecordID>0</adin:RecordID>
                              <adin:Action>Create</adin:Action>
                              <adin:DataRow>
                                  <adin:field column="AD_Client_ID" >
                                    <adin:val>'.$AD_Client_ID.'</adin:val>
                                  </adin:field>               
                                  <adin:field column="AD_Org_ID" >
                                    <adin:val>'.$AD_Org_ID.'</adin:val>
                                  </adin:field>
                                  <adin:field column="C_Order_ID" >
                                    <adin:val>'.$IdOrden.'</adin:val>
                                  </adin:field>
                                  <adin:field column="C_BPartner_ID" >
                                    <adin:val>'.$C_BPartner_ID.'</adin:val>
                                  </adin:field>                  
                                  <adin:field column="M_Warehouse_ID" >
                                    <adin:val>'.$M_Warehouse_ID.'</adin:val>
                                  </adin:field>
                                  <adin:field column="M_Product_ID" >
                                    <adin:val>'.$vM_Product_ID.'</adin:val>
                                  </adin:field>                                
                                  <adin:field column="QtyEntered" >
                                    <adin:val>'.$vCantidad.'</adin:val>
                                  </adin:field>
                                  <adin:field column="QtyOrdered" >
                                    <adin:val>'.$vCantidad.'</adin:val>
                                  </adin:field>
                                                    
                              </adin:DataRow>
                            </adin:ModelCRUD>
                            <adin:ADLoginRequest>
                            <adin:user>'.$WS_User.'</adin:user>
                            <adin:pass>'.$WS_Password.'</adin:pass>
                            <adin:lang>'.$WS_Lang.'</adin:lang>
                            <adin:ClientID>'.$WS_ClientID.'</adin:ClientID>
                            <adin:RoleID>'.$WS_RoleID.'</adin:RoleID>
                            <adin:OrgID>0</adin:OrgID>
                            <adin:WarehouseID>0</adin:WarehouseID>
                            <adin:stage>0</adin:stage>
                            </adin:ADLoginRequest>
                        </adin:ModelCRUDRequest>
                      </adin:createData>
                  </soapenv:Body>
                </soapenv:Envelope>';


      //$Url = "https://pruebas.refividrio.com.mx:4848/ADInterface/services/ModelADService";
      $Url = $WS_URL;

                          
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $Url);
      curl_setopt($ch, CURLOPT_VERBOSE, 1);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
      curl_setopt($ch, CURLOPT_POSTFIELDS, $XML);
      $resultado = curl_exec($ch);
      //echo $resultado ."<br />" ;
      curl_close($ch);
      //echo $ch;
      
      $datoXML = simplexml_load_string($resultado);
      $datoXML->registerXPathNamespace("ns1", "http://3e.pl/ADInterface");
      
      $response = $datoXML->xpath("//ns1:StandardResponse")[0];
      //$dataArray['detalleFraccion'] = (string) $response['RecordID'];
      //echo "ID Orden Line " . $response['RecordID'] . "<br>";


   }


    // foreach ($data->detallesorden as $valor) {
    //   //echo "$key => $value", PHP_EOL;
    //   var_dump($valor);
    //   //echo $ws['id_dev_orden'];
    //   //echo $ws->ws_client;
    //   //echo $key->ws_client; // Esto devuelve las variables por separado
    //   //echo $value;
    //  }



      // foreach ($array['datos'] as $key => $value) {
      //     echo "$key => $value", PHP_EOL;
      //     //echo $ws['id_dev_orden'];
      //     //echo $ws->ws_client;
      //     //echo $key->ws_client; // Esto devuelve las variables por separado
      //     //echo $value;
      // }

  }


      public function LMX_Document($datos){

        $datosJSON = json_encode($datos,JSON_FORCE_OBJECT);
        $ws_datos = json_decode($datosJSON);

        var_dump( $datosJSON);

        foreach($ws_datos as $key){
          //var_dump($key);
          //print_r($key);
          //var_dump($key->CFDIString);
        
        

          $XML = '
          <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:adin="http://3e.pl/ADInterface">
          <soapenv:Header/>
          <soapenv:Body>
            <adin:createData>
                <adin:ModelCRUDRequest>
                  <adin:ModelCRUD>
                      <adin:serviceType>RF_LMX_Document</adin:serviceType>
                      <adin:TableName>LMX_Document</adin:TableName>
                      <adin:RecordID>0</adin:RecordID>
                      <adin:Action>Create</adin:Action>
                      <adin:DataRow>
                            <adin:field column="AD_Client_ID">
                            <adin:val>1000000</adin:val>
                        </adin:field>
                        <adin:field column="AD_Org_ID">
                            <adin:val>0</adin:val>
                        </adin:field>
                        <adin:field column="AD_Table_ID">
                            <adin:val>318</adin:val>
                        </adin:field>
                        <adin:field column="CFDISATCertificate">
                          <adin:val>'.$key->CFDISATCertificate.'</adin:val>
                        </adin:field>
                        <adin:field column="CFDISATSeal">
                          <adin:val>'.$key->TaxID.'</adin:val>
                        </adin:field>
                        <adin:field column="CFDISeal">
                          <adin:val>'.$key->CFDISeal.'</adin:val>
                        </adin:field>
                        <adin:field column="CFDISealingDate">
                          <adin:val>'.$key->CFDISealingDate.'</adin:val>
                        </adin:field>
                        <adin:field column="CFDIString">
                          <adin:val>'.$key->CFDIString.'</adin:val>
                        </adin:field>
                        <adin:field column="CFDIToken">
                          <adin:val>'.$key->TaxID.'</adin:val>
                        </adin:field>
                        <adin:field column="CFDIUUID">
                          <adin:val>'.$key->CFDIUUID.'</adin:val>
                        </adin:field>
                        <adin:field column="CFDIXML">
                          <adin:val>'.$key->CFDIXML.'</adin:val>
                        </adin:field>	               
                        <adin:field column="Record_ID">
                          <adin:val>'.$key->C_Invoice_ID.'</adin:val>
                        </adin:field>
                        <adin:field column="TaxID">
                          <adin:val>'.$key->TaxID.'</adin:val>
                        </adin:field>
                        <adin:field column="TipoDeComprobante">
                          <adin:val>'.$key->TipoDeComprobante.'</adin:val>
                        </adin:field>	               	                          
                        <adin:field column="TipoRelacion">
                          <adin:val>01</adin:val>
                        </adin:field>	
                        <adin:field column="UsoCFDI">
                          <adin:val>'.$key->UsoCFDI.'</adin:val>
                        </adin:field>    
                      </adin:DataRow>
                  </adin:ModelCRUD>
                  <adin:ADLoginRequest>
                    <adin:user>'.$key->ws_user.'</adin:user>
                    <adin:pass>'.$key->ws_password.'</adin:pass>
                    <adin:lang>'.$key->ws_lang.'</adin:lang>
                    <adin:ClientID>'.$key->ad_client.'</adin:ClientID>
                    <adin:RoleID>'.$key->ws_role.'</adin:RoleID>
                    <adin:OrgID>0</adin:OrgID>
                    <adin:WarehouseID>0</adin:WarehouseID>
                    <adin:stage>0</adin:stage>
                  </adin:ADLoginRequest>
                </adin:ModelCRUDRequest>
            </adin:createData>
          </soapenv:Body>
      </soapenv:Envelope>
          ';



      }



  //     $XML = '
  //     <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:adin="http://3e.pl/ADInterface">
  //     <soapenv:Header/>
  //     <soapenv:Body>
  //        <adin:createData>
  //           <adin:ModelCRUDRequest>
  //              <adin:ModelCRUD>
  //                 <adin:serviceType>RF_LMX_Document</adin:serviceType>
  //                 <adin:TableName>LMX_Document</adin:TableName>
  //                 <adin:RecordID>0</adin:RecordID>
  //                 <adin:Action>Create</adin:Action>
  //                        <adin:DataRow>
  //                              <adin:field column="AD_Client_ID">
  //                              <adin:val>1000000</adin:val>
  //                          </adin:field>
  //                          <adin:field column="AD_Org_ID">
  //                              <adin:val>0</adin:val>
  //                          </adin:field>
  //                          <adin:field column="AD_Table_ID">
  //                              <adin:val>318</adin:val>
  //                          </adin:field>
  //                          <adin:field column="CFDISATCertificate">
  //                            <adin:val>1</adin:val>
  //                          </adin:field>
  //                          <adin:field column="CFDISATSeal">
  //                            <adin:val>2</adin:val>
  //                          </adin:field>
  //                          <adin:field column="CFDISeal">
  //                            <adin:val>3</adin:val>
  //                          </adin:field>
  //                          <adin:field column="CFDISealingDate">
  //                            <adin:val>4</adin:val>
  //                          </adin:field>
  //                          <adin:field column="CFDIString">
  //                            <adin:val>5</adin:val>
  //                          </adin:field>
  //                          <adin:field column="CFDIToken">
  //                            <adin:val>6</adin:val>
  //                          </adin:field>
  //                          <adin:field column="CFDIUUID">
  //                            <adin:val>7</adin:val>
  //                          </adin:field>
  //                          <adin:field column="CFDIXML">
  //                            <adin:val>8</adin:val>
  //                          </adin:field>	               
  //                          <adin:field column="Record_ID">
  //                            <adin:val>1160254</adin:val>
  //                          </adin:field>
  //                          <adin:field column="TaxID">
  //                            <adin:val>10</adin:val>
  //                          </adin:field>
  //                          <adin:field column="TipoDeComprobante">
  //                            <adin:val>E</adin:val>
  //                          </adin:field>	               	                          
  //                          <adin:field column="TipoRelacion">
  //                            <adin:val>01</adin:val>
  //                          </adin:field>	
  //                          <adin:field column="UsoCFDI">
  //                            <adin:val>G02</adin:val>
  //                          </adin:field>    
  //                        </adin:DataRow>
  //              </adin:ModelCRUD>
  //              <adin:ADLoginRequest>
  //               <adin:user>sistemas.refividrio</adin:user>
  //               <adin:pass>DevTI-Web_Service#21.</adin:pass>
  //               <adin:lang>192</adin:lang>
  //               <adin:ClientID>1000000</adin:ClientID>
  //               <adin:RoleID>1000016</adin:RoleID>
  //               <adin:OrgID>0</adin:OrgID>
  //               <adin:WarehouseID>0</adin:WarehouseID>
  //               <adin:stage>0</adin:stage>
  //              </adin:ADLoginRequest>
  //           </adin:ModelCRUDRequest>
  //        </adin:createData>
  //     </soapenv:Body>
  //  </soapenv:Envelope>
  //     ';


 
        $sUrl = "https://pruebas.refividrio.com.mx:4848/ADInterface/services/ModelADService";
                    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $sUrl);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $XML);
        $resultGetRows3 = curl_exec($ch);
        echo $resultGetRows3 ."<br />" ;
        curl_close($ch);
        echo $ch;
        
        
        $xml3 = simplexml_load_string($resultGetRows3);
        $xml3->registerXPathNamespace("ns1", "http://3e.pl/ADInterface");
        
        $response3 = $xml3->xpath("//ns1:StandardResponse")[0];
        //$dataArray['detalleFraccion'] = (string) $response['RecordID'];
        echo "ID Costo " . $response3['RecordID'] . "<br>";

      

    }


}

?>